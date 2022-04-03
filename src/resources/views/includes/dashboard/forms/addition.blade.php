<div class="col-md-{{ $form->column() }} {{ $form->className() }}" data-label="container_{{ $key }}">
    @includeIf($form->bladePath(), ['key' => $key, 'form' => $form->attributes(), 'model' => $controllerSettings->model()->model(), 'edit_mode' => $controllerSettings->request()->editMode()])
</div>
