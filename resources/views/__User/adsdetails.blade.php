@extends('layouts.app')

@section('content')

<div id="modalReportAds" class="modal fade" tabindex="-1" role="dialog" style="margin-top: 100px;">
    <div class="modal-dialog">
        <div class="modal-content register-success-modal-box" style="width: 70%;
    margin: 0 auto;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body register-success-modal" style="padding: 20px;">
                <form method="POST" id="modalReportForm" data-toggle="validator">
                	<h3 id="modalTitle">{{trans('buttons.reportthisad')}}</h3>
                    <div class="form-group">
                      	<input class="form-control" type="text" name="modaltxtName" id="modaltxtName" placeholder="{{trans('label-terms.name')}}" required>
                    </div>

                    <div class="form-group">
                      	<input class="form-control" type="email" name="modaltxtEmail" id="modaltxtEmail" placeholder="{{trans('label-terms.email')}}" required>
                    </div>

                    <div class="form-group">
                      	<input class="form-control" type="text" name="modaltxtReason" id="modaltxtReason" placeholder="{{trans('label-terms.subject')}}" required>
                    </div>  

                    <div class="form-group">
                    	<textarea class="form-control" rows="5" id="modaltxtComment" name="modaltxtComment" placeholder="{{trans('instruction-terms.tellusmoreaboutreport')}}" required></textarea>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
	            <div class="btn btn-primary btn-block submit-buttons delete-buttons-feedback" id="modalbtnReportAds" style="width:40%; margin: 0 auto;">{{trans('buttons.submit')}}</div>
          	</div>
        </div>
    </div>
</div>

<div class="container breadcrumb-class uppercase-text">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-xs-12 no-padding-column">
			{{ Breadcrumbs::render() }}
		</div>
	</div>
