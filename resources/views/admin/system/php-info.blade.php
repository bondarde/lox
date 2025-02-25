<x-filament-panels::page>

    <script>
        function onIframeLoad(iframe) {
            const contentHeight = iframe.contentWindow.document.body.scrollHeight;
            iframe.style.height = (contentHeight + 100) + 'px';
        }
    </script>

    <x-filament::section>
        <iframe
            class="rounded"
            srcdoc="{{ $phpInfoContents }}"
            width="100%"
            onload="onIframeLoad(this)"
        ></iframe>
    </x-filament::section>

</x-filament-panels::page>
