@include("newthemplate.Admin.header")
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Admin Profile</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/getDashBoardPage">Dashboard</a></li>
                        <li class="breadcrumb-item active">Admin Profile</li>
                    </ol>
                </div><!-- /.col -->
            </div>
        </div>
    </div>
    <div class="box">
        <!-- /.box-header -->
        <div class="box-body">
            <form role="form" action="/admin/update-profile" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-8">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title">User Information</h3>
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
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <div class="text-center icon_thumbnails">
                                            <img class="img img-rounded"  width="100px" height="100px"
                                                 style="margin-left: auto; margin-right: auto; display: block;" src="{{ auth()->user()->avatar }}" alt="User profile picture">
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h3 class="profile-username text-center">
                                            <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                                   placeholder="Nina" name="name" value="{{ auth()->user()->name }}">
                                        </h3>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputFile">Upload Photo</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input{{ $errors->has('avatar') ? ' is-invalid' : '' }}"
                                                   accept="image/*" id="userProfileImage" name="avatar">
                                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email address</label>
                                    <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                           id="exampleInputEmail1" placeholder="Enter email" name="email"  value="{{ auth()->user()->email }}">
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong style="color:red">{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Password</label>
                                    <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                           id="exampleInputPassword1" placeholder="Password" name="password" value="********">
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong style="color:red">{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Confirm Password</label>
                                    <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                           id="exampleInputPassword1" placeholder="Password" name="password_confirmation" value="********">
                                </div>
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

</div>
</div>
</div>

<section class="content">
</section>

<!-- /.content -->
@include("newthemplate.Admin.footer")

<script>
    let $inputFile = $('#userProfileImage');
    let $inputImage = $('input[name="image"]');

    $inputFile.on('change', function () {
        if (typeof $(this).prop('files')[0] !== 'undefined') {
            if ($(this).prop('files')[0].type.split('/')[0] === 'image') {
                let reader = new FileReader();

                reader.onload = function (e) {
                    $('.icon_thumbnails img').attr('src', e.target.result);
                    $('.icon_thumbnails').show();
                };

                reader.readAsDataURL($(this).prop('files')[0]);
                file = $(this).prop('files')[0];
                $('.custom-file-label').text(file.name);
                $inputImage.val('');
            } else {
                swal.fire('Error!', 'The file must be an image.', 'error');
                $(this).val('');
            }
        }
    });
</script>