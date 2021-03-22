var $ = jQuery.noConflict();

$(document).ready(function () {



    // При открытии новой вкладки закрывает предыдущюю
    //  !function (i) {
    //      var o, n;
    //      i(".title_block").on("click", function () {
    //          o = i(this).parents(".accordion_item"), n = o.find(".info"),
    //              o.hasClass("active_block") ? (o.removeClass("active_block"),
    //                  n.slideUp()) : (o.addClass("active_block"), n.stop(!0, !0).slideDown(),
    //                  o.siblings(".active_block").removeClass("active_block").children(
    //                      ".info").stop(!0, !0).slideUp())
    //      })
    //  }(jQuery);

    // При открытии новой вкладки НЕ закрывает предыдущюю
    $('.title_block').click(function () {
        $(this).closest('.accordion_item').toggleClass('active_block').find('.info').slideToggle();
        $(this).closest('.accordion_item').find('.chat-right-wrapper').toggleClass('active');
    });

// // Show the first tab by default
//     $('.tabs-stage div').hide();
//     $('.tabs-stage div:first').show();
//     $('.tabs-nav li:first').addClass('tab-active');
//
// // Change tab class and display content
//     $('.tabs-nav a').on('click', function(event){
//         event.preventDefault();
//         $('.tabs-nav li').removeClass('tab-active');
//         $(this).parent().addClass('tab-active');
//         $('.tabs-stage div').hide();
//         $($(this).attr('href')).show();
//     });
});