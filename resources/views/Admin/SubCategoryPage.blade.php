@extends('layouts.admin')

@section('content')

<div class="modal fade" id="modalEditSubCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Sub Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="updateproduct" data-toggle="validator">

                    <div class="form-group">
                        <div class="">
                          <label class="control-label">Sub Category Id :</label>
                        </div>
                        <div class="">
                          <input class="form-control" type="text" readonly="readonly" name="modaltxtSubCategoryId" id="modaltxtSubCategoryId" readonly="readonly">
                        </div>
                    </div>  

                    <div class="form-group">
                        <div class="">
                          <label class="control-label">Category Name :</label>
                        </div>
                        <div class="">
                            <input class="form-control" type="text" readonly="readonly" name="modaltxtCategoryName" id="modaltxtCategoryName" readonly="readonly">
                        </div>
                    </div> 

                    <div class="form-group">
                        <div class="">
                          <label class="control-label">Sub Category Name :</label>
                        </div>
                        <div class="">
                          <input class="form-control" type="text" name="modaltxtSubCategoryName" id="modaltxtSubCategoryName">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="">
                          <label class="control-label">Sorting :</label>
                        </div>
                        <div class="">
                          <input class="form-control" type="text" name="modaltxtSubCategorySort" id="modaltxtSubCategorySort">
                        </div>
                    </div>  

                    <div class="form-group">
                        <div class="">
                          <label class="control-label">Basic Ads Price :</label>
                        </div>
                        <div class="">
                          <input class="form-control" type="text" name="modaltxtBasicAdsPrice" id="modaltxtBasicAdsPrice" value="0">
                        </div>
                    </div> 

                    <div class="form-group">
                        <div class="">
                          <label class="control-label">Auto-Bump Ads Price :</label>
                        </div>
                        <div class="">
                          <input class="form-control" type="text" name="modaltxtAutoBumpAdsPrice" id="modaltxtAutoBumpAdsPrice" value="0">
                        </div>
                    </div> 

                    <div class="form-group">
                        <div class="">
                          <label class="control-label">Spotlight Ads Price :</label>
                        </div>
                        <div class="">
                          <input class="form-control" type="text" name="modaltxtSpotlightAdsPrice" id="modaltxtSpotlightAdsPrice" value="0">
                        </div>
                    </div> 

                    <input id="modalTxtHidden" value="" type="hidden"/>
                    <input id="modalTxtHiddenCategoryId" value="" type="hidden"/>
                </form>
            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-info" id="ModalbtnSubCategoryUpdate">Submit</button>
          </div>
        </div>
    </div>
</div>


<div class="container-fluid" style="padding-top: 50px; background-color: #002450; ">
  <div class="col-lg-12 col-md-12">
      <h6 class="admin-portal-title-white">Add New Subcategory</h6>
  </div>
  <div class="col-lg-4 col-md-4">
       <label class="label-white">Category Name </label>
       <select  id="dropDownCategory" name="dropDownCategory" class="form-control">
            <option value="default">-- Please Choose Your Category --</option>
            @foreach($categories as $category)
            <option value="{{$category['id']}}">{{$category['categoryName']}}</option>
            @endforeach
        </select>
  </div>
  <div class="col-lg-6 col-md-6">
     <label class="label-white">Subcategory Name </label><input type="text" name="InputName" class="form-control" id="txtSubCategoryName">
   </div>
   <div class="col-lg-4 col-md-4">
    <br/>
     <label class="label-white">Sorting </label><input type="text" name="InputName" class="form-control" id="txtSubCategorySort">
   </div>
   <div class="col-lg-4 col-md-4">
    <br/>
     <label class="label-white">Basic Ads Price </label><input type="text" name="InputName" class="form-control" id="txtBasicPrice">
   </div>
   <div class="col-lg-4 col-md-4">
    <br/>
     <label class="label-white">Auto-Bump Ads Price </label><input type="text" name="InputName" class="form-control" id="txtAutoBumpPrice">
   </div>
   <div class="col-lg-4 col-md-4">
    <br/>
     <label class="label-white">Spotlight Ads Price </label><input type="text" name="InputName" class="form-control" id="txtSpotlightPrice">
   </div>
    <div class="col-lg-offset-10 col-md-offset-10 col-lg-2 col-md-2">
      <input type="submit" name="" value="Add Subcategory" id="btnSubCategoryAdd"  class="btnSubmit" style="margin-top: 30px; margin-bottom: 30px; width: 100%;">
          {{ csrf_field() }}
    </div>
  </div>
</div>

 <div id="tablewrap" class="container-fluid table-responsive" style="margin-top: 50px;">
    <div class="col-lg-12 col-md-12">
      <h6 class="admin-portal-title-blue">Manage Existing Subcategories</h6>
    </div>
    <div class="col-lg-12 col-md-12">
      <table id="subCategoryTable" class="table-striped">
        <thead>
          <th style="width: 200px">ID</th>
          <th style="width: 200px">Category Name</th>
          <th style="width: 200px">Sub Category Name</th>
          <th style="width: 200px">Sort</th>
          <th style="width: 200px">Basic Price</th>
          <th style="width: 200px">Auto Bump Price</th>
          <th style="width: 200px">Spotlight Price</th>
          <th style="width: 200px"></th>
          <th style="width: 200px"></th>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </div>

@endsection