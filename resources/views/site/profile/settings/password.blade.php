@include("site.inc.header")

<section class="sell_now_s" >
    <div class="container">
        <div class="wrap_content_box clearfix">
            <div class="left_box sidebar_settings">
                <div class="s_title_wrpr">
                    <h3 class="s_title s_title_2">{{ Language::lang('Settings') }}</h3>
                </div>
                @include('site.profile.settings.inc.sidebar')
            </div>

            <div class="right content_box height_100vh">
                @include('site.inc.flush-messages')

                <form action="{{ route('profile.settings.password') }}" method="post">
                    {{ @csrf_field() }}
                    {{ method_field('put') }}

                    <div class="sell_now_two_cols">
                        <div class="col">
                            <div class="form_group">
                                <label class="text_label">{{ Language::lang('Current password') }}</label>
                                <input type="password" class="text_input"
                                       placeholder="{{ Language::lang('Current password') }}"
                                       name="current_password" required>
                                @if($errors->has('current_password'))
                                    <p style="color: red">{{ $errors->first('current_password') }}</p>
                                @endif
                            </div>
                            <div class="form_group">
                                <label class="text_label">{{ Language::lang('New password') }}</label>
                                <input type="password" class="text_input"
                                       placeholder="{{ Language::lang('New password') }}"
                                       name="new_password" required>
                                @if($errors->has('new_password'))
                                    <p style="color: red">{{ $errors->first('new_password') }}</p>
                                @endif
                            </div>
                            <div class="form_group">
                                <label class="text_label">{{ Language::lang('Repeat new password') }}</label>
                                <input type="password" class="text_input"
                                       placeholder="{{ Language::lang('Repeat new password') }}"
                                       name="new_password_confirmation" required>
                            </div>
                        </div>

                        <div class="wrap_btn_form profile_settings">
                            <button type="submit" class="btn def_btn save">{{ Language::lang('Save') }}</button>
                            <button type="button" class="btn bordr_btn cancel">{{ Language::lang('Cancel') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@include('site.inc.notification')
@include("site.inc.footer")
