var translationTable = $('#translationTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: 'getTranslationTable',
        data: function (d) {
            d.locale = $('#dropDownLanguage').find(":selected").val();
            d.group = $('#dropDownGroup').find(":selected").val();
        }
    },
    "order": [[ 0, "desc" ]],
    columns:[
        {data: "id"},
        {data: "group"},
        {data: "name"},
        {data: "englishText"},
        {
            "data": null,
            "searchable": false,
            "render": function(data, type, row, meta){ 
            return'<input type="text" name="translationText" id="txtTranslation'+ row.id +'" value="'+ row.text +'" class="form-control" class="txtTranslationText">'
            }
        },

        {
            "data": null,
            "searchable": false,
            "render": function(data, type, row, meta){ 
            return'<div><button style="height: 50px" type="button" class="col-md-12 btn btn-success btnUpdateTranslation" data-id="'+ row.id +'" data-languageType="'+ row.locale +'">Update</button>';
            }
        },

      ],

      "fnDrawCallback":function(){

        $('.btnUpdateTranslation').on('click', function(e) {

            if (confirm('Are you sure to update ?')) {

                var translationId = $(this).attr('data-id');
                var text = $('#txtTranslation'+ translationId +'').val();

                $.ajax({
                    type: "POST",
                    url: 'updateTranslation',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: ({ "translationId": translationId, "translationText": text }),
                    dataType: "html",
                    success: function(data) {

                        if(data.includes('1')){
                            alert('Update successful');
                            translationTable.ajax.reload(null, false);
                        }
                        else{
                            alert("Fail To Add");
                        }
                        
                    },
                    error: function() {
                        alert('Something Wrong ! Please Try Again');
                    }
                  });
            }
        });
      }
});

$("#dropDownGroup").change(function(e){
     translationTable.draw();
     var choosenLanguage = $("#dropDownLanguage option:selected").attr("data-language");
     $('#translationTable thead #txtLanguageDisplay').text('Text In ' + choosenLanguage);
     e.preventDefault();

});

$("#dropDownLanguage").change(function(e){
     translationTable.draw();
     var choosenLanguage = $("#dropDownLanguage option:selected").attr("data-language");
     $('#translationTable thead #txtLanguageDisplay').text('Text In ' + choosenLanguage);
     e.preventDefault();

});