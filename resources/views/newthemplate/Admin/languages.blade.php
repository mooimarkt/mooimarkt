@include("newthemplate.Admin.header")
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Languages manager</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/getDashBoardPage">Dashboard</a></li>
                            <li class="breadcrumb-item active">Languages manager</li>
                        </ol>
                    </div><!-- /.col -->
                </div>
            </div>
        </div>
        <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
                <form role="form" action="/admin/languages/save" method="POST" id="lang-form" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">All languages</h3>
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
                                    @foreach ($Languages as $key => $Language)
                                        <div class="form-group">
                                            <label for="lang{{ $key }}">{{ $Language->name }}</label>
                                            <select id="lang{{ $key }}" name="lang[{{ $Language->id }}]" data-id="{{ $Language->id }}" class="form-control">
                                                <option value="1" @if ($Language->status == 1) selected @endif>Active</option>
                                                <option value="0" @if ($Language->status == 0) selected @endif>Inactive</option>
                                            </select>
                                        </div>
                                    @endforeach

                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>


                        </div>
                    </div>
                </form>
            </div><!-- /.container-fluid -->

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