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
<div class="col-md-{{ $form->column() }} {{ $form->className() }}" data-label="container_{{ $key }}_latitude">
    <div class="form-group">
        <label class="font-weight-bold" for="{{ $key }}-latitude">Latitude</label>
        @include('adminro::includes.dashboard.forms.utils.input', ['key' => $key, 'form'=> $form->attributes(), 'model' => $controllerSettings->model()->model(), 'edit_mode' => $controllerSettings->request()->editMode(), 'type' => 'text', 'prefix' => '.latitude'])
    </div>
</div>
<div class="col-md-{{ $form->column() }} {{ $form->className() }}" data-label="container_{{ $key }}_longitude">
    <div class="form-group">
        <label class="font-weight-bold" for="{{ $key }}-longitude">Longitude</label>
        @include('adminro::includes.dashboard.forms.utils.input', ['key' => $key, 'form'=> $form->attributes(), 'model' => $controllerSettings->model()->model(), 'edit_mode' => $controllerSettings->request()->editMode(), 'type' => 'text', 'prefix' => '.longitude'])
    </div>
</div>
