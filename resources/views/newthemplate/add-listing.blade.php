@include("newthemplate.header")
<div class="baner-not-bg">
    <section id="baner-header" class="baner-header">
        <div class="content wow">
            <ul class="tabs">
                <li class="tab-link current" data-tab="tab-1">Everything</li>
                <li class="tab-link" data-tab="tab-2">Try the amazing Filter!</li>

            </ul>
            <div class="tab-content current" id="tab-1">
                <ul class="header_crumbs">
                    <li><a href="{{ route('home') }}">Home ></a></li>
                    <!-- <li><a href="#">Categories ></a></li> -->
                    @if(app('request')->input('subCategoryId') != null)
                    <li><a href="/add-listing?categoryId={{\App\SubCategory::find((int) app('request')->input('subCategoryId'))->category->id}}">{{ \App\SubCategory::find((int) app('request')->input('subCategoryId'))->category->categoryName }}</a> ></li>
                    <li><a href="/add-listing?subCategoryId={{app('request')->input('subCategoryId')}}">{{ \App\SubCategory::find((int) app('request')->input('subCategoryId'))->subCategoryName }}</a></li>
                    @else  {{-- subCategoryId --}}
                    @if(app('request')->input('categoryId') != null)
                    <li><a>{{ \App\Category::find((int) app('request')->input('categoryId'))->categoryName }}</a></li>  <!-- href="/add-listing?categoryId={{app('request')->input('categoryId')}}" -->
                    @else {{-- categoryId --}}
                    <li>Everything</li>
                    @endif {{-- categoryId --}}
                    @endif {{-- subCategoryId --}}
                </ul>
                <form id="search_form">
                    <input type="text" name="search" id="SearchTags" placeholder="Search 256 Ads" value="{{ app('request')->input('search') }}" />
                    <div class="notify">
                        To add as tag press enter
                    </div>
                    <button class="bt" name="submit" type="button">Search</button>
                </form>
            </div>
            <div class="tab-content" id="tab-2">
                <form id="search_form2">
                    <select id="FilterBrand" style="width: 100%;">
                        <option value="">All brands</option>
                    </select>
                    <select id="FilterType" style="width: 100%;" disabled>
                        <option value="">All types</option>
                    </select>
                    <select id="FilterModel" style="width: 100%;" disabled>
                        <option value="">All models</option>
                    </select>
                    <input type="text" name="search" placeholder="Search 256 Ads" id="SearchTags2" value="{{ app('request')->input('search') }}" />
                    <button class="bt" name="submit" type="button"></button>
                </form>
            </div>
        </div>
    </section>
</div>

<div class="container">
    <div class="sub-filter-container">

        @if(app('request')->input('tags') != null)

            @foreach(app('request')->input('tags') as $tag)

            <div class="blue_btn sub-filt-bl" data-val="{{$tag}}">
                <span>{{$tag}}</span>
                <img class="close_sb_f" src="/newthemplate/img/close_filter.svg" alt="Remove">
            </div>

            @endforeach

        @endif

        <!--<div class="blue_btn sub-filt-bl">
            <span>Bike</span>
            <img class="close_sb_f" src="/newthemplate/img/close_filter.svg" alt="Alternate Text" />
        </div>
        <div class="blue_btn sub-filt-bl">
            <span>NY</span>
            <img class="close_sb_f" src="/newthemplate/img/close_filter.svg" alt="Alternate Text" />
        </div>
        <div class="blue_btn sub-filt-bl">
            <span>United States</span>
            <img class="close_sb_f" src="/newthemplate/img/close_filter.svg" alt="Alternate Text" />
        </div>-->
    </div>
</div>

<div class="rec_choose_sect">
    <div class="ch_sec_left">
        <a href="#">Rafine</a>
        <a href="#">Best Match</a>
    </div>
    
</div>

