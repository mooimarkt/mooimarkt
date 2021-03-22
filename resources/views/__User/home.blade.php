@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<!-- Search Section -->
		<div class="col-lg-12 col-md-12 col-xs-12 search-section-div" style="min-height:350px;background-position: center;background-size:cover;background-image: url({{$data['imgSearchBackground']}});">
			<div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-3 col-lg-7 col-md-7 col-sm-7 col-xs-9" style="margin-top:30px;">
				{!!$data['allYouNeedForMotorcrossHTML']!!}
				@guest
                <span style="color: white; font-size: 12pt;">{{trans('instruction-terms.notamember')}}</span><a class="btn btn-link red-link-bold uppercase-text" style="font-size: 12pt; padding-bottom:12px;" href="{{ url('getRegisterPage') }}">{{trans('buttons.signup')}}!</a>
                @endguest
                @auth
                <?php 
                	$welcomeText = str_replace("[name]",'<span style="color:black;font-size:30px;font-weight:bold;word-wrap: break-word;">'.Auth::user()->name.'!</span>',trans('instruction-terms.homeWelcomeBack'));
                ?>

	                <span style="color: white; font-size: 12pt;">{!!$welcomeText!!}</span>
                @endauth
				<!--<button class="home-search-btn uppercase-text" style="width: 95%;">{!!$data['searchOurMotocross']!!}</button>-->
				<div class="search-box-div">
					<div class="input-group">
				        <input type="search" id="txtHomeSearch" class="form-control home-search-txt" placeholder="{{$data['searchOurMotocross']}}" />
				        <div class="input-group-btn">
							<button id="btnHomeSearch" class="btn btn-primary" type="">
								<span class="glyphicon glyphicon-search"></span>
							</button>
				        </div>
			        </div>
					<!--<input type="search" id="txtHomeSearch" placeholder="&#xF002; Search" class="home-search-txt" style="font-family:Arial, FontAwesome;"></input>
					<button class="blue-search-btn uppercase-text" id="btnHomeSearch" style="width: 20%;">{{trans('buttons.search')}}</button>-->
					<div id="suggestion-box" class="suggestion-div" style="display: none;">
						<ul id="suggestion-list" class="suggestion-list-ul">
						</ul>
					</div>
				</div>	
				<div style="font-weight: bold;margin-top:10px;margin-bottom:10px;">OR</div>
				<div class="filter-box-div" style="">
					<button onclick="window.location.href='{{ url('getAllAds?filter=1')}}'" class="btn " style="font-size:18px;font-weight: bold;background-color: white;">{{trans('label-terms.homepageFilter')}}</button>
				</div>			
			</div>
		</div>

		<!-- Section Divider -->
		<div class="col-lg-12 col-md-12 col-xs-12 title-section-div">
			<br/>
			{!!$data['shopEverything']!!}<br/>
			<a href="{{ url('getAllAds')}}" class="see-all-button-link" style="font-size: 11pt;">{{trans('instruction-terms.seeall')}} ❯</a>
		</div>

		<div class="col-lg-6 col-md-6 col-xs-6 category-section-div" style="background-size:cover;background-image: url({{'img/category/browse_everything.jpg'}});">
			<a href="{{ url('getAllAds')}}"><h5 class="home-category-title">{{ trans('label-terms.browseeverything')}}</h5></a>
		</div>
		<!-- Category Section -->
		@foreach($categories as $category)
			<div class="col-lg-6 col-md-6 col-xs-6 category-section-div" style="background-image: url({{ $category->categoryImage }});">
				<a href="{{ url('getAdsByCategory', ['categoryId' => $category->id]) }}"><h5 class="home-category-title">
					@if(count(explode(".", trans('categories.'.$category->categoryName))) > 1)
						{{ explode(".", trans('categories.'.$category->categoryName))[1] }}
					@else
						{{ trans('categories.'.$category->categoryName) }}
					@endif
					</h5></a>
			</div>
		@endforeach
		
		<!-- Section Divider -->
		<div class="col-lg-12 col-md-12 col-xs-12 title-section-div" style="display: inline;">
			<br/>
			{!!$data['recentlyAds']!!}<br/><br/>
			<a href="{{ url('getAllAds')}}" class="see-all-button-link" style="font-size: 11pt;">{{trans('instruction-terms.seeall')}} ❯</a>
		</div>
		<!-- Recently Ads Section -->
		<div class="col-lg-12 col-md-12 col-xs-12 recently-ads-section-div">
			<div id="featured-ads-carousel" class="owl-carousel owl-theme recently-carousel">
				@foreach($ads as $ad)
				<div class="item">
					@if( ($ad->spotLightDate != null) && ( date("Y-m-d H:i:s") >= date("Y-m-d H:i:s", strtotime($ad->spotLightDate)) ) && ( date("Y-m-d H:i:s") <= date("Y-m-d H:i:s", strtotime($ad->spotLightDate .' +1 days')) ) )
					<span style="z-index: 99; position: relative; top: 45px; left: 15px; padding: 5px; font-weight: bold; color: #fff; background-color: #dd5347">Spotlight</span>
					@else
					<span style="z-index: 99; position: relative; top: 45px; left: 15px; padding: 5px; font-weight: bold;"></span>
					@endif
					<div class="recently-ads-item">
						<div data-id="{{ $ad->id }}" class="adsClick" style="border-bottom: 1px solid #e0e0e0;">
							<div class="browse-ads-img" style="background-image: url({{ asset($ad->adsImage) }});"></div>
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
												<h6 class="recently-ads-details">
													@if(count(explode(".", trans('formfields.'.$adsData->fieldTitle))) > 1)
														{{ explode(".", trans('formfields.'.$adsData->fieldTitle))[1] }}
													@else
														{{ trans('formfields.'.$adsData->fieldTitle) }}
													@endif : {{$adsData->text}}</h6>
											</div>
										</div>
									@endif
								@endforeach	
							@endif
							<br/>			
						</div>
						<div>
							<div class="row">
								<div class="col-lg-9 col-md-9 col-xs-9">
									<div class="row">
										<h6 class="recently-ads-price">{{ Session::get('currency') }} {{ number_format($ad->adsPrice / Session::get('forexRate'),2) }}</h6>
									</div>
								</div>
								<div class="col-lg-3 col-md-3 col-xs-3">
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
				@endforeach
			</div>
		</div>

		<!-- Section Divider
		<div class="col-lg-12 col-md-12 col-xs-12 title-section-div">
			{!!$data['featuredBrands']!!}
		</div>

		Featured Brands Section 
		<div class="col-lg-12 col-md-12 col-xs-12 brands-section-div">
			@if($data['imgBrandsImage'] !== "empty")
				@foreach($data['imgBrandsImage'] as $brandimage)
				<div class="col-lg-2 col-md-2 col-xs-3">
					<div class="featured-brands-img" style="background-image: url({{$brandimage}}"></div>
				</div>
				@endforeach
			@endif
		</div>-->

		<!-- Share Experience Section -->
		<div class="col-lg-12 col-md-12 col-xs-12 share-experience-section-div">
			<div class="col-lg-2 col-md-2 col-xs-2">
				<i class="fa fa-commenting" aria-hidden="true"></i>
			</div>
			<div class="col-lg-8 col-md-8 col-xs-8">
				{!!$data['feedback']!!}
			</div>
			<div class="col-lg-2 col-md-2 col-xs-2">
				<div class="mcwidget-embed" data-widget-id="1771615"></div>
			</div>
		</div>
	</div>
