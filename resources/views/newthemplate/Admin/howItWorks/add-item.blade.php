@include("newthemplate.Admin.header")
<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        @if (Route::currentRouteName() == 'howWorks.item.create')
                        <h1 class="m-0 text-dark">New How It Works Item</h1>
                        @else
                        <h1 class="m-0 text-dark">Edit How It Works Item</h1>
                        @endif
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/getDashBoardPage">Dashboard</a></li>
                            @if (Route::currentRouteName() == 'howWorks.item.create')
                            <li class="breadcrumb-item active">New How It Works Item</li>
                            @else
                            <li class="breadcrumb-item active">Edit How It Works Item</li>
                            @endif
                        </ol>
                    </div><!-- /.col -->
                </div>
            </div>
        </div>
        <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
                @if (Route::currentRouteName() == 'howWorks.item.create')
                <form action="{{ route('howWorks.item.store') }}" method="POST" id="add-category" enctype="multipart/form-data">
                @else
                <form action="{{ route('howWorks.item.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                    {{ method_field('post') }}
                @endif
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">How It Works Item content</h3>
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
                                    <div class="form-category mb-3">
                                        <label for="category-title"> Category:</label>
                                        {{ Form::select(
                                         'how_works_category_id',
                                         [$categories],
                                         $item->category->id ?? null,
                                         ['class' => 'form-control',
                                         'style' => 'width:100%',
                                         ]
                                    ) }}
                                    </div>
                                    <div class="form-category mb-3">
                                        <label for="category-title">Item Title:</label>
                                        <input type="text" class="form-control" name="title" placeholder="How It Works Category Title" required="required" value="{{ $item->title or '' }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="category-title">Item Description:</label>
                                        <textarea class="form-control" name="description" placeholder="How It Works Category Description" required="required">{{ $item->description or '' }}</textarea>
                                    </div>
                                    <div class="form-group mb-3">
                                    <label for="category-title">Item Image:</label>
                                        <div>
                                            @if (isset($item))
                                            <img src="{{ $item->image }}" alt="">
                                            @else
                                            <img src="/mooimarkt/img/photo_camera.svg" alt="">
                                            @endif
                                        </div>
                                        <br>
                                    <input type="file" class="form-control" id="category-image" name="image" placeholder="Category Image"{{ (Route::currentRouteName() == 'howWorks.item.create') ? 'required="required" ' : '' }}>

                                    @if (Route::currentRouteName() == 'howWorks.item.create')
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    @else
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    @endif

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