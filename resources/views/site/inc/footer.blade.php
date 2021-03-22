<div class="messages_sell_items_popup" id="messages_sell_items_popup">
    <h3 class="popup_title">Chose Item(s) to Sell</h3>
    <form action="">
        <div class="m_sell_items_wrpr">
            <label class="m_sell_item_container">
                <input type="checkbox" name="" id="" checked>
                <div class="m_sell_item">
                    <div class="img_wrpr">
                        <img src="/mooimarkt/img/store/p1.jpg" alt="">
                    </div>
                    <div class="item_text">
                        <h3 class="item_name">Plaint Blouse</h3>
                        <h4 class="item_prod">Zara</h4>
                        <span class="item_price">$9.99</span>
                    </div>
                </div>
            </label>
            <label class="m_sell_item_container">
                <input type="checkbox" name="" id="">
                <div class="m_sell_item">
                    <div class="img_wrpr">
                        <img src="/mooimarkt/img/store/p2.jpg" alt="">
                    </div>
                    <div class="item_text">
                        <h3 class="item_name">Basic Jeans</h3>
                        <h4 class="item_prod">Zara</h4>
                        <span class="item_price">$9.99</span>
                    </div>
                </div>
            </label>
            <label class="m_sell_item_container">
                <input type="checkbox" name="" id="">
                <div class="m_sell_item">
                    <div class="img_wrpr">
                        <img src="/mooimarkt/img/store/p3.jpg" alt="">
                    </div>
                    <div class="item_text">
                        <h3 class="item_name">Leather Jacket</h3>
                        <h4 class="item_prod">Zara</h4>
                        <span class="item_price">$9.99</span>
                    </div>
                </div>
            </label>
            <label class="m_sell_item_container">
                <input type="checkbox" name="" id="">
                <div class="m_sell_item">
                    <div class="img_wrpr">
                        <img src="/mooimarkt/img/store/p4.jpg" alt="">
                    </div>
                    <div class="item_text">
                        <h3 class="item_name">Warm Coat</h3>
                        <h4 class="item_prod">Zara</h4>
                        <span class="item_price">$9.99</span>
                    </div>
                </div>
            </label>
            <label class="m_sell_item_container">
                <input type="checkbox" name="" id="">
                <div class="m_sell_item">
                    <div class="img_wrpr">
                        <img src="/mooimarkt/img/store/p5.jpg" alt="">
                    </div>
                    <div class="item_text">
                        <h3 class="item_name">Warm Coat</h3>
                        <h4 class="item_prod">Zara</h4>
                        <span class="item_price">$9.99</span>
                    </div>
                </div>
            </label>
            <label class="m_sell_item_container">
                <input type="checkbox" name="" id="">
                <div class="m_sell_item">
                    <div class="img_wrpr">
                        <img src="/mooimarkt/img/store/p6.jpg" alt="">
                    </div>
                    <div class="item_text">
                        <h3 class="item_name">Basic T-shirt</h3>
                        <h4 class="item_prod">Zara</h4>
                        <span class="item_price">$9.99</span>
                    </div>
                </div>
            </label>
        </div>
    </form>
    <div class="popup_right_btn_wrpr">
        <a href="" class="btn light_bordr_btn close_modal_btn">Cancel</a>
        <a href="" class="btn def_btn messages_sell_items_next">Next Step</a>
    </div>
</div>

<div class="messages_sell_items_confirm_popup" id="messages_sell_items_confirm_popup">
    <h3 class="popup_title">{!! Language::lang('Confirm Selling') !!}</h3>
    <form class="confirm-selling-form" action="">
        <div class="m_sell_items_wrpr">
            <label class="m_sell_item_container">
                <input type="checkbox" name="" id="" checked disabled>
                <div class="m_sell_item">
                    <div class="img_wrpr">
                        <img src="/mooimarkt/img/store/p6.jpg" alt="">
                    </div>
                    <div class="item_text">
                        <h3 class="item_name">Plaint Blouse</h3>
                        <h4 class="item_prod">Zara</h4>
                        <span class="item_price">$9.99</span>
                    </div>
                </div>
            </label>
        </div>
        <div class="sell_items_confirm_middle">
            <div class="col">
                <span class="m_selected_confirm_text">Confirm that you selling <span>Plaint Blouse</span> to </span>
                <div class="m-selected-item">
                    <div class="img-wrap">
                        <img src="/mooimarkt/img/m-img-2.jpg" alt="">
                    </div>
                    <div class="m-item-info">
                        <div class="top">
                            <div class="login">silverfrog195</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="ratingActivitySell">
            <fieldset class="starability-basic">
                <input type="radio"
                       id="no-rate-basic-sale"
                       class="input-no-rate" name="rating"
                       value="0"
                       aria-label="No rating." required>

                <input type="radio" id="rate_sell_1" name="rating" value="1" autocomplete="off" required>
                <label for="rate_sell_1" title="Terrible">1 star</label>

                <input type="radio" id="rate_sell_2" name="rating" value="2" autocomplete="off" required>
                <label for="rate_sell_2" title="Not good">2 stars</label>

                <input type="radio" id="rate_sell_3" name="rating" value="3" autocomplete="off" required>
                <label for="rate_sell_3" title="Average">3 stars</label>

                <input type="radio" id="rate_sell_4" name="rating" value="4" autocomplete="off" required>
                <label for="rate_sell_4" title="Very good">4 stars</label>

                <input type="radio" id="rate_sell_5" name="rating" value="5" autocomplete="off" required>
                <label for="rate_sell_5" title="Amazing">5 stars</label>

                <span class="starability-focus-ring"></span>
            </fieldset>
            <div class="sell-item__seller-comment">
                <textarea class="text_input" name="seller_comment" maxlength="500" placeholder="Add comment"></textarea>
            </div>
        </div>

        <div class="popup_right_btn_wrpr">
            <span class="confirm_total_earning">{{ Language::lang('Total Earnings') }}: <span>$9.99</span></span>
            <a href="" class="btn light_bordr_btn close_modal_btn">{{ Language::lang('Cancel') }}</a>
            <button type="submit" class="btn def_btn">{{ Language::lang('Confirm') }}</button>
            <input type="hidden" name="ads_id">
            <input type="hidden" name="buyer_id">
        </div>
    </form>
