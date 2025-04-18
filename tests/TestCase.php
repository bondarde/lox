<?php

namespace Tests;

use BezhanSalleh\FilamentShield\FilamentShieldServiceProvider;
use BondarDe\Lox\LoxServiceProvider;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase();
    }

    /**
     * Get package providers.
     *
     * @param  Application  $app
     * @return array<int, class-string<ServiceProvider>>
     */
    protected function getPackageProviders($app): array
    {
        return [
            LoxServiceProvider::class,
            LivewireServiceProvider::class,
            FilamentShieldServiceProvider::class,
        ];
    }

    protected function setUpDatabase(): void
    {
        $migrationFiles = [
            __DIR__ . '/../database/migrations/001_create_cms_pages_table.php',
            __DIR__ . '/../database/migrations/002_create_cms_redirects_table.php',
        ];

        foreach ($migrationFiles as $migrationFile) {
            $migrationClass = require $migrationFile;
            (new $migrationClass())->up();
        }
    }
}
