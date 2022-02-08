@extends('adminro::layouts.app')

@section('content')
    <div class="login login-1 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white" id="kt_login">
        @include('adminro::includes.auth.aside')

        <div class="login-content flex-row-fluid d-flex flex-column justify-content-center position-relative overflow-hidden p-7 mx-lg-auto">
            <div class="d-flex flex-column-fluid flex-center">
                <div class="login-form login-signin">
                    <form action="{{ route('password.update') }}" method="POST" class="form" novalidate="novalidate" id="kt_login_signin_form">
                        @csrf
                        @include('adminro::includes.dashboard.alerts')
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="pb-5 pt-lg-0 pt-5">
                            <h3 class="font-weight-bolder text-danger font-size-h4 font-size-h3-lg">Reset Your Password</h3>
                        </div>

                        <div class="form-group">
                            <label class="font-size-h6 font-weight-bolder text-dark">Email</label>
                            <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg  @error('email') is-invalid @enderror" type="text" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus />

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="d-flex justify-content-between mt-n5">
                                <label class="font-size-h6 font-weight-bolder text-dark pt-5">Password</label>
                            </div>
                            <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg" type="password" name="password" autocomplete="off" />

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="font-size-h6 font-weight-bolder text-dark pt-5">{{ __('Confirm Password') }}</label>
                            <input id="password-confirm" type="password" class="form-control form-control-solid h-auto py-7 px-6 rounded-lg" name="password_confirmation" required autocomplete="new-password">
                        </div>

                        <div class="pb-lg-0 pb-5">
                            <button type="submit" id="kt_login_signin_submit" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3">{{ __('Reset Password') }}</button>
                        </div>
                    </form>
                </div>
            </div>
            @include('adminro::includes.auth.footer')
        </div>
    </div>
@endsection
