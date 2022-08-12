<?php

namespace BondarDe\LaravelToolbox\Data\Aws;

use BondarDe\LaravelToolbox\Exceptions\IllegalStateException;

class AwsSecretsLoadConfig
{
    public function __construct(
        public readonly string  $awsRegion,
        public readonly string  $mfaDeviceSerialNumber,
        public readonly string  $secretId,
        public readonly string  $projectPrefix,
        public readonly bool    $useCredentialsCache,
        public readonly string  $cacheFile,
        public readonly ?string $mfaCode,
    )
    {
        if (!$this->useCredentialsCache && !$this->mfaCode) {
            throw new IllegalStateException('MFA code is required if no cache used.');
        }
    }
}
