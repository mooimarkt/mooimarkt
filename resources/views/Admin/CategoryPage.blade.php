@extends('layouts.admin')

@section('content')

<div class="modal fade" id="modalEditCategory" tabindex="-1" role="dialog" aria-
labelledby="exampleModalLabel" aria-hidden="true">
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
                          <label class="control-label">Category ID :</label>
                        </div>
                        <div class="">
                          <input class="form-control" readonly="readonly" type="text" name="modaltxtCategoryId" id="modaltxtCategoryId" disabled="disabled">
                        </div>
                    </div> 

                    <div class="form-group">
                        <div class="">
                          <label class="control-label">Category Name :</label>
                        </div>
                        <div class="">
                          <input class="form-control" type="text" name="modaltxtCategoryName" id="modaltxtCategoryName">
                        </div>
                    </div>  

                    <div class="form-group">
                        <div class="">
                          <label class="control-label">Category Status :</label>
                        </div>
                        <div class="">
                          <input class="form-control" type="text" name="modaltxtCategoryStatus" id="modaltxtCategoryStatus">
                        </div>
                    </div>

                     <div class="form-group">
                        <div class="">
                          <label class="control-label">Category Image :</label>
                        </div>
                        <div class="">
                          <img id="modalImageCategory" src="" style="width: 500px; height: auto">
                          <br/>
                          <input class="form-control" type="file" id="modalInputFileCategory" name="modalInputFileCategory" style="margin-top: 15px;">
                        </div>
                    </div>
                </form>
            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary btn-block submit-buttons" id="modalbtnUpdateCategory">Update</button>
          </div>
        </div>
    </div>
</div>


<div class="container-fluid" style="padding-top: 50px; background-color: #002450; ">
   <form id="addCategoryForm">
        <div class="col-lg-12 col-md-12">
            <h6 class="admin-portal-title-white">Add New Category</h6>
        </div>

        <div class="col-lg-4 col-md-4">
            <label class="label-white">Category Name </label><input type="text" name="categoryName" class="form-control" id="txtCategoryName">
        </div>

        <div class="col-lg-4 col-md-4">
            <label class="label-white">Category Status </label><input type="text" name="categoryStatus" class="form-control" id="txtCategoryStatus">
        </div>
      <div class="col-lg-4 col-md-4">
        <label class="label-white">Category Image </label><input type="file" name="categoryImage" class="form-control" id="inputFileCategory">
      </div>
      <div class="col-lg-offset-10 col-md-offset-10 col-lg-2 col-md-2">
          <input type="submit" name="" value="Add Category" id="btnCategoryAdd" class="btnSubmit" style="margin-top: 30px; margin-bottom: 30px; width: 100%;">
      </div>
   {{ csrf_field() }}
   </form>
</div>

 <div id="tablewrap" class="container-fluid table-responsive" style="margin-top: 50px;">
    <div class="col-lg-12 col-md-12">
      <h6 class="admin-portal-title-blue">Manage Existing Categories</h6>
    </div>
    <div class="col-lg-12 col-md-12">
        <table id="categoryTable" class="table-striped" style="width: 100%">
            <thead>
                <th style="width: 200px">ID</th>
                <th style="width: 200px">Category Name</th>
                <th style="width: 200px">Category Status</th>
                <th style="width: 200px">Category Image</th>
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