<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('owlcarousel/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('owlcarousel/owl.theme.default.min.css') }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/master1.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <style>
    .dashboard-h4{

        color:white;
        margin-bottom: 50px;
    }
        .dashboard-box{
            text-align: center !important;
            background-color: white !important;
            padding: 50px !important;
            margin-bottom: 20px !important;
        }

        .dashboard-numbers{
            font-weight: bold !important;
            font-size: 30pt !important;
            color: black !important;
        }

        .dashboard-container{

            background: #002450;
        }
    </style>
</head>

<body>
<div id="app"> 
    <nav class="navbar navbar-default navbar-static-top" style="background-color: #ebebeb !important;">
        <div class="container-fluid">
            <div class="navbar-header">

                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" style="float:right;">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <a class="navbar-brand" href="{{ url('getDashBoardPage') }}">
                    <img class="navbar-brand-img" src="{{url('/img/logo/logo.png')}}" />
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    @if (Auth::guest())
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="{{ route('register') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
                
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Categories
                        <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                          <li><a href="{{ url('getCategoryPage') }}">Manage Categories</a></li>
                          <li><a href="{{ url('getSubCategoryPage') }}">Manage SubCategories</a></li>
                          <li><a href="{{ url('getPackagePage') }}">Manage Package</a></li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Field
                        <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                          <li><a href="{{ url('getFormFieldPage') }}">Manage Field</a></li>
                          <li><a href="{{ url('getFormFieldOptionPage') }}">Manage Field Option</a></li>
                          <li><a href="{{ url('getShareFormFieldPage') }}">Manage Field Sharing</a></li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">User
                        <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                          <li><a href="{{ url('getUserPage') }}">Manage User</a></li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Ads
                        <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                          <li><a href="{{ url('getAdsPage') }}">Manage Ads</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Voucher
                        <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                          <li><a href="{{ url('getVoucherPage') }}">Voucher</a></li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Localization
                        <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                          <li><a href="{{ url('getTranslationPage') }}">Manage Translation</a></li>
                          <li><a href="{{ url('getCurrencyPage') }}">Manage Currencies</a></li>
                        </ul>
                    </li>
                </ul>

            </div>
        </div>
    </nav>
    @yield('content')
</div>

    <!-- Scripts -->
    <script type="text/javascript" src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script type="text/javascript" src="//cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('js/userPage.js') }}"></script>
    <script src="{{ asset('js/categoryPage.js') }}"></script>
    <script src="{{ asset('js/subCategoryPage.js') }}"></script>
    <script src="{{ asset('js/FormFieldPage.js') }}"></script>
    <script src="{{ asset('js/FormFieldOptionPage.js') }}"></script>
    <script src="{{ asset('js/TranslationPage.js') }}"></script>
    <script src="{{ asset('js/AdsPage.js') }}"></script>
    <script src="{{ asset('js/Currency.js') }}"></script>

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        $( ".datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
      });
    </script>

</body>
</html>
