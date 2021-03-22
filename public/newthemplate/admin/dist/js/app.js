var $toggle_status = $('#toggle_status');

$toggle_status.click(function (e) {
  e.preventDefault();

  let vals = this.dataset.vals;
  let prev_el = this.previousElementSibling;
  let text = prev_el.textContent.replace(/(^\s+|\s+$)/gm,"");

  vals = vals.split(",");

  switch (this.dataset.tgl) {
      case "toggle":

          let i = vals.indexOf(text);
          i = i >= vals.length - 1 ? 0 : i + 1;
          prev_el.textContent = vals[i];

          break;
      case "select":

          if(prev_el.getElementsByTagName("select").length > 0){return;}

          let uid = "select_" + ((Date.now() + (Math.random())).toString(36).replace(/\./, Math.ceil(Math.random() * 100)));

          prev_el.innerHTML = `
              <select id="${uid}">
                  ${(vals.map((val,i) => { return `<option ${text==val ? "selected" : ""} value="${val}">${val}</option>` })).join("")}
              </select>
         `;

          let select = document.getElementById(uid);
          select.focus();
          select.click();
          select.onblur = new OnBlur(vals);

          function OnBlur(valss) {

              return function () {

                  let val = this.value;
                  val = parseInt(val);
                  val = isNaN(val) ? this.value : valss[val];

                  this.outerHTML = val;

              }

          }

          break;

  }


});

$('body').on('change','.toggle_status select',function () {

        let $This = $(this);
        let $Parent = $This.parents(".toggle_status");

        let Loader = new TextLoader($Parent.find("*[data-tgl]"));

        Loader.setTitle("Changing");
        Loader.startLoading();

        $.post("/admin/edit-page/" + ($Parent.data('aid') + '/changestatus'),{
            adsStatus:this.value
        }, function (resp) {

            Loader.stopLoading();

            if (resp.status == "success") {

                Loader.showMesage("Saved");

            } else {

                Loader.showMesage("Error");
                swal("Error", resp.message, "error");

            }


        }).fail(new PostFail(Loader))

    });

function PostFail(loader) {

  return function (res) {

      if (typeof loader == "object") {

          loader.stopLoading();
          loader.showMesage("Error");

      }

      if (
          typeof res.responseJSON == "object" &&
          typeof res.responseJSON.errors == "object"
      ) {

          let msg = "";

          for (let Field in res.responseJSON.errors) {

              msg += (Field.slice(0, 1).toUpperCase()) + Field.slice(1) + ": " + (res.responseJSON.errors[Field].join(', '));

          }

          swal("Error", msg, "error");


      } else {

          swal("Error", "Unexpected response", "error");
          console.error("Respose: ", res);

      }

  }

}

$('#fileuploadtrigger').click(function() {
    $('#fileupload').trigger( "click" );
});
$('#fileupload').fileupload({
    dataType: 'json',
    singleFileUploads: false,
    done: function (e, data) {
        location.reload();
    },
    fail: function (e, data) {
        swal(data);
    }
});

$('.clear_buton').click(function () {
  var el = $(this);
    $.ajax({
      type: 'POST',
      url: el.data('url'),
      data: { _method: 'delete'},
      success: function(data){
        el.closest('.owl-item').remove();
      }
    });
});

// Owl Carousel DOM Elements
var carousel1 = '.js-carousel-1';
var carousel2 = '.js-carousel-2';

// Initialize plugin
var owlCarousel1 = $(carousel1).owlCarousel({
  items: 1,
  dots: false,
});
var owlCarousel2 = $(carousel2).owlCarousel({
  items: 4,
  margin: 10,
  dots: false,
});

// Sync carousel & add current class
carouselSyncCurrentClass();

// On carousel change: Sync carousel & add current class
owlCarousel1.on('changed.owl.carousel', function() {
  carouselSyncCurrentClass();
});
owlCarousel2.on('changed.owl.carousel', function(event) {
  carouselSyncCurrentClass();
});

// Thumbs switch click event.
owlCarousel2.find('.item').click(function() {
  var itemIndex = $(this).parent().index();
  owlCarousel1.trigger('to.owl.carousel', itemIndex);
  carouselSyncCurrentClass();
});

function carouselSyncCurrentClass() {
  setTimeout(function() {
    var carousel1ActiveIndex = $('.js-carousel-1 .owl-item.active').index();
    $('.js-carousel-2 .owl-item').removeClass('current');
    var currentItem = $('.js-carousel-2 .owl-item:nth-child(' + (carousel1ActiveIndex + 1) + ')');
    currentItem.addClass('current');

    if (!currentItem.hasClass('active')) {
      if (currentItem.prevAll('.active').length > 0) {
        owlCarousel2.trigger('next.owl.carousel');
      }
      if (currentItem.nextAll('.active').length) {
        owlCarousel2.trigger('prev.owl.carousel');
      }
    }
  }, 100);
}

$(document).ready(function() {

    $("#categoryId").change(function () {
        $.ajax({
            dataType: 'json',
            url: '/subCategories',
            data: {categoryId: $('#categoryId').val()},
            success: function (result) {
                $('#subCategoryId').empty();

                $.each(result, function (index, element) {

                    $('#subCategoryId').append('<option value="' + element.id + '" data-model="' + (element.filtername == null ? element.subCategoryName : element.filtername) + '">' + element.subCategoryName + '</option>');

                });

                $('#subCategoryId').change();
            }
        });
    });

    $('#SaveCategoryAds').on('click', function() {
        $.ajax({
            method: 'POST',
            url: '/admin/edit_category_ad',
            data: {
                _token: $('input[name="_token"]').val(),
                categoryId: $('#categoryId').val(),
                subCategoryId: $('#subCategoryId').val(),
                id: $(this).data('id')
            },
            success: function (result) {
                if (result.status == 'success')
                    swal('Success', 'Category saved.', 'success')
                else
                    swal('Error', result.message, 'error');
            }
        });

    });

});