@include("newthemplate.Admin.header")


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Languages</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/getDashBoardPage">Dashboard</a></li>
                        <li class="breadcrumb-item active">Languages</li>
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
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Slug</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($languages as $language)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $language->name }}</td>
                                                <td>{{ $language->slug }}</td>
                                                <td>{{ $language->created_at }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('languages.edit', $language->id) }}" class="btn btn-info">Edit</a>
                                                        @if($language->id != 1)<a href="{{ route('languages.delete', $language->id) }}" class="btn btn-danger">Delete</a>@endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
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









@section('bottom-footer')
    <script>
        $(function () {
            $('#lang_manager_table_searching').DataTable({
                'paging'      : true,
                'lengthChange': false,
                'searching'   : true,
                'ordering'    : true,
                'info'        : true,
                'autoWidth'   : false,
                'pageLength'  : localStorage.getItem('languages_l') != undefined ? localStorage.getItem('languages_l') : 10
            });

            $('#lang_manager_table_searching').on('length.dt', function (e, settings, len) {
                localStorage.setItem('languages_l', len);
            });
        })
    </script>
@endsection

<!-- /.content -->
@include("newthemplate.Admin.footer")
