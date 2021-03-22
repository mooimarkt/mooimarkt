@include("newthemplate.Admin.header")
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Invoices</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/getDashBoardPage">Dashboard</a></li>
                            <li class="breadcrumb-item active">Invoices</li>
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
                                                    <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="ascending">Invoice id</th>
                                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Listing id</th>
                                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Date</th>
                                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Pdf</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($Invoices as $Invoice)
                                                <tr role="row" class="odd tr-style">
                                                    <td>{{ $Invoice->id }}</td>
                                                    <td>{{ (intval($Invoice->listing_id) != 0) ? $Invoice->listing_id : '' }}</td>
                                                    <td>{{ $Invoice->date }}</td>
                                                    <td>
                                                        <a href="{{ url('/pdf/'.$Invoice->invoice) }}" target="_blank" class="btn btn-danger">PDF</a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="dataTables_info" id="example1_info" role="status" aria-live="polite">Showing {{ $Invoices->firstItem() }} to {{ $Invoices->lastItem() }} of {{ $Invoices->total() }} entries</div>

                                        {{ $Invoices->links() }}
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