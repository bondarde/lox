@foreach($templates as $template)
    @include($template, ['model' => $model])
@endforeach
