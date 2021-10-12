<?php

namespace BondarDe\LaravelToolbox\View\Components\Buttons;

use Illuminate\View\Component;

class DefaultButton extends Component implements Button
{
    public string $tag = self::TAG_BUTTON;
    public array $defaultAttributes;

    public function __construct(
        string $tag = self::TAG_BUTTON
    )
    {
        $this->tag = $tag;
        $this->defaultAttributes = $this->makeAttributes();

        if ($tag === self::TAG_BUTTON) {
            $this->defaultAttributes['type'] = 'submit';
        }
    }

    function makeAttributes(): array
    {
        return [
            'class' => 'inline-flex items-center justify-center transition ease-in-out duration-150 w-full md:w-auto'
                . ' px-4 py-2'
                . ' border border-transparent rounded-md'
                . ' bg-gray-800 text-white'
                . ' hover:bg-gray-700'
                . ' active:bg-gray-900'
                . ' focus:outline-none focus:ring focus:ring-gray-300 focus:border-gray-900'
                . ' dark:bg-black dark:hover:bg-gray-800'
                . ' disabled:opacity-25'
                . '',
        ];
    }

    public function render()
    {
        return view('laravel-toolbox::buttons.button');
    }
}
