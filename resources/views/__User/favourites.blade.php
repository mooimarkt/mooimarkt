@extends('layouts.app')

@section('content')

<div class="container">
	<div class="col-lg-12 col-md-12 col-xs-12 margin-bottom visible-xs">
		<br/>
		<div id="backBtnDiv" class="back-button-link">❮ {{trans('buttons.back')}}</div>
	</div>
	
	<div class="row">
		<form method="GET" action="{{ url('getFavouritesPage') }}">
	        <div class="col-lg-12 col-md-12 col-xs-12 tab-button-div">
	        	<div class="col-lg-4 col-md-4 col-xs-4 tab-button-column">
					<button id="tab2" class="tab-buttons-active" name="btnMethod" value="all" style="text-transform: uppercase;">{{trans('buttons.all')}}</button>
				</div>
				<div class="col-lg-4 col-md-4 col-xs-4 tab-button-column">
					<button id="tab1" class="tab-buttons-middle" name="btnMethod" value="active" style="text-transform: uppercase;">{{trans('buttons.active')}}</button>
				</div>
				<div class="col-lg-4 col-md-4 col-xs-4 tab-button-column">
					<button id="tab0" class="tab-buttons" name="btnMethod" value="sold" style="text-transform: uppercase;">{{trans('action.sold')}}</button>
				</div>
			</div>
		</form>
		@if(count($ads) > 0)
			<div id="displayFavouriteSection">
				@foreach($ads as $ad)
				<div class="col-lg-12 col-md-12 col-xs-12 form-rows bottom-border margin-bottom">
					<br/>
					<div class="col-lg-4 col-md-4 col-xs-5 active-ads-image-div">
						<div class="favourites-img" style="background-image: url({{ $ad->adsImage }});"></div>
						<br/><br/>
					</div>
					<div class="col-lg-8 col-md-8 col-xs-7">
						<div class="col-lg-12 col-md-12 col-xs-12" style="padding: 0;">
							<div class="form-group">
								<div class="row">	
									<div class="col-lg-12 col-md-12 col-xs-12">
										<h6 class="recently-ads-title" style="margin-top: 0;">{{ $ad->adsName }}</h6>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12 col-md-12 col-xs-12">
										<h6 class="recently-ads-details" style="margin-left: 0;">{{ $ad->adsRegion }}, {{ $ad->adsCountry }}</h6>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12 col-md-12 col-xs-12">
									@if(date_diff(date_create(date("Y-m-d H:i:s")),date_create($ad->sortingDate))->format("%m") > 0)
										{{ date_diff(date_create(date("Y-m-d H:i:s")),date_create($ad->sortingDate))->format("%m") }} month(s) ago
									@elseif(date_diff(date_create(date("Y-m-d H:i:s")),date_create($ad->sortingDate))->format("%a") > 0)
										{{ date_diff(date_create(date("Y-m-d H:i:s")),date_create($ad->sortingDate))->format("%a") }} day(s) ago
									@elseif(date_diff(date_create(date("Y-m-d H:m:s")),date_create($ad->sortingDate))->format("%h") > 0)
										{{ date_diff(date_create(date("Y-m-d H:i:s")),date_create($ad->sortingDate))->format("%h") }} hour(s) ago
									@elseif(date_diff(date_create(date("Y-m-d H:m:s")),date_create($ad->sortingDate))->format("%i") > 0)
										{{ date_diff(date_create(date("Y-m-d H:i:s")),date_create($ad->sortingDate))->format("%i") }} minute(s) ago
									@else
										{{ date_diff(date_create(date("Y-m-d H:i:s")),date_create($ad->sortingDate))->format("%s") }} second(s) ago
									@endif
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12 col-md-12 col-xs-12">
										<h6 class="info-pages-price" style="margin-left: -15px;">{{ Session::get('currency') }} {{ number_format($ad->adsPrice / Session::get('forexRate'),2) }}</h6>
									</div>
								</div>	
								<br/>
							</div>
						</div>	
						<button value="btnView" name="btnSubmitActiveAds" class="manage-ads-buttons-active uppercase-text adsClick" data-id="{{ $ad->adsId }}" style="margin-top:0;">{{trans('buttons.view')}}</button>			
						<button type="submit" class="delete-buttons-active uppercase-text margin-bottom btnFavouriteDelete" id="btnFavouriteDelete" data-id="{{ $ad->id }}">{{trans('buttons.delete')}}</button>
						<br/><br/>
					</div>
				</div>
				@endforeach
			</div>
		@elseif($checkMethod == 'sold')
		<div class="col-lg-12 col-md-12 col-xs-12 form-rows bottom-border"><h6 class="admin-portal-title-blue">{{trans('empty-message.nosoldfavourites')}}</h6></div>
		@elseif($checkMethod == 'active')
		<div class="col-lg-12 col-md-12 col-xs-12 form-rows bottom-border"><h6 class="admin-portal-title-blue">{{trans('empty-message.noactivefavourites')}}</h6></div>
		@elseif($checkMethod == 'all' || $checkMethod == '')
		<div class="col-lg-12 col-md-12 col-xs-12 form-rows bottom-border"><h6 class="admin-portal-title-blue">{{trans('empty-message.noallfavourites')}}</h6></div>
		@endif
	</div>
@if( count($ads) > 0 )

{{ $ads->links() }}

@endif
</div>

<script>
	$( document ).ready(function() {

        $('.adsClick').click(function(){

            var adsId = $(this).attr('data-id');
            window.location.href = '/getAdsDetails/'+ adsId;
        });

		if( '{{ $checkMethod }}' == 'sold'){
			$("#tab0").removeClass("tab-buttons-active");
			$("#tab1").removeClass("tab-buttons-middle-active");
			$("#tab2").removeClass("tab-buttons-active");

			$("#tab0").addClass("tab-buttons-active");
			$("#tab1").addClass("tab-buttons-middle");
			$("#tab2").addClass("tab-buttons");
		}
		else if( '{{ $checkMethod }}' == 'active'){
			$("#tab0").removeClass("tab-buttons-active");
			$("#tab1").removeClass("tab-buttons-middle-active");
			$("#tab2").removeClass("tab-buttons-active");

			$("#tab0").addClass("tab-buttons");
			$("#tab1").addClass("tab-buttons-middle-active");
			$("#tab2").addClass("tab-buttons");
		}
		else{
			$("#tab0").removeClass("tab-buttons-active");
			$("#tab1").removeClass("tab-buttons-middle-active");
			$("#tab2").removeClass("tab-buttons-active");

			$("#tab0").addClass("tab-buttons");
			$("#tab1").addClass("tab-buttons-middle");
			$("#tab2").addClass("tab-buttons-active");
		}


		$('.btnFavouriteDelete').click(function(){
			
			var id = $(this).attr('data-id');

			if (confirm("{{trans('message-box.areyousureyouwanttodelete')}}")) {

				$.ajax({
		            type: "POST",
		            url: 'deleteFavourite',
		            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		            data: ({ "id": id }),
		            dataType: "html",
		            success: function(data) {
		     
		                if(data.success = 'success'){
		                	alert("{{trans('message-box.deletedsuccessfully')}}");
		                  $("#displayFavouriteSection").load(" #displayFavouriteSection");
		                }
		                else{
		                  alert("{{trans('message-box.somethingwrong')}}");
		                }
		                  
		              },
		              error: function() {
		                  alert("{{trans('message-box.somethingwrong')}}");
		              }
		        });
		    }
		});
	});

</script>
	
@endsection
