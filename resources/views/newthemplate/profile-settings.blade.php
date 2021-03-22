@include("newthemplate.header")
<section id="profile-settings"  class="profile-settings">
    <div class="container">
        <form action="{{ url('updateUserProfile') }}" method="POST" id="profile-settings" class="profile-settings-form p_top_40">
            {{csrf_field()}}
            <div id="first_step">
               <input type="hidden" value="1" name="UserType">
               <div class="ps-row first-row">
                   <div class="first-coll">
                       <div class="input-group">
                           <label>
                               <img src="{{ isset(Auth::user()->avatar) ? Auth::user()->avatar : '/storage/avatar/icon-p.svg' }}" alt="Avatar" width="170" height="170" class="avatar" />
                               <input type="file" name="avatar" id="avatar" hidden>
                               <a href="javascript:void(0)" class="deleteAvatar" title="Delete avatar"@if (!isset(Auth::user()->avatar)) style="display: none"@endif><img src="/newthemplate/img/close.svg" alt="Delete"></a>
                           </label>
                       </div>
                       <hr class="form-divider">
                       <div class="input-group">
                           <label>First Name</label>
                           <input type="text" name="FirstName" required class="user-input" value="{{Auth::user()->name}}" placeholder="ex: John">
                           <span class="help-block">
                       	   @if ($errors->has('FirstName'))
                              <strong>{{ $errors->first('FirstName') }}</strong>
                       	   @endif
                           </span>
                       </div>
                       <div class="input-couple">
                           <div class="input-group">
                               <label>Display Option</label>
                               <select name="" class="user-input">
                                   <option value="">JD</option>
                                   <option value="">John D</option>
                                   <option value="">J Doe</option>
                                   <option value="">John Doe</option>
                               </select>
                           </div>
                           <div class="input-group">
                               <label>User Type</label>
                               <select name="" class="user-input">
                                   <option {{Auth::user()->userType == "1" ? "selected" : ""}} value="1">B4MX User</option>
                                   <option {{Auth::user()->userType == "2" ? "selected" : ""}} value="2">Facebook User</option>
                                   <option {{Auth::user()->userType == "3" ? "selected" : ""}} value="3">Google User</option>
                                   <option {{Auth::user()->userType == "4" ? "selected" : ""}} value="4">Twitter User</option>
                               </select>
                           </div>
                       </div>
                   </div>
                   <hr class="form-divider">
                   <div class="input-group map-group">
                       <label>Location</label>
                       <input type="text" id="location_autofill" class="user-input">
                       <div id="profile-map" class="profile-map"></div>
                   </div>
               </div>
               <hr class="form-divider">

               <div class="ps-row second-row">
   	            <?php $location = [];//geoip_record_by_name($_SERVER['REMOTE_ADDR']);?>
                   <div class="input-group">
                       <label>Country</label>
                       <input type="text" id="country_autocompl" name="Country" required value="{{ !empty(Auth::user()->country) ? Auth::user()->country : (key_exists("country_name",$location)  ? $location['country_name'] : "")}}" class="user-input valid" value="USA">
                       <span class="help-block">
                    	  @if ($errors->has('Country'))
                          <strong>{{ $errors->first('Country') }}</strong>
                    	  @endif
                       </span>
                   </div>
                   <div class="input-group">
                       <label>Region</label>
                       <input type="text" id="region_autocompl" name="Region" required value="{{!empty(Auth::user()->region) ? Auth::user()->region : (key_exists("region",$location) && key_exists('country_code',$location) ? geoip_region_name_by_code($location['country_code'],$location['region']) : "")}}" class="user-input valid" value="Florida">
                       <span class="help-block">
                    	  @if ($errors->has('Region'))
                          <strong>{{ $errors->first('Region') }}</strong>
                    	  @endif
                       </span>
                   </div>
                   <div class="input-group">
                       <label>City</label>
                       <input type="text" id="city_autocompl" name="City" required value="{{!empty(Auth::user()->city) ? Auth::user()->city : (key_exists("city",$location)  ? $location['city'] : "") }}" class="user-input valid" value="Miamy">
                       <span class="help-block">
                    	  @if ($errors->has('City'))
                          <strong>{{ $errors->first('City') }}</strong>
                    	  @endif
                       </span>
                   </div>
               </div>
               <hr class="form-divider">

               <div class="ps-row third-row">
                   <div class="input-group">
                       <label>Email Address</label>
                       <input type="email" name="Email" required value="{{Auth::user()->email}}" class="user-input valid" value="john@doe.com">
                       <span class="help-block">
                    	  @if ($errors->has('Email'))
                          <strong>{{ $errors->first('Email') }}</strong>
                    	  @endif
                       </span>
                   </div>
                   <hr class="form-divider">
                   <div class="input-group">
                       <label>Phone number</label>
                       <input type="text" name="Phone" class="user-input" value="{{Auth::user()->phone}}" required>
                       <span class="help-block">
                    	  @if ($errors->has('Phone'))
                          <strong>{{ $errors->first('Phone') }}</strong>
                    	  @endif
                       </span>
                       <div class="user-checkbox">
                           <input type="checkbox" name="isRetailer" value="0" {{Auth::user()->isRetailer ? "" : "checked"}} id="private-checkbox"><label></label><span>I am a private seller</span>
                       </div>
                       <div class="user-checkbox">
                           <input type="checkbox" name="isRetailer" value="1" {{Auth::user()->isRetailer ? "checked" : ""}} id="trader-checkbox"><label></label><span>I am a trader</span>
                       </div>
                       <input type="text" class="user-input{{Auth::user()->isRetailer ? " active" : ""}}" id="vat-input" name="vat" placeholder="VAT" value="{{Auth::user()->vat}}">
                       @if ($errors->has('vat'))
                      <strong>{{ $errors->first('vat') }}</strong>
                      @endif
                   </div>
                   <hr class="form-divider">
                   <div class="input-group">
                       <label>Contact Methods</label>
                       <div class="user-checkbox">
                           <input type="checkbox"><label></label><span>Contact by B4mx Messenger</span>
                       </div>
                       <div class="user-checkbox">
                           <input type="checkbox" checked><label></label><span>Contact by phone or text</span>
                       </div>
                       <div class="user-checkbox">
                           <input type="checkbox"><label></label><span>Contact by email</span>
                       </div>
                   </div>
               </div>

               <hr class="form-divider last-hr">

               <div id="subscribe-block" {{Auth::user()->isRetailer ? "style=display:block" : ""}} class="fill_details">
                   <div style="height: 50px;">
                     <input type="radio" name="Period" value="1" id="Monthly" checked style="display: none;"><label for="Monthly" class="period" style="cursor: pointer; border: 1px solid #0084ff; padding: 10px; margin-bottom: 20px; border-radius: 5px; background: #0084ff; color: #fff;">Monthly</label>
                     <input type="radio" name="Period" value="12" id="Yearly" style="display: none;"><label for="Yearly" class="period" style="cursor: pointer; border: 1px solid #0084ff; padding: 10px; margin-bottom: 20px; border-radius: 5px;">Yearly (5% Off)</label>
                   </div>
                   <div class="pl_pr_cont">
                       <label class="place_price_block{{Auth::user()->subscription == "Subscription 1" ? " place_price_block_bl" : ""}}" for="adsSelectedType1">
                           <div class="pl_pr_top">Package 1</div>
                           <div class="pl_pr_bot">
                               <div class="pl-pr-right">
                                   <p>They get 20 ads posting or 120 Euro Equivalent credit</p>
                               </div>
                               <div class="pl-pr-left"><span class="pack_price">{{\App\Option::getSetting("opt_subscription_1")}}</span> EUR/mon</div>
                               <input type="radio" data-text="They get 20 ads posting or 120 Euro Equivalent credit" {{Auth::user()->subscription == "Subscription 1" ? "checked" : ""}} name="subscription" id="adsSelectedType1" data-price="{{\App\Option::getSetting("opt_subscription_1")}}" data-realprice="{{\App\Option::getSetting("opt_subscription_1")}}" class="opacity-none" value="Subscription 1">
                           </div>
                       </label>
                       <label class="place_price_block{{Auth::user()->subscription == "Subscription 2" ? " place_price_block_bl" : ""}}" for="adsSelectedType2">
                           <div class="pl_pr_top">Package 2</div>
                           <div class="pl_pr_bot">
                               <div class="pl-pr-right">
                                   <p>They get 50 ads posting or 300 Euro Equivalent credit</p>
                               </div>
                               <div class="pl-pr-left"><span class="pack_price">{{\App\Option::getSetting("opt_subscription_2")}}</span> EUR/mon</div>
                               <input type="radio" data-text="They get 50 ads posting or 300 Euro Equivalent credit" {{Auth::user()->subscription == "Subscription 2" ? "checked" : ""}} name="subscription" id="adsSelectedType2" data-price="{{\App\Option::getSetting("opt_subscription_2")}}" data-realprice="{{\App\Option::getSetting("opt_subscription_2")}}" class="opacity-none" value="Subscription 2">
                           </div>
                       </label>
                       <label class="place_price_block{{Auth::user()->subscription == "Subscription 3" ? " place_price_block_bl" : ""}}" for="adsSelectedType3">
                           <div class="pl_pr_top">Package 3</div>
                           <div class="pl_pr_bot">
                               <div class="pl-pr-right">
                                   <p>They get 100 ads posting or 500 Euro Equivalent</p>
                               </div>
                               <div class="pl-pr-left"><span class="pack_price">{{\App\Option::getSetting("opt_subscription_3")}}</span> EUR/mon</div>
                               <input type="radio" data-text="They get 100 ads posting or 500 Euro Equivalent" {{Auth::user()->subscription == "Subscription 3" ? "checked" : ""}} name="subscription" id="adsSelectedType3" data-price="{{\App\Option::getSetting("opt_subscription_3")}}" data-realprice="{{\App\Option::getSetting("opt_subscription_3")}}" class="opacity-none" value="Subscription 3">
                           </div>
                       </label>
                   </div>

                   <input type="hidden" value="" name="price_subscription">

                   <div class="sell_dest">
                      <div class="input-group">
                          <label>Promo Code (Voucher)</label>
                          <input type="text" id="voucher" class="user-input" placeholder="Enter a voucher" autocomplete="off">
                      </div>
                   </div>
                   <hr class="form-divider last-hr">

               </div>

               <div class="ps-row botton-row">
                   <input type="submit" value="SAVE CHANGES" class="user-submit">
               </div>

            </div>
           <div id="second_step" style="text-align: center; display: none;">
               <div class="top_reset">
                   <h1 class="caption-text">Order Details</h1>
               </div>
               <div class="top_reset data-plan" style="background: #FFFFFF; border: 1px solid #E9ECF4; border-radius: 5px; margin-bottom: 10px; padding: 20px; font-size: 18px;">
                   <h3></h3>

                   <div style="border-top: 1px solid #E9ECF4; margin-top: 20px; padding-top: 20px;"></div>
               </div>
               <div class="top_reset">
                   <h1 class="caption-text">Payment</h1>
               </div>
               <form id="CreditCardForm">
                   {{ csrf_field() }}
                   <input type="hidden" name="amount" value="">
                   <div class="payment box-card">
                       <div class="form-group-card">
                           <label>Card Number</label>
                           <input type="text" id="cardnum" maxlength="16" name="number_card" class="number_card" placeholder="4149 4393 9672 9216">
                       </div>
                       <div class="form-group-card">
                           <label>Exp. Date</label>
                           <input type="text" id="expdate" maxlength="5" name="date_card" class="date_card" placeholder="09/20">
                       </div>
                       <div class="form-group-card">
                           <label>CVV</label>
                           <input type="password" id="cvv" maxlength="3" name="cvv_card" class="cvv_card" placeholder="***">
                       </div>
                       <div class="form-group-card pay_by_cc">
                           <img id="cardlabel" src="https://kafalianfitness.com/app/view/assets/img/visa.png" alt="visa">
                           <a href="#" class="btn btn-bg pay">Pay</a>
                       </div>
                   </div>
                    <input type="hidden" name="pay_token" value="">
                    <input type="hidden" name="pay_type" value="">

               <input type="submit" value="PayPal Checkout" id="PayPalCheckout">
           </div>
        </form>
    </div>
