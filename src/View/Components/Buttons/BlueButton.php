<?php

namespace BondarDe\LaravelToolbox\View\Components\Buttons;

class BlueButton extends DefaultButton
{
    function makeAttributes(): array
    {
        return [
            'class' => 'inline-flex items-center justify-center transition ease-in-out duration-150 w-full md:w-auto'
                . ' px-4 py-2'
                . ' border border-transparent rounded-md'
                . ' text-white'
                . ' bg-blue-800'
                . ' hover:bg-blue-600'
                . ' active:bg-blue-800'
                . ' focus:outline-none focus:ring focus:ring-blue-200 focus:border-blue-900'
                . ' disabled:opacity-25'
                . '',
        ];
    }
}
