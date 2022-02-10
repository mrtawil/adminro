@php $selectForm = $controllerSettings->formFields()->select($key); @endphp
@if ($selectForm)
    <div class="col-md-{{ $form->column() }} {{ $form->className() }}" data-label="container_{{ $key }}">
        <div class="form-group">
            <label class="font-weight-bold" for="{{ $key }}">{{ $form->name() }}@if (($controllerSettings->request()->editMode() && $form->requiredEdit()) || (!$controllerSettings->request()->editMode() && $form->requiredCreate()))*@endif @if ($form->additional())<small class="text-muted">{{ $form->additional() }}</small>@endif</label>
            <select @if ($form->multiple())  name="{{ $key }}[]" @else name="{{ $key }}" @endif id="{{ $key }}" class="form-control form-control-lg form-control-solid selectpicker" data-size="7" data-live-search="true" @if (($controllerSettings->request()->editMode() && $form->requiredEdit()) || (!$controllerSettings->request()->editMode() && $form->requiredCreate())) required @endif @if ($form->multiple()) multiple @endif @if (($controllerSettings->request()->editMode() && $form->readOnlyEdit()) || (!$controllerSettings->request()->editMode() && $form->readOnlyCreate())) readonly @endif @if (($controllerSettings->request()->editMode() && $form->disabledEdit()) || (!$controllerSettings->request()->editMode() && $form->disabledCreate())) disabled @endif>
                @if ($selectForm->emptyOption())
                    <option value="">Select</option>
                @endif
                @foreach ($selectForm->items() as $item)
                    <option value="{{ $selectForm->value($item) }}" @if (!$form->hiddenValue()) @if ($controllerSettings->request()->editMode()) @if (in_array($selectForm->value($item), $selectForm->itemsSelected(), true)) selected @endif @else @if (in_array($selectForm->value($item), $selectForm->itemsSelected(), true)) selected @endif @if (in_array(strval($selectForm->value($item)), is_array(old($key)) ? old($key) : [strval(old($key))], true)) selected @endif @endif @endif>
                        <span>{{ $selectForm->title($item) }}</span>
                    </option>
                @endforeach
            </select>
            @error($key)
                <span class="form-text text-danger font-weight-bold">{{ $message }}</span>
            @endError
        </div>
    </div>
@endif
