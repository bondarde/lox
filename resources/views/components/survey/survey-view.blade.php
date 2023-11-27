<div {{ $attributes }}>
    @foreach($templates as $template)
        @include($template, ['model' => $model])
    @endforeach
</div>
