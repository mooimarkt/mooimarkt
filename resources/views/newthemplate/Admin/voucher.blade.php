@include("newthemplate.Admin.header")
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Vouchers</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/getDashBoardPage">Dashboard</a></li>
                            <li class="breadcrumb-item active">Vouchers</li>
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
                                                <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending">id</th>
                                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Code</th>
                                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Name</th>
                                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Discount</th>
                                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Multiple Redeem</th>
                                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Link</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($vouchers as $voucher)
                                                <tr role="row" class="odd tr-style">
                                                    <td>{{ $voucher->id }}</td>
                                                    <td>{{ $voucher->voucherCode }}</td>
                                                    <td>{{ $voucher->voucherName }}</td>
                                                    <td>{{ $voucher->discountValue.($voucher->discountType == 'percentage' ? '%' : '€') }}</td>
                                                    <td>{{ ucfirst($voucher->multipleRedeem) }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-block btn-danger btn-sm delete_voucher" data-voucher_id="{{ $voucher->id }}">Delete</button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                <tr role="row" class="odd tr-style createVoucher">
                                                    <td>#</td>
                                                    <td>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control voucherCode" placeholder="Voucher Code" name="voucherCode" form="createVoucher">
                                                            <div class="input-group-append">
                                                                <button class="btn btn-outline-secondary genarate" type="button"><i class="fa fa-refresh"></i></button>
                                                            </div>
                                                        </div>
                                                    <td><input type="text" class="form-control" placeholder="Voucher Name" name="voucherName" form="createVoucher"></td>
                                                    <td>
                                                        <div class="input-group">
                                                            <input type="text" name="discountValue" class="form-control" form="createVoucher" value="0">
                                                            <div class="input-group-append">
                                                                <select name="discountType" class="form-control" form="createVoucher">
                                                                    <option value="percentage" selected="selected">%</option>
                                                                    <option value="unit">€</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><input type="checkbox" class="form-control"  name="multipleRedeem" checked="checked" form="createVoucher"></td>
                                                    <td>
                                                        <form action="{{ route('voucher.store') }}" method="POST" id="createVoucher">
                                                            {{ csrf_field() }}
                                                            <button type="submit" class="btn btn-block btn-success btn-sm">Create</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="dataTables_info" id="example1_info" role="status" aria-live="polite">Showing {{ $vouchers->firstItem() }} to {{ $vouchers->lastItem() }} of {{ $vouchers->total() }} entries</div>
                                        {{ $vouchers->links() }}
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