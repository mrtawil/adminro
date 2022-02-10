<div class="col-md-12">
    <div class="row">
        @if ($dynamic_select)
            <div class="col-md-{{ $form['column'] }} @if (isset($form['class_name'])){{ $form['class_name'] }}@endif" data-label="container_{{ $key }}">
                <div class="form-group">
                    <label class="font-weight-bold d-flex align-items-center" for="{{ $key }}">
                        <span>{{ $form['name'] }}@if (($edit_mode && $form['required_edit']) || (!$edit_mode && $form['required_create']))*@endif @if (isset($form['additional']))<small class="text-muted">{{ $form['additional'] }}</small>@endif</span>
                        <div id="{{ $key }}_loader" class="ml-2" style="display: none;">
                            <div class="spinner spinner-track spinner-primary"></div>
                        </div>
                    </label>
                    <select wire:model="dynamic_value" wire:change="onDynamicValueChange" name="{{ $key }}" id="{{ $key }}" class="form-control form-control-lg form-control-solid selectpicker" data-size="7" data-live-search="true" @if (($edit_mode && $form['required_edit']) || (!$edit_mode && $form['required_create'])) required @endif @if ($form['multiple']) multiple @endif @if (($edit_mode && $form['readonly_edit']) || (!$edit_mode && $form['readonly_create'])) readonly @endif @if (($edit_mode && $form['disabled_edit']) || (!$edit_mode && $form['disabled_create'])) disabled @endif>
                        @if ($dynamic_select['empty_option'])
                            <option value="" selected>Select</option>
                        @endif
                        @foreach ($dynamic_select['items'] as $item)
                            <option value="{{ $item[$dynamic_select['value_key']] }}">
                                <span>{{ $item[$dynamic_select['title_key']] }}</span>
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

    <script>
        document.addEventListener('livewire:load', function() {
            const key = @this.key;
            const listeners = @this.dynamic_select.listeners;

            const dynamic_loader_event = new Event(key + '_loader');
            @this.on(key + '_changed', () => {
                window.dispatchEvent(dynamic_loader_event);
            });

            listeners.forEach((listener) => {
                window.addEventListener(listener.key_listener + '_loader', () => {
                    $('#' + key + '_loader').show();
                });
            });
        });
    </script>
</div>
