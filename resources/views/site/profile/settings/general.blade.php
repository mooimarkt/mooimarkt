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
            <div class="right content_box">
                @include('site.inc.flush-messages')

                <form action="{{ route('profile.settings.general_settings') }}" method="post">
                    {{ @csrf_field() }}
                    <div class="sell_now_two_cols">
                        <div class="col">
                            <div class="form_group">
                                <label class="text_label">{{ Language::lang('Name') }} *</label>
                                <input type="text" class="text_input" placeholder="{{ Language::lang('John') }}"
                                       name="general[name]" value="{{ old('name') ?? $user->name }}">
                                @if($errors->has('general.name'))
                                    <p style="color: red">
                                        {{ str_replace('general.', '', $errors->first('general.name')) }}
                                    </p>
                                @endif
                            </div>

                            <div class="form_group">
                                <label class="text_label">{{ Language::lang('Country') }} *</label>
                                <select name="general[country]" id="country" class="select_two_select">
                                    @foreach($countries as $country)
                                        <option value="{{ $country->name }}"
                                                data-id="{{ $country->id }}" {{ $user->country == $country->name ? 'selected' : '' }}>{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form_group">
                                <label class="text_label">{{ Language::lang('Gender') }}</label>
                                <select name="general[gender]" id="gender" class="select_two_select">
                                    <option value="male" {{ $user->gender == 'male' ? 'selected' : '' }}>{{ Language::lang('Male') }}</option>
                                    <option value="female" {{ $user->gender == 'female' ? 'selected' : '' }}>{{ Language::lang('Female') }}</option>
                                    <option value="other" {{ $user->gender == 'other' ? 'selected' : '' }}>{{ Language::lang('Other') }}</option>
                                </select>
                            </div>


                            <div class="form_group">
                                <label class="text_label">{{ Language::lang('About my wardrobe, sending/receiving goods') }}</label>
                                <textarea id="" class="text_input textareat_limited" name="general[about_me]"
                                          maxlength="500"
                                          placeholder="{{ Language::lang('Add information about you') }}">{{ old('about_me') ?? $user->about_me }}</textarea>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form_group">
                                <div class="form_group">
                                    <label class="text_label">{{ Language::lang('Full name') }}</label>
                                    <input type="text" class="text_input" placeholder="{{ Language::lang('John Doe') }}"
                                           name="general[fullName]" value="{{ old('fullName') ?? $user->fullName }}">
                                </div>

                                <label class="text_label">{{ Language::lang('City') }} *</label>
                                <select name="general[city]" id="city" class="select_two_select">
                                    @foreach($cities as $city)
                                        <option value="{{ $city->name }}" {{ $user->city == $city->name ? 'selected' : '' }}>{{ $city->name }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('general.city'))
                                    <p style="color: red">
                                        {{ str_replace('general.', '', $errors->first('general.city')) }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12">
                        <div class="wrap_checkbox">
                            <label class="text_label"><b>{{ Language::lang('Receiving money') }} *</b></label>
                            <div class="form_group">
                                <label class="checkbox_container checkbox_container_2">
                                    <input type="radio" name="general[receiving_money]"
                                           value="cash" {{ $user->receiving_money == 'cash' ? 'checked' : '' }}>
                                    {{ Language::lang('Cash') }}
                                    <span class="checkbox_icon"></span>
                                </label>
                            </div>

                            <div class="form_group">
                                <label class="checkbox_container checkbox_container_2">
                                    <input type="radio" name="general[receiving_money]"
                                           value="wallet" {{ $user->receiving_money == 'wallet' ? 'checked' : '' }}>
                                    {{ Language::lang('Bank transfer/Tikkie') }}
                                    <span class="checkbox_icon"></span>
                                </label>
                            </div>

                            <div class="form_group">
                                <label class="checkbox_container checkbox_container_2">
                                    <input type="radio" name="general[receiving_money]"
                                           value="cash_and_wallet" {{ $user->receiving_money == 'cash_and_wallet' ? 'checked' : '' }}>
                                    {{ Language::lang('Cash and Bank transfer/Tikkie') }}
                                    <span class="checkbox_icon"></span>
                                </label>
                            </div>
                        </div>
                        @if($errors->has('general.receiving_money'))
                            <p style="color: red; margin-bottom: 25px; margin-top: -15px;">
                                {{ str_replace('general.', '', $errors->first('general.receiving_money')) }}
                            </p>
                        @endif

                        <div class="wrap_checkbox">
                            <label class="text_label"><b>{{ Language::lang('Receiving/sending goods') }} *</b></label>

                            <div class="form_group">
                                <label class="checkbox_container checkbox_container_2">
                                    <input type="radio" name="general[delivery]"
                                           value="meeting" {{ $user->delivery == 'meeting' ? 'checked' : '' }}>
                                    {{ Language::lang('Meeting') }}
                                    <span class="checkbox_icon"></span>
                                </label>
                            </div>

                            <div class="form_group">
                                <label class="checkbox_container checkbox_container_2">
                                    <input type="radio" name="general[delivery]"
                                           value="post" {{ $user->delivery == 'post' ? 'checked' : '' }}>
                                    {{ Language::lang('Sending by post') }}
                                    <span class="checkbox_icon"></span>
                                </label>
                            </div>

                            <div class="form_group">
                                <label class="checkbox_container checkbox_container_2">
                                    <input type="radio" name="general[delivery]"
                                           value="meeting & post" {{ $user->delivery == 'meeting & post' ? 'checked' : '' }}>
                                    {{ Language::lang('Meeting and sending by post') }}
                                    <span class="checkbox_icon"></span>
                                </label>
                            </div>
                        </div>
                        @if($errors->has('general.delivery'))
                            <p style="color: red; margin-bottom: 15px; margin-top: -15px;">
                                {{ str_replace('general.', '', $errors->first('general.delivery')) }}
                            </p>
                        @endif

                        <div class="wrap_btn_form profile_settings">
                            <button type="submit" class="btn def_btn save">{{ Language::lang('Save') }}</button>
                            <button type="button" class="btn bordr_btn cancel">{{ Language::lang('Cancel') }}</button>

                            <a href="{{ route('profile.deleteAccount') }}" class="btn def_btn"
                               id="delete-account">{{ Language::lang('Delete account') }}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@include('site.inc.notification')
@include("site.inc.footer")
