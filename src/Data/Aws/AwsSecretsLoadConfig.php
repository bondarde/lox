<?php

namespace BondarDe\Lox\Data\Aws;

use Closure;

class AwsSecretsLoadConfig
{
    public function __construct(
        public readonly string  $awsRegion,
        public readonly string  $mfaDeviceSerialNumber,
        public readonly string  $secretId,
        public readonly string  $projectPrefix,
        public readonly bool    $useCredentialsCache,
        public readonly string  $cacheFile,
        public readonly Closure $mfaCodeProvider,
    )
    {
    }
}
