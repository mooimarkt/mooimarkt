@include("newthemplate.header")
<div class="baner-not-bg container profile_header p10">
    <ul class="header_crumbs">
        <li><a href="#">Home ></a></li>
        <li><a href="#">Profile</a></li>
    </ul>
</div>


<!--PROFILE START-->
<div class="container p10">
    <div class="row">
        <div class="profile">
            <div class="profile_person">
                <div class="prf_person_photo">
                    <img src="{{ isset($profile->avatar) ? $profile->avatar : '/storage/avatar/icon-p.svg' }}" alt="Alternate Text" width="170" height="170" />
                </div>
                <div class="pr_person_inf">
                    <div class="name_and_status">
                        <div class="person_name">{{ $profile->name }}</div>
                        <div class="person_status">
                        {{($profile->last_login != null) ? 
                            ((strtotime("now") - strtotime($profile->last_login)) < 300
                                ? 'Online'
                                : 'Offline')
                            : 'Offline'
                        }}</div>
                    </div>
                    <div class="v-person-info-row">
                        <div class="v-person-info">User ID: <span>{{ $profile->id }}</span></div>
                        <div class="v-person-info">Level: <span class="c-green">{{ $profile->level }}</span></div>
                    </div>
                    <div class="pr_data">since {{ \Carbon\Carbon::createFromTimeStamp(strtotime($profile->created_at))->formatLocalized('%B %d, %Y') }}</div>

                    <div class="pr_country">
                        @if (!empty($profile->country))
                        <img src="/img/flags/{{ $profile->getCountryCode() }}.png" alt="Flag" />
                        <span>{{ $profile->getCityRegionCountry() }}</span>
                        @endif
                    </div>
                    <div class="pr_rating">
                        <div class="rating_block">
                            <img src="/newthemplate/img/pr_like.svg" alt="Alternate Text" />
                            <span>12K</span>
                        </div>
                        <div class="rating_block">
                            <img class="dilike_img" src="/newthemplate/img/pr_dislike.svg" alt="Alternate Text" />
                            <span>148</span>
                        </div>
                    </div>
                </div>
                @if(\Illuminate\Support\Facades\Auth::id() != $profile->id)
                <div class="pr_btn">
                    <a href="#" class="blue_btn">Send private Message</a>
                    <a href="#" class="gray-btn">Save this seller</a>
                </div>
                @endif
            </div>
            <div class="profile_right">
                <div class="item_on_sale">{{ $profile->Ads->where('adsType', 'sale')->count() }} items on sale</div>
                <div class="item_sale_container">
                    @foreach ($profile->Ads->where('parent_id', null)->sortByDesc('created_at')->take(6) as $ad)
                    <div class="item_sale_block">
                        <div class="it_left_img">
                            <img src="{{ $ad->adsImage or '/newthemplate/img/logo.svg' }}" alt="{{ $ad->adsName }}" />
                        </div>
                        <div class="it_right_text">
                            <div class="it_name_car"><a href="{{ route('ads.add-details', ['ads' => $ad->id]) }}">{{ $ad->adsName }}</a></div>
                            <div class="all_mount">
                                {{ !empty($ad->subCategory->category->categoryName) ? $ad->subCategory->subCategoryName."/" : "" }}
                                {{ !empty($ad->subCategory->subCategoryName) ? $ad->subCategory->subCategoryName : "" }}</div>
                            <div class="GBP">
                                <div class="gbp_text">{{ $ad->adsPriceWithType() }}</div>
                                <div class="gbp_img">
                                    <img src="/newthemplate/img/GBP_1.svg" alt="Alternate Text" />
                                    <img src="/newthemplate/img/GBP_2.svg" alt="Alternate Text" />
                                    <img src="/newthemplate/img/GBP_3.svg" alt="Alternate Text" />
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    {{-- <div class="item_sale_block">
                        <div class="it_left_img">
                            <img src="/newthemplate/img/rect_car_1.jpg" alt="Alternate Text" />
                        </div>
                        <div class="it_right_text">
                            <div class="it_name_car">Good Van</div>
                            <div class="all_mount">All Mountain/Enduro Bikes</div>
                            <div class="GBP">
                                <div class="gbp_text">2300 GBP</div>
                                <div class="gbp_img">
                                    <img src="/newthemplate/img/GBP_1.svg" alt="Alternate Text" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item_sale_block">
                        <div class="it_left_img">
                            <img src="/newthemplate/img/rect_car_2.jpg" alt="Alternate Text" />
                        </div>
                        <div class="it_right_text">
                            <div class="it_name_car">Mountain Bike</div>
                            <div class="all_mount">All Mountain/Enduro Bikes</div>
                            <div class="GBP">
                                <div class="gbp_text">2300 GBP</div>
                                <div class="gbp_img">
                                    <img src="/newthemplate/img/GBP_2.svg" alt="Alternate Text" />
                                    <img src="/newthemplate/img/GBP_1.svg" alt="Alternate Text" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item_sale_block">
                        <div class="it_left_img">
                            <img src="/newthemplate/img/rect_car_3.jpg" alt="Alternate Text" />
                        </div>
                        <div class="it_right_text">
                            <div class="it_name_car">Good Van</div>
                            <div class="all_mount">All Mountain/Enduro Bikes</div>
                            <div class="GBP">
                                <div class="gbp_text">2300 GBP</div>
                                <div class="gbp_img">
                                    <img src="/newthemplate/img/GBP_2.svg" alt="Alternate Text" />
                                    <img src="/newthemplate/img/GBP_3.svg" alt="Alternate Text" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item_sale_block">
                        <div class="it_left_img">
                            <img src="/newthemplate/img/rect_car_4.jpg" alt="Alternate Text" />
                        </div>
                        <div class="it_right_text">
                            <div class="it_name_car">Mountain Bike</div>
                            <div class="all_mount">All Mountain/Enduro Bikes</div>
                            <div class="GBP">
                                <div class="gbp_text">2300 GBP</div>
                                <div class="gbp_img">
                                    <img src="/newthemplate/img/GBP_1.svg" alt="Alternate Text" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item_sale_block">
                        <div class="it_left_img">
                            <img src="/newthemplate/img/rect_car_5.jpg" alt="Alternate Text" />
                        </div>
                        <div class="it_right_text">
                            <div class="it_name_car">Good Van</div>
                            <div class="all_mount">All Mountain/Enduro Bikes</div>
                            <div class="GBP">
                                <div class="gbp_text">2300 GBP</div>
                                <div class="gbp_img">
                                    <img src="/newthemplate/img/GBP_2.svg" alt="Alternate Text" />
                                    <img src="/newthemplate/img/GBP_1.svg" alt="Alternate Text" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item_sale_block">
                        <div class="it_left_img">
                            <img src="/newthemplate/img/rect_car_1.jpg" alt="Alternate Text" />
                        </div>
                        <div class="it_right_text">
                            <div class="it_name_car">Good Van</div>
                            <div class="all_mount">All Mountain/Enduro Bikes</div>
                            <div class="GBP">
                                <div class="gbp_text">2300 GBP</div>
                                <div class="gbp_img">
                                    <img src="/newthemplate/img/GBP_2.svg" alt="Alternate Text" />
                                    <img src="/newthemplate/img/GBP_3.svg" alt="Alternate Text" />
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>

                <section id="Activity_timeline">
                    <div class="actvity_text">
                        <div class="activity_left">Activity timeline</div>
                        <a name="timeline"></a>
                        <div class="activity_right">
                            <span>1 sold</span>
                            <span>3 bought</span>
                        </div>
                    </div>
                    <div class="timeline-container">
                        <div class="timeline-item">
                            {{-- <ul class="item">
                                <li>
                                    <div class="timeline-item-title">
                                        <span>15 May 2018</span>
                                        <div class="gold_star">
                                            <img src="/newthemplate/img/star_gold.svg" alt="Alternate Text" />
                                            <img src="/newthemplate/img/star_gold.svg" alt="Alternate Text" />
                                            <img src="/newthemplate/img/star_gold.svg" alt="Alternate Text" />
                                        </div>
                                    </div>
                                    <p class="timeline-item-content">You leave a comment to seller:</p>
                                    <p class="timeline-item-comments">Bad seller. Very Bad.</p>
                                </li>
                            </ul>
                            <ul>
                                <li>
                                    <div class="timeline-item-title">
                                        <span>11 May 2018</span>
                                        <div class="gold_star">
                                            <img src="/newthemplate/img/star_gold.svg" alt="Alternate Text" />
                                            <img src="/newthemplate/img/star_gold.svg" alt="Alternate Text" />
                                        </div>
                                    </div>
                                    <p class="timeline-item-content">You leave a comment to seller:</p>
                                    <p class="timeline-item-comments">Bad seller. Very Bad.</p>
                                </li>
                            </ul>
                            <ul>
                                <li>
                                    <div class="timeline-item-title">
                                        <span>8 May 2018</span>
                                        <div class="gold_star">
                                            <img src="/newthemplate/img/star_gold.svg" alt="Alternate Text" />
                                        </div>
                                    </div>
                                    <p class="timeline-item-content">You leave a comment to seller:</p>
                                    <p class="timeline-item-comments">Bad seller. Very Bad.</p>
                                </li>
                            </ul> --}}
                            @forelse ($activities as $activity)
                            <ul>
                                <li>
                                    <div class="timeline-item-title">
                                        {{ \Carbon\Carbon::createFromTimeStamp(strtotime($activity->meeting))->formatLocalized('%d %B %Y') }}
                                        @if (($activity->meeting) > date("Y-m-d H:i:s"))
                                        <div class="gold_star time-met">
                                            {{ ucfirst($activity->type) }}
                                        </div>
                                        @else
                                            <div>
                                                @if($activity->seller_confirmed && $activity->buyer_confirmed && strtotime($activity->meeting) < time() && ($activity->seller->id == Auth::id() || $activity->buyer->id == Auth::id() || !is_null($activity->buyer_mark) || !is_null($activity->seller_mark)))
                                                <div class="gold_star rating-stars"
                                                     data-activity="{{$activity->id}}"
                                                     data-type="{{$activity->type}}"
                                                     @if($activity->seller->id == Auth::id() || $activity->buyer->id == Auth::id())
                                                     data-rated="{{!is_null($activity->seller_mark) && $activity->seller->id == Auth::id() ? "true" : (!is_null($activity->buyer_mark) && $activity->buyer->id == Auth::id() ? "true" : "false")}}"
                                                     data-rate="{{!is_null($activity->seller_mark) && $activity->seller->id == Auth::id() ? $activity->seller_mark : (!is_null($activity->buyer_mark) && $activity->buyer->id == Auth::id() ? $activity->buyer_mark : 0)}}"
                                                     @else
                                                     data-rated="true"
                                                     data-rate="{{!is_null($activity->seller_mark) && $activity->seller->id == !$profile->id ? $activity->seller_mark : (!is_null($activity->buyer_mark) && $activity->buyer->id == !$profile->id ? $activity->buyer_mark : 0)}}"
                                                     @endif>
                                                </div>
                                                @endif
                                                <div class="gold_star time-met">
                                                    {{ ucfirst($activity->type) }}
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    @if ($activity->content)
                                    <p class="timeline-item-content">You leave a comment to seller:</p>
                                    <p class="timeline-item-comments">{{ $activity->content }}</p>
                                    @endif
                                    @if ($activity->type == 'meeting' || $activity->type == 'shipping')
                                    <p class="timeline-item-comments">{{ $activity->seller->name }} {!! ($activity->seller_confirmed === null) ? '<span class="time_text_gray">still has not confirmed</span>' : (!$activity->seller_confirmed ? '<span class="time_text_red">cancelled</span>' : '<span class="time_text_green">confirmed</span>') !!}</p>
                                    <p class="timeline-item-comments ti-it-p0">{{ $activity->buyer->name }} {!! ($activity->buyer_confirmed === null) ? '<span class="time_text_gray">still has not confirmed</span>' : (!$activity->buyer_confirmed ? '<span class="time_text_red">cancelled</span>' : '<span class="time_text_green">confirmed</span>') !!}</p>
                                    {!! (($activity->seller->id == Auth::id() && $activity->seller_confirmed === null) || ($activity->buyer->id == Auth::id() && $activity->buyer_confirmed === null)) ? '<a href="#" data-activity_id="'.$activity->id.'" data-confirm="true" class="blue_btn confirm">Confirm</a><a href="#" data-activity_id="'.$activity->id.'" data-confirm="false" class="gray-btn confirm">Cancel</a>' : '' !!}
                                    @endif
                                </li>
                            </ul>
                            @empty
                                <p>There are no activity yet!</p>
                            @endforelse
                            {{-- <ul>
                                <li>
                                    <div class="timeline-item-title">
                                        <span>2 May 2018</span>
                                        <div class="gold_star">
                                            <img src="/newthemplate/img/star_gold.svg" alt="Alternate Text" />
                                            <img src="/newthemplate/img/star_gold.svg" alt="Alternate Text" />
                                            <img src="/newthemplate/img/star_gold.svg" alt="Alternate Text" />
                                        </div>
                                    </div>
                                    <p class="timeline-item-content">You leave a comment to seller:</p>
                                    <p class="timeline-item-comments">Bad seller. Very Bad.</p>
                                </li>
                            </ul>
                            <ul>
                                <li>
                                    <div class="timeline-item-title">
                                        <span>15 May 2018</span>
                                        <div class="gold_star time-met">Meeting</div>
                                    </div>
                                    <p class="timeline-item-content">You leave a comment to seller:</p>
                                    <p class="timeline-item-comments">Elon Musk <span class="time_text_green">confirmed</span></p>
                                    <p class="timeline-item-comments ti-it-p0">John Johnson  <span class="time_text_gray">still has not confirmed</span></p>
                                </li>
                            </ul> --}}
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
<!--PROFILE END-->
@include("newthemplate.footer")