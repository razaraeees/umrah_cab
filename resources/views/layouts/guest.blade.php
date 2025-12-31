<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Bootstrap Css -->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ asset('assets/css/app.css') }}" id="app-style" rel="stylesheet" type="text/css" />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="auth-body-bg">
        <div class="home-btn d-none d-sm-block">
            <a href="/"></a>
        </div>
        <div class="account-pages my-5 pt-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-center justify-content-center mt-4">
                                    <div class="mb-1">
                                        <a href="/" wire:navigate class="d-flex justify-content-center align-items-center">
                                            <img src="{{ asset('assets/images/umrah_cap_auth.png') }}" alt=""  class="auth-logo logo-dark text-center">
                                            <img src="{{ asset('assets/images/umrah_cap_auth.png') }}" alt=""  class="auth-logo logo-light text-center">
                                        </a>
                                    </div>
                                </div>
                                <div class="p-3">
                                    {{ $slot }}
                                </div>
                            </div>
                        </div>
                        <div class="mt-5 text-center">
                            @if(request()->routeIs('password.request') || request()->routeIs('password.reset'))
                                <p>Remember It ? <a href="{{ route('login') }}" class="fw-bold text-primary" wire:navigate> Sign In Here </a> </p>
                            @elseif(request()->routeIs('register'))
                                <p>Already registered? <a href="{{ route('login') }}" class="fw-bold text-primary" wire:navigate> Sign In Here </a> </p>
                            @endif
                            {{-- <p>© {{ date('Y') }} {{ config('app.name', 'Laravel') }}. Crafted with <i class="mdi mdi-heart text-danger"></i></p> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- JAVASCRIPT -->
        <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
        <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
        <script src="{{ asset('assets/js/app.js') }}"></script>
    </body>
</html>
