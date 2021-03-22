$(document).ready(function() {
    let $form = $('#lang-form');

    $form.on('submit', function(e) {
        e.preventDefault();

        let Langs = {};

        $('#lang-form select').each(function(i,elem) {
            Langs[$(elem).data('id')] = $(elem).val();
        });

        $.ajax({
             type: 'POST',
             url: '/admin/languages/save',
             data: {_token: $('input[name="_token"]').val(), langs: Langs},
             success: function(data){

                if (data.status == 'success') {

                    swal("Success", "Status updated", "success");

                }else{

                    swal("Error", data.message, "error");

                }

             }
        });
    });
});