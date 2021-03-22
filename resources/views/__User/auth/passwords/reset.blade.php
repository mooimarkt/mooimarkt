@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

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

        <div class="col-md-8 col-md-offset-2">
            <form class="form-horizontal" method="POST" action="{{ url('ResetPassword') }}">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('current_password') ? ' has-error' : '' }}">
                    <label for="current_password" class="col-md-4 control-label">{{ trans('label-terms.currentpassword')}}</label>

                    <div class="col-md-6">
                        <input id="current_password" type="password" class="form-control" name="current_password" required autofocus>

                        @if ($errors->has('current_password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('current_password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password" class="col-md-4 control-label">{{ trans('label-terms.newpassword')}}</label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control" name="password" required>

                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                    <label for="password_confirmation" class="col-md-4 control-label">{{ trans('label-terms.confirmpassword')}}</label>

                    <div class="col-md-6">
                        <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>

                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-3">
                        <button type="submit" class="btn btn-primary btn-block submit-buttons uppercase-text">
                            {{trans('buttons.change')}}
                        </button>
                    </div>
                    <div class="col-md-6 col-md-offset-3 col-xs-12" style="text-align: center;">
                        <a class="btn btn-link blue-link-bold" href="{{ url('getProfilePage') }}">{{trans('buttons.backtoprofile')}}</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
