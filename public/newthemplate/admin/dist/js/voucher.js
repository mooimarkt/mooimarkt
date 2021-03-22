jQuery(function ($) {

   let $body = $('body');
   let $delete_voucher = $('.delete_voucher');
   let $genarate = $('.genarate');
   let $voucherCode = $('.voucherCode');
   
   $delete_voucher.click(function () {
      $this = $(this);
      swal({
         title: "Are you sure?",
         icon: "warning",
         buttons: {
            cancel: true,
            confirm: {
               text: "Delete",
               closeModal: false,
            }
         },
         dangerMode: true,
      }).then((value) => {
         if (value) {
            $.ajax({
               url: '/admin/voucher/' + $(this).data('voucher_id'),
               type: 'POST',
               dataType: 'json',
               data: { _method: 'delete'},
            }).done(function(data) {
               swal({
                  title: data.success,
                  icon: "success",
               });
               $this.closest('tr').hide();
            }).fail(function(res) {
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
         }
      });
   });

   $genarate.click(function() {
      var text = "";
      var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"; //abcdefghijklmnopqrstuvwxyz

      for (var i = 0; i <= 10; i++)
         text += possible.charAt(Math.floor(Math.random() * possible.length));

      $voucherCode.val(text);

   });

});