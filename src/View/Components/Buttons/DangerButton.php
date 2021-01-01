<?php

namespace BondarDe\LaravelToolbox\View\Components\Buttons;

class DangerButton extends DefaultButton
{
    function makeAttributes(): array
    {
        return [
            'class' => 'inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest focus:outline-none disabled:opacity-25 transition ease-in-out duration-150 bg-red-800 focus:ring-red-200 focus:border-red-900 hover:bg-red-700 active:bg-red-700',
        ];
    }
}
