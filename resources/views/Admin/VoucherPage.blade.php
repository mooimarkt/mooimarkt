@extends('layouts.admin')

@section('content')

<div class="modal fade" id="modalEditCategory" tabindex="-1" role="dialog" aria-
labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Voucher</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form method="POST" id="updateVoucherForm" data-toggle="validator">
                  {{ csrf_field() }}
                  <input class="form-control" type="hidden" name="voucher_id" id="modalVoucherID" >
                    <div class="form-group">
                        <div class="">
                          <label class="control-label">Voucher Name :</label>
                        </div>
                        <div class="">
                          <input class="form-control" type="text" name="voucherName" id="modalVoucherName" >
                        </div>
                    </div> 

                    <div class="form-group">
                        <div class="">
                          <label class="control-label">Voucher Code :</label>
                        </div>
                        <div class="">
                          <input class="form-control" type="text" name="voucherCode" id="modalVoucherCode">
                        </div>
                    </div>  

                    <div class="form-group">
                        <div class="">
                          <label class="control-label">Discount Value :</label>
                        </div>
                        <div class="">
                          <input class="form-control" type="text" name="discountAmount" id="modalDiscountValue">
                        </div>
                    </div>

                     <div class="form-group">
                        <div class="">
                          <label class="control-label">Discount Type :</label>
                        </div>
                        <div class="">
                          <select  id="modalDiscountType" name="discountType" class="form-control">
                            <option value="0">-- Please Select Discount Type --</option>
                            <option value="percentage" >Percentage</option>
                            <option value="price" >Price</option>
                          </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="">
                          <label class="control-label">Multiple Redeem :</label>
                        </div>
                        <div class="">
                          <select  id="modalMultipleRedeem" name="multipleRedeem" class="form-control">
                            <option value="0">-- Please Select Your Redeem Type --</option>
                            <option value="yes" >Yes</option>
                            <option value="no" >No</option>
                          </select>
                        </div>
                    </div>
                </form>
            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary btn-block submit-buttons" id="modalbtnUpdateVoucher">Update</button>
          </div>
        </div>
    </div>
</div>


<div class="container-fluid" style="padding-top: 50px; background-color: #002450; ">
   <form id="addVoucherForm">
        <div class="col-lg-12 col-md-12">
            <h6 class="admin-portal-title-white">Add New Voucher</h6>
        </div>

        <div class="col-lg-4 col-md-4">
            <label class="label-white">Voucher Name </label><input type="text" name="voucherName" class="form-control" id="txtCategoryName">
        </div>

        <div class="col-lg-4 col-md-4">
            <label class="label-white">Voucher Code </label><input type="text" name="voucherCode" class="form-control" id="txtCategoryStatus">
        </div>
        <div class="col-lg-4 col-md-4">
            <label class="label-white">Discount Value </label><input type="number" name="discountAmount" class="form-control" id="txtCategoryStatus" >
        </div>
        <div class="col-lg-4 col-md-4">
          <label class="label-white">Discount Type </label>
          <select  id="" name="discountType" class="form-control">
            <option value="0">-- Please Select Discount Type --</option>
            <option value="percentage" >Percentage</option>
            <option value="price" >Price</option>
          </select>

        </div>
        <div class="col-lg-4 col-md-4">
            <label class="label-white">Multiple Redeem </label>
            <select  id="" name="multipleRedeem" class="form-control">
              <option value="0">-- Please Select Your Redeem Type --</option>
              <option value="yes" >Yes</option>
              <option value="no" >No</option>
            </select>
        </div>     
        {{ csrf_field() }}
   </form>
      <div class="col-lg-offset-10 col-md-offset-10 col-lg-2 col-md-2">
        <button  name="" value="Add Voucher" id="save_voucher"  class="btnSubmit" style="margin-top: 30px; margin-bottom: 30px; width: 100%;">Add Voucher</button>
      </div>
   
