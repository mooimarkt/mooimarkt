<ul class="list">
    <li>
        <a href="{{ route('profile.settings.general_settings') }}" class="link">
            <span class="icon">
                @php(include("mooimarkt/img/set_general.svg"))
            </span>
            <span class="text">{{ Language::lang('My profile') }}</span>
        </a>
    </li>
    <li>
        <a href="{{ route('profile.settings.profile_email') }}" class="link">
            <span class="icon">
             @php(include("mooimarkt/img/set_email.svg"))
            </span>
            <span class="text">{{ Language::lang('Email') }}</span>
        </a>
    </li>
    <li>
        <a href="{{ route('profile.settings.profile_photo') }}" class="link">
            <span class="icon">
             @php(include("mooimarkt/img/set_profile_photo.svg"))
            </span>
            <span class="text">{{ Language::lang('Profile photo') }}</span>
        </a>
    </li>
    <li>
        <a href="{{ route('profile.settings.password') }}" class="link">
            <span class="icon">
             @php(include("mooimarkt/img/settings_icon.svg"))
            </span>
            <span class="text">{{ Language::lang('Change password') }}</span>
        </a>
    </li>
    <li>
        <a href="{{ route('profile.settings.blocked_users') }}" class="link">
            <span class="icon">
             @php(include("mooimarkt/img/set_blocked_users.svg"))
            </span>
            <span class="text">{{ Language::lang('Blocked users') }}</span>
        </a>
    </li>
</ul>