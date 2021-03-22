@include("newthemplate.Admin.header")
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">SubCategories</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/getDashBoardPage">Dashboard</a></li>
                            <li class="breadcrumb-item active">SubCategories</li>
                        </ol>
                    </div><!-- /.col -->

                    <div class="box">
                        <!-- /.box-header -->
                        <div class="box-body box-user">
                            <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                                            <thead>
                                            <tr role="row">
                                                <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending">SubCategory id</th>
                                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Category</th>
                                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Name</th>
                                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Sort</th>
                                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Link</th>

                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($subcategories as $subcategory)
                                                <tr role="row" class="odd tr-style">
                                                <td>{{ $subcategory->id }}</td>
                                                <td>{{ $subcategory->category->categoryName }}</td>
                                                <td>{{ $subcategory->subCategoryName }}</td>
                                                <td>{{ $subcategory->sort }}</td>
                                                <td>
                                                    {{-- <a href="{{ route('subcategory.show', ['subcategory' => $subcategory->id]) }}" class="btn btn-primary">View</a> --}}
                                                    <a href="{{ route('subcategory.edit', ['subcategory' => $subcategory->id]) }}" class="btn btn-warning">Edit</a>
                                                    <a href="javascript:void(0)" class="btn btn-danger deleteSubCategory" data-sid="{{ $subcategory->id }}">Delete</a>
                                                    <a href="{{ route('admin.filters.show', ['subcategory' => $subcategory->id]) }}"
                                                       class="btn btn-success">Filters</a>
                                                </td>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="dataTables_info" id="example1_info" role="status" aria-live="polite">Showing {{ $subcategories->firstItem() }} to {{ $subcategories->lastItem() }} of {{ $subcategories->total() }} entries</div>
                                        {{ $subcategories->links() }}
                                        <a href="{{ route('subcategory.create') }}" class="btn btn-primary float-right">Create</a>
                                    </div>
                                    <!-- /.box-body -->
                                </div>

                            </div><!-- /.row -->
                        </div><!-- /.container-fluid -->

                    </div>
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