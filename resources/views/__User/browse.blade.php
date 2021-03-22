@extends('layouts.app')

@section('content')
<div class="container breadcrumb-class uppercase-text">
	<div class="row">
		<div class="col-lg-12 col-md-12 col-xs-12 no-padding-column">
			{{ Breadcrumbs::render() }}
		</div>
	</div>
</div>
<div class="container">
	<div class="col-lg-12 col-md-12 col-xs-12 margin-bottom visible-xs">
		<br/>
		<div id="backBtnDiv" class="back-button-link">❮ {{trans('buttons.back')}}</div>
	</div>

	<div class="row">
		<!-- Search Section -->
        <div class="col-lg-12 col-md-12 col-xs-12 browse-search-div">
            <span class="glyphicon glyphicon-search form-control-feedback" style="left:0px !important;top:8px;"></span>

            <?php if(!isset($searchString))$searchString = "";?>
            <input type="search" id="txtBrowseSearch" placeholder="Search" class=" browse-search-txt" style="font-family:Arial, FontAwesome" value="{{$searchString}}"></input>
        </div>

        <!-- Filter Section -->
        <div class="col-lg-12 col-md-12 col-xs-12 option-div">
              <div class="col-lg-4 col-md-4 col-xs-4">
              		<button id="tab0" class="display-mode-icon-button-active" onclick="switchViewMode(0);"><i class="fa fa-th" aria-hidden="true"></i></button>
              		<button id="tab1" class="display-mode-icon-button" onclick="switchViewMode(1);"><i class="fa fa-bars" aria-hidden="true"></i></button>
              </div>
              <div class="col-lg-8 col-md-8 col-xs-8" style="text-align: right;">
              		<button id="filterToggleBtn" class="filter-button uppercase-text" data-toggle="collapse" data-target="#filter">{{trans('buttons.filter')}}</button>
              		<span class="vertical-seperator-white">|</span><span class="sort-label uppercase-text">{{trans('action.sortby')}}</span>
              		<select class="form-control sort-drop-down-list" id="dropDownSort" style="float: right; margin-top: 10px; padding: 0px 0px">
						<option value="fromnewest" selected>{{trans('label-terms.fromnewest')}}</option>
              			<option value="fromoldest">{{trans('label-terms.fromoldest')}}</option>
						<option value="fromhighest">{{trans('label-terms.fromhighest')}}</option>
						<option value="fromlowest">{{trans('label-terms.fromlowest')}}</option>
					</select>
              </div>
        </div>

        <input id="hiddenFilterClickCount" type="hidden" name="hiddenFilterClickCount" value="0">  
        <input id="hiddenFilterBtnCount" type="hidden" name="hiddenFilterBtnCount" value="0">  
        <input id="hiddenFromSearchCriteriaFlag" type="hidden" name="hiddenFromSearchCriteriaFlag" value="no">

        <div id="savedHTML">
	        <form id="filterForm">
	        	<input id="hiddenCategory" type="hidden" name="searchCategory" value="none">
		    	<input id="hiddenSubCategory" type="hidden" name="searchSubCategory" value="none">
		        <input id="hiddenSearchType" type="hidden" name="searchType" value="{{ $searchType }}">
		    	<input id="hiddenSearchData" type="hidden" name="searchData" value="{{ $searchData }}">
		    	<input id="hiddenFromSearchCriteria" type="hidden" name="hiddenFromSearchCriteria" value="{{ $fromSearchCriteria }}">
		    	<input id="hiddenSyncHeight" type="hidden">
		        <input id="hiddenAttibuteId" type="hidden" name="attributeId" value="0">
		        <input id="hiddenFormOptionId" type="hidden" name="hiddenFormOptionId">
		        <input id="hiddenDataCount" type="hidden" name="hiddenDataCount" value="0">
		        <div id="filter" class="col-lg-12 col-md-12 col-xs-12 filter-div margin-bottom-20 collapse">
		        	<div class="col-lg-12 col-md-12 col-xs-12 form-rows filter-header" style="">
		        		<!--<h6 class="back-button-link" style="color: #fff;">{{trans('buttons.filter')}}</h6>-->
		        		<table style="width:100%;font-size: 16px;">
		        			<tr>
		        				<td style="width:15%;font-weight: bold;" onclick="$('#filterToggleBtn').click();">X</td>
		        				<td style="width:70%;"><b>Refine</b><br>
		        					{{$resultsCount}} result</td>
		        				<td style="width:15%;" onclick="$('#filterResetBtn').click();">Clear</td>
		        			</tr>
		        		</table>
		        	</div>
		        	<div class="col-lg-6 col-md-6 col-xs-12 form-rows categoryColumn">
						<label for="filterDropDownCategory" class="uppercase-text">{{trans("instruction-terms.pleaseselectyouroption")}}</label>
						<select id="filterDropDownCategory" name="filterDropDownCategory" class="form-control filter-drop-down" onchange="categoryChanged();">
							<option value="none">{{trans("instruction-terms.pleaseselectyouroption")}}</option>
								@foreach($category as $categories)
									<option value="{{ $categories['id'] }}">
										@if(count(explode(".", trans('categories.'.$categories['categoryName']))) > 1)
											{{ explode(".", trans('categories.'.$categories['categoryName']))[1] }}
										@else
											{{ trans('categories.'.$categories['categoryName']) }}
										@endif
									</option>
								@endforeach
						</select>
					</div>

					<div class="col-lg-6 col-md-6 col-xs-12 form-rows subCategoryColumn">
						<label for="filterDropDownSubCategory" class="uppercase-text">{{trans("instruction-terms.pleaseselectyouroption")}}</label>
						<select id="filterDropDownSubCategory" name="filterDropDownSubCategory" class="form-control filter-drop-down" onchange="subCategoryChanged();">
							<option value="none">{{trans("instruction-terms.pleaseselectyouroption")}}</option>
						</select>
					</div>

					<div class="col-lg-6 col-md-6 col-xs-12 form-rows">
			      		<div class="form-group">
			      			<div class="col-lg-4 col-md-4 col-xs-4 no-padding-column">
						    	<label for="dropCurrency" class="uppercase-text">{{trans('label-terms.price')}}</label>
						    	<select id="dropCurrency" name="dropCurrency" class="form-control filter-drop-down">
									@foreach($currency as $currencies)
			                            <option value="{{ $currencies->currencyCode }}">{{ $currencies->currencyCode }}</option>
		                            @endforeach
								</select>
						    </div>
						    <div class="col-lg-4 col-md-4 col-xs-4 no-padding-column">
						    	<label for="txtPriceMin"></label>
						    	<input id="txtMinPrice" type="number" name="txtMinPrice" class="form-control filter-text-box" placeholder="MIN" style="margin-top: 6px;">
						    </div>
						    <div class="col-lg-4 col-md-4 col-xs-4 no-padding-column">
						    	<label for="txtPriceMax"></label>
						    	<input id="txtMaxPrice" type="number" name="txtMaxPrice" class="form-control filter-text-box" placeholder="MAX" style="margin-top: 6px;">
						    </div>
					  	</div>
					</div>

		          	<div class="col-lg-12 col-md-12 col-xs-12 form-rows" style="padding-bottom: 10px;">
		          		<div class="form-group">
		                    <div class="col-lg-12 col-md-12 col-xs-12 no-padding-column">
		                    	<label class="uppercase-text" style="position: relative; top: 40px;">{{trans('label-terms.location')}}</label>
		                        <input id="searchInput" class="form-control" type="text" placeholder="&#xF002; {{trans('buttons.search')}}" style="font-family:Arial, FontAwesome;">
		                        <div id="getGeolocation" class="form-control uppercase-text login-buttons" style="text-align: center; float: right; width: 50px; position: relative; top: 36px; z-index: 999;"><i class="fa fa-map-marker" style="font-size: 15pt;" aria-hidden="true"></i></div>
		                        <div id="googleMap" style="width:100%;height:250px;"></div>
		                    </div>
		                    <input id="geolocationLongitude" name="geolocationLongitude" value="{{$user['longitude']}}" type="hidden"/>
		                    <input id="geolocationLatitude" name="geolocationLatitude" value="{{$user['latitude']}}" type="hidden"/>
		                    <input id="geolocationCountry" name="geolocationCountry" value="{{$user['country']}}" type="hidden"/>
		                    <input id="geolocationRegion" name="geolocationRegion" value="{{$user['region']}}" type="hidden"/>
		                    <input id="geolocationCity" name="geolocationCity" value="{{$user['city']}}" type="hidden"/>
		                    	 <label for="txtRegion"></label>
		                        <input id="txtRegion" name="txtRegion" class="form-control" style="margin-top: 7px; display: none;" placeholder="{{trans('label-terms.region')}}" value="{{$user['region']}}" disabled>
		                    	<label for="txtCountry"></label>
		                        <input id="txtCountry" name="txtCountry" class="form-control" style="margin-top: 7px; display: none;" placeholder="{{trans('label-terms.country')}}" value="{{$user['country']}}" disabled>
		                        <label for="txtCity"></label>
		                        <input id="txtCity" name="txtCity" class="form-control" style="margin-top: 7px; display: none;" placeholder="{{trans('label-terms.city')}}" value="{{$user['city']}}" disabled>
		                    <div class="col-lg-10 col-md-10 col-xs-10 no-padding-column" style="padding-top: 30px;">
		                    	<label class="uppercase-text" >{{trans('instruction-terms.setzeroforanydistance')}}</label>
		                        <input type="range" min="0" max="1000" step="1" value="0" data-orientation="horizontal"/>
		                    </div>
		                    <div class="col-lg-2 col-md-2 col-xs-2 no-padding-column" >
		                    	<label class="uppercase-text" >KM(s)</label>
		                    	<input id="txtRadius" type="number" name="txtRadius" class="form-control" placeholder="KM(s)" value="0" min="0" max="1000"/>
		                    </div>
		                </div>
		    		</div>

		    		<div id="attributeSection" style="display: none;">

			        	<!--Flexi Forms-->
						<div id="attributeFlexiForm">
						</div>
		        	</div>

		        	<div id="makeModelSection" style="display: none;">

			        	<!--Flexi Forms-->
						<div id="makeModelFlexiForm">
				      		<div id="childFlexiMakeModel"></div>
				      		<div class="col-lg-12 col-md-12 col-xs-12 form-rows" style="text-align: center;">
							    <div id="addMoreMakeModelBtn" data-count="0" class="add-make-button-link" onclick="addMoreMakeModel();">{{trans('instruction-terms.addmakemodel')}}</div>
							</div>
						</div>
					</div>

					<!--Flexi Forms-->
					<div id="filterFlexiForm">

					</div>
					<!-- -->

					<div class="col-lg-12 col-md-12 col-xs-12">
						<div class="col-lg-6 col-md-6 col-xs-6 margin-top-20">
				             <div id="filterResetBtn" class="filter-browse-buttons uppercase-text" style="margin-top: 16px;">{{trans('buttons.reset')}}</div>
				        </div>
				        <div class="col-lg-6 col-md-6 col-xs-6 margin-top-20">
				             <div id="btnFilter" class="filter-browse-buttons-active uppercase-text" onclick="filterBtnClick();" style="margin-top: 16px;">{{trans('buttons.filter')}}</div>
				        </div>
			        </div>
			        <div class="col-lg-12 col-md-12 col-xs-12">
			             <hr/>
			        </div>
		        </div>

		        <!-- Search Criteria Section -->
		        <div id="saveSearchCriteriaBtn" class="col-lg-12 col-md-12 col-xs-12 search-criteria-div" style="display: none;">
		        	<div class="save-criteria-buttons-active uppercase-text margin-bottom" onclick="saveSearchCriteria();">{{trans('buttons.savesearchcriteria')}}</div>
		        </div>

	        </form>
        </div>

		<!-- Recently Ads Section -->
		<div id="adsResult">
			<div class="col-lg-12 col-md-12 col-xs-12">
	        	<div class="results-number-title">{{$resultsCount}} {{trans('label-terms.results')}}</div>
	        </div>
			@if(count($ads) > 0)
				<div class="col-lg-offset-1 col-md-offset-1 col-lg-10 col-md-10 col-xs-12 rowse-section-div">
					@foreach ($ads as $ad)
					<div class="col-lg-3 col-md-3 col-xs-6 browse-section-div">
						<div class="row">
							@if( ($ad->spotLightDate != null) && ( date("Y-m-d H:i:s") >= date("Y-m-d", strtotime($ad->spotLightDate)) ) && ( date("Y-m-d H:i:s") <= date("Y-m-d H:i:s", strtotime($ad->spotLightDate .' +1 days')) ) )
									<span style="z-index: 99; position: relative; top: 50px; left: 20px; padding: 5px; font-weight: bold; color: #fff; background-color: #dd5347">Spotlight</span>
							@else
							<span style="z-index: 99; position: relative; top: 45px; left: 15px; padding: 5px; font-weight: bold;"></span>
							@endif
							<div class="browse-item">
								<div data-id="{{ $ad->id }}" class="adsClick" style="border-bottom: 1px solid #e0e0e0;">
									<div class="browse-ads-img" style="background-image: url({{ asset($ad->adsImage) }});"></div>
									<div class="browse-details-div">
										<div class="row">
											<div style="padding-left: 20px;">
												<h6 class="recently-ads-title">{{ $ad->adsName }}</h6>
											</div>
										</div>
										<div class="row">
											<div style="padding-left: 20px;">
												<h6 class="recently-ads-details">{{ $ad->adsRegion }}, {{ $ad->adsCountry }}</h6>
											</div>
										</div>
										<div class="row">
											<div style="padding-left: 20px;">
												<br/>
											</div>
										</div>
										@if(array_key_exists ( $ad->id , $adsDatas ))
											@foreach($adsDatas[$ad->id] as $adsData)
												@if($adsData->adsId == $ad->id)
													<div class="row">
														<div style="padding-left: 20px;">
															<h6 class="recently-ads-details">@if(count(explode(".", trans('formfields.'.$adsData->fieldTitle))) > 1)
														{{ explode(".", trans('formfields.'.$adsData->fieldTitle))[1] }}
													@else
														{{ trans('formfields.'.$adsData->fieldTitle) }}
													@endif : {{$adsData->text}}</h6>
														</div>
													</div>
												@endif
											@endforeach
										@endif
										<div class="row">
											<div class="col-lg-9 col-md-9 col-xs-9 list-view-price" style="display:none;">
												<div class="row">
													<h6 class="list-recently-ads-price">{{ $ad->adsPriceType }} {{ number_format($ad->adsPrice,2) }}</h6>
												</div>
											</div>
										</div>
									</div>
									<br/>
								</div>
								<div>
									<div class="row">
										<div class="col-lg-6 col-md-6 col-xs-12 list-view-favourite" style="display:none;">
											<div class="row">
												<div class="recently-wish-list" style="padding-left: 20px;">
													<span class="fa fa-heart btnFavourite" style="padding-left: 15px; margin-left: 0px;" data-id="fav-{{ $ad->id }}"></span>
												</div>
											</div>
										</div>
										<div class="col-lg-9 col-md-9 col-xs-9 grid-view-price">
											<div class="row">
												<h6 class="recently-ads-price">{{ Session::get('currency') }} {{ number_format($ad->adsPrice / Session::get('forexRate'),2) }}</h6>
											</div>
										</div>
										<div class="col-lg-3 col-md-3 col-xs-3 grid-view-favourite">
											<div class="row">
												<div class="recently-wish-list">
													<span class="fa fa-heart btnFavourite" style="float:right;" data-id="fav-{{ $ad->id }}"></span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					@endforeach
				</div>
			@else
			<div class="col-lg-1 col-md-1 col-xs-12 rowse-section-div">
			</div>
			<div class="col-lg-12 col-md-12 col-xs-12 form-rows bottom-border"><h6 class="admin-portal-title-blue">{{trans('empty-message.emptyadslisting')}}</h6></div>
			@endif
			<div id="refresh" class="col-lg-12 col-md-12 col-xs-12" style="text-align: center;">
				{{ $ads->render() }}
			</div>
		</div>
	</div>