</section>

<script>
    function initMap() {
        var uluru = {lat: 40.584378, lng: -122.388424};
        var map = new google.maps.Map(document.getElementById('profile-map'), {
            zoom: 18,
            center: uluru,
            styles: [{"stylers":[{"saturation":-100},{"gamma":0.8},{"lightness":4},{"visibility":"on"}]},{"featureType":"landscape.natural","stylers":[{"visibility":"on"},{"color":"#5dff00"},{"gamma":4.97},{"lightness":-5},{"saturation":100}]}]
        });

        var image = {
            url: '/newthemplate/img/map-marker.svg',
            size: new google.maps.Size(30, 30)
        };

        var marker = new google.maps.Marker({
            position: uluru,
            map: map,
            draggable:true,
            icon: image
        });

        var geocoder = new google.maps.Geocoder;

        var location = document.getElementById('location_autofill');
        var profile_settings_form = document.getElementsByClassName('profile-settings-form');

        var country = document.getElementById('country_autocompl');
        var region = document.getElementById('region_autocompl');
        var city = document.getElementById('city_autocompl');

        var autocomplete = new google.maps.places.Autocomplete(location);
        var timer = 0;
        autocomplete.bindTo('bounds', map);

        location.onkeydown = function (e) {

            if(e.keyCode == 13){

                clearTimeout(timer);

                profile_settings_form[0].onsubmit =function (e) {
                    e.preventDefault();
                };

                timer = setTimeout(function () {

                    profile_settings_form[0].onsubmit = null;

                },1000)

            }

        };

        google.maps.event.addListener(marker, "dragend", function(event) {
           var point = marker.getPosition();
           var latlng = {lat: parseFloat(point.lat()), lng: parseFloat(point.lng())};
           geocoder.geocode({'location': latlng}, function(results, status) {
               if (status === 'OK') {
                   if (results[0]) {
                       results[0]['address_components'].forEach(function(item, i, arr) {
                           if (item.types.indexOf("country") != -1)
                              $('#country_autocompl').val(item.long_name);
                           if (item.types.indexOf("administrative_area_level_1") != -1)
                              $('#region_autocompl').val(item.long_name);
                           if (item.types.indexOf("locality") != -1)
                              $('#city_autocompl').val(item.long_name);
                       });
                   } else {
                       console.log('No results found');
                   }
               } else {
                   console.log('Geocoder failed due to: ' + status);
               }
           });

        });

        autocomplete.addListener('place_changed', function() {

            marker.setVisible(false);
            var place = autocomplete.getPlace();
            if (!place.geometry) {

                console.log("No details available for input: '" + place.name + "'");
                return;
            }

            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17);
            }

            marker.setPosition(place.geometry.location);
            marker.setVisible(true);

            if (place.address_components) {

                country.value =  "";
                region.value =  "";
                city.value =  "";

                console.log(place.address_components);

                place.address_components.forEach(locality=>{

                    switch(true){
                        case locality.types.indexOf("country") >= 0:
                            country.value = locality.long_name;
                            break;
                        case locality.types.indexOf("administrative_area_level_1") >= 0:
                            region.value = locality.long_name;
                            break;
                        case locality.types.indexOf("locality") >= 0 || locality.types.indexOf("sublocality" ) >= 0:
                            city.value = locality.long_name;
                            break;
                    }


                });
            }



        });

    }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBs-wGPSQvrx03p1gy4JY94xDgUJfz2Hzw&libraries=places&language=en&callback=initMap"></script>
