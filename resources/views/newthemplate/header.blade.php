<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>B4MX - home</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta property="og:site_name" content="b4mx"/>
    @if(isset($AdHead))
        <meta property="og:title" content="{{$Ad->adsName}}"/>
        <meta property="og:type" content="article"/>
        <meta property="article:published_time" content="{{$Ad->created_at}}"/>
        <meta property="article:modified_time" content="{{$Ad->updated_at}}"/>
        <meta property="article:section" content="vehicle"/>
        <meta property="article:tag" content="moto"/>
        <meta property="article:tag" content="vehicle"/>
        <meta property="article:tag" content="vehicle details"/>
        <meta property="article:tag" content="ad"/>
        <meta property="article:tag" content="gear"/>
        <meta property="og:url" content="{{Illuminate\Support\Facades\URL::current()}}"/>
        @if(isset($images))
            @forelse ($images as $image)
                <meta property="og:image" content="https://moto.cgp.systems/{{ $image->imagePath }}"/>
            @empty
                <meta property="og:image" content="https://moto.cgp.systems/newthemplate/img/baner-header.png"/>
            @endforelse
        @endif
        <meta property="og:description" content="{{$Ad->adsDescription}}"/>
    @else
        <meta property="og:title" content="b4mx"/>
        <meta property="og:description" content="Buy or Sell anything on b4mx"/>
        <meta property="og:type" content="website"/>
        <meta property="og:url" content="https://moto.cgp.systems/"/>
        <meta property="og:image" content="https://moto.cgp.systems/newthemplate/img/baner-header.png"/>
    @endif


    <link href="/newthemplate/css/reset.css" rel="stylesheet">
    <link href="/newthemplate/css/fonts.css" rel="stylesheet">
    <link href="/newthemplate/css/header.css" type="text/css" rel="stylesheet"/>
    <link href="/newthemplate/css/footer.css" type="text/css" rel="stylesheet"/>
    <link href="/newthemplate/bower_components/swiper/dist/css/swiper.min.css" rel="stylesheet"/>
    <link href="/newthemplate/bower_components/datetimepicker/jquery.datetimepicker.min.css" rel="stylesheet"/>
    <link href="/newthemplate/bower_components/star-rateing/css/star-rating.css" rel="stylesheet"/>
    <link href="/newthemplate/css/StyleSheet.css" rel="stylesheet"/>
    <link href="/newthemplate/css/max.css" rel="stylesheet">
    <link href="/newthemplate/css/vasya.css" rel="stylesheet">
    <link href="/newthemplate/css/ruslan.css" rel="stylesheet">
    <link href="/newthemplate/css/animate.css" rel="stylesheet">
    <link href="/newthemplate/css/easy-autocomplete.min.css" rel="stylesheet">
    <link href="/newthemplate/bower_components/select2/css/select2.min.css" rel="stylesheet">
    <!-- Begin emoji-picker Stylesheets -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="/css/emoji.css" rel="stylesheet">
    <!-- End emoji-picker Stylesheets -->

    @if (!empty(\App\Option::getSetting('opt_google_analytics_trackingid')))
    <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async
                src="https://www.googletagmanager.com/gtag/js?id={{ \App\Option::getSetting('opt_google_analytics_trackingid') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }

            gtag('js', new Date());

            gtag('config', '{{ \App\Option::getSetting('opt_google_analytics_trackingid') }}');
        </script>
    @endif
