@extends('layouts.app')

@section('content')

<div class="container">
	<div class="col-lg-12 col-md-12 col-xs-12 margin-bottom visible-xs">
		<br/>
		<div id="backBtnDiv" class="back-button-link">❮ {{trans('buttons.back')}}</div>
	</div>
	
	<div class="row">
		<form method="GET" action="{{ url('getInboxPage') }}">
	        <div class="col-lg-12 col-md-12 col-xs-12 tab-button-div">
				<div class="col-lg-6 col-md-6 col-xs-6 tab-button-column">
					<button id="tab1" class="tab-buttons-active" name="btnMethod" value="active" style="text-transform: uppercase;">{{trans('buttons.active')}}</button>
				</div>
				<div class="col-lg-6 col-md-6 col-xs-6 tab-button-column">
					<button id="tab0" class="tab-buttons" name="btnMethod" value="archive" style="text-transform: uppercase;">{{trans('buttons.archived')}}</button>
				</div>
			</div>
		</form>

		<div class="col-lg-12 col-md-12 col-xs-12 form-rows">
			<br/>
                <input type="checkbox" id="selectAllCbx" name="select" value="select-all" onclick="selectAllToggle();"> {{trans('buttons.selectall')}} &nbsp;&nbsp;&nbsp;
                <a id="btnArchive" class="manage-ads-buttons-active">{{trans('buttons.archive')}}</a>
                <a id="btnDelete" class="delete-buttons-active" style="padding: 8px 10px;">{{trans('buttons.delete')}}</a>
                <br/><br/>
                <input type="text" id="txtInboxSearch" class="form-control" placeholder="{{trans('buttons.search')}}" />
		</div>

		<div class="col-lg-12 col-md-12 col-xs-12 form-rows">
			<div id="displayInboxSection">

				@if(count($inbox) > 0)
					@foreach($inbox as $inbox_data)
					<?php 
						$inboxUnreadCount = "";
						$unreadClass = "";
						if($inbox_data->getUnreadMsgCount()){
							$inboxUnreadCount = $inbox_data->getUnreadMsgCount();
							$unreadClass = "unreadRow"; 

						}
					?>
						<form method="GET" action="{{ url('getReplyPage') }}">
							<div class="col-lg-12 col-md-12 col-xs-12 form-rows bottom-border margin-bottom {{$unreadClass}}" style="padding: 15px 0px 0px 0px;">
								<div class="col-lg-3 col-md-3 col-xs-4" style="padding: 0px 0px 10px 0px;">
									<table>
										<tr>
											<td style=""><input type="checkbox" name="select" value="{{ $inbox_data->id }}" style="margin: 10px;"></td>
											<td style="width: 90%;"><div class="inboxImage" style="border:1px solid #ececec;background-size:contain;background-image: url({{ asset($inbox_data->getAds->adsImage) }});" ></div></td>
										</tr>
									</table>
								</div>
								<div class="col-lg-9 col-md-9 col-xs-8">
									<div class="form-group">
										<?php
											if(isset(Auth::user()->id) && isset($inbox_data->getLastMsg()->senderID) && $inbox_data->getLastMsg()->senderID == Auth::user()->id){
												$senderDescription = "You : ";
											}else{
												$senderDescription = $inbox_data->getReceiver->name." : ";
												
											}
											
										
										?>

										<h5 class="inbox-sender-name-title">{{ $inbox_data->getAds->adsName }} <span class="badge" style="color:white;background-color: red;">{{$inboxUnreadCount}}</span></h5>
										<div class="inbox-recipient-name">{{ $inbox_data->getReceiver->name }}</div>
										
										<h6 class="inbox-type-location-title" style="font-weight: bold;">
											{{ $inbox_data->getAds->adsRegion }}, {{ $inbox_data->getAds->adsCountry }}
										</h6>
										<br/>
										
										<h6 class="inbox-type-location-title">{{ $senderDescription.$inbox_data->getLastMsg()->message }}</h6>
													<br/>
										
										<button type="submit" class="manage-ads-buttons-active uppercase-text margin-bottom btnChatsReply"  value="{{ $inbox_data->id }}" name="inboxId">{{trans('buttons.reply')}}</button>
									</div>
								</div>
								<br/><br/>			
							</div>
						</form>	
					@endforeach
				@elseif($checkMethod == 'archive')
					<div class="col-lg-12 col-md-12 col-xs-12 form-rows bottom-border"><h6 class="admin-portal-title-blue">{{trans('empty-message.noarchivedinbox')}}</h6></div>
				@elseif($checkMethod == 'active' || $checkMethod == '')
					<div class="col-lg-12 col-md-12 col-xs-12 form-rows bottom-border"><h6 class="admin-portal-title-blue">{{trans('empty-message.noactiveinbox')}}</h6></div>
				@endif
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div id="deleteArchiveSuccessModal" class="modal fade" role="dialog" style="margin-top: 100px;">
    <div class="modal-dialog">
        <div class="modal-content register-success-modal-box">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body register-success-modal">
                <i class="fa fa-check" aria-hidden="true"></i><br/>
                <h3 id="modalTitle"></h3>
                <br/>
                <h6 id="modalDescription"></h6>
            </div>
        </div>
    </div>
