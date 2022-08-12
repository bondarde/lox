<?php

namespace BondarDe\LaravelToolbox\Support;

use Aws\SecretsManager\SecretsManagerClient;
use Aws\Sts\StsClient;
use BondarDe\LaravelToolbox\Data\Aws\AwsSecretsLoadConfig;
use BondarDe\LaravelToolbox\Data\Aws\StsCredentials;
use Carbon\Carbon;

class AwsSecretsLoader
{
    public static function getSecrets(
        AwsSecretsLoadConfig $config,
    ): array
    {
        $projectPrefix = $config->projectPrefix;

        $allSecrets = self::loadSecrets(
            $config,
        );

        $prefix = $projectPrefix . '/';
        $prefixLength = strlen($projectPrefix) + 1;

        $secrets = [];

        foreach ($allSecrets as $key => $value) {
            if (substr($key, 0, $prefixLength) !== $prefix) {
                continue;
            }

            $keyWithoutPrefix = substr($key, $prefixLength);
            $secrets[$keyWithoutPrefix] = $value;
        }

        return $secrets;
    }

    private static function loadStsCredentials(
        AwsSecretsLoadConfig $config,
    ): StsCredentials
    {
        $awsRegion = $config->awsRegion;
        $mfaDeviceSerialNumber = $config->mfaDeviceSerialNumber;
        $useCredentialsCache = $config->useCredentialsCache;

        $mfaCodeProvider = $config->mfaCodeProvider;
        $mfaCode = $mfaCodeProvider();

        $stsClient = new StsClient([
            'version' => '2011-06-15',
            'region' => $awsRegion,
        ]);
        $res = $stsClient->getSessionToken([
            'SerialNumber' => $mfaDeviceSerialNumber,
            'TokenCode' => $mfaCode,
            'DurationSeconds' => $useCredentialsCache ? 129600 : 900,
        ]);

        return StsCredentials::fromAwsResult($res);
    }

    private static function loadSecrets(
        AwsSecretsLoadConfig $config,
    )
    {
        $awsRegion = $config->awsRegion;
        $secretId = $config->secretId;
        $cacheFile = $config->cacheFile;

        if ($config->useCredentialsCache) {
            // load from cache

            $serializedValue = file_get_contents($cacheFile);
            $stsCredentials = unserialize($serializedValue);

            if ($stsCredentials->expiresAt->isBefore(Carbon::now())) {
                // update credentials if expired

                $stsCredentials = self::loadStsCredentials(
                    $config,
                );

                $serializedValue = serialize($stsCredentials);
                file_put_contents($cacheFile, $serializedValue);
            }
        } else {
            // request from AWS
            $stsCredentials = self::loadStsCredentials(
                $config,
            );
        }

        $client = new SecretsManagerClient([
            'version' => '2017-10-17',
            'region' => $awsRegion,
            'credentials' => [
                'key' => $stsCredentials->accessKeyId,
                'secret' => $stsCredentials->secretAccessKey,
                'token' => $stsCredentials->sessionToken,
            ],
        ]);

        $result = $client->getSecretValue([
            'SecretId' => $secretId,
        ]);

        $secretRawValue = $result['SecretString'] ?? base64_decode($result['SecretBinary']);

        return json_decode($secretRawValue, true);
    }
}
