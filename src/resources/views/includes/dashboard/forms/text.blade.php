<div class="col-md-{{ $form->column() }} {{ $form->className() }}" data-label="container_{{ $key }}">
    <div class="form-group">
        <label class="font-weight-bold" for="{{ $key }}">{{ $form->name() }}@if (($controllerSettings->request()->editMode() && $form->requiredEdit()) || (!$controllerSettings->request()->editMode() && $form->requiredCreate()))*@endif @if ($form->additional())<small class="text-muted">{{ $form->additional() }}</small>@endif</label>
        <input type="text" name="{{ $key }}" id="{{ $key }}" class="form-control form-control-lg form-control-solid" placeholder="{{ $form->placeholder() }}" max="{{ $form->maxValue() }}" min="{{ $form->minValue() }}" step="{{ $form->step() }}" autocomplete="{{ $form->autocomplete() }}" maxlength="{{ $form->maxLength() }}" @if (($controllerSettings->request()->editMode() && $form->requiredEdit()) || (!$controllerSettings->request()->editMode() && $form->requiredCreate())) required @endif @if (!$form->hiddenValue()) @if ($controllerSettings->request()->editMode()) value="{{ $controllerSettings->model()->model()[$key] ?? '' }}" @else value="@if (old($key)){{ old($key) }}@else{{ $form->valueCreate() }}@endif" @endif @endif @if (($controllerSettings->request()->editMode() && $form->readOnlyEdit()) || (!$controllerSettings->request()->editMode() && $form->readOnlyCreate())) readonly @endif @if (($controllerSettings->request()->editMode() && $form->disabledEdit()) || (!$controllerSettings->request()->editMode() && $form->disabledCreate())) disabled @endif />
        @error($key)
            <span class="form-text text-danger font-weight-bold">{{ $message }}</span>
        @endError
    </div>
</div>
