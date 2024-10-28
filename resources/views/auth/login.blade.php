@extends('layouts.auth')

@section('content')
    <div class="d-flex flex-column flex-lg-row flex-column-fluid">
        <!--begin::Body-->
        <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">
            <!--begin::Form-->
            <div class="d-flex flex-center flex-column flex-lg-row-fluid">
                <!--begin::Wrapper-->
                <div class="w-lg-500px p-10">

                    <form class="form w-100 fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate"
                        id="kt_sign_in_form" data-kt-redirect-url="/" method="POST" action="{{ route('login') }}"
                        pb-autologin="true" autocomplete="off">
                        @csrf

                        <!--begin::Heading-->
                        <div class="text-center mb-11">
                            <!--begin::Title-->
                            <h1 class="text-gray-900 fw-bolder mb-1">
                                Si<span style="color: #49BECB;">Cantik</span>
                            </h1>
                            <!--end::Title-->

                            <!--begin::Subtitle-->
                            <div class="text-gray-500 fw-semibold fs-6">
                                Masukkan Email dan Password Anda
                            </div>
                            <!--end::Subtitle--->
                        </div>
                        <!--begin::Heading-->
                        
                        <!--begin::Input group--->
                        <div class="fv-row mb-8 fv-plugins-icon-container">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" placeholder="Email@gmail.com" required
                                autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <!--end::Input group-->

                        {{-- begin::password --}}
                        <div class="fv-row mb-8 fv-plugins-icon-container">
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" placeholder="Password"
                                name="password" required autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        {{-- end::password --}}

                        <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                            <div></div>

                            <!--begin::Link-->
                            <a href="#"
                                class="link-primary">
                                Lupa Password ?
                            </a>
                            <!--end::Link-->
                        </div>
                        <!--end::Wrapper-->

                        <!--begin::Submit button-->
                        <div class="d-grid mb-10">
                            <button type="submit" id="kt_sign_in_submit" class="btn btn-primary" pb-role="submit">

                                <!--begin::Indicator label-->
                                <span class="indicator-label">
                                    Login</span>
                                <!--end::Indicator label-->

                                <!--begin::Indicator progress-->
                                <span class="indicator-progress">
                                    Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                                <!--end::Indicator progress--> </button>
                        </div>
                        <!--end::Submit button-->
                    </form>
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Form-->
        </div>
        <!--end::Body-->

        <!--begin::Aside-->
        <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2"
            style="background-image: linear-gradient(to bottom, #49BECB, #245E65)">
            <!--begin::Content-->
            <div class="d-flex flex-column flex-center py-7 py-lg-15 px-5 px-md-15 w-100">
                <!--begin::Logo-->
                <a href="#" class="mb-0 mb-lg-12 d-flex gap-5 align-items-center">
                    <img alt="Logo" src="{{ asset('images/logo/Logo-magetan.png') }}" class="h-60px h-lg-80px rounded">
                </a>
                <!--end::Logo-->

                <!--begin::Image-->
                    <img style="height: 320px" src="{{ asset('assets/media/misc/auth-screens.png') }}" alt="" class="d-none d-lg-block mb-0 mb-lg-6">
                <!--end::Image-->

                <!--begin::Title-->
                <h1 class="d-none d-lg-block text-white fs-1 fw-semibold text-center mb-1">
                    SiCantik Platform Pengelolaan Kegiatan Pimpinan
                </h1>
                <!--end::Title-->

                <!--begin::Text-->
                <div class="d-none d-lg-block text-white fs-5 text-center">
                    Sistem Manajemen Acara ini mempermudah pengelolaan informasi kegiatan pimpinan, termasuk jadwal, penyimpanan undangan, dan riwayat kegiatan, untuk meningkatkan efisiensi dalam pengelolaan acara.
                </div>
                <!--end::Text-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Aside-->
    </div>
@endsection
