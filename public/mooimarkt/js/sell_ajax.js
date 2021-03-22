$(function () {
    $('#form-sell-button').click(function (e) {
        e.preventDefault();

       if(!$('#terms_conditions').prop('checked')){
           $('.checkbox_terms_conditions').addClass('terms_conditions_active')
            $.fancybox.close();

            return false;
        } else {
           $('.checkbox_terms_conditions').removeClass('terms_conditions_active')
       }

        $("#ads-images").val(ads_images);

        var adsName = $("input[name='adsName']").val();
        var adsImages = $("input[name='ads_images']").val();
        var adsDescription = $("textarea[name='adsDescription']").val();
        var categoryId = $("select[name='categoryId']").val();
        var subCategoryId = $("select[name='subCategoryId']").val();
        var adsPriceType = $("select[name='adsPriceType']").val();
        var adsPrice = $("input[name='adsPrice']").val();
        var original_price = $("input[name='original_price']").val();
        var swap = $("select[name='swap']").val();
        var otherBrandParentId = $("input[name='otherBrand[parentId]']").val();
        var otherBrandName = $("input[name='otherBrand[name]']").val();
        var location = $("input[name='location']").val();

        var filters = [];
        $.each($(".filters").find("select"), function (i, item) {
            filters.push($(this).val());
        });

        var classes = ["adsName", "adsImages", "adsDescription", "categoryId", "subCategoryId", "adsPriceType",
            "adsPrice", "swap", "otherBrandParentId", "otherBrandName", "location", "original_price"];
        $.ajax({
            url: '/add-sell',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                "adsName": adsName,
                "adsImages": adsImages,
                "adsDescription": adsDescription,
                "categoryId": categoryId,
                "subCategoryId": subCategoryId,
                "filters": filters,
                "adsPriceType": adsPriceType,
                "adsPrice": adsPrice,
                "original_price": original_price,
                "swap": swap,
                "otherBrand": [otherBrandParentId, otherBrandName],
                "location": location
            },
            type: 'POST',
            dataType: 'JSON',
            success: function (data) {
                if (data.status == 'errorValidation') {
                    $.fancybox.close();
                    var values = [];
                    $.each(classes, function (key, value) {
                        if (value in data.message) {
                            values.push(value);
                            $('.' + value).find('p').html(data.message[value][0])
                            $('.' + value).find('.validation').addClass('text_input_validate ')
                            $('.' + value).addClass('validate_select')

                        } else {
                            $('.' + value).find('p').html('')
                            $('.' + value).find('.validation').removeClass('text_input_validate')
                            $('.' + value).removeClass('validate_select')

                            if (values == 'adsImages') {
                                $('#adsImages').addClass('text_input_validate');
                            }
                        }

                    });
                    $('html, body').animate({
                        scrollTop: parseInt($("."+values[0]).offset().top - 200)
                    }, 200);
                } else if (data.status == 'error') {
                    $.fancybox.close();
                    $('#notification-alert').show();
                    $('.text-notification').html(translate(data.message));

                    $.each(classes, function (key, value) {
                        $('.' + value).find('p').html('')
                        $('.' + value).find('.validation').removeClass('text_input_validate')
                        $('.' + value).removeClass('validate_select')
                    });
                } else if (data.status === 'success') {
                    window.location.href = "/ads/published"
                } else {
                    console.log(data)
                }
            }
        });
    });

    $('#save_sell').click(function (e) {
        e.preventDefault();
        $("#ads-images").val(ads_images);

        var adsName = $("input[name='adsName']").val();
        var adsImages = $("input[name='ads_images']").val();
        var adsDescription = $("textarea[name='adsDescription']").val();
        var categoryId = $("select[name='categoryId']").val();
        var subCategoryId = $("select[name='subCategoryId']").val();
        var adsPriceType = $("select[name='adsPriceType']").val();
        var adsPrice = $("input[name='adsPrice']").val();
        var original_price = $("input[name='original_price']").val();
        var swap = $("select[name='swap']").val();
        var otherBrandParentId = $("input[name='otherBrand[parentId]']").val();
        var otherBrandName = $("input[name='otherBrand[name]']").val();
        var location = $("input[name='location']").val();

        var filters = [];
        $.each($(".filters").find("select"), function (i, item) {
            filters.push($(this).val());
        });
        var classes = ["adsName", "adsImages", "adsDescription", "categoryId", "subCategoryId", "adsPriceType",
            "adsPrice", "swap", "otherBrandParentId", "otherBrandName", "location", "original_price"];

        $.ajax({
            url: '/update-sell/' + $('#form-sell').data('id'),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                "adsName": adsName,
                "adsImages": adsImages,
                "adsDescription": adsDescription,
                "categoryId": categoryId,
                "subCategoryId": subCategoryId,
                "filters": filters,
                "adsPriceType": adsPriceType,
                "adsPrice": adsPrice,
                "original_price": original_price,
                "swap": swap,
                "otherBrand": [otherBrandParentId, otherBrandName],
                "location": location
            },
            type: 'POST',
            dataType: 'JSON',
            success: function (data) {
                if (data.status == 'errorValidation') {
                    $.fancybox.close();
                    var values = [];
                    $.each(classes, function (key, value) {
                        if (value in data.message) {
                            values.push(value);
                            $('.' + value).find('p').html(data.message[value][0])
                            $('.' + value).find('.validation').addClass('text_input_validate ')
                            $('.' + value).addClass('validate_select')
                        } else {
                            $('.' + value).find('p').html('')
                            $('.' + value).find('.validation').removeClass('text_input_validate')
                            $('.' + value).removeClass('validate_select')
                        }

                        if (values == 'adsImages') {
                            $('#adsImages').addClass('text_input_validate');
                        }
                    });
                    console.log(values)
                    $('html, body').animate({
                        scrollTop: parseInt($("."+values[0]).offset().top - 200)
                    }, 200);
                } else if (data.status == 'error') {
                    $.fancybox.close();
                    $('#notification-alert').show();
                    $('.text-notification').html(translate(data.message));

                    $.each(classes, function (key, value) {
                        $('.' + value).find('p').html('')
                        $('.' + value).find('.validation').removeClass('text_input_validate')
                        $('.' + value).removeClass('validate_select')
                    });
                } else if (data.status == 'success') {
                    window.location.href = "/ads/published"
                } else {
                    console.log(data)
                }
            }
        });
    });

    $('#terms_conditions').click(function() {
        $("#terms_conditions").toggle(this.checked);
    });
});
