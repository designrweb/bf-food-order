@extends('layouts.frontend')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-4 auth">
                    <h5 class="card-header">{{ __('user.Login') }}</h5>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group">
                                <label for="email" class="cols-sm-2 control-label">{{ __('user.Email') }}</label>

                                <div class="cols-sm-10">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password" class="cols-sm-2 control-label">{{ __('user.Password') }}</label>

                                <div class="cols-sm-10">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('user.Remember me next time') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-12 offset-md-12">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        {{ __('user.Login') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
{{--                        <p class="text-center">--}}
{{--                            <a href="{{ route('verification.resend') }}" class="brand-color">{{ __('Didn\'t receive confirmation message?') }}</a>--}}
{{--                        </p>--}}
                        <p class="text-center">
                            <a href="{{route('register')}}" class="brand-color">{{ __('user.Don\'t have an account? Sign up!') }}</a>
                        </p>
                        <p class="text-center">
                            <a href="{{ route('password.request') }}" class="brand-color">{{ __('user.Forgot password?') }}</a>
                        </p>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
