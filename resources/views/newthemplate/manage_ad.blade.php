@include('newthemplate.header')



<div class="baner-not-bg disp-none">
    <section id="baner-header" class="baner-header">
        <div class="content wow zoomInUp">
            <ul class="tabs">
                <li class="tab-link current" data-tab="tab-1">Everything</li>
                <li class="tab-link" data-tab="tab-2">Try the amazing Filter!</li>
            </ul>
            <div class="tab-content current" id="tab-1">
                <ul class="header_crumbs">
                    <li><a href="#">Home ></a></li>
                    <li><a href="#">Profile ></a></li>
                    <li><a href="#">Profile Settings</a></li>
                </ul>
                <form>
                    <input type="text" placeholder="Search 256 Ads" />
                    <button class="bt">Search</button>
                </form>
            </div>
            <div class="tab-content" id="tab-2">
                <form>
                    <input type="text" placeholder="Search 256 Ads" />
                    <button class="bt">Search</button>
                </form>
            </div>
        </div>
    </section>
</div>

<!--FILL IN AD DETAILS START-->
<div class="container">
    @if ($FilterKeys != NULL and is_object($FilterKeys))
        <script>
            var filters_value = {};
            @foreach ($FilterKeys as $filter)
            filters_value[{{ $filter->filter_id }}] = '{{ $filter->value }}';
            @endforeach
            console.log(filters_value);
        </script>
    @endif
    <form action="{{ route('ads.store') }}" method="POST" class="fill_details profile-settings-form" id="ads_store">
        <input type="hidden" value="" name="prc">
        <input type="hidden" name="pay_token" value="">
        <input type="hidden" name="pay_type" value="">
        @if(!is_null($Ad))
        <input type="hidden" name="ad_id" value="{{$Ad->id}}">
        @endif
        <div id="first_step">
            {{ csrf_field() }}
            <div class="top_reset">
                <h1 class="caption-text">@php echo \App\Language::GetText(54); @endphp</h1>
            </div>
            <div class="fl-wrp">
                <div class="input-group input-group-3" style="width: 50%;">
                    <label>@php echo \App\Language::GetText(55); @endphp</label>
                    <input type="text" name="adsName" value="{{!is_null($Ad) ? $Ad->adsName : ""}}" class="user-input" placeholder="{{ \App\Language::GetText(56) }}" required>
                </div>
                <div class="input-group input-group-3" style="width: 25%;">
                    <label>@php echo \App\Language::GetText(57); @endphp</label>
                    <select name="adsPriceType" id="adsPriceType" class="user-input">
                        <option {{!is_null($Ad) ? ($Ad->adsPriceType == "USD" ? "selected" : "") : ""}} value="USD">USD</option>
                        <option {{!is_null($Ad) ? ($Ad->adsPriceType == "EUR" ? "selected" : "") : ""}} value="EUR">EUR</option>
                        <option {{!is_null($Ad) ? ($Ad->adsPriceType == "GBP" ? "selected" : "") : ""}} value="GBP">GBP</option>
                    </select>
                </div>
                <div class="input-group input-group-3" style="width: 25%;">
                    <label>@php echo \App\Language::GetText(58); @endphp</label>
                    <input type="text" onkeyup="this.value = this.value.replace(/[^0-9]/g,'')" name="adsPrice" value="{{!is_null($Ad) ? $Ad->adsPrice : ""}}" class="user-input" placeholder="4500" required>
                </div>
                <div class="input-group input-group-4" style="padding: 0 20px; width: 25%;">
                    <div class="input-group">
                        <label>@php echo \App\Language::GetText(59); @endphp</label>
                        <select class="user-input add_category" id="categoryId" disabled>
                            @foreach ($categories as $category)
                            <option {{!is_null($Ad) ? ($Ad->subcategory->categoryId == $category->id ? "selected" : "" ) : ""}} value="{{ $category->id }}">{{ $category->categoryName }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="categoryId" value="{{ $Ad->subcategory->categoryId }}">
                    </div>
                </div>
                <div class="input-group input-group-4" style="padding: 0 20px; width: 25%;">
                    <div class="input-group">
                        <label for="subCategoryId">@php echo \App\Language::GetText(60); @endphp</label>
                        <select name="subCategoryId" id="subCategoryId" class="user-input add_subcategory" disabled>
                            @foreach ($subCategories as $subCategory)
                            <option data-model="{{ $subCategory->filtername }}" {{!is_null($Ad) ? ($Ad->subCategoryId == $subCategory->id ? "selected" : "" ) : ""}} value="{{ $subCategory->id }}">{{ $subCategory->subCategoryName }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="subCategoryId" value="{{ $Ad->subCategoryId }}">
                    </div>
                </div>

                <div class="input-group input-group-4 before_filters" style="padding: 0 20px; width: 25%;">
                    <div class="input-group">
                       <label for="sale_type">@php echo \App\Language::GetText(96); @endphp</label>
                       <select id="sale_type" name="sale_type" style="width: 100%;" class="user-input">
                           <option {{!is_null($Ad) ? ($Ad->sale_type == 'For sale' ? "selected" : "") : ""}} value="For sale">@php echo \App\Language::GetText(97); @endphp</option>
                           <option {{!is_null($Ad) ? ($Ad->sale_type == 'Wanted' ? "selected" : "") : ""}} value="Wanted">@php echo \App\Language::GetText(98); @endphp</option>
                       </select>
                    </div>
                </div>
                <div class="input-group input-group-4" style="padding: 0 20px; width: 25%;">
                    <div class="input-group">
                       <label for="type_ad">Used or New</label>
                       <select id="type_ad" name="type_ad" style="width: 100%;" class="user-input">
                           <option {{!is_null($Ad) ? ($Ad->type_ad == 'Used' ? "selected" : "") : ""}} value="Used">Used</option>
                           <option {{!is_null($Ad) ? ($Ad->type_ad == 'New' ? "selected" : "") : ""}} value="New">New</option>
                       </select>
                    </div>
                </div>
                <!-- <div class="input-group input-group-4" style="padding: 0 20px; width: 50%;">
                    <div class="input-group">
                       <label for="country_registration">@php echo \App\Language::GetText(101); @endphp</label>
                       <select id="CountryFilter" name="country_registration" style="width: 100%;" class="user-input">
                       </select>
                    </div>
                </div> -->
                <div class="input-group input-group-4" style="padding: 0 20px; width: 25%;">
                    <div class="input-group">
                       <label for="shipping_preference">Shipping Preference</label>
                       <select name="shipping_preference" id="shipping_preference" style="width: 100%;" class="user-input">
                           <option {{!is_null($Ad) ? ($Ad->shipping_preference == 'Local pickup' ? "selected" : "") : ""}} value="Local pickup">Local pickup</option>
                           <option {{!is_null($Ad) ? ($Ad->shipping_preference == 'Will ship within country/ Continent' ? "selected" : "") : ""}} value="Will ship within country/ Continent">Will ship within country/ Continent</option>
                           <option {{!is_null($Ad) ? ($Ad->shipping_preference == 'Will ship globally' ? "selected" : "") : ""}} value="Will ship globally">Will ship globally</option>
                       </select>
                    </div>
                </div>
                <div class="input-group input-group-4" style="padding: 0 20px; width: 25%;">
                    <div class="input-group">
                       <label for="restriction">Restriction</label>

                        <select name="restriction" id="restriction" style="width: 100%;" class="user-input">

                           <option value="0">Choose restriction</option>
                           <option {{!is_null($Ad) ? ($Ad->restriction == 'Firm price & no exchange' ? "selected" : "") : ""}} value="Firm price & no exchange">Firm price & no exchange</option>
                           <option {{!is_null($Ad) ? ($Ad->restriction == 'Reasonable offers only & no exchange' ? "selected" : "") : ""}} value="Reasonable offers only & no exchange">Reasonable offers only & no exchange</option>
                           <option {{!is_null($Ad) ? ($Ad->restriction == 'Reasonable offers only & will consider bike related exchange' ? "selected" : "") : ""}} value="Reasonable offers only & will consider bike related exchange">Reasonable offers only & will consider bike related exchange</option>

                        </select>
                    </div>
                </div>

                @if (Auth::user()->userRole == 'admin')
                <hr class="form-divider">
                <div class="input-group">
                    <label>Post as user</label>
                    <select name="userId" class="user-input" id="userId">
                        @if (!is_null($Ad))
                            @php
                                $AdUser = \App\User::find($Ad->userId);
                            @endphp
                            @if (!is_null($AdUser))
                                <option value="{{ $AdUser->id }}" selected="selected">{{ $AdUser->name.' ('.$AdUser->email.')' }}</option>
                            @else
                                <option value="{{ Auth::id() }}" selected="selected">{{ Auth::user()->name.' ('.Auth::user()->email.')' }}</option>
                            @endif
                        @else
                            <option value="{{ Auth::id() }}" selected="selected">{{ Auth::user()->name.' ('.Auth::user()->email.')' }}</option>
                        @endif
                    </select>
                </div>
                @endif
                <hr class="form-divider">
                <div class="add_with_photo">
                    <div>@php echo \App\Language::GetText(104); @endphp</div>
                    <span>@php echo \App\Language::GetText(105); @endphp</span>
                </div>
                <div class="block_dow_ph">
                    <input id="fileupload" type="file" data-url="{{ route('images.store') }}" multiple/>
                    <span id='select_file'>
                        <img src="/newthemplate/img/photo_down.svg" alt="Alternate Text" />
                        <span id="val_sel_file">@php echo \App\Language::GetText(106); @endphp</span>
                    </span>
                </div>
                <div class="set_as_cover">
                    <input type="hidden" name="adsImage" value="{{!is_null($Ad) ? $Ad->adsImage : "" }}" id="adsImage">
                    @if(!is_null($Ad))
                        <?php
                            $images = \App\AdsImages::where('adsId', $Ad->id)->get();
                            $cover = false;
                        ?>
                        @foreach($images as $img)
                            @if ($img->cover == 1)
                                <input type="hidden" name="cover_id" id="cover_id" value="{{$img->id}}">
                                @php
                                    $cover = true;
                                    break;
                                @endphp
                            @endif
                        @endforeach
                        @if (!$cover)
                            <input type="hidden" name="cover_id" id="cover_id" value="">
                        @endif
                        @foreach($images as $img)
                        <div class="set_as_block">
                            <input type="hidden" name="adsImages[]" value="{{$img->id}}">
                            <img class="rect_img_abs" src="{{$img->imagePath}}" alt="{{$img->imagePath}}">
                            <div class="close_set_img"><img src="/newthemplate/img/close_img.svg" alt="Alternate Text"></div>
                            <div class="text_set_block {{$img->cover == 1 ? "cover_butt" : ""}}" onclick="changeCover(this)" data-id="{{$img->id}}" data-src="{{$img->imagePath}}">{{$img->cover == 1 ? "Cover" : "Set As Cover"}}</div>
                        </div>
                        @endforeach
                        @if(count($images) > 0)
                        <script>
                            imgs = ['<?= implode("','",($images->pluck("imagePath")->toArray())); ?>'];
                        </script>
                        @endif
                    @else
                        <input type="hidden" name="cover_id" id="cover_id" value="">
                    @endif
                </div>
                <hr class="form-divider form-divider-m">
            </div>
            <hr class="form-divider form-divider-none">
            <div class="decription_textarea">
                <span>@php echo \App\Language::GetText(107); @endphp</span>
                <textarea placeholder="Cool item. Nice bike. Buy it." name="adsDescription">{{!is_null($Ad) ? $Ad->adsDescription : ""}}</textarea>
            </div>
            <div class="place_tags">
                <div class="tags_up-to">
                    <div>@php echo \App\Language::GetText(108); @endphp</div>
                    <span>@php echo \App\Language::GetText(109); @endphp</span>
                </div>
                <div class="bike_add">
                    <input type="text" value="" />
                    <button class="bt_blu">@php echo \App\Language::GetText(110); @endphp</button>
                </div>
                <div class="sub-filter-container">

                    @if(!is_null($Ad))
                    @foreach(App\Tag::where("adsId",$Ad->id)->get() as $tag)
                    <div class="blue_btn sub-filt-bl">
                        <input type="hidden" name="adsTags[]" value="{{$tag->tagValue}}">
                        <span>{{$tag->tagValue}}</span>
                        <img class="close_sb_f" src="/newthemplate/img/close_filter.svg" alt="Remove" />
                    </div>
                    @endforeach
                    @else
                    {{--<div class="blue_btn sub-filt-bl">
                        <input type="hidden" name="adsTags[]" value="Bike">
                        <span>Bike</span>
                        <img class="close_sb_f" src="/newthemplate/img/close_filter.svg" alt="Remove" />
                    </div>
                    <div class="blue_btn sub-filt-bl">
                        <input type="hidden" name="adsTags[]" value="NY">
                        <span>NY</span>
                        <img class="close_sb_f" src="/newthemplate/img/close_filter.svg" alt="Remove" />
                    </div>
                    <div class="blue_btn sub-filt-bl">
                        <input type="hidden" name="adsTags[]" value="United States">
                        <span>United States</span>
                        <img class="close_sb_f" src="/newthemplate/img/close_filter.svg" alt="Remove" />
                    </div>--}}
                    @endif
                </div>
            </div>
            <div class="input-group{{--  disp-none --}} location_box">
                <label>@php echo \App\Language::GetText(111); @endphp</label>
                <input type="text" value="{{!is_null($Ad) ? $Ad->adsCountry . ", " . $Ad->adsRegion . ", " . $Ad->adsCity : ""}}" id="location_autofill" class="user-input" placeholder="Enter a location" autocomplete="off">
                <button type="button" class="bt_blu" id="getGeolocation"><i class="fa fa-map-marker" aria-hidden="true"></i></button>
                <p style="margin-bottom: 10px;">We understand that the bike is everything and it is always subject to the eyes for theif, hence we would only be displaying the country and region on the site for your safety. If you are would like it to be display at some other region than your location, please type and and check on the coutry and region box for your satisfaction.</p>
                <div id="profile-map" class="profile-map"></div>
            </div>
            <hr class="form-divider">
            <?php $location = geoip_record_by_name($_SERVER['REMOTE_ADDR']); if ($location == false) $location = []; ?>
            <div class="in-gr-cont">
                <div class="input-group">
                    <label>@php echo \App\Language::GetText(112); @endphp</label>
                    <input type="text" id="country_autocompl" value="{{ !is_null($Ad) ? $Ad->adsCountry : (key_exists("country_name",$location)  ? $location['country_name'] : "") }}" name="adsCountry" class="user-input valid not-ic" placeholder="United States" required>
                </div>
                <div class="input-group">
                    <label>@php echo \App\Language::GetText(113); @endphp</label>
                    <input type="text" id="region_autocompl" value="{{ !is_null($Ad) ? $Ad->adsRegion : (key_exists("region",$location) ? $location["region"] : "") }}" name="adsRegion" class="user-input valid not-ic" placeholder="Florida" required>
                </div>
                <div class="input-group">
                    <label>@php echo \App\Language::GetText(114); @endphp</label>
                    <input type="text" id="city_autocompl" value="{{ !is_null($Ad) ? $Ad->adsCity : (key_exists("city",$location)  ? $location['city'] : "") }}" name="adsCity" class="user-input valid not-ic" placeholder="Miamy" required>
                </div>
                <div class="place_phone_num">
                    <span>@php echo \App\Language::GetText(115); @endphp</span>
                    <select class="first_tell_num" id="first_tell_num" name="adsCallingCode">
                        @foreach($Phones as $phone)
                        <option {{ !is_null($Ad) ? (intval($Ad->adsCallingCode) == intval($phone['callingCode']) ? "selected" : ""): (key_exists("country_name",$location)  ? ($location['country_code'] == $phone['code'] ? "selected" : "") : "") }} data-cntr="{{$phone['code']}}" value="{{$phone['callingCode']}}">+{{$phone['callingCode']}}</option>
                        @endforeach
                    </select>
                    <input class="second_tell_num" value="{{ !is_null($Ad) ? $Ad->adsContactNo : "" }}" type="tel" pattern="^[0-9]+$" name="adsContactNo" placeholder="23 218 5743" />
                </div>
                @if (\Auth::user()->phone != NULL)
                <script>
                    var user_phone = '{{ \Auth::user()->phone }}';
                </script>
                @endif
            </div>
            <div class="sell_dest">
                <button type="button" id="save_ad" class="blue_btn sell_now_bl">Save</button>

            </div>
        </div>
    </form>
</div>
<style>
.cover_butt {
   background: #0084FF !important;
}
.payment.box-card{
    background: #f9f9f9;
    padding: 40px;
    border-radius: 5px;
    margin-bottom: 40px;
    position: relative;
    display: block;
    float: left;
    width: 100%;
    transition: 0.3s;
    border: 1px solid #E9ECF4
}
.payment.box-card input{
    padding: 10px 15px;
    background: #fff;
    border: 0;
    font-size: 18px;
    font-family: 'sf_ui_textbold', sans-serif;
    letter-spacing: 4px;
    border: 2px solid rgba(0, 132, 255, 0.25);
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
    color: #575757;
    font-size: 14px;
    font-family: 'sf_ui__textregular', sans-serif;
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

.form-group-card {
    position: relative;
}

img.cardlabel {
    position: absolute;
    right: 15px;
    bottom: 5px;
    height: 35px;
}

@media (min-width: 1020px) {

    .two-part-row {
        display: flex;
        justify-content: space-between;
    }

    .part-row {
        width: 50%;
        padding: 25px;
    }

}

@media (max-width: 540px) {

    .payment.box-card .number_card,
    .payment.box-card .date_card,
    .payment.box-card .cvv_card,
    .payment.box-card .form-group-card:nth-child(2),
    .payment.box-card .form-group-card:nth-child(3),
    .payment.box-card .form-group-card:nth-child(4) {
        width: 100%;
        text-align: left;
        float: none;
        top: 0;
    }

    .payment.box-card input {
        font-size: 14px;
    }

    .payment.box-card {
        padding: 25px 15px;
    }

    .payment.box-card .form-group-card:nth-child(1),
    .payment.box-card .form-group-card:nth-child(2),
    .payment.box-card .form-group-card:nth-child(3) {
        margin-bottom: 15px;
    }

    img.cardlabel {
        top: -10px;
    }

}

</style>
<script>

function initMap() {
    @php
        if (key_exists("city",$location) and key_exists("country_name",$location))
            $geo = json_decode(file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.$location['city'].',%20'.$location['country_name'].'&amp&sensor=false'), true);

        if (isset($geo) and isset($geo["results"][0]["geometry"]["location"]))
             echo "var uluru = {lat: ".$geo["results"][0]["geometry"]["location"]["lat"].", lng: ".$geo["results"][0]["geometry"]["location"]["lng"]."};";
        else
            echo "var uluru = {lat: 40.584378, lng: -122.388424};";
    @endphp

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
        icon: image,
        draggable:true,
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
                            console.log(results[0]["address_components"]);

                            let txt_location_city = '';
                            let txt_location_region = '';
                            let txt_location_country = '';

                            for (var i = 0; i < results[0]["address_components"].length; i++) {
                              var component = results[0]["address_components"][i];

                                if(component['types'][0] == "locality"){
                                    $('#city_autocompl').val(component['long_name']);
                                    txt_location_city = component['long_name'];
                                    hasCity = true;
                                }
                                else if(component['types'][0] == "administrative_area_level_1"){
                                    $('#region_autocompl').val(component['long_name']);
                                    txt_location_region = component['long_name']+', ';
                                    hasRegion = true;
                                }
                                else if(component['types'][0] == "country"){
                                    $('#country_autocompl').val(component['long_name']);
                                    txt_location_country = component['long_name']+', ';
                                    hasCountry = true;


                                    let val = jQuery('option[data-cntr='+component["short_name"]+']');
                                    if(val.length > 0){
                                        jQuery("select.first_tell_num").val(val.val()).trigger("change");
                                    }
                                }
                            }

                            $('#location_autofill').val(txt_location_country+txt_location_region+txt_location_city);

                            if(hasCity == false){
                                $('#city_autocompl').val('');
                            }

                            if(hasRegion == false){
                                $('#region_autocompl').val('');
                            }

                            if(hasCountry == false){
                                $('#country_autocompl').val('');
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


    location.onkeydown = function (e) {

        if(e.keyCode == 13){

            clearTimeout(timer);

            profile_settings_form[0].onsubmit =function (e) {
                e.preventDefault();
                return false;
            };

            timer = setTimeout(function () {

                profile_settings_form[0].onsubmit = null;

            },1000);

        }

    };

    google.maps.event.addListener(marker, "dragend", function(event) {
        var point = marker.getPosition();
        var latlng = {lat: parseFloat(point.lat()), lng: parseFloat(point.lng())};
        geocoder.geocode({'location': latlng}, function(results, status) {
            if (status === 'OK') {
                if (results[0]) {

                    let txt_location_city = '';
                    let txt_location_region = '';
                    let txt_location_country = '';

                    results[0]['address_components'].forEach(function(item, i, arr) {
                        if (item.types.indexOf("country") != -1){
                            $('#country_autocompl').val(item.long_name);
                            txt_location_country = item.long_name+', ';
                            let val = jQuery('option[data-cntr='+item.short_name+']');
                            if(val.length > 0){
                                jQuery("select.first_tell_num").val(val.val()).trigger("change");
                            }
                        }
                        if (item.types.indexOf("administrative_area_level_1") != -1) {
                           $('#region_autocompl').val(item.long_name);
                           txt_location_region = item.long_name+', ';
                        }
                        if (item.types.indexOf("locality") != -1) {
                           $('#city_autocompl').val(item.long_name);
                           txt_location_city = item.long_name;
                        }
                    });

                    $('#location_autofill').val(txt_location_country+txt_location_region+txt_location_city);
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
                let val = jQuery('option[data-cntr='+locality.short_name+']');
                if(val.length > 0){
                    jQuery("select.first_tell_num").val(val.val()).trigger("change");
                }
                break;
            case locality.types.indexOf("administrative_area_level_1") >= 0:
                region.value = locality.long_name;
                break;
            case locality.types.indexOf("locality") >= 0 || locality.types.indexOf("sublocality" ) >= 0 || locality.types.indexOf("postal_town" ) >= 0:
                city.value = locality.long_name;
                break;
            }


        });
        }



    });

}
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBs-wGPSQvrx03p1gy4JY94xDgUJfz2Hzw&libraries=places&language=en&callback=initMap"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<script src="/newthemplate/bower_components/rxp-js/rxp-js.min.js"></script>
<script src="/newthemplate/js/Elavon.js"></script>
<script src="/newthemplate/js/TextLoader.js"></script>
<script>
   var paid = false;
   var amount = 0;

   paypal.Button.render({
     // Configure environment
     env: '{{\App\Option::getSetting("opt_paypal_type")}}',
     client: {

         sandbox: '{{\App\Option::getSetting("opt_paypal_client_id_sandbox")}}',
         production: '{{\App\Option::getSetting("opt_paypal_client_id_live")}}'

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
            @php
                if (\Auth::user()->isRetailer and intval(\App\Option::getSetting("opt_tax_business")) == 1) {
                    echo "total: amount + (amount / 100 * ".\App\Option::getSetting("opt_tax_proc")."),";
                } elseif (!\Auth::user()->isRetailer and intval(\App\Option::getSetting("opt_tax_individual")) == 1) {
                    echo "total: amount + (amount / 100 * ".\App\Option::getSetting("opt_tax_proc")."),";
                } else {
                    echo "total: amount,";
                }
            @endphp
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
           $('#ads_store').append('<input name="pac" type="hidden" value="'+res.id+'">');
           $('#ads_store').submit();
         });
     }
   }, '#paypal-button');
</script>

@include("newthemplate.footer")