@extends('layouts.app')

@section('content')
	
@if(count($ads) < 1)
	<form id="placeAdsForm">
		<div class="col-lg-12 col-md-12 col-xs-12 margin-bottom visible-xs">
			<br/>
			<div id="backBtnDiv" class="back-button-link">❮ {{trans('buttons.back')}}</div>
		</div>

		<div class="container">
<!-- 			<div class="ajax-loader">
			  <img src="{{ url('guest/images/ajax-loader.gif') }}" class="img-responsive" />
			</div> -->
			<div class="row">

		        @if (count($errors) > 0)
				    <div class="alert alert-danger">
				        <ul>
				            @foreach ($errors->all() as $error)
				                <li>{{ $error }}</li>
				            @endforeach
				        </ul>
				    </div>
				@endif

				@if (\Session::has('success'))
				    <div class="alert alert-success">
				        <ul>
				            <li>{!! \Session::get('success') !!}</li>
				        </ul>
				    </div>
				@endif

				<!-- <div class="col-lg-12 col-md-12 col-xs-12 form-rows">
					<input type="text" name="txtBikes" placeholder="{{trans('place-ads.Bikes')}}" class="form-control" />
				</div>

				<div class="col-lg-12 col-md-12 col-xs-12 form-rows">
					<input type="text" name="txtMotor" placeholder="{{trans('place-ads.Motocross')}}" class="form-control" />
				</div> -->
					{!! Form::hidden('checkData', 'null', array('id' => 'invisibleCheckData')) !!}
					{!! Form::hidden('adsId', 0, array('id' => 'invisibleAdsId')) !!}

					<span style="display: none;">{{$counter = 0}}</span>
					<div class="col-lg-12 col-md-12 col-xs-12 form-rows">
						<div class="row">
							<h6 class="policy-title" style="margin-left: 15px; text-align: center;">
								{{trans('label-terms.fillinadsdetails')}}
							</h6>
						</div>
					</div>

					<div class="col-lg-12 col-md-12 col-xs-12 form-rows">
						<label for="dropDownCategory" class="uppercase-text">{{trans('label-terms.categorysubcategory')}}</label>
						<select id="dropDownCategory" name="dropDownCategory" class="form-control">
							<option>{{trans("instruction-terms.pleaseselectyouroption")}}</option>
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

					<div class="col-lg-12 col-md-12 col-xs-12 form-rows">
						<select id="dropDownSubCategory" name="dropDownSubCategory" class="form-control">
							<option value="none">{{trans("instruction-terms.pleaseselectyouroption")}}</option>
						</select>
					</div>

					<div class="col-lg-12 col-md-12 col-xs-12 form-rows" style="margin-top: 20px;">
						<label for="photoLabel" class="uppercase-text">{{trans('label-terms.photos')}}</label>
						<h6 class="place-ads-photo-message">{{trans('instruction-terms.adsWithPhotoSellFast')}}</h6>
						<div class="form-group">
							<div class="file-input-div">
								<label for="uploadPhotoTxt" id="photoLabel" class="label-buttons">{{trans('instruction-terms.choosephototoupload')}}</label> <label class="label-buttons" onclick="clearImages();">Clear</label>
								<h6 class="place-ads-photo-message">{{trans('instruction-terms.addupto10photos')}}</h6>
								<h6 class="place-ads-photo-message">{{trans('instruction-terms.acceptImageType')}}</h6>
								<div id="gallerySection" class="gallery"></div>
								<input type="file" multiple="multiple" id="uploadPhotoTxt" maxLimit="6" class="inputfile" style="display: none;" accept="image/*" onchange="addNewImages(this);" />
								<input type="hidden" id="imageCounter" name="imageCounter" value="0"/>
								<div class="col-lg-12 col-md-12 col-xs-12 form-rows">
									<div id="imagePreviewerBox">

									</div>
								</div>

								<input id="primaryImageHidden" name="primaryImageHidden" type="hidden" value="none"/>
								<input id="primaryImageIdHidden" name="primaryImageIdHidden" type="hidden" value="none"/>
							</div>
					  	</div>
					</div>

					<div class="col-lg-12 col-md-12 col-xs-12 form-rows">
						<div class="form-group">
						    <label for="adsTitleTxt" class="uppercase-text">{{trans('label-terms.adstitle')}}</label>
						    <input class="form-control" type="text" id="adsTitleTxt" placeholder="Max 30 characters" name="txtAdsTitle" maxlength="30" required/>
						    <h6 class="place-ads-field-desc">{{trans('instruction-terms.placeAdsDescriptionExplaination')}}</h6>
					  	</div>
					</div>

					<div class="col-lg-3 col-md-3 col-xs-6 form-rows">
						<div class="form-group">
						    <label for="priceTxt" class="uppercase-text">{{trans('label-terms.currency')}}</label>
						    <select id="dropDownCurrency" name="dropDownCurrency" class="form-control">
						    	@foreach($currency as $currencies)
		                            <option value="{{ $currencies->currencyCode }}">{{ $currencies->currencyCode }}</option>
	                            @endforeach
	                        </select>
					  	</div>
					</div>

					<div class="col-lg-3 col-md-3 col-xs-6 form-rows">
						<div class="form-group">
						    <label for="priceTxt" class="uppercase-text">{{trans('label-terms.price')}}</label>
						    <input class="form-control" type="number" id="priceTxt" placeholder="{{trans('label-terms.price')}}" name="txtAdsPrice" required/>
					  	</div>
					</div>

					<div class="col-lg-12 col-md-12 col-xs-12 form-rows">
						<hr/>
					</div>

					<div id="formField"></div>

					<div class="col-lg-12 col-md-12 col-xs-12 form-rows" style="margin-top: 28px;">
						<br/>
						<div class="form-group">
						    <label for="descriptionTxt" class="uppercase-text">{{trans('label-terms.description')}}</label>
						    <textarea class="form-control" rows="5" id="descriptionTxt" name="txtAdsDescription" placeholder="{{trans('instruction-terms.tellusaboutyouritem')}}" required></textarea>
					  	</div>
					</div>

					<div class="col-lg-12 col-md-12 col-xs-12 form-rows" style="margin-top: 28px;">
						<div class="form-group">
						    <label for="descriptionTxt" class="uppercase-text">{{trans('label-terms.searchtags')}}</label>
						    <div class="row">
						    	<div class="col-lg-10 col-md-10 col-xs-8">
						    		<input class="form-control" type="text" id="addTagTxt" name="addTagTxt" maxlength="30"/>
						    		<h6 class="place-ads-field-desc">{{trans('instruction-terms.placeAdsTagExplaination')}}</h6>
						    	</div>
						    	<div class="col-lg-2 col-md-2 col-xs-4">
						    		<div id="addTagBtn" class="form-control login-buttons" onclick="addTag();" style="text-align: center; float: left;">Add</div>
						    	</div>
						    </div>
						    <div id="searchtagarea">
						    </div>

						    
					  	</div>
					</div>

					<div class="col-lg-12 col-md-12 col-xs-12 form-rows" style="padding-bottom: 10px;">		

		          		<div class="form-group">
		                    <div class="col-lg-12 col-md-12 col-xs-12 no-padding-column">
		                        <input id="searchInput" class="form-control" type="text" placeholder="&#xF002; {{trans('buttons.search')}}" style="font-family:Arial, FontAwesome;">
		                        <label for="googleMap" class="uppercase-text">{{trans('label-terms.location')}}</label>
		                        <div id="getGeolocation" class="form-control uppercase-text login-buttons" style="text-align: center; float: right; width: 50px; position: relative; top: 36px; z-index: 999;"><i class="fa fa-map-marker" style="font-size: 15pt;" aria-hidden="true"></i></div>

		                        <div id="googleMap" style="width:100%;height:400px;"></div>
		                    </div>
		                    <input id="geolocationLongitude" name="geolocationLongitude" value="{{$user['longitude']}}" type="hidden"/>
		                    <input id="geolocationLatitude" name="geolocationLatitude" value="{{$user['latitude']}}" type="hidden"/>
		                    <input id="geolocationCountry" name="geolocationCountry" value="{{$user['country']}}" type="hidden"/>
		                    <input id="geolocationRegion" name="geolocationRegion" value="{{$user['region']}}" type="hidden"/>
		                    <input id="geolocationCity" name="geolocationCity" value="{{$user['city']}}" type="hidden"/>
		                    <div class="col-lg-4 col-md-4 col-xs-4 no-padding-column">
		                        <label for="txtCountry"></label>
		                        <input id="txtCountry" name="txtCountry" class="form-control" style="margin-top: 7px;" placeholder="{{trans('label-terms.country')}}" value="{{$user['country']}}" disabled>
		                    </div>
		                    <div class="col-lg-4 col-md-4 col-xs-4 no-padding-column">
		                        <label for="txtRegion"></label>
		                        <input id="txtRegion" name="txtRegion" class="form-control" style="margin-top: 7px;" placeholder="{{trans('label-terms.region')}}" value="{{$user['region']}}" disabled>
		                    </div>
		                    <div class="col-lg-4 col-md-4 col-xs-4 no-padding-column">
		                        <label for="txtCity"></label>
		                        <input id="txtCity" name="txtCity" class="form-control" style="margin-top: 7px;" placeholder="{{trans('label-terms.city')}}" value="{{$user['city']}}" disabled>
		                    </div>

		                </div>
		                <h6 class="place-ads-field-desc">{{trans('instruction-terms.placeAdsLocationExplaination')}}</h6>
		    		</div>

					<div class="col-lg-12 col-md-12 col-xs-12 form-rows" style="margin-bottom: 10px;">
						<div class="form-group">
		                    <div class="col-lg-6 col-md-6 col-xs-6 no-padding-column">
								<label for="txtAdsContact" class="uppercase-text">{{trans('label-terms.phone')}}</label>
								<select id="callingCode" name="dropDownCallingCode" class="form-control">
									@foreach($callingCodeList as $callingCode)
		                                @if($user['callingCode'] == $callingCode->phonecode)
		                                <option value="{{ $callingCode->phonecode }}" selected>{{ $callingCode->name }} (+{{ $callingCode->phonecode }})</option>
		                                @else
		                                <option value="{{ $callingCode->phonecode }}">{{ $callingCode->name }} (+{{ $callingCode->phonecode }})</option>
		                                @endif
		                            @endforeach
		                        </select>
	                        </div>
		                    <div class="col-lg-6 col-md-6 col-xs-6 no-padding-column">
		                    	<label for="phone" class="uppercase-text"> </label>
								<input type="number" id="phone" name="txtAdsContact" placeholder="{{trans('label-terms.phone')}}" class="form-control" value="{{ $user->phone }}" required style="margin-top: 7px;"/>
							</div>
							<h6 class="place-ads-field-desc">{{trans('instruction-terms.PlaceAdsContactExplanation')}}</h6>
						</div>
					</div>

					<div id="packageDiv" style="display: none;">

						<div class="col-lg-12 col-md-12 col-xs-12 form-rows">
							<div class="row">
								<h6 class="policy-title" style="margin-left: 15px; text-align: center;">
									{{trans('label-terms.selectadsplan')}}
								</h6>
							</div>
						</div>

						<div class="col-lg-4 col-md-4 col-xs-12">
							<div class="box">
								<div class="place-ads-box">
								<div class="col-lg-12 col-md-12 col-xs-12 place-ads-header">
								<h6 class="header-title uppercase-text">{{trans('label-terms.basic')}}</h6>
								</div>
								<div class="col-lg-12 col-md-12 col-xs-12 place-ads-subheader">
									<div class="row">
										<div class="place-ads-pricing-cell">
											<div class="pricing-price" style="border-color: #a0c910;">
												<h6 class="pricing-label-black" style="position: relative; top: 26px;"><span style="font-size:20pt; vertical-align: top; color: #acacac;">€</span><span id="basicPrice">0</span></h6>
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-12 col-md-12 col-xs-12 place-ads-content">
								<div class="col-lg-3 col-md-3 col-xs-3">
								</div>
								<div id="basicDetailsDiv" class="col-lg-9 col-md-9 col-xs-9 package_details_div" style="text-align: left;">
								    <h6 class="content-text"><i class="fa fa-check" aria-hidden="true"></i> <span id="basicListedDay">0</span> {{trans('label-terms.daysofruntime')}}</h6>
								</div>
								<div class="col-lg-12 col-md-12 col-xs-12">
									<div id="basicAdsBtn" name="placeBtn" value="basicAds" class="btn btn-primary btn-block short-buttons uppercase-text" onclick="setAdsType('basic');">{{trans('buttons.select')}}</div>
								</div>
								</div>
								</div>
							</div>
						</div>

						<div class="col-lg-4 col-md-4 col-xs-12">
							<div class="box">
								<div class="place-ads-box">
									<div class="col-lg-12 col-md-12 col-xs-12 place-ads-header">
										<h6 class="header-title uppercase-text">{{trans('label-terms.autobump')}}</h6>

									</div>
									<div class="col-lg-12 col-md-12 col-xs-12 place-ads-subheader">
										<div class="row">
											<div class="place-ads-pricing-cell">
												<div class="pricing-price" style="border-color: #e39d5a;">
													<h6 class="pricing-label-black" style="position: relative; top: 26px;"><span style="font-size:20pt; vertical-align: top; color: #acacac;">€</span><span id="autoPrice">0</span></h6>
												</div>
											</div>
										</div>
									</div>
					        <div class="col-lg-12 col-md-12 col-xs-12 place-ads-content">
					        	<div class="col-lg-3 col-md-3 col-xs-3">
					        	</div>
					        	<div id="autoDetailsDiv" class="col-lg-9 col-md-9 col-xs-9 package_details_div" style="text-align: left;">
						            <h6 class="content-text"><i class="fa fa-check" aria-hidden="true"></i> <span id="autoListedDay">0</span> {{trans('label-terms.daysofruntime')}}</h6>
					        	</div>
					        	<div class="col-lg-12 col-md-12 col-xs-12">
					        		<div id="autoAdsBtn" name="placeBtn" value="autoBumpAds" class="btn btn-primary btn-block short-buttons uppercase-text"onclick="setAdsType('auto-bump');">{{trans('buttons.select')}}</div>
					        	</div>
					        </div>
								</div>
							</div>
						</div>

						<div class="col-lg-4 col-md-4 col-xs-12">
							<div class="box">
								<div class="ribbon">
									<span>HOT</span>
								</div>
								<div class="place-ads-box">
									<div class="col-lg-12 col-md-12 col-xs-12 place-ads-header">
										<h6 class="header-title uppercase-text">{{trans('label-terms.spotlight')}}</h6>
									</div>
									<div class="col-lg-12 col-md-12 col-xs-12 place-ads-subheader">
										<div class="row">
											<div class="place-ads-pricing-cell">
												<div class="pricing-price" style="border-color: #d9534f;">
													<h6 class="pricing-label-black" style="position: relative; top: 26px;"><span style="font-size:20pt; vertical-align: top; color: #acacac;">€</span><span id="spotlightPrice">0</span></h6>
												</div>
											</div>
										</div>
									</div>
						        <div class="col-lg-12 col-md-12 col-xs-12 place-ads-content">
						        	<div class="col-lg-3 col-md-3 col-xs-3">
						        	</div>
						        	<div id="spotlightDetailsDiv" class="col-lg-9 col-md-9 col-xs-9 package_details_div" style="text-align: left;">
							            <h6 class="content-text"><i class="fa fa-check" aria-hidden="true"></i> <span id="spotlightListedDay">0</span> {{trans('label-terms.daysofruntime')}}</h6>
						        	</div>
						        	<div class="col-lg-12 col-md-12 col-xs-12">
						        		<div id="spotlightAdsBtn" name="placeBtn" value="spotlightAds" class="btn btn-primary btn-block short-buttons uppercase-text"onclick="setAdsType('spotlight');">{{trans('buttons.select')}}</div>
						        	</div>
						        </div>
								</div>
							</div>
						</div>

					</div>

					<div id="addonsDiv" style="display: none;">

						<div class="col-lg-12 col-md-12 col-xs-12 form-rows">
							<div class="row">
								<h6 class="policy-title" style="margin-left: 15px; text-align: center;">
									{{trans('label-terms.selectaddons')}}
								</h6>
							</div>
						</div>
						<div id="add_ons_option" class="col-md-offset-3 col-lg-offset-3 col-lg-6 col-md-6 col-xs-12 form-rows" style="font-size:18px;margin-bottom:10px;background-color:#fafafa;">
						</div>
					</div>
					<div id="total_price_row" class="col-md-offset-3 col-lg-offset-3 col-lg-6 col-md-6 col-xs-12 form-rows" style="display:none;font-size:18px;margin-bottom:10px;background-color:#dcdbdb;padding:20px;">
						Total <span id="total_price" style="float:right;"></span>
					</div>

					<div class="col-lg-offset-4 col-md-offset-4 col-lg-4 col-md-4 col-xs-12">
			            <button name="btnPlaceAds" value="placeAds" id="btnPlaceAds" class="btn btn-danger btn-block place-ads-buttons uppercase-text">{{trans('buttons.payandpublish')}}</button>
			        </div>
			        <div class="col-lg-offset-4 col-md-offset-4 col-lg-4 col-md-4 col-xs-12 text-center" style="font-size:10px;margin-top:5px;">
			        	<?php
			        		$text1 = str_replace("[t&c]",'<a style="color:#0af;" href="'.url("getTermsOfUse").'">'.trans('policy-terms.termsofuse').'</a>',trans('instruction-terms.placeAdsAgreeTerm1'));

			        		$text2 = str_replace("[pricing]",'<a style="color:#0af;" href="'.url("getPricingPage").'">'.trans('label-terms.pricing').'</a>',trans('instruction-terms.placeAdsAgreeTerm2'));
			        	?>
			        	{!!$text1!!} <br> {!!$text2!!}
			            <!--By clicking "Sell Now!", you agree to the B4MX <a style="color:#0af;" href="{{url('getTermsOfUse')}}">TERMS OF USE</a>.<br>
			            Read about our <a style="color:#0af;" href="{{url('getPricingPage')}}">PRICING</a>.-->
			        </div>
		        <br/>

		        <input type="hidden" id="adsType" name="adsTypeHidden" value="none">
				<input type="hidden" id="selectedPackageId" name="selectedPackageId" value="none">
		        <input type="hidden" id="addOns" name="selectedAddOnId" value="none">

		    </div>
		</div>
			{{ csrf_field() }}
	</form>
