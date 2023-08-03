<?php

namespace BondarDe\Lox\Data\Aws;

use Aws\Result;
use BondarDe\Lox\Exceptions\IllegalStateException;
use Carbon\Carbon;

class StsCredentials
{
    public function __construct(
        public string $accessKeyId,
        public string $secretAccessKey,
        public string $sessionToken,
        public Carbon $expiresAt,
    )
    {
    }

    public static function fromAwsResult(Result $result): self
    {
        $credentials = $result->get('Credentials');

        return new self(
            $credentials['AccessKeyId'],
            $credentials['SecretAccessKey'],
            $credentials['SessionToken'],
            Carbon::parse($credentials['Expiration']),
        );
    }
}
