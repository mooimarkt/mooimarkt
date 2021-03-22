@include("newthemplate.Admin.header")
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Listings</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/getDashBoardPage">Dashboard</a></li>
                            <li class="breadcrumb-item active">Pages</li>
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
                                                <th>Page id</th>
                                                <th>Page Title</th>
                                                <th>Page Info</th>
                                                <th>Page Status</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($pages as $page)
                                                <tr>
                                                    <td>{{ $page->page }}</td>
                                                    <td>{{ $page->title }}</td>
                                                    <td>Last Edited: {{ \Carbon\Carbon::createFromTimeStamp(strtotime($page->updated_at))->diffForHumans() }}</td>
                                                    <td><p class="text-{{ $page->status == 'published' ? 'success' : ($page->status == 'deleted' ? 'danger' : 'muted') }}">{{ ucfirst($page->status) }}</p></td>
                                                    <td>
                                                        <a href="{{ route('pages.show', ['page' => $page->page]) }}" target="_blank" class="btn btn-sm btn-primary">View</a>
                                                        <a href="{{ route('pages.edit', ['page' => $page->page]) }}" class="btn btn-sm btn-success">Edit</a>
                                                        <a href="javascript:void(0)" class="btn btn-sm btn-danger deletePage" data-page="{{ $page->page }}">Delete</a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            {{-- <tr>
                                                <td>1</td>
                                                <td>Front Page</td>
                                                <td>Last Edited: 3 days ago</td>
                                                <td><p class="text-success">Published</p></td>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-primary">View</a>
                                                    <a href="edit-page.html" class="btn btn-sm btn-success">Edit</a>
                                                    <a href="#" class="btn btn-sm btn-danger">Delete</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>About us</td>
                                                <td>Last Edited: 2 days ago</td>
                                                <td><p class="text-muted">Draft</p></td>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-primary">View</a>
                                                    <a href="edit-page.html" class="btn btn-sm btn-success">Edit</a>
                                                    <a href="#" class="btn btn-sm btn-danger">Delete</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>5</td>
                                                <td>Contact us</td>
                                                <td>Last Edited: 1 days ago</td>
                                                <td><p class="text-danger">Deleted</p></td>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-primary">View</a>
                                                    <a href="edit-page.html" class="btn btn-sm btn-success">Edit</a>
                                                    <a href="#" class="btn btn-sm btn-danger">Delete</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>7</td>
                                                <td>Listings</td>
                                                <td>Last Edited: 3 days ago</td>
                                                <td><p class="text-success">Published</p></td>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-primary">View</a>
                                                    <a href="edit-page.html" class="btn btn-sm btn-success">Edit</a>
                                                    <a href="#" class="btn btn-sm btn-danger">Delete</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>12</td>
                                                <td>About us</td>
                                                <td>Last Edited: 2 days ago</td>
                                                <td><p class="text-muted">Draft</p></td>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-primary">View</a>
                                                    <a href="edit-page.html" class="btn btn-sm btn-success">Edit</a>
                                                    <a href="#" class="btn btn-sm btn-danger">Delete</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>25</td>
                                                <td>Contact us</td>
                                                <td>Last Edited: 1 days ago</td>
                                                <td><p class="text-danger">Deleted</p></td>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-primary">View</a>
                                                    <a href="edit-page.html" class="btn btn-sm btn-success">Edit</a>
                                                    <a href="#" class="btn btn-sm btn-danger">Delete</a>
                                                </td>
                                            </tr> --}}
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
</div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->



<!-- Main content -->


<section class="content">



</section>
@include("newthemplate.Admin.footer")
