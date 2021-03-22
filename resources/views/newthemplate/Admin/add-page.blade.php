@include("newthemplate.Admin.header")
<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">New Page</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/getDashBoardPage">Dashboard</a></li>
                            @if (Route::currentRouteName() == 'admin.pages.add-page')
                            <li class="breadcrumb-item active">New Page</li>
                            @else
                            <li class="breadcrumb-item active">Edit Page</li>
                            @endif
                        </ol>
                    </div><!-- /.col -->
                </div>
            </div>
        </div>
        <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
                @if (Route::currentRouteName() == 'admin.pages.add-page')
                <form action="{{ route('pages.store') }}" method="POST" id="add-page">
                @else
                <form action="{{ route('pages.update', ['page' => $page->page]) }}" method="POST" id="add-page">
                    {{ method_field('patch') }}
                @endif
                    {{ csrf_field() }}
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
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
                                        <label for="page-title">Page Link</label>
                                        <input type="text" class="form-control" id="page-link" name="page" placeholder="about" {{ isset($page) ? 'disabled' : '' }} required="required" value="{{ $page->page or '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="page-title">Page Title</label>
                                        <input type="text" class="form-control" id="page-title" name="title" placeholder="My New Page" value="{{ $page->title or '' }}">
                                    </div>
                                    <div class="mb-3">
                                <textarea id="editor1" style="width: 100%" name="content">{{ $page->content or '' }}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="page-title">SEO Title</label>
                                        <input type="text" class="form-control" id="page-title" name="meta_title" value="{{ $page->meta_title or '' }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="page-title">SEO Description</label>
                                        <input type="text" class="form-control" id="page-title" name="meta_description" value="{{ $page->meta_description or '' }}">
                                    </div>
                                    @if (Route::currentRouteName() == 'admin.pages.add-page')
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    @else
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    @endif
                                    
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
                                    {{-- <p class="text-muted"><b>Draft</b></p> --}}
                                    @php
                                        $statuses = array('published', 'draft', 'deleted');
                                    @endphp
                                    <select name="status" class="form-control" form="add-page">
                                        @foreach ($statuses as $status)
                                        <option value="{{ $status }}"{{ (isset($page) && $status == $page->status) ? ' selected' : '' }}>{{ $status }}</option>
                                        @endforeach
                                    </select>
                                    <hr>
                                    <p class="lead">Created:</p>
                                    <p class="text-primary">{{ isset($page) ? \Carbon\Carbon::createFromTimeStamp(strtotime($page->created_at))->formatLocalized('%B %d, %Y') : '-' }}</p>
                                    <hr>
                                    <p class="lead">Last Edited:</p>
                                    <p class="text-success">{{ isset($page) ? \Carbon\Carbon::createFromTimeStamp(strtotime($page->updated_at))->formatLocalized('%B %d, %Y') : '-' }}</p>
                                    <hr>
                                    <a href="#" class="btn btn-danger btn-sm deletePage">Delete</a>
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