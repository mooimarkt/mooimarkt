<!-- Start Section -->
@if(count($form) > 0)
    @foreach($form as $forms)
        @if ($forms->fieldType == 'dropdown')
            <div class="col-lg-6 col-md-6 col-xs-12 form-rows">          
                <div class="form-group form-inline">
                    <label class="uppercase-text" for="dropDown{{ $forms->fieldTitle }}">
                        @if(count(explode(".", trans('formfields.'.$forms->fieldTitle))) > 1)
                            {{ explode(".", trans('formfields.'.$forms->fieldTitle))[1] }}
                        @else
                            {{ trans('formfields.'.$forms->fieldTitle) }}
                        @endif
                    </label>
                    <div class="attributeDropDown">
                        @if($forms->filterType == null)                       
                            <select id="dropDown{{ $forms->fieldTitle }}" data-formFieldId="{{ $forms->id }}" data-type="{{ $forms->fieldType }}" data-id="{{ $forms->id }}" data-parentId="{{ $forms->parentFieldId }}" class="form-control flexibleAttribute filter-drop-down" onchange="dropDownAttributeChange({{ $forms->id }});" name="dropDown{{ $forms->fieldTitle }}" required>
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
                            <select id="dropDown{{ $forms->fieldTitle }}" data-formFieldId="{{ $forms->id }}" data-type="{{ $forms->filterType }}" data-id="{{ $forms->id }}" data-parentId="{{ $forms->parentFieldId }}" class="form-control flexibleAttribute filter-drop-down" onchange="dropDownAttributeChange({{ $forms->id }});" name="dropDown{{ $forms->fieldTitle }}" required>
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
            </div>
        @endif
    @endforeach
@endif