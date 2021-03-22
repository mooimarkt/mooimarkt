$(document).ready(function() {

    var $private_checkbox = $('#private-checkbox');
    var $vat_input =  $("#vat-input");
    var $trader_checkbox =  $("#trader-checkbox");
    var $subscribe_block =  $("#subscribe-block");

    $(".place_price_block").click(function () {
        $(".place_price_block").removeClass("place_price_block_bl");
        $(this).addClass("place_price_block_bl");
    });

    $('.menu-button').click(function(e) {
		e.preventDefault();
		$(this).toggleClass('active');
		$('header .drop-down').toggleClass('active');
	});
    $(".menu-button").click(function () {
    $(".overlay-blok").toggleClass("shadow");
    })
      $('.accordion-header').click(function () {
      $(this).children('.arrow').toggleClass('active');
      $(this).parent().siblings().children('.accordion-header').children('.arrow').removeClass('active');
      
      $(this).next('.accordion-body').slideToggle('fast').toggleClass('active');
      $(this).parent().siblings().children('.accordion-body').slideUp('fast');
     });
        $('.accordion-header').click(function() {
        $(this).siblings(".accordion-header").slideToggle();
        $(this).parent().toggleClass('active-tab');
        $('.accordion-header').not($(this)).parent().removeClass('active-tab');
     });
    	$('ul.tabs li').click(function(){
		var tab_id = $(this).attr('data-tab');

		$('ul.tabs li').removeClass('current');
		$('.tab-content').removeClass('current');

		$(this).addClass('current');
		$("#"+tab_id).addClass('current');
	});
        $(window).scroll(function() {
        var height = $(window).scrollTop();
        if(height > 1){
        $('header').addClass('header-fixed');
        } else{
        $('header').removeClass('header-fixed');
        }

    });

    $private_checkbox.click(function () {

        this.checked = true;
        $trader_checkbox.get(0).checked = false;
        $vat_input.removeClass("active");
        $subscribe_block.fadeOut(400);

    });

  /* Click on checkbox "I am a trader" on "Profile-settings" page*/
    $trader_checkbox.click(function(){

        this.checked = true;
        $private_checkbox.get(0).checked = false;
        $vat_input.addClass("active");
        $subscribe_block.fadeIn(400);

  });

  /* Tabs on "My seved searches" page*/
  $(".tab_item").not(":first").hide();
  $(".tabs-wrapper .tab").click(function() {
    $(".tabs-wrapper .tab").removeClass("active").eq($(this).index()).addClass("active");
    $(".tab_item").hide().eq($(this).index()).fadeIn()
  }).eq(0).addClass("active");


  $('#ads_store').on('submit', function() {

      if (paid === false) {

         $('.data-plan h3').text($('input[name="adsSelectedType"]:checked').val());
         $('.data-plan h3').after($('input[name="adsSelectedType"]:checked').data('text'));
         $('.data-plan div').text('Price: '+$('input[name="adsSelectedType"]:checked').data('discont-price')+' EUR');

         $('#first_step').fadeOut();
         $('#second_step').fadeIn();
         setTimeout(function() {
            $("html, body").animate({ scrollTop: 0 }, 0);
         }, 300);
         $('#expdate').mask('00/00');
         amount = parseInt($('input[name="adsSelectedType"]:checked').data('discont-price'));
         $('#CreditCardForm input[name="amount"]').val(amount);
         return false;
      }

  });

  $('#profile-settings').on('submit', function() {
      if (paid === false && change_plan === true) {

         $('.data-plan h3').text($('input[name="subscription"]:checked').val());
         $('.data-plan h3').after($('input[name="subscription"]:checked').data('text'));
         $('.data-plan div').text('Price: '+$('input[name="subscription"]:checked').data('price')+' EUR');

         $('#first_step').fadeOut();
         $('#second_step').fadeIn();
         setTimeout(function() {
            $("html, body").animate({ scrollTop: 0 }, 0);
         }, 300);
         $('#expdate').mask('00/00');
         amount = parseInt($('input[name="adsSelectedType"]:checked').data('discont-price'));
         $('#CreditCardForm input[name="amount"]').val(amount);
         return false;
      }

  });

  $('input[name="subscription"]').on('change', function() {
      change_plan = true;

      if ($(this).val() == current_plan)
         change_plan = false;
  });

  $('#PayPalCheckout').on('click', function() {
      paid = true;
      $('#profile-settings').submit();
  });

  $('.pay').on('click', function() {
/*
      $.ajax({
         type: 'POST',
         url: '/pay_cc',
         data: $('#CreditCardForm').serialize(),
         success: function(data){

            if (data.status == 'success') {
               paid = true;
               $('#ads_store').submit();
            }

         }
      });
    */
  });

  $('#ShowNumberPhone').on('click', function() {

      if ($('#NumberPhone').css('display') == 'block') {
         $('#NumberPhone').fadeOut();
         $(this).text('Show Phone number');
      } else {
         $('#NumberPhone').fadeIn();
         $(this).text('Hide Phone number');
      }

      return false;
  });

  $('#SendMessage').on('click', function() {

      $.ajax({
         type: 'POST',
         url: '/GetChat',
         data: {_token: $('input[name="_token"]').val(), adId: $(this).data('id')},
         success: function(data){

            if (data.status == 'success') {
               window.location.href = '/dialog/'+data.id;
            }else{

               let msg = new TextLoader($('#SendMessage'));

                if(typeof data.code != "unedfined"){

                    switch (data.code){
                        case 1:
                            msg.showMesage("Please Auth.");
                            break;
                        case 2:
                            msg.showMesage("Ad not exists");
                            break;
                        case 3:
                            msg.showMesage("You can`t write yourself");
                            break;

                        default:
                            msg.showMesage("Unexpected error code");
                            break;
                    }

                }else{
                    msg.showMesage("Unexpected responce");
                }

            }

         }
      });

      return false;
  });

    $('.confirm').click(function() {
      var elem = $(this);
      var elements = {
          _method: "PATCH",
          confirm: elem.data('confirm'),
      };
      $.ajax({
          url: '/activity/' + $(this).data('activity_id'),
          type: 'PATCH',
          dataType: 'json',
          data: elements,
      })
      .done(function(data) {
          swal({
              title: data.success,
              icon: "success",
          });
          if (data.confirmed) {
            elem.parent().find('.confirm').hide().parent().find('.time_text_gray').toggleClass('time_text_gray time_text_green').text('confirmed');
          } else {
            elem.parent().find('.confirm').hide().parent().find('.time_text_gray').toggleClass('time_text_gray time_text_red').text('cancelled');
          }
      })
      .fail(function(res) {
          let html = document.createElement("div");
          for (let Field in res.responseJSON.errors) {
              html.innerHTML += (Field.slice(0, 1).toUpperCase()) + Field.slice(1) + ": " + (res.responseJSON.errors[Field].join(', ')) + "<br/>";
          }
          swal({
              title: "Error!",
              content: html,
              icon: "error",
          });
      });

      return false;
    });


    $('#currency').on('change', function () {
        var currency = $(this).val();
        if (currency) {
            window.location = '/currency?currency=' + currency;
        }
        return false;
    });

});     



