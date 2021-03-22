$(function () {

    var URL = window.URL || window.webkitURL;
    var $image = $('#image-cropper');
    var options = {
        aspectRatio: NaN,
        preview: '.preview'
    };
    var uploadedImageName = 'cropped.jpg';
    var uploadedImageType = 'image/jpeg';
    var uploadedImageURL;

    // Tooltip
    $('[data-toggle="tooltip"]').tooltip();

    // Import image
    var $inputImage = $('#inputImage');

    if (URL) {
        $inputImage.change(function () {
            var files = this.files;
            var file;

            if (files && files.length) {
                file = files[0];

                if (/^image\/\w+$/.test(file.type)) {
                    uploadedImageName = file.name;
                    uploadedImageType = file.type;

                    if (uploadedImageURL) {
                        URL.revokeObjectURL(uploadedImageURL);
                    }

                    uploadedImageURL = URL.createObjectURL(file);

                    $('.preview_i').hide();
                    $('#crop-preview').show();

                    if ($image.data('cropper')) {
                        $image.cropper('destroy').attr('src', uploadedImageURL).cropper(options);
                    } else {
                        $image.attr('src', uploadedImageURL).on({
                            ready: function (e) {
                                // console.log(e.type);
                            },
                            cropstart: function (e) {
                                // console.log(e.type, e.detail.action);
                            },
                            cropmove: function (e) {
                                // console.log(e.type, e.detail.action);
                            },
                            cropend: function (e) {
                                // console.log(e.type, e.detail.action);
                            },
                            crop: function (e) {
                                $('input[name=data_cropper]').val(JSON.stringify(e.detail));
                            },
                            zoom: function (e) {
                                // console.log(e.type, e.detail.ratio);
                            }
                        }).cropper(options);
                    }

                    $.fancybox.open({
                        src  : '#crop-image',
                        type : 'inline'
                    });
                } else {
                    window.alert('Please choose an image file.');
                }
            }
        });
    } else {
        $inputImage.prop('disabled', true).parent().addClass('disabled');
    }

    $('.custom-file-input').on('change', function () {
        $(this).parent().find('.custom-file-label').text($(this).val().split("\\").pop());
    });
});
