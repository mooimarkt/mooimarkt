@include("newthemplate.header")
<div class="baner-not-bg">
    <section id="baner-header" class="baner-header">
        <div class="content">
            <ul class="tabs">
                <li class="tab-link current" data-tab="tab-1">Everything</li>
                <li class="tab-link" data-tab="tab-2">Try the amazing Filter!</li>

            </ul>
            <div class="tab-content current" id="tab-1">
                <ul class="header_crumbs">
                    @if (!empty($Ad->breadcrumb->where('type', 1)->first()))
                        <li><a href="{{ route('home') }}">{{ $Ad->breadcrumb->where('type', 1)->first()->content }}
                                ></a></li>
                    @else
                        <li><a href="{{ route('home') }}">Home ></a></li>
                    @endif

                <!-- <li><a href="#">Categories ></a></li> -->

                    @if (!empty($Ad->breadcrumb->where('type', 2)->first()))
                        <li>
                            <a href="{{ route('ads.add-listing', ['categoryId' => $Ad->subcategory->category->id]) }}">{{ $Ad->breadcrumb->where('type', 2)->first()->content }}</a>
                            >
                        </li>
                    @else
                        @if (!empty($Ad->subcategory->category))
                            <li>
                                <a href="{{ route('ads.add-listing', ['categoryId' => $Ad->subcategory->category->id]) }}">{{ $Ad->subcategory->category->categoryName }}</a>
                                >
                            </li>
                        @endif
                    @endif

                    @if (!empty($Ad->breadcrumb->where('type', 3)->first()))
                        <li>
                            <a href="{{ route('ads.add-listing', ['subCategoryId' => $Ad->subcategory->id]) }}">{{ $Ad->breadcrumb->where('type', 3)->first()->content }}</a>
                            >
                        </li>
                    @else
                        @if (!empty($Ad->subcategory))
                            <li>
                                <a href="{{ route('ads.add-listing', ['subCategoryId' => $Ad->subcategory->id]) }}">{{ $Ad->subcategory->subCategoryName }}</a>
                                >
                            </li>
                        @endif
                    @endif

                    @if (!empty($Ad->breadcrumb->where('type', 4)->first()))
                        <li><a>{{ $Ad->breadcrumb->where('type', 4)->first()->content }}</a></li>
                    @else
                        <li><a>{{ $Ad->adsName }}</a></li>
                    @endif

                </ul>
                <form action="{{ route('ads.add-listing') }}">
                    <input type="text" name="search" placeholder="Search 256 Ads"/>
                    <button class="bt">Search</button>
                </form>
            </div>
            <div class="tab-content" id="tab-2">
                <form action="{{ route('ads.add-listing') }}">
                    <input type="text" name="search" placeholder="Search 256 Ads"/>
                    <button class="bt">Search</button>
                </form>
            </div>
        </div>
    </section>
</div>

