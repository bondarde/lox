<?php

/** @noinspection PhpUnhandledExceptionInspection */

use function Deployer\get;
use function Deployer\host;
use function Deployer\set;
use function Deployer\task;

require_once 'vendor/deployer/deployer/recipe/laravel.php';
require_once 'vendor/bondarde/laravel-toolbox/resources/deployer/recipes.php';

date_default_timezone_set('Europe/Berlin');
set('root_dir', __DIR__);


################################################################################
### Project Configuration ######################################################
################################################################################

set('application', 'YOUR PROJECT NAME');
set('domain_prod', 'example.com');
set('domain_prod_www', 'www.example.com');
set('domain_test', 'test.example.com');


host(get('domain_prod'))
    ->set('labels', ['stage' => 'prod'])
    ->set('shared_files', [])
    ->set('deploy_path', '/var/www/{{domain_prod}}');

host(get('domain_test'))
    ->set('labels', ['stage' => 'test'])
    ->set('shared_files', [])
    ->set('deploy_path', '/var/www/{{domain_test}}');


################################################################################
### Tasks ######################################################################
################################################################################


task('build', [
    'build:laravel',
    'build:vite',
    'build:htaccess_minified_redirects',
])->desc('Main build script');
