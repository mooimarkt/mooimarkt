$(function () {
    setFilter(getFilter());
    getProductsFilters(getFilter(), 8, true);

    $('form.header_search.catalog-search').submit(async function (e) {
        e.preventDefault();
        let self = this;

        $.ajax({
            url: '/check-search-type',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'search': $('input[name="search"]').val()
            },
            type: 'POST',
            dataType: 'JSON',
            success: function (data) {
                if (data.status == "success") {
                    if (data.data.typeSearch === 'users') {
                        location.replace('/search?' + $(self).serialize());
                    } else {
                        setFiltersURI();
                        getProductsFilters(getFilter(), 8, true);
                    }
                }
            }
        });
    });

    $('form.header_search.main-search').submit(function (e) {
        let self = this;

        $.ajax({
            url: '/check-search-type',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'search': $('input[name="search"]').val()
            },
            type: 'POST',
            dataType: 'JSON',
            success: function (data) {
                if (data.status == "success") {
                    if (data.data.typeSearch === 'ads') return;

                    e.preventDefault();
                    location.replace('/search?' + $(self).serialize());
                }
            }
        });
    });

    $('.filter-item .title').click(function () {
        let _this = $(this);
        let parent = _this.parent();

        _this.toggleClass('open');

        if (_this.hasClass('open')) {
            parent.find('.filter_content').addClass('active');
        } else {
            parent.find('.filter_content').removeClass('active');
        }

        parent.siblings('.filter-item').each(function () {
            $(this).find('.filter_content').removeClass('active');
        });
    });

    $('.filter_content').find('.list-colors > span, .items > span, .children_items > span').on('click', function () {
        $(this).find('input[type=checkbox]').trigger('click');
    }).children().click(function (e) {
        e.stopPropagation();
    });

    $('.filter_content .items span input[type="checkbox"]').change(function () {
        let checkbox = $(this);

        if (checkbox.is(':checked') && checkbox.parents('.parent_item').length > 0) {
            if (checkbox.data('action') === 'all') {
                checkbox.parent().siblings().each(function () {
                    $(this).find('input[type="checkbox"]').prop('checked', false);
                })
            } else {
                checkbox.parent().siblings().find('input[type="checkbox"][data-action="all"]').prop('checked', false);
            }
        }
        setFilter(getFilter());
        setFiltersURI();
        getProductsFilters(getFilter(), 8, true);
    });

    $('.add-custom-brand').on('click', function () {
        $(this).parents('.filter_content').removeClass('active');
        $(this).parents('.filter-item').find('span.title').removeClass('open');

        setFilter(getFilter());
        setFiltersURI();
        getProductsFilters(getFilter(), 8, true);
    });

    $(document).on('click', '.tag-items .tag .remove', function () {
        let tag = $(this).parent();

        switch (tag.attr('data-type')) {
            case 'location':
                $('.filter_content.location_content').find('.location_item').removeClass('active');
                break;
            case 'price-to':
                $('input[name="price[to]"]').val('');
                break;
            case 'price-from':
                $('input[name="price[from]"]').val('');
                break;
            case 'other-brand':
                $('input[name="custom_brand"]').val('');
                break;
            default:
                $('.filter_content').find('.items input[type="checkbox"]:checked').each(function () {
                    let id_filter = tag.attr('data-id');
                    let value = tag.attr('data-value');

                    if ($(this).data('filter') == id_filter && $(this).val() == value) {

                        if ($(this).data('type') === 'color') {
                            $(this).parents('span').removeClass('active');
                        }

                        $(this).prop('checked', false);
                    }
                });
        }

        setFilter(getFilter());
        setFiltersURI();
        getProductsFilters(getFilter(), 8, true);
    });

    function getFilter() {
        let filters = [];
        $('.filter-item[data-filter="size"]').hide();
        $('.filter_content').each(function () {
            $(this).find('.items input[type="checkbox"]:checked').each(function () {
                let type = $(this).data('type');

                let data = {
                    type: type,
                    name: $(this).data('title'),
                    id_filter: $(this).data('filter'),
                    value: $(this).val()
                };

                switch (type) {
                    case 'color':
                        data.color = $(this).data('color');
                        break;
                    case 'type':
                        let size = $(this).parent().data('size');
                        $('.filter-item[data-id="' + size + '"]').show();
                        break;
                }

                filters.push(data);
            });


            if ($(this).hasClass('location_content')) {
                let location = $(this).find('.location_item.active');

                if (location.length > 0) {
                    let data = {
                        type: 'location',
                        name: location.text(),
                        value: location.data('value'),
                    };

                    filters.push(data);
                }
            }

            if ($(this).hasClass('price_content')) {
                let from = $(this).find('input[name="price[from]"]').val();
                let to = $(this).find('input[name="price[to]"]').val();

                from = Number.isNaN(parseInt(from)) ? 0 : parseInt(from);
                to = Number.isNaN(parseInt(to)) ? 0 : parseInt(to);

                if (from > to && to !== 0) {
                    filters.push({type: 'price-from', value: to});

                    $('input[name="price[from]"]').val(to);
                    $('input[name="price[to]"]').val('');
                } else {
                    if (from > 0) {
                        filters.push({type: 'price-from', value: from});
                    }

                    if (to > 0) {
                        filters.push({type: 'price-to', value: to});
                    }
                }
            }
        });

        let other_brand = $('input[name=custom_brand]');

        if (other_brand.length > 0) {
            if (other_brand.val().length > 0) {
                filters.push({type: 'other-brand', id_filter: other_brand.data('parent'), value: other_brand.val()});
            }
        }

        return filters;
    }

    function setFilter(filters) {
        let tags = '';

        $.each(filters, function (i, item) {
            switch (item.type) {
                case 'color':
                    tags += '<li class="tag" data-type="' + item.type + '" data-id="' + item.id_filter + '" data-value="' + item.value + '">' +
                        '<span style="padding: 7px 20px; background: ' + item.color + '"></span>' +
                        '<div class="remove"><img src="/mooimarkt/img/remove-icon.svg" alt=""></div>' +
                        '</li>';
                    break;
                case 'location':
                    tags += '<li class="tag" data-type="' + item.type + '" data-value="' + item.value + '">' + item.name + ' ' +
                        '<div class="remove"><img src="/mooimarkt/img/remove-icon.svg" alt=""></div>' +
                        '</li>';
                    break;
                case 'price-from':
                    tags += '<li class="tag" data-type="price-from" data-value="' + item.value + '">from $' + item.value + ' ' +
                        '<div class="remove"><img src="/mooimarkt/img/remove-icon.svg" alt=""></div>' +
                        '</li>';
                    break;
                case 'price-to':
                    tags += '<li class="tag" data-type="price-to" data-value="' + item.value + '">to $' + item.value + ' ' +
                        '<div class="remove"><img src="/mooimarkt/img/remove-icon.svg" alt=""></div>' +
                        '</li>';
                    break;
                case 'other-brand':
                    tags += '<li class="tag" data-type="other-brand" data-value="' + item.value + '">' + item.value + ' ' +
                        '<div class="remove"><img src="/mooimarkt/img/remove-icon.svg" alt=""></div>' +
                        '</li>';
                    break;
                default:
                    tags += '<li class="tag" data-id="' + item.id_filter + '" data-value="' + item.value + '">' + item.name + ' ' +
                        '<div class="remove"><img src="/mooimarkt/img/remove-icon.svg" alt=""></div>' +
                        '</li>';
            }
        });

        $('.tag-items').html(tags);
    }

    $('.location_item').on('click', function () {
        if (!$(this).hasClass('active')) {
            $(this).addClass('active');
            $(this).siblings().removeClass('active');
            $(this).parents('.location_content').removeClass('active');
            $(this).parents('.filter-item').find('span.title').removeClass('open');

            setFilter(getFilter());
            setFiltersURI();
            getProductsFilters(getFilter(), 8, true);
        }
    });

    function getFiltersURI(filters) {
        return encodeURIComponent(JSON.stringify(filters));
    }

    function setFiltersURI() {
        let filters = [];
        let location = '';
        let priceFrom = '';
        let priceTo = '';
        let otherBrand = '';
        let search = $('input[name="search"]').val();

        getFilter().forEach(function (tag) {
            switch (tag.type) {
                case 'location':
                    location = tag.value;
                    break;
                case 'price-from':
                    priceFrom = tag.value;
                    break;
                case 'price-to':
                    priceTo = tag.value;
                    break;
                case 'other-brand':
                    otherBrand = tag.value;
                    break;
                default:
                    filters.push(tag.value);
                    break;
            }
        });
        let filtersList = filters;
        filters = getFiltersURI(filters);

        let paramsStr = '?filters=' + filters + '&other_brand=' + otherBrand + '&location=' + location + '&price_from=' + priceFrom + '&price_to=' + priceTo + '&search=' + search;
        insertParams(paramsStr, filtersList);
    }

    $('.fancybox-open').click(function (e) {
        e.preventDefault();

        let src = $(this).attr('data-src');

        $.fancybox.close();
        $.fancybox.open({
            src: '#' + src,
            type: 'inline'
        });
    });

    $('a[data-toggle="subcategory"]').mouseover(function (e) {
        e.preventDefault();

        let _this = $(this);
        let parent = _this.parents('li');

        _this.toggleClass('open');

        if (_this.hasClass('open')) {
            _this.addClass('active');
            _this.siblings('.sub_category_content').addClass('active');
        } else {
            _this.removeClass('active');
            _this.siblings('.sub_category_content').removeClass('active');
        }

        parent.siblings('li').each(function () {
            $(this).find('a').removeClass('active').removeClass('open');
            $(this).find('.sub_category_content').removeClass('active');
        });
    });
    $('a[data-toggle="subcategory"]').mouseout(function (e) {
        e.preventDefault();
        let _this = $(this);

        _this.removeClass('open');
    });

    $(document).mouseup(function (e) {
        // Main menu
        let div = $('.sub_category_content');
        let link = $('a[data-toggle="subcategory"]');

        if (!div.is(e.target) && div.has(e.target).length === 0 && !link.is(e.target)) {
            div.removeClass('active');
            link.removeClass('active').removeClass('open');
        }
    });

    $(document).mouseup(function (e) {
        // Filter
        let div = $('.filter_content');
        let link = $('.filter-item > span');

        if ((!div.is(e.target) && div.has(e.target).length === 0) && (!link.is(e.target) && link.has(e.target).length === 0)) {
            let active = $('.filter_content.active');

            if (active.hasClass('price_content')) {
                setFilter(getFilter());
                setFiltersURI();
                getProductsFilters(getFilter(), 8, true);
            }
            div.removeClass('active');
            link.removeClass('open');
        }
    });

    $('span.parent_main').click(function () {
        let parent = $(this).parent();
        parent.find('.children_items').show();
        let back = parent.parent().find('.back');

        back.find('label').text($(this).data('title'));
        back.css({'display': 'flex', 'font-weight': 'bold'});
        $(this).hide();
        parent.siblings('.parent_item').hide();
    });

    $('.filter_content .back svg').click(function () {
        let parent = $(this).parent();

        parent.hide();
        parent.find('label').text('');

        $('.children_items').hide();
        $('.parent_item').show().find('.parent_main').show();
    });
    $('span[data-intend="link"]').click(function () {
        $(this).find('a')[0].click();
    });

    $('span.category_item').click(function () {
        $(this).addClass('active');

        let category = $(this).data('id');

        $(this).parents('.sub_category').siblings('.catalogs').find('.catalogs-content').each(function () {
            if ($(this).data('id') === category) {
                $(this).addClass('active');
            } else {
                $(this).removeClass('active');
            }
        });

        $(this).siblings('span').each(function (index) {
            $(this).removeClass('active');
        });
    });

    $('#forgot-password-form').submit(function (e) {
        e.preventDefault();

        let form = $(this);
        let data = form.serializeArray();
        let validationBlock = $('.forgot-password-validation');

        validationBlock.css('background-color', 'transparent');
        validationBlock.find('ul li').remove();

        form.find('button[type=submit]').prop('disabled', true);
        form.find('button[type=submit]').text(translate('Loading...'));

        $.ajax({
            type: 'post',
            url: '/forgetPasswordAjax',
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                form.find('button[type=submit]').prop('disabled', false);
                form.find('button[type=submit]').text(translate('Send'));

                if (response.status === 'error') {
                    validationBlock.css('background-color', '#a94442');

                    if (response.data === undefined) {
                        validationBlock.find('ul').append('<li>' + translate(response.message) + '</li>');
                    } else {
                        $.each(response.data, function (i, message) {
                            validationBlock.find('ul').append('<li>' + message[0] + '</li>');
                        });
                    }
                }

                if (response.status === 'success') {
                    $.fancybox.close();

                    Swal.fire({
                        icon: 'success',
                        title: translate('Password recovery email was sent to your email'),
                        text: translate(response.message),
                        timer: 3000,
                    })
                }
            }
        });
    });

    $('#country').on('select2:select', function () {
        let country_id = $(this).find('option:selected').data('id');

        $.ajax({
            type: 'post',
            url: '/get-cities/' + country_id,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.success) {
                    $('#city').empty();
                    $.each(response.data, function (i, item) {
                        $('#city').append($('<option>', {
                            value: item.name,
                            text: item.name
                        }));
                    });

                    $('#city').trigger({
                        type: 'select2:select',
                    });
                }
            }
        });
    });

    $('#category').on('select2:select', function () {
        let category_id = $(this).find('option:selected').val();

        $.ajax({
            type: 'post',
            url: '/get-categories/' + category_id,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.success) {
                    $('#subCategories').empty();
                    $.each(response.data, function (i, item) {
                        $('#subCategories').append($('<option>', {
                            value: item.id,
                            text: item.subCategoryName
                        }));
                    });

                    $('#subCategories').trigger({
                        type: 'select2:select',
                    });
                }
            }
        });
    });

    $('#subCategories').on('select2:select', function () {
        let subCategory_id = $(this).find('option:selected').val();
        let locale = $('.header_language_dropdown').find('.active').data('lang');
        $.ajax({
            type: 'post',
            url: '/get-filters/' + subCategory_id + '/' + locale,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.success) {

                    $('.filters').empty()
                    $.each(response.data, function (i, item) {
                        let multiple = '';
                        if (item['template'] === 'color'
                            || item['template'] === 'material'
                            || item['template'] === 'size') {
                            multiple = 'multiple'
                        }

                        let filter;
                        switch (item['template']) {
                            case 'type':
                                filter = '<div class="form_group sub_filter_block">\n' +
                                    '<label class="text_label">' + item['name'] + '</label>\n' +
                                    '<select name="filters[' + i + ']" id="filters' + i + '" ' + multiple + ' class="sub_filter select2 select_two_select">\n' +
                                    '</select>\n' +
                                    '<p class="alert alert-danger"></p>\n' +
                                    '</div>';

                                $('.filters').append('' + filter + '');
                                break;
                            case 'brand':
                                filter = '<div class="form_group">\n' +
                                    '<label class="text_label">' + item['name'] + '</label>\n' +
                                    '<select name="filters[' + i + ']" id="filters' + i + '" ' + multiple + ' class="sub_filter_brand select2 select_two_select">\n' +
                                    '</select>\n' +
                                    '<p class="alert alert-danger"></p>\n' +
                                    '</div>';

                                $('.filters').append('' + filter + '');
                                break;
                            case 'color':
                                let items = '';
                                let option = '';

                                $.each(item['value'], function (key, item) {
                                    let color = '';
                                    switch (item[1]) {
                                        case 'light blue':
                                            color = '#add8e6';
                                            break;
                                        case 'rose':
                                            color = '#ff007f';
                                            break;
                                        case 'haki':
                                            color = '#78866b';
                                            break;
                                        case 'mustard':
                                            color = '#ffdb58';
                                            break;
                                        default:
                                            color = item[1];
                                    }

                                    items += '<span style="background: ' + color + '" data-id="' + item[0] + '"></span>';
                                    option += '<option value="' + item[0] + '"></option>';
                                });

                                filter = '<div class="form_group" data-filter="' + i + '">\n' +
                                    '<label class="text_label">' + item['name'] + '</label>\n' +
                                    '<div class="list-colors">' +
                                    items +
                                    '</div>' +
                                    '<select name="filters[' + i + ']" id="colors" style="display: none;" multiple>' +
                                    option +
                                    '</select>' +
                                    '<p class="alert alert-danger"></p>\n' +
                                    '</div>';

                                $('.filters').append('' + filter + '');
                                break;
                            default:
                                filter = '<div class="form_group">\n' +
                                    '<label class="text_label">' + item['name'] + ' </label>\n' +
                                    '<select name="filters[' + i + ']" id="filters' + i + '" ' + multiple + ' class="select2 select_two_select">\n' +
                                    '</select>\n' +
                                    '<p class="alert alert-danger"></p>\n' +
                                    '</div>';

                                $('.filters').append('' + filter + '');
                        }

                        $.each(item['value'], function (key, item) {
                            $('#filters' + i).append('<option value="' + item[0] + '">' + item[1] + '</option>');
                        });

                        $('#filters' + i).select2();
                    });
                }
            }
        });
    });

    $(document).on('click', '.list-colors span', function () {
        let id = $(this).attr('data-id');
        console.log($("#colors option[value=" + id + "]"))

        $(this).toggleClass('active');
        $("#colors option[value=" + id + "]").prop('selected', $(this).hasClass('active'));
    });
    var keyFilter = 0;
    $(document).on('change', '.sub_filter', function () {
        let self = this;
        let subFilterId = $(self).find('option:selected').val();
        if (subFilterId === '') {
            if ($(self).parent().find("div").is(".sub_sub_filter")) {
                $(self).parent().find('.sub_sub_filter').remove();
            }
        } else {
            $.ajax({
                type: 'post',
                url: '/get-sub-filters/' + subFilterId,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.success) {
                        if (response.data['value'].length == 0) {
                            console.log(1)
                            if ($(self).parent().find("div").is(".sub_sub_filter")) {
                                $(self).parent().find('.sub_sub_filter').remove();
                            }
                            return false;
                        }
                        if ($(self).parent().find("div").is(".sub_sub_filter")) {
                            $(self).parent().find('.sub_sub_filter').remove();
                        }
                        $(self).parent().append('' +
                            '<div class="form_group sub_sub_filter">\n' +
                            '  <br>' +
                            '  <label class="text_label">' + response.data['name'] + '</label>\n' +
                            '  <select name="filters[]" id="subFilters' + keyFilter + '" class="select2 select_two_select subSubFilters">\n' +
                            '  </select>\n' +
                            '  <p class="alert alert-danger"></p>\n' +
                            '</div>' +
                            '');

                        $.each(response.data['value'], function (key, item) {
                            $(self).parent().find('.subSubFilters').append('<option value="' + key + '" >' + item + '</option>');
                        });
                        $(document).find("#subFilters" + keyFilter).select2()
                        keyFilter++;
                    }
                }
            });
        }
    });

    $(document).on('change', '.sub_filter_brand', function () {
        var currentFilter = $("#otherCurrentBrand").val();
        let self = this;
        let subFilterBrandId = $(self).find('option:selected').val();
        if (subFilterBrandId === '') {
            if ($("div").is(".sub_sub_filter_brand")) {
                $('.sub_sub_filter_brand').remove();
            }
        } else {
            $.ajax({
                type: 'post',
                url: '/get-sub-filters-brand/' + currentFilter + '/' + subFilterBrandId,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.success) {
                        if (response.data['value'].length == 0) {
                            if ($("div").is(".sub_sub_filter_brand")) {
                                $('.sub_sub_filter_brand').remove();
                            }
                            return false;
                        }

                        if ($("div").is(".sub_sub_filter_brand")) {
                            $('.sub_sub_filter_brand').remove();
                        }

                        $(self).parent().append('' +
                            '<div class="form_group sub_sub_filter_brand">\n' +
                            '  <br>' +
                            '  <label class="text_label">' + translate("Other Brand") + '</label>\n' +
                            '  <input name="otherBrand[parentId]" value="' + response.data['value']['id'] + '" type="hidden" class="text_input validation" placeholder="Other Brand">' +
                            '  <input name="otherBrand[name]" value="' + response.data['value']['brand'] + '" type="text" class="text_input validation" placeholder="Other Brand">' +
                            '  <p class="alert alert-danger"></p>\n' +
                            '</div>' +
                            '');

                    }
                }
            });
        }
    });

    $('.more-ads').on('click', function () {
        getProductsFilters(getFilter(), 8);
    });

    $('.sort_by').change(function () {
        getProductsFilters(getFilter(), 8, true);
    });

    function getProductsFilters(filters, per_page, refresh = false) {
        let subCategoryId = $('#cur_sub_category').val();
        let categoryId = $('#cur_category').val();
        let page = ($('.more-ads').data('page') ? $('.more-ads').data('page') : 0) + 1;
        let sort = $('.sort_by').val();
        let search = $('input[name="search"]').val();

        if (refresh) {
            page = 1;
            $('.filters-ads > .card-item').remove();
        }
        $('.more-ads').data('page', page);

        $.ajax({
            type: 'post',
            url: '/get-products-filters',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                filters: filters,
                sort: sort,
                search: search,
                categoryId: categoryId,
                subCategoryId: subCategoryId,
                page: page,
                per_page: per_page,
            }
        })
            .then(function (response) {
                if (response.data.last_page) {
                    $('.more-ads').hide();
                } else {
                    $('.more-ads').show();
                }
                $('.filters-ads').append(response.data.ads);
                $('.results').text(response.data.countAds + ' ' + translate('results'))
            });
    }

    $('#delete-account').click(function (e) {
        e.preventDefault();

        Swal.fire({
            title: translate('Are you sure?'),
            text: translate("You won't be able to revert this!"),
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: translate('Yes, delete it!')
        }).then((result) => {
            if (result.value) {
                let uri = $(this).attr('href');

                location.replace(uri);
            }
        })
    });

    $('.blacklist_user_item .action').on('click', function () {
        let target = $(this).parent();
        let userId = target.attr('data-id');
        let action = target.attr('data-action');

        $.ajax({
            type: 'post',
            url: '/profile/settings/update-blocked-users',
            data: {id: userId, action: action},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.success) {

                    if (action === 'add') {
                        target.attr('data-action', 'remove');
                        target.find('.action').text('x');
                        $('.users-list').append(target);

                        if (($(".blacklist_empty").length > 0)) {
                            $(".blacklist_empty").hide();
                            $('.wrap_btn_form').show();
                        }

                    }

                    if (action === 'remove') {
                        target.attr('data-action', 'add');
                        target.find('.action').text('+');
                        $('.blacklists').append(target);
                    }
                }
            }
        });
    });

});
localStorage.removeItem('trans');

