@extends('layouts.app')

@section('content')

<form method="POST" action="addNewAds" enctype="multipart/form-data" id="placeAdsForm">
	<div class="container">
		<div class="row">
	        @if (count($errors) > 0)
			    <div class="alert alert-danger">
			        <ul>
			            @foreach ($errors->all() as $error)
			                <li>{{ $error }}</li>
			            @endforeach
			        </ul>
			    </div>
			@endif

			<!-- <div class="col-lg-12 col-md-12 col-xs-12 form-rows">
				<input type="text" name="txtBikes" placeholder="{{trans('place-ads.Bikes')}}" class="form-control" />
			</div>

			<div class="col-lg-12 col-md-12 col-xs-12 form-rows">
				<input type="text" name="txtMotor" placeholder="{{trans('place-ads.Motocross')}}" class="form-control" />
			</div> -->

			<div class="col-lg-12 col-md-12 col-xs-12 form-rows">
				<select id="dropDownCategory" name="dropDownCategory" class="form-control">
					<option>{{trans("instruction-terms.pleaseselectyouroption")}}</option>
					@foreach($category as $categories)
					<option value="{{ $categories['id'] }}">{{ $categories['categoryName'] }}</option>
					@endforeach
				</select>
			</div>

			<div class="col-lg-12 col-md-12 col-xs-12 form-rows">
				<select id="dropDownSubCategory" name="dropDownSubCategory" class="form-control">
					<option>{{trans("instruction-terms.pleaseselectyouroption")}}</option>
				</select>
			</div>

			<div class="col-lg-12 col-md-12 col-xs-12 form-rows">
				<div class="form-group">
					<div class="file-input-div">			    
						<label for="uploadPhotoTxt" class="label-buttons">{{trans('user-feedback.Choose photos to upload')}}</label> <label class="label-buttons" onclick="clearImages();">Clear</label>
						<h6 class="place-ads-photo-message">{{trans('place-ads.*Add up to 10 photos')}} (Selected Images: <span id="SelectedNo">0</span>)</h6>
						<h6 class="place-ads-photo-message">{{trans('place-ads.*Ads with photos sell twice as fast!')}}</h6>
						<div id="gallerySection" class="gallery">
					</div>
					<input type="file" name="ads_img_path[]" multiple="multiple" id="uploadPhotoTxt" maxLimit="6" class="inputfile" style="display: none;" />
			  	</div>
			</div>

			<div class="col-lg-1 col-md-1 col-xs-3 form-rows">			
				<div class="form-group form-inline right-align">
					<label class="place-ads-labels" for="place-ads-make-txt">{{trans('place-ads.Make')}}</label>
				</div>
			</div>

			<div class="col-lg-5 col-md-5 col-xs-9 form-rows">			
				<div class="form-group form-inline">
					<select id="makeDdl" class="form-control" name="dropDownMake" onchange="checkMake();">
						<option value="Kawasaki">Kawasaki</option>
						<option value="Others">Others</option>
					</select>
				</div>
			</div>

			<div class="col-lg-1 col-md-1 col-xs-3 form-rows">			
				<div class="form-group form-inline right-align">
					<label id="othersMake" class="place-ads-labels" for="othersMakeTxt">{{trans('place-ads.Others')}}</label>
				</div>
			</div>

			<div class="col-lg-5 col-md-5 col-xs-9 form-rows">			
				<div class="form-group form-inline">
					<input id="othersMakeTxt" type="text" name="txtOthersMake" placeholder="{{trans('place-ads.Please fill in the make')}}" class="form-control" />
				</div>
			</div>

			<div class="col-lg-1 col-md-1 col-xs-3 form-rows">			
				<div class="form-group form-inline right-align">
					<label class="place-ads-labels" for="place-ads-make-txt">{{trans('place-ads.Model')}}</label>
				</div>
			</div>

			<div class="col-lg-5 col-md-5 col-xs-9 form-rows">			
				<div class="form-group form-inline">
					<select id="modelDdl" class="form-control" name="txtModel" onchange="checkModel();">
						<option value="KXF 450">KXF 450</option>
						<option value="Others">Others</option>
					</select>
				</div>
			</div>

			<div class="col-lg-1 col-md-1 col-xs-3 form-rows">			
				<div class="form-group form-inline right-align">
					<label id="othersModel" class="place-ads-labels" for="othersModelTxt">{{trans('place-ads.Others')}}</label>
				</div>
			</div>

			<div class="col-lg-5 col-md-5 col-xs-9 form-rows">			
				<div class="form-group form-inline">
					<input id="othersModelTxt" type="text" name="txtOthersModel" placeholder="{{trans('place-ads.Please fill in the model')}}" class="form-control" />
				</div>
			</div>

			<div class="col-lg-1 col-md-1 col-xs-3 form-rows">			
				<div class="form-group form-inline right-align">
					<label class="place-ads-labels" for="place-ads-make-txt">{{trans('place-ads.Year')}}</label>
				</div>
			</div>

			<div class="col-lg-5 col-md-5 col-xs-9 form-rows">			
				<div class="form-group form-inline">
					<select class="form-control" name="dropDownYear">
						<option value="2007">2007</option>
						<option value="2006">2006</option>
					</select>
				</div>
			</div>

			<div class="col-lg-1 col-md-1 col-xs-3 form-rows">			
				<div class="form-group form-inline right-align">
					<label class="place-ads-labels" for="place-ads-make-txt">{{trans('place-ads.Hours')}}</label>
				</div>
			</div>

			<div class="col-lg-5 col-md-5 col-xs-9 form-rows">			
				<div class="form-group form-inline">
					<select class="form-control" name="dropDownHour">
						<option value="24.5">24.5</option>
						<option value="20">20</option>
					</select>
				</div>
			</div>

			<div class="col-lg-1 col-md-1 col-xs-3 form-rows">			
				<div class="form-group form-inline right-align">
					<label class="place-ads-labels" for="place-ads-make-txt">{{trans('place-ads.Price')}}</label>
				</div>
			</div>

			<div class="col-lg-5 col-md-5 col-xs-9 form-rows">			
				<div class="form-group form-inline" style="display: inline-block;">
					<select class="form-control" name="dropDownPriceType" style="width:50%; float: left;">
						<option value="EUR" selected>EUR</option>
						<option value="USD">USD</option>
					</select>
					<input type="text" class="form-control" name="txtAdsPrice" style="width:50%; float: right;" />
				</div>
			</div>

			<div class="col-lg-1 col-md-1 col-xs-3 form-rows">			
				<div class="form-group form-inline right-align">
					<label class="place-ads-labels" for="place-ads-make-txt">{{trans('place-ads.Swap')}}</label>
				</div>
			</div>

			<div class="col-lg-5 col-md-5 col-xs-9 form-rows">			
				<div class="form-group form-inline">
					<select class="form-control" name="dropDownSwap">
						<option value="{{trans('place-ads.Yes')}}">{{trans('place-ads.Yes')}}</option>
						<option value="{{trans('place-ads.No')}}">{{trans('place-ads.No')}}</option>
					</select>
				</div>
			</div>

			<div class="col-lg-12 col-md-12 col-xs-12 form-rows">
				<label class="place-ads-labels" for="place-ads-make-txt">{{trans('place-ads.Add Criteria')}} &nbsp;&nbsp;&nbsp;<span style="font-size: 8pt;">▶</span></label>
			</div>

			<div class="col-lg-12 col-md-12 col-xs-12 form-rows">
				<div class="form-group">
				    <label for="descriptionTxt" class="place-ads-labels">{{trans('place-ads.Description')}}</label>
				    <textarea class="form-control" rows="5" id="descriptionTxt" name="txtAdsDescription" placeholder="{{trans('place-ads.Tell us about your bike')}}"></textarea>
			  	</div>
			</div>

			<div class="col-lg-12 col-md-12 col-xs-12 form-rows">
				<div class="form-group">				    
    			    <div class="col-lg-4 col-md-4 col-xs-5 no-padding-column">	
    			    	<label for="country"  class="black-label uppercase-text">{{trans('place-ads.Location')}}</label>
    			    	<select id="country" name="txtAdsLocation" class="form-control">
    						<option value="Malaysia" selected>Malaysia</option>
    						<option value="China">China</option>
    					</select>
    			    </div>
    			    <div class="col-lg-4 col-md-4 col-xs-5 no-padding-column">	
    			    	<label for="region"></label>
    			    	<select id="region" name="dropDownAddress1" class="form-control" style="margin-top: 6px;">
    						<option value="Pulau Pinang" selected>Pulau Pinang</option>
    						<option value="Wilayah Persekutuan Kuala Lumpur">Wilayah Persekutuan Kuala Lumpur</option>
    					</select>
    			    </div>
    			    <div class="col-lg-4 col-md-4 col-xs-2 no-padding-column">	
    			    	<label for="nearme"></label>
    			    	<div class="form-control uppercase-text" data-toggle="collapse" data-target="#google-map" style="margin-top: 6px; text-align: center;"><i class="fa fa-map-marker" style="font-size: 15pt;" aria-hidden="true"></i></div>
    			    </div>
    			    <div id="google-map" class="col-lg-12 col-md-12 col-xs-12 no-padding-column collapse">	
    			    	<div id="map"></div>
    			    	<h6>Click and drag the map to choose your location</h6>
    			    </div>
    		  	</div>
			</div>

			<div class="col-lg-12 col-md-12 col-xs-12 form-rows">
				<label for="txtAdsContact">{{trans('user-feedback.Phone')}}</label>
				<input type="text" name="txtAdsContact" placeholder="{{trans('place-ads.Phone')}}" class="form-control" />
			</div>

			<!-- <div class="col-md-6 col-xs-12">
				<br/>
	            <div class="form-group">
                        <input type="radio" name="radioContactType" value="phone"> {{trans('user-register.Contact by phone or text')}}<br>
                        <input type="radio" name="radioContactType" value="message"> {{trans('user-register.Contact by b4mx message')}}<br>
                        <input type="radio" name="radioContactType" value="email"> {{trans('user-register.Contact by email')}}
	            </div>         
	        </div> -->

			<div class="col-lg-12 col-md-12 col-xs-12 form-rows">
				<button class="btn btn-primary btn-block submit-buttons" style="width: 55%;">{{trans('place-ads.PREVIEW ADVERTISEMENT')}}</button>
			</div>

			<div class="col-lg-6 col-md-6 col-xs-12">
				<div class="box">
					<div class="ribbon">
						<span>SPECIAL</span>
					</div>
					<div class="place-ads-box">
					<div class="col-lg-12 col-md-12 col-xs-12 place-ads-header">
					<h6 class="header-title">{{trans('place-ads.FEATURED ADS')}}</h6>						
					</div>
					<div class="col-lg-12 col-md-12 col-xs-12 place-ads-subheader">
					<h6 class="sub-header-title">$20</h6>    
					</div>
					<div class="col-lg-12 col-md-12 col-xs-12 place-ads-content">
					<div class="col-lg-3 col-md-3 col-xs-3">
					</div>
					<div class="col-lg-9 col-md-9 col-xs-9" style="text-align: left;">
						<h6 class="content-text"><i class="fa fa-check" aria-hidden="true"></i> {{trans('place-ads.Up to')}} 15 {{trans('place-ads.Photos')}}</h6>   
					    <h6 class="content-text"><i class="fa fa-check" aria-hidden="true"></i> 45 {{trans('place-ads.Days of Run Time')}}</h6>  
					    <h6 class="content-text"><i class="fa fa-check" aria-hidden="true"></i> {{trans('place-ads.Top list for first 5 days')}}</h6>  
					    <h6 class="content-text"><i class="fa fa-check" aria-hidden="true"></i> {{trans('place-ads.Free Renewals')}}</h6>  
					    <h6 class="content-text"><i class="fa fa-check" aria-hidden="true"></i> {{trans('place-ads.Ad View Report')}}</h6>  
					    <h6 class="content-text"><i class="fa fa-check" aria-hidden="true"></i> {{trans('place-ads.Premium Report $5 Value')}}</h6>  
					    <br/>
					</div>
					<div class="col-lg-12 col-md-12 col-xs-12">
						<button type="submit" name="placeBtn" value="featuredAds" class="btn btn-primary btn-block short-buttons uppercase-text">{{trans('buttons.select')}}</button>
					</div>		        	
					</div>
					</div>
				</div>		
			</div>

			<div class="col-lg-6 col-md-6 col-xs-12">
				<div class="place-ads-box">
					<div class="col-lg-12 col-md-12 col-xs-12 place-ads-header">
						<h6 class="header-title">{{trans('place-ads.BASIC ADS')}}</h6>						
					</div>
					<div class="col-lg-12 col-md-12 col-xs-12 place-ads-subheader">
			            <h6 class="sub-header-title">{{trans('place-ads.By using points to earn')}}</h6>    
			        </div>
			        <div class="col-lg-12 col-md-12 col-xs-12 place-ads-content">
			        	<div class="col-lg-3 col-md-3 col-xs-3">
			        	</div>
			        	<div class="col-lg-9 col-md-9 col-xs-9" style="text-align: left;">
			        		<h6 class="content-text"><i class="fa fa-check" aria-hidden="true"></i> {{trans('place-ads.Up to')}} 10 {{trans('place-ads.Photos')}}</h6>   
				            <h6 class="content-text"><i class="fa fa-check" aria-hidden="true"></i> 30 {{trans('place-ads.Days of Run Time')}}</h6>       
				            <h6 class="content-text"><i class="fa fa-check" aria-hidden="true"></i> {{trans('place-ads.Free Renewals')}}</h6>
				            <h6 class="content-text"><i class="fa fa-check" aria-hidden="true"></i> {{trans('place-ads.Ad View Report')}}</h6>  
				            <br/>
			        	</div>
			        	<div class="col-lg-12 col-md-12 col-xs-12">
			        		<button type="submit" name="placeBtn" value="basicAds" class="btn btn-primary btn-block short-buttons uppercase-text">{{trans('buttons.select')}}</button>
			        	</div>		        	
			        </div>
				</div>
			</div>

			<div class="col-lg-offset-4 col-md-offset-4 col-lg-4 col-md-4 col-xs-12">
	            <button type="submit" name="placeBtn" value="saveAds" class="btn btn-danger btn-block place-ads-buttons">{{trans('user-profile.SAVE')}}</button>
	            <br/><br/>
	        </div>
	    </div>
		</div>
	</div>
	
		{{ csrf_field() }}
