@include("newthemplate.Admin.header")
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Settings</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/getDashBoardPage">Dashboard</a></li>
                        <li class="breadcrumb-item active">Settings</li>
                    </ol>
                </div><!-- /.col -->
            </div>
        </div>
    </div>
    <div class="box">
        <!-- /.box-header -->
        <div class="box-body">
            <form role="form" action="/admin/options/save" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Payment Information</h3>
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
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="">PayPal ID</label>
                                            <input type="text" class="form-control"
                                                   name="opt_payment_paypal[client_id]"
                                                   value="{{ json_decode(\App\Option::getSetting("opt_payment_paypal"))->client_id ?? '' }}" placeholder="">
                                        </div>
                                        <div class="form-group">
                                            <label for="">PayPal Secret</label>
                                            <input type="text" class="form-control"
                                                   name="opt_payment_paypal[secret]"
                                                   value="{{ json_decode(\App\Option::getSetting("opt_payment_paypal"))->secret ?? '' }}" placeholder="">
                                        </div>

                                        <div class="form-group">
                                            <label for="">PayPal Mode</label>
                                            <select name="opt_payment_paypal[mode]" class="form-control">
                                                <option value="sandbox" {{ (json_decode(\App\Option::getSetting("opt_payment_paypal"))->mode ?? '') == 'sandbox' ? 'selected' : '' }}>sandbox</option>
                                                <option value="live" {{ (json_decode(\App\Option::getSetting("opt_payment_paypal"))->mode ?? '') == 'live' ? 'selected' : '' }}>live</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="">Stripe Secret</label>
                                            <input type="text" class="form-control"
                                                   name="opt_payment_stripe[secret]"
                                                   value="{{ json_decode(\App\Option::getSetting("opt_payment_stripe"))->secret ?? '' }}" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>

                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Payout Information</h3>
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
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="">PayPal ID</label>
                                            <input type="text" class="form-control"
                                                   name="opt_payout_paypal[client_id]"
                                                   value="{{ json_decode(\App\Option::getSetting("opt_payout_paypal"))->client_id ?? '' }}" placeholder="">
                                        </div>
                                        <div class="form-group">
                                            <label for="">PayPal Secret</label>
                                            <input type="text" class="form-control"
                                                   name="opt_payout_paypal[secret]"
                                                   value="{{ json_decode(\App\Option::getSetting("opt_payout_paypal"))->secret ?? '' }}" placeholder="">
                                        </div>

                                        <div class="form-group">
                                            <label for="">PayPal Mode</label>
                                            <select name="opt_payout_paypal[mode]" class="form-control">
                                                <option value="sandbox" {{ (json_decode(\App\Option::getSetting("opt_payout_paypal"))->mode ?? '') == 'sandbox' ? 'selected' : '' }}>sandbox</option>
                                                <option value="live" {{ (json_decode(\App\Option::getSetting("opt_payout_paypal"))->mode ?? '') == 'live' ? 'selected' : '' }}>live</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="">Stripe Secret</label>
                                            <input type="text" class="form-control"
                                                   name="opt_payout_stripe[secret]"
                                                   value="{{ json_decode(\App\Option::getSetting("opt_payout_stripe"))->secret ?? '' }}" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>

                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Exchange Courses</h3>
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
                                <div class="form-group">
                                    <label for="">EUR/USD</label>
                                    <input  type="number" min="0" step="0.0000000001" class="form-control"
                                           name="opt_exchange_eur_usd"
                                           value="{{\App\Option::getSetting("opt_exchange_eur_usd")}}" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="">EUR/GBP</label>
                                    <input type="number" min="0" step="0.0000000001" class="form-control"
                                           name="opt_exchange_eur_gbp"
                                           value="{{\App\Option::getSetting("opt_exchange_eur_gbp")}}" id=""
                                           placeholder="">
                                </div>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>

