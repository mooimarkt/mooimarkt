@extends('layouts.app')

@section('content')

<div class="container">
	<div class="row">
        <div id="filter" class="col-lg-12 col-md-12 col-xs-12 filter-div margin-bottom-20">
	      	<div class="col-lg-6 col-md-6 col-xs-12 form-rows">		
	      		<div class="form-group">				    
    			    <div class="col-lg-4 col-md-4 col-xs-5 no-padding-column">	
    			    	<label for="country"  class="black-label uppercase-text">{{trans('place-ads.Location')}}</label>
    			    	<select id="country" name="txtAdsLocation" class="form-control">
    						<option value="Malaysia" selected>Malaysia</option>
    						<option value="China">China</option>
    					</select>
    			    </div>
    			    <div class="col-lg-4 col-md-4 col-xs-5 no-padding-column">	
    			    	<label for="region"></label>
    			    	<select id="region" name="dropDownAddress1" class="form-control" style="margin-top: 6px;">
    						<option value="Pulau Pinang" selected>Pulau Pinang</option>
    						<option value="Wilayah Persekutuan Kuala Lumpur">Wilayah Persekutuan Kuala Lumpur</option>
    					</select>
    			    </div>
    			    <div class="col-lg-4 col-md-4 col-xs-2 no-padding-column">  
                        <label for="nearme"></label>
                        <div id="getGeolocation" class="form-control uppercase-text" style="margin-top: 6px; text-align: center;"><i class="fa fa-map-marker" style="font-size: 15pt;" aria-hidden="true"></i></div>
                    </div>
    		  	</div>
			</div>
			<div class="col-lg-6 col-md-6 col-xs-12 form-rows">		
	      		<div class="form-group">				    
				    <div class="col-lg-12 col-md-12 col-xs-12 no-padding-column">	
				    	<label for="dropMake" class="black-label uppercase-text">{{trans('place-ads.Make')}}</label>
				    	<select id="dropMake" class="form-control">
							<option value="Kawasaki" selected>KAWASAKI</option>
						</select>
				    </div>
			  	</div>
			</div>
			<div class="col-lg-6 col-md-6 col-xs-12 form-rows">		
	      		<div class="form-group">				    
				    <div class="col-lg-12 col-md-12 col-xs-12 no-padding-column">	
				    	<label for="dropModel" class="black-label uppercase-text">{{trans('place-ads.Model')}}</label>
				    	<select id="dropModel" class="form-control">
							<option value="KX 250 F" selected>KX 250 F</option>
						</select>
				    </div>
			  	</div>
			</div>
			<div class="col-lg-6 col-md-6 col-xs-12 form-rows">		
	      		<div class="form-group">				    
				    <div class="col-lg-6 col-md-6 col-xs-6 no-padding-column">	
				    	<label for="dropPriceMin" class="black-label uppercase-text">{{trans('place-ads.Price')}}</label>
				    	<select id="dropPriceMin" class="form-control">
							<option value="MIN" selected>MIN</option>
						</select>
				    </div>
				    <div class="col-lg-6 col-md-6 col-xs-6 no-padding-column">	
				    	<label for="dropPriceMax"></label>
				    	<select id="dropPriceMax" class="form-control" style="margin-top: 5px;">
							<option value="MAX" selected>MAX</option>
						</select>
				    </div>
			  	</div>
			</div>
			<div class="col-lg-6 col-md-6 col-xs-12 form-rows">		
	      		<div class="form-group">				    
				    <div class="col-lg-6 col-md-6 col-xs-6 no-padding-column">	
				    	<label for="dropYearFrom" class="black-label uppercase-text">{{trans('place-ads.Year')}}</label>
				    	<select id="dropYearFrom" class="form-control">
							<option value="2017" selected>2017</option>
						</select>
				    </div>
				    <div class="col-lg-6 col-md-6 col-xs-6 no-padding-column">	
				    	<label for="dropYearTo"></label>
				    	<select id="dropYearTo" class="form-control" style="margin-top: 5px;">
							<option value="2017" selected>2017</option>
						</select>
				    </div>
			  	</div>
			</div>
			<div class="col-lg-6 col-md-6 col-xs-12 form-rows">		
	      		<div class="form-group">				    
				    <div class="col-lg-6 col-md-6 col-xs-6 no-padding-column">	
				    	<label for="dropHoursMin" class="black-label uppercase-text">{{trans('specs.Hours Used')}}</label>
				    	<select id="dropHoursMin" class="form-control">
							<option value="MIN" selected>MIN</option>
						</select>
				    </div>
				    <div class="col-lg-6 col-md-6 col-xs-6 no-padding-column">	
				    	<label for="dropHoursMax"></label>
				    	<select id="dropHoursMax" class="form-control" style="margin-top: 5px;">
							<option value="MAX" selected>MAX</option>
						</select>
				    </div>
			  	</div>
			</div>
			<div class="col-lg-6 col-md-6 col-xs-12 form-rows">		
	      		<div class="form-group">				    
				    <div class="col-lg-12 col-md-12 col-xs-12 no-padding-column">	
				    	<label for="dropCC" class="black-label uppercase-text">{{trans('specs.CC')}}</label>
				    	<select id="dropCC" class="form-control">
							<option value="Any" selected>Any</option>
						</select>
				    </div>
			  	</div>
			</div>
			<div class="col-lg-6 col-md-6 col-xs-12 form-rows">		
	      		<div class="form-group">				    
				    <div class="col-lg-12 col-md-12 col-xs-12 no-padding-column">	
				    	<label for="dropStroke" class="black-label uppercase-text">{{trans('specs.Stroke')}}</label>
				    	<select id="dropStroke" class="form-control">
							<option value="Any" selected>Any</option>
						</select>
				    </div>
			  	</div>
			</div>
			<div class="col-lg-6 col-md-6 col-xs-6 margin-top-20">
	             <button type="submit" class="filter-browse-buttons uppercase-text margin-bottom">{{trans('user-feedback.CANCEL')}}</button>
	        </div>
	        <div class="col-lg-6 col-md-6 col-xs-6 margin-top-20">
	             <button type="submit" class="filter-browse-buttons-active uppercase-text margin-bottom">{{trans('user-profile.SAVE')}}</button>
	        </div>
	        <div class="col-lg-12 col-md-12 col-xs-12">
	             <hr/>
	        </div>
	    </div>

		<script>
			$( document ).ready(function() {

		        //Ajax
		        $("#country").change(function(){

		            var countryName = $('#country :selected').attr('value');

		            $.ajax({
		                type: "GET",
		                url: 'changeState',
		                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		                data: ({ "countryName": countryName }),
		                dataType: "html",
		                success: function(data) {

		                    if(data != null){

		                        $('#region').children().remove().end();

		                        var dataArray = JSON.parse(data);

		                        for(var i = 0; i < dataArray.length; i++){

		                            $('#region').append('<option value="'+ dataArray[i] +'">' +  dataArray[i] + '</option>');
		                        }
		                    }
		                    
		                },
		                error: function() {
		                    alert("{{trans('message-box.somethingwrong')}}");
		                }
		            });
		        });

		        var selectedCountry = $('#country').find("option:first-child").val();
		        $("#country").val(selectedCountry);


		        $('#getGeolocation').click(function(){

		            $.ajax({
		                type: "GET",
		                url: 'getGeolocation',
		                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		                success: function(data) {

		                    if(data.success == "success"){

		                        $('#region').children().remove().end();

		                        for(var i = 0; i < data.states.length; i++){

		                            $('#region').append('<option value="'+ data.states[i] +'">' +  data.states[i] + '</option>');
		                        }

		                        $('#country option').removeAttr("selected");
                        		$('#region option').removeAttr("selected");
		                        $('#country option[value="'+ data.selectedCountry +'"]').attr('selected','selected');
		                        $('#region option[value="'+ data.selectedState +'"]').attr('selected','selected');
		                    }
		                    else{
		                        alert("{{trans('message-box.yourlocationisunabletolocate')}}");
		                    }
		                    
		                },
		                error: function() {
		                    alert("{{trans('message-box.somethingwrong')}}");
		                }
		            });
		        });

			});

			function switchViewMode(index){

				if(index == 0){
					$("#tab0").addClass("display-mode-icon-button-active");
					$("#tab1").removeClass("display-mode-icon-button-active");
					$("#tab1").addClass("display-mode-icon-button");
					$("#tab0").removeClass("display-mode-icon-button");

					$(".browse-section-div").removeClass("col-lg-12 col-md-12 col-xs-12");
					$(".browse-section-div").addClass("col-lg-3 col-md-3 col-xs-6");					
				}else{
					$("#tab1").addClass("display-mode-icon-button-active");
					$("#tab0").removeClass("display-mode-icon-button-active");
					$("#tab0").addClass("display-mode-icon-button");
					$("#tab1").removeClass("display-mode-icon-button");

					$(".browse-section-div").removeClass("col-lg-3 col-md-3 col-xs-6");
					$(".browse-section-div").addClass("col-lg-12 col-md-12 col-xs-12");
				}
			}
		</script>
	</div>
</div>
	
@endsection
