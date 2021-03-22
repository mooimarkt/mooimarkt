@include("newthemplate.header")
<div class="baner-not-bg">
    <div id="closepreview" style="cursor: pointer; position: fixed; text-align: center; width: 100%; padding: 10px; color: white; background: #2a84ff;" onclick="window.close()">
        Close Preview
    </div>
    <section id="baner-header" class="baner-header">
        <div class="content">
            <ul class="tabs">
                <li class="tab-link current" data-tab="tab-1">Everything</li>
                <li class="tab-link" data-tab="tab-2">Try the amazing Filter!</li>

            </ul>
            <div class="tab-content current" id="tab-1">
                <ul class="header_crumbs">
                    <li><a href="{{ route('home') }}">Home ></a></li>
                    <!-- <li><a href="#">Categories ></a></li> -->
                    @if (isset($Request['category']) && is_array($Request['category']))
                    <li><a href="{{ route('ads.add-listing', ['categoryId' => $Request['category']['id']]) }}">{{ $Request['category']['name'] }}</a> ></li>
                    @endif
                    @if (isset($Request['subcategory']) && is_array($Request['subcategory']))
                    <li><a href="{{ route('ads.add-listing', ['subCategoryId' => $Request['subcategory']['id']]) }}">{{ $Request['subcategory']['name'] }}</a> ></li>
                    @endif
                    <li><a>{{ isset($Request['title']) ? $Request['title'] : "untitled" }}</a></li>
                </ul>
                <form action="{{ route('ads.add-listing') }}">
                    <input type="text" name="search" placeholder="Search 256 Ads" />
                    <button class="bt">Search</button>
                </form>
            </div>
            <div class="tab-content" id="tab-2">
                <form action="{{ route('ads.add-listing') }}">
                    <input type="text" name="search" placeholder="Search 256 Ads" />
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
                            @if(isset($Request['images']))
                                @forelse (explode(",",$Request['images']) as $path)
                                    <div class="swiper-slide"><img src="{{ $path }}" alt="{{ $path }}" /></div>
                                @empty
                                    <div class="swiper-slide"><img src="/newthemplate/img/logo.svg" alt="No ads images :(" /></div>
                                @endforelse
                            @endif
                        </div>
                        <!-- Pagination -->
                        <div class="swiper-pagination"></div>
                        <!-- Arrows -->
                        <div class="arr_det arr_det_left"><img src="/newthemplate/img/arr_det.svg" alt="Alternate Text" /></div>
                        <div class="arr_det arr_det_right"><img src="/newthemplate/img/arr_det.svg" alt="Alternate Text" /></div>
                    </div>
                </div>
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
                    <div class="rec_name_car">{{ isset($Request['title']) ? $Request['title'] : "no-name"  }}</div>
                    <div class="rec_country">
                        {{ \Carbon\Carbon::createFromTimeStamp(time())->diffForHumans() }},
                        1019 views
                        {{ isset($Request['location']) ? $Request['location'] : "no-location" }}
                    </div>
                    <div class="rect_price">
                        <div class="rect_price_left">
                            <div class="rect_favorite"></div>
                            <div class="favorite_text">Favorite</div>
                            <div class="rect_share"></div>
                            <div class="favorite_text">Share</div>
                        </div>
                        <div class="rect_price_right">${{ isset($Request['price']) ? $Request['price'] : "no-price" }}</div>
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
                        <p>{{ isset($Request['description']) ? $Request['description'] : "no-description" }}</p>
                        <a href="#" class="gray-btn">Report this ad</a>
                    </div>
                    <div class="profile_block">
                        <div class="profile-row">
                            <div class="left-block">
                                <div class="prof_img"><img src="/newthemplate/img/prof_photo.png" alt="Alternate Text" /></div>
                                <div class="caption-text">{{ Auth::user()->name }}</div>
                            </div>
                            <a href="{{ route('profile.show', ['profile' => Auth::user()->id ]) }}" class="view_profile">View Profile</a>
                        </div>
                        <div class="profile-row buttons">
                            @if(Auth::check())
                            {{ csrf_field() }}
                            <a href="#" class="blue_btn" id="SendMessage" data-id="0">Send Message</a>
                            @else
                            <a href="#" class="blue_btn open_modal">Send Message</a>
                            @endif
                            <a href="#" class="blue_btn" id="ShowNumberPhone">Show Phone number</a>
                        </div>
                        <div id="NumberPhone" style="text-align: center; font-size: 20px; padding-top: 10px; display: none;">
                            {{ Auth::user()->phone }} (not virified)
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
                            B4MX is not responsible for the advertised goods.<br> It is illegal to use the contact information for commercial purpose.
                        </p>
                    </div>
                </div>
            </div>
            <!--DETAILS CAR INFO  END-->
        </div>
    </div>
</section>
@include("newthemplate.footer")