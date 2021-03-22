@extends('layouts.admin')

@section('content')

<div class="modal fade" id="modalFormFieldOption" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Form Field Option</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="updateproduct" data-toggle="validator">
                    <div class="form-group">
                        <div class="">
                          <label class="control-label">Form Field Option ID :</label>
                        </div>
                        <div class="">
                          <input class="form-control" type="text" name="modaltxtFormFieldOptionId" id="modaltxtFormFieldOptionId" disabled="disabled">
                        </div>
                    </div> 

                    <div class="form-group">
                        <div class="">
                          <label class="control-label">Parent Field :</label>
                        </div>
                        <div class="">
                          <input class="form-control" type="text" name="modaltxtFormFieldOptionParentField" id="modaltxtFormFieldOptionParentField" disabled="disabled">
                        </div>
                    </div>  

                    <div class="form-group">
                        <div class="">
                          <label class="control-label">Option :</label>
                        </div>
                        <div class="">
                          <input class="form-control" type="text" name="modaltxtFormFieldOptionOption" id="modaltxtFormFieldOptionOption">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="">
                          <label class="control-label">Sort :</label>
                        </div>
                        <div class="">
                          <input class="form-control" type="text" name="modaltxtFormFieldOptionSort" id="modaltxtFormFieldOptionSort">
                        </div>
                    </div>
                </form>
            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary btn-block submit-buttons" id="modalbtnUpdateFormFieldOption">Update</button>
          </div>
        </div>
    </div>
</div>


<div class="container-fluid" style="padding-top: 50px; background-color: #002450; ">

    <div class="col-lg-12 col-md-12">
        <h6 class="admin-portal-title-white">Add New Form Value</h6>
    </div>

    <div class="col-lg-4 col-md-4">
        <label class="label-white">Field</label>
        <select  id="dropDownOptionFieldId" name="dropDownOptionFieldId" class="form-control">
            <option value="0">-- Please Select Your Form Field --</option>
            @foreach($parentFields as $field)
                <option value="{{ $field->parentFieldId }}" data-form-id="{{ $field->id }}" data-subCategory-id="{{ $field->subCategoryId }}">{{ $field->subCategoryName }} : {{ $field->fieldTitle }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-lg-4 col-md-4">
        <label class="label-white">Parent Field</label>
        <select  id="dropDownSelectValue" name="dropDownSelectValue" class="form-control">
            <option value="null">-- Please Select Your Form Field First --</option>
        </select>
    </div>

    <div class="col-lg-4 col-md-4">
        <label class="label-white">Option</label><input type="text" name="txtFormValue" class="form-control" id="txtFormValue">
    </div>

    <div class="col-lg-4 col-md-4">
        <label class="label-white">Sort</label><input type="text" name="txtFormOptionSort" class="form-control" id="txtFormOptionSort">
    </div>

    <div class="col-lg-offset-10 col-md-offset-10 col-lg-2 col-md-2">
        <input type="submit" name="" value="Add Option" id="btnAddFormOptionValue" class="btnSubmit" style="margin-top: 30px; margin-bottom: 30px; width: 100%;">
    </div>
</div>

 <div id="tablewrap" class="container-fluid table-responsive" style="margin-top: 50px;">
    <div class="col-lg-12 col-md-12">
      <h6 class="admin-portal-title-blue">Manage Existing Form Field Value</h6>
    </div>
    <div class="col-lg-12 col-md-12">
      <table id="formOptionTable" class="table-striped">
        <thead>
          <th style="width: 200px">ID</th>
          <th style="width: 200px">Option Values</th>
          <th style="width: 200px">Parent Field</th>
          <th style="width: 200px">Subcategory</th>
          <th style="width: 200px">Sorting</th>
          <th style="width: 200px"></th>
          <th style="width: 200px"></th>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </div>

@endsection