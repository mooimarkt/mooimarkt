$(document).ready(function () {
    $('#SaveUser').on('click', function () {
        $.ajax({
            type   : 'POST',
            url    : '/SaveUser',
            data   : {_token: $('input[name="_token"]').val(), userId: $(this).data('id'), action: 'create'},
            success: function (data) {
                if (data.status == 'success') {
                    let msg = new TextLoader($('#SaveUser'), {showTime: 300});
                    msg.showMesage("User Saved.");
                } else {
                    let msg = new TextLoader($('#SaveUser'), {showTime: 300});
                    msg.showMesage("Error");
                }
            }
        });
    });

    $('.rating_user').on('click', function () {
        var thisDiv = $(this);
        $.ajax({
            type   : 'POST',
            url    : '/rating_user',
            data   : {
                _token : $('input[name="_token"]').val(),
                user_id: $(this).data('id'),
                event  : $(this).data('event')
            },
            success: function (data) {
                if (data.status == 'success') {
                    $('span[data-event="like"]').text(data.like);
                    $('span[data-event="dislike"]').text(data.dislike);
                } else {
                    swal({
                        title: data.message
                    });
                }
            }
        });
    });
});