</div>
<div class="container" style="background-color:#eeeeee;">

	<div class="col-lg-12 col-md-12 col-xs-12 margin-bottom visible-xs">
		<br/>
		<div id="backBtnDiv" class="back-button-link">❮ {{trans('buttons.back')}}</div>
	</div>

	<div class="row">
		<!-- Ads Gallery Section -->
		<div class="col-lg-12 col-md-12 col-xs-12 browse-section-div">
			<div class="ads-details-gallery-item">
				<div class="ads-gallery-main-img row "></div>			
			</div>
			<div id="ads-gallery-carousel" class="owl-carousel owl-theme ads-gallery-carousel">

				@foreach($ads as $ad)
					<div class="item">
						<div class="ads-gallery-item">
							<div class="ads-gallery-sub-img" image-path="{{ asset($ad->adsImage) }}" style="background-image: url({{ asset($ad->adsImage) }});"></div>
						</div>
					</div>
					@foreach($images as $adsImages)
						@if($adsImages->imagePath != $ad->adsImage)
							<div class="item">
								<div class="ads-gallery-item">
									<div class="ads-gallery-sub-img" image-path="{{ asset($adsImages->imagePath) }}" style="background-image: url({{ asset($adsImages->imagePath) }});"></div>
								</div>
							</div>
						@endif
					@endforeach
				@endforeach
			</div>
			<br/><br/><br/><br/>
		</div>

		<div class="col-lg-12 col-md-12 col-xs-12 browse-section-div">
			<div class="row ads-seller-section">
				<div class="row ads-details-rows">
					<div class="col-lg-12 col-md-12 col-xs-12">
						<h6 class="ads-details-make-model-title">{{ $ad->adsName }}</h6>
					</div>
				</div>
				<div class="row ads-details-rows">
					<div class="col-lg-12 col-md-12 col-xs-12">
						<h6 class="ads-details-price-title">{{ Session::get('currency') }} {{ number_format($ad->adsPrice / Session::get('forexRate'),0) }}</h6>
					</div>
				</div>
				<div class="row ads-details-rows">
					<div class="col-lg-12 col-md-12 col-xs-12">
						<a id="facebookShareLink" href="#" target="_blank"><i class="fa fa-facebook-square facebook-share-icon" aria-hidden="true"></i></a>
						<a id="twitterShareLink" href="#" target="_blank"><i class="fa fa-twitter-square twitter-share-icon" aria-hidden="true"></i></a>
						<a id="googleShareLink" href="#" target="_blank"><i class="fa fa-google-plus-square google-share-icon" aria-hidden="true"></i></a>
						<span href="#" target="_blank"><i class="fa fa-link copy-link-icon" aria-hidden="true" onclick="copyToClipboard();"></i></span>
						&nbsp;&nbsp;&nbsp;
						<span class="ads-details-description-content" style="word-wrap: break-word;"><i class="fa fa-eye" aria-hidden="true"></i> {{ $adsCount }} {{trans('label-terms.views')}}</span>
						&nbsp;&nbsp;&nbsp;
						<span class="ads-details-description-content" style="word-wrap: break-word; color: #3b5998; font-weight: bold;">
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
						</span>
					</div>
				</div>
			</div>
		</div>

		<!-- Ads General Info -->
		<form method="GET" action="{{ url('createNewInbox') }}">
			@foreach($ads as $ad)
				<div class="col-lg-12 col-md-12 col-xs-12 browse-section-div">
					<div class="row form-field-section">
						<div class="ads-details-rows">
							<div class="col-lg-12 col-md-12 col-xs-12">
								<h6 class="ads-dealer-information-title">{{ trans('label-terms.description') }}</h6>
							</div>
						</div>

						<div class="row ads-details-rows">
							<div class="col-lg-12 col-md-12 col-xs-12">
								<p class="ads-details-description-content" style="word-wrap: break-word; font-size: 12pt;">{{ $ad->adsDescription }}</p>
							</div>
						</div>
					</div>
				</div>

				<div class="col-lg-12 col-md-12 col-xs-12 browse-section-div">
					<div class="row form-field-section" style="padding-top: 25px;">

						@foreach($adsDatas as $adsData)
							<div class="row ads-details-rows">
								<div class="col-lg-6 col-md-6 col-xs-6">
									<h6 class="ads-details-criteria-label">
									@if(count(explode(".", trans('formfields.'.$adsData->fieldTitle))) > 1)
                                        {{ explode(".", trans('formfields.'.$adsData->fieldTitle))[1] }}
                                    @else
                                        {{ trans('formfields.'.$adsData->fieldTitle) }}
                                    @endif</h6>
								</div>
								<div class="col-lg-6 col-md-6 col-xs-6">
									<h6 class="ads-details-criteria-details">
										{{$adsData->text}}</h6>
								</div>
							</div>
						@endforeach
					</div>
				</div>

				<!-- Seller Info -->
				<div class="col-lg-12 col-md-12 col-xs-12 ads-seller-section-div">
					<div class="row ads-seller-section">	
						<div class="row ads-details-rows">
							<div class="col-lg-12 col-md-12 col-xs-12">
								<h6 class="ads-dealer-information-title">{{ trans('label-terms.dealersinformation') }}</h6>
							</div>
						</div>
						<div class="row ads-details-rows">
							<div class="col-lg-12 col-md-12 col-xs-12">
								<div class="form-group">
				    			    <label for="dealerNameLbl">{{trans('label-terms.name')}}</label>
				    			    <h6 id="dealerNameLbl" name="dealerNameLbl" class="form-control ads-dealer-information-details">{{ $ad->name }}</h6>
				    		  	</div>
				    		  </div>
					  	</div>
					  	@if($ad->phoneContactType == "1")
						  	@guest
						  	@else
						  	<div class="row ads-details-rows">
						  		<div class="col-lg-12 col-md-12 col-xs-12">
									<div class="form-group">
					    			    <label for="dealerNameLbl">{{trans('label-terms.phone')}}</label>
					    			    <h6 id="phoneLbl" name="dealerNameLbl" class="form-control ads-dealer-information-details">{{ str_repeat("*", strlen($ad->adsContactNo)) }} <span class="show-phone-btn">Show</span></h6>		    			    
					    		  	</div>
					    		  </div>
						  	</div>
						  	@endguest
					  	@endif
					  	@if($ad->emailContactType == "1")
					  	<div class="row ads-details-rows">
					  		<div class="col-lg-12 col-md-12 col-xs-12">
								<div class="form-group">
				    			    <label for="dealerNameLbl">{{trans('label-terms.email')}}</label>
				    			    <h6 id="dealerNameLbl" name="dealerNameLbl" class="form-control ads-dealer-information-details">{{ $ad->email }}</h6>
				    		  	</div>
				    		  </div>
					  	</div>
					  	@endif
					  	<div class="row ads-details-rows">
					  		<div class="col-lg-12 col-md-12 col-xs-12">
								<div class="form-group">
				    			    <label for="dealerNameLbl">{{trans('label-terms.location')}}</label>
				    			    <h6 id="dealerNameLbl" name="dealerNameLbl" class="form-control ads-dealer-information-details">{{ $ad->adsRegion }}, {{ $ad->adsCountry }}</h6>
				    		  	</div>
				    		  </div>
					  	</div>


				  		<input type="hidden" class="phoneNoHidden" value="+{{ $ad->adsCallingCode }} {{ $ad->adsContactNo }}">
				  	</div>
				</div>
				{!! Form::hidden('senderUserId', $ad->userId) !!}
				{!! Form::hidden('adsId', $ad->id) !!}
				<input type="hidden" name="modalAdsId" id="modalAdsId" value="{{ $ad->id }}">
			@endforeach

			<!-- Send Message Button -->
			@if($check == "false")
				<div class="col-lg-offset-4 col-md-offset-4 col-lg-4 col-md-4 col-xs-12 form-rows">
					<br/>
					<button class="btn btn-primary btn-block submit-buttons uppercase-text"><i class="fa fa-comments" aria-hidden="true" style="float: left;
    font-size: 17pt;"></i> {{trans('buttons.messagedealer')}}</button>
					<button id="btnReportAds" class="btn btn-primary btn-block submit-buttons uppercase-text delete-buttons-feedback" data-id="{{ $ad->id }}"><i class="fa fa-exclamation-triangle" aria-hidden="true" style="float: left;
    font-size: 17pt;"></i> {{trans('buttons.reportthisad')}}</button>
					<br/>
				</div>
			@endif
		{{ csrf_field() }}
		</form>
	</div>
