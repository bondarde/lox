<?php

namespace BondarDe\Lox\View\Components;

use BondarDe\Lox\Support\NumbersFormatter;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FileSize extends Component
{
    public function __construct(
        public readonly int  $bytes,
        private readonly int $decimals = 1,
        public readonly bool $binary = true,
    )
    {
    }

    public function render(): View
    {
        $factor = $this->binary ? 1024 : 1000;

        $thresholdGiga = pow($factor, 3);
        $thresholdMega = pow($factor, 2);

        $decimals = $this->decimals;

        $data = match (true) {
            $this->bytes > $thresholdGiga => [
                'number' => $this->bytes / $thresholdGiga,
                'unit' => $this->binary ? 'GiB' : 'GB',
            ],
            $this->bytes > $thresholdMega => [
                'number' => $this->bytes / $thresholdMega,
                'unit' => $this->binary ? 'MiB' : 'MB',
            ],
            $this->bytes < $factor => [
                'number' => $this->bytes,
                'unit' => 'B',
                'decimals' => 0,
            ],
            default => [
                'number' => $this->bytes / $factor,
                'unit' => $this->binary ? 'KiB' : 'KB',
            ],
        };

        $data['decimals'] ??= $decimals;
        $data['title'] = NumbersFormatter::format($this->bytes) . ' bytes';

        return view('lox::components.file-size', $data);
    }
}
