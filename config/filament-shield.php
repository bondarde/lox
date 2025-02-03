<?php

use BondarDe\Lox\Constants\Acl\Role;

$config = require __DIR__ . '/../vendor/bezhansalleh/filament-shield/config/filament-shield.php';

$config['super_admin']['name'] = Role::SuperAdmin->name;
$config['super_admin']['define_via_gate'] = true;

$config['shield_resource']['navigation_sort'] = 101;
$config['exclude']['pages'] = [];
$config['exclude']['widgets'] = [];

$config['register_role_policy']['enabled'] = false;

$config['entities']['custom_permissions'] = true;

return $config;
