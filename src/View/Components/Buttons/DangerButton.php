<?php

namespace BondarDe\LaravelToolbox\View\Components\Buttons;

class DangerButton extends DefaultButton
{
    function makeAttributes(): array
    {
        return [
            'class' => 'inline-flex items-center justify-center transition ease-in-out duration-150 w-full md:w-auto'
                . ' px-4 py-2'
                . ' border border-transparent rounded-md'
                . ' bg-red-800 text-white'
                . ' hover:bg-red-700'
                . ' active:bg-red-700'
                . ' focus:ring focus:ring-red-200 focus:outline-none focus:border-red-900'
                . ' disabled:opacity-25'
                . '',
        ];
    }
}
