<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css_frontend/app_frontend.css') }}" rel="stylesheet">
</head>
<body>
<div class="wrapper">
    <div class="w-100 text-center links">
        <div class="brand-link auth mx-auto px-0 py-2">
            <a href="/">
                <img src="/image/Coolinary_Logo_rgb.png" alt="MyFoodOrder>" class="mt-0">
            </a>
        </div>
        @guest
            <a class="auth-link brand-color-second" href="{{ route('login') }}">{{ __('user.Login') }}</a>
        @else

            <a id="navbarDropdown" class="auth-link brand-color-second nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                {{ Auth::user()->userInfo->full_name ?? Auth::user()->email }}
            </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a href="{{ route('profile.index') }}" class="dropdown-item mb-2">@lang('user.Profile')</a>
                <a class="brand-color-second dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    {{ __('user.Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>

        @endguest
    </div>
    <div class="content-wrapper" style="background-image: url('/image/ella-olsson-4dQiaWKiL-Y-unsplash-min.jpg'); background-size: cover;">
        @yield('content')
    </div>
    @include('footer')
</div>
</body>
@yield('js')
</html>