@else
	<form id="placeAdsForm">
		<input id="tagHidden" name="tagHidden" value='{!! $tags !!}' type="hidden"/>  
		<div class="container">
			<div class="col-lg-12 col-md-12 col-xs-12 margin-bottom visible-xs">
				<br/>
				<div id="backBtnDiv" class="back-button-link">❮ {{trans('buttons.back')}}</div>
			</div>

			<div class="row">
		        @if (count($errors) > 0)
				    <div class="alert alert-danger">
				        <ul>
				            @foreach ($errors->all() as $error)
				                <li>{{ $error }}</li>
				            @endforeach
				        </ul>
				    </div>
				@endif

				<!-- <div class="col-lg-12 col-md-12 col-xs-12 form-rows">
					<input type="text" name="txtBikes" placeholder="{{trans('place-ads.Bikes')}}" class="form-control" />
				</div>

				<div class="col-lg-12 col-md-12 col-xs-12 form-rows">
					<input type="text" name="txtMotor" placeholder="{{trans('place-ads.Motocross')}}" class="form-control" />
				</div> -->

				<div class="col-lg-12 col-md-12 col-xs-12 form-rows">
					<div class="row">
						<h6 class="policy-title" style="margin-left: 15px; text-align: center;">
							{{trans('label-terms.fillinadsdetails')}}
						</h6>
					</div>
				</div>

				@foreach($ads as $ad)
		    		{!! Form::hidden('adsId', $ad->id, array('id' => 'invisibleAdsId')) !!}
		    		{!! Form::hidden('checkData', 'hasData', array('id' => 'invisibleCheckData')) !!}
			        <div class="col-lg-12 col-md-12 col-xs-12 form-rows">
			        	<label for="dropDownCategory" class="uppercase-text">{{trans('label-terms.categorysubcategory')}}</label>
						<select id="dropDownCategory" name="dropDownCategory" class="form-control">
							<option>{{trans("instruction-terms.pleaseselectyouroption")}}</option>
								@foreach($category as $categories)
									@if($categories['id'] == $categoryId)
										<option value="{{ $categories['id'] }}" selected>{{ $categories['categoryName'] }}</option>
									@else
										<option value="{{ $categories['id'] }}">{{ $categories['categoryName'] }}</option>
									@endif
								@endforeach
						</select>
					</div>

					<div class="col-lg-12 col-md-12 col-xs-12 form-rows">
						<select id="dropDownSubCategory" name="dropDownSubCategory" class="form-control">
							<option value="none">{{trans("instruction-terms.pleaseselectyouroption")}}</option>
							@foreach($subCategory as $subCategories)
								@if($ad->subCategoryId == $subCategories->id)
									<option value="{{ $subCategories->id }}" selected>
										@if(count(explode(".", trans('subcategories.'.$subCategories->subCategoryName))) > 1)
											{{ explode(".", trans('subCategories.'.$subCategories->subCategoryName))[1] }}
										@else
											{{ trans('subCategories.'.$subCategories->subCategoryName) }}
										@endif
									</option>
								@else
									<option value="{{ $subCategories->id }}">
										@if(count(explode(".", trans('subcategories.'.$subCategories->subCategoryName))) > 1)
											{{ explode(".", trans('subCategories.'.$subCategories->subCategoryName))[1] }}
										@else
											{{ trans('subCategories.'.$subCategories->subCategoryName) }}
										@endif
									</option>
								@endif
							@endforeach
						</select>
					</div>

					<div class="col-lg-12 col-md-12 col-xs-12 form-rows" style="margin-top: 20px;">
						<label for="photoLabel" class="uppercase-text">{{trans('label-terms.photos')}}</label>
						<div class="form-group">
							<div class="file-input-div">
								<label for="uploadPhotoTxt" id="photoLabel" class="label-buttons">{{trans('instruction-terms.choosephototoupload')}}</label> <label class="label-buttons" onclick="clearImages();">Clear</label>
								<h6 class="place-ads-photo-message">{{trans('instruction-terms.addupto10photos')}}</h6>
								<div id="gallerySection" class="gallery"></div>
								<input type="file" multiple="multiple" id="uploadPhotoTxt" maxLimit="6" class="inputfile" style="display: none;" accept="image/*" onchange="addNewImages(this);" />
								<input type="hidden" id="imageCounter" name="imageCounter" value="0"/>
								<div class="col-lg-12 col-md-12 col-xs-12 form-rows">
									<div id="imagePreviewerBox">
										@if(count($galleryImages) > 0)
											<span style="display: none;">{{$counter = 0}}</span>
											@foreach($galleryImages as $galleryImage)
												<div id="{{$counter}}" class="col-lg-2 col-md-2 col-xs-6 image-editing-box" data-src="{{$galleryImage}}" style="background-image: url('{{$galleryImage}}'); background-size: cover; height: 150px; border: 5px solid white; background-position: 50% 50%;"><input id="image{{$counter}}" name="hiddenImageBase64[]" class="hiddenUploadImages" type="hidden" value="{{$galleryImage}}"/><span style="cursor: pointer; font-size: 10pt; color: red; background-color: #002450; color: white; position: absolute; bottom: 0; left: 0; width: 80%;" onclick="primaryImage('{{$counter}}');">{{trans("instruction-terms.setasprimary")}}</span><span style="cursor: pointer; font-size: 10pt; color: red; background-color: red; color: white; position: absolute; bottom: 0; right: 0; width: 20%;" onclick="deleteImage('{{$counter}}');"><i id="deleteSign" class="fa fa-times" aria-hidden="true" style="font-size: 10pt; color: white;"></i></span><div class="primary-indicator">
												@if($galleryImage == $primaryImage)
													<span style="cursor: pointer; font-size: 10pt; color: red; background-color: #002450; color: white; position: absolute; top: 0; left: 0; width: 100%;">{{trans("label-terms.primary")}}</span>
													<span style="display: none;">{{$primaryId = $counter}}</span>
												@endif
												</div></div>
												<span style="display: none;">{{$counter++}}</span>
											@endforeach
										@endif
									</div>
								</div>

								<input id="primaryImageHidden" name="primaryImageHidden" type="hidden" value="{{$primaryImage}}"/>
								<input id="primaryImageIdHidden" name="primaryImageIdHidden" type="hidden" value="{{$primaryId}}"/>
							</div>
					  	</div>
					</div>

					<div class="col-lg-12 col-md-12 col-xs-12 form-rows" style="margin-top: 20px;">
						<div class="form-group">
						    <label for="adsTitleTxt" class="uppercase-text">{{trans('label-terms.adstitle')}}</label>
						    <input class="form-control" value="{{ $ad->adsName }}" placeholder="Max 30 characters" type="text" id="adsTitleTxt" maxlength="30" name="txtAdsTitle" required/>
					  	</div>
					</div>

					<div class="col-lg-3 col-md-3 col-xs-6 form-rows">
						<div class="form-group">
						    <label for="priceTxt" class="uppercase-text">{{trans('label-terms.currency')}}</label>
						    <select id="dropDownCurrency" name="dropDownCurrency" class="form-control">
	                            @foreach($currency as $currencies)
	                            	@if($currencies->currencyCode == $ad->adsPriceType)
		                            	<option value="{{ $currencies->currencyCode }}" selected="selected">{{ $currencies->currencyCode }}</option>
		                            @else
		                            	<option value="{{ $currencies->currencyCode }}">{{ $currencies->currencyCode }}</option>
		                            @endif
	                            @endforeach
	                        </select>
					  	</div>
					</div>

					<div class="col-lg-3 col-md-3 col-xs-6 form-rows">
						<div class="form-group">
						    <label for="priceTxt" class="uppercase-text">{{trans('label-terms.price')}}</label>
						    @foreach($currency as $currencies)
						    	@if($currencies->currencyCode == $ad->adsPriceType)
						    		<input class="form-control" step="0.01" value="{{str_replace(',', '', number_format($ad->adsPrice / $currencies->conversionRate,2))}}" type="number" id="priceTxt" name="txtAdsPrice" required />
						    	@endif
						    @endforeach
					  	</div>
					</div>

					<div id="formField" class="form-rows"></div>

					<div class="col-lg-12 col-md-12 col-xs-12">
						<div class="form-group">
						    <label for="descriptionTxt" class="uppercase-text" style="margin-top: 28px;">{{trans('label-terms.description')}}</label>
						    <textarea class="form-control" rows="5" id="descriptionTxt" name="txtAdsDescription" placeholder="{{trans('instruction-terms.tellusaboutyouritem')}}" required>{{ $ad->adsDescription }}</textarea>
					  	</div>
					</div>

					<div class="col-lg-12 col-md-12 col-xs-12 form-rows" style="margin-top: 28px;">
						<div class="form-group">
						    <label for="descriptionTxt" class="uppercase-text">{{trans('label-terms.searchtags')}}</label>
						    <div class="row">
						    	<div class="col-lg-10 col-md-10 col-xs-8">
						    		<input class="form-control" type="text" id="addTagTxt" name="addTagTxt" maxlength="30"/>
						    	</div>
						    	<div class="col-lg-2 col-md-2 col-xs-4">
						    		<div id="addTagBtn" class="form-control login-buttons" onclick="addTag();" style="text-align: center; float: left;">Add</div>
						    	</div>
						    </div>
						    <div id="searchtagarea">
						    </div>
					  	</div>
					</div>

					<div class="col-lg-12 col-md-12 col-xs-12 form-rows" style="margin-top: 10px;">		
		          		<div class="form-group">
		                    <div class="col-lg-12 col-md-12 col-xs-12 no-padding-column">
		                    	<label for="googleMap" class="uppercase-text">{{trans('label-terms.location')}}</label>
		                        <input id="searchInput" class="form-control" type="text" placeholder="&#xF002; {{trans('buttons.search')}}" style="font-family:Arial, FontAwesome;">
		                        <div id="googleMap" style="width:100%;height:250px;"></div>
		                    </div>
		                    <input id="geolocationLongitude" name="geolocationLongitude" value="{{$ad->adsLongitude}}" type="hidden"/>
		                    <input id="geolocationLatitude" name="geolocationLatitude" value="{{$ad->adsLatitude}}" type="hidden"/>
		                    <input id="geolocationCountry" name="geolocationCountry" value="{{$ad->adsCountry}}" type="hidden"/>

		                    <input id="geolocationRegion" name="geolocationRegion" value="{{$ad->adsRegion}}" type="hidden"/>
		                    <input id="geolocationCity" name="geolocationCity" value="{{$ad->adsCity}}" type="hidden"/>
		                    <div class="col-lg-3 col-md-3 col-xs-3 no-padding-column">
		                        <label for="txtCountry"></label>
		                        <input id="txtCountry" name="txtCountry" class="form-control" style="margin-top: 7px;" placeholder="{{trans('label-terms.country')}}" value="{{$ad->adsCountry}}" disabled>
		                    </div>
		                    <div class="col-lg-3 col-md-3 col-xs-3 no-padding-column">
		                        <label for="txtRegion"></label>
		                        <input id="txtRegion" name="txtRegion" class="form-control" style="margin-top: 7px;" placeholder="{{trans('label-terms.region')}}" value="{{$ad->adsRegion}}" disabled>
		                    </div>
		                    <div class="col-lg-3 col-md-3 col-xs-3 no-padding-column">
		                        <label for="txtCity"></label>
		                        <input id="txtCity" name="txtCity" class="form-control" style="margin-top: 7px;" placeholder="{{trans('label-terms.city')}}" value="{{$ad->adsCity}}" disabled>
		                    </div>
		                    <div class="col-lg-3 col-md-3 col-xs-3 no-padding-column">
		                        <label for="nearme"></label>
		                        <div id="getGeolocation" class="form-control uppercase-text login-buttons" style="margin-top: 7px; text-align: center;"><i class="fa fa-map-marker" style="font-size: 15pt;" aria-hidden="true"></i></div>
		                    </div>
		                </div>
		    		</div>

					<div class="col-lg-12 col-md-12 col-xs-12 form-rows">
						<div class="form-group">
		                    <div class="col-lg-6 col-md-6 col-xs-6 no-padding-column">
								<label for="txtAdsContact" class="uppercase-text">{{trans('label-terms.phone')}}</label>
								<select id="callingcode" name="dropDownCallingCode" class="form-control">
									@foreach($callingCodeList as $callingCode)
		                                @if($ad->adsCallingCode == $callingCode->phonecode)
		                                <option value="{{ $callingCode->phonecode }}" selected>{{ $callingCode->name }} (+{{ $callingCode->phonecode }})</option>
		                                @else
		                                <option value="{{ $callingCode->phonecode }}">{{ $callingCode->name }} (+{{ $callingCode->phonecode }})</option>
		                                @endif
		                            @endforeach
		                        </select>
	                        </div>
		                    <div class="col-lg-6 col-md-6 col-xs-6 no-padding-column">
		                    	<label for="phone" class="uppercase-text"> </label>
								<input type="number" id="phone" name="txtAdsContact" placeholder="{{trans('label-terms.phone')}}" class="form-control" value="{{ $ad->adsContactNo }}" required style="margin-top: 7px;"/>
								<br/><br/>
							</div>
						</div>
					</div>

					<div class="col-lg-offset-4 col-md-offset-4 col-lg-4 col-md-4 col-xs-12">
						<br/>
			            <button id="btnEditAds" name="placeBtn" value="EditAds" class="btn btn-danger btn-block place-ads-buttons uppercase-text">{{trans('buttons.save')}}</button>
			            <button name="btnDelete" value="delete" id="btnDelete" class="btn btn-danger btn-block place-ads-buttons uppercase-text">{{trans('buttons.delete')}}</button>
			            @if($ad->adsPlaceMethod == 'draft')
			            <button name="btnPlaceAds" value="placeAds" id="btnPlaceAds" class="btn btn-danger btn-block place-ads-buttons uppercase-text">{{trans('buttons.placeads')}}</button>
			            @endif
			        </div>
		        @endforeach
		        <br/>
		    </div>
		</div>
			{{ csrf_field() }}
	</form>
