<?php

namespace BondarDe\LaravelToolbox\View\Components\Buttons;

interface Button
{
    const TAG_BUTTON = 'button';
    const TAG_LINK = 'a';

    function makeAttributes(): array;
}
