<?php

namespace BondarDe\LaravelToolbox\View\Components\Buttons;

class LightButton extends DefaultButton
{
    function makeAttributes(): array
    {
        return [
            'class' => 'inline-flex items-center px-4 py-2 border border-transparent font-semibold text-sm uppercase tracking-widest rounded-md bg-gray-200 hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:border-gray-400 focus:ring focus:ring-gray-100 disabled:opacity-25 transition ease-in-out duration-150',
        ];
    }
}
