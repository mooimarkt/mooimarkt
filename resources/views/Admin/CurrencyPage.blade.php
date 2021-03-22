@extends('layouts.admin')

@section('content')

<div class="modal fade" id="modalEditCurrency" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form method="POST" id="modalFormCategory" data-toggle="validator">
                    <div class="form-group">
                        <div class="">
                          <label class="control-label">Currency ID :</label>
                        </div>
                        <div class="">
                          <input class="form-control" readonly="readonly" type="text" name="modaltxtCurrencyId" id="modaltxtCurrencyId" disabled="disabled">
                        </div>
                    </div> 

                    <div class="form-group">
                        <div class="">
                          <label class="control-label">Currency Name :</label>
                        </div>
                        <div class="">
                          <input class="form-control" type="text" name="modaltxtCurrencyName" id="modaltxtCurrencyName">
                        </div>
                    </div>  

                    <div class="form-group">
                        <div class="">
                          <label class="control-label">Currency Code :</label>
                        </div>
                        <div class="">
                          <input class="form-control" type="text" name="modaltxtCurrencyCode" id="modaltxtCurrencyCode">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="">
                          <label class="control-label">Currency Conversion Rate :</label>
                        </div>
                        <div class="">
                          <input class="form-control" type="text" name="modaltxtCurrencyRate" id="modaltxtCurrencyRate">
                        </div>
                    </div>
                </form>
            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary btn-block submit-buttons" id="modalbtnUpdateCurrency">Update</button>
          </div>
        </div>
    </div>
</div>


<div class="container-fluid" style="padding-top: 50px; background-color: #002450; ">
   <form id="addCategoryForm">
        <div class="col-lg-12 col-md-12">
            <h6 class="admin-portal-title-white">Add New Currency</h6>
        </div>

        <div class="col-lg-4 col-md-4">
            <label class="label-white">Currency Name </label><input type="text" name="currencyName" class="form-control" id="txtCurrencyName">
        </div>

        <div class="col-lg-4 col-md-4">
            <label class="label-white">Currency Code </label><input type="text" name="currencyCode" class="form-control" id="txtCurrencyCode">
        </div>
      <div class="col-lg-4 col-md-4">
        <label class="label-white">Currency Conversion Rate</label><input type="text" name="currencyRate" class="form-control" id="txtCurrencyRate">
      </div>
      <div class="col-lg-offset-10 col-md-offset-10 col-lg-2 col-md-2">
          <input type="submit" name="" value="Add Currency" id="btnCurrencyAdd" class="btnSubmit" style="margin-top: 30px; margin-bottom: 30px; width: 100%;">
      </div>
   {{ csrf_field() }}
   </form>
</div>

 <div id="tablewrap" class="container-fluid table-responsive" style="margin-top: 50px;">
    <div class="col-lg-12 col-md-12">
      <h6 class="admin-portal-title-blue">Manage Existing Currencies</h6>
    </div>
    <div class="col-lg-12 col-md-12">
        <table id="currencyTable" class="table-striped" style="width: 100%">
            <thead>
                <th style="width: 200px">ID</th>
                <th style="width: 200px">Currency Name</th>
                <th style="width: 200px">Currency Code</th>
                <th style="width: 200px">Currency Conversion Rate</th>
                <th style="width: 200px"></th>
                <th style="width: 200px"></th>
            </thead>
            <tbody></tbody>
        </table>
    </div>
  </div>

  <script type="text/javascript">
    

  </script>

@endsection