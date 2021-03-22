@include("newthemplate.Admin.header")
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Manage Listing</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/getDashBoardPage">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="/admin/listings">Listings</a></li>
                            <li class="breadcrumb-item active">Manage Listing</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->



        <!-- Main content -->


        <section class="content">

            <div class="row">
                <div class="col-md-4">
                    <div class="js-carousel-1 owl-carousel owl-theme">
                        @foreach ($images as $image)
                        <div class="item">
                            <img src="{{ $image->imagePath }}" alt="{{ $image->imagePath }}">
                        </div>
                        @endforeach
                    </div>

                    <div class="js-carousel-2 owl-carousel owl-theme thumb">
                        @foreach ($images as $image)
                        <div class="item">
                            <div calss="item-upload">
                                {{--<img src="/newthemplate/admin/img/cancel.png" alt="Remove" class="clear_buton" title="Remove" width="30" height="30" data-url="{{ route('admin.ads.destroyimage', ['adsimages' => $image->id]) }}"/>--}}
                                <img src="{{ $image->imagePath }}" alt="{{ $image->imagePath }}">
                            </div>
                        </div>
                        @endforeach
                    </div>
                    {{--<input type="file" id="fileupload" multiple="" data-url="{{ route('admin.ads.storeimage', ['ads' => $ads->id]) }}" hidden>
                    <button type="submit" class="btn btn-block btn-primary btn-sm upload" id="fileuploadtrigger"><i class="fa fa-upload"></i>Upload image</button>--}}
                </div>
                <div class="col-md-4">
                    <div class="key-info">
                        <h2>{{ $ads->adsName }}</h2>
                        <div class="rect_text_block">
                            <div class="rect_left_text">Brand:</div>
                            <div class="rect_right_text">{{ $ads->brand }}</div>
                        </div>
                        <div class="rect_text_block">
                            <div class="rect_left_text">Sizes:</div>
                            <div class="rect_right_text">{{ $productSizes }}</div>
                        </div>
                        <div class="rect_text_block">
                            <div class="rect_left_text">Conditions:</div>
                            <div class="rect_right_text">{{ $productConditions }}</div>
                        </div>
                        <div class="rect_text_block">
                            <div class="rect_left_text">Colors:</div>
                            <div class="rect_right_text">{{ $productColors }}</div>
                        </div>
                        <div class="rect_text_block">
                            <div class="rect_left_text">Location:</div>
                            <div class="rect_right_text">{{ $ads->adsCity ?? 'Not chosen'}}</div>
                        </div>
                        <div class="rect_text_block">
                            <div class="rect_left_text">Payment:</div>
                            <div class="rect_right_text">{{ $ads->payment ?? 'Not chosen'}}</div>
                        </div>
                        <div class="rect_text_block">
                            <div class="rect_left_text">Country:</div>
                            <div class="rect_right_text">{{ $ads->adsCountry ?? null }}</div>
                        </div>
                        <div class="rect_text_block">
                            <div class="rect_left_text">City:</div>
                            <div class="rect_right_text">{{ $ads->adsCity ?? null }}</div>
                        </div>
                        <div class="rect_text_block">
                            <div class="rect_left_text">Category:</div>
                            <div class="rect_right_text">{{ $category->categoryName ?? null }}</div>
                        </div>
                        <div class="rect_text_block">
                            <div class="rect_left_text">SubCategory:</div>
                            <div class="rect_right_text">{{ $subcategory->subCategoryName ?? null }}</div>
                        </div>
                        <div class="rect_text_block">
                            <div class="rect_left_text">Applied:</div>
                            <div class="rect_right_text">{{ $ads->images->count() }}</div>
                        </div>
                        <div class="rect_text_block">
                            <div class="rect_left_text">Uploaded:</div>
                            <div class="rect_right_text">{{ $ads->created_at != null ? $ads->created_at->diffForHumans() : 'No date' }}</div>
                        </div>
                        <div class="rect_text_block">
                            <div class="rect_left_text">Price:</div>
                            <div class="rect_right_text">{{ $ads->productTypeSymbol() }} {{ $ads->adsPrice }}</div>
                        </div>
                        <div class="rect_text_block">
                            <div class="rect_left_text">Costs:</div>
                            <div class="rect_right_text">{{ $ads->productTypeSymbol() }} {{ $ads->adsCost }}</div>
                        </div>
                        <div class="rect_text_block">
                            <div class="rect_left_text">Swap:</div>
                            <div class="rect_right_text">{{ $ads->swap == 1 ? 'Yes' : 'No' }}</div>
                        </div>
                    </div>
                    {{--Breadcrumbs
                    <ul class="header_crumbs list-unstyled">
                        <li>
                            <form action="/admin/edit-page/{{ $ads->id }}/breadcrumb" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('patch') }}
                                <div class="input-group input-group-sm mb-1">
                                    <input type="text" value="{{ !empty($ads->breadcrumb->where('type', 1)->first()) ? $ads->breadcrumb->where('type', 1)->first()->content : 'Home' }}" name="content" class="form-control">
                                    <input type="hidden" value="1" name="type">
                                    <div class="input-group-append">
                                        <button class="btn btn-success" type="submit">Save</button>
                                    </div>
                                </div>
                            </form>
                            --}}{{-- <a href="{{ route('home') }}">Home ></a> --}}{{--
                        </li>
                        <!-- <li><a href="#">Categories ></a></li> -->
                        <li>
                            <form action="/admin/edit-page/{{ $ads->id }}/breadcrumb" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('patch') }}
                                <div class="input-group input-group-sm mb-1">
                                    <input type="text" value="{{ !empty($ads->breadcrumb->where('type', 2)->first()) ? $ads->breadcrumb->where('type', 2)->first()->content : (!empty($ads->subcategory->category) ? $ads->subcategory->category->categoryName : '') }}" name="content" class="form-control">
                                    <input type="hidden" value="2" name="type">
                                    <div class="input-group-append">
                                        <button class="btn btn-success" type="submit">Save</button>
                                    </div>
                                </div>
                            </form>
                            --}}{{-- <a href="{{ route('ads.add-listing', ['categoryId' => $ads->subcategory->category->id]) }}">{{ $ads->subcategory->category->categoryName }}</a> > --}}{{--
                        </li>
                        <li>
                            <form action="/admin/edit-page/{{ $ads->id }}/breadcrumb" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('patch') }}
                                <div class="input-group input-group-sm mb-1">
                                    <input type="text" value="{{ !empty($ads->breadcrumb->where('type', 3)->first()) ? $ads->breadcrumb->where('type', 3)->first()->content : (!empty($ads->subcategory) ? $ads->subcategory->subCategoryName : '') }}" name="content" class="form-control">
                                    <input type="hidden" value="3" name="type">
                                    <div class="input-group-append">
                                        <button class="btn btn-success" type="submit">Save</button>
                                    </div>
                                </div>
                            </form>
                            --}}{{-- <a href="{{ route('ads.add-listing', ['subCategoryId' => $ads->subcategory->id]) }}">{{ $ads->subcategory->subCategoryName }}</a> > --}}{{--
                        </li>
                        <li>
                            <form action="/admin/edit-page/{{ $ads->id }}/breadcrumb" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('patch') }}
                                <div class="input-group input-group-sm mb-1">
                                    <input type="text" value="{{ !empty($ads->breadcrumb->where('type', 4)->first()) ? $ads->breadcrumb->where('type', 4)->first()->content : $ads->adsName }}" name="content" class="form-control">
                                    <input type="hidden" value="4" name="type">
                                    <div class="input-group-append">
                                        <button class="btn btn-success" type="submit">Save</button>
                                    </div>
                                </div>
                            </form>
                            --}}{{-- <a>{{ $ads->adsName }}</a> --}}{{--
                        </li>
                    </ul>--}}
                </div>
                <div class="col-md-4">
                    <div class="det-descr">
                        <h2>Description</h2>
                        <p>
                            {!! $ads->adsDescription !!}
                        </p>
                    </div>
                    {{--<a class="btn btn-app edit" href="{{ route('admin.ads.edit', ['ads' => $ads->id]) }}">
                        <i class="fa fa-edit"></i>
                        Edit info
                    </a>--}}
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <table id="example2" class="table table-bordered table-hover dataTable table-listing" role="grid" aria-describedby="example2_info">
                        <tbody>
                            <tr role="row" class="odd">
                                <td class="sorting_1">Status:<br></td>
                                <td class="link-td toggle_status" data-aid="{{ $ads->id }}"><div>{{ $ads->adsStatus }}</div>{{--<a href="#" id="toggle_status" data-tgl='select' data-vals="available,unavailable,pending for payment">change</a>--}}</td>
                            </tr>
                            <tr role="row" class="even">
                                <td class="sorting_1">View:<br><span>{{ $ads->adsViews }}</span></td>
                                <td class=""></td>
                            </tr>
                            <tr role="row" class="odd">
                                @if (!empty($ads->UserAds))
                                <td class="sorting_1">Autor:<br><span>{{ $ads->UserAds->name }}</span></td>
{{--                                <td class="link-td"><a href="{{ route('profile.show', ['profile' => $ads->UserAds->id]) }}">view profile</a></td>--}}
                                <td class="link-td"></td>
                                @endif
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </section>


        <!-- /.content -->
@include("newthemplate.Admin.footer")