</form>
	<script>
		$( document ).ready(function() {

		});

		var map;
		var marker;
		var defaultPos;

		function initMap() {
			defaultPos = {lat: -25.363, lng: 131.044};

			map = new google.maps.Map(document.getElementById('map'), {
				zoom: 14,
				center: defaultPos,
				zoomControl: true,
				mapTypeControl: false,
				scaleControl: false,
				streetViewControl: false,
				rotateControl: false,
				fullscreenControl: true
	        });

	       	marker = new google.maps.Marker({
				position: defaultPos,
				map: map,
				draggable: true
	        });  

			if (navigator.geolocation) {
		          navigator.geolocation.getCurrentPosition(function(position) {
		            defaultPos.lat = position.coords.latitude;
		            defaultPos.lng = position.coords.longitude;

		            marker.setPosition(defaultPos);
	        		google.maps.event.trigger(map, "resize");
	        		map.setCenter(defaultPos);
				});
	        }
	        else{
	        	alert("Sorry, your browser does not support GPS location feature.");
	        	$("#google-map").collapse("hide");
	        }

	        google.maps.event.addListener(marker, 'mouseup', function () {
	        	getReverseGeocodingData(marker.getPosition().lat(),marker.getPosition().lng());
		    });

		    google.maps.event.trigger(map, "resize");
		}

		function getReverseGeocodingData(lat, lng) {
		    var latlng = new google.maps.LatLng(lat, lng);
		    // This is making the Geocode request
		    var geocoder = new google.maps.Geocoder();
		    geocoder.geocode({ 'latLng': latlng }, function (results, status) {
		        if (status !== google.maps.GeocoderStatus.OK) {
		            alert("Invalid location, please choose a valid location.");
		        }

		        if (status == google.maps.GeocoderStatus.OK) {
		            var address = results[0].formatted_address;

		            var fullAddress = address.split(", ");
		            $('#region').val(fullAddress[fullAddress.length - 2]);
		            $('#country').val(fullAddress[fullAddress.length - 1]);
		        }
		    });
		}

		function checkMake(){
			var selectedValue = $('#makeDdl').find(":selected").text();

			if(selectedValue == 'Others'){
				$("othersMake").css("display", "block");
				$("othersMakeTxt").css("display", "block");
			}
			else{
				$("othersMake").css("display", "none");
				$("othersMakeTxt").css("display", "none");
			}
		}

		function onSelectCategory(){
			
		}

		function checkModel(){
			var selectedValue = $('#modelDdl').find(":selected").text();

			if(selectedValue == 'Others'){
				$("othersModel").css("display", "block");
				$("othersModelTxt").css("display", "block");
			}	
			else{
				$("othersModel").css("display", "none");
				$("othersModelTxt").css("display", "none");
			}
		}

		$(function() {
		    // Multiple images preview in browser
		    var imagesPreview = function(input, placeToInsertImagePreview) {

		    	$('#gallerySection').html('');
		    	
		        if (input.files) {
		            var filesAmount = input.files.length;

		            if(filesAmount > 10){
		            	alert("{{trans('message-box.uploadupto10images')}}");
		            }
		            else{

		            	for (i = 0; i < filesAmount; i++) {

			                var reader = new FileReader();

			                reader.onload = function(event) {
			                    $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
			                }

			                $($.parseHTML('<h6>')).attr('innerHTML', 'Total Selected').appendTo(placeToInsertImagePreview);

			                reader.readAsDataURL(input.files[i]);
			            }

			            $("#SelectedNo").empty();
			            $("#SelectedNo").append(input.files.length);
		            }
		        }

		    };

		    $("input[type='submit']").click(function(){

		        var $fileUpload = $("input[type='file']");

		        if (parseInt($fileUpload.get(0).files.length)>10){

		         alert("");
		        }
		    });

		    $('#uploadPhotoTxt').on('change', function() {
		        imagesPreview(this, 'div.gallery');
		    });

		    //Ajax
		    $("#dropDownCategory").change(function(){

		    	var categoryId = $('#dropDownCategory :selected').attr('value');

		        $.ajax({
		            type: "GET",
		            url: 'getSubCategory',
		            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		            data: ({ "categoryId": categoryId }),
		            dataType: "html",
		            success: function(data) {

		            	if(data != null){

		            		$('#dropDownSubCategory').children().remove().end();

		            		var dataArray = JSON.parse(data);

		            		for(var i = 0; i < dataArray.length; i++){

		            			$('#dropDownSubCategory').append('<option value="'+ dataArray[i].id +'">' +  dataArray[i].subCategoryName + '</option>');
		            		}
		            	}
		                
		            },
		            error: function() {
		                alert("{{trans('message-box.somethingwrong')}}");
		            }
		        });
		    });
		});

		function clearImages(){
			$("#SelectedNo").empty();
			$("#SelectedNo").append("0");
			$("#gallerySection").empty();
			$('#uploadPhotoTxt').val("");
		}

	</script>

	<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ $googleMapKey }}&callback=initMap"></script>
@endsection
