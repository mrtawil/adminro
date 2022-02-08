@extends('adminro::layouts.admin')

@section('head')
    @isset($dataTable)
        <link href='{{ URL::asset('vendor/adminro/plugins/datatables/datatables.bundle.css') }}' rel='stylesheet' type='text/css' />
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

    @isset($dataTable)
        @include('adminro::includes.dashboard.datatables.datatable', ['dataTable' => $dataTable])
    @endisset
@endsection

@section('scripts')
    <script src='{{ URL::asset('vendor/adminro/js/utils/modals.js') }}'></script>

    @isset($dataTable)
        {{ $dataTable->scripts() }}

        <script>
            const dataTable = @json($dataTable);
        </script>
        <script src='{{ URL::asset('vendor/adminro/plugins/datatables/datatables.bundle.js') }}'></script>
        <script src='{{ URL::asset('vendor/adminro/plugins/datatables/buttons.server-side.js') }}'></script>
        <script src='{{ URL::asset('vendor/adminro/js/utils/datatables-forms.js') }}'></script>
    @endisset

    @foreach ($controllerSettings->info()->scriptFiles() as $script_file)
        <script src='{{ $script_file }}'></script>
    @endforeach
@endsection
