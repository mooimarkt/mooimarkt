
var subCategoryTable = $('#subCategoryTable').DataTable({
    processing: true,
    serverSide: true,
    "ajax": "getSubCategoryTable",
      columns:[
        {data: "subCategoryId"},
        {data: "categoryName"},
        {data: "subCategoryName"},
        {data: "sort"},
        {
          "data": null,
          "searchable": false,
          "render": function(data, type, row, meta){ 
            return'<div><button style="height: 50px" type="button" class="col-md-12 btn btn-success subCategoryEditBtn" data-target="#editModal" data-id="'+  row.subCategoryId +'" data-pricingId="' + row.id + '" data-spotlight="'+ row.spotlight +'" data-autoBump="'+ row.autoBump +'" data-basicAds="'+ row.basic +'" data-SubCategoryId="'+ row.subCategoryId +'" data-categoryName="' + row.categoryName + '" data-subCategoryName="'+ row.subCategoryName + '"data-categoryId="'+ row.categoryId +'" data-subCategorySort="'+ row.sort +'">Edit</button>';
          }
        },
        {
          "data": null,
          "searchable": false,
          "render": function(data, type, row, meta){ 
            return'<div><button style="height: 50px" type="button" class="col-md-12 btn btn-success subCategoryDeleteBtn" data-target="#editModal" data-id="'+  row.subCategoryId +'" data-pricingId="' + row.id + '" data-spotlight="'+ row.spotlight +'" data-autoBump="'+ row.autoBump +'" data-basicAds="'+ row.basic +'" data-SubCategoryId="'+ row.subCategoryId +'" data-categoryName="' + row.categoryName + '" data-subCategoryName="'+ row.subCategoryName + '"data-categoryId="'+ row.categoryId +'" data-subCategorySort="'+ row.sort +'">Delete</button>';
          }
        },

      ],

      "fnDrawCallback":function(){
        $('.subCategoryEditBtn').on('click', function(e) {
          //get the id or the row
            $('#modalEditSubCategory').modal('show');
            $('#modaltxtSubCategoryId').val($(this).attr('data-SubCategoryId'));
            $('#modaltxtCategoryName').val($(this).attr('data-categoryName'));
            $('#modaltxtSubCategoryName').val($(this).attr('data-subCategoryName'));
            $('#modalTxtHidden').val($(this).attr('data-pricingId'));
            $('#modaltxtSubCategorySort').val($(this).attr('data-subCategorySort'));
            $('#modalTxtHiddenCategoryId').val($(this).attr('data-categoryId'));
        });

        $('.subCategoryDeleteBtn').on('click', function(e) {

          if (confirm('Are you sure ?')) {

            var subCategoryId = $(this).attr('data-id');

              $.ajax({
                type: "POST",
                url: 'deleteSubCategory',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: ({ "subCategoryId": subCategoryId }),
                dataType: "html",
                success: function(data) {
                  
                  if(data.includes('1')){
                    alert('Delete successful');
                        $('#modalEditSubCategory').modal('hide');
                        subCategoryTable.ajax.reload();
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

$('#btnSubCategoryAdd').on('click', function(e) {

  var categoryId = $('#dropDownCategory').val();
  var subCategoryName = $('#txtSubCategoryName').val();
  var basicPrice = $('#txtBasicPrice').val();
  var autoBumpPrice = $('#txtAutoBumpPrice').val();
  var spotlightPrice = $('#txtSpotlightPrice').val();
  var sort = $('#txtSubCategorySort').val();

  if(categoryId == "default"){
    alert('please Select your Category');
  }
  else{
    $.ajax({
      type: "POST",
      url: 'addSubCategory',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      data: ({ "categoryId":categoryId, "subCategoryName":subCategoryName, "basicPrice" :basicPrice, "autoBumpPrice":autoBumpPrice, "spotlightPrice":spotlightPrice, "subCategorySort":sort  }),
      dataType: "html",
      success: function(data) {

        if(data.includes('1')){
          alert('Add successful');
              subCategoryTable.ajax.reload();
              $('#txtSubCategoryName').val('');
              $('#dropDownCategory option[value=default]').attr('selected','selected');
        }
        else{
          alert("This Sub Category already exists");
        }
          
      },
      error: function() {
          alert('Something Wrong ! Please Try Again');
      }
    });
  }
});

$('#ModalbtnSubCategoryUpdate').on('click', function(e) {

  if (confirm('Are you sure ?')) {

    var subCategoryId = $('#modaltxtSubCategoryId').val();
    var categoryId = $('#modalTxtHiddenCategoryId').val();
    var pricingId = $('#modalTxtHidden').val();
    var subCategoryName = $('#modaltxtSubCategoryName').val();
    var basicPrice = $('#modaltxtBasicAdsPrice').val();
    var autoBumpPrice = $('#modaltxtAutoBumpAdsPrice').val();
    var spotlightPrice = $('#modaltxtSpotlightAdsPrice').val();
    var sort = $('#modaltxtSubCategorySort').val();

      $.ajax({
        type: "POST",
        url: 'updateSubCategory',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: ({ "subCategoryId": subCategoryId, "categoryId": categoryId, "subCategoryName": subCategoryName, "basicPrice": basicPrice, "autoBumpPrice": autoBumpPrice, "spotlightPrice": spotlightPrice, "pricingId": pricingId, "subCategorySort": sort }),
        dataType: "html",
        success: function(data) {

          if(data.includes('1')){
            alert('Update successful');
                $('#modalEditSubCategory').modal('hide');
                subCategoryTable.ajax.reload();
          }
          else{
            alert("This Sub Category already exists");
          }
            
        },
        error: function() {
            alert('Something Wrong ! Please Try Again');
        }
      });
  }
});


