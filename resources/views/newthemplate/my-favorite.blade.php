@include("newthemplate.header")
<section class="products-list favorite-ads">
    <div class="container">
        <h2>favorite ads</h2>
        <div class="recent-ads">
            <div class="recent_container">
                @foreach (Auth::user()->favoriteAds as $ad)
                <a href="{{ route('ads.add-details', ['ads' => $ad->id]) }}" class="recent_block">
                    <div class="rec_photo"><img src="{{ $ad->adsImage or '' }}" alt="{{ $ad->adsImage }}" /></div>
                    <div class="rec_car_info">
                        <div class="rec_name_car">{{ $ad->adsName }}</div>
                        <div class="rec_country">{{-- {{ $ad->getCityRegionCountry() }} --}}</div>
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
                        <div class="rect_price_left {{ $ad->is_favorite() ? ' favorite_active' : '' }}">
                            <div class="rect_favorite {{ $ad->is_favorite() ? ' remove' : ' add' }}" data-favorite="ads" data-id="{{$ad->id}}"></div>
                            <div class="favorite_text">Favorite</div>
                        </div>
                        <div class="rect_price_right">{{-- {{ $ad->adsPriceWithType() }} --}}</div>
                    </div>
                </a>
                @endforeach
                {{-- <a href="#" class="recent_block">
                    <div class="rec_photo"><img src="/newthemplate/img/rect_car_2.jpg" alt="Alternate Text" /></div>
                    <div class="rec_car_info">
                        <div class="rec_name_car">Offroad Bike</div>
                        <div class="rec_country">New York, USA</div>
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
                        <div class="rect_price_right">$7 220</div>
                    </div>
                </a>
                <a href="#" class="recent_block">
                    <div class="rec_photo"><img src="/newthemplate/img/rect_car_3.jpg" alt="Alternate Text" /></div>
                    <div class="rec_car_info">
                        <div class="rec_name_car">Monster Quad</div>
                        <div class="rec_country">Kyiv, Ukraine</div>
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
                        <div class="rect_price_left favorite_active">
                            <div class="rect_favorite"></div>
                            <div class="favorite_text">Favorite</div>
                        </div>
                        <div class="rect_price_right">$10 000</div>
                    </div>
                </a>
                <a href="#" class="recent_block">
                    <div class="rec_photo"><img src="/newthemplate/img/rect_car_4.jpg" alt="Alternate Text" /></div>
                    <div class="rec_car_info">
                        <div class="rec_name_car">Harley Davidson bike</div>
                        <div class="rec_country">Toronto, Canada</div>
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
                        <div class="rect_price_left ">
                            <div class="rect_favorite"></div>
                            <div class="favorite_text">Favorite</div>
                        </div>
                        <div class="rect_price_right">$78 999</div>
                    </div>
                </a>
                <a href="#" class="recent_block">
                    <div class="rec_photo"><img src="/newthemplate/img/rect_car_5.jpg" alt="Alternate Text" /></div>
                    <div class="rec_car_info">
                        <div class="rec_name_car">Mercedes-Benz AMG Bike</div>
                        <div class="rec_country">County Carlow, Ireland</div>
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
                        <div class="rect_price_left favorite_active">
                            <div class="rect_favorite"></div>
                            <div class="favorite_text">Favorite</div>
                        </div>
                        <div class="rect_price_right">$42 000</div>
                    </div>
                </a>
                <a href="#" class="recent_block">
                    <div class="rec_photo"><img src="/newthemplate/img/rect_car_6.jpg" alt="Alternate Text" /></div>
                    <div class="rec_car_info">
                        <div class="rec_name_car">Bugatti Bike</div>
                        <div class="rec_country">New York, USA</div>
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
                        <div class="rect_price_right">$1 999 999</div>
                    </div>
                </a> --}}
            </div>
        </div>
    </div>
    <!--RECENT ADS END-->
</section>
@include("newthemplate.footer")