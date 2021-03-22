@include("site.inc.header")

<section class="s-page-product">
    <div class="container">
        <div class="content">
            <div class="product-gallery" style="margin-bottom: 10px;">
                @if(!empty($product->images))
                    @if(isset($product->images[0]))
                        <div class="left">
                            <a href="{{ $product->images[0]->imagePath }}" data-fancybox="gallery">
                                <img @if($product->reserved_user_id) style="opacity: 0.3;" @endif src="{{ $product->images[0]->imagePath }}" alt="">

                                @if($product->reserved_user_id)
                                    <div style="position:absolute; top: 50%; left: 50%;  transform: translate(-50%, -50%);"><h1>{{ strtoupper(trans('translation.reserved')) }}</h1></div>
                                @endif

                            </a>
                        </div>
                    @endif
                    <div class="right">
                        @if(isset($product->images[1]))
                            <div class="top">
                                <a href="{{ $product->images[1]->imagePath }}" data-fancybox="gallery">
                                    <img src="{{ $product->images[1]->imagePath }}" alt="">
                                </a>
                            </div>
                        @endif
                        <div class="bottom">
                            @if(isset($product->images[2]))
                                <div class="left">
                                    <a href="{{ $product->images[2]->imagePath }}" data-fancybox="gallery">
                                        <img src="{{ $product->images[2]->imagePath }}" alt="">
                                    </a>
                                </div>
                            @endif
                            @if(isset($product->images[3]))
                                <div class="right">
                                    <a href="{{ $product->images[3]->imagePath }}" data-fancybox="gallery">
                                        <img src="{{ $product->images[3]->imagePath }}" alt="">
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>


            <div class="product-gallery">
                @foreach($product->images as $image)
                    @if($loop->iteration > 4)
                        <div class="right">
                            <div class="top">
                                <a href="{{ $image->imagePath }}" data-fancybox="gallery">
                                    <img src="{{ $image->imagePath }}" alt="">
                                </a>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
            {!! Breadcrumbs::render('product', $product) !!}

            <div class="additional-info-box">
                {{ Language::lang('More items from') }} <span>{{ $user->fullName ?? $user->name }}</span>
            </div>
            <div class="card-items item-3">
                @include('site.inc.ads-list')
            </div>
            {!! $ads->links() !!}
        </div>
        <aside class="product-sidebar">
            <div class="top">
                <h3 class="pd-name">{{ $product->adsName }}</h3>
                <div class="pd-price">{{ $product->productTypeSymbol() }} {{ $product->adsPrice }}</div>
                <p class="pd-descr">
                    {{ $product->adsDescription }}
                </p>

                @if($product->checkThisUser())
                    <div class="btn-wrap">
                        <a href="#first_listed_popup" data-fancybox data-src="#first_listed_popup"
                           data-id="{{ $product->id }}" data-name="{{ $product->adsName }}"
                           data-link="{{ route('product', $product->id) }}"
                           class="btn def_btn first_list_btn">{{ Language::lang('make first listed') }}</a>
                        <p class="info_cents">{{ Language::lang('For') }}
                            <span>{{ App\Option::getCost("opt_pack_spotlight")['cost']}} {{ Language::lang(App\Option::getCost("opt_pack_spotlight")['currency'])  }}</span>
                        </p>
                    </div>
                @else
                    <div class="btn-wrap">
                        <p class="btn-wrap_p">{{ Language::lang('Write seller to get this item:') }}</p>
                        <a href="#" class="btn def_btn message_btn chat-start" data-id="{{ $product->id }}"
                           data-im="buying">@php(include ("mooimarkt/img/header_login_icons_2.svg")) {{ Language::lang('message seller') }}</a>
                    </div>
                @endif


                <div class="likes-count favorite" data-id="{{ $product->id }}">
                    @if (auth()->check())
                        <div class="icon @if($product->favorites->contains('user_id', auth()->user()->id)) active @endif">@php(include("mooimarkt/img/heart-icon-red.svg"))</div>
                        <div class="icon @if(!$product->favorites->contains('user_id', auth()->user()->id)) active @endif">@php(include("mooimarkt/img/heart-icon.svg"))</div>
                    @else
                        <div class="icon active">@php(include("mooimarkt/img/heart-icon.svg"))</div>
                    @endif

                    <div class="count">{{ $product->favorites->count() }}</div>&nbsp;{{ Language::lang('likes') }}
                </div>
            </div>
            <div class="middle">
                <ul class="pd-info">
                    @foreach($filters as $filter)
                        <li>
                            <span class="left">{{ Language::lang($filter['name']) }}: </span>
                            <span class="right">{{ Language::lang($filter['value']) }}</span>
                        </li>
                    @endforeach
                    {{--<li>
                        <span class="left">{{ Language::lang('Brand') }}: </span>
                        <span class="right">{{ $product->brand }}</span>
                    </li>
                    <li>
                        <span class="left">{{ Language::lang('Size') }}:</span>
                        <span class="right">{{ $productSizes }}</span>
                    </li>
                    <li>
                        <span class="left">{{ Language::lang('Condition') }}:</span>
                        <span class="right">{{ $productConditions }}</span>
                    </li>
                    <li>
                        <span class="left">{{ Language::lang('Color') }}:</span>
                        <span class="right">{{ $productColors }}</span>
                    </li>--}}
                    <li>
                        <span class="left">{{ Language::lang('Payment') }}:</span>
                        <span class="right">{{ $product->payment ?? 'Not chosen'}}</span>
                    </li>
                    <li>
                        <span class="left">{{ Language::lang('views') }}:</span>
                        <span class="right">{{ $product->adsViews }}</span>
                    </li>
                    <li>
                        <span class="left">{{ Language::lang('Applied') }}:</span>
                        <span class="right">{{ $product->images->count() }}</span>
                    </li>
                    <li>
                        <span class="left">{{ Language::lang('uploaded') }}:</span>
                        <span class="right">{{ $product->created_at != null ? $product->created_at->diffForHumans() : 'No date' }}</span>
                    </li>
                    <li>
                        <span class="left">{{ Language::lang('swap') }}:</span>
                        <span class="right">{{ $product->swap == 1 ? 'Yes' : 'No' }}</span>
                    </li>
                </ul>
            </div>
            <div class="bottom">
                <div class="user-box">
                    <div class="img-wrap">
                        <a href="{{ $product->checkThisUser() ? route('ads', 'published') : route('profile.show', $user->id) }}">
                            <img src="{{ empty($user->avatar) ? '/mooimarkt/img/photo_camera.svg' : $user->avatar }}"
                                 alt="">
                        </a>
                    </div>
                    <div class="user-info">

                        <a href="{{ $product->checkThisUser() ? route('ads', 'published') : route('profile.show', $user->id) }}">
                            <div class="login">{{ $user->fullName ?? $user->name }}</div>
                        </a>
                        <ul class="stars_rating">
                            @for($i = 1; $i <= 5; $i++)
                                <li class="star_item {{ $i <= $activities ? 'active' : '' }}"></li>
                            @endfor
                            <li>{{ $activities > 0 ? $activities : '' }}</li>
                        </ul>
                        <div class="online-status {{ $user->getOnlineAttribute() === 'Online' ? Language::lang('online') : '' }} ">{{ $user->getOnlineAttribute() }}</div>
                    </div>
                </div>
            </div>
        </aside>
    </div>
    <div class="first_listed_popup" id="first_listed_popup">
        <h3>{{ Language::lang('Make your ad First Listed') }}</h3>
        <p>{{ Language::lang('Confirm that you want to make') }} <a href="" id="name-ads">Leather
                Jacket</a> {{ Language::lang('First Listed. It will cost') }}
            <b>{{ App\Option::getCost("opt_pack_spotlight")['cost']}} {{ Language::lang(App\Option::getCost("opt_pack_spotlight")['currency'])  }}</b>.
        </p>
        <div class="btns_wrpr">
            <a href="" class="btn light_bordr_btn close_modal_btn">{{ Language::lang('Cancel') }}</a>
            <a href="" class="btn def_btn first_listed_confirm_btn">{{ Language::lang('Confirm') }}</a>
        </div>
    </div>
</section>

@include("site.inc.notification")
@include("site.inc.footer")
