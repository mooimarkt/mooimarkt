<ul class="notification-lists" style="border: none">
    @foreach($notifications as $notification)
        <li class="notification-item">
            <div class="icon">
                @isset($notification['picture']['link'])
                    <a href="{{ $notification['picture']['link'] }}">
                        <img src="{{ $notification['picture']['src'] ?? 'img/ring-icon.svg' }}" alt="">
                    </a>
                @else
                    <img src="{{ $notification['picture']['src'] ?? 'img/ring-icon.svg' }}" alt="">
                @endif
            </div>
            <div class="text-box">
                <div class="top">
                    <div class="time">
                        {{ Carbon\Carbon::parse($notification['date']->date)->format('d.m.Y H:i:s') }}
                    </div>
                </div>
                <p>{!! $notification['message'] !!}</p>
            </div>
        </li>
    @endforeach
</ul>