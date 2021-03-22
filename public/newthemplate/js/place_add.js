jQuery(function ($) {

    var firstupload = true;
    var $body = $('body');
    var $bike_add = $('.bike_add');
    var $bike_addinp = $bike_add.find("input");
    var $location_autofill = $("#location_autofill");
    var $bike_addbtn = $bike_add.find("button");
    var $sub_filt_cont = $('.sub-filter-container');
    var $ads_store = $('#ads_store');
    var $adsImage = $('#adsImage');
    var $set_as_cover = $('.set_as_cover');
    var $pay_box_pay = $('.payment.box-card .pay_by_cc .pay');
    var $preview_add = $('#preview-add');
    var $save_draft = $('#save_draft');
    var $reset_form = $('#reset_form');
    var $voucher = $('#voucher');
    var $userId = $('#userId');
    var $postDetails = $('#postDetails');
    var $prices = $('input[data-price]');

    let Elav = new Elavon({}, $);
    let Prices = [];

    imgs = typeof imgs != "undefined" && imgs.length > 0 ? imgs : [];

    $prices.each(function () {

        Prices.push(parseFloat(this.dataset.price));

    });

    $userId.select2({
        ajax: {
            type: 'POST',
            url: '/admin/users/place_add',
            dataType: 'json',
            data: function (params) {
                var query = {
                    search: params.term,
                    page: params.page || 1
                }

                // Query parameters will be ?search=[term]&page=[page]
                return query;
            },
            processResults: function (data, params) {
                params.page = params.page || 1;

                return {
                    results: data.data,
                    pagination: {
                        more: (params.page * 10) < data.last_page
                    }
                };
            }
            // templateResult: formatRepo,
            // templateSelection: formatRepoSelection
        }
    });

    function formatRepo (repo) {
        if (repo.loading) {
            return repo.text;
        }

        var markup = "<div class='select2-result-repository clearfix'>" +
        "<div class='select2-result-repository__avatar'><img src='" + repo.owner.avatar_url + "' /></div>" +
        "<div class='select2-result-repository__meta'>" +
        "<div class='select2-result-repository__title'>" + repo.full_name + "</div>";

        if (repo.description) {
            markup += "<div class='select2-result-repository__description'>" + repo.description + "</div>";
        }

        markup += "<div class='select2-result-repository__statistics'>" +
        "<div class='select2-result-repository__forks'><i class='fa fa-flash'></i> " + repo.forks_count + " Forks</div>" +
        "<div class='select2-result-repository__stargazers'><i class='fa fa-star'></i> " + repo.stargazers_count + " Stars</div>" +
        "<div class='select2-result-repository__watchers'><i class='fa fa-eye'></i> " + repo.watchers_count + " Watchers</div>" +
        "</div>" +
        "</div></div>";

        return markup;
    }

    function formatRepoSelection (repo) {
        return repo.full_name || repo.text;
    }

    $postDetails.select2();

    $postDetails.change(function () {

        let pr = 0;

        $postDetails.find('option:selected')
            .each(function () {

                pr += parseFloat(this.dataset.price);

        });

        $prices.each(function (i) {

            this.dataset.price  = Prices[i] + pr;
            $(this).parents('.pl_pr_bot')
                .find('.pack_price').html(Prices[i] + pr);

        });

    });

    $reset_form.click(function () {


        $ads_store.find('input, textarea, select').val("");
        $('.set_as_cover .set_as_block').remove();
        $adsImage.val("");

        $('.place_tags .sub-filter-container .blue_btn').remove();
        $('.bike_add input').val("");
        $('#val_sel_file').html("Tap here to upload a photo");

    });

    $save_draft.click(function () {

        paid = true;
        $ads_store.submit();

    });

    $preview_add.click(function () {

        let Form = PostNGo({
            title:$('input[name=adsName]').val(),
            images:imgs.join(","),
            price:$('input[name="adsPrice"]').val(),
            description:$("*[name='adsDescription']").val(),
            location:$('#country_autocompl').val() + ", " + $("#region_autocompl").val() + ", " + $("#city_autocompl").val(),
            _token:$('meta[name="csrf-token"]').attr('content'),
            category:{
                id:$('#categoryId').val(),
                name:$('#categoryId option:selected').html(),
            },
            subcategory:{
                id:$('#subCategoryId').val(),
                name:$('#subCategoryId option:selected').html(),
            },
        });


    });

    $bike_addbtn.attr("type", "button");

    $pay_box_pay.click(function () {

        let Loader = new TextLoader($(this));

        Loader.setTitle("Paying");
        Loader.startLoading();
        let price = $('input[name="adsSelectedType"]:checked').data('price');

        Elav.Pay(price, Elav.Card({
            num: $('#cardnum').val(),
            exp: $('#expdate').val(),
            cvv: $('#cvv').val(),
            name: "sas",

        }))
            .then(function (res) {

                Loader.stopLoading();
                Loader.showMesage("Success");

                paid = true;
                $ads_store.submit();

            })
            .catch(function (msg) {

                Loader.stopLoading();
                Loader.showMesage("Error");

                swal({
                    text: "Error",
                    icon: "error",
                    content: (() => {

                        let cnt = document.createElement("div");
                        cnt.innerHTML = msg;

                        return cnt;

                    })()
                });

            });

    });

    $body
        .on('click', '.set_as_block .close_set_img', function () {

            let $parent = $(this).parents('.set_as_block');

            if ($set_as_cover.find('.set_as_block').length <= 1) {

                $adsImage.val("");

            }

            if ($parent.find('.text_set_block:contains(Cover)').length > 0) {

                $parent.remove();

                $set_as_cover.find('.set_as_block .text_set_block').click();

            } else {
                $parent.remove();
            }

            imgs = imgs.filter(path =>{

                if(this.previousElementSibling.src.indexOf(path) >= 0){
                    return false;
                }

                return true;

            })

        })
        .on('click', '.blue_btn .close_sb_f', function () {

            $(this).parents('.blue_btn').remove();

        });

    $bike_addinp.add($location_autofill).on('keydown', function (e) {

        if (e.keyCode == 13) {

            $ads_store.one('submit.prevent', function (e) {

                e.preventDefault();

            });

            AddTag();

        }

    });

    $bike_addbtn.click(function () {

        AddTag();

    });

    $('#fileupload').fileupload({
        dataType: 'json',
        dropZone: $('.block_dow_ph'),
        done: function (e, data) {
            $.each(data.result.images, function (index, image) {
                if (firstupload) {
                    $('#adsImage').val(image.imagePath)
                }
                imgs.push(image.imagePath);
                $('.set_as_cover').append(`
                            <div class="set_as_block">
                                <input type="hidden" name="adsImages[]" value="${image.id}">
                                <img class="rect_img_abs" src="${image.imagePath}" alt="${image.imagePath}" />
                                <div class="close_set_img"><img src="/newthemplate/img/close_img.svg" alt="Alternate Text" /></div>
                                <div class="text_set_block ${firstupload ? 'cover_butt' : ''}" onclick="changeCover(this)" data-src="${image.imagePath}">${firstupload ? 'Cover' : 'Set as cover'}</div>
                            </div>
                        `);
                firstupload = false;
            });
        }
    });

    $("#categoryId").change(function () {
        $.ajax({
            dataType: 'json',
            url: '/subCategories',
            data: {categoryId: $('#categoryId').val()},
            success: function (result) {
                $('#subCategoryId').empty();
                $.each(result, function (index, element) {
                    $('#subCategoryId').append('<option value="' + element.id + '" data-model="' + element.filtername + '">' + element.subCategoryName + '</option>');
                });
            },
            error: function (xhr, ajaxOptions, thrownError) {
                // $('#searchResult').html('Ajax error!');
            }
        });
    });

    $("#subCategoryId").change(function () {
      $('#FilterType').val($('#subCategoryId option:checked').data('model'));
    });

    // Select ads type Basic/Auto bump/Spotlight
    $(".place_price_block").click(function () {
        $(".place_price_block").removeClass("place_price_block_bl");
        $(this).addClass("place_price_block_bl");
    });

    // Chanege ads cover
    changeCover = function (element) {
        $('.text_set_block').text('Set as cover');
        $('.text_set_block').removeClass('cover_butt');
        $(element).text('Cover');
        $(element).addClass('cover_butt');
        $('#adsImage').val($(element).data('src'));
    };

    function AddTag() {

        var val = $bike_addinp.val();

        if (val.length > 0) {

            var sval = val.replace(/\s/, "_").replace(/[^0-9a-zA-Z_]/g, "-").toLowerCase();

            if ($sub_filt_cont.find(".blue_btn[data-val^=" + sval + "]").length <= 0) {

                $sub_filt_cont.append(`
                    <div class="blue_btn sub-filt-bl" data-val="${sval}">
                        <input type="hidden" name="adsTags[]" value="${val}">
                        <span>${val}</span>
                        <img class="close_sb_f" src="/newthemplate/img/close_filter.svg" alt="Remove">
                    </div>
                `);

            }

            $bike_addinp.val("");

        }

    }

    function PostNGo(Data,fo,depth) {

        let form =  typeof fo != "undefined" ? fo : document.createElement('form');

        if(typeof fo == "undefined"){

            form.target = "_blank";
            form.action = "/add-details-preview";
            form.method = "post";
            form.hidden = true;

        }

        for(let name in Data ){

            if(
                typeof Data[name]  == "string" ||
                typeof Data[name]  == "number"
            ){

                let inp = document.createElement('input');
                inp.type = "text";
                inp.value = Data[name];
                inp.name = typeof depth != "undefined" ? "["+(depth).join("][")+"]" + "["+name+"]" : name;
                inp.setAttribute("value",Data[name]);
                form.appendChild(inp);

            }

            if(
                typeof Data[name]  == "object" ||
                Array.isArray(Data[name])
            ){

                let nr = depth;

                if( Array.isArray(depth) ){
                    nr.push(name);
                }else{
                    nr = [name]
                }

                PostNGo(Data[name],form,nr);

            }

        }

        document.getElementsByTagName('body')[0].appendChild(form);

        form.submit();

        form.remove();

    }

    $voucher.change(function(event) {
        $.ajax({
            url: '/voucher/check',
            type: 'POST',
            dataType: 'json',
            data: {
                voucherCode: $(this).val()
            },
        })
        .done(function(data) {
            $.each(data, function(index, el) {
                $('label[for=adsSelectedType' + (index + 1) + '] .pl-pr-left span').text(el);
                $('#adsSelectedType' + (index + 1)).data('discont-price', el);
            });
        })
        .fail(function() {
            console.log('voucherCode not found or load error');
        });
        
    });

});