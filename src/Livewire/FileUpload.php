<?php

namespace BondarDe\Lox\Livewire;

use BondarDe\Lox\Exceptions\IllegalStateException;
use BondarDe\Lox\View\DefaultUploadRenderer;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class FileUpload extends Component
{
    use WithFileUploads;

    public string $name;
    public int $max = 10;

    public array $files = [];
    public string $label = 'Datei hinzufügen&thinsp;…';
    public bool $removable = true;
    public bool $showSize = true;
    public string $renderer = DefaultUploadRenderer::class;
    public ?string $handler = null;

    public array $oldFiles;

    /**
     * @throws IllegalStateException
     */
    public function mount(): void
    {
        if (! ($this->name ?? null)) {
            throw new IllegalStateException('Attribute "name" is required.');
        }

        $this->label ??= __('Add file') . '&thinsp;…';

        $old = old($this->name ?? []);
        $this->oldFiles = collect($old)
            ->mapWithKeys(function (string $fileId): array {
                $tmpPath = $this->toRealPath($fileId);

                // fixes an issue with absolute path names in \Livewire\Features\SupportFileUploads\FileUploadConfiguration::path()
                $livewireTmpFile = File::basename($tmpPath);

                $file = TemporaryUploadedFile::createFromLivewire($livewireTmpFile);

                return [
                    $fileId => $file,
                ];
            })
            ->toArray();
    }

    public function toFileId(TemporaryUploadedFile $file): string
    {
        return Crypt::encryptString($file->getRealPath());
    }

    private function toRealPath(string $fileId): string
    {
        return Crypt::decryptString($fileId);
    }

    /**
     * @throws IllegalStateException
     */
    public function removeFile(string $fileId): void
    {
        $providedRealPath = $this->toRealPath($fileId);

        foreach ($this->files as $idx => $file) {
            $currentFileRealPath = $file->getRealPath();

            if ($providedRealPath !== $currentFileRealPath) {
                continue;
            }

            array_splice($this->files, $idx, 1);

            return;
        }

        throw new IllegalStateException('File not found: "' . $fileId . '"');
    }

    /**
     * @throws IllegalStateException
     */
    public function removeOldFile(string $fileId): void
    {
        if (! isset($this->oldFiles[$fileId])) {
            throw new IllegalStateException('File not found: "' . $fileId . '"');
        }

        unset($this->oldFiles[$fileId]);
    }

    public function updatedFiles(): void
    {
        if (! $this->handler) {
            return;
        }

        $lastFile = last($this->files);
        (new $this->handler())($lastFile);
    }

    public function render(): View
    {
        return view('lox::components.livewire.file-upload', [
            'id' => Str::uuid(),
        ]);
    }
}
