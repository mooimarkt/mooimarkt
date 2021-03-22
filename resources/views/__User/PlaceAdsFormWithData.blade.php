<!-- Start Section -->
@foreach($form as $forms)
    @if($forms->fieldType == '2dropdown')
        <div class="col-lg-6 col-md-6 col-xs-12 form-rows">          
            <div class="form-group form-inline">
                <label class="uppercase-text" for="dropDown{{ $forms->fieldTitle }}">
                    @if($forms->fieldTitle == 'Year')
                        {{ trans('formfields.'.$forms->fieldTitle) }} (YYYY)
                    @else
                        {{ trans('formfields.'.$forms->fieldTitle) }}
                    @endif
                </label>
                <select id="dropDown{{ $forms->fieldTitle }}" class="form-control flexibleFormValue" name="dropDown{{ $forms->fieldTitle }}" required>
                    <option value="EUR" selected>EUR</option>
                    <option value="USD">USD</option>
                </select>
                <input type="text" id="txt{{ $forms->fieldTitle }}" class="form-control flexibleFormValue" name="txt{{ $forms->fieldTitle }}" onmouseout="addFormFieldTag();" required/>
            </div>
        </div>
    @elseif ($forms->fieldType == 'dropdown')
        <div class="col-lg-6 col-md-6 col-xs-12 form-rows">          
            <div class="form-group form-inline">
                <label class="uppercase-text" for="dropDown{{ $forms->fieldTitle }}">
                    @if($forms->fieldTitle == 'Year')
                        {{ trans('formfields.'.$forms->fieldTitle) }} (YYYY)
                    @else
                        {{ trans('formfields.'.$forms->fieldTitle) }}
                    @endif
                </label>
                <select id="dropDown{{ $forms->id }}" data-id="{{ $forms->id }}" data-parentId="{{ $forms->parentFieldId }}" class="form-control flexibleFormValue" onchange="dropDownParentOnChange({{ $forms->id }});" name="dropDown{{ $forms->fieldTitle }}" required>
                    <option value="none" >{{trans("instruction-terms.pleaseselectyouroption")}}</option>
                    @if(array_key_exists ( $forms->fieldTitle , $adsDatas ))
                        @foreach($adsDatas[$forms->fieldTitle] as $adsData)
                            @if($forms->adsValue == $adsData->value)
                                <option value="{{ $adsData->value }}" data-id="{{ $adsData->id }}" selected="selected">@if(count(explode(".", trans('options.'.$adsData->value))) > 1)
                                        {{ explode(".", trans('options.'.$adsData->value))[1] }}
                                    @else
                                        {{ trans('options.'.$adsData->value) }}
                                    @endif</option>
                            @else
                                <option value="{{ $adsData->value }}" data-id="{{ $adsData->id }}">@if(count(explode(".", trans('options.'.$adsData->value))) > 1)
                                        {{ explode(".", trans('options.'.$adsData->value))[1] }}
                                    @else
                                        {{ trans('options.'.$adsData->value) }}
                                    @endif</option>
                            @endif
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
    @elseif ($forms->fieldType == 'input')
        @if($forms->fieldTitle == 'Year')
        <div class="col-lg-6 col-md-6 col-xs-12 form-rows">          
            <div class="form-group form-inline">
                <label class="uppercase-text" for="txt{{ $forms->fieldTitle }}">{{ trans('formfields.'.$forms->fieldTitle) }} (YYYY)</label>
                <input id="txt{{ $forms->fieldTitle }}" type="number" data-id="{{ $forms->id }}" class="form-control flexibleFormValue" name="txt{{ $forms->fieldTitle }}" value="{{ $forms->adsValue }}" min="1900" max="{{date('Y')}}" onmouseout="addFormFieldTag();" required/>
            </div>
        </div>
        @elseif($forms->fieldTitle == 'Hours')
        <div class="col-lg-6 col-md-6 col-xs-12 form-rows">          
            <div class="form-group form-inline">
                <label class="uppercase-text" for="txt{{ $forms->fieldTitle }}">{{ trans('formfields.'.$forms->fieldTitle) }}</label>
                <input id="txt{{ $forms->fieldTitle }}" type="number" data-id="{{ $forms->id }}" class="form-control flexibleFormValue" name="txt{{ $forms->fieldTitle }}" value="{{ $forms->adsValue }}" onmouseout="addFormFieldTag();" required/>
            </div>
        </div>
        @else
        <div class="col-lg-6 col-md-6 col-xs-12 form-rows">          
            <div class="form-group form-inline">
                <label class="uppercase-text" for="txt{{ $forms->fieldTitle }}">{{ trans('formfields.'.$forms->fieldTitle) }}</label>
                <input id="txt{{ $forms->fieldTitle }}" type="text" data-id="{{ $forms->id }}" class="form-control flexibleFormValue" name="txt{{ $forms->fieldTitle }}" value="{{ $forms->adsValue }}" onmouseout="addFormFieldTag();" required/>
            </div>
        </div>
        @endif
    @endif
@endforeach