</div>

<script>
	var host = location.protocol + '//' + location.host;
	var circles = [];
	var map;

	$( document ).ready(function() {

		/*if(!window.location.hash) {
	        window.location = window.location + '#loaded';
	        window.location.reload();
	    }*/
    	if (window.location.href.indexOf("filter=1") > -1) {

		    $("#filter").removeClass("collapsing");
		    $("#filter").addClass("collapse");
		   	$("#filter").addClass("in");
		   	$("#filter").show();
		}

		var searchId = $('#hiddenFromSearchCriteria').val();

		if($('#hiddenSearchType').val() == 'subCategory'){


			$('.categoryColumn').css('display', 'none');
			$('.subCategoryColumn').css('display', 'none');

			var subCategoryId = $('#hiddenSearchData').val();
			var path = host + '/getFilterForm';
			console.log("{{session()->get('locale')}}");

			$.ajax({
			      type: "GET",
			      url: path,
			      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			      data: ({ "subCategoryId": subCategoryId }),
			      success: function(data) {

			       	if(data.success == "success"){
			       		$('#filterFlexiForm').children().remove().end();
			            $('#filterFlexiForm').html(data.resultView);
			            $('.multipleSelect').multipleSelect();

			            if(data.checkLevel == true){
		            		$('#attributeSection').css('display', 'block');
			       			$('#attributeFlexiForm').append(data.attributeView);
			       		}
			       		else{

							if(data.countMakeModel.length > 0){

			       				$('#makeModelSection').css('display', 'block');
			       				$('#childFlexiMakeModel').children().remove().end();
			       				addMoreMakeModel();
				       			$('input[type="range"]').val(0).change();
			       			}
			       			else{

			       				$('#makeModelSection').css('display', 'none');
			       				$('#childFlexiMakeModel').children().remove().end();
			       			}
			       			

			       		}
			        }
			        else{
			          alert("{{trans('message-box.somethingwrong')}}");
			        }

			      },
			      error: function() {
			          alert("{{trans('message-box.somethingwrong')}}");
			      }
		    });
		}
		else if($('#hiddenSearchType').val() == 'category'){


			$('.categoryColumn').css('display', 'none');

			var categoryId = $('#hiddenSearchData').val();
	    	var path = host + '/filterDropDownCategory';

	        $.ajax({
	            type: "GET",
	            url: path,
	            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	            data: ({ "categoryId": categoryId}),
	            success: function(data) {

	            	if(data != null){

	            		$('#filterDropDownSubCategory').children().remove().end();

	            		$('#filterDropDownSubCategory').append('<option value="none">{{trans("instruction-terms.pleaseselectyouroption")}}</option>');

	            		for(var i = 0; i < data.subCategory.length; i++){

	            			$('#filterDropDownSubCategory').append('<option value="'+ data.subCategory[i].id +'">' +  data.subCategory[i].subCategoryName + '</option>');
	            		}
	            		$('input[type="range"]').val(0).change();
	            	}

	            },
	            error: function() {
	                alert("{{trans('message-box.somethingwrong')}}");
	            }
	        });

		}
		else if($('#hiddenSearchType').val() == 'name'){
			$('input[type="range"]').val(0).change();
		}

		if('{{ Auth::check() }}' == '1'){
			if({!!$favourite!!} != 'none'){
	    		$favouriteList = [{!!$favourite!!}];
		    	$.each($favouriteList[0], function( key, value ) {
		    		if(value["wishlistStatus"] == "active"){
						$('[data-id=fav-' + value["adsId"] + ']').css('color','#da444b');
						$('[data-id=fav-' + value["adsId"] + ']').css('text-shadow','#da444b 0px 0px 1px');
					}
				});
		    }

			$('.btnFavourite').click(function(){

				var adsId = $(this).attr('data-id').replace('fav-','');
				var path = host + '/addFavourite';

				$.ajax({
	                type: "POST",
	                url: path,
	                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	                data: ({ "adsId": adsId }),
	                success: function(data) {

	                    if(data.type == "unavailable"){
	                		$('[data-id=fav-' + adsId + ']').css('color','#ffffff');
	                    	$('[data-id=fav-' + adsId + ']').css('text-shadow','#000000 0px 0px 1px');
	                	}
	                	else{
	                		$('[data-id=fav-' + adsId + ']').css('color','#da444b');
	                    	$('[data-id=fav-' + adsId + ']').css('text-shadow','#da444b 0px 0px 1px');
	                	}

	                },
	                error: function() {
	                    alert("{{trans('message-box.somethingwrong')}}");
	                }
	            });
			});
		}
    	else{
    		$('.btnFavourite').click(function(){
    			window.location.href = '{{url("getLoginPage")}}';
			});
    	}

		    $('#dropDownSort').change(function(){

		    	$('#btnFilter').attr("disabled", true);

	        	jsonObj = [];
	        	$("#hiddenSearchData").val($("#txtBrowseSearch").val());

	        	var inputs = $(".flexibleFormValue");
	        	var secondInputs = $('.othersFlexiFormValue');
	        	var thirdInputs = $('.flexibleAttribute');

	        	for(var i = 0; i < inputs.length; i++){

				    item = { special:  $(inputs[i]).attr('data-special'), value: $(inputs[i]).val(), id: $(inputs[i]).attr('data-formFieldId'), type: $(inputs[i]).attr('data-type') };
console.log("item1");
console.log(item);
			        jsonObj.push(item);
				}

				for(var i = 0; i < secondInputs.length; i++){

				    item = { special: 'none', value: $(secondInputs[i]).val(), id: $(secondInputs[i]).attr('data-formFieldId'), type: $(secondInputs[i]).attr('data-type') };
console.log("item2");
console.log(item);
			        jsonObj.push(item);
				}

				for(var i = 0; i < thirdInputs.length; i++){

				    item = { special: 'none', value: $(thirdInputs[i]).val(), id: $(thirdInputs[i]).attr('data-formFieldId'), type: $(thirdInputs[i]).attr('data-type') };
console.log("item3");
console.log(item);
			        jsonObj.push(item);
				}

				var formFieldData = JSON.stringify(jsonObj);

				var searchType = $('#hiddenSearchType').val();
				var searchData = $('#hiddenSearchData').val();

				var filterForm = $('#filterForm').serialize() + "&formFieldData=" + formFieldData +
				"&searchType1=" + searchType + "&searchData1=" + searchData + "&sortType=" + $(this).val() +
				"&subCategoryId=" + $('#filterDropDownSubCategory').val() + "&categoryId=" + $('#filterDropDownCategory').val();

				var path = host + '/filterData';
				console.log(filterForm);
				$('body').addClass('loading');
				$.ajax({
				      type: "GET",
				      url: path,
				      contentType: false,
				      processData: false,
				      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				      data: filterForm,
				      success: function(data) {
				      	$('body').removeClass('loading');
				      	console.log("data = ");
				      	console.log(data);
				       	if(data.success == "success"){

				       		$('#adsResult').children().remove().end();
				       	    $('#btnFilter').attr("disabled", false);
				            $('#adsResult').html(data.resultView);
				        }
				        else{
				        	$('#btnFilter').attr("disabled", false);
				          alert("{{trans('message-box.somethingwrong')}}");
				        }

				      },
				      error: function() {
				      	$('body').removeClass('loading');
				      		$('#btnFilter').attr("disabled", false);
				          alert("{{trans('message-box.somethingwrong')}}");
				      }
			    });
		    });


        //Ajax
        $("#country").change(function(){

            var countryName = $('#country :selected').attr('value');
            var path = host + '/changeState';

            $.ajax({
                type: "GET",
                url: path,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: ({ "countryName": countryName }),
                dataType: "html",
                success: function(data) {

                    if(data != null){

                        $('#region').children().remove().end();

                        if(data == 'none'){
                            $('#region').append('<option value="none">{{trans("instruction-terms.pleaseselectyouroption")}}</option>');
                        }
                        else if(data == 'nostate'){
                             $('#region').append('<option value="' + countryName + '">' + countryName + '</option>');
                         }
                        else{
                            if(data.length > 0){
                                var dataArray = JSON.parse(data);

                                for(var i = 0; i < dataArray.length; i++){
                                    if(dataArray[i] != ''){
                                        $('#region').append('<option value="'+ dataArray[i] +'">' +  dataArray[i] + '</option>');
                                    }
                                }
                            }
                        }
                    }

                },
                error: function() {
                    alert("{{trans('message-box.somethingwrong')}}");
                }
            });
        });


		$('#txtBrowseSearch').keydown(function (e){
	        if(e.keyCode == 13){
	        	if($(this).val() == "" || $(this).val().replace(" ","")  == ""){
					alert("{{trans('message-box.Please enter keyword to search.')}}");
				}
				else{
		        	window.location.href = '/getAdsByName/'+ $(this).val();
		        }
			}
	     });

		$('#filterToggleBtn').click(function(){
			setTimeout(function(){
				if($('#hiddenFilterBtnCount').val() == 0){
					$('input[type="range"]').val(0).change();
				}
			},500);
		});

        var maxHeight = 0;

		$(".adsClick").each(function(){
		   if ($(this).height() > maxHeight) { maxHeight = $(this).height(); }
		});

		$('#hiddenSyncHeight').val(maxHeight);

		$(".adsClick").height($('#hiddenSyncHeight').val());

		if(searchId != false && searchId != 'none'){

			$('body').addClass('loading');
			$('#filterToggleBtn').css('display','none');
			var path = host + '/loadSearchCriteria';

			$.ajax({
				type: "GET",
				url: path,
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				data: ({ "searchId": searchId }),
				success: function(data) {

					if(data.success == "success"){
						$("#txtBrowseSearch").val();
						$('#adsResult').children().remove().end();
			            $('#adsResult').html(data.resultView);

			            $('#savedHTML').children().remove().end();
				    	$('#savedHTML').html(data.filterHtml);
				    	console.log("hiddenSearchData = "+$("#hiddenSearchData").val());
				    	if($("#hiddenSearchData").val()){
				    		$("#txtBrowseSearch").val($("#hiddenSearchData").val());
				    	}
				    	$('#filterDropDownCategory').val($('#hiddenCategory').val());
				    	$('#filterDropDownSubCategory').val($('#hiddenSubCategory').val());

				    	var jsonObject = JSON.parse(data.jsonData);

				    	for(var i = 0; i < jsonObject.length; i++){
				    		$('#'+jsonObject[i].id).val(jsonObject[i].value);
				    	}
			    		$('.makeDropDown>.modelClass').multipleSelect();
			    		$('.multipleSelect').multipleSelect();

			    		for(var i = 1; i <= 100; i++){
				    		for(var j = 0; j < 2; j++){
					    		$('.ms-parent').eq(i).remove();
					    	}
				    	}

				    	if(data.long != 0 || data.lat != 0){
							$('#geolocationLongitude').val(data.long);
				            $('#geolocationLatitude').val(data.lat);
						}

						$('#hiddenFromSearchCriteriaFlag').val(data.fromSearchCriteriaFlag);
					}
					else{
					  alert("{{trans('message-box.somethingwrong')}}");
					}

					$('body').removeClass('loading');
					$('#filterToggleBtn').css('display','inline');

				},
				error: function() {

				}

			});
		}
	});

	function filterBtnClick(){

		$('body').addClass('loading');
		$('#btnFilter').attr("disabled", true);
		$('#hiddenFilterBtnCount').val($('#hiddenFilterBtnCount').val() + 1);

        	jsonObj = [];

        	var inputs = $(".flexibleFormValue");
        	var secondInputs = $('.othersFlexiFormValue');
        	var thirdInputs = $('.flexibleAttribute');

        	$("#hiddenSearchData").val($("#txtBrowseSearch").val());

        	for(var i = 0; i < inputs.length; i++){

			    item = { special:  $(inputs[i]).attr('data-special'), value: $(inputs[i]).val(), id: $(inputs[i]).attr('data-formFieldId'), type: $(inputs[i]).attr('data-type') };

		        jsonObj.push(item);
			}

			for(var i = 0; i < secondInputs.length; i++){

			    item = { special: 'none', value: $(secondInputs[i]).val(), id: $(secondInputs[i]).attr('data-formFieldId'), type: $(secondInputs[i]).attr('data-type') };

		        jsonObj.push(item);
			}

			for(var i = 0; i < thirdInputs.length; i++){

			    item = { special: 'none', value: $(thirdInputs[i]).val(), id: $(thirdInputs[i]).attr('data-formFieldId'), type: $(thirdInputs[i]).attr('data-type') };

		        jsonObj.push(item);

			}

			var form = $('#filterForm')[0];

			var filterForm = new FormData(form);

			var formFieldData = JSON.stringify(jsonObj);

			var searchType = $('#hiddenSearchType').val();
			var searchData = $('#hiddenSearchData').val();

			var filterForm = $('#filterForm').serialize() + "&formFieldData=" + formFieldData +
			"&searchType1=" + searchType + "&searchData1=" + searchData + "&sortType=" + $('#dropDownSort').val() +
			"&subCategoryId=" + $('#filterDropDownSubCategory').val() + "&categoryId=" + $('#filterDropDownCategory').val();

			var path = host + '/filterData';


			$.ajax({
			      type: "GET",
			      url: path,
			      contentType: false,
			      processData: false,
			      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			      data: filterForm,
			      success: function(data) {

			       	if(data.success == "success"){

			       		$('body').removeClass('loading');

			       		if($('#filter').hasClass('in')){
							$('#filterToggleBtn').click();
						}

			       		$('#adsResult').children().remove().end();
			       	    $('#btnFilter').attr("disabled", false);
			            $('#adsResult').html(data.resultView);

			            if($('#filterDropDownSubCategory').val() != 'none' || $('#filterDropDownCategory') != 'none' || formFieldData != '[]'){

			            	if('{{ Auth::check() }}'){
					            $('#saveSearchCriteriaBtn').css('display','block');
					        }
				        }
				        else{
				        	$('#saveSearchCriteriaBtn').css('display','none');
				        }

				        var maxHeight = 0;

				        $(".adsClick").css('height','auto');

				        $(".adsClick").each(function(){
						   if ($(this).height() > maxHeight) { maxHeight = $(this).height(); }
						});

						$('#hiddenSyncHeight').val(maxHeight);

						$(".adsClick").height($('#hiddenSyncHeight').val());
			        }
			        else{
			        	$('body').removeClass('loading');
			        	$('#btnFilter').attr("disabled", false);
			          	alert("{{trans('message-box.somethingwrong')}}");
			        }

			      },
			      error: function(xhr) {
			      		$('body').removeClass('loading');
			      		$('#btnFilter').attr("disabled", false);
			          alert("{{trans('message-box.somethingwrong')}}");
			          console.log('Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText);
			      }
		    });
	}

	function addMoreMakeModel(){
		if($('#hiddenSearchType').val() != 'subCategory'){
			var subCategoryId = $('#filterDropDownSubCategory').val();
		}
		else{
			var subCategoryId = $('#hiddenSearchData').val();
		}

		var childCount = parseInt($('#addMoreMakeModelBtn').attr('data-count'));
		var parentCount = parseInt($('#addMoreMakeModelBtn').attr('data-count'));
		var count = parseInt($('#addMoreMakeModelBtn').attr('data-count')) + 4;
		var attributeId = $('#hiddenAttibuteId').val();
		var formFieldOptionId = $('#hiddenFormOptionId').val();

		$('#addMoreMakeModelBtn').attr('data-count', count);
		$('#hiddenDataCount').val(count);

		var path = host + '/getFilterForm';

		$.ajax({
		      type: "GET",
		      url: path,
		      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		      data: ({ "subCategoryId": subCategoryId, "attributeId": attributeId, "formFieldOptionId": formFieldOptionId, 'childCount': childCount, 'parentCount': parentCount }),
		      success: function(data) {

		       	if(data.success == "success"){

		       		$('#childFlexiMakeModel').append(data.makeModelView);
		       		$('#makeModelSet' + childCount + '>div>div>div>div>.modelClass').multipleSelect();

		        }
		        else{
		          alert("{{trans('message-box.somethingwrong')}}");
		        }

		      },
		      error: function() {
		          alert("{{trans('message-box.somethingwrong')}}");
		      }
	    });
	}

	//Ajax Drop Down Category
    function categoryChanged(){

    	$('body').addClass('loading');
    	var categoryId = $('#filterDropDownCategory :selected').attr('value');
    	var path = host + '/filterDropDownCategory';
       	$('#hiddenCategory').val(categoryId);

       	$('#attributeFlexiForm').empty();
		$('#filterFlexiForm').empty();
		$('#childFlexiMakeModel').empty();
		$('#makeModelSection').css('display', 'none');

        $.ajax({
            type: "GET",
            url: path,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: ({ "categoryId": categoryId}),
            success: function(data) {

            	if(data != null){

            		$('#filterDropDownSubCategory').children().remove().end();

            		$('#filterDropDownSubCategory').append('<option value="none">{{trans("instruction-terms.pleaseselectyouroption")}}</option>');

            		for(var i = 0; i < data.subCategory.length; i++){

            			$('#filterDropDownSubCategory').append('<option value="'+ data.subCategory[i].id +'">' + data.subCategory[i].text + '</option>');
            		}
            	}

            	$('body').removeClass('loading');

            },
            error: function() {
                alert("{{trans('message-box.somethingwrong')}}");
                $('body').removeClass('loading');
            }
        });
    }

    //Ajax Drop Down Sub Category
    function subCategoryChanged(){

    	$('body').addClass('loading');
    	var subCategoryId = $('#filterDropDownSubCategory :selected').attr('value');
		var path = host + '/getFilterForm';
		$('#hiddenSubCategory').val(subCategoryId);

		$('#attributeFlexiForm').empty();
		$('#filterFlexiForm').empty();
		$('#childFlexiMakeModel').empty();
		$('#makeModelSection').css('display', 'none');


		if(subCategoryId == 'none'){

			$('#childFlexiMakeModel').children().remove().end();
			$('#makeModelSection').css('display', 'none');
			$('body').removeClass('loading');
		}
		else{

				$.ajax({
			      type: "GET",
			      url: path,
			      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			      data: ({ "subCategoryId": subCategoryId }),
			      success: function(data) {

			      	$('body').removeClass('loading');

			       	if(data.success == "success"){

			       		$('#filterFlexiForm').children().remove().end();
			            $('#filterFlexiForm').html(data.resultView);
			            $('#filterFlexiForm>div>div>.multipleSelect').multipleSelect();

		            	if(data.checkLevel == true){
		            		$('#attributeSection').css('display', 'block');
		            		$('#attributeFlexiForm').children().remove().end();
			       			$('#attributeFlexiForm').html(data.attributeView);

			       			$('#makeModelSection').css('display', 'none');
			       			$('#childFlexiMakeModel').children().remove().end();
			       		}
			       		else{

			       			$('#hiddenAttibuteId').attr('value', 0);
			       			$('#attributeSection').css('display', 'none');
			       			$('#attributeFlexiForm').children().remove().end();

			       			if(data.countMakeModel.length > 0){

			       				$('#makeModelSection').css('display', 'block');
			       				$('#childFlexiMakeModel').children().remove().end();
			       			}
			       			else{

			       				$('#makeModelSection').css('display', 'none');
			       				$('#childFlexiMakeModel').children().remove().end();
			       			}
			       		}

			       		if($('#makeModelSection').css('display') == 'block'){
				       		addMoreMakeModel();
				       	}
			        }
			        else{
			          alert("{{trans('message-box.somethingwrong')}}");
			        }

			      },
			      error: function() {
			          alert("{{trans('message-box.somethingwrong')}}");
			          $('body').removeClass('loading');
			      }
		    });
		}
    }

	function saveSearchCriteria(){

		if($('#filter').hasClass('in')){
			$('#filterToggleBtn').click();
		}

		$('body').addClass('loading');

		jsonObj = [];
		makeModelJsonObj = [];
		attributeJsonObj = [];

		var inputs = $(".flexibleFormValue");
		var secondInputs = $('.othersFlexiFormValue');
		var thirdInputs = $('.flexibleAttribute');
		var makeModelInputs = $('.makeDropDown');
		var attributeInputs = $('.attributeDropDown');

		for(var i = 0; i < inputs.length; i++){

		    item = { id: $(inputs[i]).attr('id'), value: $(inputs[i]).val() };

	        jsonObj.push(item);
		}

		for(var i = 0; i < secondInputs.length; i++){

		    item = { id: $(secondInputs[i]).attr('id'), value: $(secondInputs[i]).val() };

	        jsonObj.push(item);
		}

		for(var i = 0; i < thirdInputs.length; i++){

		    item = { id: $(thirdInputs[i]).attr('id'), value: $(thirdInputs[i]).val() };

	        jsonObj.push(item);
		}

		for(var i = 0; i < makeModelInputs.length; i++){

			makeModelItem = { makeModelHtml: $(makeModelInputs[i]).html() };

		    makeModelJsonObj.push(makeModelItem);
		}

		for(var i = 0; i < attributeInputs.length; i++){

			attributeItem = { attributeHtml: $(attributeInputs[i]).html() };

		    attributeJsonObj.push(attributeItem);
		}

		//General
		item1 = { id: $('#hiddenCategory').attr('id'), value: $('#hiddenCategory').val(), type: 'hidden' };
		item2 = { id: $('#hiddenSubCategory').attr('id'), value: $('#hiddenSubCategory').val(), type: 'hidden' };
		item3 = { id: $('#hiddenSearchType').attr('id'), value: $('#hiddenSearchType').val(), type: 'hidden' };
		item4 = { id: $('#hiddenSearchData').attr('id'), value: $('#hiddenSearchData').val(), type: 'hidden' };
		item5 = { id: $('#hiddenFromSearchCriteria').attr('id'), value: $('#hiddenFromSearchCriteria').val(), type: 'hidden' };
		item6 = { id: $('#hiddenSyncHeight').attr('id'), value: $('#hiddenSyncHeight').val(), type: 'hidden' };
		item7 = { id: $('#hiddenAttibuteId').attr('id'), value: $('#hiddenAttibuteId').val(), type: 'hidden' };
		item8 = { id: $('#hiddenFormOptionId').attr('id'), value: $('#hiddenFormOptionId').val(), type: 'hidden' };
		item9 = { id: $('#hiddenDataCount').attr('id'), value: $('#hiddenDataCount').val(), type: 'hidden' };

	    //Others
		item10 = { id: $('#dropCurrency').attr('id'), value: $('#dropCurrency').val(), type: 'dropdown' };
		item11 = { id: $('#txtMinPrice').attr('id'), value: $('#txtMinPrice').val(), type: 'inputmin' };
		item12 = { id: $('#txtMaxPrice').attr('id'), value: $('#txtMaxPrice').val(), type: 'inputmax' };
		item13 = { id: $('#geolocationLongitude').attr('id'), value: $('#geolocationLongitude').val(), type: 'hidden' };
		item14 = { id: $('#geolocationLatitude').attr('id'), value: $('#geolocationLatitude').val(), type: 'hidden' };
		item15 = { id: $('#txtRadius').attr('id'), value: $('#txtRadius').val(), type: 'input' };

		jsonObj.push(item1);
		jsonObj.push(item2);
		jsonObj.push(item3);
		jsonObj.push(item4);
		jsonObj.push(item5);
		jsonObj.push(item6);
		jsonObj.push(item7);
		jsonObj.push(item8);
		jsonObj.push(item9);
		jsonObj.push(item10);
		jsonObj.push(item11);
		jsonObj.push(item12);
		jsonObj.push(item13);
		jsonObj.push(item14);
		jsonObj.push(item15);

		var form = $('#filterForm')[0];

		var filterForm = new FormData(form);

		var formFieldData = JSON.stringify(jsonObj);
		var makeModelHtmlData = JSON.stringify(makeModelJsonObj);
		var attributeHtmlData = JSON.stringify(attributeJsonObj);

		var searchType = $('#hiddenSearchType').val();
		var searchData = $('#hiddenSearchData').val();

		filterForm.append('formFieldData', formFieldData);
		filterForm.append('makeModelHtmlData', makeModelHtmlData);
		filterForm.append('attributeHtmlData', attributeHtmlData);
		filterForm.append('searchType1', searchType);
		filterForm.append('searchData1', searchData);
		filterForm.append('sortType', $('#dropDownSort').val());
		filterForm.append('searchString', $('#txtBrowseSearch').val());

		if($('#hiddenSearchType').val() == 'category'){
			filterForm.append('subCategoryId', $('#filterDropDownSubCategory').val());
			filterForm.append('categoryId', $('#hiddenSearchData').val());
		}
		else if($('#hiddenSearchType').val() == 'subCategory'){
			filterForm.append('subCategoryId', $('#hiddenSearchData').val());
			filterForm.append('categoryId', $('#hiddenSearchData').val());
		}
		else{
			filterForm.append('subCategoryId', $('#filterDropDownSubCategory').val());
			filterForm.append('categoryId', $('#filterDropDownCategory').val());
		}

		filterForm.append('searchQuery', $('#hiddenQuery').val());
		filterForm.append('searchHtml', $('#savedHTML').html());
		filterForm.append('searchSummary', $('#hiddenSearchString').val());
		//console.log("hiddenSearchString");
		//console.log($('#hiddenSearchString').val());
		//return;
		var path = host + '/addSearchAlert';

		$.ajax({
		      type: "POST",
		      url: path,
		      contentType: false,
		      processData: false,
		      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		      data: filterForm,
		      success: function(data) {

		       	if(data.success == "success"){
		       		$('body').removeClass('loading');
		       		alert('Saved Successful');
		        }
		        else{
		        	$('body').removeClass('loading');
		          	alert("{{trans('message-box.somethingwrong')}}");
		        }

		      },
		      error: function(xhr) {

		      		$('body').removeClass('loading');
		          alert("{{trans('message-box.somethingwrong')}}");
		          console.log('Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText);
		      }
	    });

    	// var asd = $('#savedHTML').html();

    	// $('#savedHTML').children().remove().end();
    	// alert(asd);
    	// $('#savedHTML').html(asd);
    	// $('#filterDropDownCategory').val($('#hiddenCategory').val());
    	// $('#filterDropDownSubCategory').val($('#hiddenSubCategory').val());
	}

	function switchViewMode(index){

		if(index == 0){
			$("#tab0").addClass("display-mode-icon-button-active");
			$("#tab1").removeClass("display-mode-icon-button-active");
			$("#tab1").addClass("display-mode-icon-button");
			$("#tab0").removeClass("display-mode-icon-button");

			$(".browse-section-div").removeClass("col-lg-12 col-md-12 col-xs-12");
			$(".browse-section-div").addClass("col-lg-3 col-md-3 col-xs-6");

			$(".browse-ads-img").removeClass("col-lg-4 col-md-4");
			$(".browse-details-div").removeClass("col-lg-8 col-md-8");

			$(".adsClick").height($('#hiddenSyncHeight').val());
			$(".adsClick").css('border-bottom','1px solid rgb(224, 224, 224)');

			$(".browse-ads-img").css("height","200px");
			$(".browse-ads-img").css("border-radius","5px 5px 0px 0px");

			$(".grid-view-price").css("display","block");
			$(".grid-view-favourite").css("display","block");
			$(".list-view-price").css("display","none");
			$(".list-view-favourite").css("display","none");
		}else{
			$("#tab1").addClass("display-mode-icon-button-active");
			$("#tab0").removeClass("display-mode-icon-button-active");
			$("#tab0").addClass("display-mode-icon-button");
			$("#tab1").removeClass("display-mode-icon-button");

			$(".browse-section-div").removeClass("col-lg-3 col-md-3 col-xs-6");
			$(".browse-section-div").addClass("col-lg-12 col-md-12 col-xs-12");

			$(".browse-ads-img").addClass("col-lg-4 col-md-4");
			$(".browse-details-div").addClass("col-lg-8 col-md-8");

			$(".adsClick").height('auto');
			$(".adsClick").css('border-bottom','0px none');

			$(".browse-ads-img").css("height","600px");
			$(".browse-ads-img").css("border-radius","5px 5px 5px 5px");

			$(".grid-view-price").css("display","none");
			$(".grid-view-favourite").css("display","none");
			$(".list-view-price").css("display","block");
			$(".list-view-favourite").css("display","block");
		}
	}

    $(document).ready(function(){

        $('.adsClick').click(function(){

            var adsId = $(this).attr('data-id');
            window.location.href = '/getAdsDetails/'+ adsId;
        });

        $('#filterResetBtn').click(function(){

            $(".filter-drop-down").prop('selectedIndex', 0);
            $(".filter-text-box").val('');
        });
    });

	function loadAdsDetails(){
    	alert("Details");
    }

    function setFavourite(){
    	alert("Favourite");
    }

    function dropDownParentOnChange(parentId){

    $('body').addClass('loading');
	var formOptionId = $('.flexibleFormValue[data-id="'+  parentId +'"]').find(':selected').attr('data-id');
	var path = host + '/getParentValue';

		if(formOptionId == 0){

			$('.flexibleFormValue[data-parentId="'+  parentId +'"]').children().remove().end();
		    $('.flexibleFormValue[data-parentId="'+  parentId +'"]').append('<option value="none" > Any</option>').multipleSelect("refresh");
		}
		else{

			$.ajax({
		        type: "GET",
		        url: path,
		        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		        data: ({ "formOptionId": formOptionId }),
		        success: function(data) {

		        	if(data.success == 'success'){

		        		$('.flexibleFormValue[data-parentId="'+  parentId +'"]').children().remove().end();
console.log(data);
		        		for(var i = 0; i < data.formFieldOption.length; i++){

		               		$('.flexibleFormValue[data-parentId="'+  parentId +'"]').append('<option value="'+ data.formFieldOption[i].value +'" data-id="' + data.formFieldOption[i].id + '"> ' +  data.formFieldOption[i].text + '</option>').multipleSelect("refresh");
		                }
		        	}

		        	$('body').removeClass('loading');
		        },
		        error: function() {
		            alert("{{trans('message-box.somethingwrong')}}");
		            $('body').removeClass('loading');
		        }
		    });
		}

	}

	function dropDownAttributeChange(id){

		$('body').addClass('loading');
		$('#hiddenAttibuteId').attr('value', id);
		var formOptionId = $('.flexibleAttribute[data-id="'+  id +'"]').find(':selected').attr('data-id');
		$('#hiddenFormOptionId').attr('value', formOptionId);

		$('#makeModelSection').css('display', 'block');
		$('#childFlexiMakeModel').children().remove().end();

		$('body').removeClass('loading');
	}

	function onDeleteMakeModelClick(id){

		var path = '#makeModelSet' + id;

		$(path).css('display', 'none');
		$('#childFlexiMakeModel').children().remove(path);
	}

	function myMap() {

        if($('#geolocationLongitude').val() == null && $('#geolocationLatitude').val() == null){
            $('#geolocationLongitude').val({{$longitude}});
            $('#geolocationLatitude').val({{$latitude}});
        }

        var mapProp = {
            center:new google.maps.LatLng($('#geolocationLatitude').val(),$('#geolocationLongitude').val()),
            zoom:12,
            streetViewControl: false,
            fullscreenControl: false,
            mapTypeControl: false,
        };

        map = new google.maps.Map(document.getElementById("googleMap"),mapProp);
        var geocoder = new google.maps.Geocoder;

        var marker = new google.maps.Marker({
          position: new google.maps.LatLng($('#geolocationLatitude').val(),$('#geolocationLongitude').val()),
          map: map,
          draggable: true,
        });

        google.maps.event.addListener(marker, 'dragend', function(evt){
            var latlng = new google.maps.LatLng(evt.latLng.lat().toFixed(4),evt.latLng.lng().toFixed(4));
            geocoder.geocode({'location': latlng}, function(results, status) {
                if (status === 'OK') {
                    if (results[0]["address_components"]) {
                        var hasCity = false;
                        var hasRegion = false;
                        var hasCountry = false;

                        for (var i = 0; i < results[0]["address_components"].length; i++) {
                          var component = results[0]["address_components"][i];

                            if(component['types'][0] == "locality"){
                                $('#txtCity').val(component['long_name']);
                                $('#geolocationCity').val(component['long_name']);
                                hasCity = true;
                            }
                            else if(component['types'][0] == "administrative_area_level_1"){
                                $('#txtRegion').val(component['long_name']);
                                $('#geolocationRegion').val(component['long_name']);
                                hasRegion = true;
                            }
                            else if(component['types'][0] == "country"){
                                $('#txtCountry').val(component['long_name']);
                                $('#geolocationCountry').val(component['long_name']);
                                hasCountry = true;
                            }
                        }

                        if(hasCity == false){
                            $('#txtCity').val('');
                            $('#geolocationCity').val('');
                        }

                        if(hasRegion == false){
                            $('#txtRegion').val('');
                            $('#geolocationRegion').val('');
                        }

                        if(hasCountry == false){
                            $('#txtCountry').val('');
                            $('#geolocationCountry').val('');
                        }
                    } else {
                        window.alert('No results found.');
                    }
                } else {
                    window.alert('Plase select a valid location.');
                }
            });

            $('#geolocationLongitude').val(evt.latLng.lng().toFixed(4));
            $('#geolocationLatitude').val(evt.latLng.lat().toFixed(4));

            for(var i in circles) {
				circles[i].setMap(null);
			}

			circles = [];

            var circle = new google.maps.Circle({
                radius: $('#txtRadius').val()*1000,
                center: new google.maps.LatLng(evt.latLng.lat().toFixed(4),evt.latLng.lng().toFixed(4)),
                map: map,
                fillColor: '#FF0000',
                fillOpacity: 0.2,
                strokeColor: '#FF0000',
                strokeOpacity: 0.6
            });

            circles.push(circle);
		    map.fitBounds(circle.getBounds());

        });

        var input = document.getElementById('searchInput');
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.bindTo('bounds', map);

        autocomplete.addListener('place_changed', function() {
            marker.setVisible(false);
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                return;
            }

            map.setZoom(16);
            map.setCenter(place.geometry.location);
            marker.setPosition(place.geometry.location);
            marker.setVisible(true);

            var hasCity = false;
            var hasRegion = false;
            var hasCountry = false;

            for (var i = 0; i < place.address_components.length; i++) {
              var component = place.address_components[i];

                if(component['types'][0] == "locality"){
                    $('#txtCity').val(component['long_name']);
                    $('#geolocationCity').val(component['long_name']);
                    hasCity = true;
                }
                else if(component['types'][0] == "administrative_area_level_1"){
                    $('#txtRegion').val(component['long_name']);
                    $('#geolocationRegion').val(component['long_name']);
                    hasRegion = true;
                }
                else if(component['types'][0] == "country"){
                    $('#txtCountry').val(component['long_name']);
                    $('#geolocationCountry').val(component['long_name']);
                    hasCountry = true;
                }
            }

            if(hasCity == false){
                $('#txtCity').val('');
                $('#geolocationCity').val('');
            }

            if(hasRegion == false){
                $('#txtRegion').val('');
                $('#geolocationRegion').val('');
            }

            if(hasCountry == false){
                $('#txtCountry').val('');
                $('#geolocationCountry').val('');
            }

            $('#geolocationLongitude').val(place.geometry.location.lng().toFixed(4));
            $('#geolocationLatitude').val(place.geometry.location.lat().toFixed(4));

            for(var i in circles) {
				circles[i].setMap(null);
			}

			circles = [];

            var circle = new google.maps.Circle({
                radius: $('#txtRadius').val()*1000,
                center: new google.maps.LatLng(place.geometry.location.lat().toFixed(4),place.geometry.location.lng().toFixed(4)),
                map: map,
                fillColor: '#FF0000',
                fillOpacity: 0.2,
                strokeColor: '#FF0000',
                strokeOpacity: 0.6
            });

            circles.push(circle);
		    map.fitBounds(circle.getBounds());

        });

        var geolocation = document.getElementById('getGeolocation');

        geolocation.addEventListener('click', function() {
            if (navigator.geolocation) {
                var position = navigator.geolocation.getCurrentPosition(function (position) {
                    map.setZoom(16);
                    map.setCenter({
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    });
                    marker.setPosition({
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    });

                    var latlng = {lat: position.coords.latitude, lng: position.coords.longitude};
                    geocoder.geocode({'location': latlng}, function(results, status) {
                        if (status === 'OK') {
                            if (results[0]["address_components"]) {
                                var hasCity = false;
                                var hasRegion = false;
                                var hasCountry = false;

                                for (var i = 0; i < results[0]["address_components"].length; i++) {
                                  var component = results[0]["address_components"][i];

                                    if(component['types'][0] == "locality"){
                                        $('#txtCity').val(component['long_name']);
                                        $('#geolocationCity').val(component['long_name']);
                                        hasCity = true;
                                    }
                                    else if(component['types'][0] == "administrative_area_level_1"){
                                        $('#txtRegion').val(component['long_name']);
                                        $('#geolocationRegion').val(component['long_name']);
                                        hasRegion = true;
                                    }
                                    else if(component['types'][0] == "country"){
                                        $('#txtCountry').val(component['long_name']);
                                        $('#geolocationCountry').val(component['long_name']);
                                        hasCountry = true;
                                    }
                                }

                                if(hasCity == false){
                                    $('#txtCity').val('');
                                    $('#geolocationCity').val('');
                                }

                                if(hasRegion == false){
                                    $('#txtRegion').val('');
                                    $('#geolocationRegion').val('');
                                }

                                if(hasCountry == false){
                                    $('#txtCountry').val('');
                                    $('#geolocationCountry').val('');
                                }
                            } else {
                                window.alert('No results found');
                            }
                        } else {
                            window.alert('Geocoder failed due to: ' + status);
                        }
                    });

                    $('#geolocationLongitude').val(position.coords.longitude.toFixed(4));
                    $('#geolocationLatitude').val(position.coords.latitude.toFixed(4));

                    for(var i in circles) {
						circles[i].setMap(null);
					}

					circles = [];

		            var circle = new google.maps.Circle({
		                radius: $('#txtRadius').val()*1000,
		                center: new google.maps.LatLng(position.coords.latitude.toFixed(4),position.coords.longitude.toFixed(4)),
		                map: map,
		                fillColor: '#FF0000',
		                fillOpacity: 0.2,
		                strokeColor: '#FF0000',
		                strokeOpacity: 0.6
		            });

		            circles.push(circle);
		            map.fitBounds(circle.getBounds());

                });
            } else {
                x.innerHTML = "Geolocation is not supported by this browser.";
            }
        });

		$('#txtRadius').change(function() {

            for(var i in circles) {
				circles[i].setMap(null);
			}

			circles = [];

            var circle = new google.maps.Circle({
                radius: $('#txtRadius').val()*1000,
                center: new google.maps.LatLng($('#geolocationLatitude').val(),$('#geolocationLongitude').val()),
                map: map,
                fillColor: '#FF0000',
                fillOpacity: 0.2,
                strokeColor: '#FF0000',
                strokeOpacity: 0.6
            });

            circles.push(circle);
		    map.fitBounds(circle.getBounds());

		});

		$('#filterToggleBtn').click(function(){
console.log("filterToggleBtn");
			setTimeout(function(){
				google.maps.event.trigger(map, "resize");

				if (navigator.geolocation && typeof searchId != undefined) {
					var position = navigator.geolocation.getCurrentPosition(function (position) {
						map.setZoom(16);
						map.setCenter({
	                        lat: position.coords.latitude,
	                        lng: position.coords.longitude
	                    });
	                    marker.setPosition({
	                        lat: position.coords.latitude,
	                        lng: position.coords.longitude
	                    });
	                    var latlng = {lat: position.coords.latitude, lng: position.coords.longitude};

	                    geocoder.geocode({'location': latlng}, function(results, status) {
	                    	if (status === 'OK') {
	                            if (results[0]["address_components"]) {
	                                var hasCity = false;
	                                var hasRegion = false;
	                                var hasCountry = false;

	                                for (var i = 0; i < results[0]["address_components"].length; i++) {
	                                  var component = results[0]["address_components"][i];

	                                    if(component['types'][0] == "locality"){
	                                        $('#txtCity').val(component['long_name']);
	                                        $('#geolocationCity').val(component['long_name']);
	                                        hasCity = true;
	                                    }
	                                    else if(component['types'][0] == "administrative_area_level_1"){
	                                        $('#txtRegion').val(component['long_name']);
	                                        $('#geolocationRegion').val(component['long_name']);
	                                        hasRegion = true;
	                                    }
	                                    else if(component['types'][0] == "country"){
	                                        $('#txtCountry').val(component['long_name']);
	                                        $('#geolocationCountry').val(component['long_name']);
	                                        hasCountry = true;
	                                    }
	                                }

	                                if(hasCity == false){
	                                    $('#txtCity').val('');
	                                    $('#geolocationCity').val('');
	                                }

	                                if(hasRegion == false){
	                                    $('#txtRegion').val('');
	                                    $('#geolocationRegion').val('');
	                                }

	                                if(hasCountry == false){
	                                    $('#txtCountry').val('');
	                                    $('#geolocationCountry').val('');
	                                }
	                            } else {
	                                window.alert('No results found');
	                            }
	                        } else {
	                            window.alert('Geocoder failed due to: ' + status);
	                        }
	                    });

	                    $('#geolocationLongitude').val(position.coords.longitude.toFixed(4));
	                    $('#geolocationLatitude').val(position.coords.latitude.toFixed(4));

	                    for(var i in circles) {
							circles[i].setMap(null);
						}

						circles = [];

						var circle = new google.maps.Circle({
			                radius: $('#txtRadius').val()*1000,
			                center: new google.maps.LatLng(position.coords.latitude.toFixed(4),position.coords.longitude.toFixed(4)),
			                map: map,
			                fillColor: '#FF0000',
			                fillOpacity: 0.2,
			                strokeColor: '#FF0000',
			                strokeOpacity: 0.6
			            });

			            circles.push(circle);
			            map.fitBounds(circle.getBounds());
					});

				$('#txtRadius').val(0);
				$('input[type="range"]').val(0).change();

				} else {
	                x.innerHTML = "Geolocation is not supported by this browser.";
	            }

	            $('.rangeslider').eq(1).remove();
				$('.rangeslider').eq(2).remove();
				$('.rangeslider').eq(3).remove();
				$('.rangeslider').eq(4).remove();
				$('.rangeslider').eq(5).remove();
			},100);

			if(!$('#filter').hasClass("in") && $('#hiddenFilterClickCount').val() == 0){

				$('#hiddenFilterClickCount').val($('#hiddenFilterClickCount').val() + 1);
	    		$('#masterMapLoader').remove().end();
				$('#googleMap').children().remove().end();
				$('body').append('<input id="searchInput" class="form-control" type="text" placeholder="&#xF002; {{trans('buttons.search')}}" style="font-family:Arial, FontAwesome;">');
				$('body').append('<script id="masterMapLoader" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDFZGVMX5YGM9hQmsAxRG_F5lwpiURDOCs&libraries=places&callback=myMap"/>');
				$('input[type="range"]').val(0).change();
			}

			var filterClickCounter = $('#hiddenFilterClickCount').val();
			$('#hiddenFilterClickCount').val(parseInt(filterClickCounter)+1);

			$('#txtRadius').val(0);
			$('input[type="range"]').val(0).change();
		});           	

		$('input[type="range"]').rangeslider({
			polyfill : false,

			rangeClass: 'rangeslider',
		    disabledClass: 'rangeslider--disabled',
		    horizontalClass: 'rangeslider--horizontal',
		    verticalClass: 'rangeslider--vertical',
		    fillClass: 'rangeslider__fill',
		    handleClass: 'rangeslider__handle',

		    onInit: function() {
		    	$(window).trigger('resize');
		    	$('input[type="range"]').val(0).change();
		    },

		    onSlide: function(position, value) {

		    	$('#txtRadius').val(value);

		    	for(var i in circles) {
					circles[i].setMap(null);
				}

				circles = [];

	            var circle = new google.maps.Circle({
	                radius: $('#txtRadius').val()*1000,
	                center: new google.maps.LatLng($('#geolocationLatitude').val(),$('#geolocationLongitude').val()),
	                map: map,
	                fillColor: '#FF0000',
	                fillOpacity: 0.2,
	                strokeColor: '#FF0000',
	                strokeOpacity: 0.6
	            });

	            circles.push(circle);
	            map.fitBounds(circle.getBounds());
	            $(window).trigger('resize');
		    },

		    onSlideEnd: function(position, value) {
		    }
		});

		if($('#txtRadius').val() > 0){
			circles = [];

            var circle = new google.maps.Circle({
                radius: $('#txtRadius').val()*1000,
                center: new google.maps.LatLng($('#geolocationLatitude').val(),$('#geolocationLongitude').val()),
                map: map,
                fillColor: '#FF0000',
                fillOpacity: 0.2,
                strokeColor: '#FF0000',
                strokeOpacity: 0.6
            });

            circles.push(circle);
		    map.fitBounds(circle.getBounds());

		    $('input[type="range"]').val(0).change();
        }
    }
</script>

@endsection
