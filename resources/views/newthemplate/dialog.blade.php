@include("newthemplate.header")

	<section id="dialog" class="dialog">
		<div class="dialog-header">
			<div class="dialog-header-user">
				<div class="container container-dialog-user">
					<a href="/dialog-list" class="arrow-back-dialog"><img src="/newthemplate/img/arrow_back.svg" /></a>
					<p class="info-dialog">
						<a href="{{ route('profile.show', ['profile' => $User->id]) }}">{{$User->name}}</a><br>
						<span>
						{{($User->last_login != null) ? 
							((strtotime("now") - strtotime($User->last_login)) < 300
								? 'Online'
								: 'Last Seen '.\Carbon\Carbon::createFromTimeStamp(strtotime($User->last_login))->diffForHumans())
							: 'Last Seen never'
						}}</span><br>
						{{-- <span>Last Seen 1 min. ago</span><br> --}}
						{{-- <span>18:00 (GMT +3)</span> --}}
					</p>
					<a href="#" class="menu-dialog"><span></span></a>
				</div>
			</div>
			<div class="container container-meet-ship">
				{{-- {{ $Ad->userId }}
				{{ Auth::id() }}
				{{ $User->id }} --}}
				<div class="meet" data-ads="{{ $Ad->id }}" data-buyer="{{ ($Ad->userId == Auth::id()) ? $User->id : Auth::id() }}"><a href="#">Meet Up</a></div>
				@if ($Ad->userId == Auth::id())
				<div class="ship" data-ads="{{ $Ad->id }}" data-buyer="{{ $User->id }}"><a href="#">Ship it Out</a></div>
				@endif
			</div>

		</div>
		<div class="good-van">
			<div class="container container-good-van">
				<div class="good-item-1">
					<img src="{{$Ad->adsImage or '/newthemplate/img/logo.svg'}}" style="max-height: 70px; width: auto;"/>
					<a href="/add-details/{{$Ad->id}}"><p>{{$Ad->adsName}}</p></a><!-- <br><span>In Lost & Find Items</span></p> -->
				</div>
				<div class="good-item-2">
					<a href="/add-details/{{$Ad->id}}"><img src="/newthemplate/img/arrow-next.svg" /></a>
				</div>
			</div>
		</div>
		<div class="dialog-body">
			<div class="container container-dialog">
            @foreach($Messages as $Message)
				<div class="@if($Message->user_id != Auth::user()->id) user-1 @else user-2 @endif message_box" data-id="{{$Message->id}}">
					<p class="today">@if(date('F j, Y', strtotime($Message->created_at)) == date('F j, Y')) today @else {{date('F j, Y', strtotime($Message->created_at))}} @endif<a class="border-a">at {{date('H:i', strtotime($Message->created_at))}}</a></p>
					<p class="user-messang-1"><span>@if ($Message->type == 'file')
						{!!$Message->body!!}
					@else
						{{$Message->body}}
					@endif</span></p>
				</div>
            @endforeach
				<div class="typing">
					<p style="display: none;">{{$User->name}} is typing…</p>
				</div>
			</div>
		</div>
		<div class="dialog-footer">
			<div class="container container-dialog-footer">
				<input type="file" name="file" class="MessageFile" hidden>
				<a href="javascript:void(0)" class="upload">+</a>
	            {{ csrf_field() }}
	            <input type="hidden" id="ChatID" value="{{$Chat->id}}">
				<div class="lead emoji-picker-container">
					<input type="text" id="MessageText" data-emojiable="true" placeholder="Write something here..." />
	            </div>
				{{-- <a href="javascript:void(0)" class="emojis"><img src="/newthemplate/img/emojis.svg" /></a> --}}
				<button class="blue_btn" id="SendChat">Send</button>
			</div>
		</div>
	</section>

@include("newthemplate.footer")