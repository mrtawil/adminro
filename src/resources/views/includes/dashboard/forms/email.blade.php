<div class='col-md-{{ $form->column() }} {{ $form->className() }}' data-label='container_{{ $key }}'>
    <div class='form-group'>
        @include('adminro::includes.dashboard.forms.utils.label', ['key' => $key, 'form'=> $form->attributes(), 'model' => $controllerSettings->model()->model(), 'edit_mode' => $controllerSettings->request()->editMode()])
        @include('adminro::includes.dashboard.forms.utils.input', ['key' => $key, 'form'=> $form->attributes(), 'model' => $controllerSettings->model()->model(), 'edit_mode' => $controllerSettings->request()->editMode(), 'type' => 'email'])
        @error($key)
            <span class='form-text text-danger font-weight-bold'>{{ $message }}</span>
        @endError
    </div>
</div>
