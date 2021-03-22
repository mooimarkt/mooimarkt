@include("newthemplate.Admin.header")
<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        @if (Route::currentRouteName() == 'subcategory.create')
                        <h1 class="m-0 text-dark">New Category</h1>
                        @else
                        <h1 class="m-0 text-dark">Edit Category</h1>
                        @endif
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/getDashBoardPage">Dashboard</a></li>
                            @if (Route::currentRouteName() == 'subcategory.create')
                            <li class="breadcrumb-item active">New SubCategory</li>
                            @else
                            <li class="breadcrumb-item active">Edit SubCategory</li>
                            @endif
                        </ol>
                    </div><!-- /.col -->
                </div>
            </div>
        </div>
        <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
                @if (Route::currentRouteName() == 'subcategory.create')
                <form action="{{ route('subcategory.store') }}" method="POST" id="add-subcategory" enctype="multipart/form-data">
                @else
                <form action="{{ route('subcategory.update', ['subcategory' => $subcategory->id]) }}" method="POST" id="add-subcategory" enctype="multipart/form-data">
                    {{ method_field('patch') }}
                @endif
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">SubCategory content</h3>
                                    <!-- tools box -->
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool btn-sm"
                                                data-widget="collapse"
                                                data-toggle="tooltip"
                                                title="Collapse">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool btn-sm"
                                                data-widget="remove"
                                                data-toggle="tooltip"
                                                title="Remove">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                    <!-- /. tools -->
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="form-subcategory mb-3">
                                        <label for="subcategory-categoryId">Category:</label>
                                        <select name="categoryId" id="subcategory-categoryId" class="form-control">
                                            @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"{{ (isset($subcategory) && $subcategory->categoryId == $category->id) ? ' selected' : '' }}>{{ $category->categoryName }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-subcategory mb-3">
                                        <label for="subcategory-title">SubCategory Name:</label>
                                        <input type="text" class="form-control" id="subcategory-name" name="subCategoryName" placeholder="SubCategory Name" value="{{ $subcategory->subCategoryName or '' }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="subcategory-title">Sort:</label>
                                        <input type="text" class="form-control" id="subcategory-sort" name="sort" placeholder="Sort" value="{{ $subcategory->sort or '' }}">
                                    </div>
                                    @if (Route::currentRouteName() == 'subcategory.create')
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    @else
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    @endif
                                    
                                </div>
                            </div>


                        </div>
                        <div class="col-md-4">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">Subcategory Information</h3>
                                    <!-- tools box -->
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool btn-sm"
                                                data-widget="collapse"
                                                data-toggle="tooltip"
                                                title="Collapse">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool btn-sm"
                                                data-widget="remove"
                                                data-toggle="tooltip"
                                                title="Remove">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                    <!-- /. tools -->
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    {{-- <p class="lead">Page status:</p>
                                    <p class="text-muted"><b>Draft</b></p>
                                    @php
                                        $statuses = array('published', 'draft', 'deleted');
                                    @endphp
                                    <select name="status" class="form-control" form="add-page">
                                        @foreach ($statuses as $status)
                                        <option value="{{ $status }}"{{ (isset($page) && $status == $page->status) ? ' selected' : '' }}>{{ $status }}</option>
                                        @endforeach
                                    </select>
                                    <hr> --}}
                                    <p class="lead">Created:</p>
                                    <p class="text-primary">{{ isset($subcategory) ? \Carbon\Carbon::createFromTimeStamp(strtotime($subcategory->created_at))->formatLocalized('%B %d, %Y') : '-' }}</p>
                                    <hr>
                                    <p class="lead">Last Edited:</p>
                                    <p class="text-success">{{ isset($subcategory) ? \Carbon\Carbon::createFromTimeStamp(strtotime($subcategory->updated_at))->formatLocalized('%B %d, %Y') : '-' }}</p>
                                    <hr>
                                    @if (Route::currentRouteName() == 'subcategory.edit')
                                    <a href="javascript:void(0)" class="btn btn-danger btn-sm deleteSubCategory" data-sid="{{ $subcategory->id }}">Delete</a>
                                    @endif
                                    {{-- <a href="#" class="btn btn-sm btn-primary">Update</a> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div><!-- /.container-fluid -->

        </div>
    </div>
</div>

<!-- /.content-header -->

</div><!-- /.row -->
</div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->



<!-- Main content -->


<section class="content">



</section>


<!-- /.content -->


@include("newthemplate.Admin.footer")