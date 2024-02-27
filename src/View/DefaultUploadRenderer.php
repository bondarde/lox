<?php

namespace BondarDe\Lox\View;

use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class DefaultUploadRenderer
{
    public function __invoke(TemporaryUploadedFile $file)
    {
        return $file->getClientOriginalName();
    }
}