</head>
<body>
<!-- MODAL ALL PAGE -->
<div class="modal_all_page">
    <section id="login-section" class="login-section">
        <div class="close_modal">&times;</div>
        <div class="modal_block">
            <h6>
                <span>Login</span>
                B4MX
            </h6>
            <form action="#" id="auth-form-popup" class="auth-form">
                {{csrf_field()}}
                <input type="email" name="email" class="user-input" placeholder="Email Address">
                <input type="password" name="password" class="user-input" placeholder="Password">
                <div class="user-checkbox">
                    <input type="checkbox"><label></label><span>Remember Me</span>
                </div>
                <input type="submit" value="LOGIN" class="user-submit">
                <a href="#" class="user-link register_page_modal_popup">Register</a>
                <a href="#" class="user-link restore_page_modal_popup">I Forgot My Password</a>
                <span class="or">OR</span>
                <a href="/GoogleRedirect" class="login-google">Login via Google</a>
                <a href="/FacebookRedirect" class="login-facebook">Login via Facebook</a>
            </form>
            <form action="#" id="register-form-popup" class="auth-form" style="display: none;">
                {{csrf_field()}}
                <input type="email" name="email" class="user-input" placeholder="Email Address">
                <input type="password" name="password" class="user-input" placeholder="Password">
                <input type="password" name="password_confirmation" class="user-input" placeholder="Confirm Password">
                <input type="submit" value="REGISTER" class="user-submit">
                <a href="#" class="user-link login_page_modal_popup">Login</a>
                <span class="or">OR</span>
                <a href="/GoogleRedirect" class="login-google">Sign Up via Google</a>
                <a href="/FacebookRedirect" class="login-facebook">Sign Up via Facebook</a>
            </form>
            <form action="#" id="password-restore" class="auth-form" style="display: none;">
                {{csrf_field()}}
                <input type="email" name="email" class="user-input" placeholder="Email Address">
                <input type="submit" value="RESTORE" class="user-submit">
                <a href="#" class="user-link login_page_modal_popup">Login</a>
                <a href="#" class="user-link register_page_modal_popup">Register</a>
            </form>
        </div>

    </section>
</div>
<!-- END MODAL -->

<!--header -->
<header>
    <div class="container container-header">
        <div class="menu-phone">
            <a class="menu-button" href="#">
                <span></span>
            </a>
            <div class="item-nav-logo">
                <a class="brand" href="/"><img src="/newthemplate/img/logo.svg"/></a>
            </div>
        </div>
        <div class="login">
            @if(Auth::check())
                <a href="/logout" class="border-a border-a-2">Logout</a>
                <span onclick="this.classList.toggle('show'); ">
                    <img src="/newthemplate/img/icon-p.svg"/>
                    <ul class="drop-down-list">
                        <li>
                            <a href="/getProfilePage">My Profle</a>
                        </li>
                        <li>
                            <a href="/my-ads-listing">My Listings</a>
                        </li>
                        <li>
                            <a href="/my-favorite">My Favirotes</a>
                        </li>
                        <li>
                            <a href="/my_seved_searches">My Searches</a>
                        </li>
                        <li>
                            <a href="/dialog-list">My Messages</a>
                        </li>
                        <li>
                            <a href="/profile/{{Auth::id()}}">Go to my timeline</a>
                        </li>
                    </ul>
                </span>
                <a href="/place_add" class="bt_blu">Place Ad</a>
            @else
                <a class="border-a border-a-2 open_modal" id="Login_button">Login</a>
                <a class="border-a border-a-2 open_modal sign_up_modal">Sign Up</a>
                <a class="open_modal"><img src="/newthemplate/img/icon-p.svg"/></a>
                <a class="bt_blu open_modal">Place Ad</a>
            @endif
        </div>
        <div class="drop-down">
            <div class="main-nav-mobail">
                <div class="accordion-container">
                    @foreach ($navbarCaregories as $category)
                        <section class="accordion">
                            <div class="accordion-header">
                                <p>{{ $category->categoryName }}</p>
                                @php $adsnum = 0; @endphp
                                @foreach ($navbarSubCaregories as $subCaregory)
                                    @if ($subCaregory->categoryId == $category->id)
                                        @php $adsnum += DB::table("ads")->where( 'adsStatus', '=', 'payed' )->where("subCategoryId",$subCaregory->id)->whereNull('ads.deleted_at')->count();  @endphp
                                    @endif
                                @endforeach
                                <p>{{ $adsnum }}</p> <!-- $category->adsnum -->
                                <span class="arrow"></span>
                            </div>
                            <div class="accordion-body" style="display: none;">
                                <ul>
                                    @foreach ($navbarSubCaregories as $subCaregory)
                                        @if ($subCaregory->categoryId == $category->id)
                                            <li>
                                                <a href="{{ route('ads.add-listing', ['subCategoryId' => $subCaregory->id]) }}"
                                                   class="border-a">{{ $subCaregory->subCategoryName }}</a>
                                                <p>{{ DB::table("ads")->where( 'adsStatus', '=', 'payed' )->where("subCategoryId",$subCaregory->id)->whereNull('ads.deleted_at')->count() }}</p>
                                            </li>   <!-- $subCaregory->adsnum -->
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </section>
                    @endforeach
                </div>
            </div>

        </div>

    </div>

</header>
<div class="overlay-blok">
    <div class="overlay"></div>
    <!-- header end -->
