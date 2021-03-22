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
                <button class="btn btn_follow">{{ $checkFollower ? Language::lang('follow') : Language::lang('Unfollow') }}</button>
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
                @include('site.inc.ads-list')
            </div>
        </main>
    </div>
</section>

@section('bottom-footer')
    <script>
        function getFollowers() {
            $.ajax({
                url     : "/profile/get-followers/{{ $user->id }}",
                type    : 'GET',
                dataType: 'JSON',
                success : function (data) {
                    $('.follow_user_wrap').html('');

                    $.each(data.followers.slice(0, 3), function (key, value) {
                        if (value.avatar == null) {
                            $(".follow_user_wrap").append('' +
                                '<li class="follow_user img_wrpr">\n' +
                                '     <a href="/profile/' + value.id + '"><img src="/mooimarkt/img/photo_camera.svg" alt=""></a>\n' +
                                '</li>');
                        } else {
                            $(".follow_user_wrap").append('' +
                                '<li class="follow_user img_wrpr">\n' +
                                '     <a href="/profile/' + value.id + '"><img src="' + value.avatar + '" alt=""></a>\n' +
                                '</li>');
                        }
                    });
                    if (data.followers.length === 0) {
                        $(".follow_user_wrap").append('' +
                            '<li class="number">No followers</li>');
                    } else {
                        $(".follow_user_wrap").append('' +
                            '<li class="number">' + data.followers.length + ' followers</li>');
                    }
                }
            });
        }

        // getFollowers();

        $('.btn_follow').click(function () {
            let userId = $(this).parent().parent().data('id');

            $.ajax({
                url     : '/profile/follower/' + userId,
                headers : {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type    : 'POST',
                dataType: 'JSON',
                success : function (data) {
                    if (data.action === 'subscribed') {
                        $('.btn_follow').html('unfollow');
                        getFollowers();
                    }

                    if (data.action === 'unsubscribed') {
                        $('.btn_follow').html('follow');
                        getFollowers();
                    }
                }
            });
        });
    </script>
@endsection

@include("site.inc.notification")
@include("site.inc.footer")
