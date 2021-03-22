@include("newthemplate.Admin.header")
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Edit Page</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Edit Page</li>
                        </ol>
                    </div><!-- /.col -->
                </div>
            </div>
        </div>
        <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
                <form action="{{ route('admin.ads.update', ['ads' => $ads->id]) }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('patch') }}
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">Page content</h3>
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
                                <div class="card-body">

                                    <div class="form-group">
                                        <label for="page-title">Page Title</label>
                                        <input type="text" name="adsName" class="form-control" id="page-title" placeholder="My New Page" value="{{ $ads->adsName }}">
                                    </div>
                                    <div class="mb-3">
                                        <textarea id="editor1" name="adsDescription" style="width: 100%">
                                          {{ $ads->adsDescription }}
                                        </textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>


                        </div>
                        <div class="col-md-4">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">Page Information</h3>
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
                                <div class="card-body">
                                    <p class="lead">Page status:</p>
                                    <p class="text-success"><b>{{ $ads->adsStatus or 'no status' }}</b></p>
                                    <hr>
                                    <p class="lead">Created:</p>
                                    <p class="text-primary">{{ \Carbon\Carbon::createFromTimeStamp(strtotime($ads->created_at))->formatLocalized('%B %d, %Y') }}</p>
                                    <hr>
                                    <p class="lead">Last Edited:</p>
                                    <p class="text-success">{{ \Carbon\Carbon::createFromTimeStamp(strtotime($ads->updated_at))->formatLocalized('%B %d, %Y') }}</p>
                                    <hr>
                                    <a href="{{ route('admin.ads.destroy', ['ads' => $ads->id]) }}" class="btn btn-danger btn-sm">Delete</a>
                                    {{-- <a href="#" class="btn btn-sm btn-primary">Update</a> --}}
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