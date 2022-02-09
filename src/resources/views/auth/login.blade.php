@extends('adminro::layouts.app')

@section('content')
    <div class="login login-1 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white" id="kt_login">
        @include('adminro::includes.auth.aside')

        <div class="login-content flex-row-fluid d-flex flex-column justify-content-center position-relative overflow-hidden p-7 mx-lg-auto">
            <div class="d-flex flex-column-fluid flex-center">
                <div class="login-form login-signin">
                    <form action="{{ route('login') }}" method="POST" class="form" novalidate="novalidate" id="kt_login_signin_form">
                        @csrf
                        @include('adminro::includes.dashboard.alerts')
                        <div class="pb-5 pt-lg-0 pt-5">
                            <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h3-lg">Welcome to <span class="text-danger">{{ config('app.name') }}</span></h3>
                            @if (Route::has('register'))
                                <span class="text-muted font-weight-bold font-size-h4">New Here? <a href="{{ route('register') }}" class="text-primary font-weight-bolder">Create an Account</a></span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label class="font-size-h6 font-weight-bolder text-dark">Email</label>
                            <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg" type="text" name="email" autocomplete="off" />
                        </div>

                        <div class="form-group">
                            <div class="d-flex justify-content-between mt-n5">
                                <label class="font-size-h6 font-weight-bolder text-dark pt-5">Password</label>

                                @if (Route::has('reset'))
                                    <a href="{{ route('password.request') }}" class="text-primary font-size-h6 font-weight-bolder text-hover-primary pt-5">
                                        Forgot Password ?
                                    </a>
                                @endif
                            </div>

                            <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg" type="password" name="password" autocomplete="off" />
                        </div>

                        <div class="form-group">
                            <label class="checkbox">
                                <input type="checkbox" checked="checked" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} />
                                <span></span>
                                Remember Me
                            </label>
                        </div>

                        <div class="pb-lg-0 pb-5">
                            <button type="submit" id="kt_login_signin_submit" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3">Sign In</button>
                        </div>
                    </form>
                </div>
            </div>
            @include('adminro::includes.auth.footer')
        </div>
    </div>
@endsection
