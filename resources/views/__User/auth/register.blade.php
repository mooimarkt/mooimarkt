@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row container-box">        

        @if (\Session::has('fail'))
            <div class="alert alert-danger">
                <ul class="message-header-list">
                    <li>{!! \Session::get('fail') !!}</li>
                </ul>
            </div>
        @endif
        
        <form class="form-horizontal" id="registerForm" method="POST" action="{{ url('registerUser') }}">
            <div class="col-lg-12 col-md-12 col-xs-12 form-rows">
                <div class="row">
                    <h6 class="policy-title" style="margin-left: 15px; text-align: center;">
                        {{trans('buttons.register')}}
                    </h6>
                </div>
            </div>

            <div class="col-md-offset-3 col-md-6 col-xs-12">           
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <div class="col-md-12 col-xs-12">
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="{{trans('label-terms.email')}}" required>

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <!--<strong>{{ $errors->first('email') }}</strong>-->
                                <strong>{{trans('label-terms.insertValidEmail')}}</strong>
                                
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <div class="col-md-12 col-xs-12">
                        <input id="password" type="password" class="form-control" name="password" placeholder="{{trans('label-terms.password')}}" required>

                        @if ($errors->has('password') && $errors->first('password') != "validation.confirmed")
                            <span class="help-block">
                                <!--<strong>{{ $errors->first('password') }}</strong>-->
                                <strong>{{trans('label-terms.passwordFormat')}}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <div class="col-md-12 col-xs-12">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="{{trans('label-terms.confirmpassword')}}" required>
                        @if ($errors->has('password') && $errors->first('password') == "validation.confirmed")
                            <span class="help-block">
                                <!--<strong>{{ $errors->first('password') }}</strong>-->
                                <strong>{{trans('label-terms.confirmPasswordNotMatch')}}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-offset-3 col-md-6 col-xs-12">
                <div class="form-group">
                    <div class="col-md-12">                       
                        <a class="btn btn-primary btn-block login-buttons normal-login" onclick="checkAgreePolicy(1);">{{trans('buttons.register')}}</a>
                        <br/>
                        <h6 class="center-hr-text uppercase-text"><span>{{trans('label-terms.or')}}</span></h6>
                        <br/>
                        <a onclick="checkAgreePolicy(2);" class="btn btn-primary btn-block login-buttons facebook-login"><i class="fa fa-facebook social-icon-fa" aria-hidden="true"></i> Sign Up with Facebook</a>
                      <a onclick="checkAgreePolicy(3);" class="btn btn-primary btn-block login-buttons google-login"><i class="fa fa-google social-icon-fa" aria-hidden="true"></i> Sign Up with Google</a>
                      <br/>
                      <input type="checkbox" id="agreeTouCbx" name="agreeTou"> {!!$data['linksTnc']!!}
                    </div>
                </div>          
            </div>
        </form>     
    </div>
</div>

<script>
    $( document ).ready(function() {
        if({{$data['lblUserType']}} == 0)
            $("#sellerTypeOption").prop('checked', true);
        else if({{$data['lblUserType']}} == 1)
            $("#buyerTypeOption").prop('checked', true);
    });

    function checkAgreePolicy(btnIndex){
        var agreed = $('#agreeTouCbx').prop('checked');

        if (agreed) {
            if(btnIndex == 1){
                document.getElementById("registerForm").submit();
            }
            else if(btnIndex == 2){
                window.location.replace("{{url('FacebookRedirect')}}");
            }
            else{
                window.location.replace("{{url('GoogleRedirect')}}");
            }
        }
        else{
            alert('{{trans("message-box.pleaseagreetotou")}}');
        }
    } 
</script>
@endsection
