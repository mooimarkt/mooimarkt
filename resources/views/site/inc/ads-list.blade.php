<style>
    .icon.cursor__no-hover svg,
    .icon.cursor__no-hover path {
        cursor: default !important;
    }
</style>

@foreach($ads as $key => $item)
    <div class="card-item login-card">
        <div class="img-wrap" data-id="{{ $item->id }}" data-name="{{ $item->adsName }}"
             data-link="{{ route('product', $item->id) }}">
            <a href="{{ route('product', $item->id) }}" class="card-item login-card">

                <img @if($item->reserved_user_id) style="opacity: 0.2;" @endif src="{{ $item->images->first()->thumb ?? '/mooimarkt/img/photo_camera.svg' }}" alt="">

                @if($item->reserved_user_id)
                    <div style="position:absolute; top: 50%; left: 50%;  transform: translate(-50%, -50%);"><h1>{{ strtoupper(trans('translation.reserved')) }}</h1></div>
                @endif
            </a>
        </div>
        <div class="card-info">
            <a href="{{ route('product', $item->id) }}" class="card-item login-card">
                <h3 class="card-title">{{ $item->adsName }}</h3>
            </a>
            <div class="card-middle">
                <div class="store">{{ $item->brand}}</div>
                <div class="card-group">
                    
                    <div class="card-count-item">
                        <div class="icon cursor__no-hover">@php(include ("mooimarkt/img/view-icon.svg")) </div>
                        <div class="count">{{ $item->adsViews }}</div>
                    </div>
                </div>
            </div>
            <div class="card-bottom">
                <div class="price">{{ $item->productTypeSymbol() }} {{ $item->adsPrice }}</div>
                <div class="card-group">
                    <div class="till">{{ Language::lang('Till') }} {{ $item->expired_at != null ? \Carbon\Carbon::parse($item->expired_at)->format('d.m.Y') : 'No date' }}</div>
                    <div class="card-count-item">
                        <div class="icon cursor__no-hover">@php(include ("mooimarkt/img/user-icon.svg"))</div>
                        <div class="count">{{ $item->getUserViews() }}</div>
                    </div>
                    <div class="card-count-item {{ (isset($filter) && $filter == 'favorites') ? 'favorite-toggle' : 'favorite' }}"
                         data-id="{{ $item->id }}" {{ (isset($filter) && $filter == 'favorites') ? 'data-fancybox data-src=#favorites' : '' }} >

                        @if (auth()->check())
                            <div class="icon @if($item->favorites->contains('user_id', auth()->user()->id)) active @endif">@php(include("mooimarkt/img/heart-icon-red.svg"))</div>
                            <div class="icon @if(!$item->favorites->contains('user_id', auth()->user()->id)) active @endif">@php(include("mooimarkt/img/heart-icon.svg"))</div>
                        @else
                            <div class="icon active">@php(include("mooimarkt/img/heart-icon.svg"))</div>
                        @endif

                        <div class="count">{{ $item->favorites->count() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
