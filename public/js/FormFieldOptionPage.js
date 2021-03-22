var formOptionTable = $('#formOptionTable').DataTable({
    processing: true,
    serverSide: true,
    "ajax": "getFormFieldOptionTable",
    "order": [[ 0, "desc" ]],
    columns:[
        {data: "id"},
        {data: "fieldValueColumn"},
        {data: "parentName2"},
        {data: "fieldLevelColumn"},
        {data: "sort"},
        {
            "data": null,
            "searchable": false,
            "render": function(data, type, row, meta){ 
            return'<div><button style="height: 50px" type="button" class="col-md-12 btn btn-success btnUpdateFormFieldOption" data-target="#editModal" data-id="'+ row.id +'" data-fieldTitle="' + row.fieldTitle + '" data-parent="'+ row.fieldColumn + '"data-formValue="'+ row.value +'">Edit</button>';
            }
        },

        {
            "data": null,
            "searchable": false,
            "render": function(data, type, row, meta){ 
            return'<div><button style="height: 50px" type="button" class="col-md-12 btn btn-success btnDeleteFormFieldOption" data-target="#editModal" data-id="'+ row.id +'" data-fieldTitle="' + row.fieldTitle + '" data-parent="'+ row.fieldColumn + '"data-formValue="'+ row.value +'">Delete</button>';
            }
        },

      ],

      "fnDrawCallback":function(){
        $('.btnUpdateFormFieldOption').on('click', function(e) {
          //get the id or the row
            $('#modalFormFieldOption').modal('show');
            $('#modaltxtFormFieldOptionId').val($(this).attr('data-id'));
            $('#modaltxtFormFieldOptionParentField').val($(this).attr('data-parent'));
            $('#modaltxtFormFieldOptionOption').val($(this).attr('data-formValue'));
        });

        $('.btnDeleteFormFieldOption').on('click', function(e) {

          if (confirm('Are you sure delete ? This action cannot be undone')) {

            var formFieldOptionId = $(this).attr('data-id');

              $.ajax({
                type: "POST",
                url: 'deleteFormFieldOption',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: ({ "formFieldOptionId": formFieldOptionId }),
                dataType: "html",
                success: function(data) {

                  if(data.includes('1')){
                    alert('Delete successful');
                        $('#modalFormFieldOption').modal('hide');
                        formOptionTable.ajax.reload();
                  }
                  else{
                    alert("Fail To Delete");
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

$('#btnAddFormOptionValue').on('click', function(e) {

   if($('#dropDownSelectValue :selected').attr('value') == "null"){
        alert('Please Select Field First')
   }
   else if($('#dropDownOptionFieldId :selected').attr('value') != 0 && $('#dropDownSelectValue :selected').attr('value') == 0){
        alert('This Field Has Empty Parent ! Please Add the parent option first')
   }
   else{

      $('#btnAddFormOptionValue').attr("disabled", true);

        var value = $('#txtFormValue').val();
        var formFieldId = $('#dropDownOptionFieldId').find(':selected').attr('data-form-id');
        var parentId = $('#dropDownSelectValue').val();
        var sort = $('#txtFormOptionSort').val();

            $.ajax({
                type: "POST",
                url: 'addFormFieldOption',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: ({ "value":value, "formFieldId":formFieldId, "parentId":parentId, "sort":sort  }),
                success: function(data) {

                    if(data.success == "success"){

                        alert('Add successful');
                        formOptionTable.ajax.reload();
                        $('#modaltxtFormFieldOptionOption').val('');
                        $('#btnAddFormOptionValue').attr("disabled", false);
                        
                    }
                    else{
                      alert("This Category already exists");
                    }   
                },
                error: function() {
                    alert('Something Wrong ! Please Try Again');
                }
            });
   }  
});


$("#dropDownOptionFieldId").change(function(){

    var currentFormId = $('#dropDownOptionFieldId :selected').attr('value');
    var currentSubCategoryId = $('#dropDownOptionFieldId :selected').attr('data-subCategory-id');

        $.ajax({
            type: "GET",
            url: 'getFormOptionValue',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: ({ "currentFormId": currentFormId, "currentSubCategoryId": currentSubCategoryId }),
            success: function(data) {

                if(data.formFieldOption.length > 0){
                    $('#dropDownSelectValue').children().remove().end();

                    for(var i = 0; i < data.formFieldOption.length; i++){
                        $('#dropDownSelectValue').append('<option value="'+ data.formFieldOption[i].id +'">' + data.formFieldOption[i].value + " ("+data.formFieldOption[i].parentName+')</option>');
                    } 
                }
                else{
                    $('#dropDownSelectValue').children().remove().end();
                    $('#dropDownSelectValue').append('<option value="0">No Parent</option>')
                } 
            },
            error: function() {
                alert('Something Wrong ! Please Try Again');
            }
        });
});

$('#modalbtnUpdateFormFieldOption').on('click', function(e) {

  if (confirm('Are you sure you want to update this data ?')) {

    var formFieldOptionId = $('#modaltxtFormFieldOptionId').val();
    var value = $('#modaltxtFormFieldOptionOption').val();
    var sort = $('#modaltxtFormFieldOptionSort').val();

      $.ajax({
        type: "POST",
        url: 'updateFormFieldOption',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: ({ "formFieldOptionId": formFieldOptionId, "value": value, "sort": sort }),
        dataType: "html",
        success: function(data) {

          if(data.includes('1')){
            alert('Update successful');
                $('#modalFormFieldOption').modal('hide');
                formOptionTable.ajax.reload();
          }
          else{
            alert("This Option already exists");
          }
            
        },
        error: function() {
            alert('Something Wrong ! Please Try Again');
        }
      });
  }
});