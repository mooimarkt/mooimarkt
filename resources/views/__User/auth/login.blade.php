@extends('layouts.app')
@section('content')
<div class="container">

    @if (\Session::has('fail'))
        <div class="alert alert-danger">
            <ul class="message-header-list">
                <li>{!! \Session::get('fail') !!}</li>
            </ul>
        </div>
    @endif

    <div class="row container-box">

        <div class="col-lg-12 col-md-12 col-xs-12 form-rows">
            <div class="row">
                <h6 class="policy-title" style="margin-left: 15px; text-align: center;">
                    {{trans('buttons.login')}}
                </h6>
            </div>
        </div>

        <div class="col-md-offset-2 col-md-8">  
            <form class="form-horizontal" method="POST" action="{{ url('userLogin') }}">
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
                <div class="form-group">
                    <div class="col-md-offset-2 col-md-8 forget-password-section-div">
                        <a class="btn btn-link blue-link-bold" href="{{ url('getForgetPasswordPage') }}">{{trans('instruction-terms.ohnoforgetpassword')}}</a>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-offset-2 col-md-8">
                        <h6 class="center-hr-text uppercase-text"><span>{{trans('label-terms.or')}}</span></h6>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-offset-2 col-md-8">
                      <a href="{{url('FacebookRedirect')}}" class="btn btn-primary btn-block login-buttons facebook-login"><i class="fa fa-facebook social-icon-fa" aria-hidden="true"></i> Login with Facebook</a>
                      <a href="{{url('GoogleRedirect')}}" class="btn btn-primary btn-block login-buttons google-login"><i class="fa fa-google social-icon-fa" aria-hidden="true"></i> Login with Google</a>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-offset-2 col-md-8 forget-password-section-div">
                        <span>{{trans('instruction-terms.notamember')}}</span><a class="btn btn-link red-link-bold uppercase-text" href="{{ url('getRegisterPage') }}">{{trans('buttons.signup')}}</a>
                    </div>
                </div>
                <button type="button" id="modalClicker" class="btn btn-info btn-lg" data-toggle="modal" data-target="#signUpSuccessModal" style="display: none;"></button>
                <button type="button" id="verifiedClicker" class="btn btn-info btn-lg" data-toggle="modal" data-target="#verifySuccessModal" style="display: none;"></button>
                <button type="button" id="pendingClicker" class="btn btn-info btn-lg" data-toggle="modal" data-target="#pendingSuccessModal" style="display: none;"></button>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="signUpSuccessModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content register-success-modal-box">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body register-success-modal">
                <i class="fa fa-check" aria-hidden="true"></i><br/>
                <h3>{{trans('message-box.thanksforsigningup')}}</h3>
                <br/>
                <h6>{{trans('message-box.youarenowmember')}}</h6>
            </div>
        </div>
    </div>
</div>

<div id="verifySuccessModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content register-success-modal-box">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body register-success-modal">
                <i class="fa fa-check" aria-hidden="true"></i><br/>
                <h3>{{trans('message-box.emailverifiedsuccessfully')}}</h3>
                <br/>
                <h6>{{trans('message-box.youarenowabletologin')}}</h6>
            </div>
        </div>
    </div>
</div>

<div id="pendingSuccessModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content register-success-modal-box">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body register-success-modal">
                <i class="fa fa-check" aria-hidden="true"></i><br/>
                <h3>{{trans('message-box.pleaseverifyemail')}}</h3>
                <br/>
                <h6>{{trans('message-box.anemailhasbeensenttoyouremail')}}</h6>
            </div>
        </div>
    </div>
</div>

<script>
    $( document ).ready(function() {

        if('{{$success}}' == 'success'){
            setTimeout(function(){
                $('#modalClicker').click();
           }, 100);

            window.history.replaceState('', 'b4mx.com', '/getLoginPage');
        }
        else if('{{$success}}' == 'verified'){
            setTimeout(function(){
                $('#verifiedClicker').click();
           }, 100);

            window.history.replaceState('', 'b4mx.com', '/getLoginPage');
        }
        else if('{{$success}}' == 'pending'){
            setTimeout(function(){
                $('#pendingClicker').click();
           }, 100);

            window.history.replaceState('', 'b4mx.com', '/getLoginPage');
        }
    });

</script>   

@endsection