@include("newthemplate.Admin.header")

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Users</h1>
                    <div class="search_top">
                        <div class="col-md-12">
                            <form action="" method="GET" class="form_list">
                                <input type="text" name="keyword" class="form-control col-md-6 "
                                       placeholder="Search by user name & info">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </form>
                        </div>
                    </div>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/getDashBoardPage">Dashboard</a></li>
                        <li class="breadcrumb-item active">Users</li>
                    </ol>
                </div>
            </div><!-- /.col -->
            <div class="box">
                <!-- /.box-header -->
                <div class="box-body box-user">
                    <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-bordered table-striped" role="grid"
                                       aria-describedby="example1_info">
                                    <thead>
                                    <tr role="row">
                                        <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1"
                                            colspan="1" aria-sort="ascending"
                                            aria-label="Rendering engine: activate to sort column descending" style="">
                                            User id
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                            colspan="1" aria-label="Browser: activate to sort column ascending"
                                            style="">User Profile
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                            colspan="1" aria-label="Platform(s): activate to sort column ascending"
                                            style="">User Info
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                            colspan="1" aria-label="Engine version: activate to sort column ascending"
                                            style="">User listings
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1"
                                            colspan="1" aria-label="CSS grade: activate to sort column ascending"
                                            style="text-align:right; padding-right: 10px;padding-left:40px;">Actions
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($AllUsers as $user)
                                        <tr role="row" class="odd tr-style tgl-parrent">
                                            <td class="sorting_1">{{$user->id}}</td>
                                            <td class="us_prof">
                                                <div class="us_ph"><img src="/newthemplate/admin/img/empty_user_img.png"
                                                                        alt="Alternate Text"/></div>
                                                <div class="us_txt">
                                                    <div>{{$user->name}}</div>
                                                    <a href="/profile/{{$user->id}}" target="_blank">Profile</a>
                                                </div>
                                            </td>
                                            <td>
                                                <div>{{$user->city}},{{$user->region}},{{$user->country}}</div>
                                                <div>{{$user->email}}</div>
                                                <div>{{$user->phone}}</div>
                                            </td>
                                            <td>
                                                <a href="/admin/listings/user/{{$user->id}}">View</a>
                                            </td>
                                            <td>
                                                <button type="button" data-uid="{{$user->id}}"
                                                        class="btn btn-block btn-success btn-sm confirm_user">Confirm
                                                </button>
                                                <button type="button" data-uid="{{$user->id}}"
                                                        class="btn btn-block btn-danger btn-sm delete_user">Delete
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="dataTables_info" id="example1_info" role="status" aria-live="polite">
                                    Showing {{ $AllUsers->firstItem() }} to {{ $AllUsers->lastItem() }}
                                    of {{ $AllUsers->total() }} users
                                </div>
                            </div>
                        {{$AllUsers->links()}}
                        <!-- /.box-body -->
                        </div>
                        <div class=""></div>
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->

            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">

</section>
<!-- /.content -->
@include("newthemplate.Admin.footer")