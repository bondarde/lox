<?php

namespace BondarDe\Lox\View\Components;

use BondarDe\Lox\Exceptions\IllegalStateException;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{
    public function __construct(
        public readonly string   $tag = 'button',
        public ?string           $icon = null,
        public readonly ?string  $badge = null,
        public readonly bool     $enabled = true,

        private readonly string  $position = 'relative',
        private readonly string  $base = 'inline-flex gap-2 items-center justify-center focus:outline-none focus:ring',
        private readonly string  $width = 'w-full md:w-auto',
        private readonly string  $animation = 'transition ease-in-out duration-150',
        private string           $padding = 'px-4 py-2',
        private readonly string  $borders = 'border border-transparent rounded-md',
        private string           $bg = 'bg-gray-800 dark:bg-gray-200',
        private string           $text = 'text-white dark:text-gray-900',
        private string           $hover = 'hover:bg-gray-700 dark:hover:bg-gray-100',
        private string           $active = 'active:bg-gray-900',
        private string           $focus = 'focus:ring-gray-300 focus:border-gray-900',
        private readonly string  $disabled = 'disabled:opacity-25',
        private readonly ?string $size = null,
        private readonly ?string $color = null,
        private readonly ?string $type = null,
        private readonly ?string $href = null,
    ) {
        switch ($this->color) {
            case 'info':
            case 'blue':
                $this->bg = 'bg-blue-800';
                $this->text = 'text-blue-100';
                $this->hover = 'hover:bg-blue-600 text-blue-50';
                $this->active = 'active:bg-blue-800';
                $this->focus = 'focus:ring-blue-200 focus:border-blue-900';
                break;
            case 'success':
            case 'green':
                $this->bg = 'bg-green-700';
                $this->text = 'text-green-50';
                $this->hover = 'hover:bg-green-600 hover:text-white';
                $this->active = 'active:bg-green-800';
                $this->focus = 'focus:ring-green-100 focus:border-green-900';
                break;
            case 'warning':
            case 'yellow':
                $this->bg = 'bg-yellow-600';
                $this->hover = 'hover:bg-yellow-500';
                $this->active = 'active:bg-yellow-800';
                $this->focus = 'focus:ring-yellow-100 focus:border-yellow-900';
                break;
            case 'danger':
            case 'red':
                $this->bg = 'bg-red-800';
                $this->text = 'text-red-50';
                $this->hover = 'hover:bg-red-700 hover:text-white';
                $this->active = 'active:bg-red-700';
                $this->focus = 'focus:ring-red-200 focus:border-red-900';
                break;
            case 'light':
                $this->bg = 'bg-gray-200 dark:bg-gray-800';
                $this->text = 'text-gray-900 dark:text-gray-100';
                $this->hover = 'hover:bg-gray-300 dark:hover:bg-gray-700';
                $this->active = 'active:bg-gray-400';
                $this->focus = 'focus:border-gray-400 focus:ring-gray-100';
                break;
        }

        switch ($this->size) {
            case 'xs':
                $this->padding = 'px-1.5 py-0.5';
                $this->text .= ' text-xs font-semibold';
                break;
            case 'sm':
                $this->padding = 'px-2 py-1';
                $this->text .= ' text-sm font-semibold';
                break;
            case 'md':
                $this->padding = 'px-3 py-1.5';
                $this->text .= ' text-md';
                break;
            case 'lg':
                $this->padding = 'px-4 py-2';
                $this->text .= ' text-lg';
                break;
            case 'xl':
                $this->padding = 'px-6 py-3';
                $this->text .= ' text-xl font-semibold tracking-wide';
        }
    }

    /**
     * @throws IllegalStateException
     */
    private function makeAttributes(): array
    {
        $attributes = [
            'class' => collect([
                $this->width,
                $this->base,
                $this->position,
                $this->animation,
                $this->padding,
                $this->borders,
                $this->bg,
                $this->text,
                $this->hover,
                $this->active,
                $this->focus,
                $this->disabled,
            ])->filter()->join(' '),
        ];

        if ($this->tag === 'a') {
            if ($this->href) {
                $attributes['href'] = $this->href;
            } else {
                throw new IllegalStateException('Link is missing href attribute.');
            }
        }

        if ($this->tag === 'button') {
            if ($this->type) {
                $attributes['type'] = $this->type;
            } else {
                $attributes['type'] = 'submit';
            }

            if (! $this->enabled) {
                $attributes['disabled'] = 'disabled';
            }
        }

        return $attributes;
    }

    /**
     * @throws IllegalStateException
     */
    public function render(): View
    {
        $buttonAttributes = $this->makeAttributes();

        return view('lox::components.button', compact(
            'buttonAttributes',
        ));
    }
}
