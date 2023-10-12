<?php

namespace BondarDe\Lox\Console;

use Composer\InstalledVersions;

class AboutCommandIntegration
{
    public function __invoke(): array
    {
        return [
            'version' => InstalledVersions::getPrettyVersion('bondarde/lox'),
            'ACL config' => config('lox.acl_config') ?? '—',
        ];
    }
}
