<input type="hidden" id="hiddenQuery" value="{{ $hiddenQuery }}" name="hiddenQuery">
<input type="hidden" id="hiddenSearchString" value="{{ $searchString }}" name="hiddenSearchString">
<div class="col-lg-12 col-md-12 col-xs-12">
	<div class="results-number-title">{{$resultsCount}} {{trans('label-terms.results')}}</div>
</div>
@if(count($ads) > 0)
	<div class="col-lg-offset-1 col-md-offset-1 col-lg-10 col-md-10 col-xs-12 rowse-section-div">
		@foreach ($ads as $ad)
		<div class="col-lg-3 col-md-3 col-xs-6 browse-section-div">
			<div class="row">
				@if( ($ad->spotLightDate != null) && ( date("Y-m-d H:i:s") >= date("Y-m-d H:i:s", strtotime($ad->spotLightDate)) ) && ( date("Y-m-d H:i:s") <= date("Y-m-d H:i:s", strtotime($ad->spotLightDate .' +1 days')) ) )
					<span style="z-index: 99; position: relative; top: 45px; left: 15px; padding: 5px; font-weight: bold; color: #fff; background-color: #dd5347">Spotlight</span>
				@else
				<span style="z-index: 99; position: relative; top: 45px; left: 15px; padding: 5px; font-weight: bold;"></span>
				@endif
				<div class="browse-item">
					<div data-id="{{ $ad->id }}" class="adsClick" style="border-bottom: 1px solid #e0e0e0;">
						<div class="browse-ads-img" style="background-image: url({{ asset($ad->adsImage) }});"></div>
						<div class="browse-details-div">
							<div class="row">
								<div style="padding-left: 20px;">
									<h6 class="recently-ads-title">{{ $ad->adsName }}</h6>
								</div>
							</div>
							<div class="row">
								<div style="padding-left: 20px;">
									<h6 class="recently-ads-details">{{ $ad->adsRegion }}, {{ $ad->adsCountry }}</h6>
								</div>
							</div>
							<div class="row">
								<div style="padding-left: 20px;">
									<br/>
								</div>
							</div>
							@if(array_key_exists ( $ad->id , $adsDatas ))
								@foreach($adsDatas[$ad->id] as $adsData)
									@if($adsData->adsId == $ad->id)
										<div class="row">
											<div style="padding-left: 20px;">
												<h6 class="recently-ads-details">@if(count(explode(".", trans('formfields.'.$adsData->fieldTitle))) > 1)
														{{ explode(".", trans('formfields.'.$adsData->fieldTitle))[1] }}
													@else
														{{ trans('formfields.'.$adsData->fieldTitle) }}
													@endif : {{$adsData->adsValue}}</h6>
											</div>
										</div>
									@endif
								@endforeach	
							@endif	
							<div class="row">
								<div class="col-lg-9 col-md-9 col-xs-9 list-view-price" style="display:none;">
									<div class="row">
										<h6 class="list-recently-ads-price">{{ Session::get('currency') }} {{ number_format($ad->adsPrice / Session::get('forexRate'),2) }}</h6>
									</div>
								</div>										
							</div>	
						</div>
						<br/>
					</div>
					<div>
						<div class="row">
							<div class="col-lg-6 col-md-6 col-xs-12 list-view-favourite" style="display:none;">
								<div class="row">
									<div class="recently-wish-list" style="padding-left: 20px;">
										<span class="fa fa-heart btnFavourite" style="padding-left: 15px; margin-left: 0px;" data-id="fav-{{ $ad->id }}"></span>
									</div>
								</div>
							</div>
							<div class="col-lg-9 col-md-9 col-xs-9 grid-view-price">
								<div class="row">
									<h6 class="recently-ads-price">{{ Session::get('currency') }} {{ number_format($ad->adsPrice / Session::get('forexRate'),2) }}</h6>
								</div>
							</div>
							<div class="col-lg-3 col-md-3 col-xs-3 grid-view-favourite">
								<div class="row">
									<div class="recently-wish-list">
										<span class="fa fa-heart btnFavourite" style="float:right;" data-id="fav-{{ $ad->id }}"></span>
									</div>
								</div>
							</div>
						</div>	
					</div>		
				</div>
			</div>
		</div>
		@endforeach
	</div>
@else
<div class="col-lg-12 col-md-12 col-xs-12 form-rows bottom-border"><h6 class="admin-portal-title-blue">{{trans('empty-message.emptyadslisting')}}</h6></div>
@endif

