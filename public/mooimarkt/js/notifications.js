$(document).ready(function () {
    if (window.authUserID) {
        window.Echo.private('notifications.' + window.authUserID)
            .listen('NewNotification', (notification) => {
                showNotification(notification.message, notification.picture);
                if (notification.id !== null) {
                    readNotifications([notification.id]);
                }
            });
    }

    function showNotification(message, picture = null) {
        $('#notification-alert').show();
        $('.text-notification').html(message);
        if (picture !== null) {
            $('#notif-picture').attr("src", picture.src);
            $('#notif-link').attr("href", picture.link);
        } else {
            $('#notif-picture').attr("src", '/mooimarkt/img/notification_def_img.svg');
            $('#notif-link').attr("href", picture.link);
        }
    }

    function readNotifications(ids) {
        $.post('/read-notifications', {
            ids   : ids,
            _token: $('meta[name="csrf-token"]').attr('content')
        })
    }

    window.setInterval(getNewNotifications, 5000);

    function getNewNotifications() {
        $.ajax({
            type   : 'POST',
            url    : '/notifications/get-new-notifications',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.success) {
                    let $headerNewNotificationsCounter = $('.toggle-ntf .notification_icon .unread-messages-count');

                    if (response.data.is_empty) {
                        $headerNewNotificationsCounter.html('').hide();
                    } else {
                        $headerNewNotificationsCounter.text(response.data.new_notifications_count).show();
                    }
                }
            }
        });
    }
});

