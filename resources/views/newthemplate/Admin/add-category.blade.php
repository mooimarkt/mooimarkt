@include("newthemplate.Admin.header")
<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        @if (Route::currentRouteName() == 'category.create')
                        <h1 class="m-0 text-dark">New Category</h1>
                        @else
                        <h1 class="m-0 text-dark">Edit Category</h1>
                        @endif
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/getDashBoardPage">Dashboard</a></li>
                            @if (Route::currentRouteName() == 'category.create')
                            <li class="breadcrumb-item active">New Category</li>
                            @else
                            <li class="breadcrumb-item active">Edit Category</li>
                            @endif
                        </ol>
                    </div><!-- /.col -->
                </div>
            </div>
        </div>
        <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
                @if (Route::currentRouteName() == 'category.create')
                <form action="{{ route('category.store') }}" method="POST" id="add-category" enctype="multipart/form-data">
                @else
                <form action="{{ route('category.update', ['category' => $category->id]) }}" method="POST" id="add-category" enctype="multipart/form-data">
                    {{ method_field('patch') }}
                @endif
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">Category content</h3>
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
                                    <div class="form-category mb-3">
                                        <label for="category-title">Category Name:</label>
                                        <input type="text" class="form-control" id="category-name" name="categoryName" placeholder="Category Name" required="required" value="{{ $category->categoryName or '' }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="category-title">Category Status:</label>
                                        <input type="text" class="form-control" id="category-status" name="categoryStatus" placeholder="Category Status" required="required" value="{{ $category->categoryStatus or '' }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="category-title">Category Image:</label>
                                        @if (isset($category))
                                        <div>
                                            <img src="{{ $category->categoryImage }}" alt="">
                                        </div>
                                        @endif
                                        <img src="" alt="">
                                        <input type="file" class="form-control" id="category-image" name="image" placeholder="Category Image"{{ (Route::currentRouteName() == 'category.create') ? 'required="required" ' : '' }}>
                                    </div>
                                    @if (Route::currentRouteName() == 'category.create')
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
                                    <h3 class="card-title">Category Information</h3>
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
                                    <p class="text-primary">{{ isset($category) ? \Carbon\Carbon::createFromTimeStamp(strtotime($category->created_at))->formatLocalized('%B %d, %Y') : '-' }}</p>
                                    <hr>
                                    <p class="lead">Last Edited:</p>
                                    <p class="text-success">{{ isset($category) ? \Carbon\Carbon::createFromTimeStamp(strtotime($category->updated_at))->formatLocalized('%B %d, %Y') : '-' }}</p>
                                    <hr>
                                    @if (Route::currentRouteName() == 'category.edit')
                                    <a href="javascript:void(0)" class="btn btn-danger btn-sm deleteCategory" cid="{{ $category->id }}">Delete</a>
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