<section class="detail-product">
    <div class="container">
        <div class="detail-product-wrapper">
            <div class="left-coll">
                <!--DETAILS SLIDER START-->
                <div class="details_slider">
                    <div class="swiper-container sw-con-det">
                        <div class="swiper-wrapper">
                            @forelse ($images as $image)
                                <div class="swiper-slide"><img src="{{ $image->imagePath }}"
                                                               alt="{{ $image->imagePath }}"/></div>
                            @empty
                                <div class="swiper-slide"><img src="/newthemplate/img/logo.svg" alt="No ads images :("/>
                                </div>
                            @endforelse
                        </div>
                        <!-- Pagination -->
                        <div class="swiper-pagination"></div>
                        <!-- Arrows -->
                        <div class="arr_det arr_det_left"><img src="/newthemplate/img/arr_det.svg"
                                                               alt="Alternate Text"/></div>
                        <div class="arr_det arr_det_right"><img src="/newthemplate/img/arr_det.svg"
                                                                alt="Alternate Text"/></div>
                    </div>
                </div>

                @if(!is_null($Ad->details) && count($Ad->details) > 0)

                    <div class="recent-ads">
                        <div class="recent_container home add-details">

                            @foreach($Ad->details as $detail)

                                <a href="https://moto.cgp.systems/add-details/{{$detail->id}}"
                                   class="recent_block wow animated" style="visibility: visible;">
                                    <div class="rec_photo"><img
                                                src="{{is_null($detail->adsImage) ? "/newthemplate/img/logo.svg" : $detail->adsImage}}"
                                                alt="Alternate Text"></div>
                                    <div class="rec_car_info">
                                        <div class="rec_name_car">{{$detail->adsName}}</div>
                                        <div class="rec_country">{{ $detail->getCityRegionCountry() }}</div>
                                        <!--<div class="rect_text_block">
                                            <div class="rect_left_text">Certificate of Road</div>
                                        </div>-->

                                        <div class="details_holder">
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
                                        <div class="rect_price_right">{{ $detail->adsPriceWithType() }}</div>
                                    </div>
                                </a>

                            @endforeach

                        </div>
                    </div>

                @endif

                @if(!is_null($Ad->parent) && count($Ad->parent) > 0)
                    <div class="recent-ads">
                        <div class="recent_container home add-details">
                            <a href="/add-details/{{$Ad->parent->id}}" class="bt_blu back_arrow">Go to set</a>
                        </div>
                    </div>

                @endif

            <!--DETAILS SLIDER  END-->
                <!--
                <div class="preview-text">
                   <p>B4MX is not responsible for the advertised goods.<br> It is illegal to use the contact information for commercial purpose.</p>
               </div>
               -->
            </div>

            <!--DETAILS CAR INFO  END-->

            <div class="add_det_car">
                <div class="rec_car_info">
                    <div class="rec_name_car">{{ $Ad->adsName }} {!! !is_null($Ad->details) && count($Ad->details) > 0 ? "( Ad Set )" : (!is_null($Ad->parent) && count($Ad->parent) > 0 ? "<a href=\"/add-details/".$Ad->parent->id."\">( Part of the Ad Set )</a>" : "") !!}</div>
                    <div class="rec_country">
                        {{ \Carbon\Carbon::createFromTimeStamp(strtotime($Ad->created_at))->diffForHumans() }},
                        {{ $Ad->adsViews }} {{ ($Ad->adsViews > 1) ? 'views' : 'view' }},
                        {{ $Ad->getCityRegionCountry() }}
                    </div>
                    <div class="rect_price">
                        <div class="rect_price_left {{ $Ad->is_favorite() ? ' favorite_active' : '' }}">
                            <div class="rect_favorite {{ $Ad->is_favorite() ? ' remove' : ' add' }}" data-favorite="ads"
                                 data-id="{{$Ad->id}}"></div>
                            <div class="favorite_text favorite_loader">Favorite</div>
                            <div class="rect_share" onclick="this.classList.toggle('show')">
                                <ul class="social-icon">
                                    <li>
                                        <a href="https://www.facebook.com/sharer/sharer.php?u={{urlencode(Illuminate\Support\Facades\URL::current())}}"
                                           onclick="window.open(this.href,'facebook','width=500,height=700');return false;"
                                           class="facebook">
                                            <img src="/newthemplate/img/facebook.svg">
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://twitter.com/home?status={{urlencode(Illuminate\Support\Facades\URL::current())}}"
                                           onclick="window.open(this.href,'twitter','width=500,height=700');return false;"
                                           target="_blank" class="twitter">
                                            <img src="/newthemplate/img/twitter.svg">
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://pinterest.com/pin/create/button/?url={{urlencode(Illuminate\Support\Facades\URL::current())}}&media={{ count($images) > 0 ? "https://moto.cgp.systems/".$images[0]->imagePath : "https://moto.cgp.systems/newthemplate/img/logo.svg" }}&description={{ $Ad->adsDescription }}"
                                           onclick="window.open(this.href,'pinterest','width=500,height=700');return false;"
                                           target="_blank" class="pinterest">
                                            <img src="/newthemplate/img/pinterest.svg">
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="favorite_text">Share</div>
                        </div>
                        {{-- <div class="rect_price_right">{{ $Ad->adsPriceWithType() }}</div> --}}
                        <div class="rect_price_right">{{ $Ad->adsPriceType.' '.$Ad->adsPrice }}</div>
                    </div>
                    <div class="key-info">
                        <div class="caption-text">key info</div>
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
                    <div class="det-descr">
                        <div class="caption-text">Description</div>
                        <p>{{ $Ad->adsDescription }}</p>
                        @if($Ad->adsStatus != 'payed' && \Illuminate\Support\Facades\Auth::id() == $Ad->userId)
                            <form action="/place_add">
                                <input type="hidden" name="ad" value="{{$Ad}}">
                                <button type="submit" class="blue_btn" id="publish_ad">Publish this ad</button>
                            </form>
                        @endif
                        <a href="#" class="gray-btn"
                           data-ads_id="{{ $Ad->id }}"
                           onclick="{{ Auth::check() ? "createReport({adsId:".($Ad->id).",name:'".(Auth::user()->name)."', email:'".(Auth::user()->email)."'})" : "createReport({adsId:".($Ad->id)."});" }}"
                                {{-- onclick="createReport()" --}}>Report this ad</a>
                    </div>
                    <div class="profile_block">
                        <div class="profile-row">
                            <div class="left-block">
                                <div class="prof_img"><img src="{{ isset($Ad->UserAds->avatar) ? $Ad->UserAds->avatar : '/storage/avatar/icon-p.svg' }}" alt="Avatar"/>
                                </div>
                                <div class="caption-text">{{ $Ad->UserAds->name or 'DELETED' }}</div>
                            </div>
                            <a href="{{ route('profile.show', ['profile' => $Ad->userId ]) }}" class="view_profile">View
                                Profile</a>
                        </div>
                        <div class="profile-row buttons">
                            @if(Auth::check())
                                {{ csrf_field() }}
                                <a href="#" class="blue_btn" id="SendMessage" data-id="{{$Ad->id}}">Send Message</a>
                            @else
                                <a href="#" class="blue_btn open_modal">Send Message</a>
                            @endif
                            <a href="#" class="blue_btn" id="ShowNumberPhone">Show Phone number</a>
                        </div>
                        <div id="NumberPhone"
                             style="text-align: center; font-size: 20px; padding-top: 10px; display: none;">
                            {{ $Ad->UserAds->phone or 'none' }} (not virified)
                        </div>
                        <div class="profile-information">
                            <div class="rect_text_block">
                                <div class="rect_left_text">Location:</div>
                                <div class="rect_right_text">New York, USA</div>
                            </div>
                            <div class="rect_text_block">
                                <div class="rect_left_text">B4MX since:</div>
                                <div class="rect_right_text">2012</div>
                            </div>
                            <div class="rect_text_block">
                                <div class="rect_left_text">Listed ads:</div>
                                <div class="rect_right_text">123</div>
                            </div>
                        </div>
                    </div>
                    <div class="det-descr legal">
                        <div class="caption-text">Legal</div>
                        <p>
                            B4MX is not responsible for the advertised goods.<br> It is illegal to use the contact
                            information for commercial purpose.
                        </p>
                    </div>
                </div>
            </div>
            <!--DETAILS CAR INFO  END-->
        </div>
    </div>
</section>
@include("newthemplate.footer")