<div class="container">
    <div class="ch_sec_right">
        <svg class="ch_tab_1 active_svg_ic" width="18" height="14" viewBox="0 0 18 14" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 6.46154H5.29412V0H0V6.46154ZM0 14H5.29412V7.53846H0V14ZM6.35294 14H11.6471V7.53846H6.35294V14ZM12.7059 14H18V7.53846H12.7059V14ZM6.35294 6.46154H11.6471V0H6.35294V6.46154ZM12.7059 0V6.46154H18V0H12.7059Z" fill="white" />
        </svg>
        <svg class="ch_tab_2" width="17" height="14" viewBox="0 0 17 14" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 9H4V5H0V9ZM0 14H4V10H0V14ZM0 4H4V0H0V4ZM5 9H17V5H5V9ZM5 14H17V10H5V14ZM5 0V4H17V0H5Z" fill="white" />
        </svg>
    </div>
    <div class="subcategory_car">
        <div class="sub-cap">Subcategory</div>
        <div class="sub_block">
            <select>
                <option value="value">Sportcars</option>
                <option value="value">Motorbike</option>
            </select>
            @if(app('request')->input('search') != null || app('request')->input('tags') != null)
            <div class="result_search"><b>{{count($ads)}}</b> ads for <b>{{implode(": ", array_filter(
                                    [
                                       app('request')->input('search') == null ? false : app('request')->input('search'),
                                       app('request')->input('tags') == null ? false : implode(",",app('request')->input('tags')),
                                    ]
                                    ))}}</b> in <b>Ireland</b></div>
            @else
            <div class="result_search"><b>{{count($ads)}}</b> ads for <b>Recent</b> in <b>Ireland</b></div>
            @endif
            <button class="save_srch_btn">Save search</button>

        </div>
    </div>
</div>

