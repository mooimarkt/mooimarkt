@extends('layouts.admin')

@section('content')

<div class="container-fluid" style="padding-top: 50px; padding-bottom: 50px; background-color: #002450; ">
  <div class="col-lg-12 col-md-12">
      <h6 class="admin-portal-title-white">Package Management</h6>
  </div>
  <form id="package_form" class="" method="POST" action="{{ url('save_package') }}">
    {{ csrf_field() }}
    <div class="col-lg-4 col-md-4">
      <select id="dropDownCategory" name="dropDownCategory" class="form-control">
        <option>-- Please Select Your Category --</option>
        @foreach($category as $categories)
        <option value="{{ $categories['id'] }}">{{ $categories['categoryName'] }}</option>
        @endforeach
      </select>
    </div>
    <div class="col-lg-4 col-md-4">
      <select id="dropDownSubCategory" name="dropDownSubCategory" class="form-control">
    		<option value="none">-- Please Select Your Sub Category --</option>
  		</select>
    </div>

    @foreach($option_ary as $i => $data)
	  <div class="col-lg-12 col-md-12" style="padding-top: 50px;">
  		<div class="col-lg-12 col-md-12">
  			<input id="{{$data["type_name"]}}" name="{{$data["type_name"]}}" type="checkbox" data-id="{{$data["type_name"]}}" class="packageCheckbox" /> <span style="font-size: 12pt; color: white;">{{$data["name"]}}</span>
  		</div>
  		<div id="section_{{$data["type_name"]}}" style="display:none;" class="section_div">
        <div class="col-lg-3 col-md-3" >
          <label>Price</label>
          <input id="{{$data["type_name"]}}_price" name="{{$data["type_name"]}}_price" type="text" class="form-control input_field" />
        </div>
        <div class="col-lg-3 col-md-3" >
          <label>Listing days</label>
          <input id="{{$data["type_name"]}}_listed" name="{{$data["type_name"]}}_listed" type="text" class="form-control input_field" />
        </div>
        <div class="col-lg-3 col-md-3" >
          <label>Auto-Bump days</label>
          <input id="{{$data["type_name"]}}_auto-bump" name="{{$data["type_name"]}}_auto-bump" type="text" class="form-control input_field" />
        </div>
        <div class="col-lg-3 col-md-3" >
          <label>Spotlight days</label>
          <input id="{{$data["type_name"]}}_spotlight" name="{{$data["type_name"]}}_spotlight" type="text" class="form-control input_field" />
        </div>
        <div class="col-lg-3 col-md-3" >
          <label>Offer Option</label>
          <select id="{{$data["type_name"]}}_offer_option" name="{{$data["type_name"]}}_offer_option" class="form-control">
            <option>-- Please Select Your Option --</option>
            <option value="all">All</option>
            <option value="place_ads">Place Ads</option>
            <option value="add_on">Add On</option>
          </select>
        </div>
  		</div>
	  </div>
    @endforeach

	  <!--<div class="col-lg-12 col-md-12" style="padding-top: 50px;">
  		<div class="col-lg-12 col-md-12">
  			<input id="auto-bump" name="auto-bump" type="checkbox" data-id="2" class="packageCheckbox" /> <span style="font-size: 12pt; color: white;">Auto-Bump Package</span>
  		</div>
      <div id="section2" style="display:none;" class="section_div">
        <div class="col-lg-3 col-md-3" >
          <label>Price</label>
          <input id="auto-bump_price" name="auto-bump_price" type="text" class="form-control input_field" />
        </div>
        <div class="col-lg-3 col-md-3" >
          <label>Listing days</label>
          <input id="auto-bump_listed" name="auto-bump_listed" type="text" class="form-control input_field" />
        </div>
        <div class="col-lg-3 col-md-3" >
          <label>Auto-Bump days</label>
          <input id="auto-bump_auto-bump" name="auto-bump_auto-bump" type="text" class="form-control input_field" />
        </div>
        <div class="col-lg-3 col-md-3" >
          <label>Spotlight days</label>
          <input id="auto-bump_spotlight" name="auto-bump_spotlight" type="text" class="form-control input_field" />
        </div>
  		</div>
	  </div>

	  <div class="col-lg-12 col-md-12" style="padding-top: 50px;">
  		<div class="col-lg-12 col-md-12">
  			<input id="spotlight" name="spotlight" type="checkbox" data-id="3" class="packageCheckbox" /> <span style="font-size: 12pt; color: white;">Spotlight Package</span>
  		</div>
      <div id="section3" style="display:none;" class="section_div">
        <div class="col-lg-3 col-md-3" >
          <label>Price</label>
          <input id="spotlight_price" name="spotlight_price" type="text" class="form-control input_field" />
        </div>
        <div class="col-lg-3 col-md-3" >
          <label>Listing days</label>
          <input id="spotlight_listed" name="spotlight_listed" type="text" class="form-control input_field" />
        </div>
        <div class="col-lg-3 col-md-3" >
          <label>Auto-Bump days</label>
          <input id="spotlight_auto-bump" name="spotlight_auto-bump" type="text" class="form-control input_field" />
        </div>
        <div class="col-lg-3 col-md-3" >
          <label>Spotlight days</label>
          <input id="spotlight_spotlight" name="spotlight_spotlight" type="text" class="form-control input_field" />
        </div>
  		</div>
	  </div>

	  <div class="col-lg-12 col-md-12" style="padding-top: 50px;">
  		<div class="col-lg-12 col-md-12">
  			<input id="basic-bump-addOn" name="basic-bump-addOn" type="checkbox" data-id="4" class="packageCheckbox" /> <span style="font-size: 12pt; color: white;">Auto-Bump add-ons (Basic)</span>
  		</div>
      <div id="section4" style="display:none;" class="section_div">
        <div class="col-lg-3 col-md-3" >
          <label>Price</label>
          <input id="basic-bump-addOn_price" name="basic-bump-addOn_price" type="text" class="form-control input_field" />
        </div>
        <div class="col-lg-3 col-md-3" >
          <label>Listing days</label>
          <input id="basic-bump-addOn_listed" name="basic-bump-addOn_listed" type="text" class="form-control input_field" />
        </div>
        <div class="col-lg-3 col-md-3" >
          <label>Auto-Bump days</label>
          <input id="basic-bump-addOn_auto-bump" name="basic-bump-addOn_auto-bump" type="text" class="form-control input_field" />
        </div>
        <div class="col-lg-3 col-md-3" >
          <label>Spotlight days</label>
          <input id="basic-bump-addOn_spotlight" name="basic-bump-addOn_spotlight" type="text" class="form-control input_field" />
        </div>
  		</div>
	  </div>

	  <div class="col-lg-12 col-md-12" style="padding-top: 50px;">
  		<div class="col-lg-12 col-md-12">
  			<input id="ab-bump-addOn" name="ab-bump-addOn" type="checkbox" data-id="5" class="packageCheckbox" /> <span style="font-size: 12pt; color: white;">Auto-Bump add-ons (Auto Bump)</span>
  		</div>
      <div id="section5" style="display:none;" class="section_div">
        <div class="col-lg-3 col-md-3" >
          <label>Price</label>
          <input id="ab-bump-addOn_price" name="ab-bump-addOn_price" type="text" class="form-control input_field" />
        </div>
        <div class="col-lg-3 col-md-3" >
          <label>Listing days</label>
          <input id="ab-bump-addOn_listed" name="ab-bump-addOn_listed" type="text" class="form-control input_field" />
        </div>
        <div class="col-lg-3 col-md-3" >
          <label>Auto-Bump days</label>
          <input id="ab-bump-addOn_auto-bump" name="ab-bump-addOn_auto-bump" type="text" class="form-control input_field" />
        </div>
        <div class="col-lg-3 col-md-3" >
          <label>Spotlight days</label>
          <input id="ab-bump-addOn_spotlight" name="ab-bump-addOn_spotlight" type="text" class="form-control input_field" />
        </div>
  		</div>
	  </div>

	  <div class="col-lg-12 col-md-12" style="padding-top: 50px;">
  		<div class="col-lg-12 col-md-12">
  			<input id="spotlight-bump-addOn" name="spotlight-bump-addOn" type="checkbox" data-id="6" class="packageCheckbox" /> <span style="font-size: 12pt; color: white;">Auto-Bump add-ons (Spotlight)</span>
  		</div>
      <div id="section6" style="display:none;" class="section_div">
        <div class="col-lg-3 col-md-3" >
          <label>Price</label>
          <input id="spotlight-bump-addOn_price" name="spotlight-bump-addOn_price" type="text" class="form-control input_field" />
        </div>
        <div class="col-lg-3 col-md-3" >
          <label>Listing date</label>
          <input id="spotlight-bump-addOn_listed" name="spotlight-bump-addOn_listed" type="text" class="form-control input_field" />
        </div>
        <div class="col-lg-3 col-md-3" >
          <label>Auto-Bump days</label>
          <input id="spotlight-bump-addOn_auto-bump" name="spotlight-bump-addOn_auto-bump" type="text" class="form-control input_field" />
        </div>
        <div class="col-lg-3 col-md-3" >
          <label>Spotlight days</label>
          <input id="spotlight-bump-addOn_spotlight" name="spotlight-bump-addOn_spotlight" type="text" class="form-control input_field" />
        </div>
  		</div>
	  </div>

    <div class="col-lg-12 col-md-12" style="padding-top: 50px;">
  		<div class="col-lg-12 col-md-12">
  			<input id="basic-spotlight-addOn" name="basic-spotlight-addOn" type="checkbox" data-id="7" class="packageCheckbox" /> <span style="font-size: 12pt; color: white;">Spotlight add-ons (Basic)</span>
  		</div>
      <div id="section7" style="display:none;" class="section_div">
        <div class="col-lg-3 col-md-3" >
          <label>Price</label>
          <input id="basic-spotlight-addOn_price" name="basic-spotlight-addOn_price" type="text" class="form-control input_field" />
        </div>
        <div class="col-lg-3 col-md-3" >
          <label>Listing days</label>
          <input id="basic-spotlight-addOn_listed" name="basic-spotlight-addOn_listed" type="text" class="form-control input_field" />
        </div>
        <div class="col-lg-3 col-md-3" >
          <label>Auto-Bump days</label>
          <input id="basic-spotlight-addOn_auto-bump" name="basic-spotlight-addOn_auto-bump" type="text" class="form-control input_field" />
        </div>
        <div class="col-lg-3 col-md-3" >
          <label>Spotlight days</label>
          <input id="basic-spotlight-addOn_spotlight" name="basic-spotlight-addOn_spotlight" type="text" class="form-control input_field" />
        </div>
  		</div>
	  </div>
    <div class="col-lg-12 col-md-12" style="padding-top: 50px;">
  		<div class="col-lg-12 col-md-12">
  			<input id="ab-spotlight-addOn" name="ab-spotlight-addOn" type="checkbox" data-id="8" class="packageCheckbox" /> <span style="font-size: 12pt; color: white;">Spotlight add-ons (Auto-bump)</span>
  		</div>
      <div id="section8" style="display:none;" class="section_div">
        <div class="col-lg-3 col-md-3" >
          <label>Price</label>
          <input id="ab-spotlight-addOn_price" name="ab-spotlight-addOn_price" type="text" class="form-control input_field" />
        </div>
        <div class="col-lg-3 col-md-3" >
          <label>Listing days</label>
          <input id="ab-spotlight-addOn_listed" name="ab-spotlight-addOn_listed" type="text" class="form-control input_field" />
        </div>
        <div class="col-lg-3 col-md-3" >
          <label>Auto-Bump days</label>
          <input id="ab-spotlight-addOn_auto-bump" name="ab-spotlight-addOn_auto-bump" type="text" class="form-control input_field" />
        </div>
        <div class="col-lg-3 col-md-3" >
          <label>Spotlight days</label>
          <input id="ab-spotlight-addOn_spotlight" name="ab-spotlight-addOn_spotlight" type="text" class="form-control input_field" />
        </div>
  		</div>
	  </div>
    <div class="col-lg-12 col-md-12" style="padding-top: 50px;">
  		<div class="col-lg-12 col-md-12">
  			<input id="spotlight-spotlight-addOn" name="spotlight-spotlight-addOn" type="checkbox" data-id="9" class="packageCheckbox" /> <span style="font-size: 12pt; color: white;">Spotlight add-ons (Spotlight)</span>
  		</div>
      <div id="section9" style="display:none;" class="section_div">
        <div class="col-lg-3 col-md-3" >
          <label>Price</label>
          <input id="spotlight-spotlight-addOn_price" name="spotlight-spotlight-addOn_price" type="text" class="form-control input_field" />
        </div>
        <div class="col-lg-3 col-md-3" >
          <label>Listing days</label>
          <input id="spotlight-spotlight-addOn_listed" name="spotlight-spotlight-addOn_listed" type="text" class="form-control input_field" />
        </div>
        <div class="col-lg-3 col-md-3" >
          <label>Auto-Bump days</label>
          <input id="spotlight-spotlight-addOn_auto-bump" name="spotlight-spotlight-addOn_auto-bump" type="text" class="form-control input_field" />
        </div>
        <div class="col-lg-3 col-md-3" >
          <label>Spotlight days</label>
          <input id="spotlight-spotlight-addOn_spotlight" name="spotlight-spotlight-addOn_spotlight" type="text" class="form-control input_field" />
        </div>
  		</div>
	  </div>-->

    <div class="col-lg-offset-10 col-md-offset-10 col-lg-2 col-md-2">
      <button type="" name="" id="btnSubmit" class="btnSubmit" style="margin-top: 30px; margin-bottom: 30px; width: 100%;">Save</button>
    </div>
  </form>
