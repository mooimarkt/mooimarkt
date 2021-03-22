$(document).ready(function() {
    if (filters_page == true) {
        console.log('Filters page');

        if ($('#FilterBrand_36').length > 0) {

            $('#FilterBrand_36').select2({
                ajax: {
                    url: '/ajax_filter',
                    dataType: 'json',
                    data: function (params) {
                        var result = {
                            type: 'brand',
                            term: (typeof params.term != null) ? params.term : null,
                            cat: cat_id
                        }

                        if (sub_id != false)
                            result.type_val_sub = sub_id;


                        return result;
                    }
                }
            });

            if ($('#FilterModel_36').length > 0)
                $('#FilterModel_36').select2({
                    ajax: {
                        url: '/ajax_filter',
                        dataType: 'json',
                        data: function (params) {
                            var result = {
                                type: 'model',
                                term: (typeof params.term != null) ? params.term : null,
                                brand: $('#FilterBrand_36').val(),
                                cat: cat_id,
                            }

                            if (sub_id != false)
                                result.type_val_sub = sub_id;

                            return result;
                        }
                    }
                });
        }

        if ($('#FilterBrand_41').length > 0) {

            $('#FilterBrand_41').select2({
                ajax: {
                    url: '/ajax_filter_parts',
                    dataType: 'json',
                    data: function (params) {
                        var result = {
                            type: 'brand',
                            term: (typeof params.term != null) ? params.term : null,
                            type_val_sub: $('select[data-filter-name="Vehicle Type"] option:checked').text()
                        }

                        return result;
                    }
                }
            });

            if ($('#FilterModel_41').length > 0)
                $('#FilterModel_41').select2({
                    ajax: {
                        url: '/ajax_filter_parts',
                        dataType: 'json',
                        data: function (params) {
                            var result = {
                                type: 'model',
                                term: (typeof params.term != null) ? params.term : null,
                                brand: $('#FilterBrand_41').val(),
                                type_val_sub: $('select[data-filter-name="Vehicle Type"] option:checked').text()
                            }

                            return result;
                        }
                    }
                });
        }

        if ($('#StrokeFilter').length > 0)
            $('#StrokeFilter').select2({
                ajax: {
                    url: '/ajax_filter_stroke',
                    dataType: 'json',
                    data: function (params) {
                        var result = {
                            term: (typeof params.term != null) ? params.term : null,
                            cat: cat_id,
                            sub: sub_id,
                        }

                        return result;
                    }
                }
            });


        if ($('#FrameMake').length > 0)
            $('#FrameMake').select2({
                ajax: {
                    url: '/ajax_filter',
                    dataType: 'json',
                    data: function (params) {
                        var result = {
                            type: 'framemake',
                            term: (typeof params.term != null) ? params.term : null,
                        }


                        return result;
                    }
                }
            });

        if ($('#EngineMake').length > 0)
            $('#EngineMake').select2({
                ajax: {
                    url: '/ajax_filter',
                    dataType: 'json',
                    data: function (params) {
                        var result = {
                            type: 'enginemake',
                            term: (typeof params.term != null) ? params.term : null,
                            brand: $('#FrameMake').val(),
                        }

                        return result;
                    }
                }
            });

        if ($('#FilterBrand_39').length > 0) {

            $('#FilterBrand_39').select2({
                ajax: {
                    url: '/ajax_filter',
                    dataType: 'json',
                    data: function (params) {
                        var result = {
                            type: 'brand',
                            term: (typeof params.term != null) ? params.term : null,
                            cat: cat_id,
                            group: $('#Group').val()
                        }

                        if (sub_id != false)
                            result.type_val_sub = sub_id;

                        return result;
                    }
                }
            });

            if ($('#FilterModel_39').length > 0)
                $('#FilterModel_39').select2({
                    ajax: {
                        url: '/ajax_filter',
                        dataType: 'json',
                        data: function (params) {
                            var result = {
                                type: 'model',
                                term: (typeof params.term != null) ? params.term : null,
                                brand: $('#FilterBrand_39').val(),
                                cat: cat_id,
                                group: $('#Group').val()
                            }

                            if (sub_id != false)
                                result.type_val_sub = sub_id;

                            return result;
                        }
                    }
                });

            $('body').on('change', '.side-filters #Group', function() {
                $('#FilterBrand_39').select2('enable');

                $('.add_brand').val('any');
                $('.add_brand').trigger('change');

                $('.add_model').val('any');
                $('.add_model').trigger('change');
                $('.add_model').select2('enable', false);
            });
        }

        $('body').on('change', '.add_brand', function() {
            if ($(this).val().length > 0)
                $('.add_model').select2('enable');

            $('.add_model').val('any');
            $('.add_model').trigger('change');
        });
    }



});