</div>

 <div id="tablewrap" class="container-fluid table-responsive" style="margin-top: 50px;">
    <div class="col-lg-12 col-md-12">
      <h6 class="admin-portal-title-blue">Existing Voucher</h6>
    </div>
    <div class="col-lg-12 col-md-12">
        <table id="voucherTable" class="table-striped" style="width: 100%">
            <thead>
                <th style="width: 200px">Voucher Name</th>
                <th style="width: 200px">Voucher Code</th>
                <th style="width: 200px">Discount Value</th>
                <th style="width: 200px">Discount Type</th>
                <th style="width: 200px">Redeem Type</th>
                <th style="width: 200px">Status</th>
                <th style="width: 200px"></th>
                <th style="width: 200px"></th>
            </thead>
            <tbody></tbody>
        </table>
    </div>
  </div>

    <script type="text/javascript" src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>

  <script>

    $(document).ready(function() {
      $("#save_voucher").click(function(event) {
        var formData = $("#addVoucherForm").serialize();
        $.post(location.protocol + '//' + location.host+"/save_voucher", formData, function(r){
          console.log("r");
          console.log(r);
          if(r.status == "error"){
            alert(r.msg);
          }else{
            window.location.reload();
          }
          //window.location.reload();

        },'json').fail(function(e){
          console.log("failed");
          console.log(e);
        });

      });

      var voucherTable = $('#voucherTable').DataTable({
      processing: true,
      serverSide: true,
      "ajax": "getVoucherTable",
        columns:[
          {data: "voucherName"},
          {data: "voucherCode"},
          {data: "discountValue"},
          {data: "discountType"},
          {data: "multipleRedeem"},
          {data: "status"},
          /*{
            "data": null,
            "searchable": false,
            "render": function(data, type, row, meta){ 
              return'<div><img style="width: 100px; height= auto;" src="'+ data.categoryImage +'">';
            }
          },*/

          {
            "data": null,
            "searchable": false,
            "render": function(data, type, row, meta){ 
              return'<div><button style="height: 50px" type="button" class="col-md-12 btn btn-success btnEditCategory" data-target="#editModal"  data-voucherID="'+ row.id +'" data-voucherName="'+ row.voucherName +'" data-voucherCode="' + row.voucherCode + '" data-discountValue="' + row.discountValue +'" data-discountType="' + row.discountType +'" data-multipleRedeem="' + row.multipleRedeem +'">Edit</button>';
            }
          },

          {
            "data": null,
            "searchable": false,
            "render": function(data, type, row, meta){ 
              return'<div><button id="" style="height: 50px" type="button" class="col-md-12 btn btn-danger deleteVoucherBtn" data-target="#editModal" data-id="'+ row.id +'">Delete</button>';
            }
          },
        ],

        "fnDrawCallback":function(){
          $('.btnEditCategory').on('click', function(e) {
            //get the id or the row
              $('#modalEditCategory').modal('show');
              $("#modalVoucherID").val($(this).attr('data-voucherID'));
              $('#modalVoucherName').val($(this).attr('data-voucherName'));
              $('#modalVoucherCode').val($(this).attr('data-voucherCode'));
              $('#modalDiscountValue').val($(this).attr('data-discountValue'));
              $('#modalDiscountType').val($(this).attr('data-discountType'));
              $('#modalMultipleRedeem').val($(this).attr('data-multipleRedeem'));
          });

          $('.deleteVoucherBtn').on('click', function(e) {

          var voucherID = $(this).attr('data-id');

            if (confirm('Are you sure ?')) {

              $.ajax({
                type: "POST",
                url: 'deleteVoucher',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: ({ "voucherID": voucherID }),
                success: function(data) {
                  
                  alert(data.msg);
                  voucherTable.ajax.reload();
                  
                    
                },
                error: function() {
                    alert('Something Wrong ! Please Try Again');
                }
              });
            }
          });
        }
      });

      $('#modalbtnUpdateVoucher').on('click', function(e) {


          if (confirm('Are you sure ?')) {

              

              //var categoryForm = $("#updateVoucherForm")[0];
              var formData = $("#updateVoucherForm").serialize();
              /*var form = $('#modalFormCategory')[0];

              var categoryForm = new FormData(form);
              categoryForm.append('categoryId', categoryId);
              categoryForm.append('needUpdate', needUpdate);*/

              $.post(location.protocol + '//' + location.host+"/updateVoucher", formData, function(r){
                console.log("r");
                console.log(r);
                if(r.status == "error"){
                  alert(r.msg);
                }else{
                  window.location.reload();
                }
                //window.location.reload();

              },'json').fail(function(e){
                console.log("failed");
                console.log(e);
              });
          }
      });
    });

  </script>

@endsection