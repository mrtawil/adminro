<!DOCTYPE html>
<html lang='en'>

<head>
    <base href='../../'>
    <meta charset='utf-8' />
    <title>{{ config('app.name') }}</title>
    <meta name='description' content='{{ config('app.name') }}' />
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no' />

    <link href='https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700' rel='stylesheet' />
    <link href='https://cdn.jsdelivr.net/gh/mrtawil/adminro-assets/plugins/plugins.bundle.css' rel='stylesheet' type='text/css' />
    <link href='https://cdn.jsdelivr.net/gh/mrtawil/adminro-assets/css/style.bundle.css' rel='stylesheet' type='text/css' />
    <link href='https://cdn.jsdelivr.net/gh/mrtawil/adminro-assets/css/theme.css' rel='stylesheet' type='text/css' />
    <link href='https://cdn.jsdelivr.net/gh/mrtawil/adminro-assets/favicon.png' rel='shortcut icon'>
    <link href='{{ URL::asset('vendor/adminro/assets/css/custom.css') }}' rel='stylesheet' type='text/css'>
    @livewireStyles
    @yield('head')
    @stack('head')
</head>

<body id='kt_body' class='header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading'>
    <div id='app'>
        @include('adminro::includes.dashboard.header-mobile')
        @include('adminro::includes.dashboard.aside')
        <div class='wrapper' id='kt_wrapper'>
            @include('adminro::includes.dashboard.header')
            <div class='content' id='kt_content'>
                @include('adminro::includes.dashboard.subheader')
                <div class='container-fluid'>
                    @include('adminro::includes.dashboard.alerts')
                    @yield('content')
                </div>
            </div>
            @include('adminro::includes.dashboard.footer')
        </div>
    </div>

    @include('adminro::includes.dashboard.user-panel')
    @include('adminro::includes.dashboard.scroll-to-top')

    <script>
        var HOST_URL = 'https://preview.keenthemes.com/metronic/theme/html/tools/preview';
        var REDIRECT_URL = @json(session('redirect_url'));
    </script>
    <script src='https://cdn.jsdelivr.net/gh/mrtawil/adminro-assets/plugins/plugins.bundle.js'></script>
    <script src='https://cdn.jsdelivr.net/gh/mrtawil/adminro-assets/js/scripts.bundle.js'></script>
    <script src='https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}'></script>
    <script src='{{ URL::asset('vendor/adminro/assets/js/utils/helpers.js') }}'></script>
    <script src='{{ URL::asset('vendor/adminro/assets/js/pages/admin.js') }}'></script>
    @livewireScripts
    @yield('scripts')
    @stack('scripts')
</body>

</html>
