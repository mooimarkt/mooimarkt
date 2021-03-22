@extends('layouts.app')

@section('content')

<div class="container">
	<div class="row">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul class="message-header-list">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (\Session::has('success'))
            <div class="alert alert-success">
                <ul class="message-header-list">
                    <li>{!! \Session::get('success') !!}</li>
                </ul>
            </div>
        @endif

        <div class="col-lg-12 col-md-12 col-xs-12 margin-bottom visible-xs">
            <br/>
            <div id="backBtnDiv" class="back-button-link">❮ {{trans('buttons.back')}}</div>
        </div>

        <form method="POST" action="{{ url('updateUserProfile') }}">
    		<div class="col-lg-12 col-md-12 col-xs-12 form-rows bottom-border">
    			<div class="form-group">
    			    <label for="subjectTxt">{{trans('label-terms.name')}}</label>
    			    <input type="text" class="form-control profile-textboxes" id="subjectTxt" name="txtName" value="{{ $user['name'] }}" style="height: 30px;" required>

                    @if ($errors->has('txtName'))
                        <span class="help-block">
                            <strong>{{ $errors->first('txtName') }}</strong>
                        </span>
                    @endif
    		  	</div>
    		</div>

    		<div class="col-lg-12 col-md-12 col-xs-12 form-rows bottom-border" style="padding-bottom: 10px;">		
          		<div class="form-group">
                    <div class="col-lg-12 col-md-12 col-xs-12 no-padding-column"> 
                        <input id="searchInput" class="form-control" type="text" placeholder="&#xF002; {{trans('buttons.search')}}" style="font-family:Arial, FontAwesome;">
                        <label for="googleMap">{{trans('label-terms.location')}}</label> 
                        <div id="getGeolocation" class="form-control uppercase-text login-buttons" style="text-align: center; float: right; width: 50px; position: relative; top: 36px; z-index: 999;"><i class="fa fa-map-marker" style="font-size: 15pt;" aria-hidden="true"></i></div>
                        <div id="googleMap" style="width:100%;height:250px;"></div>
                    </div>    
                    <input id="geolocationLongitude" name="geolocationLongitude" value="{{$user['longitude']}}" type="hidden"/>    
                    <input id="geolocationLatitude" name="geolocationLatitude" value="{{$user['latitude']}}" type="hidden"/>  
                    <input id="geolocationCountry" name="geolocationCountry" value="{{$user['country']}}" type="hidden"/>  
                    <input id="geolocationRegion" name="geolocationRegion" value="{{$user['region']}}" type="hidden"/>
                    <input id="geolocationCity" name="geolocationCity" value="{{$user['city']}}" type="hidden"/>
                    <div class="col-lg-4 col-md-4 col-xs-4 no-padding-column">  
                        <label for="txtCountry"></label>
                        <input id="txtCountry" name="txtCountry" class="form-control" style="margin-top: 7px;" placeholder="{{trans('label-terms.country')}}" value="{{$user['country']}}" disabled>
                    </div>
                    <div class="col-lg-4 col-md-4 col-xs-4 no-padding-column">  
                        <label for="txtRegion"></label>
                        <input id="txtRegion" name="txtRegion" class="form-control" style="margin-top: 7px;" placeholder="{{trans('label-terms.region')}}" value="{{$user['region']}}" disabled>
                    </div>
                    <div class="col-lg-4 col-md-4 col-xs-4 no-padding-column">  
                        <label for="txtCity"></label>
                        <input id="txtCity" name="txtCity" class="form-control" style="margin-top: 7px;" placeholder="{{trans('label-terms.city')}}" value="{{$user['city']}}" disabled>
                    </div>
                </div>
    		</div>

    		<div class="col-lg-12 col-md-12 col-xs-12 form-rows bottom-border">
    			<div class="form-group">
    			    <label for="subjectTxt">{{trans('label-terms.email')}}</label>
    			    <input type="text" style="height: 30px;" class="form-control profile-textboxes" id="subjectTxt" name="txtEmail" disabled="true" value="{{ $user['email'] }}" required>
    		  	</div>
    		</div>

            <div class="col-lg-12 col-md-12 col-xs-12 form-rows bottom-border">
                <div class="form-group">                    
                    <div class="col-lg-2 col-md-2 col-xs-6 no-padding-column">  
                        <label for="txtAdsContact">{{trans('label-terms.phone')}}</label>
                        <select id="callingCode" name="dropDownCallingCode" class="form-control profile-textboxes">
                            @foreach($callingCodeList as $callingCode)
                                @if($user['callingCode'] == $callingCode->phonecode)
                                <option value="{{ $callingCode->phonecode }}" selected>{{ $callingCode->name }} (+{{ $callingCode->phonecode }})</option>
                                @else
                                <option value="{{ $callingCode->phonecode }}">{{ $callingCode->name }} (+{{ $callingCode->phonecode }})</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-5 col-md-5 col-xs-6 no-padding-column" style="height: 75px;">  
                        <label for="txtPhone"> </label>
                        <input type="number" id="txtPhone" name="txtPhone" placeholder="{{trans('label-terms.phone')}}" class="form-control profile-textboxes" value="{{ $user['phone'] }}" required style="margin-top: 7px;"/>
                        @if ($errors->has('txtPhone'))
                            <span class="help-block">
                                <strong>{{ $errors->first('txtPhone') }}</strong>
                            </span>
                        @endif
                        <br/><br/>
                    </div>
                </div>
            </div>

    		<div class="col-lg-12 col-md-12 col-xs-12 form-rows bottom-border" id="passwordDiv">
    			<div class="form-group"> 
    			    <label for="subjectTxt">{{trans('label-terms.password')}}</label> 
                    <a class="btn btn-primary btn-block login-buttons uppercase-text" style="width: 100px;" href="{{ url('getResetPasswordPage') }}"><i class="fa fa-pencil" aria-hidden="true"></i></a> 
    		  	</div>
    		</div>

    		<div class="col-md-12 col-xs-12" style="padding-bottom: 10px;">
    			<br/>
                <div class="form-group">
                    <label for="subjectTxt">{{trans('label-terms.accounttype')}}</label> 
                    <div class="col-md-12">                     
                        @if($user['userType'] == 1)
                        <input type="radio" id="sellerTypeOption" name="radioUserType" value="1" checked> {{trans('label-terms.imprivateseller')}}<br>
                        <input type="radio" id="buyerTypeOption" name="radioUserType" value="2"> {{trans('label-terms.imtrader')}}
                        @elseif($user['userType'] == 2)
                        <input type="radio" id="sellerTypeOption" name="radioUserType" value="1"> {{trans('label-terms.imprivateseller')}}<br>
                        <input type="radio" id="buyerTypeOption" name="radioUserType" value="2" checked> {{trans('label-terms.imtrader')}}
                        @else
                        <input type="radio" id="sellerTypeOption" name="radioUserType" value="1"> {{trans('label-terms.imprivateseller')}}<br>
                        <input type="radio" id="buyerTypeOption" name="radioUserType" value="2"> {{trans('label-terms.imtrader')}}
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-xs-12 bottom-border" style="padding-bottom: 10px;">
                <br/>
                <div class="form-group" id="vatSection">
                    <label for="subjectTxt">VAT</label> 
                    <div class="col-md-12" id="vatPart">                     
                        <input type="text" id="txtVat" value="{{$user['vat']}}" name="txtVat" placeholder="V.A.T" class="form-control profile-textboxes" style="margin-top: 7px;"/>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-xs-12">
                <br/>
                <div class="form-group">
                    <label for="subjectTxt">{{trans('label-terms.contactmethod')}}</label> 
                    <div class="col-md-12">
                        <input type="checkbox" id="contactMessageOption" name="selectb4mxType" value="1" checked disabled=""> {{trans('label-terms.byb4mxmessage')}}<br>
                        @if($user['phoneContactType'] == 1)
                            <input type="checkbox" id="contactPhoneOption" name="selectPhontType" value="1" checked> 
                            {{trans('label-terms.byphonetext')}}<br>
                        @else
                         <input type="checkbox" id="contactPhoneOption" name="selectPhontType" value="1"> 
                            {{trans('label-terms.byphonetext')}}<br>
                        @endif

                        @if($user['emailContactType'] == 1)  
                            <input type="checkbox" id="contactEmailOption" name="selectEmailType" value="1" checked> {{trans('label-terms.byemail')}}
                        @else
                          <input type="checkbox" id="contactEmailOption" name="selectEmailType" value="1"> {{trans('label-terms.byemail')}}
                        @endif
                    </div>
                </div>          
            </div>
            <div class="col-md-offset-3 col-md-6 col-xs-12">
                <br/>
                <br/>
                <button type="submit" class="btn btn-primary btn-block login-buttons uppercase-text">{{trans('buttons.save')}}</button>
                <br/>
            </div>
            {{ csrf_field() }}
        </form>
        <button type="button" id="modalClicker" class="btn btn-info btn-lg" data-toggle="modal" data-target="#setProfileModal" style="display: none;"></button>
	</div>
