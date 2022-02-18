<label class="d-flex align-items-center font-weight-bold {{ $className ?? '' }}" for="{{ $key }}">
    <span>{{ $form['name'] }}</span>
    @if (getFormRequired($form, $edit_mode))
        <span>*</span>
    @endif
    @if ($form['additional'])
        <small class="text-muted ml-1">{{ $form['additional'] }}</small>
    @endif
</label>
