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
</head>

<body>
<div id="app"> 
    
    <div class="container">

        @if (\Session::has('fail'))
            <div class="alert alert-danger">
                <ul class="message-header-list">
                    <li>{!! \Session::get('fail') !!}</li>
                </ul>
            </div>
        @endif

        <div class="row">

            <div class="col-lg-12 col-md-12 col-xs-12 form-rows">
                <div class="row">
                    <h6 class="policy-title" style="margin-left: 15px; text-align: center;">
                        Admin Login
                    </h6>
                </div>
            </div>

            <div class="col-md-offset-2 col-md-8">  
                <form class="form-horizontal" method="POST" action="{{ url('adminLogin') }}">
                    {{ csrf_field() }}
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <div class="col-md-offset-2 col-md-8">
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="{{trans('label-terms.email')}}" required autofocus>
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <div class="col-md-offset-2 col-md-8">
                            <input id="password" type="password" class="form-control" name="password" placeholder="{{trans('label-terms.password')}}" required>
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <button type="submit" class="btn btn-primary btn-block login-buttons normal-login">{{trans('buttons.login')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