<section class="products-list">
    <div class="container with-sidebar">
        <div class="side-filters">
           <form id="search_form2">
            <h3>Refine</h3>
            <div class="side-qty-row">
                <span>74,277 ads</span>
                <a href="#" class="side-done" id="filter_submit">Done</a>
            </div>
            <div class="side-filter-line active">
                <div class="side-line-title">
                    Location
                </div>
                <div class="side-line-content">
                    <div class="location-tabs">
                        <a href="#tab-country" class="active">Country</a>
                        <a href="#tab-near">Near Me</a>
                    </div>
                    <div class="location-content">
                        <div class="location-inner active" id="tab-country">
                            <label for="CountryFilter" class="country-label">Country</label>
                            <select name="" id="CountryFilter" class="side-select2">
                            </select>
                            <label for="CityFilter" class="country-label">City</label>
                            <select name="" id="CityFilter" class="side-select2" disabled>
                            </select>
                        </div>
                        <div class="location-inner" id="tab-near">
                            <div id="map-near-me"></div>
                            <div class="range-slider">
                                <label for="">Search within <span id="range-value">25</span>km</label>
                                <input id="range" type="range" step="0.5" min="7" max="621.5" data-units="metric" class="range-slider" value="0">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="side-filter-line">
                <div class="side-line-title">
                    Type
                </div>
                <div class="side-line-content">
                    <div class="radio-group">
                        <input type="radio" checked name="car_type" value="any">
                        <label>Any</label>
                        <input type="radio" name="car_type" value="new">
                        <label>New</label>
                        <input type="radio" name="car_type" value="used">
                        <label>Used</label>
                    </div>
                </div>
            </div>
            <div class="side-filter-line">
                <div class="side-line-title">
                    Make / Model
                </div>
                <div class="side-line-content make-model-block">
                    <select name="" id="FilterBrand2" class="side-select2">
                        <option value="0">Choose Make</option>
                    </select>
                    <select name="" id="FilterType2" class="side-select2" disabled>
                        <option value="">Choose Type</option>
                    </select>
                    <select name="" id="FilterModel2" class="side-select2" disabled>
                        <option value="">Choose Model</option>
                    </select>
                </div>
            </div>
            <div class="side-filter-line">
                <div class="side-line-title">
                    Year
                </div>
                <div class="side-line-content side-row">
                    <div class="min-max-group">
                        <input type="text" id="MinYear">
                        <label for="">Min</label>
                    </div>
                    <div class="min-max-group">
                        <input type="text" id="MaxYear">
                        <label for="">Max</label>
                    </div>
                </div>
            </div>
            <div class="side-filter-line">
                <div class="side-line-title">
                    Price
                </div>
                <div class="side-line-content side-row">
                    <div class="min-max-group">
                        <select name="" id="Currency">
                            <option value="EUR">€</option>
                            <option value="GBP">£</option>
                            <option value="USD">$</option>
                        </select>
                    </div>
                    <div class="min-max-group">
                        <input type="text" id="MinPrice">
                        <label for="">Min</label>
                    </div>
                    <div class="min-max-group">
                        <input type="text" id="MaxPrice">
                        <label for="">Max</label>
                    </div>
                </div>
            </div>
            <div class="side-filter-line">
                <div class="side-line-title">
                    Mileage
                </div>
                <div class="side-line-content side-row">
                   <div class="min-max-group">
                        <select name="" id="MileageType">
                            <option value="km">km</option>
                            <option value="mi">mi</option>
                        </select>
                    </div>
                    <div class="min-max-group">
                        <input type="text" id="MinMileage">
                        <label for="">Min</label>
                    </div>
                    <div class="min-max-group">
                        <input type="text" id="MaxMileage">
                        <label for="">Max</label>
                    </div> 
                </div>
            </div>
            <div class="side-filter-line">
                <div class="side-line-title">
                    Engine Size (L)
                </div>
                <div class="side-line-content side-row">
                    <div class="min-max-group">
                        <input type="text" id="MinEngine_size">
                        <label for="">Min</label>
                    </div>
                    <div class="min-max-group">
                        <input type="text" id="MaxEngine_size">
                        <label for="">Max</label>
                    </div>
                </div>
            </div>
            <div class="side-filter-line">
                <div class="side-line-title">
                    Fuel Type
                </div>
                <div class="side-line-content check-line">
                    <div class="check-block">
                        <input type="checkbox" checked name="FuelType" value="any">
                        <label for="">Any</label>   
                    </div>
                    <div class="check-block">
                        <input type="checkbox" name="FuelType" value="Petrol">
                        <label for="">Petrol</label>   
                    </div>
                    <div class="check-block">
                        <input type="checkbox" name="FuelType" value="Diesel">
                        <label for="">Diesel</label>   
                    </div>
                    <div class="check-block">
                        <input type="checkbox" name="FuelType" value="Electric">
                        <label for="">Electric</label>   
                    </div>
                    <div class="check-block">
                        <input type="checkbox" name="FuelType" value="Hybrid">
                        <label for="">Hybrid</label>   
                    </div>
                </div>
            </div>
            <div class="side-filter-line">
                <div class="side-line-title">
                    Transmission
                </div>
                <div class="side-line-content">
                    <div class="radio-group">
                        <input type="radio" name="transmission" checked value="any">
                        <label>Any</label>
                        <input type="radio" name="transmission" value="Manual">
                        <label>Manual</label>
                        <input type="radio" name="transmission" value="Automatic">
                        <label>Automatic</label>
                    </div>
                </div>
            </div>
            <div class="side-filter-line">
                <div class="side-line-title">
                    Body Type
                </div>
                <div class="side-line-content check-line">
                    <div class="check-block">
                        <input type="checkbox" name="BodyType" checked value="any">
                        <label for="">Any</label>   
                    </div>
                    <div class="check-block">
                        <input type="checkbox" name="BodyType" value="Cabriolet">
                        <label for="">Cabriolet</label>   
                    </div>
                    <div class="check-block">
                        <input type="checkbox" name="BodyType" value="Coupe">
                        <label for="">Coupe</label>   
                    </div>
                    <div class="check-block">
                        <input type="checkbox" name="BodyType" value="Saloon">
                        <label for="">Saloon</label>   
                    </div>
                    <div class="check-block">
                        <input type="checkbox" name="BodyType" value="Hatchback">
                        <label for="">Hatchback</label>   
                    </div>
                    <div class="check-block">
                        <input type="checkbox" name="BodyType" value="Estate">
                        <label for="">Estate</label>   
                    </div>
                    <div class="check-block">
                        <input type="checkbox" name="BodyType" value="MPV">
                        <label for="">MPV</label>   
                    </div>
                    <div class="check-block">
                        <input type="checkbox" name="BodyType" value="SUV">
                        <label for="">SUV</label>   
                    </div>
                </div>
            </div>
            <div class="side-filter-line">
                <div class="side-line-title">
                    Colour
                </div>
                <div class="side-line-content">
                    <select name="Colour" id="Colour" class="side-select2">
                        <option value="any">Any</option>
                        <option value="Black">Black</option>
                        <option value="Blue">Blue</option>
                        <option value="Brown">Brown</option>
                        <option value="Gray">Gray</option>
                        <option value="Green">Green</option>
                        <option value="Orange">Orange</option>
                        <option value="Red">Red</option>
                        <option value="Pink">Pink</option>
                        <option value="Violet">Violet</option>
                        <option value="White">White</option>
                        <option value="Yellow">Yellow</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
            </div>
            <div class="side-filter-line">
                <div class="side-line-title">
                    Doors
                </div>
                <div class="side-line-content check-line">
                    <div class="check-block">
                        <input type="checkbox" name="Doors" checked value="any">
                        <label for="">Any</label>   
                    </div>
                    <div class="check-block">
                        <input type="checkbox" name="Doors" value="2">
                        <label for="">2</label>   
                    </div>
                    <div class="check-block">
                        <input type="checkbox" name="Doors" value="3">
                        <label for="">3</label>   
                    </div>
                    <div class="check-block">
                        <input type="checkbox" name="Doors" value="4">
                        <label for="">4</label>   
                    </div>
                    <div class="check-block">
                        <input type="checkbox" name="Doors" value="5">
                        <label for="">5</label>   
                    </div>
                    <div class="check-block">
                        <input type="checkbox" name="Doors" value="6">
                        <label for="">6</label>   
                    </div>
                </div>
            </div>
            <div class="side-filter-line">
                <div class="side-line-title">
                    Country of Registration
                </div>
                <div class="side-line-content check-line">
                    <select name="CountryRegisterFilter" id="CountryRegisterFilter" class="side-select2">
                    </select>
                </div>
            </div>
            <div class="side-filter-line">
                <div class="side-line-title">
                    Seller Type
                </div>
                <div class="side-line-content">
                    <div class="radio-group">
                        <input type="radio" name="seller_type" checked value="any">
                        <label>Any</label>
                        <input type="radio" name="seller_type" value="private">
                        <label>Private</label>
                        <input type="radio" name="seller_type" value="dealer">
                        <label>Dealer</label>
                    </div>                    
                </div>
            </div>
            <div class="side-filter-line">
                <div class="side-line-title">
                    For Sale / Wanted
                </div>
                <div class="side-line-content">
                    <div class="radio-group">
                        <input type="radio" name="sale-wanted" value="For sale">
                        <label>For Sale</label>
                        <input type="radio" name="sale-wanted" value="Wanted">
                        <label>Wanted</label>
                    </div> 
                </div>
            </div>
            <div class="side-filter-line">
                <div class="side-line-title">
                    Previous Owners
                </div>
                <div class="side-line-content">
                    <select name="previous_owners" id="previous_owners" class="side-select2">
                        <option value="any">Any</option>
                        <option value="0">0 (New)</option>
                        <option value="1">Up to 1</option>
                        <option value="2">Up to 2</option>
                        <option value="3">Up to 3</option>
                        <option value="4">Up to 4</option>
                        <option value="5">Up to 5</option>
                    </select>
                </div>
            </div>
            <a href="#" class="side-clear">Clear All</a>
            </form>
        </div>
        <div class="recent-ads">
            <div class="recent_container">
                @foreach ($ads as $ad)
                <a href="{{ route('ads.add-details', ['ads' => $ad->id]) }}" class="recent_block">
                    <div class="rec_photo"><img src="{{ $ad->adsImage or '/newthemplate/img/logo.svg' }}" alt="{{ $ad->adsImage }}" /></div>
                    <div class="rec_car_info">
                        <div class="rec_name_car">{{ $ad->adsName }}</div>
                        <div class="rec_country">{{ $ad->getCityRegionCountry() }}</div>
                        <div class="rect_text_block info-list">
                            <div class="rect_left_text">Certificate of Road</div>
                        </div>
                        <div class="rect_text_block info-list">
                            <div class="rect_left_text">Warthiness:</div>
                            <div class="rect_right_text">No</div>
                        </div>
                        <div class="rect_text_block info-list">
                            <div class="rect_left_text">Brand:</div>
                            <div class="rect_right_text">Ford</div>
                        </div>
                        <div class="rect_text_block info-list">
                            <div class="rect_left_text">Year:</div>
                            <div class="rect_right_text">2018</div>
                        </div>
                        <div class="rect_text_block info-list">
                            <div class="rect_left_text">Miege:</div>
                            <div class="rect_right_text">200 km</div>
                        </div>
                        <div class="brief-information">
                            Honda, CRF450, 2016, 26 hours
                        </div>
                    </div>
                    <div class="rect_price">
                        <div class="rect_price_left">
                            <div class="rect_favorite"></div>
                            <div class="favorite_text">Favorite</div>
                        </div>
                        <div class="rect_price_right">{{ $ad->adsPriceWithType() }}</div>
                    </div>
                </a>
                    @if($loop->iteration >=6 && count($ads) > 6)
                        <a class='load-more'>Load More</a>
                        @break
                    @endif
                @endforeach
            </div>
            <div class="recent-pagin-mob pagin-list">
                <a class="rec_next_prev" href="#">Prev</a>
                <a class="active_pagin" href="#">1</a>
                <a href="#">2</a>
                <a href="#">3</a>
                <a class="rec_next_prev" href="#">Next</a>
            </div>
            <div class="recent-button-bottom">
                <!-- <a class="blue_btn rect_see_all" href="#">See all recent ads</a> -->
                <button class="save_srch_btn">Save search</button>
            </div>
        </div>
    </div>
    <!--RECENT ADS END-->
