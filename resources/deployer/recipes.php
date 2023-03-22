<?php

/** @noinspection PhpUnhandledExceptionInspection */

use BondarDe\LaravelToolbox\Data\Aws\AwsSecretsLoadConfig;
use BondarDe\LaravelToolbox\Support\AwsSecretsLoader;
use BondarDe\LaravelToolbox\Support\ViteManifestParser;
use Illuminate\Support\Str;
use function Deployer\after;
use function Deployer\artisan;
use function Deployer\ask;
use function Deployer\get;
use function Deployer\invoke;
use function Deployer\output;
use function Deployer\parse;
use function Deployer\runLocally;
use function Deployer\set;
use function Deployer\task;
use function Deployer\upload;
use function Deployer\writeln;

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Config ////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

set('composer_action', 'about');
set('repository', '');
set('allow_anonymous_stats', false);

set('writable_mode', 'chmod');
set('writable_use_sudo', true);
set('writable_recursive', true);
set('writable_chmod_mode', '777');

set('stage', function () {
    return get('labels')['stage'];
});

set('build_path', '{{root_dir}}/.build/{{stage}}');
set('vite_build_path', '{{root_dir}}/.build/.vite');
set('env_file_path', '{{build_path}}/.env');

set('git_revision', function () {
    return runLocally('git rev-parse --verify --short=12 HEAD');
});

set('git_tag', function () {
    return match (get('stage')) {
        'test' => runLocally('git describe --tags --candidates=100 $(git log -n1 --pretty=\'%H\')'),
        default => runLocally('git describe --exact-match --tags $(git log -n1 --pretty=\'%H\')'),
    };
});

set('package_name', function () {
    $composerJsonPath = parse('{{root_dir}}/composer.json');
    $composerJson = json_decode(file_get_contents($composerJsonPath));

    return $composerJson->name;
});

set('opcache_config_filename', '{{ root_dir }}/.build/.opcache-config-{{stage}}');

set('opcache_token', function () {
    $json = runLocally('cat {{ opcache_config_filename }}');

    return json_decode($json)->token;
});
set('opcache_filename', function () {
    $json = runLocally('cat {{ opcache_config_filename }}');

    return json_decode($json)->filename;
});


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Callbacks /////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// If deploy fails, automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Upload codebase after deploy:prepare
after('deploy:prepare', 'deploy:upload');

// Clear OPCache after symlink
after('deploy:symlink', 'deploy:clear_opcache');


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Build tasks ///////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

task('build:laravel', function () {
    writeln('Building <fg=green>{{git_tag}}</> (<fg=green>{{git_revision}}</>) for <fg=red>{{stage}}</> to <fg=blue>{{build_path}}</> …');

    // Prepare build dir
    runLocally('rm -Rf {{build_path}}');
    runLocally('mkdir -p {{build_path}}');

    // Copy Laravel files
    runLocally('cp .env.{{stage}} {{env_file_path}}');
    runLocally('rsync -r artisan {{build_path}}');
    runLocally('rsync -r app {{build_path}}');
    runLocally('rsync -r bootstrap {{build_path}}');
    runLocally('rsync -r config {{build_path}}');
    runLocally('rsync -r database {{build_path}}');
    runLocally('rsync -r public {{build_path}}');
    $langDir = get('root_dir') . '/lang';
    if (is_dir($langDir)) {
        runLocally('rsync -r lang {{build_path}}');
    }
    runLocally('rsync -r resources/views {{build_path}}/resources');
    runLocally('rsync -r routes {{build_path}}');
    runLocally('rsync --include=.php --exclude=.git --recursive --copy-links vendor {{build_path}}');
    runLocally('rsync -r composer.json {{build_path}}');

    // Store Git revision as app version
    runLocally('echo "APP_VERSION=\"{{git_revision}}\"" >> {{env_file_path}}');

    // Store Sentry release
    $packageName = get('package_name');
    $sentryPackageName = str_replace('/', '-', $packageName);
    runLocally('echo "SENTRY_RELEASE=\"' . $sentryPackageName . '@{{git_tag}}:{{git_revision}}\"" >> {{env_file_path}}');
})->once();


task('build:vite', function () {
    $rootDir = get('root_dir');
    require $rootDir . '/vendor/autoload.php';

    writeln('Building JS & CSS with Vite…');
    $buildResult = runLocally('npm run build');
    if (output()->isDebug()) {
        writeln($buildResult);
    }
    writeln('<fg=green>✔ Vite done.</>');

    // Retrieve names of generated files
    $manifestPath = parse('{{vite_build_path}}/manifest.json');
    $manifest = json_decode(file_get_contents($manifestPath));

    $jsSourceFilename = ViteManifestParser::getJavascriptFilePath($rootDir);
    $cssSourceFilename = ViteManifestParser::getStylesheetFilePath($rootDir);

    $jsTargetFile = $manifest->{$jsSourceFilename}->file;
    $cssTargetFile = $manifest->{$cssSourceFilename}->file;

    set('vite_js_file', $jsTargetFile);
    set('vite_css_file', $cssTargetFile);

    // Copy CSS & JS into public dir
    runLocally('mkdir {{build_path}}/public/=\)');
    runLocally('cat {{vite_build_path}}/{{vite_css_file}} > "{{build_path}}/public/=)/app.{{git_revision}}.css"');
    runLocally('cat {{vite_build_path}}/{{vite_js_file}} > "{{build_path}}/public/=)/app.{{git_revision}}.js"');
})->once();


