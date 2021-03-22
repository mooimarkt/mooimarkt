$(document).ready(function () {

    $('.form-payment-card').submit(function (e) {
        e.preventDefault();

        let form = $(this);
        let data = form.serializeArray();

        form.find('input[type=submit]').prop('disabled', true);
        form.find('input[type=submit]').val('Loading...');

        $.each(form.find('.error_input_text'), function () {
            $(this).hide().text('');
        });

        $.ajax({
            type: 'post',
            url: '/payment-card',
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                form.find('input[type=submit]').prop('disabled', false);
                form.find('input[type=submit]').val('Submit Payment');

                switch (response.status) {
                    case 'error':
                        $.each(response.data, function (i, value) {
                            $('input[name='+i+']').siblings('.error_input_text').show().text(value[0]);
                        });
                        break;
                    case 'error_payment':
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: response.message
                        });
                        break;
                    case 'success':
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            confirmButtonText: 'OK',
                            preConfirm: () => {
                                location.reload();
                            }
                        });
                        break;
                    default:
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Error Payment!'
                        });
                }
            }
        });
    });

    $('.form-payout-card').submit(function (e) {
        e.preventDefault();

        let form = $(this);
        let data = form.serializeArray();

        form.find('input[type=submit]').prop('disabled', true);
        form.find('input[type=submit]').val('Loading...');

        $.each(form.find('.error_input_text'), function () {
            $(this).hide().text('');
        });

        $.ajax({
            type: 'post',
            url: '/payout-card',
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                form.find('input[type=submit]').prop('disabled', false);
                form.find('input[type=submit]').val('Submit Payout');

                switch (response.status) {
                    case 'error':
                        $.each(response.data, function (i, value) {
                            $('input[name='+i+']').siblings('.error_input_text').show().text(value[0]);
                        });
                        break;
                    case 'error_balance':
                    case 'error_payout':
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: response.message
                        });
                        break;
                    case 'success':
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            confirmButtonText: 'OK',
                            preConfirm: () => {
                                location.reload();
                            }
                        });
                        break;
                    default:
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Error Payment!'
                        });
                }

            }
        });
    });


    $('.form-payout-paypal').submit(function (e) {
        e.preventDefault();

        let form = $(this);
        let data = form.serializeArray();
        let action = form.attr('action');

        form.find('input[type=submit]').prop('disabled', true);
        form.find('input[type=submit]').val('Loading...');

        $.each(form.find('.error_input_text'), function () {
            $(this).hide().text('');
        });

        $.ajax({
            type: 'post',
            url: action,
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                form.find('input[type=submit]').prop('disabled', false);
                form.find('input[type=submit]').val('Payout PayPal');

                switch (response.status) {
                    case 'error':
                        $.each(response.data, function (i, value) {
                            $('input[name='+i+']').siblings('.error_input_text').show().text(value[0]);
                        });
                        break;
                    case 'error_balance':
                    case 'error_payout':
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: response.message
                        });
                        break;
                    case 'success':
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            confirmButtonText: 'OK',
                            preConfirm: () => {
                                location.reload();
                            }
                        });
                        break;
                    default:
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Error Payment!'
                        });
                }
            }
        });

    });

});