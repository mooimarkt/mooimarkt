@include("newthemplate.Admin.header")
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">How It Works Items</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/getDashBoardPage">Dashboard</a></li>
                            <li class="breadcrumb-item active">How It Works Items</li>
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
                                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Image</th>
                                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Title</th>
                                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Description</th>
                                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($items as $item)
                                                    <tr role="row" class="odd tr-style">
                                                        <td>{{ $item->id }}</td>
                                                        <td class="us_prof">
                                                            <div class="us_ph">
                                                                <img src="{{ $item->image }}"  />
                                                            </div>
                                                        </td>
                                                        <td>{{ $item->title }}</td>
                                                        <td>{{ $item->description }}</td>
                                                        <td>
                                                            <a href="{{ route('howWorks.item.edit', $item->id) }}" class="btn btn-warning">Edit</a>
                                                            <a href="javascript:void(0)" class="btn btn-danger deleteItem" data-cid="{{ $item->id }}">Delete</a>
                                                        </td>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <br>
                                        <a href="{{ route('howWorks.item.create') }}" class="btn btn-primary float-right">Create</a>
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