task('build:htaccess_minified_redirects', function () {
    $filename = parse('{{build_path}}/public/.htaccess');
    $gitRevision = get('git_revision');

    $lines = file($filename);
    $replacementsCount = 0;

    foreach ($lines as &$line) {
        switch (trim($line)) {
            case 'RewriteRule ^=\)/app\.[0-9a-f]+\.css$ /blank.txt [NC,L,R=301]':
                $line = str_replace('/blank.txt', '/=)/app.' . $gitRevision . '.css', $line, $count);
                $replacementsCount += $count;
                break;
            case 'RewriteRule ^=\)/app\.[0-9a-f]+\.js$ /blank.txt [NC,L,R=301]':
                $line = str_replace('/blank.txt', '/=)/app.' . $gitRevision . '.js', $line, $count);
                $replacementsCount += $count;
                break;
            default:
        }
    }

    $message = $replacementsCount . ' CSS/JS replacements in .htaccess';

    if (!$replacementsCount) {
        throw new Exception($message);
    }

    writeln('<fg=green>' . $message . '</>');

    file_put_contents($filename, implode('', $lines));
})->once();


task('build:generate_opcache_config', function () {
    $rootDir = get('root_dir');
    require $rootDir . '/vendor/autoload.php';

    $token = Str::uuid();

    $filename = 'opcache-reset-' . Str::uuid() . '.php';
    $config = compact('token', 'filename');

    runLocally('echo \'' . json_encode($config) . '\' > {{ opcache_config_filename }}');
});


task('build:opcache_reset', function () {
    invoke('build:generate_opcache_config');

    $token = get('opcache_token');
    $target = parse('{{build_path}}/public/{{opcache_filename}}');

    $lines = array_map(fn(string $line) => str_replace(
        '$token = die();',
        '$token = \'' . $token . '\';',
        $line,
    ), file(__DIR__ . '/opcache-reset.php'));

    file_put_contents($target, implode('', $lines));
})
    ->desc('Create file for OPCache reset')
    ->once();


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Build tasks ///////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

task('build', [
    'build:laravel',
    'build:vite',
    'build:htaccess_minified_redirects',
    'build:opcache_reset',
])->desc('Main build script');


task('build:update_env_from_aws_secrets', function () {
    $rootDir = get('root_dir');
    require $rootDir . '/vendor/autoload.php';

    $region = get('aws_secrets_region');
    $deviceSerialNumber = get('aws_secrets_device_serial_number');
    $secretId = get('aws_secrets_secret_id');
    $projectPrefix = get('aws_secrets_project_prefix');
    $useCache = get('aws_secrets_use_cache', true);
    $cacheFile = get('aws_secrets_cache_file', '{{root_dir}}/.build/.aws-sts-credentials');

    if (
        !$region
        || !$deviceSerialNumber
        || !$secretId
        || !$projectPrefix
    ) {
        throw new Exception('AWS secrets setup is incomplete.');
    }


    $config = new AwsSecretsLoadConfig(
        $region,
        $deviceSerialNumber,
        $secretId,
        $projectPrefix,
        $useCache,
        $cacheFile,
        fn() => ask('AWS MFA Code:'),
    );

    writeln('Loading AWS secrets…');
    $secrets = AwsSecretsLoader::getSecrets(
        $config,
    );
    writeln('Got <fg=red>' . count($secrets) . ' secrets</>, writing out to <fg=blue>{{ env_file_path }}</>…');

    // append secrets to env file
    foreach ($secrets as $key => $value) {
        runLocally('echo "' . $key . '=\"' . $value . '\"" >> {{ env_file_path }}');
    }
})->once();


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Deployment tasks //////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$disabledFn = fn() => writeln('<fg=gray>Task disabled</>');
task('deploy:update_code', $disabledFn);
task('deploy:vendors', $disabledFn);


task('deploy:clear_opcache', function () {
    $filename = get('opcache_filename');
    $token = get('opcache_token');
    $date = date('Y-m-d');
    $hash = md5($token . $date);

    $host = get('alias');
    if ($host === get('domain_prod')) {
        $host = get('domain_prod_www');
    }

    $authBasic = get('auth_basic');
    if ($authBasic) {
        $host = $authBasic . '@' . $host;
    }

    $protocol = get('protocol', "https");
    $url = "$protocol://$host/$filename?hash=$hash";
    $cmd = "curl -L $url";

    writeln("Clearing OPCache: <fg=blue>$url</> …");
    writeln(runLocally($cmd));
});


task('deploy:upload', function () {
    writeln('Uploading {{build_path}} → {{release_path}}');

    upload('{{build_path}}/', '{{release_path}}/');
});

after('artisan:migrate', artisan('acl:update-roles-and-permission'))
    ->desc('ACL setup');
