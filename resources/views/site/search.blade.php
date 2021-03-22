@include("site.inc.header")

<section class="s-category">
    <div class="container">
        <div class="category-wrap">
            <div class="category-box">
                <div class="top-info">
                    <ul class="breadcrumbs">
                        <li><a href="/">{{ Language::lang('Home') }}</a></li>
                        <li>/</li>
                        <li><a href="/catalog">{{ Language::lang('Search') }}</a></li>
                    </ul>
                    <h1 class="top-title">{{ Language::lang('Search') }}</h1>
                </div>
            </div>

            <div class="category-filter-panel tags">
                <ul class="tag-items"></ul>
            </div>
        </div>
    </div>
</section>

<section class="cards_sections_wrpr">
    <section class="s-results">
        <div class="container">
            <div class="top-panel">
                <div class="resultsSearch">{{ $result->count() }} results</div>
            </div>
            <div class="card-items item-4">
                @foreach($result as $item)
                    <aside class="profile_sidebar" data-id="{{ $item->id }}">
                        <div class="profile_sidebar_row">
                            <div class="img_wrpr">
                                <img src="{{ empty($item->avatar) ? '/mooimarkt/img/photo_camera.svg' : $item->avatar }}"
                                     alt="">
                            </div>
                            <a href="{{ route('profile.show', $item->id) }}">
                                <h3 class="sidebar_nickname">{{ $item->name }}</h3>
                            </a>
                        </div>
                        <div class="profile_sidebar_row ">
                            <h3 class="sidebar_title">{{ Language::lang('Buyer') }}</h3>
                            <div class="stars_rating_row">
                                <ul class="stars_rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        <li class="star_item {{ $i <= $item->activitiesBuyer ? 'active' : '' }}"></li>
                                    @endfor
                                    <li>{{ $item->activitiesBuyer > 0 ? $item->activitiesBuyer : '' }}</li>
                                </ul>
                            <!--<a href="" class="rating_arrow_link"><?php include "mooimarkt/img/arrow_right_icon.svg"; ?></a>-->
                            </div>
                        </div>
                        <div class="profile_sidebar_row">
                            <h3 class="sidebar_title">{{ Language::lang('Seller') }}</h3>
                            <div class="stars_rating_row">
                                <ul class="stars_rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        <li class="star_item {{ $i <= $item->activitiesSeller ? 'active' : '' }}"></li>
                                    @endfor
                                    <li>{{ $item->activitiesSeller > 0 ? $item->activitiesSeller : '' }}</li>
                                </ul>
                            <!--<a href="" class="rating_arrow_link"><?php include "mooimarkt/img/arrow_right_icon.svg"; ?></a>-->
                            </div>
                        </div>
                        <div class="profile_sidebar_row follow_user_row">
                            <div class="wrap_user">
                                <ul class="follow_user_wrap">
                                </ul>
                            <!--<a href="" class="rating_arrow_link"><?php include "mooimarkt/img/arrow_right_icon.svg"; ?></a>-->
                            </div>
                            <button class="btn btn_follow">{{ $item->savedUsers ? Language::lang('follow') : Language::lang('unfollow') }}</button>
                        </div>
                        <div class="profile_sidebar_row">
                            <ul class="profile_sidebar_time_info">
                                <li>@php(include("mooimarkt/img/hlogin_top_line_icon_2.svg"))
                                    <span>{{ $item->getOnlineAttribute() }}</span></li>
                                <li>On website since <span>{{ $item->created_at->format('d.m.Y') }}</span></li>
                            </ul>
                        </div>
                                @if($item->show_email && $item->email)
                            <div class="profile_sidebar_row">
                                    <ul class="social-items grey_color">
                                        {{--<li><a href="{{ $item->facebook_link }}" target="_blank"
                                               rel="nofollow noreferrer">@php(include ("mooimarkt/img/fb-icon.svg"))</a></li>
                                        <li><a href="{{ $item->instagram_link }}" target="_blank"
                                               rel="nofollow noreferrer">@php(include ("mooimarkt/img/inst-icon.svg"))</a></li>--}}
                                    <li>
                                        <a href="mailto:{{ $item->email }}">@php(include ("mooimarkt/img/mail_icon_gray.svg"))</a>
                                    </li>
                                    </ul>
                            </div>
                                @endif
                    </aside>
                @endforeach
            </div>
        </div>
    </section>
</section>

@section('bottom-footer')
    <script>
        $('.btn_follow').click(function (e) {
            var userId = $(this).parent().parent().data('id');
            $.ajax({
                url: '/profile/follower/' + userId,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                dataType: 'JSON',
                success: function (data) {
                    if (data.action === 'subscribed') {
                        $('.btn_follow').html('unfollow')
                    }
                    if (data.action === 'unsubscribed') {
                        $('.btn_follow').html('follow')
                    }
                }
            });
        })
    </script>
@endsection

@include("site.inc.notification")
@include("site.inc.footer")