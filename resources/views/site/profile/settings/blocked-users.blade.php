@include("site.inc.header")

<section class="sell_now_s">
    <div class="container">
        <div class="wrap_content_box clearfix">
            <div class="left_box sidebar_settings">
                <div class="s_title_wrpr">
                    <h3 class="s_title s_title_2">{{ Language::lang('Settings') }}</h3>
                </div>
                @include('site.profile.settings.inc.sidebar')
            </div>
            <div class="right content_box content_box_1">
                <form action="">
                    <div>
                        @if($blockedUsers->isNotEmpty())
                            <div class="blacklist_user_wrap users-list">
                                @foreach($blockedUsers as $blockedUser)
                                    <div class="blacklist_user_item" data-id="{{ $blockedUser->id }}" data-action="remove">
                                        <div class="wrap_info_user">
                                            <div class="image">
                                                <img src="{{ empty($blockedUser->avatar) ? '/mooimarkt/img/photo_camera.svg' : $blockedUser->avatar }}" alt="">
                                            </div>
                                            <div class="name">{{ $blockedUser->name }}</div>
                                        </div>
                                        <div class="action">x</div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="wrap_btn_form">
                                <button type="button" data-fancybox="" data-src="#add_to_black_list" class="btn def_btn save add_to_blacklist">
                                    @php(include("mooimarkt/img/add_to_blacklist.svg")) {{ Language::lang('Add to blocked users') }}
                                </button>
                            </div>
                        @else
                            <div class="blacklist_user_wrap users-list"></div>
                            <div class="wrap_btn_form" style="display: none;">
                                <button type="button" data-fancybox="" data-src="#add_to_black_list" class="btn def_btn save add_to_blacklist">
                                    @php(include("mooimarkt/img/add_to_blacklist.svg")) {{ Language::lang('Add to blocked users') }}
                                </button>
                            </div>

                            <div class="blacklist_empty">
                                <p>{{ Language::lang('Blocked users is empty') }}</p>
                                <button type="button" data-fancybox="" data-src="#add_to_black_list" class="btn def_btn add_to_blacklist">
                                    @php(include("mooimarkt/img/add_to_blacklist.svg")) {{ Language::lang('Add to blocked users') }}
                                </button>
                            </div>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@section('popup-blocks')
    <div class="blacklists_popup" id="add_to_black_list">
        <h3 class="popup_title">{{ Language::lang('Chose Item(s) to Sell') }}</h3>
        <div class="blacklist_user_wrap blacklists">
            @foreach($users as $user)
                <div class="blacklist_user_item" data-id="{{ $user->id }}" data-action="add">
                    <div class="wrap_info_user">
                        <div class="image">
                            <img src="{{ empty($user->avatar) ? '/mooimarkt/img/photo_camera.svg' : $user->avatar }}" alt="">
                        </div>
                        <div class="name">{{ $user->name }}</div>
                    </div>
                    <div class="action">+</div>
                </div>
            @endforeach
        </div>
        <div class="popup_right_btn_wrpr">
            <a href="" class="btn light_bordr_btn close_modal_btn">{{ Language::lang('Close') }}</a>
        </div>
    </div>
@endsection

@include("site.inc.footer")