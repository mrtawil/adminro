<div class="col-md-12">
    <div class="row">
        @if ($model_select_type)
            <div class="col-md-{{ $form['column'] }} @if (isset($form['class_name'])){{ $form['class_name'] }}@endif" data-label="container_{{ $key . '_type' }}">
                <div class="form-group">
                    <label class="font-weight-bold" for="{{ $key . '_type' }}">{{ $form['name'] }} {{ 'Type' }}@if (($edit_mode && $form['required_edit']) || (!$edit_mode && $form['required_create']))*@endif @if (isset($form['additional']))<small class="text-muted">{{ $form['additional'] }}</small>@endif</label>
                    <select wire:model="model_type" wire:change="onModelTypeChange" name="{{ $key . '_type' }}" id="{{ $key . '_type' }}" class="form-control form-control-lg form-control-solid selectpicker" data-size="7" data-live-search="true" @if (($edit_mode && $form['required_edit']) || (!$edit_mode && $form['required_create'])) required @endif @if ($form['multiple']) multiple @endif @if (($edit_mode && $form['readonly_edit']) || (!$edit_mode && $form['readonly_create'])) readonly @endif @if (($edit_mode && $form['disabled_edit']) || (!$edit_mode && $form['disabled_create'])) disabled @endif>
                        @if ($model_select_type['empty_option'])
                            <option value="" selected>Select</option>
                        @endif
                        @foreach ($model_select_type['items'] as $item)
                            <option value="{{ $item[$model_select_type['value_key']] }}">
                                <span>{{ $item[$model_select_type['title_key']] }}</span>
                            </option>
                        @endforeach
                    </select>
                    @error($key)
                        <span class="form-text text-danger font-weight-bold">{{ $message }}</span>
                    @endError
                </div>
            </div>
        @endif

        @if ($model_select_id)
            <div class="col-md-{{ $form['column'] }} @if (isset($form['class_name'])){{ $form['class_name'] }}@endif" data-label="container_{{ $key . '_id' }}">
                <div class="form-group">
                    <label class="font-weight-bold" for="{{ $key . '_id' }}">{{ $form['name'] }} {{ 'Id' }}@if (($edit_mode && $form['required_edit']) || (!$edit_mode && $form['required_create']))*@endif @if (isset($form['additional']))<small class="text-muted">{{ $form['additional'] }}</small>@endif</label>
                    <select wire:model="model_id" wire:change="onModelIdChange" name="{{ $key . '_id' }}" id="{{ $key . '_id' }}" class="form-control form-control-lg form-control-solid selectpicker" data-size="7" data-live-search="true" @if (($edit_mode && $form['required_edit']) || (!$edit_mode && $form['required_create'])) required @endif @if ($form['multiple']) multiple @endif @if (($edit_mode && $form['readonly_edit']) || (!$edit_mode && $form['readonly_create'])) readonly @endif @if (($edit_mode && $form['disabled_edit']) || (!$edit_mode && $form['disabled_create'])) disabled @endif>
                        @if ($model_select_id['empty_option'])
                            <option value="" selected>Select</option>
                        @endif
                        @foreach ($model_select_id['items'] as $item)
                            <option value="{{ $item[$model_select_id['value_key']] }}">
                                <span>{{ $item[$model_select_id['title_key']] }}</span>
                            </option>
                        @endforeach
                    </select>
                    @error($key)
                        <span class="form-text text-danger font-weight-bold">{{ $message }}</span>
                    @endError
                </div>
            </div>
        @endif
    </div>
</div>
