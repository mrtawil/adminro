@extends('adminro::layouts.admin')

@section('head')
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/gh/mrtawil/adminro-assets/plugins/multiselect/css/multi-select.css' type='text/css' />

    @isset($dataTable)
        <link href='https://cdn.jsdelivr.net/gh/mrtawil/adminro-assets/plugins/datatables/datatables.bundle.css' rel='stylesheet' type='text/css' />
    @endisset
@endsection

@section('content')
    @include('adminro::includes.dashboard.modals.modalLarge1')
    @if ($controllerSettings->info()->projectDetails())
        @include('adminro::includes.dashboard.project-details', ['projectDetails' => $controllerSettings->info()->projectDetails()])
    @endif

    @if ($controllerSettings->info()->cardToolbar())
        @include('adminro::includes.dashboard.card-toolbar', ['cardToolbar' => $controllerSettings->info()->cardToolbar()])
    @endif

    <div class="row">
        @isset($dataTable)
            <div class="col">
                @include('adminro::includes.dashboard.datatables.datatable', ['dataTable' => $dataTable])
            </div>
        @endisset

        <div class="col">
            @include('adminro::includes.dashboard.utils.create_abstract', ['controllerSettings' => $controllerSettings])
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const old = @json(old());
        const formFields = @json($controllerSettings->formFields()->attributes());
        const item = null;
    </script>

    <script src='https://cdn.jsdelivr.net/gh/mrtawil/adminro-assets/plugins/multiselect/js/jquery.multi-select.js'></script>
    <script src='https://cdn.jsdelivr.net/gh/mrtawil/adminro-assets/plugins/multiselect/js/jquery.quicksaerch.js'></script>
    <script src='https://cdn.jsdelivr.net/gh/mrtawil/adminro-assets/plugins/select2/js/select2.full.min.js'></script>

    <script src='{{ URL::asset('vendor/adminro/assets/js/utils/modals.js') }}'></script>
    <script src='{{ URL::asset('vendor/adminro/assets/js/utils/form-utils.js') }}'></script>

    @isset($dataTable)
        {{ $dataTable->scripts() }}

        <script>
            const dataTable = @json($dataTable);
            const status = @json(Adminro\Constants\Constants::STATUS);
        </script>
        <script src='https://cdn.jsdelivr.net/gh/mrtawil/adminro-assets/plugins/datatables/datatables.bundle.js'></script>
        <script src='https://cdn.jsdelivr.net/gh/mrtawil/adminro-assets/plugins/datatables/buttons.server-side.js'></script>
        <script src='{{ URL::asset('vendor/adminro/assets/js/utils/datatables-forms.js') }}'></script>
    @endisset

    @foreach ($controllerSettings->info()->scriptFiles() as $script_file)
        <script src='{{ $script_file }}'></script>
    @endforeach

    @foreach (collect($controllerSettings->formFields()->forms())->where('type', 'addition') as $form)
        @if ($form->scriptPath())
            <script src='{{ $form->scriptPath() }}'></script>
        @endif
    @endforeach
@endsection