{{--                        <div class="card card-primary card-outline">--}}
{{--                            <div class="card-header">--}}
{{--                                <h3 class="card-title">Vat API Key</h3>--}}
{{--                                <!-- tools box -->--}}
{{--                                <div class="card-tools">--}}
{{--                                    <button type="button" class="btn btn-tool btn-sm"--}}
{{--                                            data-widget="collapse"--}}
{{--                                            data-toggle="tooltip"--}}
{{--                                            title="Collapse">--}}
{{--                                        <i class="fa fa-minus"></i>--}}
{{--                                    </button>--}}
{{--                                    <button type="button" class="btn btn-tool btn-sm"--}}
{{--                                            data-widget="remove"--}}
{{--                                            data-toggle="tooltip"--}}
{{--                                            title="Remove">--}}
{{--                                        <i class="fa fa-times"></i>--}}
{{--                                    </button>--}}
{{--                                </div>--}}
{{--                                <!-- /. tools -->--}}
{{--                            </div>--}}
{{--                            <!-- /.card-header -->--}}
{{--                            <div class="card-body box-profile">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="">Vat API Key</label>--}}
{{--                                    <a href="https://vatapi.com/dashboard" target="_blank" title=""><i class="fa fa-external-link"></i></a>--}}
{{--                                    <input  type="text" class="form-control"--}}
{{--                                           name="opt_vatapi_key"--}}
{{--                                           value="{{\App\Option::getSetting("opt_vatapi_key")}}" placeholder="">--}}
{{--                                </div>--}}
{{--                                <button type="submit" class="btn btn-primary">Save</button>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="card card-primary card-outline">--}}
{{--                            <div class="card-header">--}}
{{--                                <h3 class="card-title">Google Analytics Integration</h3>--}}
{{--                                <!-- tools box -->--}}
{{--                                <div class="card-tools">--}}
{{--                                    <button type="button" class="btn btn-tool btn-sm"--}}
{{--                                            data-widget="collapse"--}}
{{--                                            data-toggle="tooltip"--}}
{{--                                            title="Collapse">--}}
{{--                                        <i class="fa fa-minus"></i>--}}
{{--                                    </button>--}}
{{--                                    <button type="button" class="btn btn-tool btn-sm"--}}
{{--                                            data-widget="remove"--}}
{{--                                            data-toggle="tooltip"--}}
{{--                                            title="Remove">--}}
{{--                                        <i class="fa fa-times"></i>--}}
{{--                                    </button>--}}
{{--                                </div>--}}
{{--                                <!-- /. tools -->--}}
{{--                            </div>--}}
{{--                            <!-- /.card-header -->--}}
{{--                            <div class="card-body box-profile">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="">Tracking ID</label>--}}
{{--                                    <a href="https://analytics.google.com/analytics/web/?authuser" target="_blank" title=""><i class="fa fa-external-link"></i></a>--}}
{{--                                    <input  type="text" class="form-control"--}}
{{--                                           name="opt_google_analytics_trackingid"--}}
{{--                                           value="{{\App\Option::getSetting("opt_google_analytics_trackingid")}}" placeholder="UA-122384033-1">--}}
{{--                                </div>--}}
{{--                                <button type="submit" class="btn btn-primary">Save</button>--}}
{{--                            </div>--}}
{{--                        </div>--}}

                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Social links</h3>
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
                                <div class="form-group">
                                    <label for="">Facebook</label>
                                    <a href="{{\App\Option::getSetting("opt_link_facebook") ?? 'https://www.facebook.com'}}" target="_blank" title=""><i class="fa fa-external-link"></i></a>
                                    <input  type="text" class="form-control"
                                            name="opt_link_facebook"
                                            value="{{\App\Option::getSetting("opt_link_facebook")}}" placeholder="https://www.facebook.com/***">
                                </div>
                                <div class="form-group">
                                    <label for="">Instagram</label>
                                    <a href="{{\App\Option::getSetting("opt_link_instagram") ?? 'https://www.instagram.com'}}" target="_blank" title=""><i class="fa fa-external-link"></i></a>
                                    <input  type="text" class="form-control"
                                            name="opt_link_instagram"
                                            value="{{\App\Option::getSetting("opt_link_instagram")}}" placeholder="https://www.instagram.com/***">
                                </div>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>

                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Expired date</h3>
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
                                <div class="form-group">
                                    <label for="">Count days</label>
                                    <div class="input-group date">
                                        <input type="number" name="opt_expired_date" value="{{\App\Option::getSetting("opt_expired_date")}}" class="form-control pull-right" placeholder="30" min="1" max="360">
{{--                                        <input type="text" name="opt_expired_date" data-date-format="yyyy-mm-dd" value="{{\App\Option::getSetting("opt_expired_date")}}" class="form-control pull-right" data-provide="datepicker"  id="datepicker">--}}
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Home slider (Image must be 1110x430)</h3>
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
                                <div class="form-group sliders">
                                    @foreach(json_decode(\App\Option::getSetting("opt_slider")) as $slide)
                                    <div class="slider">
                                        <button type="button" class="btn btn-danger btn-sm delete-slider pull-right" style=" margin-top: -15px;"><i class="fa fa-times"></i></button>
                                        <div class="row">
                                            <div class="input-group col-md-4">
                                                <div class="image-preview" id="image-preview{{ $loop->iteration }}" style="background-image: url({{ $slide->image_url }});  background-size: cover; background-position: center center">
                                                    <label for="image-upload" class="image-label">Choose File</label>
                                                    <input type="file" name="opt_slider[{{ $loop->iteration }}][image_url]" class="image-upload" id="image-upload{{ $loop->iteration }}" />
                                                    <input type="hidden" name="opt_slider[{{ $loop->iteration }}][text_image_url]" value="{{ $slide->image_url }}" class="text_image_url" />
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="">Text</label>
                                                    <textarea class="editor{{ $loop->iteration }}" style="width: 100%" rows="5" name="opt_slider[{{ $loop->iteration }}][slider_content]"> {{ $slide->slider_content }}</textarea>
                                                    <br>
                                                    <div class="checkbox" id="add-link">
                                                        <label>
                                                            <input type="checkbox" onclick="javascript: getLink('.link_field{{ $loop->iteration }}', this)" {{ !empty($slide->url_name) ? 'checked' : ''}}> Add link
                                                        </label>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="">Name</label>
                                                            <input  type="text" class="form-control link_field{{ $loop->iteration }}"
                                                                    name="opt_slider[{{ $loop->iteration }}][url_name]" {{ !empty($slide->url_name) ? '' : 'disabled'}}
                                                                    value="{{ $slide->url_name ?? null}}" placeholder="Save now">
                                                    </div>
                                                    <div class="col-md-8">
                                                        <label for="">Url</label>
                                                        <input  type="text" class="form-control link_field{{ $loop->iteration }}"
                                                                name="opt_slider[{{ $loop->iteration }}][url_link]" {{ !empty($slide->url_link) ? '' : 'disabled'}}
                                                                value="{{ $slide->url_link ?? null}}" placeholder="/our-story">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    </div>
                                    @endforeach
                                </div>
                                <button type="submit" class="btn btn-primary">Save</button>
                                <button type="button" class="btn btn-info add-slider" >Add photo</button>
                            </div>
                        </div>
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title">SEO</h3>
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
                                <div class="form-group">
                                    <label for="">SEO Title</label>
                                    <div class="input-group date">
                                        <input type="text" name="opt_seo_title" value="{{\App\Option::getSetting("opt_seo_title")}}" class="form-control pull-right">
                                        {{--                                        <input type="text" name="opt_expired_date" data-date-format="yyyy-mm-dd" value="{{\App\Option::getSetting("opt_expired_date")}}" class="form-control pull-right" data-provide="datepicker"  id="datepicker">--}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">SEO Description</label>
                                    <div class="input-group date">
                                        <input type="text" name="opt_seo_description" value="{{\App\Option::getSetting("opt_seo_description")}}" class="form-control pull-right">
                                        {{--                                        <input type="text" name="opt_expired_date" data-date-format="yyyy-mm-dd" value="{{\App\Option::getSetting("opt_expired_date")}}" class="form-control pull-right" data-provide="datepicker"  id="datepicker">--}}
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Support</h3>
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
                                <div class="form-group">
                                    <label for="">Support Email</label>
                                    <div class="input-group date">
                                        <input type="email" name="opt_support_email" value="{{\App\Option::getSetting("opt_support_email")}}" class="form-control pull-right">
                                    </div>
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
@include("newthemplate.Admin.footer")