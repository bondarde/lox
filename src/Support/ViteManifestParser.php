<?php

namespace BondarDe\Lox\Support;

use BondarDe\Lox\Exceptions\IllegalStateException;
use Illuminate\Support\Str;

class ViteManifestParser
{
    /**
     * @throws IllegalStateException
     */
    public static function getJavascriptFilePath(?string $root = null): string
    {
        return self::getFirstMatchingSourceFile($root, [
            '*.js',
            '*.ts',
        ]);
    }

    /**
     * @throws IllegalStateException
     */
    public static function getStylesheetFilePath(?string $root = null): string
    {
        return self::getFirstMatchingSourceFile($root, [
            '*.css',
            '*.scss',
            '*.sass',
        ]);
    }

    /**
     * @throws IllegalStateException
     */
    private static function getFirstMatchingSourceFile(?string $root, array $patterns): string
    {
        $root = $root ?: base_path();
        $sourceFiles = self::getSourceFiles($root);

        foreach ($sourceFiles as $sourceFile) {
            if (Str::is($patterns, $sourceFile)) {
                return $sourceFile;
            }
        }

        throw new IllegalStateException('No matching source file found.');
    }

    private static function getSourceFiles(string $root): array
    {
        $viteConfigFilePath = $root . DIRECTORY_SEPARATOR . 'vite.config.js';
        $configContent = file_get_contents($viteConfigFilePath);

        preg_match('/outDir:\s[\'"](?<outputDirectory>[^\'"]+)[\'"],/', $configContent, $matches);

        $viteOutputDirectory = $matches['outputDirectory'];

        $viteManifestPath = $root . DIRECTORY_SEPARATOR . $viteOutputDirectory . DIRECTORY_SEPARATOR . 'manifest.json';

        $manifestContent = json_decode(file_get_contents($viteManifestPath), true);

        return array_keys($manifestContent);
    }
}