function translate(transText = '') {
    let trans;
    let convertTrans = convertToSlug(transText);
    let transArr = {};
    let localTranslate = localStorage.trans !== undefined ? JSON.parse(localStorage.trans) : {};

    if (localTranslate[convertTrans] !== undefined) {
        return localTranslate[convertTrans];
    } else {
        $.ajax({
            type: 'post',
            url: '/translate',
            async: false,
            data: {trans: transText},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.success) {
                    trans = response.data;
                    transArr[convertTrans] = response.data;
                    transArr = $.extend(transArr, localTranslate);
                    localStorage.trans = JSON.stringify(transArr);
                }
            }
        });

        return trans;
    }
}

function convertToSlug(text) {
    return text
        .toLowerCase()
        .replace(/ /g, '_')
        .replace(/[^\w-]+/g, '')
        ;
}

function insertParams(values, filters) {
    var newurl = '';

    newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + values;
    $('.parent_item').each(function (item) {
        let self = this;
        let filters_ids = $(this).data('ids');
        if (filters_ids !== undefined) {
            $(self).find('.parent_main').css({'font-weight': 'inherit'})
            filters.forEach(function (element) {
                if (filters_ids.includes(Number(element))) {
                    $(self).find('.parent_main').css({'font-weight': 'bold'})
                }
            });
        }
    });

    window.history.pushState({path: newurl}, '', newurl);
}

function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
}

$('.subSubFilters').select2();