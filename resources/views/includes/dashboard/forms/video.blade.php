<div class="col-md-{{ $form->column() }} {{ $form->className() }}" data-label="container_{{ $key }}">
    <div class="form-group">
        <label class="font-weight-bold mb-3" for="{{ $key }}">{{ $form->name() }}@if (($controllerSettings->request()->editMode() && $form->requiredEdit()) || (!$controllerSettings->request()->editMode() && $form->requiredCreate()))*@endif @if ($form->additional())<small class="text-muted">{{ $form->additional() }}</small>@endif</label>
        <input type="file" name="{{ $key }}" id="{{ $key }}" class="d-none" onchange="onFileInputChange('{{ $key }}')" @if (($controllerSettings->request()->editMode() && $form->disabledEdit()) || (!$controllerSettings->request()->editMode() && $form->disabledCreate())) disabled @endif>
        <div class="dropzone dropzone-multi" id="dropzone-{{ $key }}">
            <div class="d-flex align-items-center">
                <div class="dropzone-panel mb-lg-0 mb-2 mr-2">
                    <a class="dropzone-select btn btn-light-primary font-weight-bold btn-sm" onclick="onAttachFilesClick('{{ $key }}')">Attach video</a>
                </div>
                @if ($controllerSettings->request()->editMode() && !$form->hiddenValue() && isset($controllerSettings->model()->model()[$key]) && $controllerSettings->model()->model()[$key])
                    <div class="dropzone-panel mb-lg-0 mb-2">
                        <a class="dropzone-select btn btn-light-danger font-weight-bold btn-sm" href="{{ $controllerSettings->info()->removeFileUrl($key) }}">Remove video</a>
                    </div>
                @endif
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="dropzone-items">
                        <div class="dropzone-item" style="display:none">
                            <div class="dropzone-file">
                                <div class="dropzone-filename" title="some_image_file_name.jpg">
                                    <span id="dropzone-{{ $key }}-filename">some_image_file_name.jpg</span> <strong>(<span id="dropzone-{{ $key }}-filesize">340kb</span>)</strong>
                                </div>
                            </div>
                            <div class="dropzone-toolbar">
                                <span class="dropzone-delete" onclick="onFileRemoveClick('{{ $key }}')"><i class="flaticon2-cross"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if ($controllerSettings->request()->editMode() && !$form->hiddenValue() && isset($controllerSettings->model()->model()[$key]) && $controllerSettings->model()->model()[$key])
            <div class="mt-2">
                <a href="{{ getStorageUrl($controllerSettings->model()->model()[$key . '_path'],$controllerSettings->model()->model()[$key]) }}" class="btn btn-light text-secondary font-weight-bold btn-sm mr-1" target="_blank">Preview</a>
                <a href="{{ getStorageUrl($controllerSettings->model()->model()[$key . '_path'],$controllerSettings->model()->model()[$key]) }}" class="btn btn-light text-secondary font-weight-bold btn-sm" target="_blank" download>Download</a>
            </div>
        @endif
        @error($key)
            <span class="form-text text-danger font-weight-bold">{{ $message }}</span>
        @endError
    </div>
</div>
