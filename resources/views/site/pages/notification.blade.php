@include("site.inc.header")

<section class="s-notification">
    <div class="container">
        <div class="title-box">
            <h1>{!! Language::lang('Notifications') !!}</h1>
        </div>

        <ul class="notification-lists">
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
                            <div class="time">{{ Carbon\Carbon::parse($notification['date']->date)->format('d.m.Y H:i:s') }}</div>
                        </div>
                        <p>{!! $notification['message'] !!}</p>
                    </div>
                    <div class="remove" data-id="{{ $notification['id'] }}">
                        @php(include ("mooimarkt/img/remove-icon.svg"))
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</section>

@section('bottom-footer')
    <script>
        $(document).ready(function () {
            $('.remove').on('click', function () {
                let $this = $(this);
                let id    = $this.data('id');

                $.post('/delete-notification', {
                    id    : id,
                    _token: $('meta[name=csrf-token]').attr('content')
                }).then(function (response) {
                    if (response.status == 'success') {
                        $this.parent().remove();
                    }
                });
            });
        });
    </script>
@endsection

@include("site.inc.notification")
@include("site.inc.footer")