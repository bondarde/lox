@livewire('lox::application-models-list', [
    'model' => $getRecord()->fullyQualifiedClassName,
    'dbTableName' => $getRecord()->dbTableName,
])
