@php $table_select = isset($data['table_select'][$key]) ? $data['table_select'][$key] : null; @endphp
@if ($table_select)
    <div class="col-md-12 {{ $form->className() }}" data-label="container_{{ $key }}">
        <div class="form-group">
            <div class="row">
                <div class="col-md-{{ $form->column() }} {{ $form->className() }}">
                    <table class="table table-bordered table-hover table-checkable" id="table_select_{{ $key }}">
                        <thead>
                            <tr>
                                @foreach ($table_select['columns'] as $column)
                                    <th>{{ $column['displayName'] }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                @foreach ($table_select['columns'] as $column)
                                    <th>{{ $column['displayName'] }}</th>
                                @endforeach
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="col-md-{{ $form['columnResults'] }} {{ $form->className() }} mt-5 mt-md-0">
                    <table class="table table-bordered table-hover table-checkable" id="table_select_results_{{ $key }}">
                        <thead>
                            <tr>
                                @foreach ($table_select['columns_result'] as $column)
                                    <th>{{ $column['displayName'] }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                @foreach ($table_select['columns_result'] as $column)
                                    <th>{{ $column['displayName'] }}</th>
                                @endforeach
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endif
