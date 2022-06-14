@if($loadJsLib)
    <script src="{{ $jsLibSrc }}"></script>
@endif
<script type="text/javascript">
    let tinyConfig = {!! json_encode($editorConfig, JSON_PRETTY_PRINT) !!};

    @if($enableImageUpload)
        tinyConfig = {
        ...tinyConfig,
        ...{
            setup: function (editor) {
                editor.on('init change', function () {
                    console.log('init, change')
                    editor.save()
                })
            },
            image_title: true,
            automatic_uploads: true,
            images_upload_url: '{{ $imagesUploadUrl }}',
            file_picker_types: 'image',
            file_picker_callback: function (cb) {
                const input = document.createElement('input')

                input.setAttribute('type', 'file')
                input.setAttribute('accept', 'image/*')
                input.onchange = function () {
                    const file = this.files[0]
                    const reader = new FileReader()

                    reader.readAsDataURL(file)
                    reader.onload = function () {
                        const id = 'blob-' + (new Date()).getTime()
                        const blobCache = tinymce.activeEditor.editorUpload.blobCache
                        const base64 = reader.result.split(',')[1]
                        const blobInfo = blobCache.create(id, file, base64)
                        blobCache.add(blobInfo)
                        cb(blobInfo.blobUri(), {title: file.name})
                    }
                }
                input.click()
            }
        }
    }
    @endif

    tinymce.init(tinyConfig);
</script>