</section>
<script>
    @if(app('request')->input('subCategoryId') != null)
        let SubCategoryId = {{app('request')->input('subCategoryId')}};
    @endif
    @if(app('request')->input('categoryId') != null)
        let CategoryId = {{app('request')->input('categoryId')}};
    @endif
    @if(app('request')->input('search') != null)
        let SearchString = "{{app('request')->input('search')}}";
    @endif
</script>

   <script>
     
      var citymap = {
        losangeles: {
          center: {lat: 34.052, lng: -118.243},
          population: 3857799
        }
      };

      var cities_map_filter = [];

      var range = document.getElementById('range');
      var rangeTarget = document.getElementById('range-value');

      function callback2(e) {
         if (e != null)
            e.forEach(function(item, i, arr) {
               console.log(item);
               // cities_map_filter[] =
            });
      }

      function initMap() {
        // Create the map.
        var map = new google.maps.Map(document.getElementById('map-near-me'), {
          zoom: 12,
          center: {lat: 34.052, lng: -118.243},
          mapTypeId: 'terrain'
        });

        var service = new google.maps.places.PlacesService(map);

        // Construct the circle for each value in citymap.
        // Note: We scale the area of the circle based on the population.
        for (var city in citymap) {
          // Add the circle for this city to the map.
          var cityCircle = new google.maps.Circle({
            strokeColor: '#FF0000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#FF0000',
            fillOpacity: 0.35,
            map: map,
            center: citymap[city].center,
            radius: Math.sqrt(citymap[city].population),
            draggable: true
          });

          //console.log(Math.sqrt(citymap[city].population) * 10);
        }

        range.addEventListener('input', function(e) {

            var rangeValue = range.value;
            //console.log(rangeValue);

            rangeTarget.innerHTML = rangeValue;
            cityCircle.setRadius(rangeValue * 100);

           var request = {
             location: {lat: cityCircle.center.lat(), lng: cityCircle.center.lng()},
             radius: Math.round(rangeValue * 100),
             type: ['locality']
           };
           console.log(request);
           service.nearbySearch(request, callback2);
        });
      }
    </script>

<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAGLYEy6zq-xrw6eQBr4Ctuy3oFC7XnGzY&callback=initMap&libraries=places&language=en">
    </script>


@include("newthemplate.footer")