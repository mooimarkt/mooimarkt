@include("newthemplate.Admin.header")
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">New Filter ({{ $category->categoryName }} > {{ $subCategory->subCategoryName }})</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/getDashBoardPage">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/admin/subcategory">SubCategories</a></li>
                        <li class="breadcrumb-item"><a href="/admin/filters/{{ $subCategory->id }}">Filters</a></li>
                        <li class="breadcrumb-item active">New Filter</li>
                    </ol>
                </div><!-- /.col -->
            </div>
        </div>
    </div>
    <div class="box">
        <!-- /.box-header -->
        <div class="box-body">
                <form action="{{ route('admin.filters.store', ['subCategoryId' => $subCategory->id]) }}" method="POST">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card card-primary card-outline">
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="form-subcategory mb-3">
                                        <label for="subcategory-categoryId">Filters Category:</label>
                                        <select name="parent_id" class="form-control">
                                            <option value="category-{{ $subCategory->id }}">New Category</option>
                                            @foreach ($filters as $filter)
                                                <option value="{{ $filter->id }}">
                                                    {{ $filter->parent !== null && $filter->parent->template == 'type' ? '--' : '' }}
                                                    {{ $filter->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-subcategory mb-3">
                                        <label for="subcategory-title">Filter Template:</label>
                                        <select name="template" class="form-control">
                                            @foreach ($templates as $key => $template)
                                                <option value="{{ $key }}" {{ $key == old('template') ? 'selected' : '' }}>{{ $template }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-subcategory mb-3">
                                        <label for="subcategory-title">Filter Name:</label>
                                        <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                    </div>
                                   {{-- <div class="form-group mb-3">
                                        <label for="subcategory-title">Sort:</label>
                                        <input type="number" class="form-control" name="sort" value="{{ old('sort') }}">
                                    </div>--}}

                                    <div class="row">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                        <div style="padding-left: 10px;">
                                            <a href="/admin/filters/{{ $subCategory->id }}" style="width:100%" class="btn btn-warning">Back</a>
                                        </div>
                                    </div>
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