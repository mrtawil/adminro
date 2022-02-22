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
                    <select wire:model='value' wire:change='onValueChange' name='{{ $key }}' id='{{ $key }}' class='form-control' style='width: 100%; display: none;' data-live-search='true' placeholder='{{ $form['placeholder'] }}' max='{{ $form['max_value'] }}' min='{{ $form['min_value'] }}' step='{{ $form['step'] }}' autocomplete='{{ $form['autocomplete'] }}' maxlength='{{ $form['max_length'] }}' @if ($form['multiple']) multiple @endif value='{{ getFormValue($key, $form, $model, $edit_mode, $suffix ?? '', $prefix ?? '') }}' @if (getFormRequired($form, $edit_mode)) required @endif @if (getFormReadOnly($form, $edit_mode)) readonly @endif @if (getFormDisabled($form, $edit_mode)) disabled @endif>
                        @if ($select['empty_option'] && !$form['multiple'])
                            <option value='' selected>Select</option>
                        @endif
                        @foreach ($select['items'] as $item)
                            <option value='{{ $item[$select['value_key']] }}' @selected($item[$select['value_key']]==$this->value)>
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

    @push('scripts')
        <script>
            document.addEventListener('livewire:load', function() {
                const key = @this.key;
                var key_listeners = @this.select.listeners.map((listener) => {
                    return listener.key_listener;
                });

                const select_loader_event = new Event(key + '_loader');
                @this.on(key + '_changed', () => {
                    window.dispatchEvent(select_loader_event);
                });

                @this.select.listeners.forEach((listener) => {
                    window.addEventListener(listener.key_listener + '_loader', () => {
                        $('.forms #' + key).prop('disabled', true);
                        $('#' + key + '_loader').show();
                    });
                });

                $('.forms #' + key).on('change', (e) => {
                    if (@this.form.multiple) {
                        let values = [];
                        $('.forms #' + key).find(':selected').each(function(index, option) {
                            values.push($(option).val());
                        });

                        @this.set('value', values);
                    } else {
                        @this.set('value', e.target.value);
                    }
                });

                @this.on(key + '_rebuild', (event) => {
                    initSelectForm(key, getActiveSelectRequest(@this.select), false);
                    $('#' + key + '_loader').hide();
                });

                var initSelectForm = (key, active_request, first_load) => {
                    let options = {
                        placeholder: 'Select',
                        allowClear: true,
                        minimumInputLength: 0,
                        width: 'resolve',
                        escapeMarkup: function(markup) {
                            return markup;
                        },
                        language: {
                            searching: function() {
                                // return 'Searching';
                            }
                        },
                    }

                    if (first_load) {
                        options.data = @this.select.items;
                    }

                    if (active_request && !@this.select.static_items) {
                        options.ajax = {
                            url: active_request.url,
                            dataType: 'json',
                            method: 'POST',
                            delay: 250,
                            headers: {
                                'X-CSRF-TOKEN': $('input[name="_token"]').val()
                            },
                            data: function(params) {
                                query = {
                                    q: params.term,
                                    page: params.page || 1,
                                    select: JSON.stringify(@this.select),
                                    active_request: active_request,
                                };

                                active_request.params.forEach((param) => {
                                    query[param] = @this[param];
                                });

                                return query;
                            },
                        }
                    }

                    if ((@this.select.static_items && checkParams(key_listeners)) || (!@this.select.static_items && active_request)) {
                        $('.forms #' + key).prop('disabled', false);
                    } else {
                        $('.forms #' + key).prop('disabled', true);
                    }

                    $('.forms #' + key).select2(options);

                    if (first_load) {
                        $('.forms #' + key).on("select2:clear", function(e) {
                            $(this).on("select2:opening.cancelOpen", function(e) {
                                e.preventDefault();

                                $(this).off("select2:opening.cancelOpen");
                            });
                        });
                    }
                }

                var getActiveSelectRequest = (select) => {
                    if (select.default_request) {
                        if (!checkParams(select.default_request.params)) {
                            return null;
                        }

                        return select.default_request;
                    }

                    let conditional_request = select.conditional_requests.find((conditional_request) => @this[conditional_request.conditional_key] == conditional_request.conditional_value);
                    if (conditional_request) {
                        if (!checkParams(conditional_request.request.params)) {
                            return null;
                        }

                        return conditional_request.request;
                    }

                    return null;
                }

                var checkParams = (params) => {
                    for (let i = 0; i < params.length; i++) {
                        let param = params[i];
                        if (@this[param] === null || @this[param] === '') {
                            return false;
                        }
                    }

                    return true;
                }

                initSelectForm(key, getActiveSelectRequest(@this.select), true);
            });
        </script>
    @endpush
</div>
