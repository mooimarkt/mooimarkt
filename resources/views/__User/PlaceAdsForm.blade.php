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
                <select id="dropDown{{ $forms->fieldTitle }}" class="form-control flexibleFormValue filter-drop-down" name="dropDown{{ $forms->fieldTitle }}" required>
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
                @if($forms->filterType == null)
                    <select id="dropDown{{ $forms->fieldTitle }}" data-formFieldId="{{ $forms->id }}" data-id="{{ $forms->id }}" data-type="{{ $forms->fieldType }}" data-parentId="{{ $forms->parentFieldId }}" class="form-control flexibleFormValue filter-drop-down" onchange="dropDownParentOnChange({{ $forms->id }});" name="dropDown{{ $forms->fieldTitle }}" required>
                        <option value="none" selected="selected" >{{trans("instruction-terms.pleaseselectyouroption")}}</option>
                        @foreach($value as $values)
                            @if($values->fieldTitle == $forms->fieldTitle)                        
                                <option value="{{ $values->value }}" data-id="{{ $values->id }}">
                                    @if(count(explode(".", trans('options.'.$values->value))) > 1)
                                        {{ explode(".", trans('options.'.$values->value))[1] }}
                                    @else
                                        {{ trans('options.'.$values->value) }}
                                    @endif</option>
                            @endif
                        @endforeach
                    </select>
                @else
                    <select id="dropDown{{ $forms->fieldTitle }}" data-formFieldId="{{ $forms->id }}" data-id="{{ $forms->id }}" data-type="{{ $forms->filterType }}" data-parentId="{{ $forms->parentFieldId }}" class="form-control flexibleFormValue filter-drop-down" onchange="dropDownParentOnChange({{ $forms->id }});" name="dropDown{{ $forms->fieldTitle }}" required>
                        <option value="none" selected="selected" >{{trans("instruction-terms.pleaseselectyouroption")}}</option>
                        @foreach($value as $values)
                            @if($values->fieldTitle == $forms->fieldTitle)
                                <option value="{{ $values->value }}" data-id="{{ $values->id }}">
                                    @if(count(explode(".", trans('options.'.$values->value))) > 1)
                                        {{ explode(".", trans('options.'.$values->value))[1] }}
                                    @else
                                        {{ trans('options.'.$values->value) }}
                                    @endif</option>
                            @endif
                        @endforeach
                    </select>
                @endif
            </div>
        </div>
    @elseif ($forms->fieldType == 'input')
        @if($forms->fieldTitle == 'Year')
        <div class="col-lg-6 col-md-6 col-xs-12 form-rows">          
            <div class="form-group form-inline">
                <label class="uppercase-text" for="txt{{ $forms->fieldTitle }}">{{ trans('formfields.'.$forms->fieldTitle) }} (YYYY)</label>
                <input id="txt{{ $forms->fieldTitle }}" type="number" data-id="{{ $forms->id }}" class="form-control flexibleFormValue" name="txt{{ $forms->fieldTitle }}" value="{{date('Y')}}" min="1900" max="{{date('Y')}}" onmouseout="addFormFieldTag();" required/>
            </div>
        </div>
        @elseif($forms->fieldTitle == 'Hours')
        <div class="col-lg-6 col-md-6 col-xs-12 form-rows">          
            <div class="form-group form-inline">
                <label class="uppercase-text" for="txt{{ $forms->fieldTitle }}">{{ trans('formfields.'.$forms->fieldTitle) }}</label>
                <input id="txt{{ $forms->fieldTitle }}" type="number" data-id="{{ $forms->id }}" class="form-control flexibleFormValue" onmouseout="addFormFieldTag();" name="txt{{ $forms->fieldTitle }}" value="0" required/>
            </div>
        </div>
        @else
        <div class="col-lg-6 col-md-6 col-xs-12 form-rows">          
            <div class="form-group form-inline">
                <label class="uppercase-text" for="txt{{ $forms->fieldTitle }}">{{ trans('formfields.'.$forms->fieldTitle) }}</label>
                <input id="txt{{ $forms->fieldTitle }}" type="text" data-id="{{ $forms->id }}" class="form-control flexibleFormValue" onmouseout="addFormFieldTag();" name="txt{{ $forms->fieldTitle }}" required/>
            </div>
        </div>
        @endif
    @endif
@endforeach