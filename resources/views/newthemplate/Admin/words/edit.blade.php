@include("newthemplate.Admin.header")
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Translate word</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/getDashBoardPage">Dashboard</a></li>
                        <li class="breadcrumb-item active">Translate word</li>
                    </ol>
                </div><!-- /.col -->
            </div>
        </div>
    </div>
    <div class="content">
        <div class="box">
        <a href="{{ route('words.list') }}" id="add-lang" class="btn btn-success">Back</a>
        <br>
        <br>
        <!-- /.box-header -->
        <div class="box-body">
            <form role="form"  action="{{ route('words.edit', $word->id) }}"  method="post">
                {{ csrf_field() }}

                <div class="row">
                    <div class="col-md-8">
                        <div class="card card-primary card-outline">
                            <hr>

                            <!-- /.card-header -->
                            <div class="card-body box-profile">

                                @foreach($languages as $language)
                                    <div class="form-group">
                                        <label for="title">{{ $language->name }} ({{ $language->slug }})</label>
                                        <textarea class="form-control" id="title" name="data[{{ $language->id }}]">{{ isset($word->data[$language->id]) ? $word->data[$language->id] : '' }}</textarea>
                                    </div>
                                @endforeach
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-block btn-success" value="Save">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div><!-- /.container-fluid -->

    </div>
    </div>
</div>


@include("newthemplate.Admin.footer")



