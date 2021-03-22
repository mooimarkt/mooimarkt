
var categoryTable = $('#categoryTable').DataTable({
    processing: true,
    serverSide: true,
    "ajax": "getCategoryTable",
      columns:[
        {data: "id"},
        {data: "categoryName"},
        {data: "categoryStatus"},
        {
          "data": null,
          "searchable": false,
          "render": function(data, type, row, meta){ 
            return'<div><img style="width: 100px; height= auto;" src="'+ data.categoryImage +'">';
          }
        },

        {
          "data": null,
          "searchable": false,
          "render": function(data, type, row, meta){ 
            return'<div><button style="height: 50px" type="button" class="col-md-12 btn btn-success btnEditCategory" data-target="#editModal" data-image="'+ row.categoryImage +'" data-id="'+ row.id +'" data-categoryName="' + row.categoryName + '" data-categoryStatus="' + row.categoryStatus +'">Edit</button>';
          }
        },

        {
          "data": null,
          "searchable": false,
          "render": function(data, type, row, meta){ 
            return'<div><button style="height: 50px" type="button" class="col-md-12 btn btn-success btnDeleteCategory" data-target="#editModal" data-image="'+ row.categoryImage +'" data-id="'+ row.id +'" data-categoryName="' + row.categoryName + '" data-categoryStatus="' + row.categoryStatus +'">Delete</button>';
          }
        },
      ],

      "fnDrawCallback":function(){
        $('.btnEditCategory').on('click', function(e) {
          //get the id or the row
            $('#modalEditCategory').modal('show');
            $('#modaltxtCategoryId').val($(this).attr('data-id'));
            $('#modaltxtCategoryName').val($(this).attr('data-categoryName'));
            $('#modaltxtCategoryStatus').val($(this).attr('data-categoryStatus'));
            $('#modalImageCategory').attr('src', $(this).attr('data-image'));
        });

        $('.btnDeleteCategory').on('click', function(e) {

        var categoryId = $(this).attr('data-id');

          if (confirm('Are you sure ?')) {

            $.ajax({
              type: "POST",
              url: 'deleteCategory',
              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
              data: ({ "categoryId": categoryId }),
              dataType: "html",
              success: function(data) {
                
                if(data.includes('1')){
                  alert("delete successful");
                  $('#modalEditCategory').modal('hide');
                  categoryTable.ajax.reload();
                }
                else{
                  alert("Delete Fail");
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

$('#btnCategoryAdd').on('click', function(e) {


  e.preventDefault();

  var categoryName = $('#txtCategoryName').val();
  var categoryStatus = $('#txtCategoryStatus').val();

  var form = $('#addCategoryForm')[0];

  var categoryForm = new FormData(form);

    $.ajax({
      type: "POST",
      url: 'addCategory',
      contentType: false,
      processData: false,
      enctype: 'multipart/form-data',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      data: categoryForm,
      dataType: "html",
      success: function(data) {

        if(data.includes('1')){
          alert('Add successful');
              $('#modalEditCategory').modal('hide');
              categoryTable.ajax.reload();
        }
        else{
          alert("This Category already exists");
        }
          
      },
      error: function(xhr) {
          alert('Something Wrong ! Please Try Again');
          console.log('Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText);
      }
    });
});

$('#modalbtnUpdateCategory').on('click', function(e) {

    var categoryId = $('#modaltxtCategoryId').val();

    if (confirm('Are you sure ?')) {

        var checkImage = $('#modalInputFileCategory').get(0).files.length;
        var needUpdate;

        if(checkImage > 0){

          needUpdate = "true";
        }

        else{

          needUpdate = "false";
        }

        var form = $('#modalFormCategory')[0];

        var categoryForm = new FormData(form);
        categoryForm.append('categoryId', categoryId);
        categoryForm.append('needUpdate', needUpdate);

            $.ajax({
                type: "POST",
                url: 'updateCategory',
                contentType: false,
                processData: false,
                enctype: 'multipart/form-data',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: categoryForm,
                dataType: "html",
                success: function(data) {

                    if(data.includes('1')){
                      alert('Update successful');
                          $()
                          categoryTable.ajax.reload();
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

$(document).ready(function(){

    $('#modalInputFileCategory').change(function(){
      var input = this;
      var url = $(this).val();
      var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
      if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) 
       {
          var reader = new FileReader();

          reader.onload = function (e) {
             $('#modalImageCategory').attr('src', e.target.result);
          }
         reader.readAsDataURL(input.files[0]);
      }
    });

  });

    



