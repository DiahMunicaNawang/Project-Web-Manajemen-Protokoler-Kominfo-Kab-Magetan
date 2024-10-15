@extends('layouts.auth')

@section('content')
    <div class="d-flex flex-column-fluid bg-orange bg-gradient justify-content-center bg-light p-12 p-lg-20">
        <!--begin::Card-->
        <div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10">
            <!--begin::Wrapper-->
            <div class="d-flex flex-center flex-column flex-column-fluid px-lg-10 pb-15 pb-lg-20">
                <!--begin::Aside-->
                <div class="d-flex flex-center flex-lg-start flex-column mb-10">
                    <div class="d-flex align-items-center justify-content-around rounded-4">
                        <img class="w-25 rounded-4 bg-white" loading="lazy" src="{{ asset('images/logo/Logo-magetan.jpg') }}"
                            alt="City">

                        <!--begin::Heading-->
                        <div class="mb-11">
                            <!--begin::Title-->
                            <h1 class="text-gray-900 fw-bolder mb-3">
                                Boutique GELO
                            </h1>
                            <!--end::Title-->

                            <!--begin::Subtitle-->
                            <div class="text-gray-500 fw-semibold fs-6">
                                Indonesian Traditional Cloth
                            </div>
                            <!--end::Subtitle--->
                        </div>
                        <!--begin::Heading-->
                    </div>
                </div>
                <!--begin::Aside-->

                <!--begin::Form-->
                <form class="form w-100 fv-plugins-bootstrap5 fv-plugins-framework" method="POST" action="{{ route('register') }}" autocomplete="off">
                    @csrf

                    <!--begin::Input group--->
                    <div class="fv-row mb-8 fv-plugins-icon-container">
                        <label for="name" class="form-label">Name</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                            name="name" value="{{ old('name') }}" placeholder="Name" required autocomplete="name" autofocus>
                    
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                    <div class="fv-row mb-8 fv-plugins-icon-container">
                        <label for="email" class="form-label">Email</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" placeholder="Email@gmail.com" required autocomplete="email">
                    
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                    <div class="fv-row mb-8 fv-plugins-icon-container">
                        <label for="balance" class="form-label">Balance</label>
                        <input id="balance" type="number" class="form-control @error('balance') is-invalid @enderror"
                            name="balance" value="{{ old('balance') }}" placeholder="Balance" required autocomplete="balance">
                    
                        @error('balance')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                    <div class="fv-row mb-8 fv-plugins-icon-container">
                        <label for="phone" class="form-label">Phone</label>
                        <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror"
                            name="phone" value="{{ old('phone') }}" placeholder="Phone" required autocomplete="phone">
                    
                        @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                    <div class="fv-row mb-8 fv-plugins-icon-container">
                        <label for="address" class="form-label">Address</label>
                        <input id="address" type="text" class="form-control @error('address') is-invalid @enderror"
                            name="address" value="{{ old('address') }}" placeholder="Address" required autocomplete="address">
                    
                        @error('address')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                    <div class="fv-row mb-8 fv-plugins-icon-container">
                        <label for="gender" class="form-label">Gender</label>
                        <select id="gender" class="form-control @error('gender') is-invalid @enderror" name="gender" required autocomplete="gender">
                            <option value="" disabled selected>Gender</option>
                            <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki Laki</option>
                            <option value="P" {{ old('gender') == 'female' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    
                        @error('gender')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                    <!-- Password Input -->
                    <div class="fv-row mb-8 fv-plugins-icon-container">
                        <label for="password" class="form-label">Password</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                            placeholder="Password" name="password" required autocomplete="current-password">
                    
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                    <!--begin::Submit button-->
                    <div class="d-grid mb-10">
                        <button type="submit" id="kt_sign_in_submit" class="btn btn-dark" pb-role="submit">

                            <!--begin::Indicator label-->
                            <span class="indicator-label">
                                Daftar</span>
                            <!--end::Indicator label-->

                            <!--begin::Indicator progress-->
                            <span class="indicator-progress">
                                Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                            <!--end::Indicator progress--> </button>
                    </div>
                    <!--end::Submit button-->

                    <div class="text-gray-500 text-center fw-semibold fs-6">
                        Sudah memiliki akun?

                        <a href="/login" class="link-primary">
                            Login sekarang
                        </a>
                    </div>
                </form>
                <!--end::Form-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Card-->
    </div>
@endsection
