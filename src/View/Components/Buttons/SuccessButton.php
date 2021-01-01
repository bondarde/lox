<?php

namespace BondarDe\LaravelToolbox\View\Components\Buttons;

class SuccessButton extends DefaultButton
{
    function makeAttributes(): array
    {
        return [
            'class' => 'inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest focus:outline-none disabled:opacity-25 transition ease-in-out duration-150 bg-green-700 focus:ring-green-200 focus:border-green-900 hover:bg-green-600 active:bg-green-800',
        ];
    }
}
