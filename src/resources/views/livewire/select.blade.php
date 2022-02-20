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
                    <select wire:model='value' wire:change='onValueChange' name='{{ $key }}' id='{{ $key }}' class='form-control form-control-lg form-control-solid selectpicker' data-size='7' data-live-search='true' data-none-selected-text='Select' @if (($edit_mode && $form['required_edit']) || (!$edit_mode && $form['required_create'])) required @endif @if ($form['multiple']) multiple @endif @if (($edit_mode && $form['readonly_edit']) || (!$edit_mode && $form['readonly_create'])) readonly @endif @if (($edit_mode && $form['disabled_edit']) || (!$edit_mode && $form['disabled_create'])) disabled @endif>
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
                });
            });

            window.addEventListener(key + '_rebuild', (event) => {
                select = @this.select;
                value = @this.value;

                rebuildSelect(key, select, value);
                $('#' + key + '_loader').hide();
            });

            var addListenerOnSearchChange = (key) => {
                let el = $('div[data-label="container_' + key + '"] input[type="search"]');
                $(el).on('keyup', (e) => {
                    const value = e.target.value;
                    console.log('value:', value);

                    @this.onSearchChange(value);
                });
            }

            $(function() {
                // addListenerOnSearchChange(key);
            });
        });
    </script>
</div>
