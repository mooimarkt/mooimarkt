@extends('layouts.admin')

@section('content')

<div class="container-fluid" style="padding-top: 50px; background-color: #002450; ">
        <div class="col-lg-12 col-md-12">
            <h6 class="admin-portal-title-white">Share Form Field</h6>
        </div>

         <div class="col-lg-4 col-md-4">
            <label class="label-white">From Sub Category</label>
              <select  id="dropDownToShareSubCategory" name="dropDownToShareSubCategory" class="form-control">
                      <option value="0">-- Please Select Sub Category --</option>
                  @foreach($subCategories as $subCat)
                      <option value="{{ $subCat->id }}">{{ $subCat->subCategoryName }}</option>
                  @endforeach
              </select>
          </div>

          <div class="col-lg-4 col-md-4">
            <label class="label-white">Field Name</label>
                <select  id="dropDownShareField" name="dropDownCategory" class="form-control">
                    <option value="none"></option>
                </select>
          </div>

          <div class="col-lg-4 col-md-4">
            <br/><br/><br/><br/>
          </div>

          <div class="col-lg-4 col-md-4">
            <label class="label-white">To Sub Category</label>
              <select  id="dropDownShareSubCategory" name="dropDownShareSubCategory" class="form-control">
                  <option value="all">All</option>
                  @foreach($subCategories as $subCat)
                      <option value="{{ $subCat->id }}">{{ $subCat->subCategoryName }}</option>
                  @endforeach
              </select>
          </div>

      <div class="col-lg-offset-10 col-md-offset-10 col-lg-2 col-md-2">
          <input type="submit" name="" value="Share Field" id="btnShareField" class="btnSubmit" style="margin-top: 30px; margin-bottom: 30px; width: 100%;">
      </div>
</div>

<div id="tablewrap" class="container-fluid table-responsive" style="margin-top: 50px;">
    <div class="col-lg-12 col-md-12">
      <h6 class="admin-portal-title-blue">Manage Existing Share Form Field</h6>
    </div>

    <div class="col-lg-12 col-md-12">
      <table id="shareFormFieldTable" class="table-striped">
        <thead>
          <th style="width: 200px">ID</th>
          <th style="width: 200px">Share From Sub Category Name</th>
          <th style="width: 200px">Share To Sub Category Name</th>
          <th style="width: 200px">Field Title</th>
          <th style="width: 100px"></th>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </div>

@endsection