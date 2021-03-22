@extends('layouts.admin')

@section('content')

<div class="modal fade" id="modalEditUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="updateproduct" data-toggle="validator">
                    <div class="form-group">
                        <div class="">
                          <label class="control-label">User ID :</label>
                        </div>
                        <div class="">
                          <input class="form-control" type="text" name="txtUserId" id="txtUserId" disabled="disabled">
                        </div>
                    </div> 

                    <div class="form-group">
                        <div class="">
                          <label class="control-label">Email :</label>
                        </div>
                        <div class="">
                          <input class="form-control" type="text" name="txtUserEmail" id="txtUserEmail" disabled="disabled">
                        </div>
                    </div>  

                    <div class="form-group">
                        <div class="">
                          <label class="control-label">Name :</label>
                        </div>
                        <div class="">
                          <input class="form-control" type="text" name="txtUserName" id="txtUserName" disabled="disabled">
                        </div>
                    </div> 

                    <div class="form-group">
                        <div class="">
                          <label class="control-label">Role :</label>
                        </div>
                        <div class="">
                          <select  id="modalDropDownRole" name="modalDropDownRole" class="form-control">
                              <option value="admin">admin</option>
                              <option value="user">user</option>
                              <option value="unset">unset</option>
                              <option value="pending">pending</option>
                              <option value="blocked">blocked</option>
                          </select>
                        </div>
                    </div> 
                </form>
            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-info" id="btnSubmitUpdateUser">Submit</button>
          </div>
        </div>
    </div>
</div>

  <div id="tablewrap" class="container-fluid table-responsive" style="margin-top: 50px;">
    <div class="col-lg-12 col-md-12">
      <h6 class="admin-portal-title-blue">Manage User</h6>
    </div>
    <div class="col-lg-5 col-md-5">
      <label class="control-label">From Date :</label>
      <input id="userFromDate" type="text" class="form-control datepicker">
    </div>
    <div class="col-lg-5 col-md-5">
      <label class="control-label">Until Date :</label>
      <input id="userToDate" type="text" class="form-control datepicker">
    </div>
    <div class="col-lg-2 col-md-2">
      <label class="control-label"></label>
      <div id="userSearchButton" class="btnEditCategory" style="padding:5px; text-align: center; position: relative; top: 7px; ">Search</div>
    </div>

    <div class="col-lg-12 col-md-12" style="padding-top: 50px;">
      <table id="userTable" class="table-striped">
        <thead>
          <th style="width: 200px">ID</th>
          <th style="width: 200px">Social Type</th>
          <th style="width: 200px">Role</th>
          <th style="width: 200px">Name</th>
          <th style="width: 200px">Email</th>
          <th style="width: 200px">Country</th>
          <th style="width: 200px">Region</th>
          <th style="width: 200px">Contact No</th>
          <th style="width: 200px"></th>
          <th style="width: 200px"></th>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </div>

  <script type="text/javascript" src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function(){

      $('#userSearchButton').click(function(){

        var fromDate = $('#userFromDate').val();
        var toDate = $('#userToDate').val();

        if(fromDate == "" || toDate == ""){

          alert('Please Choose a Proper Date');
        }
        else{

          userTable.draw();
        }
      });
    });
</script>

@endsection