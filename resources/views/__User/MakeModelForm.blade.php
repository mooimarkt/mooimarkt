<div id="makeModelSet{{ $childCount }}" class="col-lg-12 col-md-12 col-xs-12">
    <div class="row">
    @foreach($form as $forms)
        @if($forms->fieldType == 'dropdown')
            <div class="col-lg-4 col-md-4 col-xs-5 form-rows" style="padding-left: 15px;padding-right: 0px;">          
                <div class="form-group form-inline">
                    <label class="uppercase-text" for="dropDown{{ $forms->fieldTitle }}">
                        @if(count(explode(".", trans('formfields.'.$forms->fieldTitle))) > 1)
                            {{ explode(".", trans('formfields.'.$forms->fieldTitle))[1] }}
                        @else
                            {{ trans('formfields.'.$forms->fieldTitle) }}
                        @endif</label>
                    @if($childCount % 2 == 0)
                        <div class="makeDropDown">
                            @if($forms->filterType == null)                           
                                <select id="dropDown{{ $childCount }}" data-formFieldId="{{ $forms->id }}" data-id="{{ $childCount }}" data-type="{{ $forms->fieldType }}" data-parentId="-1" data-special="{{ $forms->fieldTitle }}" class="form-control flexibleFormValue filter-drop-down" onchange="dropDownParentOnChange({{ $childCount }});" name="dropDown{{ $forms->fieldTitle }}" required>
                                    <option data-id="0" value="0">{{trans("instruction-terms.pleaseselectyouroption")}}</option>
                                    @foreach($value as $values)
                                        @if($values->formFieldId == $forms->id)
                                            <option value="{{ $values->value }}" data-id="{{ $values->id }}">
                                                @if(count(explode(".", trans('options.'.$values->value))) > 1)
                                                {{ explode(".", trans('options.'.$values->value))[1] }}
                                                @else
                                                    {{ trans('options.'.$values->value) }}
                                                @endif
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            @else 
                                <select id="dropDown{{ $childCount }}" data-formFieldId="{{ $forms->id }}" data-id="{{ $childCount }}" data-type="{{ $forms->filterType }}" data-parentId="-1" data-special="{{ $forms->fieldTitle }}" class="form-control flexibleFormValue filter-drop-down" onchange="dropDownParentOnChange({{ $childCount }});" name="dropDown{{ $forms->fieldTitle }}" required>
                                    <option data-id="0" value="0">{{trans("instruction-terms.pleaseselectyouroption")}}</option>
                                    @foreach($value as $values)
                                        @if($values->formFieldId == $forms->id)
                                            <option value="{{ $values->value }}" data-id="{{ $values->id }}">
                                                @if(count(explode(".", trans('options.'.$values->value))) > 1)
                                                    {{ explode(".", trans('options.'.$values->value))[1] }}
                                                @else
                                                    {{ trans('options.'.$values->value) }}
                                                @endif
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            @endif
                        </div>
                    @else
                        <div class="makeDropDown">
                            @if($forms->filterType == null)
                                <select multiple id="multi{{ $childCount }}" data-formFieldId="{{ $forms->id }}" data-id="{{ $forms->id }}" data-type="{{ $forms->fieldType }}" data-parentId="{{ $childCount-1 }}" data-special="{{ $forms->fieldTitle }}" class="form-control flexibleFormValue filter-drop-down modelClass" name="multi{{ $forms->fieldTitle }}" required>
                                    <option data-id="0" value="0"> {{trans("label-terms.anyoptions")}}</option>
                                    @foreach($value as $values)
                                        @if($values->fieldTitle == $forms->fieldTitle)
                                            <option value="{{ $values->value }}" data-id="{{ $values->id }}">
                                                @if(count(explode(".", trans('options.'.$values->value))) > 1)
                                                    {{ explode(".", trans('options.'.$values->value))[1] }}
                                                @else
                                                    {{ trans('options.'.$values->value) }}
                                                @endif
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            @else
                                <select multiple id="multi{{ $childCount }}" data-formFieldId="{{ $forms->id }}" data-id="{{ $forms->id }}" data-type="{{ $forms->filterType }}" data-parentId="{{ $childCount-1 }}" data-special="{{ $forms->fieldTitle }}" class="form-control flexibleFormValue filter-drop-down modelClass" name="multi{{ $forms->fieldTitle }}" required>
                                    <option data-id="0" value="0"> {{trans("label-terms.anyoptions")}}</option>
                                    @foreach($value as $values)
                                        @if($values->fieldTitle == $forms->fieldTitle)
                                            <option value="{{ $values->value }}" data-id="{{ $values->id }}">
                                                @if(count(explode(".", trans('options.'.$values->value))) > 1)
                                                    {{ explode(".", trans('options.'.$values->value))[1] }}
                                                @else
                                                    {{ trans('options.'.$values->value) }}
                                                @endif
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        @endif
        <div id="temp" style="display: none;">
            {{ ++$childCount }}
        </div>
    @endforeach   
    @if(count($form))
    <div class="col-lg-1 col-md-2 col-xs-2 form-rows" style="padding-left: 0px;padding-right: 0px;">          
        <div class="form-group form-inline">
            <label class="uppercase-text"></label>
            <div class="makeDropDown">
                <div id="removeMakeModelPairBtn" data-removeId="{{ $childCount-2 }}" onclick="onDeleteMakeModelClick({{ $childCount-2 }});" class="form-control uppercase-text login-buttons makeModelRemover" style="width:34px;height:34px;margin-top: 7px; text-align: center;">X</div>
            </div>
        </div>
    </div>
    @endif
    </div>
</div>
