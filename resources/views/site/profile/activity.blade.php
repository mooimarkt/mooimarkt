@include("site.inc.header")

<section class="left_sidebar_s">
    <div class="container">
        <aside class="profile_sidebar" data-id="{{ $user->id }}">
            <div class="profile_sidebar_row">
                <div class="img_wrpr">
                    <img src="{{ empty($user->avatar) ? '/mooimarkt/img/photo_camera.svg' : $user->avatar }}" alt="">
                </div>
                <h3 class="sidebar_nickname">{{ $user->name }}</h3>
            </div>
            <div class="profile_sidebar_row">
                <h3 class="sidebar_title">{{ Language::lang('Buyer') }}</h3>
                <div class="stars_rating_row">
                    <a href="{{ $activitiesBuyer >= 1 ? route('profile.show', [$user->id, 'activity' => 'buyer']) : '#' }}"
                       style="{{ $activitiesBuyer < 1 ? 'cursor: default' : '' }}">
                        <ul class="stars_rating">
                            @for($i = 1; $i <= 5; $i++)
                                <li class="star_item {{ $i <= $activitiesBuyer ? 'active' : '' }}"></li>
                            @endfor
                            <li>{{ $activitiesBuyer > 0 ? $activitiesBuyer : '' }}</li>
                        </ul>
                    </a>
                    <?php include "mooimarkt/img/arrow_right_icon.svg"; ?>
                </div>
            </div>
            <div class="profile_sidebar_row">
                <h3 class="sidebar_title">{{ Language::lang('Seller') }}</h3>
                <div class="stars_rating_row">
                    <a href="{{ $activitiesSeller >= 1 ? route('profile.show', [$user->id, 'activity' => 'seller']) : '#' }}"
                       style="{{ $activitiesSeller < 1 ? 'cursor: default' : '' }}">
                        <ul class="stars_rating">
                            @for($i = 1; $i <= 5; $i++)
                                <li class="star_item {{ $i <= $activitiesSeller ? 'active' : '' }}"></li>
                            @endfor
                            <li>{{ $activitiesSeller > 0 ? $activitiesSeller : '' }}</li>
                        </ul>
                    </a>
                    <?php include "mooimarkt/img/arrow_right_icon.svg"; ?>
                </div>
            </div>
            <div class="profile_sidebar_row follow_user_row">
                <ul class="follow_user_wrap"></ul>
                <button class="btn btn_follow">{{ $checkFollower ? Language::lang('follow') : Language::lang('unfollow') }}</button>
            </div>
            <div class="profile_sidebar_row">
                <ul class="profile_sidebar_time_info">
                    <li>@php(include("mooimarkt/img/hlogin_top_line_icon_2.svg"))
                        <span>{{ $user->getOnlineAttribute() }}</span></li>
                    <li>On website since <span>{{ $user->created_at->format('d.m.Y') }}</span></li>
                </ul>
            </div>
            @if($user->show_email && $user->email)
                <div class="profile_sidebar_row">
                    <ul class="social-items grey_color">
                        <li>
                            <a href="mailto:{{ $user->email }}">@php(include ("mooimarkt/img/mail_icon_gray.svg"))</a>
                        </li>
                    </ul>
                </div>
            @endif
        </aside>

        <main class="main_content">
            <div class="card-items item-3">
                @if(request()->activity === 'seller')
                    <ul class="review-list">
                        @foreach($activity as $item)
                            <li class="review-item">
                                <div class="icon">
                                    <a href="{{ route('profile.show', $item->buyer->id) }}">
                                        <img src="{{ $item->buyer->getAvatarAttribute($item->buyer->avatar) }}" alt="">
                                    </a>
                                </div>
                                <div class="text-box">
                                    <div class="top">
                                        <div class="time">{{ Carbon\Carbon::parse($item->created_at)->format('d.m.Y H:i:s') }}</div>
                                    </div>
                                    <div class="username">
                                        <a href="{{ route('profile.show', $item->buyer->id) }}">{{ $item->buyer->name }}</a>
                                    </div>
                                    <div class="stars_rating_row">
                                        <ul class="stars_rating">
                                            @for($i = 1; $i <= 5; $i++)
                                                <li class="star_item {{ $i <= $item->buyer_mark ? 'active' : '' }}"></li>
                                            @endfor
                                        </ul>
                                    </div>
                                    <p>{{ $item->comment }}</p>
                                </div>
                                <div class="product-icon">
                                    @if($item->ads && ($image = $item->ads->images->first()))
                                        <img src="{{ $image->thumb }}" alt="">
                                    @else
                                        <img src="/mooimarkt/img/logo.svg" alt="">
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @elseif(request()->activity === 'buyer')
                    <ul class="review-list">
                        @foreach($activity as $item)
                            <li class="review-item">
                                <div class="icon">
                                    <a href="{{ route('profile.show', $item->seller->id) }}">
                                        <img src="{{ $item->seller->getAvatarAttribute($item->seller->avatar) }}"
                                             alt="">
                                    </a>
                                </div>
                                <div class="text-box">
                                    <div class="top">
                                        <div class="time">{{ Carbon\Carbon::parse($item->created_at)->format('d.m.Y H:i:s') }}</div>
                                    </div>
                                    <div class="username">
                                        <a href="{{ route('profile.show', $item->seller->id) }}">{{ $item->seller->name }}</a>
                                    </div>
                                    <div class="stars_rating_row">
                                        <ul class="stars_rating">
                                            @for($i = 1; $i <= 5; $i++)
                                                <li class="star_item {{ $i <= $item->seller_mark ? 'active' : '' }}"></li>
                                            @endfor
                                        </ul>
                                    </div>
                                    <p>{{ $item->seller_comment }}</p>
                                </div>
                                <div class="product-icon">
                                    @if($item->ads && ($image = $item->ads->images->first()))
                                        <img src="{{ $image->thumb }}" alt="">
                                    @else
                                        <img src="/mooimarkt/img/logo.svg" alt="">
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </main>
    </div>
</section>

@include("site.inc.notification")
@include("site.inc.footer")