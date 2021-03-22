@extends('layouts.app')

@section('content')
	

<div class="container">
	<div class="row">
		<div class="col-md-12 text-center">
			<span class="glyphicon glyphicon-exclamation-sign" style="font-size: 100px;"></span><br>
			<span class="" style="font-size: 18px;">{{trans("label-terms.oops")}}</span><br>
			<span class="" style="font-size: 18px;color:grey;">{{trans("label-terms.sorrySomethingWentWrong")}}</span><br><br>

			<span class="" style="font-size: 18px;">{{trans("label-terms.tryAgain")}}</span>		

		</div>
	</div>
	<div class="row" style="margin-top: 30px;">
		<div class="col-md-12 text-center">
			<div class="col-lg-12 col-md-12 col-xs-12 margin-bottom" >
				<a class="place-ads-button" style="padding:20px !important;" href="{{url('/')}}" role="button">{{trans("buttons.backToHomepage")}}</a>

			</div>
		</div>
	</div>
</div>

@endsection
