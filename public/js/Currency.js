var currencyTable = $('#currencyTable').DataTable({
    processing: true,
    serverSide: true,
    "ajax": "getCurrencyTable",
      columns:[
        {data: "id"},
        {data: "currencyName"},
        {data: "currencyCode"},
        {data: "conversionRate"},
        {
          "data": null,
          "searchable": false,
          "render": function(data, type, row, meta){ 
            return'<div><button style="height: 50px" type="button" class="col-md-12 btn btn-success btnEditCurrency" data-target="#editModal" data-id="'+ row.id +'" data-id="'+ row.id +'" data-currencyName="' + row.currencyName + '" data-currencyCode="' + row.currencyCode +'" data-conversionRate="' + row.conversionRate + '">Edit</button>';
          }
        },

        {
          "data": null,
          "searchable": false,
          "render": function(data, type, row, meta){ 
            return'<div><button style="height: 50px" type="button" class="col-md-12 btn btn-success btnDeleteCurrency" data-target="#editModal" data-id="'+ row.id +'" data-id="'+ row.id +'" data-currencyName="' + row.currencyName + '" data-currencyCode="' + row.currencyCode +'" data-conversionRate="' + row.conversionRate + '">Delete</button>';
          }
        },
      ],

      "fnDrawCallback":function(){
        $('.btnEditCurrency').on('click', function(e) {
          //get the id or the row
            $('#modalEditCurrency').modal('show');
            $('#modaltxtCurrencyId').val($(this).attr('data-id'));
            $('#modaltxtCurrencyName').val($(this).attr('data-currencyName'));
            $('#modaltxtCurrencyCode').val($(this).attr('data-currencyCode'));
            $('#modaltxtCurrencyRate').val($(this).attr('data-conversionRate'));
        });

        $('.btnDeleteCurrency').on('click', function(e) {

          var currencyId = $(this).attr('data-id');

          if (confirm('Are you sure ?')) {

            $.ajax({
              type: "POST",
              url: 'deleteCurrency',
              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
              data: ({ "currencyId": currencyId }),
              dataType: "html",
              success: function(data) {
                
                if(data.includes('1')){
                  alert("delete successful");
                  $('#modalEditCurrency').modal('hide');
                  currencyTable.ajax.reload();
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

$('#btnCurrencyAdd').on('click', function(e) {


  e.preventDefault();

  var currencyName = $('#txtCurrencyName').val();
  var currencyCode = $('#txtCurrencyCode').val();
  var currencyRate = $('#txtCurrencyRate').val();

    $.ajax({
      type: "POST",
      url: 'addCurrency',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      data: ({ "currencyName":currencyName, "currencyCode":currencyCode, "currencyRate" :currencyRate }),
      dataType: "html",
      success: function(data) {

        if(data.includes('1')){
          alert('Add successful');
              currencyTable.ajax.reload();
              $('#txtCurrencyName').val('');
              $('#txtCurrencyCode').val('');
              $('#txtCurrencyRate').val('');
        }
        else{
          alert("This Sub Category already exists");
        }
          
      },
      error: function() {
          alert('Something Wrong ! Please Try Again');
      }
    });
});

$('#modalbtnUpdateCurrency').on('click', function(e) {

    if (confirm('Are you sure ?')) {

      var currencyId = $('#modaltxtCurrencyId').val();
      var currencyName = $('#modaltxtCurrencyName').val();
      var currencyCode = $('#modaltxtCurrencyCode').val();
      var currencyRate = $('#modaltxtCurrencyRate').val();

        $.ajax({
          type: "POST",
          url: 'updateCurrency',
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          data: ({ "currencyId": currencyId, "currencyName": currencyName, "currencyCode": currencyCode, "currencyRate": currencyRate }),
          dataType: "html",
          success: function(data) {

            if(data.includes('1')){
              alert('Update successful');
                  $('#modalEditCurrency').modal('hide');
                  currencyTable.ajax.reload();
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