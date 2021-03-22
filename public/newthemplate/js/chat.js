$(document).ready(function () {
    $('body').on('keyup', '.emoji-wysiwyg-editor', function (event) {
        if (event.keyCode == 13) {
            $(this).blur();
            SendMessage();
            event.preventDefault();
            event.stopPropagation();
        }
    });

    $("#SendChat").on('click', function (event) {
        SendMessage();
        return false;
    });

    $('.upload').click(function () {
        $("input[type='file']").trigger('click');
    });

    $('.meet').click(function () {
        createActivity({
            'ads_id'  : $(this).data('ads'),
            'buyer_id': $(this).data('buyer'),
            'type'    : 'meet'
        })
    });

    $('.ship').click(function () {
        createActivity({
            'ads_id'  : $(this).data('ads'),
            'buyer_id': $(this).data('buyer'),
            'type'    : 'shipping'
        })
    });

    $('body').on('click', '.meet, .ship', function (event) {
        $('#datepicker').datetimepicker({});
    });

    function createActivity(elemets = null) {

        let html = document.createElement("div");

        html.innerHTML = `
      <div id="createActivity">
          <input class="swal-content__input" id="datepicker" name="meeting" placeholder="Date in YYYY-MM-DD HH:MM" type="text" value="${elemets.meeting ? elemets.meeting : ''}">
          <input class="swal-content__input" name="location" type="text" placeholder="Location" value="${elemets.location ? elemets.location : ''}">
          <textarea class="swal-content__textarea" name="content" placeholder="Comment">${elemets.content ? elemets.content : ''}</textarea>
          <input class="swal-content__input" name="ads_id" type="hidden" value="${elemets.ads_id ? elemets.ads_id : ''}">
          <input class="swal-content__input" name="buyer_id" type="hidden" value="${elemets.buyer_id ? elemets.buyer_id : ''}">
          <input class="swal-content__input" name="type" type="hidden" value="${elemets.type ? elemets.type : ''}">
      </div>`;

        swal(elemets.type == "meet" ? 'Meet Up' : "Ship it Out", {
            content: html,
            buttons: [true, elemets.type == "meet" ? 'Meet Up' : "Ship it Out"],
            onOpen : function () {
                $('#datepicker').datetimepicker({});
            },
        })
            .then((value) => {
                // console.log(elements);
                var elements = {
                    ads_id  : $('#createActivity [name=ads_id]').val(),
                    meeting : $('#createActivity [name=meeting]').val(),
                    location: $('#createActivity [name=location]').val(),
                    content : $('#createActivity [name=content]').val(),
                    buyer_id: $('#createActivity [name=buyer_id]').val(),
                    type    : $('#createActivity [name=type]').val()
                };
                if (value) {
                    $.ajax({
                        url     : '/activity',
                        type    : 'POST',
                        dataType: 'json',
                        data    : elements,
                    })
                        .done(function (data) {
                            swal({
                                title: data.success,
                                icon : "success",
                            });
                        })
                        .fail(function (res) {
                            let html = document.createElement("div");
                            for (let Field in res.responseJSON.errors) {
                                html.innerHTML += (Field.slice(0, 1).toUpperCase()) + Field.slice(1) + ": " + (res.responseJSON.errors[Field].join(', ')) + "<br/>";
                            }
                            swal({
                                title  : "Error!",
                                content: html,
                                icon   : "error",
                            }).then((value) => {
                                createActivity(elements);
                            });
                        });
                }
            });
    }

    $('.MessageFile').fileupload({
        type    : 'POST',
        url     : '/AddFile',
        formData: {chat_id: $('#ChatID').val(), _token: $('input[name="_token"]').val()},
        done    : function (e, data) {
            if ($('.container-dialog .typing').length > 0)
                $('.container-dialog .typing').before(data.result.html);
            else
                $('.container-dialog').append(data.result.html);
        }
    });

    function SendMessage() {
        $.ajax({
            type   : 'POST',
            url    : '/AddMessage',
            data   : {
                message: $('#MessageText').val(),
                chat_id: $('#ChatID').val(),
                _token : $('input[name="_token"]').val()
            },
            success: function (data) {
                console.log(data);
                if (data.status == 'success') {
                    $('#MessageText').val('');
                    $('.emoji-wysiwyg-editor').text('');
                    if ($('.container-dialog .typing').length > 0)
                        $('.container-dialog .typing').before(data.html);
                    else
                        $('.container-dialog').append(data.html);
                }
            }
        });
    }

    $(function () {
        // Initializes and creates emoji set from sprite sheet
        window.emojiPicker = new EmojiPicker({
            emojiable_selector: '[data-emojiable=true]',
            assetsPath        : '/img/emojii',
            popupButtonClasses: 'fa fa-smile-o'
        });
        // Finds all elements with `emojiable_selector` and converts them to rich emoji input fields
        // You may want to delay this step if you have dynamically created input fields that appear later in the loading process
        // It can be called as many times as necessary; previously converted input fields will not be converted again
        window.emojiPicker.discover();
    });

    if ($('#MessageText').length > 0)
        setInterval(function () {
            $.ajax({
                type   : 'POST',
                url    : '/GetMessages',
                data   : {chat_id: $('#ChatID').val(), _token: $('input[name="_token"]').val()},
                success: function (data) {

                    if (data.status == 'success') {

                        jQuery.each(data.messages, function (i, val) {
                            if ($('.container-dialog .message_box[data-id="' + i + '"]').length == 0) {
                                if ($('.container-dialog .typing').length > 0)
                                    $('.container-dialog .typing').before(val);
                                else
                                    $('.container-dialog').append(val);
                            }
                        });
                        if (data.is_typing) {
                            $('.typing p').fadeIn();
                        } else {
                            $('.typing p').fadeOut();
                        }

                    }
                }
            });
        }, 2000);

    var timer    = [0, 0];
    var isTimeOn = false;
    $('body').on('keypress', '.emoji-wysiwyg-editor', function (event) {
        if (!isTimeOn) {
            typing();
            isTimeOn = true;
            timer[0] = setInterval(typing, 1000);
        }
        clearTimeout(timer[1]);
        timer[1] = setTimeout(function (argument) {
            isTimeOn = false;
            clearInterval(timer[0]);
        }, 1000);
    });

    function typing() {
        $.ajax({
            type: 'POST',
            url : '/typing',
            data: {chat_id: $('#ChatID').val(), _token: $('input[name="_token"]').val()},
        });
    }

});