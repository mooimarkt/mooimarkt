@include("newthemplate.Admin.header")
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Dashboard</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">Dashboard</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">

                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $adsCount }}</h3>

                                <p>Listings</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="/admin/listings" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $meetingCount }}</h3>

                                <p>Meetings</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="/admin/meetings" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $userCount }}</h3>

                                <p>Users</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="/admin/users/all" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $totalTransaction }}</h3>

                                <p>Payments</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                            <a href="/admin/payments" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>
                <!-- /.row -->
                <!-- Main row -->
                <div class="row">
                    <!-- Left col -->
                    <section class="col-lg-12 connectedSortable">

                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fa fa-bar-chart-o"></i>
                                    Sales
                                </h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-widget="collapse">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-widget="remove">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="bar-chart" style="height: 345px;"></div>
                            </div>
                            <!-- /.card-body-->
                        </div>

                    </section>
                    <!-- /.Left col -->
                    <!-- right col (We are only adding the ID to make the widgets sortable)-->
                    {{-- <section class="col-lg-5 connectedSortable">

                        <!-- Map card -->
                        <div class="card bg-primary-gradient">
                            <div class="card-header no-border">
                                <h3 class="card-title">
                                    <i class="fa fa-map-marker mr-1"></i>
                                    Visitors
                                </h3>
                                <!-- card tools -->
                                <div class="card-tools">
                                    <button type="button"
                                            class="btn btn-primary btn-sm daterange"
                                            data-toggle="tooltip"
                                            title="Date range">
                                        <i class="fa fa-calendar"></i>
                                    </button>
                                    <button type="button"
                                            class="btn btn-primary btn-sm"
                                            data-widget="collapse"
                                            data-toggle="tooltip"
                                            title="Collapse">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                                <!-- /.card-tools -->
                            </div>
                            <div class="card-body">
                                <div id="world-map" style="height: 250px; width: 100%;"></div>
                            </div>
                            <!-- /.card-body-->
                            <div class="card-footer bg-transparent">
                                <div class="row">
                                    <div class="col-4 text-center">
                                        <div id="sparkline-1"></div>
                                        <div class="text-white">Visitors</div>
                                    </div>
                                    <!-- ./col -->
                                    <div class="col-4 text-center">
                                        <div id="sparkline-2"></div>
                                        <div class="text-white">Online</div>
                                    </div>
                                    <!-- ./col -->
                                    <div class="col-4 text-center">
                                        <div id="sparkline-3"></div>
                                        <div class="text-white">Sales</div>
                                    </div>
                                    <!-- ./col -->
                                </div>
                                <!-- /.row -->
                            </div>
                        </div>
                        <!-- /.card -->
                    </section> --}}
                    <!-- right col -->
                </div>
                <!-- /.row (main row) -->
            </div><!-- /.container-fluid -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">Last Published Listings</h1>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <div class="box">
                <!-- /.box-header -->
                <div class="box-body box-user">
                    <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                                    <thead>
                                    <tr role="row">
                                        <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending">Ad id</th>
                                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Info</th>
                                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Price</th>
                                        <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Link</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($lastAds as $ad)
                                        <tr role="row" class="odd tr-style">
                                            <td>{{ $ad->id }}</td>
                                            <td class="us_prof">
                                                <div class="us_ph"><img src="{{ $ad->adsImage or '/newthemplate/img/logo.svg' }}" alt="{{ $ad->adsName }}" class="rounded-circle" /></div>
                                                <div class="us_txt">
                                                    <div>{{ $ad->adsName }}</div>
                                                </div>
                                            </td>
                                            <td>{{ $ad->adsPriceWithType() }}</td>
                                            <td>
                                                <a href="{{ route('product', ['ads' => $ad->id]) }}" class="btn btn-primary btn-block">View</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                        
                                        {{-- <tr role="row" class="odd tr-style">
                                            <td>15</td>
                                            <td class="us_prof">
                                                <div class="us_ph"><img src="/newthemplate/admin/img/rect_car_2.jpg" alt="Alternate Text" /></div>
                                                <div class="us_txt">
                                                    <div>Bugatti Bike</div>
                                                </div>
                                            </td>
                                            <td>$1 999 999</td>
                                            <td>
                                                <a href="/admin/listing-management" class="btn btn-block btn-primary">View</a>
                                            </td>
                                        </tr>
                                        <tr role="row" class="odd tr-style">
                                            <td>15</td>
                                            <td class="us_prof">
                                                <div class="us_ph"><img src="/newthemplate/admin/img/rect_car_3.jpg" alt="Alternate Text" /></div>
                                                <div class="us_txt">
                                                    <div>Bugatti Bike</div>
                                                </div>
                                            </td>
                                            <td>$1 999 999</td>
                                            <td>
                                                <a href="/admin/listing-management" class="btn btn-block btn-primary">View</a>
                                            </td>
                                        </tr>
                                        <tr role="row" class="odd tr-style">
                                            <td>13</td>
                                            <td class="us_prof">
                                                <div class="us_ph"><img src="/newthemplate/admin/img/rect_car_4.jpg" alt="Alternate Text" /></div>
                                                <div class="us_txt">
                                                    <div>Bugatti Bike</div>
                                                </div>
                                            </td>
                                            <td>$1 999 999</td>
                                            <td>
                                                <a href="/admin/listing-management" class="btn btn-block btn-primary">View</a>
                                            </td>
                                        </tr>
                                        <tr role="row" class="odd tr-style">
                                            <td>14</td>
                                            <td class="us_prof">
                                                <div class="us_ph"><img src="/newthemplate/admin/img/rect_car_5.jpg" alt="Alternate Text" /></div>
                                                <div class="us_txt">
                                                    <div>Bugatti Bike</div>
                                                </div>
                                            </td>
                                            <td>$1 999 999</td>
                                            <td>
                                                <a href="/admin/listing-management" class="btn btn-block btn-primary">View</a>
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
        </section>
        <!-- /.content -->
    </div>
@include("newthemplate.Admin.footer")