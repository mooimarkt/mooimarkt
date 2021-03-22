@include("newthemplate.header")

<section id="login-section" class="login-section">
    <div class="container">
        <div class="place_ad-fre">

            <div class="container">
                <h6><span>@php echo \App\Language::GetTextSearch('Place') @endphp </span>@php echo \App\Language::GetTextSearch('Ads Pricing') @endphp</h6>
                <div class="col-lg-6 col-md-6 col-xs-12 form-rows">
                    <select id="dropDownCategory" name="dropDownCategory" class="form-control">
                        <option>@php echo \App\Language::GetTextSearch('Select Category') @endphp</option>
        				@foreach($category as $categories)
        					<option value="{{ $categories['id'] }}">{{ \App\Language::GetTextSearch($categories['categoryName']) }}</option>
        				@endforeach
                    </select>
                    <select id="dropDownSubCategory" name="dropDownSubCategory" class="form-control">
                        <option value="none">@php echo \App\Language::GetTextSearch('Select Subcategory') @endphp</option>
                    </select>
                </div>
                <div class="priccing_container">
                    <div class="priccing_place_ad">
                        @php echo \App\Language::GetTextSearch('Place Ad Fee') @endphp
                    </div>

                    <div class="priccing_block">
                        <div class="priccing_top">@php echo \App\Language::GetTextSearch('Basic') @endphp</div>
                        <div class="priccing_bott">
                            <p>€<span class="priccing_cost" id="basicPrice">0</span></p>
                        </div>
                    </div>
                    <div class="priccing_block">
                        <div class="priccing_top">@php echo \App\Language::GetTextSearch('Autobump') @endphp</div>
                        <div class="priccing_bott">
                            <p>€<span class="priccing_cost" id="autoPrice">0</span></p>
                        </div>
                    </div>
                    <div class="priccing_block">
                        <div class="priccing_top">@php echo \App\Language::GetTextSearch('Spotlight') @endphp</div>
                        <div class="priccing_bott">
                            <p>€<span class="priccing_cost" id="spotlightPrice">0</span></p>
                        </div>
                    </div>
                </div>
                <a class="blue_btn place_ad_btn" href="{{ route('ads.place_add') }}">@php echo \App\Language::GetTextSearch('Place ad') @endphp</a>
            </div>

        </div>
    </div>
