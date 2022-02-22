<input type='{{ $type }}' name='{{ getFormName($key, $suffix ?? '', $prefix ?? '') }}' id='{{ getFormId($key, $suffix ?? '', $prefix ?? '') }}' class='form-control form-control-lg' @if ($type == 'checkbox') data-switch='true' data-on-color='success' data-on-text='ON' data-off-color='danger' data-off-text='OFF' @endif placeholder='{{ $form['placeholder'] }}' max='{{ $form['max_value'] }}' min='{{ $form['min_value'] }}' step='{{ $form['step'] }}' autocomplete='{{ $form['autocomplete'] }}' maxlength='{{ $form['max_length'] }}' @if ($form['multiple']) multiple @endif value='{{ getFormValue($key, $form, $model, $edit_mode, $suffix ?? '', $prefix ?? '') }}' @if (getFormRequired($form, $edit_mode)) required @endif @if (getFormReadOnly($form, $edit_mode)) readonly @endif @if (getFormDisabled($form, $edit_mode)) disabled @endif />
