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
    <script src="{{ asset('common/js/dropdown-hover.js') }}" defer></script>

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
            white-space: nowrap;
        }

        .thum-box img {
            height: 3.5rem;
            width: 3.5rem;
            border-radius: 5px;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }
    </style>
    @stack('css')
</head>
<body style="background-color: #FFF !important">
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
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/home') }}">主页</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a id="taobaoDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-hover="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
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
                               data-hover="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                抖音DOU+ <span class="caret"></span>
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
                        <li class="nav-item dropdown">
                            <a id="douTopDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-hover="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                淘豆荚统计 <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="douTopDropdown">
                                <a class="dropdown-item" href="{{ route('taodoujia.hour') }}">
                                    时段统计
                                </a>
                                <a class="dropdown-item" href="{{ route('taodoujia.douAccount') }}">
                                    账号统计
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
                            <a id="boxDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-hover="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                工具箱 <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="boxDropdown">
                                {{--<a class="dropdown-item" data-toggle="modal" data-target="#historyTbkOrder">
                                    历史订单获取
                                </a>--}}
                                <a class="dropdown-item" href="{{ route('tbkOrders.history') }}" title="获取30天内的订单">
                                    历史订单获取（30天）
                                </a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a id="userDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-hover="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
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

    <main class="py-4" style="min-height: 80vh">

        @include('components.alert')

        @yield('content')
    </main>
    <div class="container flex-center">
        <h5>网站备案号为:晋ICP备19012668号</h5>
    </div>
</div>

<div class="modal fade" id="historyTbkOrder" tabindex="-1" role="dialog" aria-labelledby="historyTbkOrderLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="historyTbkOrderLabel">淘宝联盟历史订单获取</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary">提交</button>
            </div>
        </div>
    </div>
</div>
</body>
</html>
