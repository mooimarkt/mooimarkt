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
                            <li class="breadcrumb-item active">Listings</li>
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
                                                    <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending">Ad id</th>
                                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Info</th>
                                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Price</th>
                                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Link</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($ads as $ad)
                                                <tr role="row" class="odd tr-style">
                                                    <td>{{ $ad->id }}</td>
                                                    <td class="us_prof">
                                                        <div class="us_ph">
                                                            <img src="{{ $ad->images->first()->imagePath ?? '/mooimarkt/img/photo_camera.svg' }}" alt="{{ $ad->adsName }}" class="rounded-circle" />
                                                        </div>
                                                        <div class="us_txt">
                                                            <div>{{ $ad->adsName }}</div>
                                                        </div>
                                                    </td>
                                                    <td>{{ $ad->productTypeSymbol() }} {{ $ad->adsPrice }}</td>
                                                    <td>
                                                        <a href="{{ route('admin.ads.show', ['ads' => $ad->id]) }}" class="btn btn-primary">View</a>
                                                        {{--<a href="{{ route('admin.ads.pdf', ['ads' => $ad->id]) }}" class="btn btn-danger">PDF</a>--}}
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="dataTables_info" id="example1_info" role="status" aria-live="polite">Showing {{ $ads->firstItem() }} to {{ $ads->lastItem() }} of {{ $ads->total() }} entries</div>
                                        <a href="{{ route('sellNow') }}" class="btn btn-primary float-right" target="_blank">Create ads</a>
                                        {{ $ads->links() }}
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