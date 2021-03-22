@if (session('status'))
    <div class="notification_popup_wrpr">
        <div class="notification_popup">
            <button class="close_notif_popup"></button>
            <a href="#">
                <img src="/mooimarkt/img/notification_def_img.svg">
            </a>
            <div class="text">
                <p>{{ Language::lang(session('status')) }}</p>
            </div>
        </div>
    </div>
@endif
<div class="notification_popup_wrpr" id="notification-alert" style="display: none">
    <div class="notification_popup">
        <button class="close_notif_popup"></button>
        <div class="img_wrpr">
            <a href="#" id="notif-link">
                <img src="/mooimarkt/img/notification_def_img.svg" id="notif-picture">
            </a>
        </div>
        <div class="text">
            <p class="text-notification"></p>
        </div>
    </div>
</div>

