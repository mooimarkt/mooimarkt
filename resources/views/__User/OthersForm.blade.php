<!-- Start Section -->
@foreach($form as $forms)
    <div class="col-lg-6 col-md-6 col-xs-12 form-rows" style="max-height: 60px;">          
        <div class="form-group form-inline">
            @if($forms->filterType == null)
                @if ($forms->fieldType == 'dropdown')
                    <label class="uppercase-text" for="dropDown{{ str_replace(array(':', '\\', '/', '*', ',', '.', ' ', '(', ')'),'',$forms->fieldTitle) }}">
                    @if($forms->fieldTitle == 'Year')
                        @if(count(explode(".", trans('formfields.'.$forms->fieldTitle))) > 1)
                            {{ explode(".", trans('formfields.'.$forms->fieldTitle))[1] }}
                        @else
                            {{ trans('formfields.'.$forms->fieldTitle) }}
                        @endif (YYYY)
                    @else
                        @if(count(explode(".", trans('formfields.'.$forms->fieldTitle))) > 1)
                            {{ explode(".", trans('formfields.'.$forms->fieldTitle))[1] }}
                        @else
                            {{ trans('formfields.'.$forms->fieldTitle) }}
                        @endif
                    @endif
                    </label>
                    <select id="dropDown{{ str_replace(array(':', '\\', '/', '*', ',', '.', ' ', '(', ')'),'',$forms->fieldTitle) }}" data-formFieldId="{{ $forms->id }}" data-id="{{ $forms->id }}" data-type="{{ $forms->fieldType }}" data-parentId="{{ $forms->parentFieldId }}" class="form-control othersFlexiFormValue filter-drop-down" onchange="dropDownParentOnChange({{ $forms->id }});" name="dropDown{{ $forms->fieldTitle }}" required>
                        <option value="none" selected="selected" >{{trans("instruction-terms.pleaseselectyouroption")}}</option>
                        @if(array_key_exists ( $forms->id , $value ))
                            @foreach($value[$forms->id] as $values)                      
                                <option value="{{ $values->value }}">
                                    @if(count(explode(".", trans('options.'.$values->value))) > 1)
                                    {{ explode(".", trans('options.'.$values->value))[1] }}
                                @else
                                    {{ trans('options.'.$values->value) }}
                                @endif
                                </option>
                            @endforeach
                        @endif
                    </select>
                @elseif ($forms->fieldType == 'input')
                    <label class="uppercase-text" for="input{{ str_replace(array(':', '\\', '/', '*', ',', '.', ' ', '(', ')'),'',$forms->fieldTitle) }}">
                    @if($forms->fieldTitle == 'Year')
                        @if(count(explode(".", trans('formfields.'.$forms->fieldTitle))) > 1)
                            {{ explode(".", trans('formfields.'.$forms->fieldTitle))[1] }}
                        @else
                            {{ trans('formfields.'.$forms->fieldTitle) }}
                        @endif (YYYY)
                    @else
                        @if(count(explode(".", trans('formfields.'.$forms->fieldTitle))) > 1)
                            {{ explode(".", trans('formfields.'.$forms->fieldTitle))[1] }}
                        @else
                            {{ trans('formfields.'.$forms->fieldTitle) }}
                        @endif
                    @endif
                    </label>
                    <input type="text" id="input{{ str_replace(array(':', '\\', '/', '*', ',', '.', ' ', '(', ')'),'',$forms->fieldTitle) }}" data-formFieldId="{{ $forms->id }}" data-id="{{ $forms->id }}" data-type="{{ $forms->fieldType }}" data-parentId="{{ $forms->parentFieldId }}" class="form-control othersFlexiFormValue filter-text-box" name="input{{ $forms->fieldTitle }}">
                @endif
            @else
                @if ($forms->filterType == 'dropdown')
                    <label class="uppercase-text" for="dropDown{{ str_replace(array(':', '\\', '/', '*', ',', '.', ' ', '(', ')'),'',$forms->fieldTitle) }}">
                    @if($forms->fieldTitle == 'Year')
                        @if(count(explode(".", trans('formfields.'.$forms->fieldTitle))) > 1)
                            {{ explode(".", trans('formfields.'.$forms->fieldTitle))[1] }}
                        @else
                            {{ trans('formfields.'.$forms->fieldTitle) }}
                        @endif (YYYY)
                    @else
                        @if(count(explode(".", trans('formfields.'.$forms->fieldTitle))) > 1)
                            {{ explode(".", trans('formfields.'.$forms->fieldTitle))[1] }}
                        @else
                            {{ trans('formfields.'.$forms->fieldTitle) }}
                        @endif
                    @endif
                    </label>
                    <select id="dropDown{{ str_replace(array(':', '\\', '/', '*', ',', '.', ' ', '(', ')'),'',$forms->fieldTitle) }}" data-formFieldId="{{ $forms->id }}" data-id="{{ $forms->id }}" data-type="{{ $forms->filterType }}" class="form-control othersFlexiFormValue filter-drop-down" onchange="dropDownParentOnChange({{ $forms->id }});" name="dropDown{{ $forms->fieldTitle }}" required>
                        <option value="none" selected="selected" >{{trans("instruction-terms.pleaseselectyouroption")}}</option>
                        @if(array_key_exists ( $forms->id , $value ))
                            @foreach($value[$forms->id] as $values)                      
                                <option value="{{ $values->value }}">
                                    @if(count(explode(".", trans('options.'.$values->value))) > 1)
                                    {{ explode(".", trans('options.'.$values->value))[1] }}
                                @else
                                    {{ trans('options.'.$values->value) }}
                                @endif
                                </option>
                            @endforeach
                        @endif
                    </select>
                @elseif ($forms->filterType == 'multiple')
                    <label class="uppercase-text" for="dropDown{{ str_replace(array(':', '\\', '/', '*', ',', '.', ' ', '(', ')'),'',$forms->fieldTitle) }}">
                    @if($forms->fieldTitle == 'Year')
                        @if(count(explode(".", trans('formfields.'.$forms->fieldTitle))) > 1)
                            {{ explode(".", trans('formfields.'.$forms->fieldTitle))[1] }}
                        @else
                            {{ trans('formfields.'.$forms->fieldTitle) }}
                        @endif (YYYY)
                    @else
                        @if(count(explode(".", trans('formfields.'.$forms->fieldTitle))) > 1)
                            {{ explode(".", trans('formfields.'.$forms->fieldTitle))[1] }}
                        @else
                            {{ trans('formfields.'.$forms->fieldTitle) }}
                        @endif
                    @endif
                    </label>
                    <select multiple id="multi{{ str_replace(array(':', '\\', '/', '*', ',', '.', ' ', '(', ')'),'',$forms->fieldTitle) }}" data-formFieldId="{{ $forms->id }}" data-id="{{ $forms->id }}" data-type="{{ $forms->filterType }}" class="form-control othersFlexiFormValue filter-drop-down multipleSelect" onchange="dropDownParentOnChange({{ $forms->id }});" name="dropDown{{ $forms->fieldTitle }}" required>
                        @if(array_key_exists ( $forms->id , $value ))
                            @foreach($value[$forms->id] as $values)                      
                                <option value="{{ $values->value }}"> @if(count(explode(".", trans('options.'.$values->value))) > 1)
                                    {{ explode(".", trans('options.'.$values->value))[1] }}
                                @else
                                    {{ trans('options.'.$values->value) }}
                                @endif</option>
                            @endforeach
                        @endif
                    </select>
                @elseif ($forms->filterType == 'range')           
                    <div class="col-lg-6 col-md-6 col-xs-6 no-padding-column">  
                        <label class="uppercase-text" for="rangeMin{{ str_replace(array(':', '\\', '/', '*', ',', '.', ' ', '(', ')'),'',$forms->fieldTitle) }}">
                        @if($forms->fieldTitle == 'Year')
                            @if(count(explode(".", trans('formfields.'.$forms->fieldTitle))) > 1)
                                {{ explode(".", trans('formfields.'.$forms->fieldTitle))[1] }}
                            @else
                                {{ trans('formfields.'.$forms->fieldTitle) }}
                            @endif (YYYY)
                        @else
                            @if(count(explode(".", trans('formfields.'.$forms->fieldTitle))) > 1)
                                {{ explode(".", trans('formfields.'.$forms->fieldTitle))[1] }}
                            @else
                                {{ trans('formfields.'.$forms->fieldTitle) }}
                            @endif
                        @endif
                        </label>
                        <input type="number" id="rangeMin{{ str_replace(array(':', '\\', '/', '*', ',', '.', ' ', '(', ')'),'',$forms->fieldTitle) }}" data-formFieldId="{{ $forms->id }}" data-id="{{ $forms->id }}" data-type="rangeMin" class="form-control othersFlexiFormValue filter-text-box" name="input{{ $forms->fieldTitle }}" placeholder="MIN">
                    </div>
                    <div class="col-lg-6 col-md-6 col-xs-6 no-padding-column">  
                        <label for="rangeMax{{ str_replace(array(':', '\\', '/', '*', ',', '.', ' ', '(', ')'),'',$forms->fieldTitle) }}"></label>
                        <input type="number" id="rangeMax{{ str_replace(array(':', '\\', '/', '*', ',', '.', ' ', '(', ')'),'',$forms->fieldTitle) }}" data-formFieldId="{{ $forms->id }}" data-id="{{ $forms->id }}" data-type="rangeMax" class="form-control othersFlexiFormValue filter-text-box" name="input{{ $forms->fieldTitle }}" placeholder="MAX" style="margin-top: 6px;">
                    </div>
                @elseif ($forms->filterType == 'checkbox')      
                    <label class="uppercase-text" for="dropDown{{ str_replace(array(':', '\\', '/', '*', ',', '.', ' ', '(', ')'),'',$forms->fieldTitle) }}">
                    @if($forms->fieldTitle == 'Year')
                        @if(count(explode(".", trans('formfields.'.$forms->fieldTitle))) > 1)
                            {{ explode(".", trans('formfields.'.$forms->fieldTitle))[1] }}
                        @else
                            {{ trans('formfields.'.$forms->fieldTitle) }}
                        @endif (YYYY)
                    @else
                        @if(count(explode(".", trans('formfields.'.$forms->fieldTitle))) > 1)
                            {{ explode(".", trans('formfields.'.$forms->fieldTitle))[1] }}
                        @else
                            {{ trans('formfields.'.$forms->fieldTitle) }}
                        @endif
                    @endif
                    </label><br/>
                    @if(array_key_exists ( $forms->id , $value ))
                        @foreach($value[$forms->id] as $values) 
                            <input type="checkbox" id="checkBox{{ str_replace(array(':', '\\', '/', '*', ',', '.', ' ', '(', ')'),'',$forms->fieldTitle) }}" data-formFieldId="{{ $forms->id }}" data-id="{{ $forms->id }}" data-type="checkBox" class="othersFlexiFormValue filter-checkbox-checkmark" name="input{{ $forms->fieldTitle }}"> <span class="filter-checkbox-text" value="{{ $values->value }}">@if(count(explode(".", trans('options.'.$values->value))) > 1)
                                    {{ explode(".", trans('options.'.$values->value))[1] }}
                                @else
                                    {{ trans('options.'.$values->value) }}
                                @endif</span>&nbsp;&nbsp;&nbsp;
                        @endforeach
                    @endif
                @elseif ($forms->filterType == 'radio')      
                    <label class="uppercase-text" for="radio{{ str_replace(array(':', '\\', '/', '*', ',', '.', ' ', '(', ')'),'',$forms->fieldTitle) }}">
                    @if($forms->fieldTitle == 'Year')
                        @if(count(explode(".", trans('formfields.'.$forms->fieldTitle))) > 1)
                            {{ explode(".", trans('formfields.'.$forms->fieldTitle))[1] }}
                        @else
                            {{ trans('formfields.'.$forms->fieldTitle) }}
                        @endif (YYYY)
                    @else
                        @if(count(explode(".", trans('formfields.'.$forms->fieldTitle))) > 1)
                            {{ explode(".", trans('formfields.'.$forms->fieldTitle))[1] }}
                        @else
                            {{ trans('formfields.'.$forms->fieldTitle) }}
                        @endif
                    @endif
                    </label><br/>
                    @if(array_key_exists ( $forms->id , $value ))
                        @foreach($value[$forms->id] as $values) 
                            <input type="radio" id="radio{{ str_replace(array(':', '\\', '/', '*', ',', '.', ' ', '(', ')'),'',$forms->fieldTitle) }}" data-formFieldId="{{ $forms->id }}" data-id="{{ $forms->id }}" data-type="radio" class="othersFlexiFormValue" name="input{{ $forms->fieldTitle }}" value="{{ $values->value }}"> <span class="filter-checkbox-text">@if(count(explode(".", trans('options.'.$values->value))) > 1)
                                    {{ explode(".", trans('options.'.$values->value))[1] }}
                                @else
                                    {{ trans('options.'.$values->value) }}
                                @endif</span>&nbsp;&nbsp;&nbsp;
                        @endforeach
                    @endif
                @endif
            @endif
        </div>
    </div>
@endforeach