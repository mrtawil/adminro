<div class='col-md-{{ $form->column() }} {{ $form->className() }}' data-label='container_{{ $key }}'>
    <div class='form-group'>
        @include('adminro::includes.dashboard.forms.utils.label', ['key' => $key, 'form'=> $form->attributes(), 'model' => $controllerSettings->model()->model(), 'edit_mode' => $controllerSettings->request()->editMode(), 'className' => 'd-block'])
        @include('adminro::includes.dashboard.forms.utils.input', ['key' => $key, 'form'=> $form->attributes(), 'model' => $controllerSettings->model()->model(), 'edit_mode' => $controllerSettings->request()->editMode(), 'type' => 'checkbox'])
    </div>
</div>
