<div class="col-md-{{ $form->column() }} {{ $form->className() }}" data-label="container_{{ $key }}">
    <div class="form-group">
        <label class="font-weight-bold" for="{{ $key }}">{{ $form->name() }}</label>
        <div id="{{ $key }}-map" style="height: 400px;"></div>
    </div>
</div>
<div class="col-md-{{ $form->column() }} {{ $form->className() }}" data-label="container_{{ $key }}">
    <div class="form-group">
        <button type="button" id="{{ $key }}-use-my-location" class="btn btn-light">Use my location</button>
    </div>
</div>
@if (env('DB_CONNECTION') == 'mysql')
    <div class="col-md-{{ $form->column() }} {{ $form->className() }}" data-label="container_{{ $key }}_latitude">
        <div class="form-group">
            <label class="font-weight-bold" for="{{ $key }}-latitude">Latitude</label>
            <input type="text" id="{{ $key }}-latitude" name="{{ $key }}[latitude]" class="form-control form-control-solid" @if (!$form->hiddenValue()) @if ($controllerSettings->request()->editMode()) value="@if (isset($controllerSettings->model()->model()[$key]) && $controllerSettings->model()->model()[$key] && isset($controllerSettings->model()->model()[$key])){{ $controllerSettings->model()->model()
    [$key]->getLat() }}@endif" @else value="@if (old($key)){{ old($key)['latitude'] }}@endif" @endif @endif autocomplete="off" @if (($controllerSettings->request()->editMode() && $form->requiredEdit()) || (!$controllerSettings->request()->editMode() && $form->requiredCreate())) required @endif @if (($controllerSettings->request()->editMode() && $form->readOnlyEdit()) || (!$controllerSettings->request()->editMode() && $form->readOnlyCreate())) readonly @endif @if (($controllerSettings->request()->editMode() && $form->disabledEdit()) || (!$controllerSettings->request()->editMode() && $form->disabledCreate())) disabled @endif>
        </div>
    </div>
    <div class="col-md-{{ $form->column() }} {{ $form->className() }}" data-label="container_{{ $key }}_longitude">
        <div class="form-group">
            <label class="font-weight-bold" for="{{ $key }}-longitude">Longitude</label>
            <input type="text" id="{{ $key }}-longitude" name="{{ $key }}[longitude]" class="form-control form-control-solid" @if (!$form->hiddenValue()) @if ($controllerSettings->request()->editMode()) value="@if (isset($controllerSettings->model()->model()[$key]) && $controllerSettings->model()->model()[$key] && isset($controllerSettings->model()->model()[$key])){{ $controllerSettings->model()->model()
    [$key]->getLng() }}@endif" @else value="@if (old($key)){{ old($key)['longitude'] }}@endif" @endif @endif autocomplete="off" @if (($controllerSettings->request()->editMode() && $form->requiredEdit()) || (!$controllerSettings->request()->editMode() && $form->requiredCreate())) required @endif @if (($controllerSettings->request()->editMode() && $form->readOnlyEdit()) || (!$controllerSettings->request()->editMode() && $form->readOnlyCreate())) readonly @endif @if (($controllerSettings->request()->editMode() && $form->disabledEdit()) || (!$controllerSettings->request()->editMode() && $form->disabledCreate())) disabled @endif>
        </div>
    </div>
@elseif(env('DB_CONNECTION') == 'mongodb')
    <div class="col-md-{{ $form->column() }} {{ $form->className() }}" data-label="container_{{ $key }}_latitude">
        <div class="form-group">
            <label class="font-weight-bold" for="{{ $key }}-latitude">Latitude</label>
            <input type="text" id="{{ $key }}-latitude" name="{{ $key }}[latitude]" class="form-control form-control-solid" @if (!$form->hiddenValue()) @if ($controllerSettings->request()->editMode()) value="@if (isset($controllerSettings->model()->model()[$key]) && $controllerSettings->model()->model()[$key] && isset($controllerSettings->model()->model()[$key]['coordinates'])){{ $controllerSettings->model()->model()[$key]['coordinates'][1] }}@endif" @else value="@if (old($key)){{ old($key)['latitude'] }}@endif" @endif @endif autocomplete="off" @if (($controllerSettings->request()->editMode() && $form->requiredEdit()) || (!$controllerSettings->request()->editMode() && $form->requiredCreate())) required @endif @if (($controllerSettings->request()->editMode() && $form->readOnlyEdit()) || (!$controllerSettings->request()->editMode() && $form->readOnlyCreate())) readonly @endif @if (($controllerSettings->request()->editMode() && $form->disabledEdit()) || (!$controllerSettings->request()->editMode() && $form->disabledCreate())) disabled @endif>
        </div>
    </div>
    <div class="col-md-{{ $form->column() }} {{ $form->className() }}" data-label="container_{{ $key }}_longitude">
        <div class="form-group">
            <label class="font-weight-bold" for="{{ $key }}-longitude">Longitude</label>
            <input type="text" id="{{ $key }}-longitude" name="{{ $key }}[longitude]" class="form-control form-control-solid" @if (!$form->hiddenValue()) @if ($controllerSettings->request()->editMode()) value="@if (isset($controllerSettings->model()->model()[$key]) && $controllerSettings->model()->model()[$key] && isset($controllerSettings->model()->model()[$key]['coordinates'])){{ $controllerSettings->model()->model()[$key]['coordinates'][0] }}@endif" @else value="@if (old($key)){{ old($key)['longitude'] }}@endif" @endif @endif autocomplete="off" @if (($controllerSettings->request()->editMode() && $form->requiredEdit()) || (!$controllerSettings->request()->editMode() && $form->requiredCreate())) required @endif @if (($controllerSettings->request()->editMode() && $form->readOnlyEdit()) || (!$controllerSettings->request()->editMode() && $form->readOnlyCreate())) readonly @endif @if (($controllerSettings->request()->editMode() && $form->disabledEdit()) || (!$controllerSettings->request()->editMode() && $form->disabledCreate())) disabled @endif>
        </div>
    </div>
@endif