@endif

<script src="{{ asset('js/load-image.all.min.js') }}"></script>
	<script>
		
	</script>

	<script>
		var tagArray = [];
		var formTagArray = [];

	var package_pricing_data = {};
	var pricing_details_data = {};
	var pricing_add_ons_data = {};
	var pricing_add_ons_ary = {};
		$( document ).ready(function() {

			if({{count($ads)}} !== 0){

				var array = $.parseJSON($('#tagHidden').val());

				for(var i = 0; i < array.length; i++){
					if(array[i].type == "form"){
						formTagArray.push(array[i].tagValue);
					}
					else if(array[i].type == "etc"){
						tagArray.push(array[i].tagValue);
					}
				}

				refreshTag();
			}

			$('#imageCounter').val({{$counter}});

			var host = location.protocol + '//' + location.host;

			$('#btnDelete').click(function(e){

				e.preventDefault();

				var adsId = $('#invisibleAdsId').attr('value');

				$.ajax({
	                type: "POST",
	                url: 'deleteEditPageAds',
	                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	                data: ({ "adsId": adsId }),
	                success: function(data) {

                        alert("{{trans('message-box.deletedsuccessfully')}}");
                        window.location.href = host + "/getActiveAdsPage";

	                },
	                error: function() {
	                    alert("{{trans('message-box.somethingwrong')}}");
	                }
	            });

			});

			$(window).keydown(function(event){
	            if(event.keyCode == 13) {
	              event.preventDefault();
	              return false;
	            }
	        });

			//Starter for has data

			$('.class option[value="'+ $('.class').find(":selected").val() +'"]').prop('selected', true);
			//kelvin set selected prop

			if($('#invisibleCheckData').attr('value') == 'hasData'){

				var adsId = $('#invisibleAdsId').attr('value');

				$.ajax({
	                type: "GET",
	                url: 'placeAdsGotData',
	                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	                data: ({ "adsId": adsId }),
	                success: function(data) {

                        $('#formField').html(data.formView);

	                },
	                error: function() {
	                    alert("{{trans('message-box.somethingwrong')}}");
	                }
	            });
			}


	        $('#btnSaveAds').on('click', function(e){

	        	$('#btnSaveAds').attr("disabled", true);

	        	if($('#dropDownCategory')[0].selectedIndex == 0 || $('#dropDownSubCategory')[0].selectedIndex == 0){
	        		e.preventDefault();
	        		$('#btnSaveAds').attr("disabled", false);
	        		alert("{{trans('message-box.selectcategoryandsubcategory')}}");
	        	}
	        	else if($("#imageCounter").val() == 0){
	        		e.preventDefault();
	        		$('#btnSaveAds').attr("disabled", false);
	        		alert("{{trans('message-box.pleasechooseatleast')}}");
	        	}
	        	else{
					if($("#placeAdsForm")[0].checkValidity()) {
			        	if($('#adsType').val() == "none"){
			        		e.preventDefault();
			        		$('#btnSaveAds').attr("disabled", false);
			        		alert("{{trans('message-box.selectadstype')}}");
			        	}
			        	else{
			        		
			        		var inputs = $(".flexibleFormValue");
			        		var count = 0;


				        	for(var i = 0; i < inputs.length; i++){

							    if($(inputs[i]).val() == "none"){
							    	count++;
							    }
							}

							if(count > 0){


								alert("{{trans('message-box.pleasefillinalldetails')}}");

							}
							else{

				        		$('body').addClass('loading');

					        	jsonObj = [];
					        	imgObj = [];

					        	e.preventDefault();
					        	var inputs = $(".flexibleFormValue");
					        	var images = $(".hiddenUploadImages");

					        	for(var i = 0; i < inputs.length; i++){				  

								    item = { value: $(inputs[i]).val(), id: $(inputs[i]).attr('data-id') };

							        jsonObj.push(item);
								}

								for(var i = 0; i < images.length; i++){				  

								    item = { value: $(images[i]).val() };

							        imgObj.push(item);
								}
									
								var form = $('#placeAdsForm')[0];

				  				var placeAdsForm = new FormData(form);

				  				var formFieldData = JSON.stringify(jsonObj);
				  				var imageData = JSON.stringify(imgObj); 

				  				placeAdsForm.append('formFieldData', formFieldData);
				  				placeAdsForm.append('formImageData', imageData);
				  				placeAdsForm.append('placeType', "saveAds");
				  				placeAdsForm.append('tag', JSON.stringify(tagArray));
				  				placeAdsForm.append('formFieldTag', JSON.stringify(formTagArray));

								$.ajax({

								      type: "POST",
								      url: 'addNewAds',
								      contentType: false,
								      processData: false,
								      enctype: 'multipart/form-data',
								      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
								      data: placeAdsForm,
								      dataType: "html",
								      success: function(data) {

								       	if(data.success = "success"){
								       		$('body').removeClass('loading');
								       		$('#page-content-wrapper').find("input, select, button, textarea").removeAttr('readonly');
								       		$('#btnSaveAds').attr("disabled", false);
								        	window.location.href = "/getActiveAdsPage?btnMethod=draft&success=save";
								        }
								        else{
								        	$('body').removeClass('loading');
								        	$('#page-content-wrapper').find("input, select, button, textarea").removeAttr('readonly');
								        	$('#btnSaveAds').attr("disabled", false);
								        }
								          
								      },
								      error: function() {
								      	$('body').removeClass('loading');
								      	$('#page-content-wrapper').find("input, select, button, textarea").removeAttr('readonly');
								      	$('#btnSaveAds').attr("disabled", false);
								          alert("{{trans('message-box.somethingwrong')}}");
								      }
							    });
							}

						}
					}
					else{
						$('#btnSaveAds').attr("disabled", false);
					}
				}

	        });

	        $('#btnPlaceAds').on('click', function(e){

        		
	        	if($('#dropDownCategory')[0].selectedIndex == 0 || $('#dropDownSubCategory')[0].selectedIndex == 0){
	        		e.preventDefault();
	        		$('#btnPlaceAds').attr("disabled", false);
	        		alert("{{trans('message-box.selectcategoryandsubcategory')}}");
	        	}
	        	else if($("#imageCounter").val() == 0){
	        		e.preventDefault();
	        		$('#btnPlaceAds').attr("disabled", false);
	        		alert("{{trans('message-box.pleasechooseatleast')}}");
	        	}
	        	else{
		        	if($("#placeAdsForm")[0].checkValidity()) {
			        	if($('#adsType').val() == "none" && $('#invisibleAdsId').attr('value') == 0){
			        		e.preventDefault();
			        		$('#btnPlaceAds').attr("disabled", false);
			        		alert("{{trans('message-box.selectadstype')}}");
			        	}
			        	else{

			        		var inputs = $(".flexibleFormValue");
			        		var count = 0;

				        	for(var i = 0; i < inputs.length; i++){

							    if($(inputs[i]).val() == "none"){
							    	count++;
							    }
							}

							if(count > 0){


								alert("{{trans('message-box.pleasefillinalldetails')}}");

							}
							else{

				        		$('body').addClass('loading');
					        	var adsId = $('#invisibleAdsId').attr('value');
					        	jsonObj = [];
					        	imgObj = [];

					        	e.preventDefault();
					        	var inputs = $(".flexibleFormValue");
					        	var images = $(".hiddenUploadImages");

					        	for(var i = 0; i < inputs.length; i++){				  

								    item = { value: $(inputs[i]).val(), id: $(inputs[i]).attr('data-id') };

							        jsonObj.push(item);
								}

								for(var i = 0; i < images.length; i++){				  

								    item = { value: $(images[i]).val() };

							        imgObj.push(item);
								}
									
								var form = $('#placeAdsForm')[0];

				  				var placeAdsForm = new FormData(form);

				  				var formFieldData = JSON.stringify(jsonObj);
				  				var imageData = JSON.stringify(imgObj); 

				  				placeAdsForm.append('formFieldData', formFieldData);
				  				placeAdsForm.append('formImageData', imageData);
				  				placeAdsForm.append('placeType', "placeAds");
				  				placeAdsForm.append('adsId', adsId);
				  				placeAdsForm.append('tag', JSON.stringify(tagArray));
				  				placeAdsForm.append('formFieldTag', JSON.stringify(formTagArray));
				  				$('#btnPlaceAds').attr("disabled", true);
								$.ajax({

								      type: "POST",
								      url: 'addNewAds',
								      contentType: false,
								      processData: false,
								      enctype: 'multipart/form-data',
								      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
								      data: placeAdsForm,
								      dataType: "html",
								      success: function(data) {

								       	if(data.success = "success"){
								       		$('body').removeClass('loading');
								       		$('#page-content-wrapper').find("input, select, button, textarea").removeAttr('readonly');
								       		$('#btnPlaceAds').attr("disabled", false);
								       		//console.log(JSON.parse(data));
								       		//console.log(data);console.log(data.redirectLink);console.log(data["redirect_link"]);return;
								       		var return_data = JSON.parse(data);
								          //window.location.href = "/getActiveAdsPage?btnMethod=publish&success=place";
								          window.location.href = return_data.redirectLink;
								        }
								        else{
								        	$('body').removeClass('loading');
								        	$('#page-content-wrapper').find("input, select, button, textarea").removeAttr('readonly');
								        	$('#btnPlaceAds').attr("disabled", false);
								        }
								          
								      },
								      error: function(xhr) {
								      	$('body').removeClass('loading');
								      	$('#page-content-wrapper').find("input, select, button, textarea").removeAttr('readonly');
								      	 /*$('#btnPlaceAds').attr("disabled", false);
								          alert("{{trans('message-box.somethingwrong')}}");*/
								          console.log('Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText);
								      }
							    });
							}

						}
					}
					else{
						$('#btnPlaceAds').attr("disabled", false);
					}
				}

	        });

	        $('#btnEditAds').on('click', function(e){

	        	e.preventDefault();

	        	$('#btnEditAds').attr("disabled", true);

	        	if($('#dropDownCategory')[0].selectedIndex == 0 || $('#dropDownSubCategory')[0].selectedIndex == 0){
	        		e.preventDefault();
	        		$('#btnEditAds').attr("disabled", false);
	        		alert("{{trans('message-box.selectcategoryandsubcategory')}}");
	        	}
	        	else if($("#imageCounter").val() == 0){
	        		e.preventDefault();
	        		$('#btnEditAds').attr("disabled", false);
	        		alert("{{trans('message-box.pleasechooseatleast')}}");
	        	}
	        	else{
		        	if($("#placeAdsForm")[0].checkValidity()) {

		        		var inputs = $(".flexibleFormValue");
			        		var count = 0;

				        	for(var i = 0; i < inputs.length; i++){				  


							    if($(inputs[i]).val() == "none"){
							    	count++;
							    }
							}

							if(count > 0){


								alert("{{trans('message-box.pleasefillinalldetails')}}");

							}
							else{

					        	var adsId = $('#invisibleAdsId').attr('value');

					        	jsonObj = [];
					        	imgObj = [];

					        	var inputs = $(".flexibleFormValue");
					        	var images = $(".hiddenUploadImages");

					        	for(var i = 0; i < inputs.length; i++){				  

								    item = { value: $(inputs[i]).val(), id: $(inputs[i]).attr('data-id') };

							        jsonObj.push(item);
								}

								for(var i = 0; i < images.length; i++){				  

								    item = { value: $(images[i]).val() };

							        imgObj.push(item);
								}
									
								var form = $('#placeAdsForm')[0];

				  				var placeAdsForm = new FormData(form);

				  				var formFieldData = JSON.stringify(jsonObj);
				  				var imageData = JSON.stringify(imgObj); 

				  				placeAdsForm.append('formFieldData', formFieldData);
				  				placeAdsForm.append('formImageData', imageData);
				  				placeAdsForm.append('placeType', "editAds");
				  				placeAdsForm.append('adsId', adsId);
				  				placeAdsForm.append('tag', JSON.stringify(tagArray));
					  			placeAdsForm.append('formFieldTag', JSON.stringify(formTagArray));
				  				
								$.ajax({

								      type: "POST",
								      url: 'addNewAds',
								      contentType: false,
								      processData: false,
								      enctype: 'multipart/form-data',
								      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
								      data: placeAdsForm,
								      dataType: "html",
								      success: function(data) {

								       	if(data.success = "success"){
								       		$('#btnEditAds').attr("disabled", false);
								          window.location.href = "/getActiveAdsPage?btnMethod=publish&success=edit";
								        }
								        else{
								        	$('#btnEditAds').attr("disabled", false);
								        }
								          
								      },
								      error: function() {
								      		$('#btnEditAds').attr("disabled", false);
								          alert("{{trans('message-box.somethingwrong')}}");
								      }
							    });
							}

					}
					else{

						$('#btnEditAds').attr("disabled", false);
					}
				}

	        });

	        //Ajax Drop Down Category
		    $("#dropDownCategory").change(function(){

		    	$('body').addClass('loading');
		    	

		    	var categoryId = $('#dropDownCategory :selected').attr('value');

		    	var adsId;

		    	if({{ count($ads) }} < 1){
		    		adsId = "";
		    	}
		    	else{
		    		adsId = $('#invisibleAdsId').attr('value');
		    	}

		    	$('#addonsDiv').css('display','none');
				$('#packageDiv').css('display','none');
				resetPackageData();
		        $.ajax({
		            type: "GET",
		            url: 'getSubCategory',
		            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		            data: ({ "categoryId": categoryId, "adsId": adsId }),
		            success: function(data) {

		            	if(data != null){

		            		$('#dropDownSubCategory').children().remove().end();

		            		$('#dropDownSubCategory').append('<option value="none">{{trans("instruction-terms.pleaseselectyouroption")}}</option>');

		            		for(var i = 0; i < data.subCategory.length; i++){

		            			$('#dropDownSubCategory').append('<option value="'+ data.subCategory[i].id +'">' +  data.subCategory[i].text + '</option>');
		            		}

		            		$('#formField').empty();

		            		$('body').removeClass('loading');
		            		$('#page-content-wrapper').find("input, select, button, textarea").removeAttr('readonly');
		            	}

		            },
		            error: function() {
		                alert("{{trans('message-box.somethingwrong')}}");
		            }
		        });
		    });


		    //Ajax Drop Down Sub Category
		    $("#dropDownSubCategory").change(function(){

		    	$('body').addClass('loading');

		    	var subCategoryId = $('#dropDownSubCategory :selected').attr('value');
		    	$('#subCatHidden').val(subCategoryId);

		    	var adsId;

		    	if (subCategoryId != "none"){

		    		$('#packageDiv').css('display','block');

			    	if({{ count($ads) }} < 1){
			    		adsId = "";
			    	}
			    	else{
			    		adsId = $('#invisibleAdsId').attr('value');
			    	}

			        $.ajax({
			            type: "GET",
			            url: 'getAllSubCategoryData',
			            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			            data: ({ "subCategoryId": subCategoryId, "adsId": adsId }),
			            success: function(data) {

			            	if(data != null){

			            		$('#formField').html(data.formView);
			            	}

			            },
			            error: function() {
			                alert("{{trans('message-box.somethingwrong')}}");
			            }
			        });
			        resetPackageData();

					

			        $.ajax({
			            type: "GET",
			            url: 'getPricingBySubCategory',
			            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			            data: ({ "subCategoryId": subCategoryId,"offer_option": "place_ads"}),
			            success: function(data) {
										console.log("pricing data");
										console.log(data);
			            	if(data.success == "success"){
								var count = 0;
								jQuery.each(data.pricing, function(index, item) {
									package_pricing_data[item.type] = item;
									count++;
									var package_data = JSON.parse(item.data);
									var details_code = "";
									if(package_data["listed"] != "0"){
										details_code += '<h6 class="content-text"><i class="fa fa-check" aria-hidden="true"></i> Listed '+package_data["listed"]+' days.</h6>';
									}
									if(package_data["auto-bump"] != "0"){
										var auto_bump_day = package_data["auto-bump"].split(",");
										jQuery.each(auto_bump_day, function(index1, item1) {
											details_code += '<h6 class="content-text"><i class="fa fa-check" aria-hidden="true"></i> Auto Bump at '+item1;
											if(item1 == "1"){
												details_code += 'st day.</h6>';
											}
											else if(item1 == "2"){
												details_code += 'nd day.</h6>';
											}else if(item1 == "3"){
												details_code += 'rd day.</h6>';
											}else{
												details_code += 'th day.</h6>';
											}
										});
									}
									if(package_data["spotlight"] != "0"){
										details_code += '<h6 class="content-text"><i class="fa fa-check" aria-hidden="true"></i> Spotlight the ad for '+package_data["spotlight"]*24+' hours.</h6>';
									}
									var price = item.price;
									if(item.price == 0)price = "Free";
									if(item.type == "basic"){

										$("#basicPrice").html(price);
										$("#basicListedDay").html(package_data["listed"]);
										$("#basicDetailsDiv").html(details_code);
									}else if(item.type == "auto-bump"){
										$("#autoPrice").html(price);
										$("#autoListedDay").html(package_data["listed"]);
										$("#autoDetailsDiv").html(details_code);
									}else if(item.type == "spotlight"){
										$("#spotlightPrice").html(price);
										$("#spotlightListedDay").html(package_data["listed"]);
										$("#spotlightDetailsDiv").html(details_code);
									}else{
										if (!pricing_add_ons_data.hasOwnProperty(item.type)) {
											console.log("in!!!");
											pricing_add_ons_data[item.type] = {};
										}
										console.log(item.id);
										pricing_add_ons_data[item.type][item.id] = item;
										pricing_add_ons_ary[item.id] = item;
									}
									if(Object.keys(data.pricing).length == count){
										adjust_package_box_height();
									}

								});
								// get add on data //
								var package_add_ons_data = data.pricing_add_ons;
								console.log("package_add_ons_data !!!! ");
								console.log(package_add_ons_data);
								
			            	}
			            	else{

			            		alert('No price data for selected subcategory.');
			            		$("#basicPrice").html('0');
		          				$("#autoPrice").html('0');
		          				$("#spotlightPrice").html('0');
			            	}

			            	$('body').removeClass('loading');
			                $('#page-content-wrapper').find("input, select, button, textarea").removeAttr('readonly');

			            },
			            error: function() {
			                alert("{{trans('message-box.somethingwrong')}}");
			            }
			        });
			    }
			    else{
			    	$('#addonsDiv').css('display','none');
		    		$('#packageDiv').css('display','none');
		    		$('#formField').empty();
		    		$('body').removeClass('loading');
			    }
		    });
		    //End Ajax Drop Down Sub Category
		});

function addFormFieldTag(){

	formTagArray = [];

	$('.flexibleFormValue').each(function(i, obj) {
		if(!formTagArray.includes($(obj).val()) && $(obj).val() != 'none') {
		    formTagArray.push($(obj).val());
		}
	});

	refreshTag();
}

function addTag(){

	if(!tagArray.includes($('#addTagTxt').val()) && !formTagArray.includes($('#addTagTxt').val())) {
	    tagArray.push($('#addTagTxt').val());
		refreshTag();
	}

	$('#addTagTxt').val("");
}

function deleteTag(index){
	tagArray.splice(index,1);

	refreshTag();
}

function refreshTag(){
	$('#searchtagarea').children().remove();

	for(var i = 0; i < formTagArray.length; i++){
		$('#searchtagarea').append('<div style="padding: 10px 2px; display: inline-block;"><span style="cursor: pointer; font-size: 10pt; color: red; background-color: #002450; color: white; padding: 5px; margin-bottom: 5px;">' + formTagArray[i] + '</span></div>');
	}

	for(var i = 0; i < tagArray.length; i++){
		$('#searchtagarea').append('<div style="padding: 10px 2px; display: inline-block;"><span style="cursor: pointer; font-size: 10pt; color: red; background-color: #002450; color: white; padding: 5px; margin-bottom: 5px;" onclick="deleteTag(' + i + ');">' + tagArray[i] + ' <i id="deleteSign" class="fa fa-times" aria-hidden="true" style="font-size: 10pt; color: white;"></i></span></div>');
	}
}

function resetPackageData(){
	pricing_add_ons_data = {};
	pricing_add_ons_ary = {};
    $("#basicPrice").html("");
	$("#basicListedDay").html("");
	$("#basicDetailsDiv").html("");
    $("#spotlightPrice").html("");
	$("#spotlightListedDay").html("");
	$("#spotlightDetailsDiv").html("");
	$("#autoPrice").html("");
	$("#autoListedDay").html("");
	$("#autoDetailsDiv").html("");
	$("#add_ons_option").html("");
	$('#autoAdsBtn').html('{{trans("buttons.select")}}');
	$('#spotlightAdsBtn').html('{{trans("buttons.select")}}');
	$('#basicAdsBtn').html('{{trans("buttons.select")}}');
	$("#total_price_row").hide();
	$("#total_price").html("");
	$("#adsType").val("none");
	$("#selectedPackageId").val("none");
	$("#addOns").val("none");
}

function addNewImages(fileUploader){
	var $fileUpload = $("#uploadPhotoTxt");

	if (fileUploader.files) {
		$('body').addClass('loading');
		var count = $("#imageCounter").val();
        var filesAmount = fileUploader.files.length;

        for (i = 0; i < filesAmount; i++) {

        	if(parseInt(i) + $(".image-editing-box").length >9){
        		break;
        	}

            var reader = new FileReader();

            reader.onload = function(e) {

            	loadImage.parseMetaData(event.target.result, function(data) {
				    //default image orientation
				    var orientation = 0;
				    //if exif data available, update orientation
				    if (data.exif) {
				        orientation = data.exif.get('Orientation');
				    }
				    var loadingImage = loadImage(
				        event.target.result,
				        function(canvas) {
				            //here's the base64 data result
				            var base64data = canvas.toDataURL('image/jpeg');

				            $('#imagePreviewerBox').append('<div id="' + $("#imageCounter").val() + '" class="col-lg-2 col-md-2 col-xs-6 image-editing-box" data-src="' + base64data + '" style="background-image: url(' + base64data + '); background-size: cover; height: 150px; border: 5px solid white; background-position: 50% 50%;"><input id="image' + $("#imageCounter").val() + '" name="hiddenImageBase64[]" class="hiddenUploadImages" type="hidden" value="' + base64data + '"/><span style="cursor: pointer; font-size: 10pt; color: red; background-color: #002450; color: white; position: absolute; bottom: 0; left: 0; width: 80%;" onclick="primaryImage(' + $("#imageCounter").val() + ');">{{trans("instruction-terms.setasprimary")}}</span><span style="cursor: pointer; font-size: 10pt; color: red; background-color: red; color: white; position: absolute; bottom: 0; right: 0; width: 20%;" onclick="deleteImage(' + $("#imageCounter").val() + ');"><i id="deleteSign" class="fa fa-times" aria-hidden="true" style="font-size: 10pt; color: white;"></i></span><div class="primary-indicator"></div></div>');

			            	if($("#imageCounter").val() == 0){
			            		$('#primaryImageIdHidden').val(0);
								$('#primaryImageHidden').val(base64data);
								$('.primary-indicator').children().remove();
								$('#0>.primary-indicator').append('<span style="cursor: pointer; font-size: 10pt; color: red; background-color: #002450; color: white; position: absolute; top: 0; left: 0; width: 100%;">{{trans("label-terms.primary")}}</span>');
			            	}

			            	$("#imageCounter").val((parseInt($("#imageCounter").val())+1));
				        }, {
				            //should be set to canvas : true to activate auto fix orientation
				            canvas: true,
				            orientation: true
				        }
				    );
				});
	        }

	        if($("#imageCounter").val() <= 10){
		        reader.readAsDataURL(fileUploader.files[i]);
		    }
        }
        $('body').removeClass('loading');
    }
}

function adjust_package_box_height(){
	console.log("adjust_package_box_height");
	var tallestBox = 0;

	$(".package_details_div").each(function() {
		var divHeight = $(this).height();

		if (divHeight > tallestBox){
			tallestBox = divHeight;
		}
	});
	console.log("tallestBox = "+tallestBox);
	// Apply height & add total vertical padding
	$(".package_details_div").css("height", tallestBox);
}
function clearImages(){
	$('.image-editing-box').remove();
	$("#imageCounter").val(0);
	$('#primaryImageIdHidden').val(-1);
	$('#primaryImageHidden').val('none');
}

function deleteImage(imageId){
	if($('#primaryImageIdHidden').val() == imageId){
		if($('#imageCounter').val() == 1){
			clearImages();
		}
		else{
			alert("{{trans('message-box.unabletodeleteimage')}}");
		}
	}
	else{
		$('#'+imageId).remove();
		$('#imageCounter').val($('#imageCounter').val() - 1);
	}
}

function primaryImage(imageId){
	$('#primaryImageIdHidden').val(imageId);
	$('#primaryImageHidden').val($('#'+imageId+'>.hiddenUploadImages').val());
	$('.primary-indicator').children().remove();
	$('#'+imageId+'>.primary-indicator').append('<span style="cursor: pointer; font-size: 10pt; color: red; background-color: #002450; color: white; position: absolute; top: 0; left: 0; width: 100%;">{{trans("label-terms.primary")}}</span>');
}

function outImage(imageId){
	$('#deleteSign').remove();
}

function checkMake(){
	var selectedValue = $('#makeDdl').find(":selected").text();

	if(selectedValue == 'Others'){
		$("othersMake").css("display", "block");
		$("othersMakeTxt").css("display", "block");
	}
	else{
		$("othersMake").css("display", "none");
		$("othersMakeTxt").css("display", "none");
	}
}

function build_add_ons_option(data){
	console.log("build_add_ons_option");
	console.log(data);
	$("#add_ons_option").html("");
	$('#addOns').val("none");
	jQuery.each(data, function(index, item) {
		var code = "";
		console.log("print");
		console.log(index);
		console.log(item);
		var add_ons_data = JSON.parse(item.data);
	console.log(add_ons_data);
		code += '<div class="row" style="border:1px solid grey;padding:10px;">';
			code += '<div class="col-md-2">';
				code += '<input id="add_on_package_'+item.id+'" class="add_on_checkbox" type="checkbox" onclick="select_add_ons(\''+item.id+'\')">'
			code += '</div>';
			code += '<div class="col-md-8">';
			if(add_ons_data.listed != "0"){
				code += "Add "+add_ons_data.listed+" Days Listing Time.<br>";
			}
			if(add_ons_data["auto-bump"] != "0"){
				var auto_bump_day = add_ons_data["auto-bump"].split(",");
				jQuery.each(auto_bump_day, function(index1, item1) {
					code += 'Auto Bump at '+item1;
					if(item1 == "1"){
						code += 'st day.</h6>';
					}
					else if(item1 == "2"){
						code += 'nd day.</h6>';
					}else if(item1 == "3"){
						code += 'rd day.</h6>';
					}else{
						code += 'th day.</h6>';
					}
				});
				code += "<br>";
				//code += "Auto-bump "+add_ons_data["auto-bump"]+" Day.<br>";
			}
			if(add_ons_data.spotlight != "0"){
				code += 'Spotlight the ad for '+add_ons_data["spotlight"]*24+' hours.</br>';
				//code += "Spotlight "+add_ons_data.spotlight+" Days<br>";
			}
			code += '</div>';
			code += '<div class="col-md-2">';
				code += "€ " + item.price;
			code += '</div>';

		code += '</div>';
		$("#add_ons_option").append(code);
	});
}

function setAdsType(option){
	$('#adsType').val(option);
	$("#selectedPackageId").val(package_pricing_data[option].id)
	$('#addonsDiv').css('display','none');
	console.log("option = "+option);
	console.log(package_pricing_data);
	

	if(option == 'basic'){
		$('#autoAdsBtn').html('{{trans("buttons.select")}}');
		$('#spotlightAdsBtn').html('{{trans("buttons.select")}}');
		$('#basicAdsBtn').html('{{trans("buttons.selected")}}');
	}
	else if(option == 'auto-bump'){
		$('#autoAdsBtn').html('{{trans("buttons.selected")}}');
		$('#spotlightAdsBtn').html('{{trans("buttons.select")}}');
		$('#basicAdsBtn').html('{{trans("buttons.select")}}');
	}
	else{
		$('#autoAdsBtn').html('{{trans("buttons.select")}}');
		$('#spotlightAdsBtn').html('{{trans("buttons.selected")}}');
		$('#basicAdsBtn').html('{{trans("buttons.select")}}');
	}
	console.log("build_add_on");
	console.log(pricing_add_ons_data);
	//if (pricing_add_ons_data.hasOwnProperty(option)) {

	if(option == "auto-bump"){
		option = "ab";
	}

	var ary = $.extend({}, pricing_add_ons_data[option+"-bump-addOn"], pricing_add_ons_data[option+"-spotlight-addOn"]);
	$("#add_ons_option").html("");
	if(Object.keys(ary).length > 0){
		$('#addonsDiv').css('display','block');
		build_add_ons_option(ary);
	}
	update_price();
}
function update_price(){
	$("#total_price_row").show();

	var selected_package_type = $('#adsType').val();
	var selected_add_ons_id = $('#addOns').val();
	
	var price = 0;
	if(selected_package_type != "none"){
		price = parseInt(package_pricing_data[selected_package_type].price);
	}

	if(selected_add_ons_id != "none"){
		price += parseInt(pricing_add_ons_ary[selected_add_ons_id].price);
	}
	console.log(price);
	$("#total_price").html("€ "+price);
}

function select_add_ons(id){
	console.log("select_add_ons");
	$('#addOns').val(id);

	var checkedState =   $("#add_on_package_"+id).prop("checked");
	if(checkedState == false){
		$('#addOns').val("none");
	}else{
		$('#addOns').val(id);
	}
	console.log(checkedState);
	$('.add_on_checkbox').prop('checked', false);

	$("#add_on_package_"+id).prop("checked",checkedState);
	update_price();
}


function setAddOns(option){
	console.log("setAddOns = "+setAddOns);
	$('#addOns').val(option);
	update_price();
}

function dropDownParentOnChange(id){

	$('body').addClass('loading');
	var formOptionId = $('.flexibleFormValue[data-id="'+  id +'"]').find(':selected').attr('data-id');

	addFormFieldTag();

	$.ajax({
        type: "GET",
        url: 'getParentValue',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: ({ "formOptionId": formOptionId }),
        success: function(data) {

        	if(data.success == 'success'){

        		$('.flexibleFormValue[data-parentId="'+  id +'"]').children().remove().end();

        		$('.flexibleFormValue[data-parentId="'+  id +'"]').append('<option value="none" selected="selected" >{{trans("instruction-terms.pleaseselectyouroption")}}</option>');

        		for(var i = 0; i < data.formFieldOption.length; i++){

               		$('.flexibleFormValue[data-id="'+  data.formFieldOption[i].formFieldId +'"]').append('<option value="'+ data.formFieldOption[i].value +'" data-id="' + data.formFieldOption[i].id + '">' +  data.formFieldOption[i].value + '</option>');
                }
                $('body').removeClass('loading');
                $('#page-content-wrapper').find("input, select, button, textarea").removeAttr('readonly');
        	}

        },
        error: function() {
            alert("{{trans('message-box.somethingwrong')}}");
        }
    });
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
            mapTypeControl: false
        };

        var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);
        var geocoder = new google.maps.Geocoder;

        var marker = new google.maps.Marker({
          position: new google.maps.LatLng($('#geolocationLatitude').val(),$('#geolocationLongitude').val()),
          map: map,
          draggable: true
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

                                $("#callingCode > option").each(function() {
					            	var countryString = this.text.split(" (");

								    if(component['long_name'] == countryString[0]){
								    	$("#callingCode").val(this.value);
								    }
								});
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

                    $("#callingCode > option").each(function() {
		            	var countryString = this.text.split(" (");

					    if(component['long_name'] == countryString[0]){
					    	$("#callingCode").val(this.value);
					    }
					});
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

                                        $("#callingCode > option").each(function() {
							            	var countryString = this.text.split(" (");

										    if(component['long_name'] == countryString[0]){
										    	$("#callingCode").val(this.value);
										    }
										});
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
                });
            } else {
                x.innerHTML = "Geolocation is not supported by this browser.";
            }
        });

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

                                    $("#callingCode > option").each(function() {
						            	var countryString = this.text.split(" (");

									    if(component['long_name'] == countryString[0]){
									    	$("#callingCode").val(this.value);
									    }
									});

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
            });
        } else {
            x.innerHTML = "Geolocation is not supported by this browser.";
        }
    }

	</script>
@endsection
