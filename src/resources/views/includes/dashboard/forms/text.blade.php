@if ($form->translatable())
    @foreach ($form->translatables() as $translatable)
        <div class='col-md-{{ $form->column() }} {{ $form->className() }}' data-label='container_{{ $key }}'>
            <div class='form-group'>
                @include('adminro::includes.dashboard.forms.utils.label', ['key' => $key, 'suffix' => getTranslatableLabelSuffix($translatable), 'form' => $form->attributes(), 'model' => $controllerSettings->model()->model(), 'edit_mode' => $controllerSettings->request()->editMode()])
                @include('adminro::includes.dashboard.forms.utils.input', ['key' => $key, 'suffix' => getTranslatableKeySuffix($translatable), 'form' => $form->attributes(), 'model' => $controllerSettings->model()->model(), 'edit_mode' => $controllerSettings->request()->editMode(), 'type' => 'input', 'translatable' => $translatable])
                @error($key)
                    <span class='form-text text-danger font-weight-bold'>{{ $message }}</span>
                @endError
            </div>
        </div>
    @endforeach
@else
    <div class='col-md-{{ $form->column() }} {{ $form->className() }}' data-label='container_{{ $key }}'>
        <div class='form-group'>
            @include('adminro::includes.dashboard.forms.utils.label', ['key' => $key, 'form' => $form->attributes(), 'model' => $controllerSettings->model()->model(), 'edit_mode' => $controllerSettings->request()->editMode()])
            @include('adminro::includes.dashboard.forms.utils.input', ['key' => $key, 'form' => $form->attributes(), 'model' => $controllerSettings->model()->model(), 'edit_mode' => $controllerSettings->request()->editMode(), 'type' => 'input'])
            @error($key)
                <span class='form-text text-danger font-weight-bold'>{{ $message }}</span>
            @endError
        </div>
    </div>
@endif
