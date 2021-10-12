<?php

namespace BondarDe\LaravelToolbox\View\Components\Buttons;

class LightButton extends DefaultButton
{
    function makeAttributes(): array
    {
        return [
            'class' => 'inline-flex items-center justify-center transition ease-in-out duration-150 w-full md:w-auto'
                . ' px-4 py-2'
                . ' border border-transparent rounded-md'
                . ' bg-gray-200'
                . ' hover:bg-gray-300'
                . ' active:bg-gray-400'
                . ' focus:outline-none focus:border-gray-400 focus:ring focus:ring-gray-100'
                . ' dark:bg-gray-800 dark:hover:bg-gray-700'
                . ' disabled:opacity-25'
                . '',
        ];
    }
}
