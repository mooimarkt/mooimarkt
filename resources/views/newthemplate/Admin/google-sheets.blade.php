@include("newthemplate.Admin.header")
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Google Sheets</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/getDashBoardPage">Dashboard</a></li>
                        <li class="breadcrumb-item active">Google Sheets</li>
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
                                <h3 class="card-title">Google Sheet API</h3>
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

							<?php
							$refresh_url = false;
							try {
								$SheetContr = new \App\GoogleSheets();
								$token      = App\Option::getSetting( "opt_google_sheets_token", false );
								$client     = $SheetContr->Client();
								$SheetContr->Auth( $client );
								$refresh_url = $client->createAuthUrl();
							} catch ( \Exception $e ) {
							}
							?>
                            <div class="card-body box-profile">
                                <ul class="nav nav-tabs mb-3">
                                    @if($refresh_url)
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#actions"
                                           role="tab" aria-controls="home" aria-selected="true">Actions</a>
                                    </li>
                                    @endif
                                    <li class="nav-item">
                                        <a class="nav-link @if(!$refresh_url) active @endif" data-toggle="tab" href="#json" role="tab">Credentials.json</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#upload" role="tab">Upload credentials.json</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#service_account" role="tab">service_account.json</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#upload_service_account" role="tab">Upload service_account.json</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    @if($refresh_url)
                                    <div class="tab-pane active" id="actions" role="tabpanel">
                                        <div class="form-group">
                                            {{-- <a href="{{$client->createAuthUrl()}}" class="btn btn-primary" >{{$token && !$client->isAccessTokenExpired() ? "ReAuthorise" : "Authorise"}}</a> --}}
                                            <a href="/google/import" class="btn btn-primary" >Import</a>
                                            <a href="javascript:void(0)" class="btn btn-secondary export">Export</a>
                                        </div>
                                    </div>
                                    @endif
                                    @if(session('success'))
                                            <script>
                                                setTimeout(function () {

                                                    var cnt = document.createElement('div');
                                                    cnt.innerHTML =  "Imported New Categories: {{count(session('success')['Categories']['new'])}} <br/>"+
                                                        "Imported New SubCategories: {{count(session('success')['SubCategories']['new'])}} <br/>"+
                                                        "Updated Categories: {{count(session('success')['Categories']['updated'])}} <br/>"+
                                                        "Updated SubCategories: {{count(session('success')['SubCategories']['updated'])}} <br/>"+
                                                        "Deleted Categories: {{session('success')['Categories']['deleted']}} <br/>"+
                                                        "Deleted SubCategories: {{session('success')['SubCategories']['deleted']}} <br/>";

                                                    swal({
                                                        icon:"success",
                                                        title:'Imported',
                                                        content:cnt
                                                    })
                                                },1000);
                                            </script>
                                    @endif
                                    <div class="tab-pane @if(!$refresh_url) active @endif" id="json" role="tabpanel">
                                        <div class="form-group">
                                            <label for="">credentials.json</label>
                                            <textarea name="opt_google_sheets" id="opt_google_sheets" cols="30"
                                                      rows="10" class="form-control"
                                                      onclick="prettyPrint(this)">{{\App\Option::getSetting("opt_google_sheets")}}</textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                    <div class="tab-pane" id="upload" role="tabpanel">
                                        <div class="form-group">
                                            <input type="file" name="opt_google_sheets" class="form-control optionsUpload" form="optionsUpload">
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="service_account" role="tabpanel">
                                        <div class="form-group">
                                            <label for="opt_google_sheets_service_account">service_account.json</label>
                                            <textarea name="opt_google_sheets_service_account" id="opt_google_sheets_service_account" cols="30"
                                                      rows="10" class="form-control"
                                                      onclick="prettyPrint(this)">{{\App\Option::getSetting("opt_google_sheets_service_account")}}</textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                    <div class="tab-pane" id="upload_service_account" role="tabpanel">
                                        <div class="form-group">
                                            <input type="file" name="opt_google_sheets_service_account" class="form-control optionsUpload" form="optionsUpload">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </form>
            <form action="/admin/options/upload" method="POST" enctype="multipart/form-data" id="optionsUpload">
                {{ csrf_field() }}
            </form>
        </div><!-- /.container-fluid -->

    </div>
</div>
@include("newthemplate.Admin.footer")