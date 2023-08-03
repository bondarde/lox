<?php

namespace BondarDe\Lox\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;

class RelativeTimestamp extends Component
{
    public string $label = '—';
    public string $timestamp = '';

    public function __construct(
        ?Model $model,
        string $attr,
        bool $showTimestamp = true,
        string $timestampFormat = 'j. M Y H:i'
    )
    {
        if (!$model || !$model->{$attr}) {
            return;
        }

        $this->label = $model->{$attr}->diffForHumans();

        if ($showTimestamp) {
            $this->timestamp = $model->{$attr}->format($timestampFormat);
        }
    }

    public function render(): View
    {
        return view('lox::relative-timestamp');
    }
}
