@include("newthemplate.header-login")

<section id="login-section" class="login-section">
    <div class="container">
        <h6>
            <span>@if(!isset($_REQUEST['register'])) {{ \App\Language::GetText(19) }} @else {{ \App\Language::GetText(14) }} @endif</span>
            B4MX
        </h6>
        <script>
            var modal = @if(!isset($_REQUEST['register'])) 'login' @else 'register' @endif;
        </script>
        <form action="#" id="auth-form" class="auth-form" @if(isset($_REQUEST['register'])) style="display: none;" @endif>
            {{csrf_field()}}
            <input type="email" name="email" class="user-input" placeholder="{{ \App\Language::GetText(11) }}">
            <input type="password" name="password" class="user-input" placeholder="{{ \App\Language::GetText(12) }}">
            <div class="user-checkbox">
                <input type="checkbox"><label></label><span>@php echo \App\Language::GetText(13); @endphp</span>
            </div>
            <input type="submit" value="{{ \App\Language::GetText(19) }}" class="user-submit">
            <a href="#" class="user-link register_page_modal">@php echo \App\Language::GetText(14); @endphp</a>
            <a href="#" class="user-link">@php echo \App\Language::GetText(15); @endphp</a>
            <span class="or">@php echo \App\Language::GetText(23); @endphp</span>
            <a href="/GoogleRedirect" class="login-google">@php echo \App\Language::GetText(16); @endphp</a>
            <a href="/FacebookRedirect" class="login-facebook">@php echo \App\Language::GetText(17); @endphp</a>
        </form>
        <form action="#" id="register-form" class="auth-form" @if(!isset($_REQUEST['register'])) style="display: none;" @endif>
            {{csrf_field()}}
            <input type="email" name="email" class="user-input" placeholder="Email Address">
            <input type="password" name="password" class="user-input" placeholder="{{ \App\Language::GetText(12) }}">
            <input type="password" name="password_confirmation" class="user-input" placeholder="{{ \App\Language::GetText(18) }}">
            <input type="submit" value="REGISTER" class="user-submit">
            <a href="#" class="user-link register_page_modal">@php echo \App\Language::GetText(19); @endphp</a>
            <span class="or">@php echo \App\Language::GetText(23); @endphp</span>
            <a href="/GoogleRedirect" class="login-google">@php echo \App\Language::GetText(20); @endphp</a>
            <a href="/FacebookRedirect" class="login-facebook">@php echo \App\Language::GetText(21); @endphp</a>
        </form>
    </div>
</section>

<section id="error-popup" class="popup">
    <div class="container">
        <div class="popup-inner">
            <h6>@php echo \App\Language::GetText(175); @endphp</h6>
            <p>@php echo \App\Language::GetText(176); @endphp</p>
            <a href="#" class="blue-button" id="popup-okay">@php echo \App\Language::GetText(177); @endphp</a>
        </div>
    </div>
    <div class="overlay" id="popup-overlay"></div>
</section>
@if(isset($success) && $success == "verified")
    <script>
        window.history.replaceState('', 'b4mx.com', '/getLoginPage');
    </script>
@endif
@include("newthemplate.footer")