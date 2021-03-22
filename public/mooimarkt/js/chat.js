(function ($) {
    var Chat = {
        'get_message_timer'           : 5000,
        'read_message_timer'          : 1000,
        'check_unread_messages_timer' : 5000,
        'chat_wrapper'                : '.chat_wrapper',
        'chat_container'              : '.chat-container',
        'chat_start_btn'              : '.chat-start',
        'chat_user_list_item'         : '.chat-container .m-item',
        'chat_right_side'             : '.chat-container .right',
        'chat_item'                   : '.chat-container .chat-right-wrapper',
        'chat_item_active'            : '.chat-container .chat-right-wrapper.active',
        'chat_send_message_btn'       : '.chat-container .btn-send-message',
        'chat_hide_deleting_btn'      : '.chat-container .m-action-item.hide-deleting',
        'chat_select_messages_btn'    : '.chat-container .m-action-item.chat-select',
        'chat_select_all_messages_btn': '.chat-container .m-select-all',
        'chat_delete_messages_btn'    : '.chat-container .m-item-delete',
        'chat_delete_chat_btn'        : '.chat-container .delete-chat',
        'chat_search_field'           : '.chat-container .m-search-form input',
        'sell_item_btn'               : '.chat-container .sell-item',
        'sold_item_btn'               : '.accordion_item .sold_btn',
        'stop_item_btn'               : '.accordion_item .stop_btn',
        'resume_item_btn'             : '.accordion_item .resume_btn',
        'confirm_sale_buyer_btn'      : '.chat-container .confirm_sale_buyer_btn',
        'confirm_selling_form'        : '.confirm-selling-form',
        'confirm_sale_form'           : '#confirmSaleForm',
        'confirm_sale_buyer'          : '.confirm_sale_buyer',
        'token'                       : $('[name="csrf-token"]').attr('content'),
        init                          : function () {
            this.bind();

            this.getMessages();
            this.sendFile();
            this.checkUnreadMessages();
            this.getUnreadMessagesCount();

            this.section_example     = $(this.example_block).find(this.example_section);
            this.lesson_example      = $(this.example_block).find(this.example_lesson);
            this.main_block          = $(this.main_block_id);
            this.sections_items_list = this.main_block.find(this.sections_items_list_class);
            this.section_iter        = this.main_block.data('iter');
        },
        bind                          : function () {
            $(document).on('click', this.chat_start_btn, this.startChat);
            $(document).on('click', this.chat_user_list_item, this.switchChat);
            $(document).on('click', this.chat_send_message_btn, this.sendMessage);
            $(document).on('keypress', '.message-input', function (e) {
                if (e.which == 13) {
                    let sendButton = $(this).parent().next().find('.btn-send-message');
                    Chat.sendMessage(e, sendButton);
                }
            });
            $(document).on('click', this.chat_hide_deleting_btn, this.hideDeleting);
            $(document).on('click', this.chat_select_messages_btn, this.selectMessages);
            $(document).on('click', this.chat_select_all_messages_btn, this.selectAllMessages);
            $(document).on('click', this.chat_delete_messages_btn, this.deleteMessages);
            $(document).on('click', this.chat_delete_chat_btn, this.deleteChat);
            $(document).on('input keyup', this.chat_search_field, this.searchUsers);
            $(document).on('click', this.sold_item_btn, this.sellItem);
            $(document).on('click', this.stop_item_btn, this.stopItem);
            $(document).on('click', this.resume_item_btn, this.resumeItem);
            $(document).on('click', this.confirm_sale_buyer_btn, this.confirmSaleBuyer);
            $(document).on('click', this.confirm_sale_buyer, this.confirmSaleBuyer);
            $(document).on('submit', this.confirm_selling_form, this.confirmSelling);
            $(document).on('submit', this.confirm_sale_form, this.sendConfirmSaleBuyer);
            $(document).on('click', this.sell_item_btn, this.sellItem);
        },
        startChat                     : function (e) {
            e.preventDefault();
            let self = this;

            $.ajax({
                type   : 'POST',
                url    : '/GetChat',
                data   : {_token: Chat.token, adId: $(this).data('id')},
                success: function (data) {
                    if (data.status == 'success') {
                        window.location.href = '/messages?im=' + $(self).data('im') + '&product_id=' + data.product_id;
                    } else {
                        if (typeof data.code != "undefined") {
                            switch (data.code) {
                                case 1:
                                    alert("Please Auth");
                                    break;
                                case 2:
                                    alert("Ad not exists");
                                    break;
                                case 3:
                                    alert("You can`t write yourself");
                                    break;
                                default:
                                    alert("Unexpected error code");
                                    break;
                            }
                        } else {
                            alert("Unexpected response");
                        }
                    }
                },
                error  : function (error) {
                    if (error.responseJSON.message) {
                        showNotification('Please Auth');
                    }
                }
            });
        },
        switchChat                    : function (e) {
            e.preventDefault();

            let $button        = $(this);
            let $chatContainer = $button.closest(Chat.chat_container);
            let $mainContainer = $button.closest('.accordion_item');

            let chatId = $button.data('chatId');
            let info   = $button.data('info');

            if (chatId) {
                $('.chat-right-wrapper', $chatContainer)
                    .removeClass('active')
                    .hide();
                $('[data-chat-id="' + chatId + '"]', $(Chat.chat_right_side))
                    .addClass('active')
                    .show();

                $('.profile-users', $chatContainer)
                    .removeClass('active')
                    .hide();
                $('#profile-' + chatId)
                    .addClass('active')
                    .show();
            }

            $('.sold_btn', $mainContainer).data('info', info);
        },
        sendMessage                   : function (e, clickedElement = null) {
            e.preventDefault();

            let $button    = clickedElement ? $(clickedElement) : $(this);
            let $container = $button.parents('.chat-right-wrapper.active');
            let $input     = $('.message-input', $container);
            let message    = $input.val();
            let chatId     = $container.data('chatId');
            let token      = $('[name="csrf-token"]').attr('content');

            $.ajax({
                type   : 'POST',
                url    : '/AddMessage',
                data   : {
                    message: message,
                    chat_id: chatId,
                    _token : token,
                },
                success: function (data) {
                    console.log(data);
                    if (data.status == 'success') {
                        $input.val('');

                        $('.chat', $container).append(data.html);

                        Chat.scrollChatDown();
                    }
                }
            });
        },
        hideDeleting                  : function (e) {
            e.preventDefault();

            let $button    = $(this);
            let $container = $button.closest('.chat-right-wrapper');

            $button.hide();
            $(".message-item", $container).removeClass("checkbox-active");
            $(".m-action-item.delete-chat", $container).show();
            $(".m-action-item.m-item-delete, .m-action-item.m-select-all", $container).removeClass("active");
            $('.m-action-item.chat-select', $container).show();
        },
        selectMessages                : function (e) {
            e.preventDefault();

            let $button    = $(this);
            let $container = $button.closest('.chat-right-wrapper');

            $button.hide();
            $(".message-item", $container).addClass("checkbox-active");
            $(".m-action-item.delete-chat", $container).hide();
            $(".m-action-item.m-item-delete, .m-action-item.m-select-all", $container).addClass("active");
            $(".m-action-item.hide-deleting", $container).show();
        },
        selectAllMessages             : function (e) {
            e.preventDefault();

            let $button    = $(this);
            let $container = $button.closest('.chat-right-wrapper');

            var checkboxes = $button.closest('.chat-container').find('.chat-right-wrapper.active :checkbox');
            checkboxes.each(function () {
                this.checked = "checked";
            });
        },
        deleteMessages                : function (e) {
            e.preventDefault();

            let $button    = $(this);
            let $container = $button.closest('.chat-right-wrapper');
            let $input     = $('.message-input', $container);
            // let messages = [32, 777];
            let messages   = [];
            $('.message-item', $container).each(function () {
                if ($('[type="checkbox"]', $(this)).prop('checked')) {
                    messages.push($(this).data('id'));
                }
            });
            // console.log(messages);
            let chatId = $container.data('chatId');
            // let token = $('[name="csrf-token"]').attr('content');

            // return;////////////////////////////////////////////////////////////////

            $.ajax({
                type   : 'POST',
                url    : '/DeleteMessages',
                data   : {messages: messages, chat_id: chatId, _token: Chat.token},
                success: function (data) {
                    // console.log(data);
                    if (data.status == 'success') {
                        // $('.chat', $container).append(data.html);

                        $.each(messages, function (index, value) {
                            $('.message-item[data-id="' + value + '"]', $container).remove();
                        });

                        // Chat.scrollChatDown();
                    }
                }
            });
        },
        checkUnreadMessages           : function (e) {
            setInterval(function () {
                let messages = [];
                $('.chat-right-wrapper.active .chat.active .message-item.person-message.unread').each(function () {
                    messages.push($(this).data('id'));
                });

                if (messages.length) {
                    Chat.markMessagesRead(messages, $('.chat-right-wrapper.active').data('product-id'));
                }
            }, Chat.read_message_timer);
        },
        markMessagesRead              : function (messages, productId) {
            if (messages.length) {
                $.ajax({
                    type   : 'POST',
                    url    : '/MarkMessagesRead',
                    data   : {
                        messages: messages,
                        _token  : Chat.token,
                    },
                    success: function (response) {
                        if (response.status === 'success') {
                            $('.chat-right-wrapper.active .chat.active .message-item.person-message.unread').removeClass('unread');

                            Chat.getUnreadMessagesCount();

                            let $messagesActiveTabUnreadMessagesCounter = $('.tab_btn_messages.active span.tab-messages-count');
                            if ($messagesActiveTabUnreadMessagesCounter.length) {
                                let tabUnreadMessagesCount = parseInt($messagesActiveTabUnreadMessagesCounter.text());
                                tabUnreadMessagesCount     = tabUnreadMessagesCount - response.data.read_messages_count;
                                console.log(tabUnreadMessagesCount, 'tab')

                                if (tabUnreadMessagesCount <= 0) {
                                    $messagesActiveTabUnreadMessagesCounter.remove();
                                } else {
                                    $messagesActiveTabUnreadMessagesCounter.text(tabUnreadMessagesCount);
                                }
                            }

                            let $conversationListItemUnreadMessagesCounter = $('li[data-product-id="' + productId + '"] span.unread-messages-count');
                            console.log($conversationListItemUnreadMessagesCounter);
                            if ($conversationListItemUnreadMessagesCounter.length) {
                                let unreadMessagesCount = parseInt($conversationListItemUnreadMessagesCounter.text());
                                unreadMessagesCount     = unreadMessagesCount - response.data.read_messages_count;
                                console.log(unreadMessagesCount);
                                if (unreadMessagesCount <= 0) {
                                    $conversationListItemUnreadMessagesCounter.remove();
                                } else {
                                    $conversationListItemUnreadMessagesCounter.html('<b>' + unreadMessagesCount + '</b>');
                                }
                            }
                        }
                    }
                });
            }
        },
        deleteChat                    : function (e) {
            e.preventDefault();

            let $button        = $(this);
            let $chatContainer = $button.closest('.chat-container');
            let $container     = $button.closest('.chat-right-wrapper');
            let chatId         = $container.data('chatId');
            let $mItem         = $('.m-list-items .m-item[data-chat-id="' + chatId + '"]', $chatContainer);
            let $profile       = $('#profile-' + chatId);

            $.ajax({
                type   : 'POST',
                url    : '/DeleteChat',
                data   : {chat_id: chatId, _token: Chat.token},
                success: function (data) {
                    if (data.status == 'success') {
                        if ($('.m-list-items .m-item', $chatContainer).length) {
                            $('.m-list-items .m-item', $chatContainer).eq(0).click();
                            $container.remove();
                            $mItem.remove();
                            $profile.remove();
                        } else {
                            window.location.reload();
                        }

                        // Chat.scrollChatDown();
                    }
                }
            });
        },
        sendFile                      : function () {
            console.log('sendFile');
            $('.MessageFile').fileupload({
                type    : 'POST',
                url     : '/AddFile',
                formData: {
                    chat_id: $(Chat.chat_item_active).data('chatId'),
                    _token : $('[name="csrf-token"]').attr('content')
                },
                done    : function (e, data) {
                    /*
                    if ($('.container-dialog .typing').length > 0)
                        $('.container-dialog .typing').before(data.result.html);
                    else
                        $('.container-dialog').append(data.result.html);
                    */
                    $(Chat.chat_item_active + ' .chat').append(data.result.html);
                    Chat.scrollChatDown();
                }
            });
        },
        scrollChatDown                : function () {
            let $content = $(Chat.chat_item_active + ' .messages-content');
            $content.animate({
                scrollTop: $('.chat', $content).height()
            }, 500);
        },
        getUnreadMessagesCount        : function () {
            setInterval(getUnreadMessagesCountAjaxCall, Chat.check_unread_messages_timer);

            function getUnreadMessagesCountAjaxCall() {
                $.ajax({
                    type   : 'POST',
                    url    : '/GetUnreadMessagesCount',
                    data   : {_token: Chat.token},
                    success: function (data) {
                        if (data.status == 'success') {
                            let $countContainer = $('.header_login_icons_menu .icon_wrpr.notification_icon.messages span');
                            if (data.unread_count) {
                                $countContainer.text(data.unread_count).show();
                            } else {
                                $countContainer.hide();
                            }
                        }
                    }
                });
            }
        },
        getMessages                   : function () {
            setInterval(function () {
                let $container = $('.chat-right-wrapper.active');
                let token      = $('[name="csrf-token"]').attr('content');

                $.each($container, function (index, element) {
                    let $containerElement = $(element);
                    let chatId            = $containerElement.data('chatId');

                    $.ajax({
                        type   : 'POST',
                        url    : '/GetMessages',
                        data   : {
                            chat_id: chatId,
                            _token : token
                        },
                        success: function (data) {
                            if (data.status == 'success') {
                                let doScroll = false;
                                jQuery.each(data.messages, function (i, val) {
                                    if ($('.chat .message-item[data-id="' + i + '"]', $containerElement).length == 0) {
                                        doScroll = true;
                                        $('.chat[data-chat-id="' + chatId + '"]', $containerElement).append(val);
                                    }
                                });

                                if (doScroll) {
                                    Chat.scrollChatDown();
                                }
                            }
                        }
                    });
                });
            }, Chat.get_message_timer);
        },
        searchUsers                   : function () {
            let value      = $(this).val().toLowerCase();
            let $container = $(this).closest('.chat-container');

            $('.m-list-items .m-item', $container).filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        },
        stopItem                      : function (e) {
            e.preventDefault();

            let $button = $(this);

            $.ajax({
                type   : 'POST',
                url    : '/pauseAds',
                data   : {adsId: $button.data('id'), _token: Chat.token},
                success: function (data) {
                    if (data.status == 'success') {
                        $button.hide();
                        $button.closest('.wrap_button').find('.resume_btn').show();
                    }
                }
            });
        },
        resumeItem                    : function (e) {
            e.preventDefault();

            let $button = $(this);

            $.ajax({
                type   : 'POST',
                url    : '/resumeAds',
                data   : {adsId: $button.data('id'), _token: Chat.token},
                success: function (data) {
                    if (data.status == 'success') {
                        $button.hide();
                        $button.closest('.wrap_button').find('.stop_btn').show();
                    }
                }
            });
        },
        sellItem                      : function (e) {
            e.preventDefault();

            let $button = $(this);
            let info    = $button.data('info');

            let $popup = $('#messages_sell_items_confirm_popup');

            $('.m_sell_item .img_wrpr img', $popup).prop('src', info.product_image);
            $('.m_sell_item .item_text .item_name', $popup).text(info.product_title);
            $('.m_sell_item .item_text .item_prod', $popup).text(info.product_brand);
            $('.m_sell_item .item_text .item_price', $popup).text(info.product_currency + info.product_price);
            $('.sell_items_confirm_middle .m_selected_confirm_text span', $popup).text(info.product_title);
            $('.sell_items_confirm_middle .m-selected-item .img-wrap img', $popup).prop('src', info.buyer_avatar);
            $('.sell_items_confirm_middle .m-selected-item .m-item-info .login', $popup).text(info.buyer_name);
            $('.confirm_total_earning span', $popup).text(info.product_currency + info.product_price);
            $('[name="ads_id"]', $popup).val(info.product_id);
            $('[name="buyer_id"]', $popup).val(info.buyer_id);

            $popup.find('form').attr('chat-id', info.chat_id);

            $.fancybox.open({
                src : '#messages_sell_items_confirm_popup',
                type: 'inline'
            });
        },
        confirmSelling                : function (e) {
            e.preventDefault();

            let $form   = $(this);
            let chatId  = $form.attr('chat-id');
            let adsId   = $('[name=ads_id]', $form).val();
            let buyerId = $('[name=buyer_id]', $form).val();

            let data = {
                ads_id        : adsId,
                meeting       : $('[name=meeting]', $form).val(),
                location      : $('[name=location]', $form).val(),
                content       : $('[name=content]:checked', $form).val(),
                buyer_id      : buyerId,
                type          : $('[name=type]:checked', $form).val(),
                seller_mark   : $('[name="rating"]:checked', $form).val(),
                seller_comment: $('textarea[name="seller_comment"]', $form).val(),
                _token        : Chat.token,
            };

            $.ajax({
                type    : 'POST',
                url     : '/activity',
                data    : data,
                dataType: 'json',
                success : function (response) {
                    $.fancybox.close();
                    if (response.success) {
                        let chatBlock = $('.chat-right-wrapper[data-chat-id="' + chatId + '"]');
                        chatBlock.find('.profile-info-stars').show().find('.star_item').each(function (i) {
                            if (i < data.seller_mark) {
                                $(this).addClass('active');
                            }
                        });

                        if (response.status === 'ads_seller_sell_request_sent') {
                            $('button.sell-item[data-ads_id="' + response.data.ads_id + '"]').remove();
                            $('.product_options_btns[data-product-id="' + response.data.ads_id + '"]').remove();
                        }
                    }

                    $.ajax({
                        type: 'POST',
                        url: 'update-add/' + adsId,
                        data: {
                            _token: Chat.token,
                            adsStatus: 'sold'
                        },
                        dataType: 'json',
                        error: function(error) {
                            alert('Could not update ads');
                        },
                        success: function(){
                            showNotification('Thanks for your review');
                        }
                    });
                },
                error   : function (error) {
                    let errorData = error.responseJSON;
                    if (errorData.error) {
                        $.fancybox.close();
                        showNotification(errorData.error);

                        if (errorData.status === 'ads_sold') {
                            $('button.sell-item[data-ads_id="' + errorData.data.ads_id + '"]').remove();
                        }
                    }
                }
            });
        },
        confirmSaleBuyer              : function (e) {
            e.preventDefault();

            let $button  = $(this);
            let activity = $button.data('activity');

            $.ajax({
                method  : "GET",
                url     : '/activity/' + activity,
                dataType: "json",
                success : function (response) {
                    var diff = (new Date()).getTime() - (new Date(response.data.created_at)).getTime();
                    var days = diff / (1000 * 3600 * 24);
                    if(response.data.buyer_mark > 0){
                        showNotification('Your review is already displayed.');
                    }else if(days >= 3){
                        showNotification('The review date has expired.');
                    }else{
                        $('#confirmSaleForm').attr('data-activity', activity);

                        $.fancybox.open({
                            src : '#confirmSale',
                            type: 'inline'
                        });
                    }
                }
            });
        },
        sendConfirmSaleBuyer          : function (e) {
            e.preventDefault();

            let form     = $(this);
            let activity = form.attr('data-activity');
            let rating   = form.find('[name="rating"]:checked').val();
            let button   = $('button[data-activity="' + activity + '"]');

            let data = {
                rating : rating,
                comment: form.find('[name="comment"]').val(),
                confirm: 'true',
                _method: 'patch',
                _token : Chat.token
            };

            $.ajax({
                method  : "POST",
                url     : '/activity/' + activity,
                data    : data,
                dataType: "json",
                success : function (data) {
                    if (data.success) {
                        // showNotification(data.success);
                        $.fancybox.close();

                        button.hide();

                        let ratings = button.closest('.wrap_button').find('.profile-info-stars');
                        ratings.show().find('.star_item').each(function (i) {
                            if (i < rating) {
                                $(this).addClass('active');
                            }
                        });

                        $.ajax({
                            method  : "GET",
                            url     : '/activity/' + activity,
                            dataType: "json",
                            success : function (response) {
                                window.location = "/profile/" + response.data.buyer_id + "/buyer";
                            }
                        });
                    } else {
                        //..
                    }
                },
                error   : function (error) {
                    let errorData = error.responseJSON;
                    if (errorData.error) {
                        $.fancybox.close();
                        showNotification(errorData.error);

                        if (errorData.status === 'ads_sold') {
                            $('button.confirm_sale_buyer_btn[data-activity="' + errorData.data.activity_id + '"]').remove();
                        }
                    }
                }
            });
        }
    };

    $(document).ready(function () {
        Chat.init();

        $(document).on('change', '.ratingActivity input', function () {
            let rating   = $(".ratingActivity input:checked").val();
            let activity = $(this).closest('fieldset').data('activity_id');

            rateActivity(rating, activity);
        });
        $('.tab_btn').click(function (e) {
            if ($(this).data('title') === 'selling') {
                $('.buying')
                    .removeClass('active')
                    .hide()
                ;
                $('.selling')
                    .addClass('active')
                    .show()
                ;
                $('[data-title="buying"]').removeClass('active');
                $('[data-title="selling"]').addClass('active');
                $('[data-button-section="buying"]').removeClass('active');
                $('[data-button-section="selling"]').addClass('active');
                $('[data-button-section="selling"] .tab_btn').removeClass('active');
                $('[data-button="all"]').addClass('active');
            }
            if ($(this).data('title') === 'buying') {
                $('.selling')
                    .removeClass('active')
                    .hide()
                ;
                $('.buying')
                    .addClass('active')
                    .show()
                ;
                $('[data-title="selling"]').removeClass('active');
                $('[data-title="buying"]').addClass('active');
                $('[data-button-section="selling"]').removeClass('active');
                $('[data-button-section="buying"]').addClass('active');
                $('[data-button-section="buying"] .tab_btn').removeClass('active');
                $('[data-button="all"]').addClass('active');
            }

            if ($(this).data('button') === 'available') {
                let buttonSection = $(this).parent().data('button-section');

                $('[data-button-section="' + buttonSection + '"] .tab_btn').removeClass('active');
                $(this).addClass('active');

                $('.accordion_item').each(function (index) {
                    if ($(this).hasClass(buttonSection) && ($(this).data('status') === 'available' || $(this).data('status') === 'payed')) {
                        $(this).addClass('active');
                    } else {
                        $(this).removeClass('active').hide();
                    }
                });
            }
            if ($(this).data('button') === 'sold') {
                let buttonSection = $(this).parent().data('button-section');

                $('[data-button-section="' + buttonSection + '"] .tab_btn').removeClass('active');
                $(this).addClass('active');

                $('.accordion_item').each(function (index) {
                    if ($(this).hasClass(buttonSection) && $(this).data('status') === 'sold') {
                        $(this).addClass('active');
                    } else {
                        $(this).removeClass('active').hide();
                    }
                });

            }
            if ($(this).data('button') === 'all') {
                let buttonSection = $(this).parent().data('button-section');

                $('[data-button-section="' + buttonSection + '"] .tab_btn').removeClass('active');
                $(this).addClass('active');

                $('.accordion_item').each(function (index) {
                    if ($(this).hasClass(buttonSection)) {
                        $(this).addClass('active');
                    } else {
                        $(this).removeClass('active').hide();
                    }
                });

            }
        })
    });
})(jQuery);

$(document).ready(function () {
    $(".product-item").on('click', function (event) {
        $(".customer-item").hide();
        $(".customer-item-" + $(this).attr('product_id')).show();
    });
});

function showNotification(msg) {
    $('#notification-alert .text-notification').html(msg);
    $('#notification-alert').show();
}

var rateActivity = function (rate = 5, activity) {
    let token = $('[name="csrf-token"]').attr('content');

    $.ajax({
        method  : "POST",
        url     : '/activity/' + activity,
        data    : {_token: token, _method: 'patch', mark: rate},
        dataType: "json",
        success : function (data) {
            if (data.success) {
                // showNotification(data.success);
            } else {
                // swal("Error", data.message, "error");
            }
        },
        error   : function (error) {
            console.log(error,);
            //alert("Error");

            if (error.responseJSON.error) {
                showNotification(error.responseJSON.error);
            }
        }
    });
};