@include('newthemplate.header')

<section id="messages" class="messages">
    <div class="content tab-header">
        <ul class="tabs">
            <li class="tab-link current" data-tab="tab-1">Active</li>
            <li class="tab-link" data-tab="tab-2">Archieved</li>

        </ul>
        <div class="tab-content current" id="tab-1">
            <h5>Active</h5>
            <p>System: You have a meet up with Jenna Clark at 18:00(GMT+1) on 25th May 2018 in Apple Green, Pauktawr,
                Kilkenny, Ireland</p>
            <p>System: You have a shipment arrangement with Paul on 27th May 2018 to ship to №26, High Street, Hameln,
                Germany.</p>
        </div>
        <div class="tab-content" id="tab-2">
            <h5>Archieved</h5>
            <p>System: You have a meet up with Jenna Clark at 18:00(GMT+1) on 25th May 2018 in Apple Green, Pauktawr,
                Kilkenny, Ireland</p>
            <p>System: You have a shipment arrangement with Paul on 27th May 2018 to ship to №26, High Street, Hameln,
                Germany.</p>
        </div>
    </div>

    <div class="container list-item">
        @if(isset($Chats))
            @foreach($Chats as $id => $Chat)
                @foreach($Chat['Messages'] as $mess)
                    @php $lmess = $mess; @endphp
                @endforeach
                @if(!isset($lmess)) @continue @endif
                <a href="/dialog/{{$id}}" class="item">
                    <div class="item-chat">
                        <div class="chat-preview">
                            <img src="{{ isset($Chat['User']->avatar) ? $Chat['User']->avatar : '/storage/avatar/icon-p.svg' }}" alt="Avatar" width="48" height="48"/>
                            <ul>
                                <li class="name">{{ (!empty($Chat['User'])) ? $Chat['User']->name : 'DELETED' }}</li>
                                <li class="messages-preview">@if($lmess->user_id == Auth::user()->id)
                                        you: @endif @if(isset($lmess)) @if ($lmess->type == 'file')
                                        <object>{!!$lmess->body!!}</object> @else {{$lmess->body}} @endif @endif</li>
                            </ul>
                        </div>
                        <p class="cars">{{$Chat['Ad']->adsName}}</p>
                    </div>
                    <div class="time">
                        <ul>
                            <li>11:42 am</li>
                            <li><span>1</span></li>
                        </ul>
                    </div>
                </a>
            @endforeach
        @endif
    </div>
</section>
<!-- footer end -->
<script src="/newthemplate/bower_components/jquery/jquery.min.js"></script>
<script src="/newthemplate/bower_components/swiper/dist/js/swiper.js"></script>
<!-- build:js js/main.js -->
<script src="/newthemplate/js/JavaScript.js"></script>
<script src="/newthemplate/js/jquery.3.3.1.js"></script>
<script src="/newthemplate/js/wow.js"></script>
<script>new WOW().init();</script>
<script src="/newthemplate/js/app.js"></script>

<script src="/newthemplate/js/max.js"></script>
</div>