<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=0.9">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link rel="shortcut icon" href="{{url('/img/logo/logo.png')}}">
	<script type="text/javascript" src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="{{ asset('owlcarousel/owl.carousel.min.css') }}">
	<link rel="stylesheet" href="{{ asset('owlcarousel/owl.theme.default.min.css') }}">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link href="{{ asset('css/master1.css') }}" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container header-nav-container">
                <div class="navbar-header">
                    <a class="navbar-brand main-logo" href="{{ url('/') }}">
                        <img class="navbar-brand-img" src="{{url('/img/logo/logo.png')}}" />
                    </a>
                </div>
                <ul class="nav navbar-nav header-nav">
                    <li>
                        <button type="button" class="navbar-toggle collapsed navbar-toggle-right" style="float: right; margin-top: 18px; margin-bottom: 18px; margin-right: 10px;" data-toggle="collapse" data-target="#auth-navbar-collapse">
                            <span class="sr-only">Toggle Navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>  
                    </li>
                </ul>

                <div class="collapse navbar-collapse" id="auth-navbar-collapse">
                     <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="{{ url('getTermsOfUse') }}"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;&nbsp;{{trans('policy-terms.termsofuse')}}</a></li>
                    </ul>
                </div>
            </div>           
        </nav> 
		<div id="page-content-wrapper">              
			@yield('content')               
		</div>
		<div class="footer-section" style="margin-top: 20px;">
			<div class="container header-nav-container">
				<div class="col-lg-12 col-md-12 col-xs-12">
					<a href="#" class="footer-links">{{trans('master-1.ABOUT US')}}</a><br/>
                    <a href="{{url('getTermsOfUse')}}" class="footer-links uppercase-text">{{trans('policy-terms.termsofuse')}}</a><br/>
					<a href="#" class="footer-links">{{trans('master-1.FAQ')}}</a><br/>
					<a href="#" class="footer-links">{{trans('master-1.PRICING')}}</a><br/>
					<a href="#" class="footer-links">{{trans('master-1.PRICING LEGAL')}}</a><br/>
					<a href="#" class="footer-links">{{trans('master-1.CONTACT US')}}</a><br/>
				</div>
				<br/>
				<div class="col-lg-12 col-md-12 col-xs-12">
					<h6 class="footer-connect-title">{{trans("master-1.LET'S CONNECT")}}</h6>
					<a name="facebookSocialLink" href="#"><i class="fa fa-facebook-square footer-social-icon" aria-hidden="true"></i></a>
					<a name="googleSocialLink" href="#"><i class="fa fa-google-plus-square footer-social-icon" aria-hidden="true"></i></a>
					<a name="twitterSocialLink" href="#"><i class="fa fa-twitter-square footer-social-icon" aria-hidden="true"></i></a>
				</div>
				<div class="col-lg-12 col-md-12 col-xs-12">
					<h6 class="footer-copyright-title">© {{date('Y')}} Mooimarkt. ALL RIGHTS RESERVED.</h6>
				</div>
			</div>
		</div>
	</div>
	
    <!-- Scripts -->
    <script type="text/javascript" src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/ads.js') }}"></script>
    <script src="{{ asset('owlcarousel/owl.carousel.min.js') }}"></script>
    <script type="text/javascript" src="//cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('js/userPage.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {

            var toggle = $('.toggle-nav');
            var contentWrapper = $('#page-content-wrapper');
            var now = 0
            var short = 0
            var long = 0

            //If is at portrait
            if(window.innerHeight > window.innerWidth){
                now = 0
                short = $('.navbar').height();
                $('.breadcrumb').css('margin-top', short + 20);
            }
            else{
                now = 1
                long = $('.navbar').height();
                $('.breadcrumb').css('margin-top', long + 20);
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
    </script>
</body>
</html>
