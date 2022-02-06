@if($loadJsLib)
    <script src="{{ $jsLibSrc }}"></script>
@endif
<script type="text/javascript">
    tinymce.init({!! json_encode($editorConfig, JSON_PRETTY_PRINT) !!});
</script>