</div>

<script>

	$(document).ready(function() {

		if('{{ $checkMethod }}' == 'archive'){
			$("#tab0").removeClass("tab-buttons-active");
			$("#tab1").removeClass("tab-buttons-active");

			$("#tab0").addClass("tab-buttons-active");
			$("#tab1").addClass("tab-buttons");

			$("#btnArchive").css("display","none");
		}
		else{
			$("#tab0").removeClass("tab-buttons-active");
			$("#tab1").removeClass("tab-buttons-active");

			$("#tab0").addClass("tab-buttons");
			$("#tab1").addClass("tab-buttons-active");
			$("#btnArchive").css("display","inline-block");
		}

		$('#txtInboxSearch').keydown(function (e){
	        if(e.keyCode == 13){
	        	var method = "active";

	        	if('{{ $checkMethod }}' == 'archive'){
	        		method = "archive";
	        	}
	        	else{

	        		method = "active";
	        	}
	        	window.location.href = '/getInboxPageByName/'+ $(this).val() + '/' + method;
			}
	     });


        $("#selectAllCbx").click(function(){
		    $('input:checkbox').not(this).prop('checked', this.checked);
		});


		$('#btnDelete').click(function(){

			var len = $('table tr input:checked').length;

			if(len == 0){
				alert("{{trans('message-box.noinboxisselected')}}");
			}
			else{

				if (confirm("{{trans('message-box.areyousureyouwanttodelete')}}")) {
					var allId = [];

					$('table tr input:checked').each(function() {

						allId.push($(this).attr('value'));

					});

					$.ajax({
		                type: "POST",
		                url: 'deleteInbox',
		                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		                data: ({ "allId": allId }),
		                dataType: "html",
		                success: function(data) {

		                    if(data.success = 'success'){

		                    	alert("{{trans('message-box.deletedsuccessfully')}}");

		                    	$("#displayInboxSection").load(" #displayInboxSection");
		                    }
		                    
		                },
		                error: function() {
		                    alert("{{trans('message-box.somethingwrong')}}");
		                }
		            });
		        }
		    }
			  
		});

		$('#btnArchive').click(function(){

			var len = $('table tr input:checked').length;

			if(len == 0){
				alert("{{trans('message-box.noinboxisselected')}}");
			}
			else{

				var allId = [];
				$('table tr input:checked').each(function() {

					allId.push($(this).attr('value'));

				});

				$("body").addClass("loading");
				$.ajax({
	                type: "POST",
	                url: 'archiveInbox',
	                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	                data: ({ "allId": allId }),
	                dataType: "html",
	                success: function(data) {
	                	$("body").removeClass("loading");
	                    if(data.success = 'success'){

	                    	alert("{{trans('message-box.inboxesarchivedsuccessfully')}}");

	                    	$("#displayInboxSection").load(" #displayInboxSection");
	                    }
	                    
	                },
	                error: function() {
	                	$("body").removeClass("loading");
	                    alert("{{trans('message-box.somethingwrong')}}");
	                }
	            });
			}  
		});
    });

</script>
	
@endsection
