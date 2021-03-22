@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/cropperjs/dist/cropper.css" crossorigin="anonymous">
    <style>
        .profile-modal {
            width: 70%;
            height: 70%;
            margin:0 auto;
            margin-top: 80px!important;
        }
    </style>
@endsection

@include("site.inc.header")

<section class="sell_now_s">
    <div class="container">
        <h3 class="s_top_grey_title">{{ Language::lang('Sell an item') }}</h3>
        <div class="sell_now_form">
            @if(!empty($errors->get('adWillCost')))
                <div class="new-auth-validation" style="background-color: red">
                    <p style="padding: 5px"> {{ Language::lang($errors->get('adWillCost')[0]) }} </p>
                </div>
            @endif
            <div class="sell_now_two_cols">
                <div class="col">
                    <div class="form_group">
                        <label class="text_label" id="photos" data-count="0">{{ Language::lang('Add photos ') }}</label>
                        <form action="/upload-image" id="dropzone-cropping" class="dropzone input_file_container">
                            <input type="file" name="file_input_one" id="file_input_one" class="file_input_dropzone">
                            <div class="dropzone_inner" id="adsImages">
                                <label data-target-form="dropzone-cropping"
                                       class="input_file_btn btn def_btn">

                                <?xml version="1.0" encoding="iso-8859-1"?>
                                <!-- Generator: Adobe Illustrator 19.1.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
                                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                         viewBox="0 0 486.3 486.3" style="enable-background:new 0 0 486.3 486.3;" xml:space="preserve">
<g>
    <g>
        <path d="M395.5,135.8c-5.2-30.9-20.5-59.1-43.9-80.5c-26-23.8-59.8-36.9-95-36.9c-27.2,0-53.7,7.8-76.4,22.5
			c-18.9,12.2-34.6,28.7-45.7,48.1c-4.8-0.9-9.8-1.4-14.8-1.4c-42.5,0-77.1,34.6-77.1,77.1c0,5.5,0.6,10.8,1.6,16
			C16.7,200.7,0,232.9,0,267.2c0,27.7,10.3,54.6,29.1,75.9c19.3,21.8,44.8,34.7,72,36.2c0.3,0,0.5,0,0.8,0h86
			c7.5,0,13.5-6,13.5-13.5s-6-13.5-13.5-13.5h-85.6C61.4,349.8,27,310.9,27,267.1c0-28.3,15.2-54.7,39.7-69
			c5.7-3.3,8.1-10.2,5.9-16.4c-2-5.4-3-11.1-3-17.2c0-27.6,22.5-50.1,50.1-50.1c5.9,0,11.7,1,17.1,3c6.6,2.4,13.9-0.6,16.9-6.9
			c18.7-39.7,59.1-65.3,103-65.3c59,0,107.7,44.2,113.3,102.8c0.6,6.1,5.2,11,11.2,12c44.5,7.6,78.1,48.7,78.1,95.6
			c0,49.7-39.1,92.9-87.3,96.6h-73.7c-7.5,0-13.5,6-13.5,13.5s6,13.5,13.5,13.5h74.2c0.3,0,0.6,0,1,0c30.5-2.2,59-16.2,80.2-39.6
			c21.1-23.2,32.6-53,32.6-84C486.2,199.5,447.9,149.6,395.5,135.8z" fill="#E0B1A3"/>
        <path d="M324.2,280c5.3-5.3,5.3-13.8,0-19.1l-71.5-71.5c-2.5-2.5-6-4-9.5-4s-7,1.4-9.5,4l-71.5,71.5c-5.3,5.3-5.3,13.8,0,19.1
			c2.6,2.6,6.1,4,9.5,4s6.9-1.3,9.5-4l48.5-48.5v222.9c0,7.5,6,13.5,13.5,13.5s13.5-6,13.5-13.5V231.5l48.5,48.5
			C310.4,285.3,318.9,285.3,324.2,280z" fill="#E0B1A3"/>
    </g>
</g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
                                        <g>
                                        </g>
