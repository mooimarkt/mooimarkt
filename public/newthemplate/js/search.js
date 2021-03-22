jQuery(function ($) {
    if ($('#search_form').length > 0) {
        let $body = $('body');
        let $form = $('#search_form');
        let $form2 = $('#search_form2');
        let $form3 = $('#search_form3');
        let form = $form.get(0);
        let form2 = $form2.get(0);
        let form3 = $form2.get(0);
        console.log('main func');

        let $input = $(form.search);
        let $input2 = $(form2.search);
        let $submit = $(form.submit);
        let $submit2 = $(form2.submit);

        let $category_filter = $('#category_filter');

        let $notify = $form.find(".notify");
        let $sub_filt_cont = $('.sub-filter-container');

        let $recent_container = $('.recent_container');

        let $result_search = $('.result_search');
        let $result_search_b = $result_search.find("b");
        let $save_srch_btn = $('.save_srch_btn');

        let Timers = [0, 0];
        let Notified = localStorage.getItem("TagNotify") != null;
        let Loader = new TextLoader($submit);
        let Loader2 = new TextLoader($submit2);
        let LoaderSS = new TextLoader($save_srch_btn);
        let SaveSearch = new SimpleSave({}, $);
        let InQuey = {};

        if (typeof SubCategoryId != "undefined") {
            SubCategoryId = parseInt(SubCategoryId);
            SubCategoryId = isNaN(SubCategoryId) ? 0 : SubCategoryId;
            InQuey.subcat = SubCategoryId;
        }

        if (typeof CategoryId != "undefined") {
            CategoryId = parseInt(CategoryId);
            CategoryId = isNaN(CategoryId) ? 0 : CategoryId;

            InQuey.cat = CategoryId;
        }

        if (typeof SearchString != "undefined") {
            InQuey.s = SearchString;
        }

        let Search = new Finder({
            ads: {
                url: "/query/ads",
                query: InQuey
            }
        }, $);

        $submit.click(function () {
            let tags = $sub_filt_cont.find(".blue_btn");
            let val = $input.val();

            if (tags.length > 0 || val.length > 0) {
                Loader.setTitle("Searching");
                Loader.startLoading();
                clearResults();

                let query = {};

                $result_search_b.eq(0).html("-");
                $result_search_b.eq(1).html("");

                if (val.length > 0) {
                    query.s = val;
                    $result_search_b.eq(1).html(val);
                }

                if (tags.length > 0) {
                    query.tags = [];

                    tags.each(function () {
                        let html = $(this).find('span').html();

                        if (html.length > 0) {
                            query.tags.push(html);
                        }
                    });

                    $result_search_b.eq(1).html((val.length > 0 ? val + ": " : "") + query.tags.join(","));
                }

                if (typeof SubCategoryId != "undefined") {
                    query.subcat = SubCategoryId;
                }

                if (typeof CategoryId != "undefined") {
                    query.cat = CategoryId;
                }

                Search.Html(AdThemplate, Search.Get('ads', query))
                    .then(function (html) {
                        Loader.stopLoading();

                        $recent_container.html(html);
                    })
                    .catch(function (error) {
                        Loader.stopLoading();
                        Loader.showMesage(error);
                    });
            } else {
                Loader.showMesage("Empty search");
            }

        });

        $submit2.click(function () {
            let val = $input2.val();

            Loader2.setTitle("Searching");
            Loader2.startLoading();
            clearResults();

            let query = {};

            $result_search_b.eq(0).html("-");
            $result_search_b.eq(1).html("");

            if (val.length > 0) {
                query.s = val;
                $result_search_b.eq(1).html(val);
            }

            if ($('#FilterBrand').val().length > 0) {
                query.brand = $('#FilterBrand').val();
            }

            if ($('#FilterType').val().length > 0) {
                query.type = $('#FilterType').val();
            }

            if ($('#FilterModel').val().length > 0) {
                query.model = $('#FilterModel').val();
            }

            if (typeof SubCategoryId != "undefined") {
                query.subcat = SubCategoryId;
            }

            if (typeof CategoryId != "undefined") {
                query.cat = CategoryId;
            }

            Search.Html(AdThemplate, Search.Get('ads', query))
                .then(function (html) {
                    Loader2.stopLoading();

                    $recent_container.html(html);

                })
                .catch(function (error) {
                    Loader2.stopLoading();
                    Loader2.showMesage(error);
                });
        });

        $submit3.click(function () {
            clearResults();

            let query = {};

            if ($('#FilterBrand2').val().length > 0) {
                query.brand = $('#FilterBrand2').val();
            }

            if ($('#FilterType2').val().length > 0) {
                query.type = $('#FilterType2').val();
            }

            if ($('#MinYear').val().length > 0) {
                query.minyear = $('#MinYear').val();
            }

            if ($('#MaxYear').val().length > 0) {
                query.maxyear = $('#MaxYear').val();
            }

            if ($('#MinPrice').val().length > 0) {
                query.minprice = $('#MinPrice').val();
            }

            if ($('#MaxPrice').val().length > 0) {
                query.maxprice = $('#MaxPrice').val();
            }

            if ($('#Currency').val().length > 0) {
                query.currency = $('#Currency').val();
            }

            if ($('#MinMileage').val().length > 0) {
                query.minmileage = $('#MinMileage').val();
            }

            if ($('#MaxMileage').val().length > 0) {
                query.maxmileage = $('#MaxMileage').val();
            }

            if ($('#MileageType').val().length > 0) {
                query.mileage_type = $('#MileageType').val();
            }

            if ($('#MinEngine_size').val().length > 0) {
                query.minengine_size = $('#MinEngine_size').val();
            }

            if ($('#MaxEngine_size').val().length > 0) {
                query.maxengine_size = $('#MaxEngine_size').val();
            }

            if ($('input[name="transmission"]:checked').val().length > 0) {
                query.transmission = $('input[name="transmission"]:checked').val();
            }

            if ($('input[name="sale-wanted"]:checked').length > 0) {
                query.sale_type = $('input[name="sale-wanted"]:checked').val();
            }

            if ($('#previous_owners option:checked').val().length > 0) {
                query.previous_owners = $('#previous_owners option:checked').val();
            }

            if ($('#CountryFilter option:checked').length > 0) {
                query.country = $('#CountryFilter option:checked').text();
            }

            if ($('#CityFilter option:checked').length > 0) {
                query.city = $('#CityFilter option:checked').text();
            }

            if ($('#CountryRegisterFilter option:checked').length > 0) {
                query.country_registration = $('#CountryRegisterFilter option:checked').val();
            }

            query.car_type = $('input[name="car_type"]:checked').val();

            query.seller_type = $('input[name="seller_type"]:checked').val();

            query.colour = $('#Colour option:checked').val();

            query.fuel_type = $('input[name="FuelType"]:checked').map(function () {
                return this.value;
            }).get();

            query.body_type = $('input[name="BodyType"]:checked').map(function () {
                return this.value;
            }).get();

            query.doors = $('input[name="Doors"]:checked').map(function () {
                return this.value;
            }).get();

            query.doors = $('input[name="Doors"]:checked').map(function () {
                return this.value;
            }).get();

            if (typeof SubCategoryId != "undefined") {
                query.subcat = SubCategoryId;
            }

            if (typeof CategoryId != "undefined") {
                query.cat = CategoryId;
            }

            Search.Html(AdThemplate, Search.Get('ads', query))
                .then(function (html) {

                    $recent_container.html(html);

                })
                .catch(function (error) {
                });
        });

        $category_filter.click(function () {
            clearResults();

            let query = {};

            if ($('#brand').val().length > 0) {
                query.brand = $('#brand').val();
            }

            if ($('#size').val().length > 0) {
                query.size = $('#size').val();
            }

            if ($('#color').val().length > 0) {
                query.color = $('#color').val();
            }

            if ($('#condition').val().length > 0) {
                query.condition = $('#condition').val();
            }

            // if ($('#MinPrice').val().length > 0) {
            //     query.minprice = $('#MinPrice').val();
            // }
            //
            // if ($('#MaxPrice').val().length > 0) {
            //     query.maxprice = $('#MaxPrice').val();
            // }

            if ($('#price').val().length > 0) {
                query.price = $('#price').val();
            }

            if ($('#swap').val().length > 0) {
                query.swap = $('#swap').val();
            }

            // query.colour = $('#Colour option:checked').val();

            if (typeof SubCategoryId != "undefined") {
                query.subcat = SubCategoryId;
            }

            if (typeof CategoryId != "undefined") {
                query.cat = CategoryId;
            }

            Search.Html(AdThemplate, Search.Get('ads', query))
                .then(function (html) {
                    $recent_container.html(html);
                })
                .catch(function (error) {
                });
        });

        $save_srch_btn.click(function () {
            LoaderSS.setTitle("Saving");
            LoaderSS.startLoading();

            let Tags = [];

            $sub_filt_cont.find(".blue_btn").each(function () {
                let html = $(this).find('span').html();

                if (html.length > 0) {
                    Tags.push(html);
                }
            });

            SaveSearch.Create({
                s: $("#SearchTags").val(),
                tags: Tags,
                category: typeof CategoryId != "undefined" ? CategoryId : 0,
                sub_category: typeof SubCategoryId != "undefined" ? SubCategoryId : 0,
            })
                .then(function () {
                    LoaderSS.stopLoading();
                    LoaderSS.showMesage("Saved");

                })
                .catch(function (msg) {
                    LoaderSS.stopLoading();
                    LoaderSS.showMesage(msg);
                });
        });

        $form.on('submit', function (e) {
            e.preventDefault();
        });

        $input.on('keydown', function (e) {
            if (e.keyCode == 13) {
                AddTag();
            } else {
                showTagNotify();
            }
        });

        $body
            .on('click', '.blue_btn .close_sb_f', function () {
                $(this).parents('.blue_btn').remove();
            })
            .on('click', '.load-more', function () {
                console.log('load');
                let LoadMore = new TextLoader($(this));
                LoadMore.setTitle("Loading");
                LoadMore.startLoading();

                Search.Html(AdThemplate, Search.Next('ads'))
                    .then(function (html) {
                        LoadMore.stopLoading();

                        $('.load-more').remove();
                        $recent_container.append(html);

                    })
                    .catch(function (error) {
                        LoadMore.stopLoading();
                        LoadMore.showMesage(error);
                    });
            });


        function showTagNotify() {
            if (Notified) return;

            delayTagNotify();

            Timers[0] = setTimeout(function () {
                $notify.show();
                Notified = true;

                Timers[1] = setTimeout(function () {
                    $notify.fadeOut(500);
                }, 3000);
            }, 600);
        }

        function delayTagNotify() {
            if ($notify.is(":hidden")) {
                clearTimeout(Timers[0]);
                clearTimeout(Timers[1]);
            }
        }

        function AddTag() {
            var val = $input.val();

            if (val.length > 0) {
                var sval = val.replace(/\s/, "_").replace(/[^0-9a-zA-Z_]/g, "-").toLowerCase();

                if ($sub_filt_cont.find(".blue_btn[data-val^=" + sval + "]").length <= 0) {
                    $sub_filt_cont.append(`
                       <div class="blue_btn sub-filt-bl" data-val="${sval}">
                           <span>${val}</span>
                           <img class="close_sb_f" src="/newthemplate/img/close_filter.svg" alt="Remove">
                       </div>
                   `);
                }

                $input.val("");

                localStorage.setItem("TagNotify", 1);
            }
        }

        function clearResults() {
            $recent_container.find('.recent_block').remove();
        }

        function AdThemplate(res) {
            let html = "";

            $result_search_b.eq(0).html(res.total);

            if (res.data.length > 0 && Array.isArray(res.data)) {
                res.data.forEach(ad => {
                    let curr = "";

                    switch (ad.adsPriceType) {
                        case 'EUR':
                            curr = '€';
                            break;
                        case 'GBP':
                            curr = '£';
                            break;
                        case 'USD':
                            curr = '$';
                            break;
                        case 'CAD':
                            curr = 'C$';
                            break;
                        default:
                            curr = ad.adsPriceType;
                    }

                    html += `
                               <a href="https://moto.cgp.systems/add-details/${ad.id}" class="recent_block">
                                   <div class="rec_photo"><img src="${ad.adsImage == null ? "/newthemplate/img/logo.svg" : ad.adsImage}" alt="${ad.adsImage}"></div>
                                   <div class="rec_car_info">
                                       <div class="rec_name_car">${ad.adsName}</div>
                                       <div class="rec_country">${ad.adsCountry},${ad.adsRegion},${ad.adsCity}</div>
                                       <div class="rect_text_block info-list">
                                           <div class="rect_left_text">Certificate of Road</div>
                                       </div>
                                       <!--<div class="rect_text_block info-list">
                                           <div class="rect_left_text">Warthiness:</div>
                                           <div class="rect_right_text">No</div>
                                       </div>
                                       <div class="rect_text_block info-list">
                                           <div class="rect_left_text">Brand:</div>
                                           <div class="rect_right_text">Ford</div>
                                       </div>
                                       <div class="rect_text_block info-list">
                                           <div class="rect_left_text">Year:</div>
                                           <div class="rect_right_text">2018</div>
                                       </div>
                                       <div class="rect_text_block info-list">
                                           <div class="rect_left_text">Miege:</div>
                                           <div class="rect_right_text">200 km</div>
                                       </div>
                                       <div class="brief-information">
                                           Honda, CRF450, 2016, 26 hours
                                       </div>-->
                                   </div>
                                   <div class="rect_price">
                                       <div class="rect_price_left">
                                           <div class="rect_favorite"></div>
                                           <div class="favorite_text">Favorite</div>
                                       </div>
                                       <div class="rect_price_right">${curr}${ad.adsPrice.slice(0, -3)}</div>
                                   </div>
                               </a>`
                });

                if (res.next_page_url != null) {
                    html += "<a class='load-more'>Load More</a>"
                }
            }

            return html.length > 0 ? html : "<div class='no-results'>No results</div>";
        }

        var options = {
            url: function (phrase) {
                return "/get_title_ads";
            },

            getValue: function (element) {
                return element.name;
            },

            ajaxSettings: {
                dataType: "json",
                method: "POST",
                data: {
                    dataType: "json"
                }
            },

            preparePostData: function (data) {
                data.phrase = $("#SearchTags").val();

                return data;
            },
            /*
             list: {
             onClickEvent: function() {
             AddTag();
             }
             },*/

            requestDelay: 400
        };

        $("#SearchTags").easyAutocomplete(options);

        var options = {
            url: function (phrase) {
                return "/get_title_ads";
            },

            getValue: function (element) {
                return element.name;
            },

            ajaxSettings: {
                dataType: "json",
                method: "POST",
                data: {
                    dataType: "json"
                }
            },

            preparePostData: function (data) {
                data.phrase = $("#SearchTags2").val();
                data.brand = $("#FilterBrand").val();
                data.type = $("#FilterType").val();
                data.model = $("#FilterModel").val();

                return data;
            },
            /*
             list: {
             onClickEvent: function() {
             AddTag();
             }
             },*/

            requestDelay: 400
        };

        $("#SearchTags2").easyAutocomplete(options);
    }

    var options_index = {
        url: function (phrase) {
            return "/get_title_ads";
        },

        getValue: function (element) {
            return element.name;
        },

        ajaxSettings: {
            dataType: "json",
            method: "POST",
            data: {
                dataType: "json"
            }
        },

        preparePostData: function (data) {
            data.phrase = $("#SearchTagsIndex").val();

            return data;
        },

        requestDelay: 400
    };
    $("#SearchTagsIndex").easyAutocomplete(options_index);

    var options_index = {
        url: function (phrase) {
            return "/get_title_ads";
        },

        getValue: function (element) {
            return element.name;
        },

        ajaxSettings: {
            dataType: "json",
            method: "POST",
            data: {
                dataType: "json"
            }
        },

        preparePostData: function (data) {
            data.phrase = $("#SearchTagsIndex2").val();
            data.brand = $("#FilterBrand").val();
            data.type = $("#FilterType").val();
            data.model = $("#FilterModel").val();

            return data;
        },

        requestDelay: 400
    };
    $("#SearchTagsIndex2").easyAutocomplete(options_index);
});