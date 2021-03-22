@extends('layouts.admin')

@section('content')
<div class="container-fluid" style="padding-top: 50px; background-color: #002450; ">

    <div class="col-lg-4 col-md-4">
        <label class="label-white">Language</label>
        <select  id="dropDownLanguage" name="dropDownLanguage" class="form-control">
            @foreach($translationLanguage as $translationLanguages)
                <option value="{{ $translationLanguages->locale }}" data-language="{{ $translationLanguages->name }}">{{ $translationLanguages->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-lg-4 col-md-4">
        <label class="label-white">Group</label>
        <select  id="dropDownGroup" name="dropDownGroup" class="form-control">
            @foreach($groupList as $group)
                <option value="{{ $group->group }}" data-language="{{ $group->group }}">{{ $group->group }}</option>
            @endforeach
        </select>
    </div>

    <div style="height: 120px;"></div>

</div>

<div id="tablewrap" class="container-fluid table-responsive" style="margin-top: 50px;">

    <div class="col-lg-12 col-md-12">
      <h6 class="admin-portal-title-blue">Manage Translation</h6>
    </div>

    <div class="col-lg-12 col-md-12">
        <table id="translationTable" class="table-striped" style="width: 100%">
            <thead>
                <th style="width: 200px">ID</th>
                <th style="width: 200px">Group</th>
                <th style="width: 200px">Language</th>
                <th style="width: 200px">Text In English</th>
                <th style="width: 200px" id="txtLanguageDisplay">Text In English</th>
                <th style="width: 100px;"></th>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
@endsection