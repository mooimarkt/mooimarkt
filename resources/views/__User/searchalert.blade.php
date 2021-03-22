@extends('layouts.app')

@section('content')

<div class="container">
	<div class="col-lg-12 col-md-12 col-xs-12 margin-bottom visible-xs">
		<br/>
		<div id="backBtnDiv" class="back-button-link">❮ {{trans('buttons.back')}}</div>
	</div>
		
	<div class="row" id="searchAlertSection">
		<div class="col-lg-12 col-md-12 col-xs-12 margin-bottom">
			<a class="place-ads-button" href="{{url('getAllAds?filter=1')}}" role="button">{{trans("buttons.createSearchAlert")}}</a>

		</div>
		@if(count($data) > 0)
	        @foreach($data as $criteriaData)
	        	<form method="GET" action="{{ url('getAllAds') }}">
					<div class="col-lg-12 col-md-12 col-xs-12 form-rows bottom-border margin-bottom">
						<br/>
						<div class="col-lg-12 col-md-12 col-xs-12">
							<div class="col-lg-12 col-md-12 col-xs-12" style="padding: 0;">
								<div class="form-group">
									<h6 class="inbox-sender-name-title">{{$criteriaData->searchTitle}}</h6>
									<br/>
									<h6 class="inbox-type-location-title">{{$criteriaData->searchString}}</h6>
								</div>
							</div>				
							<br/><br/><br/><br/>
							<div class="col-lg-2 col-md-2 col-xs-5" style="padding: 0;">
								<select class="form-control margin-bottom alertOptionDropDown" data-id="{{ $criteriaData->id }}" id="alertOption">
									@if($criteriaData->alertActivated == 0)
										<option value="0" selected="selected">No Alert</option>
										<option value="1">Alert Daily</option>
										<option value="2">Alert Weekly</option>
									@elseif($criteriaData->alertActivated == 1)
										<option value="0">No Alert</option>
										<option value="1" selected="selected">Alert Daily</option>
										<option value="2">Alert Weekly</option>
									@elseif($criteriaData->alertActivated == 2)
										<option value="0">No Alert</option>
										<option value="1">Alert Daily</option>
										<option value="2" selected="selected">Alert Weekly</option>
									@endif
								</select>
								<br/>
							</div>
							<div class="col-lg-offset-1 col-md-offset-1 col-xs-offset-1 col-lg-2 col-md-2 col-xs-6" style="padding: 0;">
								<button type="submit" data-id="{{ $criteriaData->id }}" class="btnViewSearchAlert manage-ads-buttons-active uppercase-text margin-bottom" style="width: 48%;">{{trans('buttons.view')}}</button>
								<span data-id="{{ $criteriaData->id }}" class="btnDeleteSearchAlert delete-buttons-active uppercase-text margin-bottom" style="width: 48%; padding: 8px;" onclick="deleteSearch({{ $criteriaData->id }});">{{trans('buttons.delete')}}</span>
							</div>
							<br/><br/><br/>
						</div>
					</div>
					<input type="hidden" name="searchId" value="{{ $criteriaData->id }}">
				</form>
			@endforeach
		@else
		<div class="col-lg-12 col-md-12 col-xs-12 form-rows bottom-border"><h6 class="admin-portal-title-blue">{{trans('empty-message.nosearchalerts')}}</h6></div>
		@endif
	</div>
	{{ $data->links() }}
</div>

<script>
	$(document).ready(function(){

		$('#alertOption').change(function(){

			$.ajax({
	            type: "POST",
	            url: 'updateAlertActivated',
	            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	            data: ({ "searchId": $(this).attr('data-id'), "alertActivated": $(this).val() }),
	            success: function(data) {

	            	if(data.success == "success"){
		            	
	            	}
	            	else{

	            		
	            	}
	                
	            },
	            error: function() {
	                alert("{{trans('message-box.somethingwrong')}}");
	            }
	        });
		});
	});

	function deleteSearch(id){

		if (confirm("{{trans('message-box.areyousureyouwanttodelete')}}")) {

			$.ajax({
	            type: "POST",
	            url: 'deleteSearchAlert',
	            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	            data: ({ "searchId": id}),
	            success: function(data) {

	            	if(data.success == "success"){
		            	alert('Delete Successful');
		            	$("#searchAlertSection").load(" #searchAlertSection");
	            	}
	            	else{

	            		
	            	}
	                
	            },
	            error: function() {
	                alert("{{trans('message-box.somethingwrong')}}");
	            }
	        });
	    }

	}
</script>
	
@endsection
