<?php

/** @noinspection PhpUnhandledExceptionInspection */

use function Deployer\after;
use function Deployer\get;
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

set('git_revision', function () {
    return runLocally('git rev-parse --verify --short=12 HEAD');
});

set('git_tag', function () {
    return runLocally('git describe --exact-match --tags $(git log -n1 --pretty=\'%H\')');
});

set('package_name', function () {
    $composerJsonPath = parse('{{root_dir}}/composer.json');
    $composerJson = json_decode(file_get_contents($composerJsonPath));

    return $composerJson->name;
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
    runLocally('cp .env.{{stage}} {{build_path}}/.env');
    runLocally('rsync -r artisan {{build_path}}');
    runLocally('rsync -r app {{build_path}}');
    runLocally('rsync -r bootstrap {{build_path}}');
    runLocally('rsync -r config {{build_path}}');
    runLocally('rsync -r database {{build_path}}');
    runLocally('rsync -r public {{build_path}}');
    runLocally('rsync -r lang {{build_path}}');
    runLocally('rsync -r resources/views {{build_path}}/resources');
    runLocally('rsync -r routes {{build_path}}');
    runLocally('rsync --include=.php --exclude=.git --recursive --copy-links vendor {{build_path}}');
    runLocally('rsync -r composer.json {{build_path}}');

    // Store Git revision as app version
    runLocally('echo "APP_VERSION=\"{{git_revision}}\"" >> {{build_path}}/.env');

    // Store Sentry release
    runLocally('echo "SENTRY_RELEASE=\"{{package_name}}@{{git_tag}}:{{git_revision}}\"" >> {{build_path}}/.env');
})->once();


task('build:vite', function () {
    writeln('Building JS & CSS with Vite…');
    $buildResult = runLocally('npm run build');
    if (output()->isDebug()) {
        writeln($buildResult);
    }
    writeln('<fg=green>✔ Vite done.</>');

    // Retrieve names of generated files
    $manifestPath = parse('{{vite_build_path}}/manifest.json');
    $manifest = json_decode(file_get_contents($manifestPath));

    $jsFile = $manifest->{'resources/js/app.js'}->file;
    $cssFile = $manifest->{'resources/scss/app.scss'}->file;

    set('vite_js_file', $jsFile);
    set('vite_css_file', $cssFile);

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


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//// Deployment tasks //////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$disabledFn = fn() => writeln('<fg=gray>Task disabled</>');
task('deploy:update_code', $disabledFn);
task('deploy:vendors', $disabledFn);


task('deploy:clear_opcache', function () {
});


task('deploy:upload', function () {
    writeln('Uploading {{build_path}} → {{release_path}}');

    upload('{{build_path}}/', '{{release_path}}/');
});
