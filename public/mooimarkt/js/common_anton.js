Dropzone.autoDiscover = false;
$(function () {
    $('.main_slider').slick({
        autoplay      : true,
        autoplaySpeed : 4000,
        infinite      : true,
        speed         : 1000,
        slidesToShow  : 1,
        slidesToScroll: 1,
        dots          : true,
        customPaging  : function (slider, i) {
            return '<button class="slider_dot"></button>';
        },
        arrows        : false,
    });
    ads_images            = [];
    let acceptedFileTypes = "image/*";
    var fileList          = new Array;
    let i                 = 0;

    $("#dropzone-cropping").dropzone({
        previewTemplate     : '<div class="dz-preview dz-file-preview">\n' +
            '<div class="dz-image">\n' +
            '    <img data-dz-thumbnail />\n' +
            '  <div class="dz-details">\n' +
            '    <div class="dz-filename" style="display: none"><span data-dz-name></span></div>\n' +
            '    <div class="dz-size" data-dz-size style="display: none"></div>\n' +
            '    <img data-dz-thumbnail />\n' +
            '  </div>\n' +
            '  <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>\n' +
            '  <div class="dz-success-mark"><svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">      <title>Check</title>      <defs></defs>      <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">        <path d="M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" stroke-opacity="0.198794158" stroke="#747474" fill-opacity="0.816519475" fill="#FFFFFF" sketch:type="MSShapeGroup"></path>      </g>    </svg></div>\n' +
            '  <div class="dz-error-mark" style="display: none"><span>✘</span></div>\n' +
            '  <div class="dz-error-message"><span data-dz-errormessage></span></div>\n' +
            '</div>\n' +
            '</div>',
        addRemoveLinks      : true,
        maxFiles            : 5,
        maxFilesize: 50,
        dictMaxFilesExceeded: "Maximum upload limit reached",
        acceptedFiles       : acceptedFileTypes,
        dictInvalidFileType : "upload only JPG/PNG",
        headers             : {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        transformFile       : function (file, done) {
            let myDropZone = this;

            let editor                   = document.createElement('div');
            editor.style.position        = 'fixed';
            editor.style.left            = 0;
            editor.style.right           = 0;
            editor.style.top             = 0;
            editor.style.bottom          = 0;
            editor.style.zIndex          = 9999;
            editor.style.backgroundColor = '#000';
            editor.className             = 'profile-modal';

            let rotate            = document.createElement('button');
            rotate.style.position = 'absolute';
            rotate.style.left     = '130px';
            rotate.style.top      = '10px';
            rotate.style.zIndex   = 9999;
            rotate.textContent    = 'rotate';
            rotate.className      = 'btn';
            rotate.addEventListener('click', function () {
                cropper.rotate(-90);
            });

            let confirm            = document.createElement('button');
            confirm.style.position = 'absolute';
            confirm.style.left     = '10px';
            confirm.style.top      = '10px';
            confirm.style.zIndex   = 9999;
            confirm.textContent    = 'Confirm';
            confirm.className      = 'btn';
            confirm.addEventListener('click', function () {
                if ($('#adsImages').length > 0) {
                    $('#adsImages').removeClass('text_input_validate');
                }

                var canvas = cropper.getCroppedCanvas();

                canvas.toBlob(function (blob) {
                    myDropZone.createThumbnail(
                        blob,
                        myDropZone.options.thumbnailWidth,
                        myDropZone.options.thumbnailHeight,
                        myDropZone.options.thumbnailMethod,
                        false,
                        function (dataURL) {
                            myDropZone.emit('thumbnail', file, dataURL);
                            done(blob);
                        }
                    );
                });

                editor.parentNode.removeChild(editor);
            });

            editor.appendChild(confirm);
            editor.appendChild(rotate);

            let image = new Image();
            image.src = URL.createObjectURL(file);
            editor.appendChild(image);

            document.body.appendChild(editor);

            let cropper = new Cropper(image, {
                aspectRatio: 4 / 3
            });
        },
        init                : function () {
            $(this.element).addClass("dropzone");

            this.on("success", function (file, serverFile) {
                $('#max_files_limit_reached').remove();
                fileList[i] = {
                    "serverFileName": serverFile.name,
                    "fileName"      : file.name,
                    "fileId"        : i
                };
                ads_images.push(serverFile.name);
                // You can add 10 more photos for free TEXT
                let youCanAddCount = (fileList.length) ? 5 - fileList.length : 0;
                $('.you_can_ add_text span').text(youCanAddCount);
                $('.dz-message').show();
                i += 1;
            });
            this.on("removedfile", function (file) {
                let rmvFile = "";
                for (let f = 0; f < fileList.length; f++) {
                    if (fileList[f].fileName == file.name) {
                        rmvFile = fileList[f].serverFileName;
                    }
                }

                if (rmvFile) {
                    $.ajax({
                        url    : '/delete-image', //your php file path to remove specified image
                        type   : "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data   : {
                            filenamenew: rmvFile,
                            type       : 'delete',
                        },
                        success: function (data) {
                            ads_images.remove(data.name)
                        }
                    });
                }
            });
            this.on("addedfile", function () {
                if (this.files[5]) {
                    this.removeFile(this.files[5]);
                }
            });
            this.on("maxfilesexceeded", function (file) {
                $('h3.you_can_add_text').append('<span id="max_files_limit_reached" style="color: red; padding-left: 5px;">(maximum upload limit reached)</span>');
            });
        }
    });

    $(".dz-remove").click(function () {
        var filenamenew = $(this).data('filenamenew')
        var imageid     = $(this).data('imageid')
        for (let f = 0; f < fileList.length; f++) {
            if (fileList[f].fileName == filenamenew) {
                filenamenew = fileList[f].fileName;
            }
        }
        if (filenamenew) {
            $.ajax({
                url    : '/delete-image', //your php file path to remove specified image
                type   : "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data   : {
                    filenamenew: filenamenew,
                    imageid    : imageid,
                    type       : 'delete',
                },
                success: function (data) {
                    ads_images.remove(data.name)
                    $('#' + data.id).remove()
                }
            });
        }
    })

    Array.prototype.remove = function (value) {
        var idx = this.indexOf(value);
        if (idx != -1) {
            return this.splice(idx, 1);
        }
        return false;
    }

    $(".input_file_btn").click(function () {
        let targetForm = $(this).data("target-form");
        $("#" + targetForm).click();
    });

    $('.select_two_select').select2();

    $(".textareat_limited").on('keyup', function (event) {
        let currentString = $(".textareat_limited").val()
        $(".textareat_limit_number span").text(currentString.length);
    });

    $(".close_notif_popup").click(function () {
        $(this).closest('.notification_popup_wrpr').hide();
    });

    /*$(document).on('click', '.my_items_dropdown_list span', function () {
        let targetData = $(this).data('items-target');
        $('.dropdown_tabs_title span').appendTo($('.my_items_dropdown_list'));
        $(this).prependTo($('.dropdown_tabs_title'));

        $('.my_items_controls_content').removeClass('active');
        $('.my_items_controls_content.' + targetData).addClass('active');

        $('.my_items_cards').removeClass('active');
        $('.my_items_cards.' + targetData).addClass('active');
    });*/


    let itemsControlsView = false;
    $(document).on('click', '.edit_items_btn', function (e) {
        removeItemBtn = '<button class="item_remove_btn"></button>';
        firstListBtn  = '<button class="first_list_btn" data-fancybox data-src="#first_listed_popup" href="javascript:;"></button>';
        editItemBtn   = '<button class="item_edit_btn"></a>';
        extendBtn     = '<button class="extend_product" data-fancybox data-src="#extend_product" href="javascript:;"></a>';

        if (!itemsControlsView) {
            $(".card-item .img-wrap").append(removeItemBtn);
            $(".card-item .img-wrap").append(firstListBtn);
            $(".card-item .img-wrap").append(editItemBtn);
            $(".card-item .img-wrap").append(extendBtn);
        } else {
            $(".item_remove_btn").remove();
            $(".first_list_btn").remove();
            $(".item_edit_btn").remove();
            $(".extend_product").remove();
        }

        itemsControlsView = !itemsControlsView;
        $(this).toggleClass('active');
    });

    $(document).on('click', '.item_remove_btn', function (e) {
        var productId = $(this).parent().data('id');
        $.ajax({
            url     : '/deleteProduct',
            data    : {"adsId": productId},
            headers : {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type    : 'POST',
            dataType: 'JSON',
            success : function (res) {

            }
        })
        $(this).closest('.card-item').remove();
        return false;
    });

    $(document).on('click', '.item_edit_btn', function (e) {
        var productId        = $(this).parent().data('id');
        window.location.href = "/edit-sell/" + productId
    });

    $(document).on('click', '.close_modal_btn', function (e) {
        $.fancybox.close();
        return false;
    });

    let firstListedBtnThis;
    $(document).on('click', '.first_list_btn', function (e) {
        firstListedBtnThis = $(this);
        if (firstListedBtnThis.parent().data('name') === undefined) {
            var name = firstListedBtnThis.data('name')
        } else {
            var name = firstListedBtnThis.parent().data('name')
        }
        if (firstListedBtnThis.parent().data('link') === undefined) {
            var link = firstListedBtnThis.data('link')
        } else {
            var link = firstListedBtnThis.parent().data('link')
        }
        $('#name-ads').html(name)
        $('#name-ads').attr("href", link)
    });

    $(document).on('click', '.first_listed_confirm_btn', function (e) {

        firstListedBtnThis.addClass('active');
        firstListedBtnThis.data('active');

        var adsId = firstListedBtnThis.data('id')
        if (adsId === undefined) {
            var adsId = firstListedBtnThis.parent().data('id');
        }
        $.ajax({
            url     : '/first-listed',
            data    : {"adsId": adsId},
            headers : {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type    : 'POST',
            dataType: 'JSON',
            success : function (data) {

            }
        });
        $.fancybox.close();
        return false;
    });

    let extendProduct;
    $(document).on('click', '.extend_product', function (e) {
        extendProduct = $(this);
    });

    $(document).on('click', '#extend_product_confirm_btn', function (e) {

        var adsId = extendProduct.data('id')
        if (adsId === undefined) {
            var adsId = extendProduct.parent().data('id');
        }
        $.ajax({
            url     : '/extend-product',
            data    : {"adsId": adsId},
            headers : {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type    : 'POST',
            dataType: 'JSON',
            success : function (data) {
                $('#notification-alert').show();
                $('.text-notification').html(translate(data.message));
                if (window.location.pathname == '/ads/expired') {
                    $('.img-wrap[data-id="' + adsId + '"]').parent().remove()
                }
            }
        });
        $.fancybox.close();
        return false;
    });


    $(document).on('click', '.messages_sell_items_next', function (e) {
        $.fancybox.close();
        $.fancybox.open({
            src : '#messages_sell_items_confirm_popup',
            type: 'inline'
        });
        return false;
    });

    $('#uploadButton').on('click', function () {
        $('#verborgen_file').click();
    });

    var temp_src = '';

    $("#my-awesome-dropzone2").dropzone({
        url                : "/store-media",
        maxFiles           : 1,
        acceptedFiles      : acceptedFileTypes,
        dictInvalidFileType: "upload only JPG/PNG",
        transformFile      : function (file, done) {
            let myDropZone_2 = this;

            let editor                   = document.createElement('div');
            editor.style.position        = 'fixed';
            editor.style.left            = 0;
            editor.style.right           = 0;
            editor.style.top             = 0;
            editor.style.bottom          = 0;
            editor.style.zIndex          = 9999;
            editor.style.backgroundColor = '#000';
            editor.className             = 'profile-modal';

            let rotate            = document.createElement('button');
            rotate.style.position = 'absolute';
            rotate.style.left     = '130px';
            rotate.style.top      = '10px';
            rotate.style.zIndex   = 9999;
            rotate.textContent    = 'rotate';
            rotate.className      = 'btn';
            rotate.addEventListener('click', function () {
                cropper.rotate(-90);
            });

            let confirm            = document.createElement('button');
            confirm.style.position = 'absolute';
            confirm.style.left     = '10px';
            confirm.style.top      = '10px';
            confirm.style.zIndex   = 9999;
            confirm.textContent    = 'Confirm';
            confirm.className      = 'btn';
            confirm.addEventListener('click', function () {
                var result = '';
                var canvas = cropper.getCroppedCanvas();
                canvas.toBlob(function (blob) {
                    temp_src = blob;
                    myDropZone_2.createThumbnail(
                        blob,
                        myDropZone_2.options.thumbnailWidth,
                        myDropZone_2.options.thumbnailHeight,
                        myDropZone_2.options.thumbnailMethod,
                        false,
                        function (dataURL) {
                            myDropZone_2.emit('thumbnail', blob, dataURL);
                            done(blob);
                        }
                    );
                });

                editor.parentNode.removeChild(editor);
            });

            editor.appendChild(confirm);
            editor.appendChild(rotate);

            let image = new Image();
            image.src = URL.createObjectURL(file);
            editor.appendChild(image);

            document.body.appendChild(editor);

            let cropper = new Cropper(image, {
                aspectRatio: 1
            });
        },
        init               : function () {
            this.on("success", function (file, serverFileName) {
                let bgData      = file.dataURL;
                let new_bg_data = temp_src.dataURL;
                $('.icon_profile').css('background-image', 'url("' + new_bg_data + '")');
                $('.icon_profile').addClass("bg_changed");
                $('#file_input_two').val(serverFileName.name);
            });
        }
    });

    $('.mob_menu_btn').on('click', function () {
        $(this).toggleClass("active");
        $('.header_nav').toggleClass("active");
        $('body').toggleClass("menu_open");
    });

    // Hide Header on on scroll down
    var didScroll;
    var lastScrollTop = 0;
    var delta         = 5;
    var navbarHeight  = $('header').outerHeight();

    $(window).scroll(function (event) {
        didScroll = true;
    });

    setInterval(function () {
        if (didScroll) {
            hasScrolled();
            didScroll = false;
        }
    }, 250);

    function hasScrolled() {
        var st = $(this).scrollTop();

        // Make sure they scroll more than delta
        if (Math.abs(lastScrollTop - st) <= delta)
            return;

        // If they scrolled down and are past the navbar, add class .nav-up.
        // This is necessary so you never see what is "behind" the navbar.
        if (st > lastScrollTop && st > navbarHeight) {
            // Scroll Down
            $('.header').addClass('hiden_height');
        } else {
            // Scroll Up
            if (st + $(window).height() < $(document).height()) {
                $('.header').removeClass('hiden_height');
            }
        }

        lastScrollTop = st;
    }

    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.scroll_to_top').addClass('active');
        } else {
            $('.scroll_to_top').removeClass('active');
        }
    });

    $('.scroll_to_top').click(function () {

        $("html, body").animate({
            scrollTop: 0
        }, "slow");
        return false;
    });

    var uaTwo   = window.navigator.userAgent;
    var isIETwo = /MSIE|Trident/.test(uaTwo);

    if (isIETwo) {
        document.documentElement.classList.add('ie');
    }

    $('#favorite_confirm').click(function (e) {
        e.preventDefault();
        var adsId = $(this).data('id');

        $.ajax({
            url     : '/favorite/toggle/' + adsId,
            headers : {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type    : 'POST',
            dataType: 'JSON',
            success : function (data) {
                var countFavorite = Number($('.favorites[data-id="' + data.id + '"]').find('.count').html())

                var countFavorite = Number($('.favorite-toggle[data-id="' + data.id + '"]').find('.count').html())
                // $('#notification-alert').show();
                // $('.text-notification').html(translate(data.message));
                $('.img-wrap[data-id="' + data.id + '"]').parent().remove()
                $.fancybox.close();
            }
        });
    })

    $(document).on('click', '.favorite', function (e) {
        e.preventDefault();

        let target = $(this);
        let adsId  = target.data('id');

        $.ajax({
            url     : '/favorite/toggle/' + adsId,
            headers : {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type    : 'POST',
            dataType: 'JSON',
            success : function (data) {
                if (data.success == 'success') {
                    target.find('.icon').toggleClass('active');
                    target.find('.count').html(data.count);
                }

                // $('.text-notification').html(translate(data.message));
                // $('#notification-alert').show();

                $.fancybox.close();
            }
        });
    });

    $(document).on('click', '.favorite-toggle', function (e) {
        var id = $(this).data('id')
        $('#favorite_confirm').data('id', id)
    });
});
