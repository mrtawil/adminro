<div class="col-md-{{ $form->column() }} {{ $form->className() }}" data-label="container_{{ $key }}">
    @includeIf($form['blade_path'], ['form' => $form])
</div>