</div>

<script type="text/javascript" src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
<script type="text/javascript">
  function submit_form(){
    var form = $("#package_form").serialize();
    console.log(form);
  }
  function reset_all(){
    $('.packageCheckbox').prop('checked', false);
    $(".input_field").val('');
    $(".section_div").hide();
  }
	$(document).ready(function(){

		$('.packageCheckbox').change(function(){
			var value = $(this).is(':checked');
			var sectionId = $(this).attr('data-id');

			if(value == true){
        $('#section_' + sectionId).show();
        console.log('#section_' + sectionId);
				//$('#section' + sectionId).append('<div class="col-lg-3 col-md-3" ><input type="text" class="form-control" /></div><div class="col-lg-3 col-md-3" ><input type="text" class="form-control" /></div>');
			}
			else if(value == false){
        $('#section_' + sectionId).hide();
				//$('#section' + sectionId).children().remove().end();
			}
		});

		$("#dropDownCategory").change(function(){
      reset_all();
    	var categoryId = $('#dropDownCategory :selected').attr('value');

        $.ajax({
            type: "GET",
            url: 'getPackageSubCategory',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: ({ "categoryId": categoryId }),
            success: function(data) {

            	if(data != null){

            		$('#dropDownSubCategory').children().remove().end();

            		$('#dropDownSubCategory').append('<option value="none">-- Please Select Your Sub Category --</option>');
                $('#dropDownSubCategory').append('<option value="0">Default</option>');

            		for(var i = 0; i < data.subCategory.length; i++){

            			$('#dropDownSubCategory').append('<option value="'+ data.subCategory[i].id +'">' +  data.subCategory[i].subCategoryName + '</option>');
            		}
            	}

            },
            error: function() {
                alert("{{trans('message-box.somethingwrong')}}");
            }
        });
    });

    $("#dropDownSubCategory").change(function(){
      reset_all();
      var subCategoryId = $('#dropDownSubCategory :selected').attr('value');

        $.ajax({
            type: "GET",
            url: 'getSubCategoryPackage',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: ({ "subCategoryId": subCategoryId }),
            success: function(data) {
              console.log("data");
              console.log(data);
            	if(data != null){

                jQuery.each(data.package, function(index, item) {
                  $('#'+item.type).prop('checked', true);
                  var sectionId = $('#'+item.type).attr('data-id');
                  $('#section_' + sectionId).show();
                  $("#"+item.type+"_price").val(item.price);
                  var data = JSON.parse(item.data);

                  $("#"+item.type+"_listed").val(data.listed);
                  $("#"+item.type+"_auto-bump").val(data["auto-bump"]);
                  $("#"+item.type+"_spotlight").val(data.spotlight);
                  console.log(item.offer_option);
                  if(item.offer_option){
                    $("#"+item.type+"_offer_option").val(item.offer_option).change();
                  }

                })


            	}

            },
            error: function() {
                alert("{{trans('message-box.somethingwrong')}}");
            }
        });
    })
    $("#btnSubmit").click(function(e){
      e.preventDefault();
      var formData = $("#package_form").serialize();
      $("body").addClass("loading");
      $.post("{{ url('save_package') }}", formData, function(r){
        console.log("r");
        console.log(r.status);
        alert("Successfully save package");
        window.location.reload();

      },'json').fail(function(e){
        console.log("failed");
        console.log(e);
      });
    });

	});
</script>

@endsection