</div>

<div class="first_listed_popup" id="first_listed_popup">
    <h3>{{ Language::lang('Make your ad First Listed') }}</h3>
    <p>
        {{ Language::lang('Confirm that you want to make') }}
        {{ Language::lang('First Listed. It will cost') }}
        <b>{{ App\Option::getCost("opt_pack_spotlight")['cost']}} {{ Language::lang(App\Option::getCost("opt_pack_spotlight")['currency'])  }}</b>.
    </p>
    <div class="btns_wrpr">
        <a href="" class="btn light_bordr_btn close_modal_btn">{{ Language::lang('Cancel') }}</a>
        <a href="" class="btn def_btn first_listed_confirm_btn">{{ Language::lang('Confirm') }}</a>
    </div>
</div>

<div class="messages_sell_items_confirm_popup" id="confirmSale">
    <h3 class="popup_title">Confirm Sale</h3>
    <div class="confirm_sale">
        <form id="confirmSaleForm" data-activity="">
            <div class="ratingActivitySale">
                <fieldset class="starability-basic">
                    <input type="radio"
                           id="no-rate-basic-sale"
                           class="input-no-rate" name="rating"
                           value="0"
                           aria-label="No rating." required>

                    <input type="radio" id="rate_sale_1" name="rating" value="1" autocomplete="off" required>
                    <label for="rate_sale_1" title="Terrible">1 star</label>

                    <input type="radio" id="rate_sale_2" name="rating" value="2" autocomplete="off" required>
                    <label for="rate_sale_2" title="Not good">2 stars</label>

                    <input type="radio" id="rate_sale_3" name="rating" value="3" autocomplete="off" required>
                    <label for="rate_sale_3" title="Average">3 stars</label>

                    <input type="radio" id="rate_sale_4" name="rating" value="4" autocomplete="off" required>
                    <label for="rate_sale_4" title="Very good">4 stars</label>

                    <input type="radio" id="rate_sale_5" name="rating" value="5" autocomplete="off" required>
                    <label for="rate_sale_5" title="Amazing">5 stars</label>

                    <span class="starability-focus-ring"></span>
                </fieldset>
            </div>
            <div>
                <textarea class="text_input" name="comment" maxlength="500" placeholder="Add comment"></textarea>
            </div>
        </form>
    </div>

    <div class="popup_right_btn_wrpr">
        <a href="#" class="btn light_bordr_btn close_modal_btn">Cancel</a>
        <button type="submit" form="confirmSaleForm" class="btn def_btn">Confirm</button>
    </div>
</div>

@yield('popup-blocks')

<a href="" class="scroll_to_top"></a>

<footer class="main-footer">
    <div class="container">
        <div class="ft-top">
            <nav class="ft-menu">
                <ul>
                    <li><a href="/how-it-works">{!! Language::lang('How it works?') !!}</a></li>
                    <li><a href="/terms-conditions">{!! Language::lang('Terms & Conditions') !!}</a></li>
                    <li><a href="/qa">{{ Language::lang('Q&A') }}</a></li>
                    <li><a href="/contact-administration"> {{ Language::lang('Contact Us') }}</a></li>
                </ul>
            </nav>
            <div class="ft-social">
                <ul class="social-items">
                    @if(!empty($optLinkFacebook))
                        <li>
                            <a href="{{ $optLinkFacebook }}" target="_blank" rel="nofollow noopener">
                                <?php include "mooimarkt/img/fb-icon.svg"; ?>
                            </a>
                        </li>
                    @endif
                    @if(!empty($optLinkInstagram))
                        <li>
                            <a href="{{ $optLinkInstagram }}" target="_blank" rel="nofollow noopener">
                                <?php include "mooimarkt/img/inst-icon.svg"; ?>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="copiright">© Mooimarkt {{ date('Y') }}. {!! Language::lang('all rights reserved.') !!} </div>
    </div>
</footer>

<script>
    (function () {
        window.authUserID = '{{ optional($authUser)->id ?? 0 }}';
    })();
</script>

<script src="/mooimarkt/assets/jquery/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script type="text/javascript" src="/mooimarkt/assets/fancybox/jquery.fancybox.min.js"></script>
<script type="text/javascript" src="/mooimarkt/assets/dropzone/dropzone.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

<script src="/js/fileupload/vendor/jquery.ui.widget.js"></script>
<script src="/js/fileupload/jquery.iframe-transport.js"></script>
<script src="/js/fileupload/jquery.fileupload.js"></script>

<script src="/mooimarkt/js/chat.js?v=11"></script>
<script src="/mooimarkt/js/common.js"></script>

<script src="/mooimarkt/js/common_anton.js?v=2"></script>
<script src="/mooimarkt/js/common_artur.js"></script>
<script src="/mooimarkt/js/v_script.js"></script>

<script src="/js/app.js"></script>
<script src="/mooimarkt/js/notifications.js"></script>

<script src="/mooimarkt/js/sell_ajax.js"></script>
<script src="/mooimarkt/js/custom.js"></script>

@yield('bottom-footer')

</body>
</html>