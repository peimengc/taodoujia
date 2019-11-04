<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        .c-dgray {
            color: #b3b3b3;
        }

        .c-blue {
            color: #3490dc;
        }

        .font08 {
            font-size: 0.8rem;
        }

        .font10 {
            font-size: 1rem;
        }

        .font15 {
            font-size: 1.5rem;
        }

        .table-data tbody tr td {
            color: #333333;
            vertical-align: middle;
            word-break: keep-all;
            white-space:nowrap;
        }

        .thum-box img {
            height: 3.5rem;
            width: 3.5rem;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<div id="app">
    <nav class="navbar sticky-top navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">
                    @auth
                        <li class="nav-item dropdown">
                            <a id="taobaoDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                淘宝联盟 <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="taobaoDropdown">
                                <a class="dropdown-item" href="{{ route('tbkAuthorizes.index') }}">
                                    联盟授权
                                </a>
                                <a class="dropdown-item" href="{{ route('tbkOrders.index') }}">
                                    联盟订单
                                </a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a id="douTopDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                DOU+统计 <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="douTopDropdown">
                                <a class="dropdown-item" href="{{ route('douAccounts.index') }}">
                                    带货账号
                                </a>
                                <a class="dropdown-item" href="{{ route('douTopTasks.index') }}">
                                    投放任务
                                </a>
                            </div>
                        </li>
                    @endauth
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a id="userDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
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

        @include('components.alert')

        @yield('content')
    </main>
</div>
</body>
</html>
