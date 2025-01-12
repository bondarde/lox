<?php

namespace BondarDe\Lox\View\Components\Form;

use Illuminate\Contracts\View\View;

class FormActions extends FormComponent
{
    public function render(): View
    {
        return view('lox::components.form.form-actions');
    }
}
