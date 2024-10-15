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

    <link rel="stylesheet" href="{{ asset('assets/css/style.bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.bundle.css') }}">

    {{-- Owl Css --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

    {{-- Splide Css --}}
    <link href="
https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css
" rel="stylesheet">

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

<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
    <!--begin::Page-->
    <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
        <!--begin::Wrapper-->
        <div class="app-wrapper flex-column flex-row-fluid" style="background: url('{{asset('images/banners/background-yellow-blue.jpg')}}') no-repeat center center; background-size: cover;">
            <!--begin::Main-->
            <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                <div id="kt_app_content" class="app-content flex-column-fluid">
                    <!--begin::Content container-->
                    <div id="kt_app_content_container">
                        @yield('content')
                    </div>
                    <!--end::Products-->
                </div>
                <!--end::Footer-->
            </div>
            <!--end:::Main-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Page-->
</div>
{{-- script --}}
<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>
<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
<script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
{{-- Slider Js --}}
<script src="
                    https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js
                    "></script>
{{-- Jquery --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="
https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js
"></script>
@stack('scripts')
</body>

</html>
