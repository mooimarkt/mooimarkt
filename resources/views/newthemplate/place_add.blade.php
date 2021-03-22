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
    <form action="{{ route('ads.store') }}" method="POST" class="fill_details profile-settings-form" id="ads_store">
        <input type="hidden" name="pay_token" value="">
        <input type="hidden" name="pay_type" value="">
        @if(!is_null($Ad))
        <input type="hidden" name="ad_id" value="{{$Ad->id}}">
        @endif
        <div id="first_step">
            {{ csrf_field() }}
            <div class="top_reset">
                <h1 class="caption-text"><span>Fill in</span> Ad details</h1>
            </div>
            <div class="fl-wrp">
                <div class="input-group input-group-3" style="width: 50%;">
                    <label>Add Title</label>
                    <input type="text" name="adsName" value="{{!is_null($Ad) ? $Ad->adsName : ""}}" class="user-input" placeholder="Nice Bike" required>
                </div>
                <div class="input-group input-group-3" style="width: 25%;">
                    <label>Currency</label>
                    <select name="adsPriceType" id="adsPriceType" class="user-input">
                        <option {{!is_null($Ad) ? ($Ad->adsPriceType == "USD" ? "selected" : "") : ""}} value="USD">USD</option>
                        <option {{!is_null($Ad) ? ($Ad->adsPriceType == "EUR" ? "selected" : "") : ""}} value="EUR">EUR</option>
                        <option {{!is_null($Ad) ? ($Ad->adsPriceType == "GBP" ? "selected" : "") : ""}} value="GBP">GBP</option>
                    </select>
                </div>
                <div class="input-group input-group-3" style="width: 25%;">
                    <label>Price</label>
                    <input type="text" onkeyup="this.value = this.value.replace(/[^0-9]/g,'')" name="adsPrice" value="{{!is_null($Ad) ? $Ad->adsPrice : ""}}" class="user-input" placeholder="4500" required>
                </div>
                <div class="input-group input-group-4" style="padding: 0 20px; width: 25%;">
                    <div class="input-group">
                        <label>Category</label>
                        <select class="user-input" id="categoryId">
                            @foreach ($categories as $category)
                            <option {{!is_null($Ad) ? ($Ad->subcategory->categoryId == $category->id ? "selected" : "" ) : ""}} value="{{ $category->id }}">{{ $category->categoryName }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="input-group input-group-4" style="padding: 0 20px; width: 25%;">
                    <div class="input-group">
                        <label for="subCategoryId">Subcategory</label>
                        <select name="subCategoryId" id="subCategoryId" class="user-input">
                            @foreach ($subCategories as $subCategory)
                            <option data-model="{{ $subCategory->filtername }}" {{!is_null($Ad) ? ($Ad->subCategoryId == $subCategory->id ? "selected" : "" ) : ""}} value="{{ $subCategory->id }}">{{ $subCategory->subCategoryName }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="input-group input-group-4" style="padding: 0 20px; width: 25%;">
                    <div class="input-group">
                       <label for="FilterBrand">Brand</label>
                       <select id="FilterBrand" name="brand" style="width: 100%;">
                           <option value="">All brands</option>
                       </select>
                    </div>
                </div>
                <div class="input-group input-group-4" style="padding: 0 20px; width: 25%;">
                    <div class="input-group">
                       <label for="FilterModel">Model</label>
                       <select id="FilterModel" name="model" style="width: 100%;" disabled>
                           <option value="">All models</option>
                       </select>
                    </div>
                    <input id="FilterType" type="hidden" name="type" value="Enduro">
                </div>
                <div class="input-group input-group-4" style="padding: 0 20px; width: 25%;">
                    <div class="input-group">
                       <label for="TypeAd">Type</label>
                       <select id="TypeAd" name="type_ad" style="width: 100%;" class="user-input">
                           <option {{!is_null($Ad) ? ($Ad->type_ad == "Used" ? "selected" : "") : ""}} value="Used">Used</option>
                           <option {{!is_null($Ad) ? ($Ad->type_ad == "New" ? "selected" : "") : ""}} value="New">New</option>
                       </select>
                    </div>
                    <input id="FilterType" type="hidden" name="type" value="Enduro">
                </div>
                <div class="input-group input-group-4" style="padding: 0 20px; width: 25%;">
                    <div class="input-group">
                       <label for="AdYear">Year</label>
                       <input type="number" name="year" maxlength="4" id="AdYear" value="{{!is_null($Ad) ? $Ad->year : ""}}" class="user-input" placeholder="2018">
                    </div>
                </div>
                <div class="input-group input-group-4" style="padding: 0 20px; width: 25%;">
                    <div class="input-group">
                       <label for="Mileage">Mileage</label>
                       <input type="number" name="mileage" id="Mileage" value="{{!is_null($Ad) ? $Ad->mileage : ""}}" class="user-input" placeholder="">
                    </div>
                </div>
                <div class="input-group input-group-4" style="padding: 0 20px; width: 25%;">
                    <div class="input-group">
                       <label for="Mileage">Mileage type</label>
                       <select id="mileage_type" name="mileage_type" style="width: 100%;" class="user-input">
                           <option {{!is_null($Ad) ? ($Ad->mileage_type == "km" ? "selected" : "") : ""}} value="km">km</option>
                           <option {{!is_null($Ad) ? ($Ad->mileage_type == "mi" ? "selected" : "") : ""}} value="mi">mi</option>
                       </select>
                    </div>
                </div>
                <div class="input-group input-group-4" style="padding: 0 20px; width: 25%;">
                    <div class="input-group">
                       <label for="engine_size">Engine size (l)</label>
                       <input type="text" name="engine_size" id="engine_size" value="{{!is_null($Ad) ? $Ad->engine_size : ""}}" class="user-input" placeholder="">
                    </div>
                </div>
                <div class="input-group input-group-4" style="padding: 0 20px; width: 25%;">
                    <div class="input-group">
                       <label for="fuel_type">Fuel type</label>
                       <select id="fuel_type" name="fuel_type" style="width: 100%;" class="user-input">
                           <option {{!is_null($Ad) ? ($Ad->fuel_type == "Petrol" ? "selected" : "") : ""}} value="Petrol">Petrol</option>
                           <option {{!is_null($Ad) ? ($Ad->fuel_type == "Diesel" ? "selected" : "") : ""}} value="Diesel">Diesel</option>
                           <option {{!is_null($Ad) ? ($Ad->fuel_type == "Electric" ? "selected" : "") : ""}} value="Electric">Electric</option>
                           <option {{!is_null($Ad) ? ($Ad->fuel_type == "Hybrid" ? "selected" : "") : ""}} value="Hybrid">Hybrid</option>
                       </select>
                    </div>
                </div>
                <div class="input-group input-group-4" style="padding: 0 20px; width: 25%;">
                    <div class="input-group">
                       <label for="transmission">Transmission</label>
                       <select id="transmission" name="transmission" style="width: 100%;" class="user-input">
                           <option {{!is_null($Ad) ? ($Ad->transmission == "Manual" ? "selected" : "") : ""}} value="Manual">Manual</option>
                           <option {{!is_null($Ad) ? ($Ad->transmission == "Automatic" ? "selected" : "") : ""}} value="Automatic">Automatic</option>
                       </select>
                    </div>
                </div>
                <div class="input-group input-group-4" style="padding: 0 20px; width: 25%;">
                    <div class="input-group">
                       <label for="body_type">Body type</label>
                       <select id="body_type" name="body_type" style="width: 100%;" class="user-input">
                           <option {{!is_null($Ad) ? ($Ad->body_type == "Saloon" ? "selected" : "") : ""}} value="Saloon">Saloon</option>
                           <option {{!is_null($Ad) ? ($Ad->body_type == "Cabriolet" ? "selected" : "") : ""}} value="Cabriolet">Cabriolet</option>
                           <option {{!is_null($Ad) ? ($Ad->body_type == "Coupe" ? "selected" : "") : ""}} value="Coupe">Coupe</option>
                           <option {{!is_null($Ad) ? ($Ad->body_type == "Hatchback" ? "selected" : "") : ""}} value="Hatchback">Hatchback</option>
                           <option {{!is_null($Ad) ? ($Ad->body_type == "Estate" ? "selected" : "") : ""}} value="Estate">Estate</option>
                           <option {{!is_null($Ad) ? ($Ad->body_type == "MPV" ? "selected" : "") : ""}} value="MPV">MPV</option>
                           <option {{!is_null($Ad) ? ($Ad->body_type == "SUV" ? "selected" : "") : ""}} value="SUV">SUV</option>
                       </select>
                    </div>
                </div>
                <div class="input-group input-group-4" style="padding: 0 20px; width: 25%;">
                    <div class="input-group">
                       <label for="сolour">Colour</label>
                       <select id="сolour" name="сolour" style="width: 100%;" class="user-input">
                           <option {{!is_null($Ad) ? ($Ad->сolour == "Black" ? "selected" : "") : ""}} value="Black">Black</option>
                           <option {{!is_null($Ad) ? ($Ad->сolour == "Blue" ? "selected" : "") : ""}} value="Blue">Blue</option>
                           <option {{!is_null($Ad) ? ($Ad->сolour == "Brown" ? "selected" : "") : ""}} value="Brown">Brown</option>
                           <option {{!is_null($Ad) ? ($Ad->сolour == "Gray" ? "selected" : "") : ""}} value="Gray">Gray</option>
                           <option {{!is_null($Ad) ? ($Ad->сolour == "Green" ? "selected" : "") : ""}} value="Green">Green</option>
                           <option {{!is_null($Ad) ? ($Ad->сolour == "Orange" ? "selected" : "") : ""}} value="Orange">Orange</option>
                           <option {{!is_null($Ad) ? ($Ad->сolour == "Red" ? "selected" : "") : ""}} value="Red">Red</option>
                           <option {{!is_null($Ad) ? ($Ad->сolour == "Pink" ? "selected" : "") : ""}} value="Pink">Pink</option>
                           <option {{!is_null($Ad) ? ($Ad->сolour == "Violet" ? "selected" : "") : ""}} value="Violet">Violet</option>
                           <option {{!is_null($Ad) ? ($Ad->сolour == "White" ? "selected" : "") : ""}} value="White">White</option>
                           <option {{!is_null($Ad) ? ($Ad->сolour == "Yellow" ? "selected" : "") : ""}} value="Yellow">Yellow</option>
                           <option {{!is_null($Ad) ? ($Ad->сolour == "Other" ? "selected" : "") : ""}} value="Other">Other</option>
                       </select>
                    </div>
                </div>
                <div class="input-group input-group-4" style="padding: 0 20px; width: 25%;">
                    <div class="input-group">
                       <label for="doors">Doors</label>
                       <select id="doors" name="doors" style="width: 100%;" class="user-input">
                           <option {{!is_null($Ad) ? ($Ad->сolour == 2 ? "selected" : "") : ""}} value="2">2</option>
                           <option {{!is_null($Ad) ? ($Ad->сolour == 3 ? "selected" : "") : ""}} value="3">3</option>
                           <option {{!is_null($Ad) ? ($Ad->сolour == 4 ? "selected" : "") : ""}} value="4">4</option>
                           <option {{!is_null($Ad) ? ($Ad->сolour == 5 ? "selected" : "") : ""}} value="5">5</option>
                           <option {{!is_null($Ad) ? ($Ad->сolour == 6 ? "selected" : "") : ""}} value="6">6</option>
                       </select>
                    </div>
                </div>
                <div class="input-group input-group-4" style="padding: 0 20px; width: 25%;">
                    <div class="input-group">
                       <label for="sale_type">For sale / wanted</label>
                       <select id="sale_type" name="sale_type" style="width: 100%;" class="user-input">
                           <option {{!is_null($Ad) ? ($Ad->sale_type == 'For sale' ? "selected" : "") : ""}} value="For sale">For sale</option>
                           <option {{!is_null($Ad) ? ($Ad->sale_type == 'Wanted' ? "selected" : "") : ""}} value="Wanted">Wanted</option>
                       </select>
                    </div>
                </div>
                <div class="input-group input-group-4" style="padding: 0 20px; width: 25%;">
                    <div class="input-group">
                       <label for="previous_owners">Previous owners</label>
                       <select id="previous_owners" name="previous_owners" style="width: 100%;" class="user-input">
                           <option {{!is_null($Ad) ? ($Ad->previous_owners == 0 ? "selected" : "") : ""}} value="0">0 (New)</option>
                           <option {{!is_null($Ad) ? ($Ad->previous_owners == 1 ? "selected" : "") : ""}} value="1">Up to 1</option>
                           <option {{!is_null($Ad) ? ($Ad->previous_owners == 2 ? "selected" : "") : ""}} value="2">Up to 2</option>
                           <option {{!is_null($Ad) ? ($Ad->previous_owners == 3 ? "selected" : "") : ""}} value="3">Up to 3</option>
                           <option {{!is_null($Ad) ? ($Ad->previous_owners == 4 ? "selected" : "") : ""}} value="4">Up to 4</option>
                           <option {{!is_null($Ad) ? ($Ad->previous_owners == 5 ? "selected" : "") : ""}} value="5">Up to 5</option>
                       </select>
                    </div>
                </div>
                <div class="input-group input-group-4" style="padding: 0 20px; width: 50%;">
                    <div class="input-group">
                       <label for="country_registration">Country of registration</label>
                       <select id="CountryFilter" name="country_registration" style="width: 100%;" class="user-input">
                       </select>
                    </div>
                </div>

                <hr class="form-divider">
                <div class="input-group">
                    <label>Details/Single Post</label>
                    <select class="user-input" name="ad_parts[]" id="postDetails" multiple>
                        <option value="0">Single post</option>
                        <optgroup label="PArent Post" >
                            <!-- FLTER BLOCKED AND USED ADS HERE  -->
                            <?php $PartAds = \App\Ads::with("details");
                            $PartAds->where('userId',\Illuminate\Support\Facades\Auth::id());
                            $PartAds->whereNull("parent_id");
                            ?>
                            @foreach ($PartAds->get() as $add)
                            @if(strpos($add,'blocked-') === 0) @continue @endif
                            @if(!is_null($add->details) && count($add->details) > 0) @continue @endif
                            <option data-price="{{ $add->adsStatus == "payed" ? 0 : ([
                            \App\Option::getSetting("opt_pack_basic"),
                            \App\Option::getSetting("opt_pack_basic"),
                            \App\Option::getSetting("opt_pack_auto_bump"),
                            \App\Option::getSetting("opt_pack_spotlight")
                            ][array_search($add->adsSelectedType,["","Basic","Auto bump","Spotlight"])]) }}" value="{{ $add->id }}">{{ $add->adsName }}</option>
                            @endforeach
                        </optgroup>
                    </select>
                </div>
                @if (Auth::user()->userRole == 'admin')
                <hr class="form-divider">
                <div class="input-group">
                    <label>Post as user</label>
                    <select name="userId" class="user-input" id="userId">
                        <option value="{{ Auth::id() }}" selected="selected">{{ Auth::user()->name.' ('.Auth::user()->email.')' }}</option>
                    </select>
                </div>
                @endif
                <hr class="form-divider">
                <div class="add_with_photo">
                    <div>Photos</div>
                    <span>Ads with photos sell twice as fast!</span>
                </div>
                <div class="block_dow_ph">
                    <input id="fileupload" type="file" data-url="{{ route('images.store') }}" multiple/>
                    <span id='select_file'>
                        <img src="/newthemplate/img/photo_down.svg" alt="Alternate Text" />
                        <span id="val_sel_file">Tap here to upload a photo</span>
                    </span>
                </div>
                <div class="set_as_cover">
                    <input type="hidden" name="adsImage" value="{{!is_null($Ad) ? $Ad->adsImage : "" }}" id="adsImage">
                    @if(!is_null($Ad))
                    <?php $images = \App\AdsImages::where('adsId', $Ad->id)->get(); ?>
                    @foreach($images as $img)
                    <div class="set_as_block">
                        <input type="hidden" name="adsImages[]" value="{{$img->id}}">
                        <img class="rect_img_abs" src="{{$img->imagePath}}" alt="{{$img->imagePath}}">
                        <div class="close_set_img"><img src="/newthemplate/img/close_img.svg" alt="Alternate Text"></div>
                        <div class="text_set_block {{$Ad->adsImage == $img->imagePath ? "cover_butt" : ""}}" onclick="changeCover(this)" data-src="{{$img->imagePath}}">{{$Ad->adsImage == $img->imagePath ? "Cover" : "Set As Cover"}}</div>
                    </div>
                    @endforeach
                    @if(count($images) > 0)
                    <script>
                        imgs = ['<?= implode("','",($images->pluck("imagePath")->toArray())); ?>'];
                    </script>
                    @endif
                    @endif
                </div>
                <hr class="form-divider form-divider-m">
            </div>
            <hr class="form-divider form-divider-none">
            <div class="decription_textarea">
                <span>Description</span>
                <textarea placeholder="Cool item. Nice bike. Buy it." name="adsDescription">{{!is_null($Ad) ? $Ad->adsDescription : ""}}</textarea>
            </div>
            <div class="place_tags">
                <div class="tags_up-to">
                    <div>Tags</div>
                    <span>Up to 15 tags</span>
                </div>
                <div class="bike_add">
                    <input type="text" value="Bike" />
                    <button class="bt_blu">Add</button>
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
                    <div class="blue_btn sub-filt-bl">
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
                    </div>
                    @endif
                </div>
            </div>
            <div class="input-group{{--  disp-none --}}">
                <label>Location</label>
                <input type="text" value="{{!is_null($Ad) ? $Ad->adsCountry . ", " . $Ad->adsRegion . ", " . $Ad->adsCity : ""}}" id="location_autofill" class="user-input" placeholder="Enter a location" autocomplete="off">
                <div id="profile-map" class="profile-map"></div>
            </div>
            <hr class="form-divider">
            <?php /*$location = geoip_record_by_name($_SERVER['REMOTE_ADDR']);*/?>
            {{--<div class="in-gr-cont">
                <div class="input-group">
                    <label>Country</label>
                    <input type="text" id="country_autocompl" value="{{ !is_null($Ad) ? $Ad->adsCountry : (key_exists("country_name",$location)  ? $location['country_name'] : "") }}" name="adsCountry" class="user-input valid not-ic" placeholder="USA" required>
                </div>
                <div class="input-group">
                    <label>Region</label>
                    <input type="text" id="region_autocompl" value="{{ !is_null($Ad) ? $Ad->adsRegion : (key_exists("region",$location) && key_exists('country_code',$location) ? geoip_region_name_by_code($location['country_code'],$location['region']) : "") }}" name="adsRegion" class="user-input valid not-ic" placeholder="Florida" required>
                </div>
                <div class="input-group">
                    <label>City</label>
                    <input type="text" id="city_autocompl" value="{{ !is_null($Ad) ? $Ad->adsCity : (key_exists("city",$location)  ? $location['city'] : "") }}" name="adsCity" class="user-input valid not-ic" placeholder="Miamy" required>
                </div>
                <div class="place_phone_num">
                    <span>Phone number</span>
                    <select class="first_tell_num" id="first_tell_num" name="adsCallingCode">
                        @foreach($Phones as $phone)
                        <option {{ !is_null($Ad) ? ($Ad->adsCallingCode == $phone['code'] ? "selected" : ""): (key_exists("country_name",$location)  ? ($location['country_code'] == $phone['code'] ? "selected" : "") : "") }} data-cntr="{{$phone['code']}}" value="{{$phone['callingCode']}}">+{{$phone['callingCode']}}</option>
                        @endforeach
                    </select>
                    <input class="second_tell_num" value="{{ !is_null($Ad) ? $Ad->adsContactNo : "" }}" type="tel" pattern="^[0-9]+$" name="adsContactNo" placeholder="23 218 5743" />
                </div>
            </div>--}}
            <div class="pl_pr_cont">
                <label class="place_price_block" for="adsSelectedType1">
                    <div class="pl_pr_top">Basic</div>
                    <div class="pl_pr_bot">
                        <div class="pl-pr-right">
                            <p>Listed 60 days</p>
                        </div>
                        <div class="pl-pr-left"><span class="pack_price">{{\App\Option::getSetting("opt_pack_basic")}}</span> EUR</div>
                        <input data-text="Listed 60 days" type="radio" {{ !is_null($Ad) ? ( $Ad->adsSelectedType == "Basic" ? "checked" : "" ) : "" }} name="adsSelectedType" id="adsSelectedType1" data-discont-price="{{\App\Option::getSetting("opt_pack_basic")}}" data-price="{{\App\Option::getSetting("opt_pack_basic")}}" class="opacity-none" value="Basic" required>
                    </div>
                </label>
                <label class="place_price_block" for="adsSelectedType2">
                    <div class="pl_pr_top">Auto bump</div>
                    <div class="pl_pr_bot">
                        <div class="pl-pr-right">
                            <p>Listed 60 days</p>
                            <p>Auto bump at 7-th day</p>
                            <p>Auto bump at 14-th day</p>
                        </div>
                        <div class="pl-pr-left"><span class="pack_price">{{\App\Option::getSetting("opt_pack_auto_bump")}}</span> EUR</div>
                        <input data-text="Listed 60 days, Auto bump at 7-th day, Auto bump at 14-th day" type="radio" {{ !is_null($Ad) ? ( $Ad->adsSelectedType == "Auto bump" ? "checked" : "" ) : "" }} name="adsSelectedType" id="adsSelectedType2" data-discont-price="{{\App\Option::getSetting("opt_pack_auto_bump")}}" data-price="{{\App\Option::getSetting("opt_pack_auto_bump")}}" class="opacity-none" value="Auto bump">
                    </div>
                </label>
                <label class="place_price_block" for="adsSelectedType3">
                    <div class="pl_pr_top">Spotlight</div>
                    <div class="pl_pr_bot">
                        <div class="pl-pr-right">
                            <p>Listed 60 days</p>
                            <p>Spotlight the adfor 24 hours</p>
                        </div>
                        <div class="pl-pr-left"><span class="pack_price">{{\App\Option::getSetting("opt_pack_spotlight")}}</span> EUR</div>
                        <input data-text="Listed 60 days, Spotlight the adfor 24 hours" type="radio" name="adsSelectedType" {{ !is_null($Ad) ? ( $Ad->adsSelectedType == "Spotlight" ? "checked" : "" ) : "" }} id="adsSelectedType3" data-discont-price="{{\App\Option::getSetting("opt_pack_spotlight")}}" data-price="{{\App\Option::getSetting("opt_pack_spotlight")}}" class="opacity-none" value="Spotlight">
                    </div>
                </label>
            </div>
            <div class="sell_dest">
                <div class="input-group">
                    <label>Promo Code (Voucher)</label>
                    <input type="text" id="voucher" class="user-input" placeholder="Enter a voucher" autocomplete="off">
                </div>
                <button type="submit" class="blue_btn sell_now_bl">sell now</button>
                <a href="#" class="price-gray-btn" id="preview-add">Preview your ad</a>
                <a href="#" class="price-gray-btn" id="save_draft" >Save without pay</a>
                {{-- <a href="#" class="blue_btn sell_now_bl" onclick="document.getElementById('ads_store').submit();">sell now</a> --}}
                <div class="by_click_text">
                    By clicking “Sell Now”, you agree with B4MX <br />
                    Terms and Conditions
                </div>
                <a href="#" class="price-gray-btn res_form" id="reset_form" >Reset Form</a>
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
            </form>
            <div id="paypal-button"></div>
        </div>
    </form>
</div>
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
                    results[0]['address_components'].forEach(function(item, i, arr) {
                        if (item.types.indexOf("country") != -1){
                            $('#country_autocompl').val(item.long_name);
                            let val = jQuery('option[data-cntr='+item.short_name+']');
                            if(val.length > 0){
                                jQuery("select.first_tell_num").val(val.val()).trigger("change");
                            }
                        }
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
   }, '#paypal-button');
</script>

@include("newthemplate.footer")