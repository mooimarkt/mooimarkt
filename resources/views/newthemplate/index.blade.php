@include( 'newthemplate.header' )
@include( 'newthemplate.baner' )

<!--OUR CATEGORIES START-->
<div class="our_categories">
    <div class="container">
        <div class="categ-arr categ-arr-left"><img src="/newthemplate/img/arr_bl_slider.svg" alt="Alternate Text"/>
        </div>
        <div class="categ-arr categ-arr-right"><img src="/newthemplate/img/arr_bl_slider.svg" alt="Alternate Text"/>
        </div>
        <h6 class="fadeInDown animated"><span>OUR </span>CATEGORIES</h6>
        <p class="p-center-text">Sed porttitor, quam id pellentesque tempor, erat enim placerat nisi, vel sodales ligula
            enim a augue.</p>
        <div class="swiper-container categories-slider">
            <div class="categories_container swiper-wrapper">
                <a href="{{ route('ads.add-listing') }}" class="cat_main_block swiper-slide wow">
                    <div class="cat_block">
                        <div class="cat-block-img">
                            <img src="/newthemplate/img/cat-car-1.svg" alt="Everything"/>
                        </div>
                        <div class="cat-name-car">Everything</div>
                        <div class="cat-inf-car">{{ App\Ads::where( 'adsStatus','payed' )->count().' '.(App\Ads::count() > 1 ? 'ads' : 'ad') }}</div>
                    </div>
                </a>
                @foreach ($categories as $category)
                    <a href="{{ route('ads.add-listing', ['categoryId' => $category->id]) }}"
                       class="cat_main_block swiper-slide wow">
                        <div class="cat_block">
                            <div class="cat-block-img">
                                <img src="{{ $category->categoryImage }}" alt="{{ $category->categoryName }}"/>
                            </div>
                            <div class="cat-name-car">{{ $category->categoryName }}</div>
                            <div class="cat-inf-car">{{ $category->adsnum.' '.($category->adsnum > 1 ? 'ads' : 'ad') }}</div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- OUR CATEGORIES END-->
<!--RECENT ads START-->
<div class="rec_cap_text">
    <h6 class="wow"><span>RECENT </span>ads</h6>
    <p class="p-center-text wow">Sed porttitor, quam id pellentesque tempor, erat enim placerat nisi, vel sodales ligula
        enim a augue.</p>
</div>

<div class="place_add">
    <div class="place_text wow">It is <span>FREE </span>to place ads in many sections</div>
    <a href="/place_add" class="blue_btn  wow">Place Ad</a>
</div>

<div class="mob_gray-btn">
    <a href="#">Everything</a>
    <a href="#">Wanted ads</a>
</div>
<div class="rec_choose_sect">
     <div class="ch_sec_left">
        <select>
            <option value="value">Choose section</option>
            <option value="value">Choose section</option>
        </select>
    </div>
    <div class="ch_sec_right">
        <svg class="ch_tab_1 active_svg_ic" width="18" height="14" viewBox="0 0 18 14" fill="none"
             xmlns="http://www.w3.org/2000/svg">
            <path d="M0 6.46154H5.29412V0H0V6.46154ZM0 14H5.29412V7.53846H0V14ZM6.35294 14H11.6471V7.53846H6.35294V14ZM12.7059 14H18V7.53846H12.7059V14ZM6.35294 6.46154H11.6471V0H6.35294V6.46154ZM12.7059 0V6.46154H18V0H12.7059Z"
                  fill="white"/>
        </svg>
        <svg class="ch_tab_2" width="17" height="14" viewBox="0 0 17 14" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 9H4V5H0V9ZM0 14H4V10H0V14ZM0 4H4V0H0V4ZM5 9H17V5H5V9ZM5 14H17V10H5V14ZM5 0V4H17V0H5Z"
                  fill="white"/>
        </svg>
    </div>
</div>
<div class="recent_add_mob">
    <div>Recent ads</div>
    <a class="blue_btn" href="#">See All</a>