<div id="refresh" class="col-lg-12 col-md-12 col-xs-12 filterPaginateList" style="text-align: center;">
	{{ $ads->render() }}
</div>

<script>

	var host = location.protocol + '//' + location.host;

	$(document).ready(function(){

		$('.filterPaginateList>ul>li>a').click(function(e){
			e.preventDefault();

			$.ajax({
                type: "GET",
                url: $(this).attr('href'),
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function(data) {

                    $('#adsResult').children().remove().end();
            		$('#adsResult').html(data.resultView);
                    
                },
                error: function() {
                    alert('Something Wrong ! Please Try Again');
                }
            });
		});


		if($("#tab0").hasClass("display-mode-icon-button-active")){
			$("#tab0").addClass("display-mode-icon-button-active");
			$("#tab1").removeClass("display-mode-icon-button-active");
			$("#tab1").addClass("display-mode-icon-button");
			$("#tab0").removeClass("display-mode-icon-button");

			$(".browse-section-div").removeClass("col-lg-12 col-md-12 col-xs-12");
			$(".browse-section-div").addClass("col-lg-3 col-md-3 col-xs-6");

			$(".browse-ads-img").removeClass("col-lg-4 col-md-4");
			$(".browse-details-div").removeClass("col-lg-8 col-md-8");

			$(".adsClick").height($('#hiddenSyncHeight').val());
			$(".adsClick").css('border-bottom','1px solid rgb(224, 224, 224)');

			$(".browse-ads-img").css("height","200px");		
			$(".browse-ads-img").css("border-radius","5px 5px 0px 0px");

			$(".grid-view-price").css("display","block");
			$(".grid-view-favourite").css("display","block");
			$(".list-view-price").css("display","none");
			$(".list-view-favourite").css("display","none");		
		}else{
			$("#tab1").addClass("display-mode-icon-button-active");
			$("#tab0").removeClass("display-mode-icon-button-active");
			$("#tab0").addClass("display-mode-icon-button");
			$("#tab1").removeClass("display-mode-icon-button");

			$(".browse-section-div").removeClass("col-lg-3 col-md-3 col-xs-6");
			$(".browse-section-div").addClass("col-lg-12 col-md-12 col-xs-12");

			$(".browse-ads-img").addClass("col-lg-4 col-md-4");
			$(".browse-details-div").addClass("col-lg-8 col-md-8");

			$(".adsClick").height('auto');
			$(".adsClick").css('border-bottom','0px none');

			$(".browse-ads-img").css("height","600px");
			$(".browse-ads-img").css("border-radius","5px 5px 5px 5px");

			$(".grid-view-price").css("display","none");
			$(".grid-view-favourite").css("display","none");
			$(".list-view-price").css("display","block");
			$(".list-view-favourite").css("display","block");
		}

        $('.adsClick').click(function(){

            var adsId = $(this).attr('data-id');
            window.location.href = '/getAdsDetails/'+ adsId;
        });

        if('{{ Auth::check() }}' == '1'){
			if({!!$favourite!!} != 'none'){
	    		$favouriteList = [{!!$favourite!!}];
		    	$.each($favouriteList[0], function( key, value ) {
		    		if(value["wishlistStatus"] == "active"){
						$('[data-id=fav-' + value["adsId"] + ']').css('color','#094084');
						$('[data-id=fav-' + value["adsId"] + ']').css('text-shadow','#094084 0px 0px 1px');
					}
				});
		    }
			
			$('.btnFavourite').click(function(){

				var adsId = $(this).attr('data-id').replace('fav-','');
				var path = host + '/addFavourite';

				$.ajax({
	                type: "POST",
	                url: path,
	                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	                data: ({ "adsId": adsId }),
	                success: function(data) {

	                    if(data.type == "unavailable"){
	                		$('[data-id=fav-' + adsId + ']').css('color','#ffffff');
	                    	$('[data-id=fav-' + adsId + ']').css('text-shadow','#000000 0px 0px 1px');
	                	}
	                	else{
	                		$('[data-id=fav-' + adsId + ']').css('color','#094084');
	                    	$('[data-id=fav-' + adsId + ']').css('text-shadow','#094084 0px 0px 1px');
	                	}
	                    
	                },
	                error: function() {
	                    alert('Something Wrong ! Please Try Again');
	                }
	            });
			});
		}
    	else{
    		$('.btnFavourite').click(function(){
    			window.location.href = '{{url("getLoginPage")}}';
			});
    	}
    });
</script>