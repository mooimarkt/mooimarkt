<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <title>
        {{\App\Option::getSetting("opt_seo_title") ?? 'Mooimarkt'}}
    </title>
    <meta name="description" content="{{\App\Option::getSetting("opt_seo_description") ?? 'Mooimarkt Description'}}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="/mooimarkt/assets/fancybox/jquery.fancybox.min.css"/>
    <link rel="stylesheet" type="text/css" href="/mooimarkt/assets/dropzone/dropzone.min.css"/>
    <link rel="stylesheet" type="text/css" href="/mooimarkt/assets/starability/starability-basic.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet"/>

    <link rel="stylesheet" href="/mooimarkt/css/fonts.css">
    <link rel="stylesheet" href="/mooimarkt/css/greed.css">
    <link rel="stylesheet" href="/mooimarkt/css/reset.css">
    <link rel="stylesheet" href="/mooimarkt/css/main.css?v=5">
    <link rel="stylesheet" href="/mooimarkt/css/main_anton.css">
    <link rel="stylesheet" href="/mooimarkt/css/media_anton.css">
    <link rel="stylesheet" href="/mooimarkt/css/media.css?v=2">
    <link rel="stylesheet" href="/mooimarkt/css/main_artur.css">
    <link rel="stylesheet" href="/mooimarkt/css/maryan.css">
    <link rel="stylesheet" href="/mooimarkt/css/alex.css">
    <link rel="stylesheet" href="/mooimarkt/css/custom.css">
    @yield('styles')
