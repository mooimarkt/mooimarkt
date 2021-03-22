@include("newthemplate.Admin.header")
    <div class="content-wrapper" style="min-height: 835px;">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Profile</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/getDashBoardPage">Dashboard</a></li>
                            <li class="breadcrumb-item active">User Profile</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="box">
                <!-- /.box-header -->
                <div class="box-body">
                    <form role="form">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card card-primary card-outline">
                                    <div class="card-header">
                                        <h3 class="card-title">User Information</h3>
                                        <!-- tools box -->
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool btn-sm" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                            <button type="button" class="btn btn-tool btn-sm" data-widget="remove" data-toggle="tooltip" title="Remove">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </div>
                                        <!-- /. tools -->
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body box-profile" style="display: block;">
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <div class="text-center">
                                                    <img class="profile-user-img img-fluid img-circle" src="/newthemplate/admin/dist/img/user4-128x128.jpg" alt="User profile picture">
                                                </div>
                                            </div>

                                            <div class="col-md-8">
                                                <h3 class="profile-username text-center">
                                                    <input type="text" class="form-control" value="Nina Mcintire">
                                                </h3>

                                                <p class="text-muted text-center">
                                                    <input type="text" class="form-control" value="Software Engineer">
                                                </p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputFile">Change Photo</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="exampleInputFile">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="">Upload</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Email address</label>
                                            <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Password</label>
                                            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                        </div>
                                        <div class="form-group">
                                            <label for="user-type">User Type</label>
                                            <input type="text" class="form-control" id="user-type" placeholder="">
                                        </div>
                                        <div class="form-group">
                                            <label>About:</label>
                                            <textarea class="form-control" rows="3" placeholder="Enter ..."></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </div>


                            </div>
                            <div class="col-md-4">
                                <div class="card card-primary card-outline">
                                    <div class="card-header">
                                        <h3 class="card-title">User Stats</h3>
                                        <!-- tools box -->
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool btn-sm" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                            <button type="button" class="btn btn-tool btn-sm" data-widget="remove" data-toggle="tooltip" title="Remove">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </div>
                                        <!-- /. tools -->
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <p class="lead">Page status:</p>
                                        <p class="text-success"><b>Active</b></p>
                                        <hr>
                                        <p class="lead">Registered:</p>
                                        <p class="text-primary">May 17, 2018</p>
                                        <hr>
                                        <p class="lead">Last Activity:</p>
                                        <p class="text-success">May 21, 2018</p>
                                        <hr>
                                        <a href="#" class="btn btn-danger btn-sm">Delete</a>
                                        <a href="#" class="btn btn-sm btn-primary">Update</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div><!-- /.container-fluid -->

            </div>
        </section>
    </div>
@include("newthemplate.Admin.footer")