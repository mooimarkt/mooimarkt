@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/cropperjs/dist/cropper.css" crossorigin="anonymous">
@endsection

@include("site.inc.header")

<section class="sell_now_s">
    <div class="container">
        <h3 class="s_top_grey_title">{{ Language::lang('Sell an item') }}</h3>
        <div class="sell_now_form">
            @if(!empty($errors->get('adWillCost')))
            <div class="new-auth-validation" style="background-color: red">
                <p style="padding: 5px"> {{ $errors->get('adWillCost')[0] }} </p>
            </div>
            @endif
            <div class="sell_now_two_cols">
                <div class="col">
                    <div class="form_group">
                        <label class="text_label" id="photos" data-count="{{ $ads->images->count() }}">{{ Language::lang('Add photos') }}</label>
                        <form action="/upload-image" id="dropzone-cropping" class="dropzone input_file_container">
                            <input type="file" name="file_input_one" id="file_input_one" class="file_input_dropzone">
                            <div class="dropzone_inner"  id="adsImages">
                                <label data-target-form="dropzone-cropping" class="input_file_btn btn def_btn">@php(include ("mooimarkt/img/photo_camera_icon.svg")) {{ Language::lang('Upload photo') }}</label>
                                <span class="input_file_text">{{ Language::lang('or drag in') }}</span>
                            </div>
                            <h3 class="you_can_add_text">{!! Language::lang('You can add <span>5</span> more photos for free') !!}</h3>
                            <div class="dz-default dz-message" style="display: block;"><span>{{ Language::lang('Drop files here to upload') }}</span></div>

                            @foreach($ads->images as $image)
                            <div class="dz-preview dz-processing dz-image-preview dz-success dz-complete" id="{{ $image->id }}">
                                <div class="dz-image">
                                    <img data-dz-thumbnail="" alt="{{ Language::lang($image->getNameImage()) }}" src="{{ $image->imagePath }}">
                                </div>

                                <div class="dz-progress">
                                    <span class="dz-upload" data-dz-uploadprogress="" style="width: 100%;"></span>
                                </div>
                                <a class="dz-remove" href="javascript:undefined;" data-dz-remove="" data-imageid="{{ $image->id }}" data-filenamenew="{{ $image->imagePath }}">{{ Language::lang('Remove file') }}</a>
                            </div>
                            @endforeach

                        </form>
                    </div>
                </div>

                <div class="col">
                    {!! Form::open([
                        'route' => ['updateSell', $ads->id], 'method' => 'post', 'id' => 'form-sell', 'data-id' => $ads->id]) !!}
                        <div class="form_group adsName">
                            <label class="text_label"> {{ Language::lang('Title') }}</label>
                            <input type="text" class="text_input validation" name="adsName" value="{{ $ads->adsName }}" placeholder="{{ Language::lang('What do you want to sell?') }}">
                            <p class="alert alert-danger"></p>
                        </div>
                        <input type="hidden" class="text_input" name="ads_images" id="ads-images">
                        <div class="form_group adsDescription">
                            <label class="text_label"> {{ Language::lang('Description') }}</label>
                            <div class="textareat_limited_wrpr">
                                <span class="textareat_limit_number"><span>0</span> / 500</span>
                                <textarea id="" class="text_input textareat_limited validation" name="adsDescription" maxlength="500" placeholder="{{ Language::lang('Add information about your product...') }}">{{ $ads->adsDescription }}</textarea>
                                <p class="alert alert-danger"></p>
                            </div>
                        </div>
                        <div class="form_group categoryId validation">
                            <label class="text_label">{{ Language::lang('Category') }}</label>
                            {{ Form::select('categoryId', $categories, $category->id, ['class' => 'select_two_select validation', 'id' => 'category'] ) }}
                        </div>
                        <div class="form_group subCategoryId validation">
                            <label class="text_label">{{ Language::lang('SubCategory') }}</label>
                            {{ Form::select('subCategoryId', $subCategories, $subcategory->id ?? null, ['class' => 'select_two_select', 'id' => 'subCategories'] ) }}
                            <p class="alert alert-danger"></p>
                        </div>
                    <div class="filters">
                    @foreach($filters as $filter)

                                @if($filter['template'] === 'type')
                                <div class="form_group validation sub_filter_block">
                                    <label class="text_label">{{ Language::lang($filter['name']) }}</label>
                                    {{ Form::select("filters[$loop->iteration]", [null => 'Choose Type...'] +  $filter['list'], $filter['current'], ['class' => 'select_two_select sub_filter'] ) }}
                                    <p class="alert alert-danger"></p>
                                    @if($filter['template'] === 'type' && !empty($filter['current']) && \App\Filter::getChildrenFilters($filter['current'])->isNotEmpty())
                                        <div class="form_group sub_sub_filter">
                                            <br>  <label class="text_label">{{ Language::lang(\App\Filter::getName($filter['current'])) }}</label>
                                            <select name="filters[]" class="select2 select_two_select subSubFilters">
                                                @foreach(\App\Filter::getChildrenFilters($filter['current']) as $subSubFilter)
                                                    <option value="{{ $subSubFilter->id }}" {{ in_array($subSubFilter->id, $ads->filters()->get()->pluck('id')->toArray()) ? 'selected' : '' }}>{{ Language::lang($subSubFilter->name) }}</option>
                                                @endforeach
                                            </select>
                                            <p class="alert alert-danger"></p>
                                        </div>
                                    @endif
                                </div>
                                @elseif($filter['template'] === 'brand')
                                <div class="form_group validation">
                                    <label class="text_label">{{ Language::lang($filter['name']) }}</label>
                                    {{ Form::select("filters[$loop->iteration]", $filter['list'], $filter['current'], ['class' => 'select_two_select sub_filter_brand'] ) }}
                                    <p class="alert alert-danger"></p>
                                </div>
                                @elseif($filter['template'] === 'color')
                                <div class="form_group validation">
                                    <label class="text_label">{{ Language::lang($filter['name']) }}</label>
                                    <div class="list-colors">
                                        @foreach($filter['list'] as $key => $item)
                                            @switch ($item)
                                            @case('light blue')
                                                <span style="background: #add8e6" data-id="{{ $key }}" class="{{ in_array($key, $filter['current']) ? 'active' : '' }}"></span>
                                            @break
                                            @case ('rose')
                                                <span style="background: #ff007f" data-id="{{ $key }}" class="{{ in_array($key, $filter['current']) ? 'active' : '' }}"></span>
                                            @break
                                            @case ('haki')
                                                <span style="background: #78866b" data-id="{{ $key }}" class="{{ in_array($key, $filter['current']) ? 'active' : '' }}"></span>
                                            @break
                                            @case ('mustard')
                                                <span style="background: #ffdb58" data-id="{{ $key }}" class="{{ in_array($key, $filter['current']) ? 'active' : '' }}"></span>
                                            @break
                                            @default
                                                <span style="background: {{ $item }}" data-id="{{ $key }}" class="{{ in_array($key, $filter['current']) ? 'active' : '' }}"></span>
                                            @endswitch
                                        @endforeach
                                        <select name="filters[{{ $loop->iteration }}]" id="colors" style="display: none" multiple>
                                            @foreach($filter['list'] as $key => $item)
                                                <option value="{{ $key }}" {{ in_array($key, $filter['current']) ? 'selected' : '' }}>{{ Language::lang($item) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <p class="alert alert-danger"></p>
                                </div>
                                @else
                                <div class="form_group validation">
                                    <label class="text_label">{{ Language::lang($filter['name']) }}</label>
                                    {{ Form::select("filters[$loop->iteration]", $filter['list'], $filter['current'], ['class' => 'select_two_select',
                                    ($filter['template'] == 'material')
                                    || ($filter['template'] == 'size')
                                    ? 'multiple' : ''] ) }}
                                    <p class="alert alert-danger"></p>
                                </div>
                                @endif

                        @if($filter['template'] == 'brand' && !empty($filter['current']) && \App\Filter::getChildrenFilters($filter['current'])->isNotEmpty())
                            @foreach(\App\Filter::getChildrenFilters($filter['current']) as $subSubFilter)
                                @if(in_array($subSubFilter->id, $ads->filters()->get()->pluck('id')->toArray()))
                                    <input name="otherCurrentBrand" type="hidden" id="otherCurrentBrand" value="{{ Language::lang($subSubFilter->id) }}">
                                @endif
                            @endforeach
                            <div class="form_group sub_sub_filter_brand">
                              <br>
                              <label class="text_label">{{ Language::lang('Other Brand') }}</label>
                                @foreach(\App\Filter::getChildrenFilters($filter['current']) as $subSubFilter)
                                    @if(in_array($subSubFilter->id, $ads->filters()->get()->pluck('id')->toArray()))
                                    <input name="otherBrand[parentId]" value="{{ $subSubFilter->parent->id }}" type="hidden">
                                    <input name="otherBrand[name]" value="{{ Language::lang($subSubFilter->name) }}" type="text" class="text_input validation" placeholder="Other Brand">
                                    @endif
                                @endforeach

                              <p class="alert alert-danger"></p>
                            </div>
                        @endif
                        @endforeach
                    </div>
                        {{--<div class="form_group validation">
                            <label class="text_label">{{ Language::lang('Location (KM)') }}</label>
                            <input type="number" class="text_input validation" name="location" value="{{ $ads->location }}" placeholder="30">
                        </div>--}}
                        <div class="form_group adsPrice">
                            <label class="text_label">{{ Language::lang('Selling Price') }}</label>
                            <div class="select_n_input">
{{--                                {{ Form::select('adsPriceType',--}}
{{--                                    $priceTypes,--}}
{{--                                    $ads->adsPriceType, ['class' => 'select_two_select'] ) }}--}}
                                <input name="adsPriceType" type="hidden" value="EUR">
                                <input name="adsPrice" type="text" class="text_input validation" placeholder="10.5" value="{{ $ads->adsPrice }}">
                            </div>
                            <p class="alert alert-danger" style="margin-left: 130px;"></p>
                        </div>
                        <div class="form_group original_price">
                            <label class="text_label">{{ Language::lang('Original Price') }}</label>
                            <div class="select_n_input">
                                <input name="original_price" type="text" class="text_input validation" placeholder="10.5" value="{{ $ads->original_price }}">
                            </div>
                            <p class="alert alert-danger" style="margin-left: 130px;"></p>
                        </div>
                        <div class="form_group">
                            <label class="text_label">{{ Language::lang('Swap') }}</label>
                            {{ Form::select('swap', ['No','Yes'], $ads->swap, ['class' => 'select_two_select', 'id' => 'swap'] ) }}
                        </div>
                        <div class="btn_wrpr">
                            <a href="#save_sell" id="save_sell" class="btn def_btn">{{ Language::lang('Save sell') }}</a>
                        </div>
                    {!! Form::close() !!}
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