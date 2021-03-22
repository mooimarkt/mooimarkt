$(document).ready(function () {
    if ($('.more-most-liked-home').length > 0)
        loadAds('most_liked', 5, '.more-most-liked-home');

    if ($('.more-newest-home').length > 0)
        loadAds('new', 5, '.more-newest-home');

    if ($('.more-most-liked').length > 0)
        loadAds('most_liked', 4, '.more-most-liked');

    $('.more-most-liked-home').on('click', function () {
        loadAds('most_liked', 5, '.more-most-liked-home');
    });

    $('.more-newest-home').on('click', function () {
        loadAds('most_liked', 5, '.more-newest-home');
    });

    $('.more-most-liked').on('click', function () {
        loadAds('most_liked', 4, '.more-most-liked');
    });

    function loadAds(type, per_page, button_class) {
        let page = ($(button_class).data('page') ? $(button_class).data('page') : 0) + 1;
        $(button_class).data('page', page);

        let category = $('#cur_category').val();
        let sub_category = $('#cur_sub_category').val();

        $.post('/ads-load', {
            page: page,
            type: type,
            per_page: per_page,
            category: category,
            sub_category: sub_category,
            _token: $('meta[name="csrf-token"]').attr('content')
        }).then(function (response) {
            if (response.data.last_page) $(button_class).hide();

            $(button_class + '-container').append(response.data.ads);
        });
    }
});