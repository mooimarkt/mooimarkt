/* favorite active*/
$(".recent_block ").click(function (e) {
    if ($(e.target).parents().hasClass("rect_price_left")) {
        e.preventDefault();
        $(this).find(".rect_favorite").toggleClass("favorite_active");
    }
})


/* mob slider categories*/
var swiper = new Swiper('.categories-slider', {
    nextButton: '.categ-arr-right',
    prevButton: '.categ-arr-left',
    slidesPerView: 8,
    loop: true,
    simulateTouch: false,
    breakpoints: {
        991: {
            slidesPerView: 6
        },
        767: {
            slidesPerView: 3
        },
       380: {
            slidesPerView: 2
        }
    }
});
/* mob tab index */
var screenWidth = window.innerWidth;

$(window).resize(function() {
    screenWidth = window.innerWidth;
    
});

let list_type = 'grid';
if ($.cookie('list_type') != 'undefined')
    list_type = $.cookie('list_type');

function swapView() {
    if (screenWidth < 768) {
        $(".recent-ads").toggleClass('recent-ads-double');
    }
}

$(document).ready(function($) {
    swapView();

    $(".ch_tab_1").click(function () {
        $(".ch_tab_1").addClass("active_svg_ic");
        $(".ch_tab_2").removeClass("active_svg_ic");
        $(".recent-ads").removeClass("recent-ads-double");
        list_type = 'grid';
        $.cookie('list_type', list_type, { expires: 7, path: '/' });
        swapView();
    });

    $(".ch_tab_2").click(function () {
        $(".ch_tab_1").removeClass("active_svg_ic");
        $(".ch_tab_2").addClass("active_svg_ic");
        $(".recent-ads").addClass("recent-ads-double");
        list_type = 'list';
        $.cookie('list_type', list_type, { expires: 7, path: '/' });
        swapView();
    });
});

/* slider details */
var swiper = new Swiper('.sw-con-det', {
    nextButton: '.arr_det_right',
    prevButton: '.arr_det_left',
    pagination: '.swiper-pagination',
    paginationType: 'fraction',
    loop: true,
});
/* DOWNOLOAD PHOTO */
$('#select_file').click(function () {
    $("input[type='file']").trigger('click');
})

$("input[type='file']").change(function () {
    $('#val_sel_file').text(this.value.replace(/C:\\fakepath\\/i, ''))
})    

/* select icon */
$(".serch_select").click(function () {
    $(this).next(".serch_drop_select").slideToggle(300);
})
$(".sel_img").click(function () {
    var img = $(this).attr("src");
    $(this).parent().parent().slideToggle(300);
    $(this).parent().parent().prev().children(".img_select").attr("src",img);
 
})
    /* MODAL*/

$(".open_modal").click(function () {
    if ($(this).hasClass('sign_up_modal')) {

       $('#auth-form-popup').css('display', 'none');
       $('#register-form-popup').css('display', 'block');
       $('.modal_block h6 span').text('Register');
    } else {
       $('#auth-form-popup').css('display', 'block');
       $('#register-form-popup').css('display', 'none');
       $('.modal_block h6 span').text('Login');
    }

    $(".modal_all_page").css("display", "block");

    return false;
})
$(".close_modal").click(function () {
    $(".modal_all_page").css("display", "none");
})

$(".register_page_modal_popup").click(function () {

    $('#auth-form-popup').css('display', 'none');
    $('#password-restore').css('display', 'none');
    $('#register-form-popup').css('display', 'block');
    $('.modal_block h6 span').text('Register');

    return false;
});

$(".login_page_modal_popup").click(function () {

    $('#auth-form-popup').css('display', 'block');
    $('#password-restore').css('display', 'none');
    $('#register-form-popup').css('display', 'none');
    $('.modal_block h6 span').text('Login');

    return false;
});

$(".restore_page_modal_popup").click(function () {

    $('#auth-form-popup').css('display', 'none');
    $('#password-restore').css('display', 'block');
    $('#register-form-popup').css('display', 'none');
    $('.modal_block h6 span').text('Login');

    return false;
});

$(".register_page_modal").click(function () {

    if (modal == 'login') {
       modal = 'register';
       $('#auth-form').css('display', 'none');
       $('#register-form').css('display', 'block');
       $('#login-section h6 span').text('Register');
    } else {
       modal = 'login';
       $('#auth-form').css('display', 'block');
       $('#register-form').css('display', 'none');
       $('#login-section h6 span').text('Login');
    }

    return false;
});


