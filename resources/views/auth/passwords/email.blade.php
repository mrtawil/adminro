@extends('adminro::layouts.app')

@section('content')
    <div class="login login-1 login-forgot-on d-flex flex-column flex-lg-row flex-column-fluid bg-white" id="kt_login">
        @include('adminro::includes.auth.aside')

        <div class="login-content flex-row-fluid d-flex flex-column justify-content-center position-relative overflow-hidden p-7 mx-auto">
            <div class="d-flex flex-column-fluid flex-center">
                <div class="login-form login-forgot">
                    <form action="{{ route('password.email') }}" method="POST" class="form" novalidate="novalidate" id="kt_login_forgot_form">
                        @csrf
                        @include('adminro::includes.dashboard.alerts')
                        <div class="pb-13 pt-lg-0 pt-5">
                            <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">Forgotten Password ?</h3>
                            <p class="text-muted font-weight-bold font-size-h4">Enter your email to reset your password</p>
                        </div>

                        <div class="form-group">
                            <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6" type="email" placeholder="Email" name="email" autocomplete="off" value="{{ old('email') }}" />
                            @error('email')
                                <div class="font-size-h6 text-danger mt-3">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group d-flex flex-wrap pb-lg-0 align-items-center">
                            <button type="submit" id="kt_login_forgot_submit" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-4">Submit</button>
                            <span class="text-muted font-weight-bold font-size-h4">Feeling good now? <a href="{{ route('login') }}" class="text-primary font-weight-bolder">Login</a></span>
                        </div>
                    </form>
                </div>
            </div>
            @include('adminro::includes.auth.footer')
        </div>
    </div>
@endsection