</div>



<script src="{{ asset('owlcarousel/owl.carousel.min.js') }}"></script>
<script type="text/javascript">
	$(document).ready(function() {	
		window.history.pushState('', 'b4mx.com', '/getAdsDetails/' + $('#modalAdsId').val());

		$('#facebookShareLink').attr('href','https://www.facebook.com/sharer/sharer.php?u=' + window.location.href);
		$('#twitterShareLink').attr('href','https://twitter.com/intent/tweet?text=Hey guys, please check {{ $ad->adsName }} in {{ $ad->adsRegion }}, {{ $ad->adsCountry }} at ' + window.location.href + ' @b4mxmotocross');
		$('#googleShareLink').attr('href','https://plus.google.com/share?url=' + window.location.href);

		var host = location.protocol + '//' + location.host;

		var imagePath = $('.ads-gallery-sub-img').attr('image-path');
		$('.ads-gallery-main-img').css("background-image","url(" + imagePath + ")");

		$('#ads-gallery-carousel').owlCarousel({
			rtl:false,
			loop:false,
			margin:10,
			nav:true,
			dots:false,
            navText:['<','>'],
			responsive:{
				0:{
					items:4
				},
				768:{
					items:6
				},
				1080:{
					items:4
				}
			}
		});

		$('.ads-gallery-sub-img').click(function(){
			var imagePath = $(this).attr('image-path');
			$('.ads-gallery-main-img').css("background-image","url(" + imagePath + ")");
		});

		$('.show-phone-btn').click(function(){
			$('#phoneLbl').html($('.phoneNoHidden').val());
		});

		$('#btnReportAds').click(function(e){

			e.preventDefault();
			$('#modalReportAds').modal('show');
		});

		$('#modalbtnReportAds').click(function(){

			if($("#modaltxtName").val() == "" || $("#modaltxtEmail").val() == "" || $("#modaltxtReason").val() == "" || $("#modaltxtComment").val() == ""){

				alert("{{trans('instruction-terms.filluptheformbelow')}}");
			}
			else{
				var path = host + '/reportAds';

				var adsId = $('#modalAdsId').val();

				var name = $('#modaltxtName').val();
				var email = $('#modaltxtEmail').val();
				var reason = $('#modaltxtReason').val();
				var comment = $('#modaltxtComment').val();

				if(name == "" || email == "" || reason == "" || comment == ""){

					alert("{{trans('message-box.pleasefillinalldetails')}}");
				}

				$.ajax({
				      type: "POST",
				      url: path,
				      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				      data: ({ "adsId": adsId, "name": name, "email": email, "reason": reason, "comment": comment }),
				      success: function(data) {

				       	if(data.success == "success"){
				       		
				       		alert("{{trans('message-box.thereportisrecorded')}}");
				       		$('#modalReportAds').modal('hide');
				       		$('#modaltxtName').val('');
				       		$('#modaltxtEmail').val('');
				       		$('#modaltxtReason').val('');
				       		$('#modaltxtComment').val('');
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

    function copyToClipboard() {
		var $temp = $("<input>");
		$("body").append($temp);
		$temp.val(window.location.href).select();
		document.execCommand("copy");
		$temp.remove();
		alert("{{trans('message-box.thelinkiscopiedtoclipboard')}}");
	}
</script>
	
@endsection
