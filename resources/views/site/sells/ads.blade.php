@include("site.inc.header")

<section class="left_sidebar_s">
    <div class="container">
        <aside class="profile_sidebar">
            <div class="profile_sidebar_row">
                <div class="img_wrpr">
                    <img src="{{ empty($user->avatar) || !Storage::disk('public')->exists(str_replace("/storage", "", $user->avatar)) ? '/mooimarkt/img/photo_camera.svg' : $user->avatar }}"
                         alt="">
                </div>
                <h3 class="sidebar_nickname">{{ $user->fullName ?? $user->name }}</h3>
            </div>
            <div class="profile_sidebar_row ">
                <h3 class="sidebar_title">{{ Language::lang('Buyer') }}</h3>
                <div class="stars_rating_row">
                    @if($activitiesBuyer >= 1)
                        <a href="{{ route('profile.show', [$user->id, 'activity' => 'buyer']) }}">
                            <ul class="stars_rating">
                                @for($i = 1; $i <= 5; $i++)
                                    <li class="star_item {{ $i <= $activitiesBuyer ? 'active' : '' }}"></li>
                                @endfor
                                <li>{{ $activitiesBuyer > 0 ? $activitiesBuyer : '' }}</li>
                            </ul>
                        </a>
                        <a href="{{ route('profile.show', [$user->id, 'activity' => 'buyer']) }}">
                            <?php include "mooimarkt/img/arrow_right_icon.svg"; ?>
                        </a>
                    @else
                        <a href="#" style="cursor: default">
                            <ul class="stars_rating">
                                @for($i = 1; $i <= 5; $i++)
                                    <li class="star_item"></li>
                                @endfor
                                <li></li>
                            </ul>
                        </a>
                        <a href="#" class="svg_cursor__default">
                            <?php include "mooimarkt/img/arrow_right_icon.svg"; ?>
                        </a>
                    @endif
                </div>
            </div>
            <div class="profile_sidebar_row">
                <h3 class="sidebar_title">{{ Language::lang('Seller') }}</h3>
                <div class="stars_rating_row">
                    @if($activitiesSeller >= 1)
                        <a href="{{ route('profile.show', [$user->id, 'activity' => 'seller']) }}">
                            <ul class="stars_rating">
                                @for($i = 1; $i <= 5; $i++)
                                    <li class="star_item {{ $i <= $activitiesSeller ? 'active' : '' }}"></li>
                                @endfor
                                <li>{{ $activitiesSeller > 0 ? $activitiesSeller : '' }}</li>
                            </ul>
                        </a>
                        <a href="{{ route('profile.show', [$user->id, 'activity' => 'seller']) }}">
                            <?php include "mooimarkt/img/arrow_right_icon.svg"; ?>
                        </a>
                    @else
                        <a href="#" style="cursor: default">
                            <ul class="stars_rating">
                                @for($i = 1; $i <= 5; $i++)
                                    <li class="star_item"></li>
                                @endfor
                                <li></li>
                            </ul>
                        </a>
                        <a href="#" class="svg_cursor__default">
                            <?php include "mooimarkt/img/arrow_right_icon.svg"; ?>
                        </a>
                    @endif
                </div>
            </div>
            <div class="profile_sidebar_row follow_user_row">
                <div class="wrap_user">
                    <ul class="follow_user_wrap">
                        @foreach($followers->take(3) as $follower)
                            <li class="follow_user img_wrpr">
                                <a href="/profile/{{ $follower->id }}">
                                    <img src="{{ empty($follower->avatar) || !Storage::disk('public')->exists(str_replace("/storage", "", $follower->avatar)) ? '/mooimarkt/img/photo_camera.svg' : $follower->avatar }}"
                                         alt="">
                                </a>
                            </li>
                        @endforeach
                        <li class="number">
                            @if(count($followers))
                                <a href="{{ route('profile.followers-list', $user->id) }}">
                                    {{ count($followers) . Language::lang('&nbsp;followers') }}
                                </a>
                            @else
                                {{ Language::lang('No followers') }}
                            @endif
                        </li>
                    </ul>
                    @if(count($followers))
                        <a href="{{ route('profile.followers-list', $user->id) }}">
                            <?php include "mooimarkt/img/arrow_right_icon.svg"; ?>
                        </a>
                    @else
                        <a href="#" class="svg_cursor__default">
                            <?php include "mooimarkt/img/arrow_right_icon.svg"; ?>
                        </a>
                    @endif
                </div>
            </div>
            <div class="profile_sidebar_row">
                <ul class="profile_sidebar_time_info">
                    <li>
                        @php(include ("mooimarkt/img/hlogin_top_line_icon_2.svg"))
                        <span class="green">{{ Language::lang('Online') }}</span>
                    </li>
                    <li>
                        {{ Language::lang('On website since ') }}
                        <span>{{ $websiteSince }}</span>
                    </li>
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
            <div class="profile_sidebar_row">
                <p class="profile_sidebar_text">{{ $user->about_me }}</p>
                <a href="{{ route('myMessage') }}"
                   class="btn def_btn message_btn">@php(include ("mooimarkt/img/header_login_icons_2.svg")){{ Language::lang('my messages') }} </a>
                <a href="{{ route('profile.settings.general_settings') }}"
                   class="btn settings_btn">@php(include ("mooimarkt/img/settings_icon.svg")){{ Language::lang('Settings') }} </a>
            </div>
        </aside>
        <main class="main_content">
            <div class="my_items_top_controls">
                <div class="my_items_dropdown_tabs">
                    <h3 class="dropdown_tabs_title"><span
                                data-items-target="sell_items"> {{ Language::lang($itemTarget) }}</span> @php(include ("mooimarkt/img/language_arrow_bottom.svg"))
                    </h3>
                    <div class="my_items_dropdown_list">
                        @foreach($itemsList as $key => $item)
                            <a href="{{ $key }}">
                                <span data-items-target="bought_items">{{ Language::lang($item) }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="my_items_controls_content sell_items active">
                    <div class="left items_test">
                        @if($filter != 'favorites' && $filter != 'bought')
                            <div class="items_radios_wrpr">
                                <a href="{{ route('ads', 'published') }}" class="items_radio"
                                   data-items-target="sell_items">
                                    <input type="radio"
                                           name="items_radio" {{ $filter == 'published' ? 'checked' : '' }}>
                                    <span class="items_radio_btn">@php(include ("mooimarkt/img/hlogin_top_line_icon_1.svg")){{ Language::lang('My published items') }} </span>
                                </a>
                                <a href="{{ route('ads', 'expired') }}" class="items_radio"
                                   data-items-target="bought_items">
                                    <input type="radio" name="items_radio" {{ $filter == 'expired' ? 'checked' : '' }}>
                                    <span class="items_radio_btn">@php(include ("mooimarkt/img/hlogin_top_line_icon_2.svg")) {{ Language::lang('Expired items') }}</span>
                                </a>
                                <a href="{{ route('ads', 'sold') }}" class="items_radio">
                                    <input type="radio" name="items_radio" {{ $filter == 'sold' ? 'checked' : '' }}>
                                    <span class="items_radio_btn">@php(include ("mooimarkt/img/hlogin_top_line_icon_3.svg")) {{ Language::lang('Sold items') }}</span>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
                @if($filter != 'favorites' && $filter != 'sold' && $filter != 'bought')
                    <div class="my_items_controls_btns">
                        <button class="my_items_top_btn edit_items_btn"></button>
                    </div>
                @endif
            </div>
            <div class="card-items item-3 my_items_cards sell_items active">
                @include('site.inc.ads-list')
            </div>
            {{ $ads->withPath(route('ads', ['filter' => $filter]))->appends($_GET)->links() }}
        </main>
    </div>

    <div class="first_listed_popup" id="favorites">
        <h3>{{ Language::lang('Are you sure ?') }}</h3>
        <div class="btns_wrpr">
            <a href="" class="btn light_bordr_btn close_modal_btn"> {{ Language::lang('Cancel') }}</a>
            <button class="btn def_btn" id="favorite_confirm"> {{ Language::lang('Confirm') }}</button>
        </div>
    </div>
    <div class="first_listed_popup" id="extend_product">
        <h3> {{ Language::lang('Do you want to extend the display of goods?') }}</h3>
        <div class="btns_wrpr">
            <a href="" class="btn light_bordr_btn close_modal_btn"> {{ Language::lang('Cancel') }}</a>
            <button class="btn def_btn" id="extend_product_confirm_btn"> {{ Language::lang('Confirm') }}</button>
        </div>
    </div>
    <div class="first_listed_popup" id="first_listed_popup">
        <h3> {{ Language::lang('Make your ad First Listed') }}</h3>
        <p>  {{ Language::lang('Confirm that you want to make') }} <a href=""
                                                                      id="name-ads"></a> {{ Language::lang('First Listed. It will cost') }}
            <b>{{ App\Option::getCost("opt_pack_spotlight")['cost']}} {{ Language::lang(App\Option::getCost("opt_pack_spotlight")['currency'])  }}</b>.
        </p>
        <div class="btns_wrpr">
            <a href="" class="btn light_bordr_btn close_modal_btn"> {{ Language::lang('Cancel') }}</a>
            <a href="" class="btn def_btn first_listed_confirm_btn"> {{ Language::lang('Confirm') }}</a>
        </div>
    </div>
</section>

@include("site.inc.notification")
@include("site.inc.footer")
