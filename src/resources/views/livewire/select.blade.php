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
                    <select wire:model='value' wire:change='onValueChange' name='{{ $key }}' id='{{ $key }}' class='form-control form-control-lg form-control-solid' data-size='7' data-live-search='true' placeholder='{{ $form['placeholder'] }}' max='{{ $form['max_value'] }}' min='{{ $form['min_value'] }}' step='{{ $form['step'] }}' autocomplete='{{ $form['autocomplete'] }}' maxlength='{{ $form['max_length'] }}' value='{{ getFormValue($key, $form, $model, $edit_mode, $suffix ?? '', $prefix ?? '') }}' @if (getFormRequired($form, $edit_mode)) required @endif @if (getFormReadOnly($form, $edit_mode)) readonly @endif @if (getFormDisabled($form, $edit_mode)) disabled @endif>
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
                    $('#' + key).prop('disabled', true);
                });
            });

            $('#' + key).on('change', (e) => {
                @this.set('value', e.target.value);
            });

            window.addEventListener(key + '_rebuild', (event) => {
                select = @this.select;
                value = @this.value;

                initSelectForm(key, getActiveSelectRequest(select));
                $('#' + key + '_loader').hide();
                $('#' + key).prop('disabled', false);
            });

            var initSelectForm = (key, active_request) => {
                let options = {
                    placeholder: 'Select',
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
                        cache: false,
                        data: function(params) {
                            query = {
                                q: params.term,
                                page: params.page || 1,
                                select: JSON.stringify(select),
                                active_request: active_request,
                            };

                            active_request.params.forEach((param) => {
                                query[param] = @this[param];
                            });

                            return query;
                        },
                    }
                }

                if (!select.static_items) {
                    $('#' + key).empty();
                }

                $('#' + key).select2(options);
            }

            var getActiveSelectRequest = (select) => {
                if (select.default_request) {
                    return select.default_request;
                }

                let conditional_request = select.conditional_requests.find((conditional_request) => @this[conditional_request.conditional_key] == conditional_request.conditional_value);
                if (conditional_request) {
                    return conditional_request.request;
                }

                return null;
            }

            initSelectForm(key, getActiveSelectRequest(select));
        });
    </script>
</div>