</head>
<body>
@if(auth()->check())
    <header class="header login_header">
        <div class="header_login_top_line">
            <div class="container">
                <ul>
                    <li>
                        <a href="{{ route('ads', 'published') }}">
                            @php(include ("mooimarkt/img/hlogin_top_line_icon_1.svg")) {{ Language::lang('My published items') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('ads', 'expired') }}">
                            @php(include ("mooimarkt/img/hlogin_top_line_icon_2.svg")) {{ Language::lang('expired items') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('ads', 'sold') }}">
                            @php(include ("mooimarkt/img/hlogin_top_line_icon_3.svg")) {{ Language::lang('sold items') }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="header_top_line">
            <div class="container">
               <!-- <a href="/" class="header_logo">{{ Language::lang('Mooimarkt') }}</a> -->
                <a href="/" class="header_logo"><img src="/mooimarkt/img/logo_60.jpg" alt="Mooimarkt" class="login-logo-img" /></a>
                <div class="right">
                    <div class="header_login_controls">
                        <ul class="header_login_icons_menu">
                            <li class="wallet_header_link">
                                <a href="{{ route('wallet_up') }}"><span
                                            class="text">€{{ number_format(auth()->user()->wallet, 2) }}</span>
                                    <div class="icon_wrpr wallet_icon">
                                        @php(include("mooimarkt/img/header_login_icons_1.svg"))
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('myMessage') }}">
                                    <div class="icon_wrpr notification_icon messages">
                                        <span class="unread-messages-count" {!! $unreadMessagesCount == 0 ? 'style="display: none;"' : '' !!}>
                                            {{ $unreadMessagesCount }}
                                        </span>
                                        @php(include("mooimarkt/img/header_login_icons_2.svg"))
                                    </div>
                                </a>
                            </li>

                            <li>
                                <a href="#" class="toggle-ntf">
                                    <div class="icon_wrpr notification_icon">
                                        <span class="unread-messages-count" {!! $newNotifications == 0 ? 'style="display: none;"' : '' !!}>
                                            {{ $newNotifications }}
                                        </span>
                                        @php(include("mooimarkt/img/header_login_icons_3.svg"))
                                    </div>
                                </a>
                                <div class="notifications_box">
                                    <div class="notifications_menu">
                                        <div class="notification_empty">
                                            {{ Language::lang('Notifications not found') }}
                                        </div>

                                        <div class="notifications_items"></div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <a href="{{ route('ads', 'favorites') }}">
                                    <div class="icon_wrpr">
                                        @php(include("mooimarkt/img/header_login_icons_4.svg"))
                                    </div>
                                </a>
                            </li>
                        </ul>
                        <div class="header_login_profile profile_header_link">
                            <div class="img_wrpr">
                                <img src="{{ empty(auth()->user()->avatar) ? '/mooimarkt/img/photo_camera.svg' : auth()->user()->avatar }}"
                                     alt="">
                            </div>
                            <div class="arrow_icon">
                                @php(include("mooimarkt/img/language_arrow_bottom.svg"))
                            </div>
                            <div class="profile_header_dropdown">
                                <ul>
                                    <li><a href="{{ route('ads', ['filter' => 'published']) }}"
                                           class="profile-link">{{ Language::lang('My profile') }}</a></li>
                                    <li><a href="{{ route('profile.settings.general_settings') }}"
                                           class="profile-link">{{ Language::lang('My settings') }}</a></li>
                                    <li><a href="{{ route('logout') }}"
                                           class="profile-link">{{ Language::lang('Logout') }}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('sellNow') }}" class="btn def_btn">{{ Language::lang('Sell Now') }}</a>
                    <div class="header_language">
                        <div class="header_language_label">{{ strtoupper(\App::getLocale()) }} @php(include("mooimarkt/img/language_arrow_bottom.svg"))</div>
                        <div class="header_language_dropdown">
                            <ul>
                                @foreach($languages as $lang)
                                    <li>
                                        <a href="{{ route('set_language', ['lang' => $lang->slug]) }}"
                                           class="language-item {{ $lang->slug == \App::getLocale() ? 'active' : '' }}"
                                           data-lang="{{ $lang->slug }}"><img src="{{ $lang->icon }}" alt="">
                                            <span>{{ strtoupper($lang->slug) }}</span></a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <button class="mob_menu_btn">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </div>
            </div>
        </div>
        <div class="header_bottom_line">
            <div class="container">
                <nav class="header_nav">
                    <div class="header_login_top_line mob">
                        <ul>
                            <li>
                                <a href="{{ route('ads', 'published') }}">@php(include("mooimarkt/img/hlogin_top_line_icon_1.svg")){{ Language::lang('My published items') }} </a>
                            </li>
                            <li>
                                <a href="{{ route('ads', 'expired') }}">@php(include("mooimarkt/img/hlogin_top_line_icon_2.svg")) {{ Language::lang('expired items') }}</a>
                            </li>
                            <li>
                                <a href="{{ route('ads', 'sold') }}">@php(include("mooimarkt/img/hlogin_top_line_icon_3.svg")) {{ Language::lang('sold items') }}</a>
                            </li>
                        </ul>
                    </div>
                    <div class="header_login_controls mobile">
                        <ul class="header_login_icons_menu">
                            <li class="wallet_header_link">
                                <a href="{{ route('wallet_up') }}">
                                    <span class="text">€{{ number_format(auth()->user()->wallet, 2) }}</span>
                                    <div class="icon_wrpr wallet_icon">
                                        @php(include("mooimarkt/img/header_login_icons_1.svg"))
                                    </div>
                                </a>
                                {{--<div class="wallet_header_dropdown">
                                    <form action="">
                                        <label class="text_label">{{ Language::lang('Wallet Top up') }}</label>
                                        <div class="wallet_dropdown_group">
                                            <input type="text" class="text_input"
                                                   placeholder="{{ Language::lang('Write any amount...') }}">
                                            <button class="btn def_btn"> {{ Language::lang('Submit') }}</button>
                                        </div>
                                    </form>
                                    <form action="">
                                        <label class="text_label">{{ Language::lang('wallet cash out') }}</label>
                                        <div class="wallet_dropdown_group">
                                            <input type="text" class="text_input"
                                                   placeholder="{{ Language::lang('Write any amount...') }}">
                                            <button class="btn def_btn">{{ Language::lang('Submit') }}</button>
                                        </div>
                                    </form>
                                </div>--}}
                            </li>
                            <li>
                                <a href="{{ route('myMessage') }}">
                                    <div class="icon_wrpr notification_icon">
                                        <span {!! $unreadMessagesCount == 0 ? 'style="display: none;"' : '' !!}>
                                            {{ $unreadMessagesCount }}
                                        </span>
                                        @php(include("mooimarkt/img/header_login_icons_2.svg"))
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('pages.notification') }}">
                                    <div class="icon_wrpr notification_icon">
                                        <span class="text">12</span>
                                        @if ($newNotifications > 0)
                                            <span>{{ $newNotifications }}</span>
                                        @endif
                                        @php(include("mooimarkt/img/header_login_icons_3.svg"))
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('ads', 'favorites') }}">
                                    <div class="icon_wrpr">
                                        @php(include("mooimarkt/img/header_login_icons_4.svg"))
                                    </div>
                                </a>
                            </li>
                        </ul>
                        <div class="header_login_profile profile_header_link__mobile">
                            <div class="img_wrpr">
                                <img src="{{ empty(auth()->user()->avatar) ? '/mooimarkt/img/photo_camera.svg' : auth()->user()->avatar }}"
                                     alt="">
                            </div>
                            <div class="arrow_icon">
                                @php(include("mooimarkt/img/language_arrow_bottom.svg"))
                            </div>
                            <div class="profile_header_dropdown profile_header_dropdown__mobile">
                                <ul>
                                    <li><a href="{{ route('ads', ['filter' => 'published']) }}"
                                           class="profile-link">{{ Language::lang('My profile') }}</a></li>
                                    <li><a href="{{ route('profile.settings.general_settings') }}"
                                           class="profile-link">{{ Language::lang('My settings') }}</a></li>
                                    <li><a href="{{ route('logout') }}"
                                           class="profile-link">{{ Language::lang('Logout') }}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    @include('site.inc.main-menu')
                </nav>
                <form action="{{ route('adsByCategory') }}"
                      class="header_search {{ isset($curSubCategory) && isset($curCategory) ? 'catalog-search' : 'main-search' }}">
                    <div class="search-content">
                        <input type="text" class="header_search_input" value="{{ request()->search ?? '' }}"
                               name="search" placeholder="{{ Language::lang('Search') }}">
                    </div>
                </form>
            </div>
        </div>
    </header>
