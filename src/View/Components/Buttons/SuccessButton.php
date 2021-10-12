<?php

namespace BondarDe\LaravelToolbox\View\Components\Buttons;

class SuccessButton extends DefaultButton
{
    function makeAttributes(): array
    {
        return [
            'class' => 'inline-flex items-center justify-center transition ease-in-out duration-150 w-full md:w-auto'
                . ' px-4 py-2'
                . ' border border-transparent rounded-md'
                . ' bg-green-700 text-white'
                . ' hover:bg-green-600'
                . ' active:bg-green-800'
                . ' focus:outline-none focus:ring focus:ring-green-100 focus:border-green-900'
                . ' disabled:opacity-25'
                . '',
        ];
    }
}
