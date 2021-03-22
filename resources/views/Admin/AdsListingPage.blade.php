@extends('layouts.admin')

@section('content')
<div id="tablewrap" class="container-fluid table-responsive" style="margin-top: 50px;">
  <div class="col-lg-12 col-md-12">
    <h6 class="admin-portal-title-blue">Manage Ads</h6>
  </div>
  <div class="col-lg-5 col-md-5">
    <label class="control-label">From Date :</label>
    <input id="fromDate" type="text" class="form-control datepicker">
  </div>
  <div class="col-lg-5 col-md-5">
    <label class="control-label">Until Date :</label>
    <input id="toDate" type="text" class="form-control datepicker">
  </div>
  <div class="col-lg-2 col-md-2">
    <label class="control-label"> </label>
    <div id="adsSearchButton" class="btnEditCategory" style="padding:5px; text-align: center; position: relative; top: 7px;">Search</div>
  </div>
  <div class="col-lg-12 col-md-12" style="padding-top: 50px;">
    <table id="adsTable" class="table-striped">
      <thead>
        <th style="width: 200px">ID</th>
        <th style="width: 200px">Ads Name</th>
        <th style="width: 200px">Ads Price</th>
        <th style="width: 200px">Ads Country</th>
        <th style="width: 200px">Ads Region</th>
        <th style="width: 200px">Ads Contact No</th>
        <th style="width: 200px"></th>
      </thead>
      <tbody></tbody>
    </table>
  </div>
</div>

<script type="text/javascript" src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function(){

      $('#adsSearchButton').click(function(){

        var fromDate = $('#fromDate').val();
        var toDate = $('#toDate').val();

        if(fromDate == "" || toDate == ""){

          alert('Please Choose a Proper Date');
        }
        else{

          adsTable.draw();
        }
      });
    });
</script>

@endsection