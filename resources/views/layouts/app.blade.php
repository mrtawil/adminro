<!DOCTYPE html>
<html lang="en">

<head>
    <base href="../../../">
    <meta charset="utf-8" />
    <title>{{ config('app.name') }}</title>
    <meta name="description" content="{{ config('app.name') }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet" />
    <link href='{{ URL::asset('vendor/adminro/plugins/plugins.bundle.css') }}' rel='stylesheet' type='text/css' />
    <link href='{{ URL::asset('vendor/adminro/css/style.bundle.css') }}' rel='stylesheet' type='text/css' />
    <link href='{{ URL::asset('vendor/adminro/css/header-base-light.css') }}' rel='stylesheet' type='text/css' />
    <link href='{{ URL::asset('vendor/adminro/css/header-menu-light.css') }}' rel='stylesheet' type='text/css' />
    <link href='{{ URL::asset('vendor/adminro/css/brand-dark.css') }}' rel='stylesheet' type='text/css' />
    <link href='{{ URL::asset('vendor/adminro/css/aside-dark.css') }}' rel='stylesheet' type='text/css' />
    <link href='{{ URL::asset('vendor/adminro/css/custom.css') }}' rel='stylesheet' type='text/css' />
    <link href="{{ URL::asset('favicon.ico') }}" rel="shortcut icon">
</head>

<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
    <div class="d-flex flex-column flex-root">
        @yield('content')
    </div>

    <script>
        var REDIRECT_URL = @json(session('redirect_url'));
    </script>
    <script src='{{ URL::asset('vendor/adminro/plugins/plugins.bundle.js') }}'></script>
    <script src='{{ URL::asset('vendor/adminro/js/pages/admin.js') }}'></script>
    <script src='{{ URL::asset('vendor/adminro/js/scripts.bundle.js') }}'></script>
</body>

</html>
