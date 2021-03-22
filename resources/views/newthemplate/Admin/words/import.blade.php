@include("newthemplate.Admin.header")

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Import Words</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/getDashBoardPage">Dashboard</a></li>
                        <li class="breadcrumb-item active">Import Words</li>
                    </ol>
                </div><!-- /.col -->
            </div>
        </div>
    </div>
    <div class="box">
        <a href="{{ route('words.list') }}" id="add-lang" class="btn btn-success">Back</a>
        <br>
        <br>
        <!-- /.box-header -->
        <div class="box-body">
            <form role="form" action="{{ route('words.import') }}" enctype="multipart/form-data" method="post">
                {{ csrf_field() }}

                    <div class="col-md-8">
                        <div class="card card-primary card-outline">
                            <hr>
                            <!-- /.card-header -->
                            <div class="card-body box-profile">

                                <div class="form-group">
                                    <label for="file">File</label>
                                    <input id="file" name="file" type="file">

                                </div>
                            </div>

                            <div class="form-group">
                                <input type="submit" class="btn btn-block btn btn-primary" value="Upload">
                            </div>
                        </div>
                    </div>
            </form>
        </div><!-- /.container-fluid -->

    </div>
</div>

@include("newthemplate.Admin.footer")

