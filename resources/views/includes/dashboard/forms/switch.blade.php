<div class="col-md-{{ $form->column() }} {{ $form->className() }}" data-label="container_{{ $key }}">
    <div class="form-group">
        <label class="font-weight-bold d-block" for="{{ $key }}">{{ $form->name() }}@if (($controllerSettings->request()->editMode() && $form->requiredEdit()) || (!$controllerSettings->request()->editMode() && $form->requiredCreate()))*@endif</label>
        <input data-switch="true" type="checkbox" name="{{ $key }}" id="{{ $key }}" data-on-color="success" data-on-text="ON" data-off-color="danger" data-off-text="OFF" @if ($controllerSettings->request()->editMode() && $controllerSettings->model()->model()[$key]) checked @elseif(!$controllerSettings->request()->editMode() && old($key)) checked @elseif(!$controllerSettings->request()->editMode() && $form->valueCreate()) checked @endif @if (($controllerSettings->request()->editMode() && $form->readOnlyEdit()) || (!$controllerSettings->request()->editMode() && $form->readOnlyCreate())) readonly @endif @if (($controllerSettings->request()->editMode() && $form->disabledEdit()) || (!$controllerSettings->request()->editMode() && $form->disabledCreate())) disabled @endif />
    </div>
</div>
