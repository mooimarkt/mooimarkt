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
            <div class="right content_box height_100vh">
                <form action="{{ route('profile.settings.profile_email') }}" method="post">
                    {{ @csrf_field() }}
                    <div>
                        <div class="form_group">
                            <label class="text_label">{{ Language::lang('current email') }}</label>
                            <div class="wrap_input_box">
                                <input type="email" class="text_input" placeholder="donald.wood@example.com" name="email" value="{{ $user->email }}">
{{--                                <input type="submit" class="btn bordr_btn cancel change" value="change">--}}
                            </div>
                            @if($errors->has('email'))
                                <div class="alert alert-danger">{{ $errors->first('email') }}</div>
                            @endif
                        </div>

                        <div class="form_group">
                            <label class="checkbox_container checkbox_container_2">
                                <input type="checkbox" name="show_email" value="1" {{ $user->show_email ? 'checked' : '' }}>
                                {{ Language::lang('receive letters from users by mail') }}
                                <span class="checkbox_icon"></span>
                            </label>
                        </div>

                        <div class="wrap_btn_form">
                            <button type="submit" class="btn def_btn save">{{ Language::lang('save') }}</button>
                            <button type="button" class="btn bordr_btn cancel">{{ Language::lang('Cancel') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@include("site.inc.footer")