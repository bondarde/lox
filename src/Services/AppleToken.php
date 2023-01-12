<?php

namespace BondarDe\LaravelToolbox\Services;

use Carbon\CarbonImmutable;
use Firebase\JWT\JWT;

class AppleToken
{
    public function generate(): string
    {
        $now = CarbonImmutable::now();

        $keyId = config('services.apple.key_id');
        $privateKey = config('services.apple.private_key');

        $teamId = config('services.apple.team_id');
        $clientId = config('services.apple.client_id');

        $header = [
            'alg' => 'ES256',
            'kid' => $keyId,
        ];
        $payload = [
            'iss' => $teamId,
            'iat' => $now->getTimestamp(),
            'exp' => $now->addMonths(5)->getTimestamp(),
            'aud' => 'https://appleid.apple.com',
            'sub' => $clientId,
        ];

        return JWT::encode(
            payload: $payload,
            key: $privateKey,
            alg: 'ES256',
            keyId: $keyId,
            head: $header,
        );
    }
}
