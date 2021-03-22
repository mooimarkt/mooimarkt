<?php

if(!session()->get('locale')){
session()->put('locale', 'en');
}
?>

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">



    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @if(isset($ad->name) && strpos(Request::url(), 'getAdsDetails') != false)
        <!-- Google Meta Tag -->
        <meta name="author" content="{{ $ad->name }}">
        <meta name="keywords" content="Make,Model,Year,Hours,Engine,Size,Stroke,Color,Motocross,Bikes,Quads,Vehicles,Gear,Casual,Parts,Accessories">
        <meta name="google-site-verification" content=""/>

        <!-- Facebook Meta Tag -->
        <meta property="og:title" content="{{ $ad->adsName }}">
        <meta property="og:image" content="{{ asset($ad->adsImage) }}">
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{Request::url()}}">
        <meta property="og:description" content="{{ $summaryString }}" />
    @endif

    <title>B4MX.COM - The worlds exclusive off-road marketplace</title>

    <!-- Styles -->
    <link rel="shortcut icon" href="{{url('/img/logo/favicon.png')}}">
	<script type="text/javascript" src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="{{ asset('owlcarousel/owl.carousel.min.css') }}">
	<link rel="stylesheet" href="{{ asset('owlcarousel/owl.theme.default.min.css') }}">
    <!--<link href="{{ asset('css/app.css') }}" rel="stylesheet">-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="{{ asset('css/master1.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
    <link href="{{ asset('css/multiple-select.css')}}" rel="stylesheet"/>
    <link href="{{ asset('css/rangeslider.css')}}" rel="stylesheet"/>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="//widget.manychat.com/1709717899323566.js" async="async"></script>

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-fixed-top" style="box-shadow: rgb(0, 0, 0) 0px 0px 10px;">
            <div class="container header-nav-container">
                <div class="navbar-header" style="float:left;">
                    <a class="navbar-brand main-logo" href="{{ url('/') }}">
                        <img class="navbar-brand-img" src="{{url('/img/logo/logo.png')}}" />
                    </a>
                </div>
                <ul class="nav navbar-nav header-nav" style="float:right;">
                    <li>
                        <button type="button" id="navbarBox" class="navbar-toggle collapsed toggle-nav is-closed animated fadeInLeft menu-toggle" style="float: left;">
                            <span class="sr-only">Toggle Navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </li>
                    <li>
                        <div class="profile-box-div">
                            <button type="button" class="navbar-toggle collapsed navbar-toggle-right profile-button-img" style="float: right;">
                                <img class="" height="30px" width="auto" src="https://cdn0.iconfinder.com/data/icons/users-android-l-lollipop-icon-pack/24/user-512.png"/>
                            </button>
                            <div id="profile-drop-box" class="profile-drop-div collapse" style="display:none;">
                                <ul class="nav navbar-nav navbar-right">
                                    <li><a href="{{ url('getProfilePage') }}"><i class="fa fa-user" aria-hidden="true"></i>&nbsp;&nbsp;{{trans('label-terms.myprofile')}}</a></li>
                                    <?php $draftCount = 0;
                                    if(isset(Auth::user()->id) && Auth::user()->getDraftAdsCount()){
                                        $draftCount = " (".Auth::user()->getDraftAdsCount().")";
                                    }else{
                                        $draftCount = "";
                                    }

                                    if(isset(Auth::user()->id) && Auth::user()->getUnreadMsgCount()){
                                        $unreadMsgCount = " (".Auth::user()->getUnreadMsgCount().")";
                                    }else{
                                        $unreadMsgCount = "";
                                    }


                                    ?>
                                    <li><a href="{{ url('getActiveAdsPage') }}"><i class="fa fa-buysellads" aria-hidden="true"></i>&nbsp;&nbsp;{{trans('label-terms.myactiveads')}} {{$draftCount}} </a></li>
                                    <li><a href="{{ url('getInboxPage') }}"><i class="fa fa-envelope-o" aria-hidden="true"></i>&nbsp;&nbsp;{{trans('label-terms.myinbox')}} {{$unreadMsgCount}}</a></li>
                                    <li><a href="{{ url('getFavouritesPage') }}"><i class="fa fa-heart" aria-hidden="true"></i>&nbsp;&nbsp;{{trans('label-terms.myfavourites')}}</a></li>
                                    <li><a href="{{ url('getSearchAlertPage') }}"><i class="fa fa-search" aria-hidden="true"></i>&nbsp;&nbsp;{{trans('label-terms.searchalerts')}}</a></li>
                                    <!-- Authentication Links -->
                                    @guest
                                        <li><a href="{{ url('getLoginPage') }}"><i class="fa fa-sign-in" aria-hidden="true"></i>&nbsp;&nbsp;{{trans('buttons.login')}}</a></li>
                                    @else
                                        <li>
                                            <a style="color: #dd5347;" href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                                <i class="fa fa-sign-out" aria-hidden="true"></i>&nbsp;&nbsp;{{trans('buttons.logout')}}
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                {{ csrf_field() }}
                                            </form>
                                        </li>

                                        <!--{{ Auth::user()->name }}-->
                                    @endguest
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li>
                        <a class="place-ads-anchor uppercase-text place-ads-button" style="float: right;" href="{{ url('getPlaceAdsPage') }}">{{trans('buttons.placeads')}}</a>

                    </li>
                </ul>
            </div>
        </nav>

		<div id="wrapper" style="overflow: hidden;">
			<!-- Sidebar -->
			<nav class="navbar navbar-inverse navbar-fixed-top" id="sidebar-wrapper" role="navigation">
				<ul class="nav sidebar-nav">
                    <li class="sidebar-title">
                        <a href="#" class="uppercase-text">{{trans('instruction-terms.shopbycategory')}}</a>
                    </li>
                     @foreach($category as $categories)
			            <li class="sidebar-more">
                            <a href="#SubMenu{{ $categories->id }}" class="list-group-item" data-toggle="collapse" data-parent="SubMenu{{ $categories->id }}">
                                @if(count(explode(".", trans('categories.'.$categories->categoryName))) > 1)
                                    {{ explode(".", trans('categories.'.$categories->categoryName))[1] }}
                                @else
                                    {{ trans('categories.'.$categories->categoryName) }}
                                @endif
                                ({{$categories->totalAdsCount()}})
                                <i class="more-less fa fa-plus" aria-hidden="true" style="float: right;"></i></a>

                            <div class="collapse list-group-submenu" id="SubMenu{{ $categories->id }}">
                                @foreach($subCategory as $subCategories)
                                    @if($categories->id == $subCategories->categoryId)
                                        <a href="{{ url('getAdsBySubCategory', ['subCategoryId' => $subCategories->id]) }}" class="list-group-item sidebar-internal-drop-li" data-parent="{{ $subCategories->id }}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            @if(count(explode(".", trans('subcategories.'.$subCategories->subCategoryName))) > 1)
                                                {{ explode(".", trans('subcategories.'.$subCategories->subCategoryName))[1] }}
                                            @else
                                                {{ trans('subcategories.'.$subCategories->subCategoryName) }}
                                            @endif
                                            ({{$subCategories->totalAdsCount()}})
                                        </a>
                                    @endif
                                @endforeach
                            </div>
				        </li>
                   @endforeach
				</ul>
			</nav><!-- /#sidebar-wrapper -->

			<div id="page-content-wrapper" style="margin-top: 70px;">
				@yield('content')
			</div>
		</div>
		<div class="footer-section" style="margin-top: 20px;">
			<div class="container header-nav-container" style="background-color: #505050;">
                <div class="col-lg-offset-3 col-md-offset-3 col-lg-3 col-md-3 col-xs-12 footer-link-section" style="text-align: center !important;">
                    <label for="language" class="footer-title uppercase-text">{{trans('instruction-terms.selectlanguage')}}</label>
                    <select id="language" name="dropDownLanguage" class="form-control" style="width: 60%; margin: 0 auto; background-color: #505050; color: #fff; border: 2px solid #fff;">
                        @foreach($language as $languages)
                            <option value="{{ $languages->locale }}">{{ $languages->name }}</option>
                        @endforeach
                    </select>
                    <select id="currency" name="dropDownCurrency" class="form-control" style="width: 60%; margin: 0 auto; background-color: #505050; color: #fff; border: 2px solid #fff;">
                        @foreach($currency as $currencies)
                            <option value="{{ $currencies->currencyCode }}">{{ $currencies->currencyCode }}</option>
                        @endforeach
                    </select>
                </div>
				<div class="col-lg-offset-1 col-md-offset-1 col-lg-5 col-md-5 col-xs-12 footer-link-section">
                    <label for="language" class="footer-title uppercase-text">{{trans('label-terms.navigation')}}</label><br/>
					<!-- <a href="#" class="footer-links">{{trans('master-1.ABOUT US')}}</a><br/>-->
                    <a href="{{url('getTermsOfUse')}}" class="footer-links uppercase-text">{{trans('policy-terms.termsofuse')}}</a><br/>
                    <a href="{{url('getPrivacyPolicy')}}" class="footer-links uppercase-text">{{trans('policy-terms.privacypolicy')}}</a><br/>
					<!-- <a href="#" class="footer-links">{{trans('master-1.FAQ')}}</a><br/>-->
					<a href="{{url('getPricingPage')}}" class="footer-links uppercase-text">{{trans('label-terms.pricing')}}</a><br/>
					<a href="{{url('getFeedbackPage')}}" class="footer-links uppercase-text">{{trans('label-terms.contactus')}}</a><br/>
				</div>
				<br/>
				<div class="col-lg-12 col-md-12 col-xs-12">
					<h6 class="footer-connect-title uppercase-text">{{trans("label-terms.letsconnect")}}</h6>
                </div>
                <div class="col-lg-12 col-md-12 col-xs-12" style="padding:0px 0px 10px 0px;">
                    <div class="fb-like" data-href="https://www.facebook.com/beforemotocross/" data-layout="button" data-action="like" data-size="small" data-show-faces="true" data-share="false"></div>
                </div>
                <div class="col-lg-12 col-md-12 col-xs-12" style="padding:0px 0px 10px 0px;">
                    <a href="https://www.pinterest.ie/b4mx/" data-pin-do="buttonPin" ></a>
                </div>
                <div class="col-lg-12 col-md-12 col-xs-12" style="padding:0px 0px 0px 0px;">
                    <a style="" class="twitter-follow-button" href="https://twitter.com/b4mxmotocross" data-size="small" data-show-screen-name="false" data-show-count="false"></a>
                </div>
                <div class="col-lg-12 col-md-12 col-xs-12" style="padding:0px 0px 10px 0px;">

                    <a name="instagramSocialLink" href="https://www.instagram.com/beforemotocross/" target="_blank"><i class="fa fa-instagram footer-social-icon" aria-hidden="true"></i></a>
				</div>
				<div class="col-lg-12 col-md-12 col-xs-12">
					<h6 class="footer-copyright-title">© {{date('Y')}} Mooimarkt. ALL RIGHTS RESERVED.</h6>
				</div>
			</div>
		</div>
	</div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('owlcarousel/owl.carousel.min.js') }}"></script>
    <script type="text/javascript" src="//cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('js/userPage.js') }}"></script>
    <script src="{{ asset('js/share.js') }}"></script>
    <script src="{{ asset('js/multiple-select.js') }}"></script>
    <script src="{{ asset('js/rangeslider.min.js') }}"></script>
    <script src="{{ asset('js/load-image.all.min.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript" src="{{ asset('js/ads.js') }}"></script>


    <script type="text/javascript">
        $(document).ready(function() {

            if("{{ Session::get('locale') }}" != ''){
                $('#language').val("{{ Session::get('locale') }}");
            }

            if("{{ Session::get('currency') }}" != ''){
                $('#currency').val("{{ Session::get('currency') }}");
            }

            var host = location.protocol + '//' + location.host;

            $('#backBtnDiv').click(function(){
                parent.history.back();
                return false;
            });

            $('#language').change(function(){

                $.ajax({
                    type: "GET",
                    url: host + '/changeLocale',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: ({ "locale":$(this).val() }),
                    success: function(data) {

                        if(data.success == "success"){
                            location.reload();
                        }
                        else{
                            alert("{{trans('message-box.somethingwrong')}}");
                        }
                    },
                    error: function() {
                        alert("{{trans('message-box.somethingwrong')}}");
                    }
                });
            });

            $('#currency').change(function(){

                $.ajax({
                    type: "GET",
                    url: host + '/changeCurrency',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: ({ "currency":$(this).val() }),
                    success: function(data) {

                        if(data.success == "success"){
                            location.reload();
                        }
                        else{
                            alert("{{trans('message-box.somethingwrong')}}");
                        }
                    },
                    error: function() {
                        alert("{{trans('message-box.somethingwrong')}}");
                    }
                });
            });

            $('.profile-box-div').on('mouseover', function(){
                $('#profile-drop-box').css('display','block');
            });

            $('.profile-box-div').on('mouseout', function(){
                $('#profile-drop-box').css('display','none');
            });

            var toggle = $('.toggle-nav');
            var contentWrapper = $('#page-content-wrapper');
            var now = 0
            var short = 0
            var long = 0

            //If is at portrait
            if(window.innerHeight > window.innerWidth){
                now = 0
                short = $('.navbar').height();
                //$('.breadcrumb').css('margin-top', short + 20);
            }
            else{
                now = 1
                long = $('.navbar').height();
                //$('.breadcrumb').css('margin-top', long + 20);
            }

            toggle.click(function() {
                if($('#wrapper').hasClass('toggled')){
                    $('#wrapper').removeClass('toggled');
                }
                else{
                    $('#wrapper').addClass('toggled');
                }
            });

            contentWrapper.click(function() {
                if($('#wrapper').hasClass('toggled')){
                    $('#wrapper').removeClass('toggled');
                }

                if($('#auth-navbar-collapse').hasClass('in')){
                    $('#auth-navbar-collapse').removeClass('in');
                }

                if($('#profile-drop-box').css('display') == 'block'){
                    $('#profile-drop-box').css('display','none');
                }

                if($("#suggestion-list").length > 0 && $("#suggestion-box").length > 0) {
                    $('#suggestion-list').children().remove().end();
                    $('#suggestion-box').css('display','none');
                }

            });

            $('.sidebar-more').on('hidden.bs.collapse', toggleIcon);
            $('.sidebar-more').on('shown.bs.collapse', toggleIcon);

            $( window ).on( "orientationchange", function( event ) {

                if(window.innerHeight > window.innerWidth){
                    now = 0

                    $('.breadcrumb').css('margin-top', long + 20);
                    short = $('.navbar').height();
                }
                else{
                    now = 1

                    $('.breadcrumb').css('margin-top', short + 20);
                    long = $('.navbar').height();
                }
            });
        });

        function toggleIcon(e) {
            $(e.target)
                .prev('.list-group-item')
                .find(".more-less")
                .toggleClass('fa-plus fa-minus');
        }

        function getParameterByName(name, url) {
            if (!url) url = window.location.href;
            name = name.replace(/[\[\]]/g, "\\$&");
            var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, " "));
        }

        if($('#geolocationLongitude').length > 0) {
            $('body').append('<script id="masterMapLoader" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDFZGVMX5YGM9hQmsAxRG_F5lwpiURDOCs&libraries=places&callback=myMap"/>');
        }
    </script>

    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-111351737-1', 'auto');
        ga('send', 'pageview');
    </script>
    <script>window.twttr = (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0],
        t = window.twttr || {};
        if (d.getElementById(id)) return t;
        js = d.createElement(s);
        js.id = id;
        js.src = "https://platform.twitter.com/widgets.js";
        fjs.parentNode.insertBefore(js, fjs);

        t._e = [];
        t.ready = function(f) {
        t._e.push(f);
        };

        return t;
    }(document, "script", "twitter-wjs"));</script>

        <div id="fb-root"></div>
    <script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.12&appId=218134461588352&autoLogAppEvents=1';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
    <script
        type="text/javascript"
        async defer
        src="//assets.pinterest.com/js/pinit.js"
    ></script>
</body>
</html>
