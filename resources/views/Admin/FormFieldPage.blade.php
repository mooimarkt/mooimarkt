@extends('layouts.admin')

@section('content')

<div class="modal fade" id="modalEditFormField" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Form Field</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                    <div class="form-group">
                        <div class="">
                          <label class="control-label">Field ID :</label>
                        </div>
                        <div class="">
                          <input class="form-control" type="text" name="modaltxtFormFieldId" id="modaltxtFormFieldId" disabled="disabled">
                        </div>
                    </div> 

                    <div class="form-group">
                        <div class="">
                          <label class="control-label">Field Title :</label>
                        </div>
                        <div class="">
                          <input class="form-control" type="text" name="modaltxtFormFieldTitle" id="modaltxtFormFieldTitle">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="">
                          <label class="control-label">Filter Type :</label>
                        </div>
                        <div class="">
                          <select  id="modaldropDownFilterType" name="modalDropdownFilterType" class="form-control">
                              <option value="dropdown">dropdown</option>
                              <option value="input">Input Text</option>
                              <option value="range">range</option>
                              <option value="checkbox">checkbox</option>
                              <option value="radio">radio</option>
                              <option value="multiple">multiple</option>
                          </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="">
                          <label class="control-label">Sorting :</label>
                        </div>
                        <div class="">
                          <input class="form-control" type="text" name="modaltxtFormFieldSotring" id="modaltxtFormFieldSotring">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="">
                          <label class="control-label">Display Sort :</label>
                        </div>
                        <div class="">
                          <input class="form-control" type="text" name="modaltxtFormFieldDisplaySort" id="modaltxtFormFieldDisplaySort">
                        </div>
                    </div>  
            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary btn-block submit-buttons" id="modalbtnUpdateFormField">Update</button>
          </div>
        </div>
    </div>
</div>


<div class="container-fluid" style="padding-top: 50px; background-color: #002450; ">

        <div class="col-lg-12 col-md-12">
            <h6 class="admin-portal-title-white">Add New Field Form</h6>
        </div>

        <div class="col-lg-4 col-md-4">
            <label class="label-white">Sub Category</label>
                <select  id="dropDownCategory" name="dropDownCategory" class="form-control">
                    @foreach($subCategories as $subCat)
                        <option value="{{ $subCat->id }}">{{ $subCat->subCategoryName }}</option>
                    @endforeach
                </select>
          </div>

          <div class="col-lg-4 col-md-4">
            <label class="label-white">Field Title</label><input type="text" name="txtFieldTitle" class="form-control" id="txtFieldTitle">
          </div>

          <div class="col-lg-4 col-md-4">
            <label class="label-white">Field Type</label>
                <select  id="dropDownFieldType" name="dropDownFieldType" class="form-control">
                    <option value="dropdown">dropdown</option>
                    <option value="input">Input Text</option>
                </select>
          </div>

          <div class="col-lg-4 col-md-4">
            <label class="label-white">Filter Type</label>
                <select  id="dropDownFilterType" name="dropDownFilterType" class="form-control">
                    <option value="dropdown">dropdown</option>
                    <option value="input">Input Text</option>
                    <option value="range">range</option>
                    <option value="checkbox">checkbox</option>
                    <option value="radio">radio</option>
                    <option value="multiple">multiple</option>
                </select>
           </div>

          <div class="col-lg-4 col-md-4">
            <label class="label-white">Field Level</label>
                <select  id="dropDownFieldLevel" name="dropDownFieldLevel" class="form-control">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
           </div>

          <div class="col-lg-4 col-md-4">
            <label class="label-white">Parent Field</label>
                  <select  id="dropDownParentField" name="dropDownParentField" class="form-control">
                      <option value="0">0</option>
                  </select>
          </div>

          <div class="col-lg-4 col-md-4">
            <label class="label-white">Sorting</label><input type="text" name="txtFieldSorting" class="form-control" id="txtFieldSorting">
          </div>

          <div class="col-lg-4 col-md-4">
            <label class="label-white">Display Sorting</label><input type="text" name="txtFieldDisplaySort" class="form-control" id="txtFieldDisplaySort">
          </div>

          <div class="col-lg-offset-10 col-md-offset-10 col-lg-2 col-md-2">
              <input type="submit" name="" value="Add Field Form" id="btnFieldFormAdd" class="btnSubmit" style="margin-top: 30px; margin-bottom: 30px; width: 100%;">
          </div>
</div>

<div id="tablewrap" class="container-fluid table-responsive" style="margin-top: 50px;">
    <div class="col-lg-12 col-md-12">
      <h6 class="admin-portal-title-blue">Manage Existing Field Form</h6>
    </div>
    <div class="col-lg-12 col-md-12">
      <table id="formTable" class="table-striped">
        <thead>
          <th style="width: 200px">ID</th>
          <th style="width: 200px">Field Title</th>
          <th style="width: 200px">Parent Field</th>
          <th style="width: 200px">Subcategory</th>
          <th style="width: 200px">Field Type</th>
          <th style="width: 200px">Filter Type</th>
          <th style="width: 200px">Sort</th>
          <th style="width: 200px">Display Sort</th>
          <th style="width: 200px"></th>
          <th style="width: 200px"></th>
        </thead>
        <tbody></tbody>
      </table>
    </div>
</div>

@endsection