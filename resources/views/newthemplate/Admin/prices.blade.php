@include("newthemplate.Admin.header")
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Settings</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/getDashBoardPage">Dashboard</a></li>
                        <li class="breadcrumb-item active">Settings</li>
                    </ol>
                </div><!-- /.col -->
            </div>
        </div>
    </div>
    <div class="box">
        <!-- /.box-header -->
        <div class="box-body">
            <form role="form" action="/admin/options/save" method="post">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Place add prices</h3>
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
                            <div class="card-body box-profile">
                                <div class="form-group">
                                    <label for="">Basic</label>
                                    <input type="text" class="form-control"
                                           name="opt_pack_basic" placeholder="1.5" pattern="\d+(\.\d)?"
                                           value="{{\App\Option::getSetting("opt_pack_basic")}}" placeholder="">
                                </div>
{{--                                <div class="form-group">
                                    <label for="">Auto bump</label>
                                    <input type="text" class="form-control"
                                           name="opt_pack_auto_bump"
                                           value="{{\App\Option::getSetting("opt_pack_auto_bump")}}" id=""
                                           placeholder="">
                                </div>--}}
                                <div class="form-group">
                                    <label for="">First Listed</label>
                                    <input type="text"
                                           class="form-control"
                                           name="opt_pack_spotlight" placeholder="0.35" pattern="\d+(\.\d{2})?"
                                           value="{{\App\Option::getSetting("opt_pack_spotlight")}}" id=""
                                           placeholder="">
                                </div>
                                <button type="submit" class="btn btn-primary">Save</button>

                            </div>
                        </div>

                        {{--<div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Subscription package prices</h3>
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
                            <div class="card-body box-profile">
                                <div class="form-group">
                                    <label for="">Subscription 1</label>
                                    <input type="text" class="form-control"
                                           name="opt_subscription_1"
                                           value="{{\App\Option::getSetting("opt_subscription_1")}}" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="">Subscription 2</label>
                                    <input type="text" class="form-control"
                                           name="opt_subscription_2"
                                           value="{{\App\Option::getSetting("opt_subscription_2")}}" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="">Subscription 3</label>
                                    <input type="text"
                                           class="form-control"
                                           name="opt_subscription_3"
                                           value="{{\App\Option::getSetting("opt_subscription_3")}}" placeholder="">
                                </div>
                                <button type="submit" class="btn btn-primary">Save</button>

                            </div>
                        </div>--}}
                    </div>

                </div>
            </form>
        </div><!-- /.container-fluid -->

    </div>
</div>
@include("newthemplate.Admin.footer")