@if($errors->any())
<script>
    setTimeout(function () {

        var html = document.createElement("html");
        html.innerHTML = "{{implode("<br/>",$errors->all())}}";

        swal({
            title:"Error",
            content:html,
            icon:"error"
        })

    },500);
</script>
@endif
<style>
.cover_butt {
   background: #0084FF !important;
}
.payment.box-card{
	background:#333;
	padding:40px;
	border-radius:15px;
	margin-bottom:40px;
	position: relative;
    display: block;
    float: left;
	width:100%;
	transition: 0.3s;
}
.payment.box-card input{
	padding:15px;
	background:#636363;
	border:0;
	color:#fff;
	font-size: 18px;
    font-family: 'sf_ui_textbold';
	letter-spacing: 4px;
}
.payment.box-card .number_card{
	width:100%;
	text-align:center;
}
.payment.box-card .date_card{
	width: 115px;
	text-align:center;
}
.payment.box-card .cvv_card{
	width: 95px;
	text-align:center;
}
.payment.box-card .form-group-card label {
    display: block;
    color: #fff;
    font-size: 15px;
    font-family: 'sf_ui__textregular';
    line-height: 21px;
}
.payment.box-card .form-group-card:nth-child(1) {
    width: 100%;
    float: left;
    margin-bottom: 20px;
}
.payment.box-card .form-group-card:nth-child(2) {
    width: auto;
    float: left;
    margin-right: 40px;
}
.payment.box-card .form-group-card:nth-child(3) {
    width: auto;
    float: left;
}
.payment.box-card .form-group-card:nth-child(4) {
    width: auto;
    float: right;
}
.payment.box-card label {
    display: inline-block;
    max-width: 100%;
    margin-bottom: 5px;
    font-weight: 700;
    text-align: left;
}
</style>
<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<script src="/newthemplate/bower_components/rxp-js/rxp-js.min.js"></script>
<script src="/newthemplate/js/Elavon.js"></script>
<script>
   var paid = false;
   var change_plan = false;
   var current_plan = '{{Auth::user()->subscription}}';
   var amount = 0;

  /* paypal.Button.render({
     // Configure environment
     env: 'sandbox',
     client: {
       sandbox: '{{\App\Option::getSetting("opt_paypal_acc_sk")}}'
     },
     // Customize button (optional)
     locale: 'en_US',
     style: {
       size: 'large',
       color: 'gold',
       shape: 'pill',
     },
     // Set up a payment
     payment: function (data, actions) {
       return actions.payment.create({
         transactions: [{
           amount: {
             total: amount,
             currency: 'EUR'
           }
         }]
       });
     },
     // Execute the payment
     onAuthorize: function (data, actions) {
       return actions.payment.execute()
         .then(function (res) {
           paid = true;
           $('input[name=pay_token]').val(res.id);
           $('input[name=pay_type]').val('paypal');
           $('#ads_store').submit();
         });
     }
   }, '#paypal-button');  */
</script>
@include( "newthemplate.footer" );
