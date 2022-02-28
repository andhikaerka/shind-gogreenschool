<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{--<!-- CSRF Token -->--}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    {{--<!-- Fonts -->--}}
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    {{--<!-- Font Awesome -->--}}
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    {{--<!-- Styles -->--}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('styles')
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('img/shind.png') }}" height="30" alt="" loading="lazy">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                @if(request()->route()->getName() == 'school')
                    <span
                        class="navbar-text">Pengelolaan & Perlindungan Lingkungan Hidup di Sekolah Sistem Online</span>
                @endif
                {{--<!-- Left Side Of Navbar -->--}}
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    @if(request()->route()->getName() == 'home')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">{{ __('global.home') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}#program">Program</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}#schools">Sekolah Mitra</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}#contact">Kontak Kami</a>
                        </li>
                    @endif
                    {{--<!-- Authentication Links -->--}}
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('global.login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('global.register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                @if(auth()->user()->isAdmin)
                                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        {{ __('global.dashboard') }}
                                    </a>
                                @elseif(auth()->user()->isSTC)
                                    <a class="dropdown-item"
                                       href="{{ route('school.dashboard', ['school_slug' => auth()->user()->school_slug]) }}">
                                        {{ __('global.dashboard') }}
                                    </a>
                                @endif
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @if(session('message'))
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="alert alert-success" role="alert">
                            {{ session('message') }}
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <div class="container">
        <div class="row" id="contact">
            <div class="col">
                <div class="d-flex justify-content-start">
                    <img src="{{ asset('img/gogreenschool.png') }}" alt="" class="mr-5 img-fluid" style="height: 92px;">
                    <img src="{{ asset('img/banksampah.png') }}" alt="" class="mr-5 img-fluid" style="height: 92px;">
                </div>
            </div>
            <div class="col ">
                <p class="">
                    copyright (c) 2020 by Shind Jogia <br>
                    www.shind.or.id <br>
                    www.gogreenschool.org <br>
                    www.banksampah.online
                </p>
            </div>
            <div class="col">
                <div class="d-flex justify-content-start">
                    <ul class="list-unstyled mr-4">
                        <li class="media" style="align-items: center;">
                            <img src="{{ asset('img/gmail.svg') }}" class="mr-2 img-fluid" alt="..."
                                 style="height: 36px;">
                            <div class="media-body">
                                adm@shind.or.id
                            </div>
                        </li>
                        <li class="media my-4" style="align-items: center;">
                            <img src="{{ asset('img/youtube.svg') }}" class="mr-2 img-fluid" alt="..."
                                 style="height: 36px;">
                            <div class="media-body">
                                shindjogja
                            </div>
                        </li>
                    </ul>
                    <ul class="list-unstyled">
                        <li class="media" style="align-items: center;">
                            <img src="{{ asset('img/facebook.svg') }}" class="mr-2 img-fluid" alt="..."
                                 style="height: 36px;">
                            <div class="media-body">
                                gogreenschool
                            </div>
                        </li>
                        <li class="media my-4" style="align-items: center;">
                            <img src="{{ asset('img/whatsapp.svg') }}" class="mr-2 img-fluid" alt="..."
                                 style="height: 36px;">
                            <div class="media-body">
                                081903888583
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

{{--<!-- Scripts -->--}}
<script src="{{ asset('js/app.js') }}"></script>
@yield('scripts')
</body>
</html>
