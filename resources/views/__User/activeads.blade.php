@extends('layouts.app')

@section('content')



<div class="container">
	<div class="row">
	
		@if (\Session::has('success'))
		    <div class="alert alert-success">
		        <ul>
		            <li>{!! \Session::get('success') !!}</li>
		            {!! \Session::forget('success') !!}
		        </ul>
		    </div>
		@endif

		<div class="col-lg-12 col-md-12 col-xs-12 margin-bottom visible-xs">
			<br/>
			<div id="backBtnDiv" class="back-button-link">❮ {{trans('buttons.back')}}</div>
		</div>

		<form method="GET" action="{{ url('getActiveAdsPage') }}">
	        <div class="col-lg-12 col-md-12 col-xs-12 tab-button-div">
				<div class="col-lg-6 col-md-6 col-xs-6 tab-button-column">
					<button id="tab1" class="tab-buttons-active" name="btnMethod" value="publish" style="text-transform: uppercase;">{{trans('buttons.publish')}}</button>
				</div>
				<div class="col-lg-6 col-md-6 col-xs-6 tab-button-column">
					<button id="tab0" class="tab-buttons" name="btnMethod" value="draft" style="text-transform: uppercase;">{{trans('buttons.draft')}}({{Auth::user()->getDraftAdsCount()}})</button>
				</div>
			</div>
		</form>

		@if(count($ads) > 0)
			@foreach($ads as $ad)
			<form id="adsForm" method="POST" action="{{ url('getAdsDetailsPage') }}">
				<div class="col-lg-12 col-md-12 col-xs-12 form-rows bottom-border margin-bottom">
					<br/>
					<div class="col-lg-6 col-md-6 col-xs-6 active-ads-image-div">
						<div class="featured-ads-img" style="background-image: url({{ $ad->adsImage }});"></div>
						<br/><br/>
					</div>
					<div class="col-lg-6 col-md-6 col-xs-6">
						<div class="col-lg-12 col-md-12 col-xs-12" style="padding-left: 0px;">
							<div class="form-group">
								<span style="text-align: right;">
								<label class="active-ads-labels margin-top" style="float:right;"></label>
								</span>
								<div class="col-lg-12 col-md-12 col-xs-12" style="padding-left: 0;">
									<h6 class="inbox-sender-name-title" style="margin-left: 0px; margin-top: 0px;">{{ $ad->adsName }}</h6>
								</div>
								<div class="col-lg-12 col-md-12 col-xs-12" style="padding-left: 0;">
									<h6 class="recently-ads-details" style="margin-left: 0px;">{{ $ad->adsRegion }}, {{ $ad->adsCountry }}</h6>
									<br/>
								</div>
								<div class="col-lg-12 col-md-12 col-xs-12" style="padding-left: 0;">
									<span style="z-index: 99; position: relative; margin-top: 20px; font-weight: bold; color: #3b5998; background-color: #fff; font-size: 11pt;">
										@if($checkMethod != 'draft')
										<?php
											$dt = \Carbon\Carbon::parse($ad->dueDate);
											$end = \Carbon\Carbon::parse($ad->dueDate);
											$now = \Carbon\Carbon::now();
											$diff = $end->diffInDays($now);
											$string = $diff." Day(s) Left";

											$diff_hour = "-";
											$diff_min = "-";

											if($diff == "0"){
												$diff_hour = $end->diffInHours($now);
												$string = $diff_hour." Hour(s) Left";
											}
											if($diff_hour == "0"){
												$diff_min = $end->diffInMinutes($now);
												$string = $diff_min . " Minute(s) Left";
											}
											if($diff_min == "0"){
												$diff = $end->diffInSeconds($now);
												$string = $diff." Second(s) Left";
											}

											echo $string;
										?>
											<!--@if(date_diff(date_create(date("Y-m-d H:i:s")),date_create($ad->sortingDate))->format("%m") > 0)
												{{ date_diff(date_create(date("Y-m-d H:i:s")),date_create($ad->sortingDate))->format("%m") }} month(s) ago
											@elseif(date_diff(date_create(date("Y-m-d H:i:s")),date_create($ad->sortingDate))->format("%a") > 0)
												{{ date_diff(date_create(date("Y-m-d H:i:s")),date_create($ad->sortingDate))->format("%a") }} day(s) ago
											@elseif(date_diff(date_create(date("Y-m-d H:m:s")),date_create($ad->sortingDate))->format("%h") > 0)
												{{ date_diff(date_create(date("Y-m-d H:i:s")),date_create($ad->sortingDate))->format("%h") }} hour(s) ago
											@elseif(date_diff(date_create(date("Y-m-d H:m:s")),date_create($ad->sortingDate))->format("%i") > 0)
												{{ date_diff(date_create(date("Y-m-d H:i:s")),date_create($ad->sortingDate))->format("%i") }} minute(s) ago
											@else
												{{ date_diff(date_create(date("Y-m-d H:i:s")),date_create($ad->sortingDate))->format("%s") }} second(s) ago
											@endif-->
										@endif
									</span>
								</div>
								<div class="col-lg-12 col-md-12 col-xs-12" style="padding-left: 0;">
									<h6 class="info-pages-price" style="margin-left: -15px;">{{ Session::get('currency') }} {{ number_format($ad->adsPrice / Session::get('forexRate'),2) }}</h6>
								</div>
								<div class="col-lg-12 col-md-12 col-xs-12" style="padding-left: 0;">
									<h6 id="daysLeft" class="info-pages-price" style="float:right; display: none;"> {{trans('place-ads.Days Left')}}</h6>
								</div>
							</div>
						</div>	
						<div class="col-lg-6 col-md-6 col-xs-12 adsStatus" style="padding: 0;">
							<select class="form-control" id="adsStatus" name="dropDownAdsStatus" style="width: 70%; margin-top: 20px;">
								<option value="0">Active</option>
								<option value="1">Sold</option>
							</select>		
						</div>	
						<div class="col-lg-6 col-md-6 col-xs-12" style="padding-bottom: 10px;">
							{!! Form::hidden('adsId', $ad->id) !!}
							<button type="submit" class="manage-ads-buttons-active uppercase-text edit-buttons" value="btnEdit" name="btnSubmitActiveAds">{{trans('buttons.edit')}}</button>
							<button type="submit" value="btnView" name="btnSubmitActiveAds" class="manage-ads-buttons-active uppercase-text view-buttons">{{trans('buttons.view')}}</button>
							<button data-id="{{$ad->id}}" class="delete-buttons-active uppercase-text delete-buttons">{{trans('buttons.delete')}}</button>
							<button type="submit" class="delete-buttons-active uppercase-text" value="btnDelete" id="del-{{$ad->id}}" style="display: none;" name="btnSubmitActiveAds">{{trans('buttons.delete')}}</button>

						</div>	

					</div>
					
					@if($ad->adsStatus == "pending for payment")
					<div class="col-lg-12 col-md-12 col-xs-12 " style="font-size:14px;padding:0px;margin-top: 10px;margin-bottom: 10px;">
						<div class="col-xs-8 text-left" style="color:red;">
							Needs Payment (Not Listed)
						</div>
						<div class="col-xs-4 text-right" style="">
							<a href="{{url('paymentPage?t_id='.$ad->referenceId)}}" style="color:#0af;">Pay Now!</a>
						</div>
					</div>
					@else
					<div class="col-lg-12 col-md-12 col-xs-12 text-right" style="font-size:14px;padding:0px;margin-top: 10px;margin-bottom: 10px;color:#0af;">
						@if(isset($add_on_package[$ad->id]["spotlight"]))
						<div class="addOnBtn col-md-offset-8 col-xs-offset-4 col-sm-offset-8 col-xs-4 col-md-2 col-sm-2" data-adID="{{$ad->id}}" data-addOnID="{{$add_on_package[$ad->id]["spotlight"]["packageID"]}}" data-addOnType="Spotlight" style="color:#0af;">
							Spotlight
						</div>
						@endif
						@if(isset($add_on_package[$ad->id]["bump"]))
						<div class="addOnBtn col-xs-4 col-md-2 col-sm-2" style="" data-adID="{{$ad->id}}" data-addOnID="{{$add_on_package[$ad->id]["bump"]["packageID"]}}" data-addOnType="Auto-Bump">
							Bump
						</div>
						@endif
					</div>
					@endif
				</div>

				{{ csrf_field() }}
			</form>
			@endforeach
		@elseif($checkMethod == 'publish' || $checkMethod == '')
		<div class="col-lg-12 col-md-12 col-xs-12 form-rows bottom-border"><h6 class="admin-portal-title-blue">{{trans('empty-message.nopublishedads')}}</h6></div>
		@elseif($checkMethod == 'draft')
		<div class="col-lg-12 col-md-12 col-xs-12 form-rows bottom-border"><h6 class="admin-portal-title-blue">{{trans('empty-message.nodraftads')}}</h6></div>
		@endif
	</div>
	{!! $ads->appends(Request::except('page'))->links() !!}
	<button type="button" id="modalClicker" class="btn btn-info btn-lg" data-toggle="modal" data-target="#placeAdsSuccessModal" style="display: none;"></button>