</svg>
                                    {{ Language::lang('Choose a file or drag it here.') }}</label>
{{--                                <span class="input_file_text">{{ Language::lang('or drag in') }}</span>--}}
                            </div>
                            <h3 class="you_can_add_text">{!! Language::lang('You can add <span>5</span> more photos for free') !!}</h3>
                        </form>
                    </div>
                    <div class="wrap_img_dropzone">
                    </div>
                </div>

                <div class="col">
                    {!! Form::open([
                        'route' => 'addSell', 'method' => 'post', 'id' => 'form-sell']) !!}
                    <div class="form_group adsName">
                        <label class="text_label">{{ Language::lang('Title') }} *</label>
                        <input type="text" class="text_input validation" name="adsName" value="{{ old('adsName') }}"
                               placeholder="{{ Language::lang('What do you want to sell?') }}">
                        <p class="alert alert-danger"></p>
                    </div>
                    <input type="hidden" class="text_input" name="ads_images" id="ads-images">
                    <div class="form_group adsDescription">
                        <label class="text_label">{{ Language::lang('Description') }} *</label>
                        <div class="textareat_limited_wrpr">
                            <span class="textareat_limit_number"><span>0</span> / 500</span>
                            <textarea id="" class="text_input textareat_limited validation" name="adsDescription"
                                      maxlength="500"
                                      placeholder="{{ Language::lang('Add information about your product...') }}">{{ old('adsDescription') }}</textarea>
                            <p class="alert alert-danger"></p>
                        </div>
                    </div>
                    <div class="form_group categoryId validation">
                        <label class="text_label">{{ Language::lang('Category') }} *</label>
                        {{--                            {{ Form::select('categoryId', [null => 'Choose Category...'] +  $categories->toArray(), null, ['class' => 'select_two_select validation', 'id' => 'category'] ) }}--}}
                        <select name="categoryId" id="category" class="select_two_select validation">
                            <option value="" disabled selected>{{ Language::lang('Choose Category') }}...</option>
                            @foreach($categories as $key => $category)
                                <option value="{{ $key }}">{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form_group subCategoryId validation ">
                        <label class="text_label">{{ Language::lang('SubCategory') }} *</label>
                        <select name="subCategoryId" id="subCategories" class="select_two_select">
                            <option value="" disabled selected>{{ Language::lang('Choose Sub Сategory') }}...</option>

                        </select>
                        <p class="alert alert-danger"></p>
                    </div>

                    <div class="filters"></div>
                    {{--                        <div class="form_group validation">--}}
                    {{--                            <label class="text_label">{{ Language::lang('Payment') }} *</label>--}}
                    {{--                            {{ Form::select('payment', ['PayPal' => 'PayPal', 'Credit Card' => 'Credit Card'], null, ['class' => 'select_two_select', 'id' => 'payment'] ) }}--}}
                    {{--                        </div>--}}
                    <div class="form_group adsPrice">
                        <label class="text_label">{{ Language::lang('Selling Price') }} *</label>
                        <div class="select_n_input">
                            {{--                                {{ Form::select('adsPriceType',--}}
                            {{--                                    $priceTypes,--}}
                            {{--                                    'EUR', ['class' => 'select_two_select'] ) }}--}}
                            <input name="adsPriceType" type="hidden" value="EUR">
                            <input name="adsPrice" type="text" class="text_input validation" placeholder="10.5">
                        </div>
                        <p class="alert alert-danger" style="margin-left: 130px;"></p>
                    </div>
                    <div class="form_group original_price">
                        <label class="text_label">{{ Language::lang('Original Price') }}</label>
                        <div class="select_n_input">
                            {{--                                {{ Form::select('adsPriceType',--}}
                            {{--                                    $priceTypes,--}}
                            {{--                                    null, ['class' => 'select_two_select'] ) }}--}}
                            <input name="original_price" type="text" class="text_input validation" placeholder="10.5">
                        </div>
                        <p class="alert alert-danger" style="margin-left: 130px;"></p>
                    </div>
                    {{--                        <div class="form_group adsCost">--}}
                    {{--                            <label class="text_label">{{ Language::lang('Sending costs') }} *</label>--}}
                    {{--                            <div class="select_n_input">--}}
                    {{--                                {{ Form::select('adsCostType',--}}
                    {{--                                    $priceTypes,--}}
                    {{--                                    null, ['class' => 'select_two_select'] ) }}--}}
                    {{--                                <input name="adsCost" type="text" class="text_input validation" placeholder="10.5">--}}
                    {{--                            </div>--}}
                    {{--                            <p class="alert alert-danger" style="margin-left: 130px;"></p>--}}
                    {{--                        </div>--}}
                    <div class="form_group">
                        <label class="text_label">{{ Language::lang('Swap') }} *</label>
                        {{ Form::select('swap', ['No','Yes'], null, ['class' => 'select_two_select', 'id' => 'swap'] ) }}
                    </div>
                    <div class="form_group">
                        <label class="checkbox_container">
                            <input type="checkbox" name="" id="terms_conditions">
                            <span class="checkbox_icon checkbox_terms_conditions "></span>
                            <a href="/terms-conditions"
                               target="_blank" class="underline">
                                {{ Language::lang('I agree to the Terms and conditions') }} *
                            </a>
                        </label>
                    </div>
                    <div class="btn_wrpr">
                        <div class="form_group">
                            <label>
                                {{ Language::lang('Your ad will cost') }}
                                <span>{{ App\Option::getCost("opt_pack_basic")['cost']}} {{ Language::lang(App\Option::getCost("opt_pack_basic")['currency'])  }}</span>
                            </label>
                        </div>
                        <a href="#sell_now" data-fancybox data-src="#sell_now"
                           class="btn def_btn">{{ Language::lang('Sell Now') }}</a>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="first_listed_popup" id="sell_now">
                <h3>{{ Language::lang('Your ad will cost') }}
                    {{ App\Option::getCost("opt_pack_basic")['cost']}} {{ Language::lang(App\Option::getCost("opt_pack_basic")['currency'])  }}
                </h3>
                <div class="btns_wrpr">
                    <a href="" class="btn light_bordr_btn close_modal_btn">{{ Language::lang('Cancel') }}</a>
                    <a href="" class="btn def_btn " id="form-sell-button">{{ Language::lang('Confirm') }}</a>
                </div>
            </div>
        </div>
    </div>
</section>

@section('bottom-footer')
    <script src="https://unpkg.com/cropperjs/dist/cropper.js" crossorigin="anonymous"></script>
@endsection

@include("site.inc.notification")
@include("site.inc.footer")
