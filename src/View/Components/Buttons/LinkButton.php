<?php

namespace BondarDe\LaravelToolbox\View\Components\Buttons;

class LinkButton extends DefaultButton
{
    function makeAttributes(): array
    {
        return [
            'class' => 'inline-flex items-center justify-center transition ease-in-out duration-150 w-full md:w-auto'
                . ' px-4 py-2'
                . ' border border-transparent rounded-md'
                . ' hover:bg-gray-200'
                . ' active:bg-gray-300'
                . ' focus:outline-none focus:ring focus:ring-gray-200 focus:border-gray-400'
                . ' dark:hover:bg-gray-700'
                . ' disabled:opacity-25'
                . '',
        ];
    }
}
