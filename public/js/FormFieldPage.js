var formTable = $('#formTable').DataTable({
    processing: true,
    serverSide: true,
    "ajax": "getFormFieldTable",
    "order": [[ 0, "desc" ]],
    columns:[
        {data: "id"},
        {data: "fieldTitle"},
        {data: "parentName"},
        {data: "fieldLevelColumn"},
        {data: "fieldType"},
        {data: "filterType"},
        {data: "sort"},
        {data: "displaySort"},
        {
            "data": null,
            "searchable": false,
            "render": function(data, type, row, meta){ 
            return'<div><button style="height: 50px" type="button" class="col-md-12 btn btn-success btnEditFormField" data-target="#editModal" data-id="'+ row.id +'" data-fieldTitle="' + row.fieldTitle + '" data-fieldType="'+ row.fieldType + '"data-fieldLevel="'+ row.fieldLevel +'"data-parentFieldId="' + row.parentFieldId +'" data-sort="' + row.sort +'" data-filterType="' + row.filterType +'" data-displaySort="'+ row.displaySort +'">Edit</button>';
            }
        },

        {
            "data": null,
            "searchable": false,
            "render": function(data, type, row, meta){ 
            return'<div><button style="height: 50px" type="button" class="col-md-12 btn btn-success btnDeleteFormField" data-target="#editModal" data-id="'+ row.id +'" data-fieldTitle="' + row.fieldTitle + '" data-fieldType="'+ row.fieldType + '"data-fieldLevel="'+ row.fieldLevel +'"data-parentFieldId="' + row.parentFieldId +'" data-sort="' + row.sort +'">Delete</button>';
            }
        },

      ],

      "fnDrawCallback":function(){
        $('.btnEditFormField').on('click', function(e) {
          //get the id or the row
            $('#modalEditFormField').modal('show');
            $('#modaltxtFormFieldId').val($(this).attr('data-id'));
            $('#modaltxtFormFieldTitle').val($(this).attr('data-fieldTitle'));
            $('#modaltxtFormFieldSotring').val($(this).attr('data-sort'));
            $('#modalDropdownFilterType').val($(this).attr('data-filterType'));
            $('#modaltxtFormFieldDisplaySort').val($(this).attr('data-displaySort'));
        });

        $('.btnDeleteFormField').on('click', function(e) {

          if (confirm('Are you sure delete ? This action cannot be undone')) {

            var formFieldId = $(this).attr('data-id');

              $.ajax({
                type: "POST",
                url: 'deleteFormField',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: ({ "formFieldId": formFieldId }),
                dataType: "html",
                success: function(data) {

                  if(data.includes('1')){
                    alert('Delete successful');
                        $('#modalEditFormField').modal('hide');
                        formTable.ajax.reload();
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

var shareFormFieldTable = $('#shareFormFieldTable').DataTable({
    processing: true,
    serverSide: true,
    "ajax": "getShareFormFieldTable",
    "order": [[ 0, "desc" ]],
    columns:[
        {data: "id"},
        {data: "shareFromColumn"},
        {data: "subCategoryName"},
        {data: "fieldTitle"},
        // {
        //     "data": null,
        //     "searchable": false,
        //     "render": function(data, type, row, meta){ 
        //     return'<div><button style="height: 50px" type="button" class="col-md-12 btn btn-success btnEditFormField" data-target="#editModal" data-id="'+ row.id +'" data-fieldTitle="' + row.fieldTitle + '" data-fieldType="'+ row.fieldType + '"data-fieldLevel="'+ row.fieldLevel +'"data-parentFieldId="' + row.parentFieldId +'" data-sort="' + row.sort +'">Edit</button>';
        //     }
        // },

        {
            "data": null,
            "searchable": false,
            "render": function(data, type, row, meta){ 
            return'<div><button style="height: 50px" type="button" class="col-md-12 btn btn-success btnDeleteShareFormField backend-datatable-red-buttons" data-target="#editModal" data-id="'+ row.id +'" data-fieldTitle="' + row.fieldTitle + '" data-fieldType="'+ row.fieldType + '"data-fieldLevel="'+ row.fieldLevel +'"data-parentFieldId="' + row.parentFieldId +'" data-sort="' + row.sort +'">Delete</button>';
            }
        },

      ],

      "fnDrawCallback":function(){
        // $('.btnEditFormField').on('click', function(e) {
        //   //get the id or the row
        //     $('#modalEditFormField').modal('show');
        //     $('#modaltxtFormFieldId').val($(this).attr('data-id'));
        //     $('#modaltxtFormFieldTitle').val($(this).attr('data-fieldTitle'));
        //     $('#modaltxtFormFieldSotring').val($(this).attr('data-sort'));
        // });

        $('.btnDeleteShareFormField').on('click', function(e) {

          if (confirm('Are you sure delete ? This action cannot be undone')) {

            var subCategoryFieldId = $(this).attr('data-id');

              $.ajax({
                type: "POST",
                url: 'deleteShareFormField',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: ({ "subCategoryFieldId": subCategoryFieldId }),
                dataType: "html",
                success: function(data) {

                  if(data.includes('1')){
                    alert('Delete successful');
                        $('#modalEditFormField').modal('hide');
                        shareFormFieldTable.ajax.reload();
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

$('#btnFieldFormAdd').on('click', function(e) {

    $('#btnFieldFormAdd').attr("disabled", true);

    var subCategoryId = $('#dropDownCategory').val();
    var dropDownFieldLevel = $('#dropDownFieldLevel').val();
    var dropDownParentField = $('#dropDownParentField').val();
    var dropDownFieldType = $('#dropDownFieldType').val();
    var txtFieldTitle = $('#txtFieldTitle').val();
    var txtSorting = $('#txtFieldSorting').val();
    var dropDownFilterType = $('#dropDownFilterType').val();
    var displaySort = $('#txtFieldDisplaySort').val();

        $.ajax({
            type: "POST",
            url: 'addFormField',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: ({ "subCategoryId":subCategoryId, "fieldLevel":dropDownFieldLevel, "parentFieldLevel":dropDownParentField, "fieldTitle":txtFieldTitle, "fieldType":dropDownFieldType, "sort":txtSorting, "dropDownFilterType":dropDownFilterType, "displaySort":displaySort  }),
            success: function(data) {

                if(data.success == "success"){

                    alert('Add successful');
                    formTable.ajax.reload();
                    $('#btnFieldFormAdd').attr("disabled", false);
                    $('#txtFieldTitle').val('');
                    // $('#dropDownParentField').children().remove().end();
                    // $('#dropDownParentField').append('<option value="0">0</option>');
                    // $('#dropDownParentField option[value=0]').attr('selected','selected');
                    // $('#dropDownFieldLevel option[value=1]').attr('selected','selected');
                    $('#dropDownFieldType option[value=dropdown]').attr('selected','selected');
                    $('#txtFieldSorting').val('');
                }
                else{
                  alert("This Category already exists");
                }   
            },
            error: function() {
                alert('Something Wrong ! Please Try Again');
            }
        });
});


$("#dropDownFieldLevel").change(function(){

    var currentFieldLevel = $('#dropDownFieldLevel :selected').attr('value');
    var currentSubCategoryId = $('#dropDownCategory :selected').attr('value');

    var fieldLevel = parseInt(currentFieldLevel) - 1;

    if(fieldLevel > 0){

        $.ajax({
            type: "GET",
            url: 'getParentField',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: ({ "fieldLevel": fieldLevel, "currentSubCategoryId": currentSubCategoryId }),
            success: function(data) {

                if(data.success == "success"){
                    $('#dropDownParentField').children().remove().end();

                    if(data.parentFields.length > 0){

                        for(var i = 0; i < data.parentFields.length; i++){
                            $('#dropDownParentField').append('<option value="'+ data.parentFields[i].id +'">' + data.parentFields[i].subCategoryName + " : " + data.parentFields[i].fieldTitle + '</option>');
                        } 
                    }
                    else{
                        $('#dropDownParentField').append('<option value="0">0</option>');
                    }
                }
                
            },
            error: function() {
                alert('Something Wrong ! Please Try Again');
            }
        });
    }
    else{
        $('#dropDownParentField').children().remove().end();
        $('#dropDownParentField').append('<option value="0">0</option>');
    }

});

$("#dropDownCategory").change(function(){

    var currentFieldLevel = $('#dropDownFieldLevel :selected').attr('value');
    var currentSubCategoryId = $('#dropDownCategory :selected').attr('value');

    var fieldLevel = parseInt(currentFieldLevel) - 1;

    if(fieldLevel > 0){

        $.ajax({
            type: "GET",
            url: 'getParentField',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: ({ "fieldLevel": fieldLevel, "currentSubCategoryId": currentSubCategoryId }),
            success: function(data) {

                if(data.success == "success"){
                    $('#dropDownParentField').children().remove().end();

                    if(data.parentFields.length > 0){

                        for(var i = 0; i < data.parentFields.length; i++){
                            $('#dropDownParentField').append('<option value="'+ data.parentFields[i].id +'">' + data.parentFields[i].subCategoryName + " : " + data.parentFields[i].fieldTitle + '</option>');
                        } 
                    }
                    else{
                        $('#dropDownParentField').append('<option value="0">0</option>')
                    }
                }
                
            },
            error: function() {
                alert('Something Wrong ! Please Try Again');
            }
        });
    }

});

$("#dropDownToShareSubCategory").change(function(){

    var toSubCategoryId = $('#dropDownToShareSubCategory :selected').attr('value');

        $.ajax({
            type: "GET",
            url: 'toShareGetFormField',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: ({ "toSubCategoryId": toSubCategoryId }),
            success: function(data) {

                if(data.success == "success"){
                    $('#dropDownShareField').children().remove().end();

                    if(data.field.length > 0){

                        for(var i = 0; i < data.field.length; i++){
                            $('#dropDownShareField').append('<option value="'+ data.field[i].id +'">' + data.field[i].fieldTitle +'</option>');
                        } 
                    }
                    else{
                        $('#dropDownShareField').append('<option value="0">No Field For this Sub Category</option>')
                    }
                }
                
            },
            error: function() {
                alert('Something Wrong ! Please Try Again');
            }
        });

});

$('#modalbtnUpdateFormField').on('click', function(e) {

  if (confirm('Are you sure you want to update this data ?')) {

    var formFieldId = $('#modaltxtFormFieldId').val();
    var fieldTitle = $('#modaltxtFormFieldTitle').val();
    var sort = $('#modaltxtFormFieldSotring').val();
    var filterType = $('#modaldropDownFilterType').val();
    var displaySort = $('#modaltxtFormFieldDisplaySort').val();

      $.ajax({
        type: "POST",
        url: 'updateFormField',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: ({ "formFieldId": formFieldId, "fieldTitle": fieldTitle, "sort":sort, "filterType":filterType, "displaySort":displaySort }),
        dataType: "html",
        success: function(data) {

          if(data.includes('1')){
            alert('Update successful');
                $('#modalEditFormField').modal('hide');
                formTable.ajax.reload();
          }
          else{
            alert("This Title already exists");
          }
            
        },
        error: function() {
            alert('Something Wrong ! Please Try Again');
        }
      });
  }
});

//ShareFormField

$('#btnShareField').on('click', function(e) {

    $('#btnShareField').attr("disabled", true);

    var subCategoryId = $('#dropDownShareSubCategory').val();
    var formFieldId = $('#dropDownShareField').val();
    var fromSubCategoryId = $('#dropDownToShareSubCategory').val();

    alert(fromSubCategoryId);

        $.ajax({
            type: "POST",
            url: 'addShareFormField',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: ({ "subCategoryId":subCategoryId, "formFieldId":formFieldId, 'fromSubCategoryId':fromSubCategoryId }),
            success: function(data) {

                if(data.success == "success"){

                    alert('Add successful');
                    shareFormFieldTable.ajax.reload();
                    $('#btnShareField').attr("disabled", false);
                }
                else{
                  alert("This Category already exists");
                }   
            },
            error: function() {
                alert('Something Wrong ! Please Try Again');
            }
        });
});

