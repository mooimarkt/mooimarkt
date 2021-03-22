@include("newthemplate.Admin.header")
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Sitemap</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/getDashBoardPage">Dashboard</a></li>
                        <li class="breadcrumb-item active">Sitemap</li>
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
                                <h3 class="card-title">Sitemap XML</h3>
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
                                <button type="submit" class="btn btn-primary" form="generateSitemap">Generate manually</button>
                                @if (file_exists(public_path('sitemap.xml')))
                                <p class="text-muted">Last update: {{ \Carbon\Carbon::createFromTimeStamp(filemtime(public_path('sitemap.xml')))->diffForHumans() }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </form>
            <form action="/admin/sitemap/generate" method="POST" id="generateSitemap">
                {{ csrf_field() }}
            </form>
        </div><!-- /.container-fluid -->

    </div>
</div>
@include("newthemplate.Admin.footer")