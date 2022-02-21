<div class='col-md-12'>
    <div class='row'>
        @if ($select)
            <div class='col-md-{{ $form['column'] }} {{ $form['class_name'] }}' data-label='container_{{ $key }}' wire:ignore>
                <div class='form-group'>
                    <div class='d-flex align-items-center'>
                        @include('adminro::includes.dashboard.forms.utils.label', ['key' => $key, 'form' => $form])
                        <div id='{{ $key }}_loader' class='ml-2 mb-2' style='display: none;'>
                            <div class='spinner spinner-track spinner-primary'></div>
                        </div>
                    </div>
                    <select wire:model='value' wire:change='onValueChange' name='{{ $key }}' id='{{ $key }}' class='form-control form-control-lg form-control-solid select2' data-size='7' data-live-search='true' data-none-selected-text='Select' @if (($edit_mode && $form['required_edit']) || (!$edit_mode && $form['required_create'])) required @endif @if ($form['multiple']) multiple @endif @if (($edit_mode && $form['readonly_edit']) || (!$edit_mode && $form['readonly_create'])) readonly @endif @if (($edit_mode && $form['disabled_edit']) || (!$edit_mode && $form['disabled_create'])) disabled @endif>
                        @if ($select['empty_option'])
                            <option value='' selected>Select</option>
                        @endif
                        @foreach ($select['items'] as $item)
                            <option value='{{ $item[$select['value_key']] }}'>
                                <span>{{ $item[$select['title_key']] }}</span>
                            </option>
                        @endforeach
                    </select>
                    @error($key)
                        <span class='form-text text-danger font-weight-bold'>{{ $message }}</span>
                    @endError
                </div>
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('livewire:load', function() {
            const key = @this.key;
            var select = @this.select;
            var value = @this.value;

            const select_loader_event = new Event(key + '_loader');
            @this.on(key + '_changed', () => {
                window.dispatchEvent(select_loader_event);
            });

            select.listeners.forEach((listener) => {
                window.addEventListener(listener.key_listener + '_loader', () => {
                    $('#' + key + '_loader').show();
                    $('#' + key).prop("disabled", true);
                });
            });

            window.addEventListener(key + '_rebuild', (event) => {
                select = @this.select;
                value = @this.value;

                let active_request = getActiveSelectRequest();
                console.log({
                    key: key,
                    active_request: active_request
                });

                let options = {
                    placeholder: "Search for items",
                    allowClear: true,
                    minimumInputLength: 0,
                    escapeMarkup: function(markup) {
                        return markup;
                    },
                }

                if (active_request) {
                    options.ajax = {
                        url: active_request.url,
                        dataType: 'json',
                        delay: 250,
                        cache: true,
                        data: function(params) {
                            query = {
                                q: params.term,
                                page: params.page || 1,
                            };

                            active_request.params.forEach((param) => {
                                query[param] = @this[param];
                            });

                            return query;
                        },
                    }
                }

                $('#' + key).select2(options);

                $('#' + key + '_loader').hide();
                $('#' + key).prop("disabled", false);
            });

            $('#' + key).on('change', (e) => {
                @this.set('value', e.target.value);
            });

            var getActiveSelectRequest = () => {
                if (select.default_request) {
                    return select.default_request;
                }

                let conditional_request = select.conditional_requests.find((conditional_request) => @this[conditional_request.conditional_key] == conditional_request.conditional_value);
                if (conditional_request) {
                    return conditional_request.request;
                }

                return null;
            }
        });
    </script>
</div>