</div>

<!-- Modal -->
<div id="setProfileModal" class="modal fade" role="dialog" style="margin-top: 100px;">
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

<script>
	$( document ).ready(function() {

        if("{{Auth::user()->userRole}}" == "unset"){
            $('#modalTitle').append("{{trans('message-box.pleasesetprofile')}}");
            $('#modalDescription').append("{{trans('message-box.youmustsetyourprofilebeforeenjoying')}}");
            setTimeout(function(){
                $('#modalClicker').click();
           }, 100);
        }

        if($('input[type=radio][name=radioUserType]:checked').val() == 1){
            $('#vatSection').css('display','none');
        }
        else{
            $('#vatSection').css('display','block');
        }

        $('input[type=radio][name=radioUserType]').change(function() {
            if (this.value == 1) {
                $('#vatSection').css('display','none');
            }
            else if (this.value == 2) {
                $('#vatSection').css('display','block');
            }
        });

        if({{ count($socialLogin )}} > 0){
            $('#passwordDiv').css('display','none');
        }
        else{
            $('#passwordDiv').css('display','block');
        }

        $(window).keydown(function(event){
            if(event.keyCode == 13) {
              event.preventDefault();
              return false;
            }
        });
	});

    function myMap() {

        var mapProp = {
            center:new google.maps.LatLng($('#geolocationLatitude').val(),$('#geolocationLongitude').val()),
            zoom:12,
            streetViewControl: false,
            fullscreenControl: false,
            mapTypeControl: false,
        };

        var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);
        var geocoder = new google.maps.Geocoder;

        var marker = new google.maps.Marker({
          position: new google.maps.LatLng($('#geolocationLatitude').val(),$('#geolocationLongitude').val()),
          map: map,
          draggable: true,
        });

        google.maps.event.addListener(marker, 'dragend', function(evt){
            var latlng = new google.maps.LatLng(evt.latLng.lat().toFixed(4),evt.latLng.lng().toFixed(4));
            geocoder.geocode({'location': latlng}, function(results, status) {
                if (status === 'OK') {
                    if (results[0]["address_components"]) {
                        var hasCity = false;
                        var hasRegion = false;
                        var hasCountry = false;

                        for (var i = 0; i < results[0]["address_components"].length; i++) {
                          var component = results[0]["address_components"][i];
                          
                            if(component['types'][0] == "locality"){
                                $('#txtCity').val(component['long_name']);
                                $('#geolocationCity').val(component['long_name']);
                                hasCity = true;
                            }
                            else if(component['types'][0] == "administrative_area_level_1"){
                                $('#txtRegion').val(component['long_name']);
                                $('#geolocationRegion').val(component['long_name']);
                                hasRegion = true;
                            }
                            else if(component['types'][0] == "country"){
                                $('#txtCountry').val(component['long_name']);
                                $('#geolocationCountry').val(component['long_name']);
                                hasCountry = true; 
                            }

                            $("#callingCode > option").each(function() {
                                var countryString = this.text.split(" (");
                            
                                if(component['long_name'] == countryString[0]){
                                    $("#callingCode").val(this.value);
                                }
                            });
                        }

                        if(hasCity == false){
                            $('#txtCity').val('');
                            $('#geolocationCity').val('');
                        }

                        if(hasRegion == false){
                            $('#txtRegion').val('');
                            $('#geolocationRegion').val('');
                        }

                        if(hasCountry == false){
                            $('#txtCountry').val('');
                            $('#geolocationCountry').val('');
                        }
                    } else {
                        window.alert('No results found.');
                    }
                } else {
                    window.alert('Plase select a valid location.');
                }
            });

            $('#geolocationLongitude').val(evt.latLng.lng().toFixed(4));
            $('#geolocationLatitude').val(evt.latLng.lat().toFixed(4));
        });

        var input = document.getElementById('searchInput');
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.bindTo('bounds', map);

        autocomplete.addListener('place_changed', function() {
            marker.setVisible(false);
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                return;
            }
      
            map.setZoom(16);
            map.setCenter(place.geometry.location);
            marker.setPosition(place.geometry.location);
            marker.setVisible(true);

            var hasCity = false;
            var hasRegion = false;
            var hasCountry = false;

            for (var i = 0; i < place.address_components.length; i++) {
              var component = place.address_components[i];
              
                if(component['types'][0] == "locality"){
                    $('#txtCity').val(component['long_name']);
                    $('#geolocationCity').val(component['long_name']);
                    hasCity = true;
                }
                else if(component['types'][0] == "administrative_area_level_1"){
                    $('#txtRegion').val(component['long_name']);
                    $('#geolocationRegion').val(component['long_name']);
                    hasRegion = true;
                }
                else if(component['types'][0] == "country"){
                    $('#txtCountry').val(component['long_name']);
                    $('#geolocationCountry').val(component['long_name']);
                    hasCountry = true; 

                    $("#callingCode > option").each(function() {
                        var countryString = this.text.split(" (");
                    
                        if(component['long_name'] == countryString[0]){
                            $("#callingCode").val(this.value);
                        }
                    });
                }
            }

            if(hasCity == false){
                $('#txtCity').val('');
                $('#geolocationCity').val('');
            }

            if(hasRegion == false){
                $('#txtRegion').val('');
                $('#geolocationRegion').val('');
            }

            if(hasCountry == false){
                $('#txtCountry').val('');
                $('#geolocationCountry').val('');
            }

            $('#geolocationLongitude').val(place.geometry.location.lng().toFixed(4));
            $('#geolocationLatitude').val(place.geometry.location.lat().toFixed(4));
        });

        var geolocation = document.getElementById('getGeolocation');  

        geolocation.addEventListener('click', function() {
            if (navigator.geolocation) {
                var position = navigator.geolocation.getCurrentPosition(function (position) {
                    map.setZoom(16);
                    map.setCenter({
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    });
                    marker.setPosition({
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    });

                    var latlng = {lat: position.coords.latitude, lng: position.coords.longitude};
                    geocoder.geocode({'location': latlng}, function(results, status) {
                        if (status === 'OK') {
                            if (results[0]["address_components"]) {
                                var hasCity = false;
                                var hasRegion = false;
                                var hasCountry = false;

                                for (var i = 0; i < results[0]["address_components"].length; i++) {
                                  var component = results[0]["address_components"][i];
                                  
                                    if(component['types'][0] == "locality"){
                                        $('#txtCity').val(component['long_name']);
                                        $('#geolocationCity').val(component['long_name']);
                                        hasCity = true;
                                    }
                                    else if(component['types'][0] == "administrative_area_level_1"){
                                        $('#txtRegion').val(component['long_name']);
                                        $('#geolocationRegion').val(component['long_name']);
                                        hasRegion = true;
                                    }
                                    else if(component['types'][0] == "country"){
                                        $('#txtCountry').val(component['long_name']);
                                        $('#geolocationCountry').val(component['long_name']);
                                        hasCountry = true; 

                                        $("#callingCode > option").each(function() {
                                            var countryString = this.text.split(" (");
                                        
                                            if(component['long_name'] == countryString[0]){
                                                $("#callingCode").val(this.value);
                                            }
                                        });
                                    }
                                }

                                if(hasCity == false){
                                    $('#txtCity').val('');
                                    $('#geolocationCity').val('');
                                }

                                if(hasRegion == false){
                                    $('#txtRegion').val('');
                                    $('#geolocationRegion').val('');
                                }

                                if(hasCountry == false){
                                    $('#txtCountry').val('');
                                    $('#geolocationCountry').val('');
                                }
                            } else {
                                window.alert('No results found');
                            }
                        } else {
                            window.alert('Geocoder failed due to: ' + status);
                        }
                    });

                    $('#geolocationLongitude').val(position.coords.longitude.toFixed(4));
                    $('#geolocationLatitude').val(position.coords.latitude.toFixed(4));
                });
            } else {
                x.innerHTML = "Geolocation is not supported by this browser.";
            }
        }); 

        if($('#geolocationLongitude').val() == null && $('#geolocationLatitude').val() == null || $('#geolocationLongitude').val() == 0 && $('#geolocationLatitude').val() == 0){
            if (navigator.geolocation) {
                var position = navigator.geolocation.getCurrentPosition(function (position) {
                    map.setZoom(16);
                    map.setCenter({
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    });
                    marker.setPosition({
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    });

                    var latlng = {lat: position.coords.latitude, lng: position.coords.longitude};
                    geocoder.geocode({'location': latlng}, function(results, status) {
                        if (status === 'OK') {
                            if (results[0]["address_components"]) {
                                var hasCity = false;
                                var hasRegion = false;
                                var hasCountry = false;

                                for (var i = 0; i < results[0]["address_components"].length; i++) {
                                  var component = results[0]["address_components"][i];
                                  
                                    if(component['types'][0] == "locality"){
                                        $('#txtCity').val(component['long_name']);
                                        $('#geolocationCity').val(component['long_name']);
                                        hasCity = true;
                                    }
                                    else if(component['types'][0] == "administrative_area_level_1"){
                                        $('#txtRegion').val(component['long_name']);
                                        $('#geolocationRegion').val(component['long_name']);
                                        hasRegion = true;
                                    }
                                    else if(component['types'][0] == "country"){
                                        $('#txtCountry').val(component['long_name']);
                                        $('#geolocationCountry').val(component['long_name']);
                                        hasCountry = true; 

                                        $("#callingCode > option").each(function() {
                                            var countryString = this.text.split(" (");
                                        
                                            if(component['long_name'] == countryString[0]){
                                                $("#callingCode").val(this.value);
                                            }
                                        });
                                    }
                                }

                                if(hasCity == false){
                                    $('#txtCity').val('');
                                    $('#geolocationCity').val('');
                                }

                                if(hasRegion == false){
                                    $('#txtRegion').val('');
                                    $('#geolocationRegion').val('');
                                }

                                if(hasCountry == false){
                                    $('#txtCountry').val('');
                                    $('#geolocationCountry').val('');
                                }
                            } else {
                                window.alert('No results found');
                            }
                        } else {
                            window.alert('Geocoder failed due to: ' + status);
                        }
                    });

                    $('#geolocationLongitude').val(position.coords.longitude.toFixed(4));
                    $('#geolocationLatitude').val(position.coords.latitude.toFixed(4));
                });
            } else {
                x.innerHTML = "Geolocation is not supported by this browser.";
            }
        }
    }

</script>

	
@endsection