</div>
<div class="container">
    <div class="ch_sec_right">
        <svg class="ch_tab_1 active_svg_ic" width="18" height="14" viewBox="0 0 18 14" fill="none"
             xmlns="http://www.w3.org/2000/svg">
            <path d="M0 6.46154H5.29412V0H0V6.46154ZM0 14H5.29412V7.53846H0V14ZM6.35294 14H11.6471V7.53846H6.35294V14ZM12.7059 14H18V7.53846H12.7059V14ZM6.35294 6.46154H11.6471V0H6.35294V6.46154ZM12.7059 0V6.46154H18V0H12.7059Z"
                  fill="white"/>
        </svg>
        <svg class="ch_tab_2" width="17" height="14" viewBox="0 0 17 14" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 9H4V5H0V9ZM0 14H4V10H0V14ZM0 4H4V0H0V4ZM5 9H17V5H5V9ZM5 14H17V10H5V14ZM5 0V4H17V0H5Z"
                  fill="white"/>
        </svg>
    </div>
    <div class="recent-ads">
        <div class="recent_container home">
            @foreach($ads as $ad)
                <a href="{{ route('ads.add-details', ['ads' => $ad->id]) }}" class="recent_block wow">
                    <div class="rec_photo"><img src="{{ $ad->adsImage or '/newthemplate/img/logo.svg' }}"
                                                alt="Alternate Text"/></div>
                    <div class="rec_car_info">
                        <div class="rec_name_car">{{$ad->adsName}}</div>
                        <div class="rec_country">{{ $ad->getCityRegionCountry() }}</div>
                        <!--<div class="rect_text_block">
                            <div class="rect_left_text">Certificate of Road</div>
                        </div>-->

                        <div class="details_holder">
                            @if(array_key_exists ( $ad->id , $adsDatasArray ))
                                @foreach($adsDatasArray[$ad->id] as $adsData)
                                    @if($adsData->adsId == $ad->id)

                                        <div class="rect_text_block" {{$ad->id}}>
                                            <div class="rect_left_text">
                                                @if(count(explode(".", trans('formfields.'.$adsData->fieldTitle))) > 1)
                                                    {{ explode(".", trans('formfields.'.$adsData->fieldTitle))[1] }}
                                                @else
                                                    {{ trans('formfields.'.$adsData->fieldTitle) }}
                                                @endif :
                                            </div>
                                            <div class="rect_right_text">

                                                {{$adsData->text}}

                                            </div>
                                        </div>

                                    @endif
                                @endforeach
                            @endif
                        </div>

                        <!--<div class="rect_text_block">
                                <div class="rect_left_text">Brand:</div>
                                <div class="rect_right_text">Ford</div>
                            </div>
                            <div class="rect_text_block">
                                <div class="rect_left_text">Year:</div>
                                <div class="rect_right_text">2018</div>
                            </div>
                            <div class="rect_text_block">
                                <div class="rect_left_text">Miege:</div>
                                <div class="rect_right_text">200 km</div>
                            </div>-->
                    </div>
                    <div class="rect_price">
                        <div class="rect_price_left">
                            <div class="rect_favorite"></div>
                            <div class="favorite_text">Favorite</div>
                        </div>
                        <div class="rect_price_right">{{ $ad->adsPriceWithType() }}</div>
                    </div>
                </a>
        @endforeach
        <!--<a href="/add-details" class="recent_block wow">
                    <div class="rec_photo"><img src="/newthemplate/img/rect_car_2.jpg" alt="Alternate Text" /></div>
                    <div class="rec_car_info">
                        <div class="rec_name_car">Offroad Bike</div>
                        <div class="rec_country">New York, USA</div>
                        <div class="rect_text_block">
                            <div class="rect_left_text">Certificate of Road</div>
                        </div>
                        <div class="rect_text_block">
                            <div class="rect_left_text">Warthiness:</div>
                            <div class="rect_right_text">No</div>
                        </div>
                        <div class="rect_text_block">
                            <div class="rect_left_text">Brand:</div>
                            <div class="rect_right_text">Ford</div>
                        </div>
                        <div class="rect_text_block">
                            <div class="rect_left_text">Year:</div>
                            <div class="rect_right_text">2018</div>
                        </div>
                        <div class="rect_text_block">
                            <div class="rect_left_text">Miege:</div>
                            <div class="rect_right_text">200 km</div>
                        </div>
                    </div>
                    <div class="rect_price">
                        <div class="rect_price_left">
                            <div class="rect_favorite"></div>
                            <div class="favorite_text">Favorite</div>
                        </div>
                        <div class="rect_price_right">$7 220</div>
                    </div>
                </a>
                <a href="/add-details" class="recent_block wow">
                    <div class="rec_photo"><img src="/newthemplate/img/rect_car_3.jpg" alt="Alternate Text" /></div>
                    <div class="rec_car_info">
                        <div class="rec_name_car">Monster Quad</div>
                        <div class="rec_country">Kyiv, Ukraine</div>
                        <div class="rect_text_block">
                            <div class="rect_left_text">Certificate of Road</div>
                        </div>
                        <div class="rect_text_block">
                            <div class="rect_left_text">Warthiness:</div>
                            <div class="rect_right_text">No</div>
                        </div>
                        <div class="rect_text_block">
                            <div class="rect_left_text">Brand:</div>
                            <div class="rect_right_text">Ford</div>
                        </div>
                        <div class="rect_text_block">
                            <div class="rect_left_text">Year:</div>
                            <div class="rect_right_text">2018</div>
                        </div>
                        <div class="rect_text_block">
                            <div class="rect_left_text">Miege:</div>
                            <div class="rect_right_text">200 km</div>
                        </div>
                    </div>
                    <div class="rect_price">
                        <div class="rect_price_left favorite_active">
                            <div class="rect_favorite"></div>
                            <div class="favorite_text">Favorite</div>
                        </div>
                        <div class="rect_price_right">$10 000</div>
                    </div>
                </a>
                <a href="/add-details" class="recent_block wow">
                    <div class="rec_photo"><img src="/newthemplate/img/rect_car_4.jpg" alt="Alternate Text" /></div>
                    <div class="rec_car_info">
                        <div class="rec_name_car">Harley Davidson bike</div>
                        <div class="rec_country">Toronto, Canada</div>
                        <div class="rect_text_block">
                            <div class="rect_left_text">Certificate of Road</div>
                        </div>
                        <div class="rect_text_block">
                            <div class="rect_left_text">Warthiness:</div>
                            <div class="rect_right_text">No</div>
                        </div>
                        <div class="rect_text_block">
                            <div class="rect_left_text">Brand:</div>
                            <div class="rect_right_text">Ford</div>
                        </div>
                        <div class="rect_text_block">
                            <div class="rect_left_text">Year:</div>
                            <div class="rect_right_text">2018</div>
                        </div>
                        <div class="rect_text_block">
                            <div class="rect_left_text">Miege:</div>
                            <div class="rect_right_text">200 km</div>
                        </div>
                    </div>
                    <div class="rect_price">
                        <div class="rect_price_left ">
                            <div class="rect_favorite"></div>
                            <div class="favorite_text">Favorite</div>
                        </div>
                        <div class="rect_price_right">$78 999</div>
                    </div>
                </a>
                <a href="/add-details" class="recent_block wow">
                    <div class="rec_photo"><img src="/newthemplate/img/rect_car_5.jpg" alt="Alternate Text" /></div>
                    <div class="rec_car_info">
                        <div class="rec_name_car">Mercedes-Benz AMG Bike</div>
                        <div class="rec_country">County Carlow, Ireland</div>
                        <div class="rect_text_block">
                            <div class="rect_left_text">Certificate of Road</div>
                        </div>
                        <div class="rect_text_block">
                            <div class="rect_left_text">Warthiness:</div>
                            <div class="rect_right_text">No</div>
                        </div>
                        <div class="rect_text_block">
                            <div class="rect_left_text">Brand:</div>
                            <div class="rect_right_text">Ford</div>
                        </div>
                        <div class="rect_text_block">
                            <div class="rect_left_text">Year:</div>
                            <div class="rect_right_text">2018</div>
                        </div>
                        <div class="rect_text_block">
                            <div class="rect_left_text">Miege:</div>
                            <div class="rect_right_text">200 km</div>
                        </div>
                    </div>
                    <div class="rect_price">
                        <div class="rect_price_left favorite_active">
                            <div class="rect_favorite"></div>
                            <div class="favorite_text">Favorite</div>
                        </div>
                        <div class="rect_price_right">$42 000</div>
                    </div>
                </a>
                <a href="/add-details" class="recent_block wow">
                    <div class="rec_photo"><img src="/newthemplate/img/rect_car_6.jpg" alt="Alternate Text" /></div>
                    <div class="rec_car_info">
                        <div class="rec_name_car">Bugatti Bike</div>
                        <div class="rec_country">New York, USA</div>
                        <div class="rect_text_block">
                            <div class="rect_left_text">Certificate of Road</div>
                        </div>
                        <div class="rect_text_block">
                            <div class="rect_left_text">Warthiness:</div>
                            <div class="rect_right_text">No</div>
                        </div>
                        <div class="rect_text_block">
                            <div class="rect_left_text">Brand:</div>
                            <div class="rect_right_text">Ford</div>
                        </div>
                        <div class="rect_text_block">
                            <div class="rect_left_text">Year:</div>
                            <div class="rect_right_text">2018</div>
                        </div>
                        <div class="rect_text_block">
                            <div class="rect_left_text">Miege:</div>
                            <div class="rect_right_text">200 km</div>
                        </div>
                    </div>
                    <div class="rect_price">
                        <div class="rect_price_left">
                            <div class="rect_favorite"></div>
                            <div class="favorite_text">Favorite</div>
                        </div>
                        <div class="rect_price_right">$1 999 999</div>
                    </div>
                </a>
                <a href="/add-details" class="recent_block wow">
                    <div class="rec_photo"><img src="/newthemplate/img/rect_car_7.jpg" alt="Alternate Text" /></div>
                    <div class="rec_car_info">
                        <div class="rec_name_car">Mercedes 23-1252</div>
                        <div class="rec_country">Kyiv, Ukraine</div>
                        <div class="rect_text_block">
                            <div class="rect_left_text">Certificate of Road</div>
                        </div>
                        <div class="rect_text_block">
                            <div class="rect_left_text">Warthiness:</div>
                            <div class="rect_right_text">No</div>
                        </div>
                        <div class="rect_text_block">
                            <div class="rect_left_text">Brand:</div>
                            <div class="rect_right_text">Ford</div>
                        </div>
                        <div class="rect_text_block">
                            <div class="rect_left_text">Year:</div>
                            <div class="rect_right_text">2018</div>
                        </div>
                        <div class="rect_text_block">
                            <div class="rect_left_text">Miege:</div>
                            <div class="rect_right_text">200 km</div>
                        </div>
                    </div>
                    <div class="rect_price">
                        <div class="rect_price_left">
                            <div class="rect_favorite"></div>
                            <div class="favorite_text">Favorite</div>
                        </div>
                        <div class="rect_price_right">$59 889</div>
                    </div>
                </a>
                <a href="/add-details" class="recent_block wow">
                    <div class="rec_photo"><img src="/newthemplate/img/rect_car_8.jpg" alt="Alternate Text" /></div>
                    <div class="rec_car_info">
                        <div class="rec_name_car">BMW travell motorcycle</div>
                        <div class="rec_country">Toronto, Canada</div>
                        <div class="rect_text_block">
                            <div class="rect_left_text">Certificate of Road</div>
                        </div>
                        <div class="rect_text_block">
                            <div class="rect_left_text">Warthiness:</div>
                            <div class="rect_right_text">No</div>
                        </div>
                        <div class="rect_text_block">
                            <div class="rect_left_text">Brand:</div>
                            <div class="rect_right_text">Ford</div>
                        </div>
                        <div class="rect_text_block">
                            <div class="rect_left_text">Year:</div>
                            <div class="rect_right_text">2018</div>
                        </div>
                        <div class="rect_text_block">
                            <div class="rect_left_text">Miege:</div>
                            <div class="rect_right_text">200 km</div>
                        </div>
                    </div>
                    <div class="rect_price">
                        <div class="rect_price_left">
                            <div class="rect_favorite"></div>
                            <div class="favorite_text">Favorite</div>
                        </div>
                        <div class="rect_price_right">$23 999</div>
                    </div>
                </a>-->
        </div>
        <a class="link_see_all" href="/add-listing">See all recent ads
            <!-- <img src="img/white_arr_right.svg" alt="Alternate Text" /> -->
        </a>
    </div>
    <!-- <div class="recent-pagin-mob index-magin">
        <a class="rec_next_prev" href="#">Prev</a>
        <a class="active_pagin" href="#">1</a>
        <a href="#">2</a>
        <a href="#">3</a>
        <a class="rec_next_prev" href="#">Next</a>
    </div> -->
</div>
<!--RECENT ads END-->

@include( 'newthemplate.footer' )