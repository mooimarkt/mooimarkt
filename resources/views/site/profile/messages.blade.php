@include("site.inc.header")

<div class="tab_message">
    <div class="container">
        <div class="tab_message_button">
            <button class="btn def_btn tab_btn tab_btn_messages {{ (request('im') == 'selling' || request('im') == null ) ? 'active' : '' }}"
                    data-title="selling">
                @if($countMessageSelling > 0)<span class="tab-messages-count">{{ $countMessageSelling }}</span>@endif
                I'm Selling
            </button>
            <button class="btn def_btn tab_btn tab_btn_messages {{ request('im') == 'buying' ? 'active' : '' }}"
                    data-title="buying">
                @if($countMessageBuying > 0)<span class="tab-messages-count">{{ $countMessageBuying }}</span>@endif
                I'm Buying
            </button>
        </div>
        <div class="tab_message_button2 {{ (request('im') == 'selling' || request('im') == null ) ? 'active' : '' }}"
             data-button-section="selling" style="display: none">
        </div>
        <div class="tab_message_button2 {{ request('im') == 'buying' ? 'active' : '' }}" data-button-section="buying"
             style="display: none">
        </div>
    </div>
</div>

<div class="">
    <div class="container">
        @if(isset($Products))
            <div class="info">
                <section class="s-chat">
                    <div class="chat-container">
                        <div class="left">
                            <div class="top-panel top-panel-left">
                                <h2>Messages</h2>
                                <form class="m-search-form">
                                    <div class="search-icon">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path d="M19.2949 18.2109L14.6934 13.6094C15.834 12.2188 16.5215 10.4375 16.5215 8.49609C16.5215 4.04297 12.9082 0.429688 8.45508 0.429688C3.99805 0.429688 0.388672 4.04297 0.388672 8.49609C0.388672 12.9492 3.99805 16.5625 8.45508 16.5625C10.3965 16.5625 12.1738 15.8789 13.5645 14.7383L18.166 19.3359C18.4785 19.6484 18.9824 19.6484 19.2949 19.3359C19.6074 19.0273 19.6074 18.5195 19.2949 18.2109ZM8.45508 14.957C4.88867 14.957 1.99023 12.0586 1.99023 8.49609C1.99023 4.93359 4.88867 2.03125 8.45508 2.03125C12.0176 2.03125 14.9199 4.93359 14.9199 8.49609C14.9199 12.0586 12.0176 14.957 8.45508 14.957Z"
                                                  fill="#646262"></path>
                                        </svg>
                                    </div>
                                    <input type="text" placeholder="Search">
                                </form>
                            </div>
                            <div class="m-list-items-wrap">
                                <ul class="m-list-items">
                                    @php $cntr = 0; @endphp
                                    @foreach($Products as $productID => $ProductData)

                                        @php
                                            foreach ($ProductData['Chats'] as $id => $chatData) {
                                                if ($chatData['User'] === null || empty($chatData['Messages'])) {
                                                    //unset($ProductData['Chats'][$id]);
                                                }

                                                if (empty($ProductData['Chats'])) {
                                                    //continue 2;
                                                }
                                            }
                                            if (isset($ProductData)) {
                                                ksort($ProductData['Chats'], SORT_NUMERIC);
                                            }
                                        @endphp

                                        <li product_id="{{ $productID }}" data-product-id="{{ $productID }}"
                                            data-chat-id="{{ key($ProductData['Chats']) }}"
                                            class="m-item product-item product-id-item-{{ $productID }} {{ $ProductData['Product']->userId == Auth::id() ? ' selling' : 'buying' }}"
                                            style="background-color: rgba(215,197,192,0.25);  {{ ($ProductData['Product']->userId == Auth::id()) && (request('im') == 'selling') || ($ProductData['Product']->userId == Auth::id()) && (request('im') == null) || ($ProductData['Product']->userId !== Auth::id()) && (request('im') == 'buying') ? '' : 'display: none' }}; margin-bottom: 1px;">
                                            <div class="img-wrap">
                                                <img src="{{ $ProductData['Product']->images->first()->thumb or '/mooimarkt/img/logo.svg' }}"
                                                     alt="">
                                            </div>
                                            <div class="m-item-info">
                                                <div class="top">
                                                    <div style="font-size: 12px;"
                                                         class="login">{{ substr($ProductData['Product']->adsName, 0, 25) }} @if(strlen($ProductData['Product']->adsName) > 25)
                                                            ...@endif
                                                    </div>
                                                </div>
                                                @if($ProductData['messages_unread_count'] > 0)
                                                    <span style="background-color: #DD5959; color: white; padding: 2px 5px 2px 5px!important; font-size: 8px; float: right; margin-bottom: 5px; border-radius: 50px; -moz-border-radius: 50px;"
                                                          class="unread-messages-count">
                                                        <b>{{ $ProductData['messages_unread_count'] }}</b>
                                                    </span>
                                                @endif
                                            </div>
                                        </li>

                                        @foreach($ProductData['Chats'] as $chatID => $Chat)
                                            @if(isset($Chat['User']->id))
                                                @php $lastMessage = '' @endphp
                                                @php
                                                    $lastMessage = end($Chat['Messages']);
                                                    if($lastMessage === null){
                                                        $lastMessage = '';
                                                    }
                                                @endphp

                                                @php
                                                    $info = [
                                                        'product_id'       => $Chat['Ad']->id,
                                                        'product_title'    => $Chat['Ad']->adsName,
                                                        'product_image'    => $Chat['Ad']->images->first()->thumb ?? '/mooimarkt/img/logo.svg',
                                                        'product_brand'    => $Chat['Ad']->brand,
                                                        'product_price'    => $Chat['Ad']->adsPrice,
                                                        'product_currency' => $Chat['Ad']->productTypeSymbol(),
                                                        'buyer_id'         => $Chat['User']->id,
                                                        'buyer_name'       => $Chat['User']->name,
                                                        'buyer_avatar'     => $Chat['User']->avatar ?? '/mooimarkt/img/photo_camera.svg',
                                                        'chat_id'          => $chatID,
                                                    ];
                                                @endphp

                                                @if($ProductData['Product']->userId === Auth::id())
                                                    <li class="m-item sub-user-item-{{ $ProductData['Product']->id }} sub-user-item-{{ $ProductData['Product']->id }}-{{ $Chat['User']->id }} customer-item customer-item-{{ $ProductData['Product']->id }}  {{ $ProductData['Product']->userId == Auth::id() ? ' selling' : 'buying' }}"
                                                        data-chat-id="{{ $chatID }}"
                                                        data-info="<?= htmlspecialchars(json_encode($info), ENT_QUOTES);?>"
                                                        style="display: none; @if($ProductData['Product']->reserved_user_id == $Chat['User']->id) background: #fb815d @endif">
                                                        <div class="img-wrap">
                                                            <img style="height: 20px; width: 20px" width="15px"
                                                                 height="15px"
                                                                 src="{{ $Chat['User']->avatar ?? '/mooimarkt/img/photo_camera.svg' }}"
                                                                 alt="">
                                                        </div>
                                                        <div class="m-item-info">
                                                            <div class="top">
                                                                @php $isOnline = App\User::find($Chat['User']->id)->isOnline() @endphp
                                                                <div style="font-size: 10px"
                                                                     class="login">{{ $Chat['User']->name }}
                                                                    <span style="height: 5px; width: 5px;"
                                                                          class="{{ $isOnline ? 'online' : 'offline' }}"></span>
                                                                </div>
                                                                @if (!empty($lastMessage))
                                                                    @php
                                                                        if(date('d.m.Y', strtotime($lastMessage->created_at)) == date('d.m.Y')){
                                                                            $format = 'g:i A';
                                                                        }else{
                                                                            $format = 'd.m.Y';
                                                                        }
                                                                    @endphp
                                                                    <div style="font-size: 8px"
                                                                         class="time">{{ date($format, strtotime($lastMessage->created_at)) }}</div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endif
                                            @endif
                                            @php $cntr++; @endphp
                                        @endforeach
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="right">
                            @php
                                $cntr = 0;
                                $chats = [];
                                foreach($Products as $productID => $ProductData){
                                    foreach ($ProductData['Chats'] as $id => $chat){
                                        $ProductData['Chats'][$id]['Product'] = $ProductData;
                                    }

                                    $chats += $ProductData['Chats'];
                                }
                                $ProductData['Chats'] = $chats;
                            @endphp

                            @php
                                $lastNotEmptyChatId = null;
                                foreach ($ProductData['Chats'] as $chatID => $Chat) {
                                    if (!empty($Chat['Messages'])) {
                                        $lastNotEmptyChatId = $chatID;
                                    }
                                }
                            @endphp

                            @foreach($ProductData['Chats'] as $chatID => $Chat)
                                @if(isset($Chat['User']->id))
                                    @php
                                        $activity = App\Activity::where('ads_id', $Chat['Product']['Product']->id)
                                            ->where(function ($query) use ($Chat) {
                                                $query->where(function ($query) use ($Chat) {
                                                    $query->where('seller_id', $Chat['User']->id)
                                                        ->where('buyer_id', auth()->user()->id);
                                                })
                                                    ->orWhere(function ($query) use ($Chat) {
                                                        $query->where('seller_id', auth()->user()->id)
                                                            ->where('buyer_id', $Chat['User']->id);
                                                    });
                                            })
                                            ->whereNull('deleted_at')
                                            ->first();
                                    @endphp

                                    <div class="chat-right-wrapper" data-chat-id="{{ $chatID }}"
                                         data-product-id="{{ $Chat['Product']['Product']->id }}" style="display: none">
                                        <div class="top-panel top-panel-right">
                                            <a href="{{ route('profile.show', $Chat['User']->id) }}">
                                                <div class="m-selected-item">
                                                    <div class="img-wrap">
                                                        <img src="{{ $Chat['User']->avatar ?? '/mooimarkt/img/photo_camera.svg' }}"
                                                             alt="">
                                                    </div>
                                                    <div class="m-item-info">
                                                        @php $isOnline = App\User::find($Chat['User']->id)->isOnline() @endphp
                                                        <div class="top">
                                                            <div class="login">{{ $Chat['User']->name }}
                                                                <span class="{{ $isOnline ? 'online' : 'offline' }}"></span>
                                                            </div>
                                                        </div>
                                                        <div class="status">{{ $isOnline ? 'Online' : 'Offline' }}</div>
                                                    </div>
                                                </div>
                                            </a>

                                            @if(!empty($activity))
                                                @if($activity->seller->id == Auth::id() || $activity->buyer->id == Auth::id())
                                                    @php
                                                        if (Auth::id() == $activity->seller_id) {
                                                            $rate = $activity->seller_mark;
                                                        } elseif (Auth::id() == $activity->buyer_id) {
                                                            $rate = $activity->buyer_mark;
                                                        }
                                                    @endphp

                                                    @if($activity->seller_confirmed && $activity->buyer_confirmed)
                                                        <div class="profile-info-stars">
                                                            <ul class="stars_rating">
                                                                @for($i = 1; $i <= 5; $i++)
                                                                    <li class="star_item {{ $i <= $rate ? 'active' : '' }}"></li>
                                                                @endfor
                                                            </ul>
                                                        </div>
                                                    @elseif(($activity->ads !== null && $activity->ads->adsStatus !== 'sold') && is_null($activity->buyer_confirmed) && $activity->buyer->id == Auth::id())
                                                        <div class="wrap_button">
                                                            <button class="button active confirm_sale_buyer_btn"
                                                                    data-activity="{{ $activity->id }}">
                                                                Confirm sale
                                                            </button>

                                                            <div class="profile-info-stars"
                                                                 style="display: none;">
                                                                <ul class="stars_rating">
                                                                    @for($i = 1; $i <= 5; $i++)
                                                                        <li class="star_item"></li>
                                                                    @endfor
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endif
                                            @elseif($Chat['Product']['Product']->userId == Auth::id())
                                                <div class="profile-info-stars"
                                                     style="display: none;">
                                                    <ul class="stars_rating">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <li class="star_item"></li>
                                                        @endfor
                                                    </ul>
                                                </div>
                                            @endif

                                            <div class="m-actions">
                                                <a href="#" class="m-action-item hide-deleting">
                                                    @php include("mooimarkt/img/language_arrow_bottom.svg") @endphp
                                                </a>
                                                <a href="#" class="m-action-item delete-chat">
                                                    <div class="icon">
                                                        <svg width="26" height="23"
                                                             viewBox="0 0 26 23"
                                                             fill="none"
                                                             xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M18.7723 4.22326C16.6932 2.14419 13.9351 1 10.9955 1C8.05601 1 5.29787 2.14419 3.2188 4.22326C-0.799803 8.24186 -1.07887 14.6744 2.52578 19.014C2.17229 19.7256 1.60485 20.5535 0.762988 20.9674C0.358337 21.1674 0.13043 21.6 0.200198 22.0465C0.269965 22.493 0.614151 22.8419 1.06066 22.9116C1.26997 22.9442 1.56764 22.9767 1.93043 22.9767C2.90252 22.9767 4.33508 22.7488 5.8002 21.693C7.43276 22.5721 9.2188 23 10.9909 23C13.8374 23 16.656 21.8977 18.7769 19.7767C20.856 17.6977 22.0002 14.9395 22.0002 12C22.0002 9.06046 20.8514 6.30233 18.7723 4.22326ZM17.8839 18.8884C14.7444 22.0279 9.88392 22.6512 6.06066 20.4047C5.8095 20.2558 5.49787 20.3023 5.29787 20.5023C5.27927 20.5116 5.26066 20.5256 5.24671 20.5395C3.98624 21.5163 2.74904 21.7209 1.93043 21.7209H1.92578C2.86997 21.0326 3.46531 20.0093 3.81415 19.214C3.86997 19.0791 3.87927 18.9395 3.84671 18.8093C3.83276 18.6837 3.78159 18.5581 3.69322 18.4558C0.28857 14.6093 0.465314 8.74884 4.10252 5.11163C7.90252 1.31163 14.0839 1.31163 17.8793 5.11163C21.6839 8.91163 21.6839 15.0884 17.8839 18.8884Z"
                                                                  fill="#E0B1A3"></path>
                                                            <path d="M10.9947 12.7721C11.4212 12.7721 11.7668 12.4264 11.7668 12C11.7668 11.5736 11.4212 11.2279 10.9947 11.2279C10.5683 11.2279 10.2227 11.5736 10.2227 12C10.2227 12.4264 10.5683 12.7721 10.9947 12.7721Z"
                                                                  fill="#E0B1A3"></path>
                                                            <path d="M14.9752 12.7721C15.4016 12.7721 15.7473 12.4264 15.7473 12C15.7473 11.5736 15.4016 11.2279 14.9752 11.2279C14.5488 11.2279 14.2031 11.5736 14.2031 12C14.2031 12.4264 14.5488 12.7721 14.9752 12.7721Z"
                                                                  fill="#E0B1A3"></path>
                                                            <path d="M7.01233 12.7721C7.43874 12.7721 7.78442 12.4264 7.78442 12C7.78442 11.5736 7.43874 11.2279 7.01233 11.2279C6.58591 11.2279 6.24023 11.5736 6.24023 12C6.24023 12.4264 6.58591 12.7721 7.01233 12.7721Z"
                                                                  fill="#E0B1A3"></path>
                                                            <circle cx="21" cy="7" r="6"
                                                                    fill="#E0B1A3"
                                                                    stroke="white"
                                                                    stroke-width="2"></circle>
                                                            <path d="M22.5 5.5L19.5 8.5"
                                                                  stroke="white"
                                                                  stroke-linecap="round"
                                                                  stroke-linejoin="round"></path>
                                                            <path d="M19.5 5.5L22.5 8.5"
                                                                  stroke="white"
                                                                  stroke-linecap="round"
                                                                  stroke-linejoin="round"></path>
                                                        </svg>
                                                    </div>
                                                    <span>Delete Chat</span>
                                                </a>
                                                <a href="#" class="m-action-item chat-select">
                                                    <div class="icon">
                                                        <svg width="22" height="22"
                                                             viewBox="0 0 22 22"
                                                             fill="none"
                                                             xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M19.6823 0H2.31768C1.03757 0 0 1.04206 0 2.31768V19.6823C0 20.9624 1.04206 22 2.31768 22H19.6823C20.9624 22 22 20.9579 22 19.6823V2.31768C22 1.04206 20.9579 0 19.6823 0ZM20.8996 19.6823C20.8996 20.3516 20.3516 20.8996 19.6823 20.8996H2.31768C1.64843 20.8996 1.10045 20.3516 1.10045 19.6823V2.31768C1.10045 1.64843 1.64843 1.10045 2.31768 1.10045H19.6823C20.3516 1.10045 20.8996 1.64843 20.8996 2.31768V19.6823Z"
                                                                  fill="#E0B1A3"></path>
                                                            <path d="M14.3512 7.99061L9.46879 12.8416L7.64969 11.0135C7.43409 10.7979 7.08823 10.7979 6.87264 11.0135C6.65704 11.2291 6.65704 11.5749 6.87264 11.7905L9.07802 14.0094C9.18133 14.1127 9.32057 14.1711 9.46879 14.1711C9.61253 14.1711 9.75177 14.1127 9.85507 14.0094L15.1282 8.76766C15.3438 8.55206 15.3438 8.20621 15.1282 7.99061C14.9126 7.77501 14.5668 7.77501 14.3512 7.99061Z"
                                                                  fill="#E0B1A3"></path>
                                                        </svg>
                                                    </div>
                                                    <span>Select</span>
                                                </a>
                                                <a href="#" class="m-action-item m-select-all">
                                                    <div class="icon">
                                                        <svg width="22" height="22"
                                                             viewBox="0 0 22 22"
                                                             fill="none"
                                                             xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M19.6823 0H2.31768C1.03757 0 0 1.04206 0 2.31768V19.6823C0 20.9624 1.04206 22 2.31768 22H19.6823C20.9624 22 22 20.9579 22 19.6823V2.31768C22 1.04206 20.9579 0 19.6823 0ZM20.8996 19.6823C20.8996 20.3516 20.3516 20.8996 19.6823 20.8996H2.31768C1.64843 20.8996 1.10045 20.3516 1.10045 19.6823V2.31768C1.10045 1.64843 1.64843 1.10045 2.31768 1.10045H19.6823C20.3516 1.10045 20.8996 1.64843 20.8996 2.31768V19.6823Z"
                                                                  fill="#E0B1A3"></path>
                                                            <path d="M14.3512 7.99061L9.46879 12.8416L7.64969 11.0135C7.43409 10.7979 7.08823 10.7979 6.87264 11.0135C6.65704 11.2291 6.65704 11.5749 6.87264 11.7905L9.07802 14.0094C9.18133 14.1127 9.32057 14.1711 9.46879 14.1711C9.61253 14.1711 9.75177 14.1127 9.85507 14.0094L15.1282 8.76766C15.3438 8.55206 15.3438 8.20621 15.1282 7.99061C14.9126 7.77501 14.5668 7.77501 14.3512 7.99061Z"
                                                                  fill="#E0B1A3"></path>
                                                        </svg>
                                                    </div>
                                                    <span>Select All</span>
                                                </a>
                                                <a href="#" class="m-action-item m-item-delete">
                                                    <div class="icon">
                                                        <svg width="18" height="22"
                                                             viewBox="0 0 18 22"
                                                             fill="none"
                                                             xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M12.0348 7.9707C11.7502 7.9707 11.5195 8.20135 11.5195 8.48593V18.2236C11.5195 18.508 11.7502 18.7389 12.0348 18.7389C12.3193 18.7389 12.55 18.508 12.55 18.2236V8.48593C12.55 8.20135 12.3193 7.9707 12.0348 7.9707Z"
                                                                  fill="#E0B1A3"></path>
                                                            <path d="M5.95468 7.9707C5.6701 7.9707 5.43945 8.20135 5.43945 8.48593V18.2236C5.43945 18.508 5.6701 18.7389 5.95468 18.7389C6.23926 18.7389 6.4699 18.508 6.4699 18.2236V8.48593C6.4699 8.20135 6.23926 7.9707 5.95468 7.9707Z"
                                                                  fill="#E0B1A3"></path>
                                                            <path d="M1.52386 6.54937V19.2433C1.52386 19.9936 1.79898 20.6982 2.27958 21.2038C2.75797 21.7107 3.42374 21.9985 4.12049 21.9998H13.8686C14.5656 21.9985 15.2313 21.7107 15.7095 21.2038C16.1901 20.6982 16.4653 19.9936 16.4653 19.2433V6.54937C17.4206 6.29578 18.0397 5.37281 17.9119 4.39248C17.7839 3.41236 16.9489 2.67917 15.9603 2.67897H13.3224V2.03495C13.3254 1.49336 13.1113 0.973309 12.7279 0.590718C12.3445 0.208327 11.8236 -0.00460412 11.2821 -0.000176445H6.70706C6.16547 -0.00460412 5.64462 0.208327 5.26122 0.590718C4.87783 0.973309 4.66369 1.49336 4.66671 2.03495V2.67897H2.02881C1.04023 2.67917 0.205215 3.41236 0.0772145 4.39248C-0.0505843 5.37281 0.568486 6.29578 1.52386 6.54937ZM13.8686 20.9693H4.12049C3.23958 20.9693 2.5543 20.2126 2.5543 19.2433V6.59465H15.4348V19.2433C15.4348 20.2126 14.7495 20.9693 13.8686 20.9693ZM5.69715 2.03495C5.69373 1.76667 5.79918 1.50845 5.98957 1.31907C6.17976 1.12969 6.43858 1.02564 6.70706 1.03027H11.2821C11.5505 1.02564 11.8094 1.12969 11.9995 1.31907C12.1899 1.50825 12.2954 1.76667 12.292 2.03495V2.67897H5.69715V2.03495ZM2.02881 3.70941H15.9603C16.4725 3.70941 16.8877 4.12461 16.8877 4.63681C16.8877 5.14901 16.4725 5.56421 15.9603 5.56421H2.02881C1.51661 5.56421 1.10142 5.14901 1.10142 4.63681C1.10142 4.12461 1.51661 3.70941 2.02881 3.70941Z"
                                                                  fill="#E0B1A3"></path>
                                                            <path d="M8.99568 7.9707C8.71111 7.9707 8.48047 8.20135 8.48047 8.48593V18.2236C8.48047 18.508 8.71111 18.7389 8.99568 18.7389C9.28026 18.7389 9.5109 18.508 9.5109 18.2236V8.48593C9.5109 8.20135 9.28026 7.9707 8.99568 7.9707Z"
                                                                  fill="#E0B1A3"></path>
                                                        </svg>
                                                    </div>
                                                    <span>Delete</span>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="messages-box">
                                            <div class="messages-content">
                                                <div class="message-product-box">
                                                    <div class="img-wrap">
                                                        <img src="{{ $Chat['Product']['Product']->images->first()->thumb or '/mooimarkt/img/logo.svg' }}"
                                                             alt="">
                                                    </div>
                                                    <div class="text-info">
                                                        <div class="top">
                                                            <h3>{{ $Chat['Product']['Product']->adsName }}</h3>
                                                            <span class="price">{{ $Chat['Product']['Product']->productTypeSymbol() }}{{ $Chat['Product']['Product']->adsPrice }}</span>
                                                        </div>
                                                        <div class="bottom">
                                                            <div class="text">
                                                                <p>{{ Illuminate\Support\Str::limit($Chat['Product']['Product']->adsDescription, 128) }}</p>
                                                            </div>

                                                            @if(auth()->user()->id === $Chat['Product']['Product']->userId && (empty($activity) || is_null($activity->seller_confirmed)))
                                                                @php
                                                                    $productLatestActivity = $Chat['Product']['Product']->activities()->latest()->first();
                                                                    if (!$productLatestActivity) {
                                                                        $displaySellItemButton = true;
                                                                    } else {
                                                                        $displaySellItemButton = $productLatestActivity->buyer_id === $Chat['User']->id;
                                                                    }
                                                                @endphp
                                                                @if($ProductData['Product']->adsStatus !== 'sold' && $displaySellItemButton)
                                                                    <div class="btn-wrap">
                                                                        @php
                                                                            $info = [
                                                                                'product_id'       => $Chat['Product']['Product']->id,
                                                                                'product_title'    => $Chat['Product']['Product']->adsName,
                                                                                'product_image'    => $Chat['Product']['Product']->images->first()->thumb ?? '/mooimarkt/img/logo.svg',
                                                                                'product_brand'    => $Chat['Product']['Product']->brand,
                                                                                'product_price'    => $Chat['Product']['Product']->adsPrice,
                                                                                'product_currency' => $Chat['Product']['Product']->productTypeSymbol(),
                                                                                'buyer_id'         => $Chat['User']->id,
                                                                                'buyer_name'       => $Chat['User']->name,
                                                                                'buyer_avatar'     => $Chat['User']->avatar ?? '/mooimarkt/img/photo_camera.svg',
                                                                                'chat_id'          => $chatID,
                                                                            ];
                                                                        @endphp
                                                                    </div>
                                                                @endunless
                                                            @endif
                                                        </div>
                                                    </div>
                                                    @if($Chat['Product']['Product']->checkThisUser())
                                                        @php
                                                            $info = [
                                                                'product_id'       => $Chat['Product']['Product']->id,
                                                                'product_title'    => $Chat['Product']['Product']->adsName,
                                                                'product_image'    => $Chat['Product']['Product']->images->first()->thumb ?? '/mooimarkt/img/logo.svg',
                                                                'product_brand'    => $Chat['Product']['Product']->brand,
                                                                'product_price'    => $Chat['Product']['Product']->adsPrice,
                                                                'product_currency' => $Chat['Product']['Product']->productTypeSymbol(),
                                                                'buyer_id'         => $Chat['User']->id,
                                                                'buyer_name'       => $Chat['User']->name,
                                                                'buyer_avatar'     => $Chat['User']->avatar ?? '/mooimarkt/img/photo_camera.svg',
                                                                'chat_id'          => $chatID,
                                                            ];
                                                        @endphp

                                                        @unless($Chat['Product']['Product']->adsStatus === 'sold')
                                                            <div style="margin-right: 100px!important;"
                                                                 class="product_options_btns"
                                                                 data-product-id="{{ $Chat['Product']['Product']->id }}">
                                                                <div class="col">
                                                                    <div class="wrap_button">
                                                                        @if($Chat['Product']['Product']->adsStatus == 'paused')
                                                                            <a class="button stop_btn"
                                                                               style="display: none;"
                                                                               data-id="{{ $Chat['Product']['Product']->id }}">stop</a>
                                                                            <a class="button resume_btn"
                                                                               data-id="{{ $Chat['Product']['Product']->id }}">resume</a>
                                                                        @else
                                                                            <a class="button stop_btn"
                                                                               data-id="{{ $Chat['Product']['Product']->id }}">stop</a>
                                                                            <a class="button resume_btn"
                                                                               style="display: none;"
                                                                               data-id="{{ $Chat['Product']['Product']->id }}">resume</a>
                                                                        @endif
                                                                        <a class="button"
                                                                           href="{{ route('editSell', $Chat['Product']['Product']->id) }}">edit</a>
                                                                        <a class="button sold_btn">sold</a>
                                                                        <a class="button first_list_btn"
                                                                           href="#first_listed_popup" data-fancybox
                                                                           data-id="{{ $Chat['Product']['Product']->id }}"
                                                                           data-name="{{ $Chat['Product']['Product']->adsName }}"
                                                                           data-link="{{ route('product', $Chat['Product']['Product']->id) }}">up</a>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endunless
                                                    @endif
                                                </div>

                                                <div id="Chat" class="chat" data-chat-id="{{ $chatID }}">
                                                    @php $day = '' @endphp
                                                    @php $separator = '' @endphp
                                                    @foreach($Chat['Messages'] as $Message)
                                                        @php
                                                            if(date('d.m.Y', strtotime($Message->created_at)) != $day){
                                                                $day = date('d.m.Y', strtotime($Message->created_at));
                                                                if($day == date('d.m.Y')){
                                                                    $separator = 'Today';
                                                                }elseif($day == date('d.m.Y', strtotime('yesterday'))){
                                                                    $separator = 'Yesterday';
                                                                }else{
                                                                    $separator = $day;
                                                                }
                                                            }else{
                                                                $separator = '';
                                                            }
                                                        @endphp

                                                        @if($separator)
                                                            <div class="message-separate">
                                                                <span>{{ $separator }}</span></div>
                                                        @endif

                                                        @php $user = App\User::find( $Message->user_id ); @endphp
                                                        @if($Message->user_id != auth()->user()->id)
                                                            <div class="message-item person-message {{ !$Message->read_at ? 'unread' : '' }}"
                                                                 data-id="{{$Message->id}}">
                                                                <label class="checkbox">
                                                                    <input type="checkbox">
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                                <div class="img-wrap">
                                                                    <img src="{{ $user->avatar ?? '/mooimarkt/img/photo_camera.svg' }}"
                                                                         alt="">
                                                                </div>
                                                                <div class="message-wrap"
                                                                     style="background-color: white">
                                                                    <div class="text-message">
                                                                        <p>{!! $Message->body !!}</p>
                                                                        <div style="color: #5f5f5f; font-size: 10px">
                                                                            {{ date('H:i', strtotime($Message->created_at)) }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="message-item your-message"
                                                                 data-id="{{$Message->id}}">
                                                                <label class="checkbox">
                                                                    <input type="checkbox">
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                                <div class="message-wrap">
                                                                    <div class="text-message"
                                                                         style="background-color: #FAE2D8;">
                                                                        <p>{!! $Message->body !!}</p>
                                                                        <div style="color: #5f5f5f; font-size: 10px">
                                                                            {{ date('H:i', strtotime($Message->created_at)) }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="img-wrap">
                                                                    <img src="{{ $user->avatar ?? '/mooimarkt/img/photo_camera.svg' }}"
                                                                         alt="">
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>

                                            <div class="bottom-controls">
                                                <div class="control-left">
                                                    <div class="img-wrap">
                                                        <a href="{{ route('profile.show', auth()->user()->id) }}">
                                                            <img src="{{ auth()->user()->avatar ?? '/mooimarkt/img/photo_camera.svg' }}"
                                                                 alt="">
                                                        </a>
                                                    </div>
                                                    <input type="text" class="message-input"
                                                           placeholder="Type here...">
                                                </div>
                                                <div class="control-right">
                                                    <label class="attachment-file-btn">
                                                        <div class="attachment-file-icon">
                                                            <svg width="12" height="20"
                                                                 viewBox="0 0 12 20"
                                                                 fill="none"
                                                                 xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M5.95828 0C2.96838 0 0.535156 2.43249 0.535156 5.4232V15.6905C0.535156 16.057 0.831719 16.3536 1.19831 16.3536C1.56465 16.3536 1.86121 16.057 1.86121 15.6905V5.4232C1.86121 3.16413 3.69876 1.3261 5.95828 1.3261C8.21804 1.3261 10.0555 3.16413 10.0555 5.4232V16.0085C10.0555 17.478 8.85966 18.674 7.38984 18.674C7.37891 18.674 7.36908 18.6798 7.3582 18.6804C7.34655 18.6798 7.33745 18.674 7.32584 18.674C5.85613 18.674 4.66025 17.478 4.66025 16.0085V9.65885C4.66025 8.94271 5.24225 8.36067 5.95828 8.36067C6.67446 8.36067 7.2565 8.94271 7.2565 9.65885V15.6905C7.2565 16.057 7.55359 16.3536 7.91945 16.3536C8.28523 16.3536 8.58256 16.057 8.58256 15.6905V9.65885C8.58256 8.21172 7.40541 7.03461 5.95828 7.03461C4.51135 7.03461 3.3342 8.21176 3.3342 9.65885V16.0085C3.3342 18.2091 5.12445 20 7.3258 20C7.33741 20 7.34651 19.9942 7.35816 19.9935C7.36908 19.9942 7.37891 20 7.3898 20C9.59061 20 11.3814 18.2091 11.3814 16.0085V5.4232C11.3814 2.43249 8.94822 0 5.95828 0Z"
                                                                      fill="#E0B1A3"></path>
                                                            </svg>
                                                        </div>
                                                        <input type="file" class="MessageFile"
                                                               name="file"
                                                               accept="image/x-png,image/gif,image/jpeg">
                                                    </label>
                                                    <div class="btn-wrap">
                                                        <button class="btn def_btn btn-send-message">
                                                            Send
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @php $cntr++; @endphp
                                @endif
                            @endforeach
                        </div>

                        @if(!empty($ProductData['Chats']))
                            <div class="profile-info">
                                <div class="top-panel top-panel-left">
                                </div>

                                <div class="profile-info-box">
                                    @php $cntr = 0; @endphp
                                    @foreach($ProductData['Chats'] as $chatID => $Chat)
                                        @if(isset($Chat['User']->id))
                                            @php $lastMessage = '' @endphp
                                            @foreach($Chat['Messages'] as $message)
                                                @php $lastMessage = $message; @endphp
                                            @endforeach

                                            @php
                                                $info = [
                                                    'product_id'       => $Chat['Product']['Product']->id,
                                                    'product_title'    => $Chat['Product']['Product']->adsName,
                                                    'product_image'    => $Chat['Product']['Product']->images->first()->thumb ?? '/mooimarkt/img/logo.svg',
                                                    'product_brand'    => $Chat['Product']['Product']->brand,
                                                    'product_price'    => $Chat['Product']['Product']->adsPrice,
                                                    'product_currency' => $Chat['Product']['Product']->productTypeSymbol(),
                                                    'buyer_id'     => $Chat['User']->id,
                                                    'buyer_name'   => $Chat['User']->name,
                                                    'buyer_avatar' => $Chat['User']->avatar ?? '/mooimarkt/img/photo_camera.svg',
                                                ];
                                            @endphp

                                            <div class="profile-users"
                                                 id="profile-{{ $chatID }}" data-chat-id="{{ $chatID }}"
                                                 style="display: none;">
                                                <div class="img-wrap user-image">
                                                    <a href="{{ route('profile.show', $Chat['User']->id) }}">
                                                        <img src="{{ $Chat['User']->avatar ?? '/mooimarkt/img/photo_camera.svg' }}"
                                                             alt="">
                                                    </a>
                                                </div>
                                                <div class="m-item-info user-info">
                                                    @php $isOnline = App\User::find( $Chat['User']->id )->isOnline() @endphp
                                                    <p class="login profile-info-header">{{ $Chat['User']->name }}
                                                        <span class="{{ $isOnline ? 'online' : 'offline' }}"></span>
                                                    </p>

                                                    @if($ProductData['Product']->userId == $Chat['User']->id)
                                                        <p><b>Seller</b></p>
                                                        <?php
                                                        $rating = $Chat['User']->getActivity('seller');
                                                        ?>
                                                    @else
                                                        <p><b>Buyer</b></p>
                                                        <?php
                                                        $rating = $Chat['User']->getActivity('buyer');
                                                        ?>
                                                    @endif

                                                    <div class="profile-info-stars">
                                                        <ul class="stars_rating">
                                                            @for($i = 1; $i <= 5; $i++)
                                                                <li class="star_item {{ $i <= $rating ? 'active' : '' }}"></li>
                                                            @endfor
                                                        </ul>
                                                    </div>
                                                    @if($Chat['User']->about_me !== null)
                                                        <p class="profile-info-text">
                                                            {{ Illuminate\Support\Str::limit($Chat['User']->about_me, 110) }}
                                                        </p>
                                                    @endif
                                                    @if($Chat['User']->city !== null)
                                                        <p class="profile-info-text">
                                                            I'm at {{ $Chat['User']->city }}
                                                        </p>
                                                    @endif

                                                </div>

                                                @if($Chat['Product']['Product']->checkThisUser())
                                                    <div class="first_listed_popup" id="reservedConfirm-{{ $Chat['Product']['Product']->id }}">
                                                        <h3 id="reservedConfirmTitle-{{ $Chat['Product']['Product']->id }}"></h3>
                                                        <p id="reservedConfirmBody-{{ $Chat['Product']['Product']->id }}"></p>
                                                        <div class="btns_wrpr">
                                                            <a href="" class="btn light_bordr_btn close_modal_btn">{{ trans('Cancel') }}</a>
                                                            <a href="JavaScript:updateIsReserved('{{ $Chat['Product']['Product']->id }}')" class="btn def_btn">{{ trans('Confirm') }}</a>
                                                        </div>
                                                    </div>

                                                    <div style="padding-top: 5px;" align="center">
                                                        <div class="isReserved-{{ $Chat['Product']['Product']->id }}-{{ $Chat['User']->id }}">
                                                            @if($Chat['Product']['Product']->reserved_user_id == $Chat['User']->id)
                                                                <a class="btn def_btn more-most-liked-home" style="width: 222px;" href="JavaScript:openIsReservedDialog('{{ $Chat['Product']['Product']->id }}', 0, '{{ $Chat['User']->id }}')">{{trans('translation.reserved')}}</a>
                                                            @else
                                                                <a class="btn def_btn more-most-liked-home" style="width: 222px;" href="JavaScript:openIsReservedDialog('{{ $Chat['Product']['Product']->id }}', 1, '{{ $Chat['User']->id }}')">{{trans('translation.reserve')}}</a>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    @if($Chat['Product']['Product']->adsStatus != "sold")
                                                        <div style="padding-top: 5px;" align="center">
                                                            <button class="btn def_btn more-most-liked-home sell-item" style="width: 222px;"
                                                                    data-info="<?= htmlspecialchars(json_encode($info), ENT_QUOTES);?>"
                                                                    data-ads_id="{{ $Chat['Product']['Product']->id }}"
                                                                    data-buyer_id="{{ $Chat['User']->id }}">
                                                                Confirm Sale
                                                            </button>
                                                        </div>
                                                    @endif
                                                @endif
                                            </div>
                                        @endif
                                        @php $cntr++; @endphp
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </section>
            </div>
        @endif
    </div>
</div>

@section('bottom-footer')
    <script type="text/javascript">

        let isReserved = null;
        let lastReservedUserId = null;

        function openIsReservedDialog(id, value, userId)
        {
            if(value){
                $("#reservedConfirmTitle-" + id).html('<?php echo e(trans("Reserve this item")); ?>');
                $("#reservedConfirmBody-" + id).html('<?php echo e(trans("By clicking on 'Reserve', a notification will be sent to the buyer and others will no longer be able to submit offers for the reserved Gem.")); ?>');
            }else{
                $("#reservedConfirmTitle-" + id).html('<?php echo e(trans("Unreserve this item.")); ?>');
                $("#reservedConfirmBody-" + id).html('<?php echo e(trans("This item won't be shown as a reserved item anymore.")); ?>');
            }
            isReserved = value;
            lastReservedUserId = userId;
            $.fancybox.open( $("#reservedConfirm-" + id));
        }

        function updateIsReserved(id){
            $.ajax({
                type: "POST",
                url: 'update-add/' + id,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: ({ "reserved_user_id": isReserved ? lastReservedUserId : null}),
                success: function(data) {
                    if(data.success){
                        console.log(".sub-user-item-"+id+"-"+lastReservedUserId);
                        if(isReserved){
                            $(".sub-user-item-"+id).css('background-color', 'white');
                            $(".sub-user-item-"+id+"-"+lastReservedUserId).css('background-color', '#fb815d');
                            $('.isReserved-' + id + '-'+ lastReservedUserId).html('<a class="btn def_btn more-most-liked-home" style="width: 222px;" href="JavaScript:openIsReservedDialog('+ id +', 0, '+ lastReservedUserId +')"><?php echo e(trans('translation.reserved')); ?></a>');
                        }else{
                            $('.isReserved-' + id + '-'+ lastReservedUserId).html('<a class="btn def_btn more-most-liked-home" style="width: 222px;" href="JavaScript:openIsReservedDialog('+ id +', 1, '+ lastReservedUserId +')"><?php echo e(trans('translation.reserve')); ?></a>');
                            $(".sub-user-item-"+id).css('background-color', 'white');
                        }
                    }
                },
                error: function() {
                    alert('<?php echo e(trans('translation.errors.ads_update')); ?>');
                }
            });
            $.fancybox.close();
        }
    </script>
@endsection

@include("site.inc.notification")
@include("site.inc.footer")

<script type="text/javascript">
    $(document).ready(function () {
        @if(request('product_id'))
        $('.product-id-item-{{ request('product_id') }}').trigger('click');
        @endif
    });
</script>