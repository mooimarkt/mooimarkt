@include("newthemplate.Admin.header")
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">How It Works Categories</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/getDashBoardPage">Dashboard</a></li>
                            <li class="breadcrumb-item active">How It Works Categories</li>
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
                                                <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending">Id</th>
                                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Title</th>
                                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Actions</th>

                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($howWorksCategories as $category)
                                                <tr role="row" class="odd tr-style">
                                                <td>{{ $category->id }}</td>
                                                <td>{{ $category->title }}</td>
                                                <td>
                                                    <a href="{{ route('howWorks.category.edit', $category->id) }}" class="btn btn-warning">Edit</a>
                                                    <a href="javascript:void(0)" class="btn btn-danger deleteCategory" data-cid="{{ $category->id }}">Delete</a>
                                                    <a href="{{ route('howWorks.items.list', $category->id) }}" class="btn btn-info ">Items</a>
                                                </td>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <br>
                                        <a href="{{ route('howWorks.category.create') }}" class="btn btn-primary float-right">Create</a>
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