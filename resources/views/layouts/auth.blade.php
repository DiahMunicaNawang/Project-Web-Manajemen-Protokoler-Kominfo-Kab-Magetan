<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'WORLD GAMES') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo/Logo-magetan.jpg') }}">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />

    {{-- Font Awesome Icon --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Styles -->
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
        type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.bundle.css') }}">

    {{-- Global css --}}
    <link rel="stylesheet" href="{{ asset('assets/plugins/global/plugins.bundle.css') }}">

    <style>
        .dt-buttons>* {
            display: none;
        }

        .image {
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .image img {
            width: 50%;
            height: 50%;
        }

        .img-hover-zoom {
            overflow: hidden;
        }

        .img-hover-zoom img {
            transition: transform 0.3s ease;
        }

        .img-hover-zoom:hover img {
            transform: scale(1.1);
        }
    </style>
    @stack('css')
</head>

<body id="kt_app_body" data-kt-app-layout="light-sidebar" data-kt-app-header-fixed="true"
    data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-minimize="on"
    data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true"
    data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">

    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <!--begin::Page-->
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
            <!--begin::Header-->
            <!--begin::Wrapper-->
            @yield('content')
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Page-->

    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>

    @stack('scripts')
</body>

</html>
