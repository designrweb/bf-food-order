@extends('layouts.frontend')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-4 auth">
                    <h5 class="card-header">{{ __('user.Login') }}</h5>

                    <div class="card-body">
                        @if (session('successfullyRegistered'))

                        @endif
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
                                <div class="cols-sm-10">
                                    <select name="" id="" class="form-control">
                                        <option value="">I want to Order a meal for myself</option>
                                        <option value="">I want to Order meal for my kid(s)</option>
                                    </select>
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
                        <p class="text-center">
                            <a href="{{ route('register') }}" class="brand-color">{{ __('user.Don\'t have an account? Sign up!') }}</a>
                        </p>
                        <p class="text-center">
                            <a href="{{ route('password.request') }}" class="brand-color">{{ __('user.Forgot password?') }}</a>
                        </p>
                        @if (session('resentUserEmail'))
                            <div class="text-center">
                                <div class="alert alert-success">
                                    {{ __('user.Before proceeding, please check your email for a verification link.') }}
                                    {{ __('user.If you did not receive the email') }},
                                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                                        @csrf
                                        <input type="hidden" name="email" value="{{ session('resentUserEmail') }}">
                                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline" style="color: #96c11f;">
                                            {{ __('user.click here to request another') }}.
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endif
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                {{ __('user.A fresh verification link has been sent to your email address.') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
