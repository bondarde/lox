<div
    x-data="{ uploading: false, progress: 0 }"
    x-on:livewire-upload-start="uploading = true"
    x-on:livewire-upload-finish="uploading = false"
    x-on:livewire-upload-error="uploading = false"
    x-on:livewire-upload-progress="progress = $event.detail.progress"
>
    {{-- File Input --}}
    <input
        class="hidden"
        type="file"
        id="{{ $id }}"
        wire:model="files"
    >

    {{-- Label / Button / Dropzone --}}
    <label
        class="block border-2 border-dashed rounded-lg p-4 text-gray-500 dark:text-gray-200 cursor-pointer"
        x-bind:class="isDroppingFile ? 'bg-blue-200 border-blue-400' : 'bg-gray-50 dark:bg-gray-800 border-gray-200 dark:border-gray-700'"
        id="label-{{ $id }}"
        for="{{ $id }}"
        x-data="fileDropData()"
        x-on:drop="isDroppingFile = false"
        x-on:drop.prevent="handleFileDrop($event)"
        x-on:dragover.prevent="isDroppingFile = true"
        x-on:dragleave.prevent="isDroppingFile = false"
    >
        {!! $label !!}
    </label>


    {{-- Files list --}}
    @if(count($files) || count($oldFiles))
        <ul class="flex flex-col gap-4 mt-4">
            @foreach($oldFiles as $fileId => $file)
                <li
                    wire:key="{{ $file->getRealPath() }}"
                >
                    <input
                        type="hidden"
                        name="{{ $name }}[]"
                        value="{{ $this->toFileId($file) }}"
                    >
                    {{ (new $renderer)($file) }}
                    @if($showSize)
                        <span
                            class="text-sm opacity-75"
                        ><x-lox::file-size
                                :bytes="$file->getSize()"
                            /></span>
                    @endif
                    @if($removable)
                        <x-lox::button
                            class="md:ml-2"
                            type="button"
                            size="sm"
                            color="red"
                            wire:click="removeOldFile('{{ $fileId }}')"
                            icon="×"
                        >
                            {{ __('Remove') }}
                        </x-lox::button>
                    @endif
                </li>
            @endforeach
            @foreach($files as $file)
                <li
                    wire:key="{{ $file->getRealPath() }}"
                >
                    <input
                        type="hidden"
                        name="{{ $name }}[]"
                        value="{{ $this->toFileId($file) }}"
                    >
                    {{ (new $renderer)($file) }}
                    @if($showSize)
                        <span
                            class="text-sm opacity-75"
                        ><x-lox::file-size
                                :bytes="$file->getSize()"
                            /></span>
                    @endif
                    @if($removable)
                        <x-lox::button
                            class="md:ml-2"
                            type="button"
                            size="sm"
                            color="red"
                            wire:click="removeFile('{{ $this->toFileId($file) }}')"
                            icon="×"
                        >
                            {{ __('Remove') }}
                        </x-lox::button>
                    @endif
                </li>
            @endforeach
        </ul>
    @endif


    {{-- Loader --}}
    <div
        wire:loading
        wire:target="files"
    >
        {{ __('Uploading') }}&thinsp;…
        <br>
        <progress max="100" x-bind:value="progress"></progress>
    </div>

    {{-- https://f24aalam.medium.com/laravel-livewire-drag-n-drop-files-upload-using-alpinejs-37d5b80d3eb9 --}}
    <script>
        window.fileDropData = () => {
            const self = @this;

            const handleFileDrop = (ev) => {
                if (!ev.dataTransfer.files.length) {
                    return
                }

                const files = ev.dataTransfer.files;

                let currentFilesCount = self.files.length;
                const hasMaxAllowedFilesCount = currentFilesCount >= self.max;
                const wouldExceedMaxAllowedFilesCount = currentFilesCount + files.length > self.max;

                if (hasMaxAllowedFilesCount || wouldExceedMaxAllowedFilesCount) {
                    alert('{{ trans_choice('{1} Maximum one file!|[2,*] Maximum :count files!', $max) }}');
                    return
                }

                for (let file of files) {
                    self.upload('files', file,
                        (file) => console.log('uploaded', file),
                        (error) => {
                            console.error(error)
                            let message = '{{ __('Upload of “:file” failed!') }}'.replace(':file', file.name)
                            alert(message)
                        },
                        (progress) => console.log('progress', file, progress.detail.progress)
                    )
                }
            }

            return {
                isDroppingFile: false,
                handleFileDrop,
            }
        }
    </script>
</div>
