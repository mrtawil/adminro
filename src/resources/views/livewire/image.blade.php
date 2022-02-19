<div class="col-md-{{ $form['column'] }} {{ $form['class_name'] }}" data-label="container_{{ $key }}">
    <div class="form-group">
        @include('adminro::includes.dashboard.forms.utils.label', ['key' => $key, 'form' => $form])
        <input type="file" name="{{ $key }}" id="{{ $key }}" class="d-none" onchange="onFileInputChange('{{ $key }}')" @if (($edit_mode && $form['disabled_edit']) || (!$edit_mode && $form['disabled_create'])) disabled @endif>
        <div class="dropzone dropzone-multi" id="dropzone-{{ $key }}">
            <div class="d-flex align-items-center">
                <div class="dropzone-panel mb-lg-0 mb-2 mr-2">
                    <a class="dropzone-select btn btn-light-primary font-weight-bold btn-sm" onclick="onAttachFilesClick('{{ $key }}')">Attach image</a>
                </div>
                @if ($edit_mode && !$form['hidden_value'] && isset($model[$key]) && $model[$key])
                    <div class="dropzone-panel mb-lg-0 mb-2">
                        <a class="dropzone-select btn btn-light-danger font-weight-bold btn-sm" onclick="return confirm('Are you sure?') || event.stopImmediatePropagation();" wire:click.prevent="removeFile">Remove image</a>
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
        @if ($edit_mode && !$form['hidden_value'] && isset($model[$key]) && $model[$key])
            <div class="image-input image-input-outline mt-2">
                <div class="image-input-wrapper">
                    <img src="{{ getStorageUrl($model[$key . '_path'], $model[$key]) }}" class="img-thumbnail" alt="">
                </div>
            </div>
        @endif
        @error($key)
            <span class="form-text text-danger font-weight-bold">{{ $message }}</span>
        @endError
    </div>
</div>
