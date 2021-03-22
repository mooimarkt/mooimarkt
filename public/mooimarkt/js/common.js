$(function () {
    $(document).on('click', function (e) {
        if (!$(e.target).hasClass('notifications_menu') && !$(e.target).parents('.notifications_menu').length > 0 && !$(e.target).hasClass('toggle-ntf') && !$(e.target).parents('.toggle-ntf').length > 0) {
            $(".notifications_menu").removeClass('active');
        }
    });

    $(".toggle-ntf").click(function (e) {
        e.preventDefault();

        $(".notifications_menu").toggleClass('active');

        if ($(".notifications_menu").hasClass('active')) {
            $('.notifications_items').html('');

            loadNotifications();
        }
    });

    function loadNotifications() {
        $.get('/notifications')
            .then((response) => {
                $('.show_more_notifications').remove();

                if (response.data.is_empty) {
                    $('.notifications_items').empty();
                    $('.notification_empty').show();
                } else {
                    $('.notification_empty').hide();
                    $('.notifications_items').append(response.data.view);
                    $('.notifications_menu.active').append(response.data.view_more);
                }
            });
    }


    /* $(".apply-filter").on("click", function () {
         $(this).parents('form').submit();
     });*/

    // $(".sort_by").on("change", function () {
    //     $(this).parents('form').submit();
    // });

    $(".m-search-form .search-icon").on("click", function () {
        $(this).parent().toggleClass("active");
    });

    $(document).on("mouseup", function (e) {
        var target = e.target;
        var searchBtn = $(".m-search-form .search-icon");
        var searchForm = $(".m-search-form");

        if (!searchBtn.is(target) && searchBtn.has(target).length === 0 && !searchForm.is(target) && searchForm.has(target).length === 0) {
            searchForm.removeClass("active");
        }
    });

    /*
    $(".m-action-item.chat-select").on("click", function (e) {
        e.preventDefault();
        $(this).hide();
        $(".message-item").addClass("checkbox-active");
        $(".m-action-item.delete-chat").hide();
        $(".m-action-item.m-item-delete, .m-action-item.m-select-all").addClass("active");
    });

    $(document).on("click", ".chat-container .m-select-all", function (e) {
        e.preventDefault();
        var checkboxes = $(this).closest('.chat-container').find(':checkbox');
        checkboxes.each( function () {
            this.checked = "checked";
        });
    });
    */

// Show the first tab by default
    $('.tabs-stage').children().hide();
    $('.tabs-stage div:first').show();

    $('.tabs-stage-payment').children().hide();
    $('.tabs-stage-payment div:first').show();

    $('.tabs-nav li:first').addClass('tab-active');

// Change tab class and display content
    $('.tabs-nav a').on('click', function (event) {
        event.preventDefault();
        $('.tabs-nav li').removeClass('tab-active');
        $(this).parent().addClass('tab-active');
        $('.tabs-stage').children().hide();
        $('.tabs-stage-payment').children().hide();
        $($(this).attr('href')).show();
    });

    if ($('#new-login').length > 0) {
        var new_login = $('#new-login');
        new_login.on('submit', function (e) {
            e.preventDefault();
            var email = $('#new-login').find('input[name="email"]').val();
            var pass = $('#new-login').find('input[name="pass"]').val();
            $.ajax({
                url: '/new-ajax-login',
                data: {"email": email, "pass": pass},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                dataType: 'JSON',
                success: function (res) {
                    if (res.message == "user") {
                        printSuccessMsg(".new-auth-validation", "Logined! Redirecting");
                        location.href = "/";
                    } else if (res.message == "admin") {
                        printSuccessMsg(".new-auth-validation", "Logined! Redirecting");
                        location.href = "/admin";
                    } else {
                        printErrorMsg(".new-auth-validation", res.message)
                    }
                }
            }).fail(function (res) {
                if (
                    typeof res.responseJSON == "object" &&
                    typeof res.responseJSON.errors == "object"
                ) {
                    let msg = "";
                    for (let Field in res.responseJSON.errors) {
                        msg += (Field.slice(0, 1).toUpperCase()) + Field.slice(1) + ": " + (res.responseJSON.errors[Field].join(', ')) + "<br/>";
                    }
                    printErrorMsg(".new-auth-validation", msg);
                } else {
                    printErrorMsg(".new-auth-validation", "Unexpected response");
                    console.error("Respose: ", res);
                }
            });
        });
    }

    if ($('#new-signup').length > 0) {
        var new_signup = $('#new-signup');

        new_signup.on('submit', function (e) {
            e.preventDefault();
            var name = $('#new-signup').find('input[name="name"]').val();
            var password = $('#new-signup').find('input[name="password"]').val();
            var password_confirmation = $('#new-signup').find('input[name="password_confirmation"]').val();
            var email = $('#new-signup').find('input[name="email"]').val();
            $.ajax({
                url: '/new-ajax-signup',
                data: {
                    "username": name,
                    "password": password,
                    "password_confirmation": password_confirmation,
                    "email": email
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                dataType: 'JSON',
                success: function (res) {
                    if (res.status == "success") {
                        printSuccessMsg(".new-signup-validation", res.message);

                        setTimeout(function () {
                            location.reload();
                        }, 2000);
                    } else {
                        printErrorMsg(".new-signup-validation", res)
                    }
                }
            }).fail(function (res) {
                if (
                    typeof res.responseJSON == "object" &&
                    typeof res.responseJSON.errors == "object"
                ) {
                    let msg = "";
                    for (let Field in res.responseJSON.errors) {
                        msg += (Field.slice(0, 1).toUpperCase()) + Field.slice(1) + ": " + (res.responseJSON.errors[Field].join(', ')) + "<br/>";
                    }
                    printErrorMsg(".new-signup-validation", msg);
                } else {
                    printErrorMsg(".new-signup-validation", "Unexpected response");
                    console.error("Respose: ", res);
                }
            });

        });
    }

    function printErrorMsg(fieldClass, msg) {
        $(fieldClass).find("ul").html('');
        $(fieldClass).css('display', 'block');
        $(fieldClass).css('background-color', '#a94442');
        if (jQuery.type(msg) === "string") {
            $(fieldClass).find("ul").append('<li>' + msg + '</li>');
        } else {
            $.each(msg.error, function (key, value) {
                $(fieldClass).find("ul").append('<li>' + value + '</li>');
            });
        }
    }

    function printSuccessMsg(fieldClass, msg) {
        $(fieldClass).find("ul").html('');
        $(fieldClass).css('display', 'block');
        $(fieldClass).css('background-color', '#28a745');
        $(fieldClass).find("ul").append('<li>' + msg + '</li>');
    }
});