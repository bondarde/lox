<?php

namespace BondarDe\Lox\View\Components;

use BondarDe\Lox\Constants\DashboardItemColors;
use BondarDe\Lox\Exceptions\IllegalStateException;
use BondarDe\Lox\Support\NumbersFormatter;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DashboardItem extends Component
{
    public string $cssClasses;

    public function __construct(
        public readonly string     $label,
        public readonly string     $href,
        DashboardItemColors|string $colors = DashboardItemColors::Default,
        public readonly bool       $asInteger = false,
        public readonly bool       $asTimestamp = false,
    )
    {
        $this->cssClasses = match (true) {
            is_string($colors) => $colors,
            $colors instanceof DashboardItemColors => $colors->value,
            default => throw new IllegalStateException('Unexpected colors value.'),
        };
    }

    public function renderSlot(string $slot): string
    {
        return match (true) {
            $this->asInteger => NumbersFormatter::format($slot),
            $this->asTimestamp => Carbon::createFromTimestamp($slot)->shortRelativeDiffForHumans(),
            default => $slot,
        };
    }

    public function render(): View
    {
        return view('lox::dashboard-item');
    }
}
