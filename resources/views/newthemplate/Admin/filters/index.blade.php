@include("newthemplate.Admin.header")
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Filters  ({{ $category->categoryName }} > {{ $subCategory->subCategoryName }})</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/getDashBoardPage">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/admin/subcategory">SubCategories</a></li>
                        <li class="breadcrumb-item active">Filters</li>
                    </ol>
                </div><!-- /.col -->
            </div>
        </div>
    </div>
    <div class="box">
        <!-- /.box-header -->
        <div class="box-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary card-outline">
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="box">
                                    <br>
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-8 offset-2">
                                                <div class="row  d-flex justify-content-center">
                                                    <div style="padding-right: 10px;">
                                                        <a href="{{ route('admin.filters.create', ['subCategoryId' => $subCategory->id]) }}" style="width:100%" class="btn btn-success">Create new filter</a>
                                                    </div>
                                                    <div style="padding-right: 10px;">
                                                        <a href="/admin/subcategory" style="width:100%" class="btn btn-warning">Back</a>
                                                    </div>
                                                </div>
                                                <br>
                                                <input type="hidden" id="sub_category_id" value="{{ $subCategory->id }}">
                                                <div id="sortableResult"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
        </div><!-- /.container-fluid -->

    </div>
</div>

@include("newthemplate.Admin.footer")