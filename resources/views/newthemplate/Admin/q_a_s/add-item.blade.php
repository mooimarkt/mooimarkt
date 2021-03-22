@include("newthemplate.Admin.header")
<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        @if (Route::currentRouteName() == 'qa.item.create')
                        <h1 class="m-0 text-dark">New QA Item</h1>
                        @else
                        <h1 class="m-0 text-dark">Edit QA Item</h1>
                        @endif
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/getDashBoardPage">Dashboard</a></li>
                            @if (Route::currentRouteName() == 'qa.item.create')
                            <li class="breadcrumb-item active">New QA Item</li>
                            @else
                            <li class="breadcrumb-item active">Edit QA Item</li>
                            @endif
                        </ol>
                    </div><!-- /.col -->
                </div>
            </div>
        </div>
        <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
                @if (Route::currentRouteName() == 'qa.item.create')
                <form action="{{ route('qa.item.store') }}" method="POST" id="add-category" enctype="multipart/form-data">
                @else
                <form action="{{ route('qa.item.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                    {{ method_field('post') }}
                @endif
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">QA Item content</h3>
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
                                         'q_a_category_id',
                                         [$categories],
                                         $item->category->id ?? null,
                                         ['class' => 'form-control',
                                         'style' => 'width:100%']
                                    ) }}
                                    </div>

                                    <div class="form-category mb-3">
                                        <label for="category-title"> Item Question:</label>
                                        <textarea class="form-control" id="category-name" name="question" placeholder="QA Item Title" required="required">{{ $item->question or '' }}</textarea>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="category-title"> Item Answer:</label>
                                        <textarea class="form-control" id="category-status" name="answer" placeholder="QA Item Description" required="required">{{ $item->answer or '' }}</textarea>
                                    </div>
                             
                                    @if (Route::currentRouteName() == 'qa.item.create')
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