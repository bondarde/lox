<?php

namespace BondarDe\LaravelToolbox\Support;

use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Support\Collection;
use Laravel\Fortify\RecoveryCode;

class OneTimePasswordUtil
{

    public static function toSvg(string $secretKey, string $userId): string
    {
        $renderer = new ImageRenderer(
            new RendererStyle(200, 4),
            new SvgImageBackEnd
        );

        $appId = config('app.name');
        $label = $appId . ': ' . $userId;

        $params = http_build_query([
            'issuer' => $appId,
            'secret' => $secretKey,
        ]);
        $content = 'otpauth://totp/' . $label . '?' . $params;

        $writer = new Writer($renderer);
        $svg = $writer->writeString($content);

        return trim(substr($svg, strpos($svg, "\n") + 1));
    }

    public static function makeRecoveryCodes(int $count = 8): array
    {
        return Collection::times($count, function () {
            return RecoveryCode::generate();
        })->all();
    }
}
