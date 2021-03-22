@extends('layouts.app')

@section('content')

<div class="container">
	<div class="col-lg-12 col-md-12 col-xs-12 margin-bottom visible-xs">
		<br/>
		<div id="backBtnDiv" class="back-button-link">❮ {{trans('buttons.back')}}</div>
	</div>
		
	<div class="row">
		<div class="col-lg-12 col-md-12 col-xs-12 form-rows margin-bottom">
			<br/>
			@foreach($ads as $ad)
			<div class="col-lg-3 col-md-3 col-xs-6 active-ads-image-div">
				<img src="{{ $ad->adsImage }}" />
			</div>
			<div class="col-lg-9 col-md-9 col-xs-6">
				<div class="col-lg-12 col-md-12 col-xs-12" style="padding: 0;">
					<div class="form-group">
						<h6 class="inbox-sender-name-title" id="userId" data-target-id="{{ $ad->id }}" onclick="window.location.href='{{url('getAdsDetails/'.$ad->adsId)}}'">{{ $ad->adsName }}</h6>
						<!--<h6 class="inbox-type-location-title" style="font-weight: bold;" id="userId" data-target-id="{{ $ad->id }}" >{{ $ad->name }}</h6>-->
						<br/>
						<h6 class="inbox-type-location-title" id="adsId" data-ads-id="{{$ad->adsId}}" >{{ $ad->adsRegion }}, {{ $ad->adsCountry }}</h6>
						<br/>
						<h6 class="inbox-type-location-title">{{ $ad->adsPriceType }} {{ number_format($ad->adsPrice,2,".",",") }}</h6>
					</div>
				</div>				
			</div>
			@endforeach

			<div class="col-lg-12 col-md-12 col-xs-12 chat-window-div">
				<div id="chat-window-div">
				@foreach($chats as $chat)
					@if($chat->senderID == Auth::user()->id)
					<div class="speech-time-right-div">
						<p class="speech-time-right convertToLocalTime" data-ts="{{$chat->created_at->timestamp}}"></p>
						<hgroup class="speech-bubble-right">
							<p>{{ $chat->message }}</p>					
						</hgroup>
					</div>
					@else
					<div class="speech-time-left-div">
						<p class="speech-time-left convertToLocalTime" data-ts="{{$chat->created_at->timestamp}}"></p>
						<hgroup class="speech-bubble-left">
							<p>{{ $chat->message }}</p>					
						</hgroup>
					</div>
					@endif
				@endforeach
				</div>
			</div>
		</div>

		<div class="col-lg-12 col-md-12 col-xs-12 inbox-typing-div">
				<button class="inbox-send-button" id="inbox-send-button" data-inbox-id="{{ $inboxId }}" style="float: right;"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
				<div style="overflow: hidden; padding-right: .5em;">
					<input type="text" class="form-control inbox-textboxes" id="txtSendTextbox" placeholder="{{trans('instruction-terms.typehere')}}" />
				</div>        
        </div>
	</div>
</div>


<script>
	$(document).ready(function(){
		$(".convertToLocalTime").each(function(i,obj){
			var ts = $(obj).data("ts");
			var dt = moment(parseInt(ts)*1000).format('LLL')
			$(obj).html(dt);
		});

		

		$(".chat-window-div").animate({ scrollTop: 10000 }, 0);
		$('#inbox-send-button').click(function(){

			var targetInboxId = $(this).attr('data-inbox-id');
			var targetUserId = $('#userId').attr('data-target-id');
			var adsId = $('#adsId').attr('data-ads-id');
			var message = $('.inbox-textboxes').val();

			if(message == "" || message.replace(" ","")  == ""){
				alert("Please enter message.");
				return;
			}
          	$('body').addClass('loading');

			$.ajax({
	            type: "POST",
	            url: 'replyMessage',
	            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	            data: ({ "targetInboxId": targetInboxId, "targetUserId": targetUserId, "adsId": adsId, "message": message }),
	            dataType: "html",
	            success: function(data) {
				$('body').removeClass('loading');
					$('.inbox-textboxes').val('');
					$("#chat-window-div").load(" #chat-window-div", function() {
						$(".convertToLocalTime").each(function(i,obj){
							var ts = $(obj).data("ts");
							var dt = moment(parseInt(ts)*1000).format('LLL')
							$(obj).html(dt);
						});
						$(".chat-window-div").animate({ scrollTop: 10000 }, 1000);
					});

				},
				error: function() {
					$('body').removeClass('loading');
					alert("{{trans('message-box.somethingwrong')}}");
				}
	        });
		});

		$('#txtSendTextbox').keydown(function (e){
	        if(e.keyCode == 13){
	        	if($(this).val() == "" || $(this).val().replace(" ","")  == ""){
					alert("Please enter message.");
				}
				else{
		        	var targetInboxId = $('#inbox-send-button').attr('data-inbox-id');
					var targetUserId = $('#userId').attr('data-target-id');
					var adsId = $('#adsId').attr('data-ads-id');
					var message = $('.inbox-textboxes').val();
					$('body').addClass('loading');
					$.ajax({
			            type: "POST",
			            url: 'replyMessage',
			            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			            data: ({ "targetInboxId": targetInboxId, "targetUserId": targetUserId, "adsId": adsId, "message": message }),
			            dataType: "html",
						success: function(data) {
							$('body').removeClass('loading');
							$('.inbox-textboxes').val('');
							$("#chat-window-div").load(" #chat-window-div", function() {
								$(".chat-window-div").animate({ scrollTop: 10000 }, 1000);
							});

						},
						error: function() {
							$('body').removeClass('loading');
							alert("{{trans('message-box.somethingwrong')}}");
						}
			        });
		        }
			}
	     });
	});
</script>
	
@endsection