</section>
<script src="/newthemplate/bower_components/jquery/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		set_price_row_height();
		//Ajax Drop Down Category
	    $("#dropDownCategory").change(function(){

	    	var categoryId = $('#dropDownCategory :selected').attr('value');

	        $.ajax({
	            type: "GET",
	            url: 'PricingGetSubCategory',
	            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	            data: ({ "categoryId": categoryId}),
	            success: function(data) {

	            	if(data != null){

	            		$('#dropDownSubCategory').children().remove().end();

	            		$('#dropDownSubCategory').append('<option value="none">-- @php echo \App\Language::GetTextSearch("Please Select Your Sub Category") @endphp --</option>');

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
				console.log("dropDownSubCategory");
	    	var subCategoryId = $('#dropDownSubCategory :selected').attr('value');

	        $.ajax({
	            type: "GET",
	            url: 'getPricingBySubCategory',
	            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	            data: ({ "subCategoryId": subCategoryId}),
	            success: function(data) {
								console.log("data");
								console.log(data);

								//console.log(JSON.parse(data.pricing[0].get_pricing_details[0].data));
	            	if(data.success == "success"){
									var add_ons_ary = {};
									jQuery.each(data.pricing, function(index, item) {
										if(item.type == "basic"){
											$("#basicPrice").html(item.price);
											$("#bacis_pricing_details").html(build_pricing_details(JSON.parse(item.data)));
										}else if(item.type == "auto-bump"){
											$("#autoPrice").html(item.price);
											$("#auto_bump_pricing_details").html(build_pricing_details(JSON.parse(item.data)));
										}else if(item.type == "spotlight"){
											$("#spotlightPrice").html(item.price);
											$("#spotlight_pricing_details").html(build_pricing_details(JSON.parse(item.data)));
										}else{
											var title = "";
											if(item.type.indexOf("spotlight-addOn") !== -1 ){
												title = "Spotlight";
											}else{
												title = "Bump to top";
											}
											if (!add_ons_ary.hasOwnProperty(title)) {
												add_ons_ary[title] = {};
											}
											add_ons_ary[title][item.type] = item;
										}
									});
									$("#feature_row").show();
									set_box_height();

									console.log("add_ons_ary");
									console.log(add_ons_ary);
									build_add_ons(add_ons_ary);
									set_add_on_box_height();
								}
	            	else{
	            		alert("{{trans('message-box.nopricedata')}}");
	            		$("#basicPrice").html('0');
          				$("#autoPrice").html('0');
          				$("#spotlightPrice").html('0');
	            	}

	            },
	            error: function() {
	                alert("{{trans('message-box.somethingwrong')}}");

	            }
	        });
	    });
	});
	function build_add_ons(build_add_ons){
		console.log("build_add_ons");
		console.log(build_add_ons);
		var code = "";
		jQuery.each(build_add_ons, function(index, item) {
			console.log("index " +index);
			console.log(item);
			var key_ary = [];
			if(index == "Bump to top"){
				key_ary = ["basic-bump-addOn","ab-bump-addOn","spotlight-bump-addOn"];
			}else{
				key_ary = ["basic-spotlight-addOn","ab-spotlight-addOn","spotlight-spotlight-addOn"];
			}

			code += '<div class="col-lg-2 col-md-2 col-xs-3 no_padding_div  pricing_section_cell add_on_box" style="text-align:center;">';
				code += '<div id="feature_header" class="" style=""><span>'+index+'</span></div>';
			code += '</div>';
			code += '<div class="col-lg-3 col-md-3 col-xs-3 no_padding_div pricingTableCell add_on_box" style="">';
				code += '<div id="" class="" style="height:auto;"><span>';
				if(item.hasOwnProperty(key_ary[0])){
					code += '€'+item[key_ary[0]]["price"]+'<br>';
					var data = JSON.parse(item[key_ary[0]]["data"]);
					if(data["listed"] != 0){
						code += 'Adds '+data["listed"]+' days<br>';
					}
					if(data["auto-bump"] != 0){
						code += 'Bump to top like a recent ad<br>';
					}
					if(data["spotlight"] != 0){
						code += 'Spotlight the ad for '+data["spotlight"]*24+' hours<br>';
					}
				}else{
					code += 'N/A';
				}
				code += '</span></div>';
			code += '</div>';
			code += '<div class="col-lg-3 col-md-3 col-xs-3 no_padding_div pricingTableCell add_on_box" style="">';
				code += '<div id="" class=""><span>';

				if(item.hasOwnProperty(key_ary[1])){

					code += '€'+item[key_ary[1]]["price"]+'<br>';
					var data = JSON.parse(item[key_ary[1]]["data"]);
					if(data["listed"] != 0){
						code += 'Adds '+data["listed"]+' days<br>';
					}
					if(data["auto-bump"] != 0){
						code += 'Bump to top like a recent ad<br>';
					}
					if(data["spotlight"] != 0){
						code += 'Spotlight the ad for '+data["spotlight"]*24+' hours<br>';
					}
				}else{
					code += 'N/A';
				}
				code += '</span></div>';
			code += '</div>';
			code += '<div class="col-lg-3 col-md-3 col-xs-3 no_padding_div pricingTableCell add_on_box" style="">';
				code += '<div id="" class=""><span>';
				if(item.hasOwnProperty(key_ary[2])){
					code += '€'+item[key_ary[2]]["price"]+'<br>';
					var data = JSON.parse(item[key_ary[2]]["data"]);
					if(data["listed"] != 0){
						code += 'Adds '+data["listed"]+' days<br>';
					}
					if(data["auto-bump"] != 0){
						code += 'Bump to top like a recent ad<br>';
					}
					if(data["spotlight"] != 0){
						code += 'Spotlight the ad for '+data["spotlight"]*24+' hours<br>';
					}
				}else{
					code += 'N/A';
				}
				code += '</span></div>';
			code += '</div>';
		});

		//console.log(code);
		$("#add_on_contain").html(code);
		$("#add_on_contain").show();
		$("#add_on_title").show();

	}

	function set_price_row_height(){
		var tallestBox = 0;

		$(".price_row").each(function() {
		  var divHeight = $(this).height();

		  if (divHeight > tallestBox){
		    tallestBox = divHeight;
		  }
		});

		// Apply height & add total vertical padding
		$(".price_row").css("height", tallestBox);

	}
	function set_add_on_box_height(){
		var tallestBox = 0;

		$(".add_on_box").each(function() {
		  var divHeight = $(this).height();
		  console.log("divHeight. 111 = "+divHeight);
		  if (divHeight > tallestBox){
		    tallestBox = divHeight;
		  }
		});

		// Apply height & add total vertical padding
		$(".add_on_box").css("height", tallestBox);
	}

	function set_box_height(){
		var tallestBox = 0;

		$(".pricing_box").css("height", "auto");
		$(".pricing_box").each(function() {
		  var divHeight = $(this).height();
		  console.log(divHeight);

		  if (divHeight > tallestBox){
		    tallestBox = divHeight;
		  }
		});

		// Apply height & add total vertical padding
		$(".pricing_box").css("height", tallestBox);
	}
	function build_pricing_details(data){
		var code = "";
		code += '<ul style="padding-left:20px;padding:right:5px;">';
		if(data["listed"] != 0){
			code += '<li>Listed for '+data["listed"]+' Days</li>';
		}
		if(data["auto-bump"] != "0"){
			var auto_bump_day = data["auto-bump"].split(",");
			jQuery.each(auto_bump_day, function(index1, item1) {

				code += '<li>Auto Bump at '+item1;
				if(item1 == "1"){
					code += 'st day.</li>';
				}
				else if(item1 == "2"){
					code += 'nd day.</li>';
				}else if(item1 == "3"){
					code += 'rd day.</li>';
				}else{
					code += 'th day.</li>';
				}
			});
		}

		/*if(data["auto-bump"] != 0){
			code += '<li>Auto Bump for '+data["auto-bump"]+' Days</li>';
		}*/
		if(data["spotlight"] != 0){
			code += '<li>Spotlight the ad for '+data["spotlight"]*24+' hours.</li>';
		}

		code += '</ul>';
		console.log("code " +code);
		return code;
	}
</script>
@include("newthemplate.footer")