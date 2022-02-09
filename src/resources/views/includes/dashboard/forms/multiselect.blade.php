@php $multiselect = $controllerSettings->formFields()->multiSelect($key); @endphp
@if ($multiselect)
    <div class="col-md-{{ $form->column() }} {{ $form->className() }}" data-label="container_{{ $key }}">
        <div class="form-group">
            <label class="font-weight-bold d-block" for="{{ $key }}">{{ $form->name() }}@if (($controllerSettings->request()->editMode() && $form->requiredEdit()) || (!$controllerSettings->request()->editMode() && $form->requiredCreate()))*@endif @if ($form->additional())<small class="text-muted">{{ $form->additional() }}</small>@endif</label>
            <select name="{{ $key }}[]" id="{{ $key }}" class="searchable" @if ($form->multiple()) multiple="multiple" @endif>
                @foreach ($multiselect->items() as $item)
                    <option value="{{ $multiselect->value($item) }}" @if (!$form->hiddenValue()) @if ($controllerSettings->request()->editMode()) @if (in_array($multiselect->value($item), $multiselect->itemsSelected(), true)) selected @endif @else @if (in_array($multiselect->value($item), $multiselect->itemsSelected(), true)) selected @endif @if(in_array(strval($multiselect->value($item)), is_array(old($key)) ? old($key) : [strval(old($key))], TRUE)) selected @endif @endif @endif>
                        <span>{{ $multiselect->title($item) }}</span>
                    </option>
                @endforeach
            </select>
            @error($key)
                <span class="form-text text-danger font-weight-bold">{{ $message }}</span>
            @endError
        </div>
    </div>
@endif