</div>

<!-- Modal -->
<div id="placeAdsSuccessModal" class="modal fade" role="dialog" style="margin-top: 100px;">
    <div class="modal-dialog">
        <div class="modal-content register-success-modal-box">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body register-success-modal">
                <i class="fa fa-check" aria-hidden="true"></i><br/>
                <h3 id="modalTitle"></h3>
                <br/>
                <h6 id="modalDescription"></h6>
            </div>
        </div>
    </div>
</div>
<form id="purchaseAddOnForm" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
  <input id="purchaseAddOnAdsID" type="hidden" name="purchaseAddOnAdsID" class="form-control" value=""  />
  <input id="purchaseAddOnPackageID" type="hidden" name="purchaseAddOnPackageID" class="form-control" value=""  />
</form>

<!-- confirm add on modal -->
<div id="confirmAddOnModal" class="modal fade" role="dialog" style="margin-top: 100px;">
    <div class="modal-dialog">
        <div class="modal-content ">
            <div class="modal-header" id="confirmAddOnModalTitle">
            </div>
            <div class="modal-body">
            <h4 id="confirmAddOnDescription"></h4>

            </div>
            <div class="modal-footer">
	            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	            <button id="confirmPurchaseAddOnBtn" data-addOnID="" class="btn btn-primary btn-ok">Confirm</button>
	        </div>
        </div>
    </div>
