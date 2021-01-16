<?php

namespace BondarDe\LaravelToolbox\View\Components\Buttons;

class BlueButton extends DefaultButton
{
    function makeAttributes(): array
    {
        return [
            'class' => 'inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest focus:outline-none disabled:opacity-25 transition ease-in-out duration-150 bg-blue-800 focus:ring focus:ring-blue-200 focus:border-blue-900 hover:bg-blue-600 active:bg-blue-800',
        ];
    }
}
