@include("site.inc.header")

<section class="sell_now_s">
  <div class="container">
    <h3 class="s_top_grey_title">{{ Language::lang('Change password') }}</h3>
    @if ($errors->any())
      <div class="alert alert-danger" style="margin-bottom: 20px;">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
    <div class="sell_now_form">
      <div class="sell_now_two_cols">
        <div class="col">
          <form action="{{ route('password.change', [$email, $token]) }}" method="POST">
            {{ csrf_field() }}

            <div class="form_group">
              <label class="text_label">{{ Language::lang('New password') }} *</label>
              <input type="password" class="text_input" name="password" value="{{ old('password') }}"
                     placeholder="{{ Language::lang('Enter new password') }}" required>
            </div>
            <div class="form_group">
              <label class="text_label">{{ Language::lang('Confirm password') }} *</label>
              <input type="password" class="text_input" name="password_confirmation" value="{{ old('password_confirmation') }}"
                     placeholder="{{ Language::lang('Confirm password') }}" required>
            </div>
            <div class="form_group">
              <button type="submit" class="btn def_btn">Change password</button>
            </div>
            <small>{{ Language::lang('After a successful password change, you will be automatically redirected to the main page') }}</small>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

@include("site.inc.footer")