</div>

<!-- Scripts -->
<script src="{{ asset('owlcarousel/owl.carousel.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {	

    	var host = location.protocol + '//' + location.host;

    	$('.share-experience-section-div').click(function(){
    		window.location.href = "{{ url('getFeedbackPage') }}";
    	});

    	if('{{ Auth::check() }}' == '1'){

    		if({!!$favourite!!} != 'none'){
	    		$favouriteList = [{!!$favourite!!}];
		    	$.each($favouriteList[0], function( key, value ) {
		    		if(value["wishlistStatus"] == "active"){
						$('[data-id=fav-' + value["adsId"] + ']').css('color','#da444b');
						$('[data-id=fav-' + value["adsId"] + ']').css('text-shadow','#da444b 0px 0px 1px');
					}
				});
		    }

    		$('.btnFavourite').click(function(){

				var adsId = $(this).attr('data-id').replace('fav-','');

				$.ajax({
	                type: "POST",
	                url: 'addFavourite',
	                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	                data: ({ "adsId": adsId }),
	                success: function(data) {

	                    if(data.success = "success"){

	                    	if(data.type == "unavailable"){
	                    		$('[data-id=fav-' + adsId + ']').css('color','#ffffff');
	                        	$('[data-id=fav-' + adsId + ']').css('text-shadow','#000000 0px 0px 1px');
	                    	}
	                    	else{
	                    		$('[data-id=fav-' + adsId + ']').css('color','#da444b');
	                        	$('[data-id=fav-' + adsId + ']').css('text-shadow','#da444b 0px 0px 1px');
	                    	}
	                    }
	                    
	                },
	                error: function() {
	                    alert("{{trans('message-box.somethingwrong')}}");
	                }
	            });
			});
    	}
    	else{
    		$('.btnFavourite').click(function(){
    			window.location.href = '{{url("getLoginPage")}}';
			});
    	}

		$('#featured-dealer-carousel').owlCarousel({
			rtl:false,
			loop:false,
			margin:10,
			nav:true,
			dots:false,
            navText:['<','>'],
			responsive:{
				0:{
					items:1
				},
				768:{
					items:1
				},
				1080:{
					items:1
				}
			}
		});

		$('#featured-ads-carousel').owlCarousel({
			rtl:false,
			loop:false,
			margin:10,
			nav:true,
			dots:false,
            navText:['<','>'],
			responsive:{
				0:{
					items:2
				},
				768:{
					items:3
				},
				1080:{
					items:5
				}
			}
		});

		$('.adsClick').click(function(){

			var adsId = $(this).attr('data-id');
			window.location.href = '/getAdsDetails/'+ adsId;
		});

		$('#btnHomeSearch').click(function (e){
			if($('#txtHomeSearch').val() == "" || $('#txtHomeSearch').val().replace(" ","")  == ""){
				alert("{{trans('message-box.pleaseenterkeyword')}}");
			}
			else{
	        	window.location.href = '/getAdsByName/'+ $('#txtHomeSearch').val();  
	        }
	     });

		$('#txtHomeSearch').keyup(function (e){

	        if(e.keyCode == 13){
	        	if($(this).val() == "" || $(this).val().replace(" ","")  == ""){
					alert("{{trans('message-box.pleaseenterkeyword')}}");
				}
				else{
		        	window.location.href = '/getAdsByName/'+ $(this).val();  
		        }
			}
			else if(e.keyCode == 8 || e.keyCode >= 48 && e.keyCode <= 57 || e.keyCode >= 65 && e.keyCode <= 90 || e.keyCode >= 96 && e.keyCode <= 105){

				var path = host + '/getSearchSuggestion';
				var word = $(this).val();

				$.ajax({
				      type: "GET",
				      url: path,
				      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				      data: ({ "searchword": word} ),
				      success: function(data) {

				       	if(data.success == "success"){
				       		
				       		$('#suggestion-list').children().remove().end();

				       		if(data.test != null){
				       			if(data.ads.length > 0){
					       			$('#suggestion-box').css('display','block');

					       			for(var i = 0; i < data.ads.length; i++){

					       				var formFieldOptionValue = "";

					       				for(var j = 0; j < data.formField.length; j++){

					       					console.log(data.formField[j].adsId + data.formField[j].adsValue);
					       					if(data.formField[j].adsId == data.ads[i].id){
						       					formFieldOptionValue += data.formField[j].adsValue + " / ";
						       				}
					       				}

						       			if(i == data.ads.length - 1){					       					

							       			$('#suggestion-list').append('<li class="suggestion-result" onclick="searchBySuggestion(\'' + data.ads[i].id + '\');" data-name="' + data.ads[i].adsName + '">' + data.ads[i].adsName + '<br/> ► ' + formFieldOptionValue + '</li>');
							       		}
							       		else{
							       			$('#suggestion-list').append('<li class="suggestion-result border-bottom-list" onclick="searchBySuggestion(\'' + data.ads[i].id + '\');" data-name="' + data.ads[i].adsName + '">' + data.ads[i].adsName + '<br/> ► ' + formFieldOptionValue + '</li>');
							       		}
						       		}
						       	}
						       	else{
						       		$('#suggestion-box').css('display','none');
						       	}
				       		}
				       		else{
				       			$('#suggestion-box').css('display','none');
				       		}
				        }
				        else{

				          alert("{{trans('message-box.somethingwrong')}}");
				        }
				          
				      },
				      error: function(xhr) {

				          //alert('Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText);
				      }
			    });
			}
	     });

		var maxHeight = 0;

		$(".adsClick").each(function(){
		   if ($(this).height() > maxHeight) { maxHeight = $(this).height(); }
		});

		$(".adsClick").height(maxHeight);
    });

    $('.breadcrumb-class').css("display","none");

    function searchBySuggestion(adsId){
    	window.location.href = '/getAdsDetails/'+ adsId;  
    }

    /*function timeDifference(date1,date2) {
        var difference = date1.getTime() - date2.getTime();

        var daysDifference = Math.floor(difference/1000/60/60/24);
        difference -= daysDifference*1000*60*60*24

       var hoursDifference = Math.floor(difference/1000/60/60);
        difference -= hoursDifference*1000*60*60

        var minutesDifference = Math.floor(difference/1000/60);
        difference -= minutesDifference*1000*60

        var secondsDifference = Math.floor(difference/1000);

     alert('difference = ' + daysDifference + ' day/s ' + hoursDifference + ' hour/s ' + minutesDifference + ' minute/s ' + secondsDifference + ' second/s ');*/
</script>

@endsection
