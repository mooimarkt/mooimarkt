@include("newthemplate.Admin.header")
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Payments</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/getDashBoardPage">Dashboard</a></li>
                            <li class="breadcrumb-item active">Payments</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <div class="box">
            <!-- /.box-header -->
            <div class="box-body box-user">
                <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-bordered table-striped" role="grid" aria-describedby="example1_info">
                                <thead>
                                <tr role="row">
                                    <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="text-align: center;">Payment id</th>
                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="">Ad</th>
                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="">Method</th>
                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="">Type</th>
                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending" style="">Price</th>
                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" style="">Code</th>
                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" style="">Email</th>
                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending" style="">Status</th>
                                    {{-- <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" style="text-align:right; padding-right: 10px;padding-left:40px;">Actions</th> --}}
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($payments as $payment)
                                    <tr role="row" class="odd tr-style">
                                        <td class="sorting_1" style="text-align: center;">{{ $payment->id }}</td>
                                        <td>
                                            <a href="/profile/{{$payment->user->id}}" target="_blank">{{ $payment->user->name }}</a>
                                        </td>
                                        <td>{{ $payment->method }}</td>
                                        <td>{{ ucwords($payment->type) }}</td>
                                        <td>{{ $payment->total }} {{ $payment->currency }}</td>
                                        <td>{{ $payment->transaction_id }}</td>
                                        <td>{{ $payment->email }}</td>
                                        <td>{{ ucwords(str_replace(['-', '_'], ' ', $payment->status)) }}</td>
                                        {{-- <td class="us_prof">
                                            <div class="us_ph"><img src="/newthemplate/admin/dist/img/avatar.png" alt="Alternate Text" /></div>
                                            <div class="us_txt">
                                                <div>Cara Delevinge</div>
                                                <a href="#">Profile</a>
                                            </div>
                                        </td>
                                        {{-- <td>
                                            <button type="button" class="btn btn-block btn-success btn-sm">Confirm</button>
                                            <button type="button" class="btn btn-block btn-danger btn-sm">Delete</button>
                                        </td> --}}
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="dataTables_info" id="example1_info" role="status" aria-live="polite">Showing {{ $payments->firstItem() }} to {{ $payments->lastItem() }} of {{ $payments->total() }} payments</div>
                            <div class="float-right">{{$payments->links()}}</div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <div class=""></div>
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->

        </div>
    </div>
   @include("newthemplate.Admin.footer")