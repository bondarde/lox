<x-form.form-row
    for="name"
    :label="__('Name')"
>
    <x-form.input
        name="name"
        :placeholder="__('Name')"
        :model="$model"
    />
</x-form.form-row>


<x-form.form-row
    for="guard_name"
    :label="__('Guard')"
>
    <x-form.input
        name="guard_name"
        :placeholder="__('Guard')"
        :model="$model"
    />
    <p class="text-sm">Z.B. „web“ oder „api“</p>
</x-form.form-row>