function createReport(elemets = null) {

   let html = document.createElement("div");

   html.innerHTML = `
   <div id="createReport">
      <select class="swal-content__input" name="type">
         <option disabled${elemets.type ? '' : ' selected'}> -- select an type -- </option>
         <option value="Report"${elemets.type =='Report' ? ' selected' : ''}>Report</option>
         <option value="Spam"${elemets.type =='Spam' ? ' selected' : ''}>Spam</option>
         <option value="Invalid category"${elemets.type =='Invalid category' ? ' selected' : ''}>Invalid category</option>
         <option value="Prohibited product / service"${elemets.type =='Prohibited product / service' ? ' selected' : ''}>Prohibited product / service</option>
         <option value="Ad is not relevant"${elemets.type =='Ad is not relevant' ? ' selected' : ''}>Ad is not relevant</option>
         <option value="Fraud"${elemets.type =='Fraud' ? ' selected' : ''}>Fraud</option>
      </select>
      <input class="swal-content__input" name="adsId" type="hidden" value="${elemets.adsId ? elemets.adsId : ''}">
      <input class="swal-content__input" name="name" type="text" placeholder="Name" value="${elemets.name ? elemets.name : ''}">
      <input class="swal-content__input" name="email" type="email" placeholder="Email" value="${elemets.email ? elemets.email : ''}">
      <textarea class="swal-content__textarea" name="reason" placeholder="Reason" autofocus>${elemets.reason ? elemets.reason : ''}</textarea>

   </div>`;

   swal('Report this Ad',{
      content: html,
      className: 'swal-custom',
      buttons: [true, 'Report'],
   })
   .then((value) => {
      var data = {
         adsId: $('#createReport [name=adsId]').val(),
         name: $('#createReport [name=name]').val(),
         email: $('#createReport [name=email]').val(),
         reason: $('#createReport [name=reason]').val(),
         type: $('#createReport [name=type]').val(),
      };
      if (value) {
         $.ajax({
            url: '/ads/report',
            type: 'POST',
            dataType: 'json',
            data: data,
         })
         .done(function(res) {
            swal({
                className: 'swal-custom',
                title: res.success,
                icon: "success",
            });
         })
         .fail(function(res) {
            let html = document.createElement("div");
            for (let Field in res.responseJSON.errors) {
                html.innerHTML += (Field.slice(0, 1).toUpperCase()) + Field.slice(1) + ": " + (res.responseJSON.errors[Field].join(', ')) + "<br/>";
            }
            swal({
                title: "Error!",
                content: html,
                className: 'swal-custom',
                icon: "error",
            }).then((value) => {
                createReport(data);
            });
        });
      }
   });
}