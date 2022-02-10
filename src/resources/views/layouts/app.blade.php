<!DOCTYPE html>
<html lang="en">

<head>
    <base href="../../../">
    <meta charset="utf-8" />
    <title>{{ config('app.name') }}</title>
    <meta name="description" content="{{ config('app.name') }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <link href='https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700' rel='stylesheet' />
    <link href='https://cdn.jsdelivr.net/gh/mrtawil/adminro-assets/plugins/plugins.bundle.css' rel='stylesheet' type='text/css' />
    <link href='https://cdn.jsdelivr.net/gh/mrtawil/adminro-assets/css/style.bundle.css' rel='stylesheet' type='text/css' />
    <link href='https://cdn.jsdelivr.net/gh/mrtawil/adminro-assets/css/theme.css' rel='stylesheet' type='text/css' />
    <link href='https://cdn.jsdelivr.net/gh/mrtawil/adminro-assets/favicon.png' rel='shortcut icon'>
</head>

<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
    <div class="d-flex flex-column flex-root">
        @yield('content')
    </div>

    <script>
        var HOST_URL = 'https://preview.keenthemes.com/metronic/theme/html/tools/preview';
        var REDIRECT_URL = @json(session('redirect_url'));
    </script>
    <script src='https://cdn.jsdelivr.net/gh/mrtawil/adminro-assets/plugins/plugins.bundle.js'></script>
    <script src='https://cdn.jsdelivr.net/gh/mrtawil/adminro-assets/js/scripts.bundle.js'></script>
    <script src='{{ URL::asset('vendor/adminro/assets/js/pages/admin.js') }}'></script>
    <script src='{{ URL::asset('vendor/adminro/assets/js/utils/helpers.js') }}'></script>
</body>

</html>