</div>

<script type="text/javascript">
	$( document ).ready(function() {

		var isPlaceAds = getParameterByName('success', $(location).attr('href'));

        if(isPlaceAds == 'place'){

        	$('#modalTitle').append("{{trans('message-box.adsplacedsuccessfully')}}");
        	$('#modalDescription').append("{{trans('message-box.youadsispublished')}}");
            setTimeout(function(){
                $('#modalClicker').click();
           }, 100);

            window.history.replaceState('', 'b4mx.com', '/getActiveAdsPage');
        }
        else if(isPlaceAds == 'save'){

        	$('#modalTitle').append("{{trans('message-box.adssavedsuccessfully')}}");
        	$('#modalDescription').append("{{trans('message-box.youradsissavedandeditable')}}");
        	setTimeout(function(){
                $('#modalClicker').click();
           }, 100);

        	window.history.replaceState('', 'b4mx.com', '/getActiveAdsPage');
        }
        else if(isPlaceAds == 'edit'){

        	$('#modalTitle').append("{{trans('message-box.adssavedsuccessfully')}}");
        	$('#modalDescription').append("{{trans('message-box.yourupdatedadsdetailsissaved')}}");
        	setTimeout(function(){
                $('#modalClicker').click();
           }, 100);

        	window.history.replaceState('', 'b4mx.com', '/getActiveAdsPage');
        }

		if( '{{ $checkMethod }}'  == 'draft'){
			$("#daysLeft").css("display", "none");
			$("#tab0").removeClass("tab-buttons-active");
			$("#tab1").removeClass("tab-buttons-active");

			$("#tab0").addClass("tab-buttons-active");
			$("#tab1").addClass("tab-buttons");

			$(".publish-buttons").css("display", "none");	
			$(".adsStatus").css("display", "none");		
			$(".view-buttons").css("display", "none");	
			$(".edit-buttons").text("{{trans('buttons.publish')}}");	
		}
		else{
			$("#daysLeft").css("display", "none");
			$("#tab0").removeClass("tab-buttons-active");
			$("#tab1").removeClass("tab-buttons-active");

			$("#tab0").addClass("tab-buttons");
			$("#tab1").addClass("tab-buttons-active");

			$(".publish-buttons").css("display", "inline-block");	
			$(".adsStatus").css("display", "none");	
			$(".view-buttons").css("display", "inline-block");		
			$(".edit-buttons").text("{{trans('buttons.edit')}}");
		}

		$('.delete-buttons').click(function(e){
			e.preventDefault();

			if (confirm("{{trans('message-box.areyousureyouwanttodelete')}}")) {
				var selectedAdsId = $(this).attr('data-id');
				$('#del-' + selectedAdsId).click();
			}
		});
		$(".addOnBtn").click(function(){
			$("#confirmAddOnModal").modal("show");
			$("#confirmAddOnModalTitle").html("Confirm Purchase");
			$("#confirmAddOnDescription").html("Are you sure to purchase "+$(this).attr('data-addOnType')+" Add On?");
			$("#confirmPurchaseAddOnBtn").attr('data-addOnID',$(this).attr('data-addOnID'));
			$("#confirmPurchaseAddOnBtn").attr('data-adID',$(this).attr('data-adID'));
		})
		$("#confirmPurchaseAddOnBtn").click(function(){
			console.log(this);
			$("#purchaseAddOnAdsID").val($(this).attr('data-adID'));
			$("#purchaseAddOnPackageID").val($(this).attr('data-addOnID'));
			var formData = $("#purchaseAddOnForm").serialize();
			console.log(formData);

			$.post(location.protocol + '//' + location.host+"/purchaseAddOn", formData, function(r){
		      console.log("r");
		      console.log(r);
		      if(r.status == "error"){
		        //alert(r.msg);
		        window.location.reload();
		      }else{
		       // alert(r.msg);
		       window.location.href = r.redirectLink;
		      }
		      //window.location.reload();

		    },'json').fail(function(e){
		      console.log("failed");
		      console.log(e);
		    });
		})
		
	});

	
</script>
	
@endsection
