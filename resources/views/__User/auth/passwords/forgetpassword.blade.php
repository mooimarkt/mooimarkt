@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row container-box">

        @if (\Session::has('success'))
            <div class="alert alert-success">
                <ul class="message-header-list">
                    <li>{!! \Session::get('success') !!}</li>
                </ul>
            </div>
        @endif

        @if (\Session::has('fail'))
            <div class="alert alert-danger">
                <ul class="message-header-list">
                    <li>{!! \Session::get('fail') !!}</li>
                </ul>
            </div>
        @endif

        <div class="col-lg-12 col-md-12 col-xs-12 form-rows">
            <div class="row">
                <h6 class="policy-title" style="margin-left: 15px; text-align: center;">
                    {{ trans('label-terms.retrievepassword')}}
                </h6>
            </div>
        </div>

        <div class="col-md-8 col-md-offset-2">
            <form class="form-horizontal" method="POST" action="{{ url('forgetPassword') }}">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="col-md-4 control-label">{{ trans('label-terms.email')}}</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" required autofocus>

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-3 col-xs-12">
                        <button type="submit" class="btn btn-primary btn-block submit-buttons margin-top">
                            {{ trans('label-terms.retrievepassword')}}
                        </button>
                    </div>
                    <div class="col-md-6 col-md-offset-3 col-xs-12" style="text-align: center;">
                        <a class="btn btn-link blue-link-bold" href="{{ url('getLoginPage') }}">{{trans('buttons.backtologin')}}</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
