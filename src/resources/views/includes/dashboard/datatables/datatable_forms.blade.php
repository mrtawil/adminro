<form class="kt-form kt-form--fit" id="kt-form">
    <div class="row">
        @foreach ($controllerSettings->dataTable()->forms() as $key => $form)
            @if ($form['type'] == 'string')
                <div class="col-md-3 mb-6">
                    <label class="text-capitalize">{{ $form['title'] }}</label>
                    <input type="text" class="form-control form-control-lg datatable-input" placeholder="string" data-col-index="{{ $loop->index }}" />
                </div>
            @elseif($form['type'] == 'int')
                <div class="col-md-3 mb-6">
                    <label class="text-capitalize">{{ $form['title'] }}</label>
                    <input type="text" class="form-control form-control-lg datatable-input" placeholder="int" data-col-index="{{ $loop->index }}" />
                </div>
            @elseif($form['type'] == 'select')
                <div class="col-md-3 mb-6">
                    <label class="text-capitalize">{{ $form['title'] }}</label>
                    <select class="form-control form-control-lg datatable-input selectpicker" data-col-index="{{ $loop->index }}" data-size="7" data-live-search="true">
                        <option value="">Select</option>
                        @foreach ($form['options'] as $option)
                            <option value="{{ $option['value'] }}">{{ $option['title'] }}</option>
                        @endforeach
                    </select>
                </div>
            @elseif($form['type'] == 'date_range')
                <div class="col-md-3 mb-6">
                    <div class="form-group mb-0">
                        <label>{{ $form['title'] }}</label>
                        <div class="input-group" id="kt_daterangepicker_{{ $key }}">
                            <input type="text" class="form-control form-control-lg datatable-input" readonly placeholder="date range" data-col-index="{{ $loop->index }}" />
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="la la-calendar-check-o"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>

    <div class="d-flex align-items-center">
        @if ($controllerSettings->actions()->search())
            <button class="btn btn-primary btn-primary--icon mr-2" id="kt_search">
                <span>
                    <i class="la la-search"></i>
                    <span>Search</span>
                </span>
            </button>
        @endif
        @if ($controllerSettings->actions()->reset())
            <button class="btn btn-secondary btn-secondary--icon mr-2" id="kt_reset">
                <span>
                    <i class="la la-close"></i>
                    <span>Reset</span>
                </span>
            </button>
        @endif
        @if ($controllerSettings->actions()->buttons())
            <div id="buttons-container"></div>
        @endif
    </div>
</form>