@else
    <header class="header unlogin_header">
        <div class="header_top_line">
            <div class="container">
                <!-- <a href="/" class="header_logo">{{ Language::lang('Mooimarkt') }}</a> -->
                <a href="/" class="header_logo"><img src="/mooimarkt/img/logo_60.jpg" alt="Mooimarkt" class="login-logo-img" /></a>
                <div class="right">
                    <a data-fancybox="" data-src="#hidden-content" href="javascript:;"
                       class="btn def_btn">{{ Language::lang('Log In / Sign Up ') }}</a>

                    <div style="display: none;" id="forgot-password-content">
                        <div class="login-logo-section" style="padding:20px 0;text-align: center;">
                            <a href="/" class="login-logo"><img src="/mooimarkt/img/logo_60.jpg" alt="Mooimarkt" class="login-logo-img" /></a>
                        </div>
                        <div class="forgot-password">                           

                            <form action="#" id="forgot-password-form">
                                <div class="forgot-password-validation">
                                    <ul></ul>
                                </div>
                                <div class="input-hint">
                                            <small style="text-align: right;display: block;">Please enter your email address.</small>
                                        </div>
                                
                                <input type="email" name="email" placeholder="{{ Language::lang('email') }}">
                                <div class="form-bottom">
                                    <button type="submit" class="btn def_btn">{{ Language::lang('Send') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div style="display: none;" id="email-login-content">
                        <div class="login-logo-section" style="padding:20px 0;text-align: center;">
                            <a href="/" class="login-logo"><img src="/mooimarkt/img/logo_60.jpg" alt="Mooimarkt" class="login-logo-img" /></a>
                        </div>  
                        <div class="email-login">
                            

                            <form action="#" id="new-login">
                                <div class="new-auth-validation">
                                            <ul></ul>
                                        </div>
                                <input type="text" name="email" placeholder="{{ Language::lang('email') }}">
                                <input type="password" name="pass" placeholder="{{ Language::lang('PASSWORD') }}">
                                <div class="form-bottom">
                                    <button type="submit" class="btn def_btn">{{ Language::lang('LOG IN') }}</button>
                                    <div style="padding-top: 20px;">
                                        <a href="#" data-src="forgot-password-content" class="fancybox-open forgot-password">{{ Language::lang('Forgot Password?') }}</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div style="display: none;" id="registration-content">
                        <div class="login-logo-section" style="padding:20px 0;text-align: center;">
                            <a href="/" class="login-logo"><img src="/mooimarkt/img/logo_60.jpg" alt="Mooimarkt" class="login-logo-img" /></a>
                        </div>
                        <div class="registration">
                            

                            <form action="#" id="new-signup">
                                        <div class="new-signup-validation">
                                            <ul>
                                            </ul>
                                        </div>
                                        <div class="input-hint">
                                            <small style="max-width: 195px; display: inline-block;">
                                                {!! Language::lang('Username can contain letters and numbers without spaces.') !!}
                                            </small>
                                        </div>
                                        <input type="text" name="name"
                                               placeholder="{{ ucfirst(Language::lang('Username')) }}">
                                        <input name="email" placeholder="{{ Language::lang('Email') }}">
                                        <div class="input-hint">
                                            <small>
                                                {!! Language::lang('Must contain at least 6 characters.') !!}
                                            </small>
                                        </div>
                                        <input type="password" name="password"
                                               placeholder="{{ ucfirst(Language::lang('Password')) }}">
                                        <input type="password" name="password_confirmation"
                                               placeholder="{{ Language::lang('Confirm Password') }}">
                                        <button type="submit"
                                                class="btn def_btn">{{ Language::lang('SIGN UP') }}</button>
                                    </form>
                        </div>
                    </div>

                    <div style="display: none; cursor: default;" id="hidden-content">
                        <div class="login-logo-section" style="padding:20px 0;text-align: center;">
                            <a href="/" class="login-logo"><img src="/mooimarkt/img/logo_60.jpg" alt="Mooimarkt" class="login-logo-img" /></a>
                        </div>
                        <div class="initial-login-screen">
                            <div class="new-auth-validation">
                                <ul></ul>
                            </div>
                            <div class="login-options">
                                <div class="login-option-left">
                                    <a class="fb connect" onclick="window.location='/FacebookRedirect'">Login with Facebook</a>
                                </div>
                                <div class="login-option-right">
                                    <a href="#" data-src="email-login-content" class="fancybox-open login-btn">Login with Email</a>
                                </div>
                                
                            </div>
                            <a href="#" data-src="registration-content" class="fancybox-open register-btn">{{ Language::lang('Sign Up') }}</a>
                        </div>
                    </div>

                    <div class="header_language">
                        <div class="header_language_label">{{ strtoupper(\App::getLocale()) }} @php(include("mooimarkt/img/language_arrow_bottom.svg"))</div>
                        <div class="header_language_dropdown">
                            <ul>
                                @foreach($languages as $lang)
                                    <li>
                                        <a href="{{ route('set_language', ['lang' => $lang->slug]) }}"
                                           class="language-item {{ $lang->slug == \App::getLocale() ? 'active' : '' }}"
                                           data-lang="{{ $lang->slug }}"><img src="{{ $lang->icon }}" alt="">
                                            <span>{{ strtoupper($lang->slug) }}</span></a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <button class="mob_menu_btn">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </div>
            </div>
        </div>
        <div class="header_bottom_line">
            <div class="container">
                <nav class="header_nav">
                    @include('site.inc.main-menu')
                </nav>
                <form action="/catalog" class="header_search">
                    <input type="text" name="search" value="{{ request()->search }}" class="header_search_input"
                           placeholder="{{ Language::lang('Search') }}">
                </form>
            </div>
        </div>
    </header>
@endif
