@include("site.inc.header")

<section class="s-checkout">
    <div class="container">
        <div class="title-box">
            <h1>Wallet cash out</h1>
        </div>

        <h2>Choose your payouts method</h2>

        <div class="purchase-box">
            <div class="left">
                <div class="purchase-item">

                    <div class="tabs">
                        <ul class="tabs-nav">
                            <li class="tab-active"><a href="#tab-1">Card</a></li>
                            <li class=""><a href="#tab-2">PayPal</a></li>
                        </ul>
                        <div class="tabs-stage-payment">
                            <div id="tab-1">
                                <div class="checkout_body checkout_card_info" style="">
                                    <div class="item_row checkout_header">
                                        <p><b>Only a debit card can be used for payouts.</b></p><br>
                                        <p>We use a 256-bit SSL encryption to protect your payment information</p>
                                        <form action="#" class="form-payout-card">
                                            <input type="hidden" name="_token" value="{{ @csrf_token() }}">
                                            <input type="hidden" name="amount" value="{{ request()->amount }}">

                                            <div class="inputs_flex">
                                                <div class="item">
                                                    <label>Card number</label>
                                                    <input type="text" class="text_input" data-mask="0000 0000 0000 0000" name="card_number" placeholder="16 digits" required>
                                                    <span class="error_input_text"></span>
                                                </div>
                                                <div class="item">
                                                    <label>Expiry date</label>
                                                    <div class="double_input">
                                                        <div class="input_item">
                                                            <input type="text" name="card_month" data-mask="00" class="text_input" placeholder="MM" required>
                                                            <span class="error_input_text"></span>
                                                        </div>
                                                        <div class="input_item">
                                                            <input type="text" name="card_year" data-mask="00" class="text_input" placeholder="YY" required>
                                                            <span class="error_input_text"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="item">
                                                    <label>CVC/CVV</label>
                                                    <div class="cvv">
                                                        <div class="input_item">
                                                            <input type="text" name="card_cvv" class="text_input" data-mask="0000" placeholder="3 or 4 digits" required>
                                                            <span class="error_input_text"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="inputs_flex">
                                                <div class="item">
                                                    <label>First & Last Name</label>
                                                    <div class="double_input">
                                                        <div class="input_item">
                                                            <input type="text" name="first_name" class="text_input" placeholder="First Name" required>
                                                            <span class="error_input_text"></span>
                                                        </div>
                                                        <div class="input_item">
                                                            <input type="text" name="last_name" class="text_input" placeholder="Last Name" required>
                                                            <span class="error_input_text"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="item">
                                                    <label>Date of birth</label>
                                                    <div class="cvv">
                                                        <div class="input_item">
                                                            <input type="text" name="date_birth" class="text_input" data-mask="00/00/0000" placeholder="DD/MM/YYYY" required>
                                                            <span class="error_input_text"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="submit" class="btn complete_purchase" style="margin-top: 25px;" value="Submit Payout">
                                        </form>
                                    </div>
                                </div>

                            </div>
                            <div id="tab-2" style="display: none;">
                                <form action="{{ route('payout_pay_pal') }}" method="post" class="form-payout-paypal">
                                    <input type="hidden" name="_token" value="{{ @csrf_token() }}">
                                    <input type="hidden" name="amount" value="{{ request()->amount }}">

                                    <div class="item" style="position: relative">
                                        <label>Email</label>
                                        <input type="email" class="text_input" name="email" placeholder="Receiver Email">
                                        <span class="error_input_text"></span>
                                    </div>

                                    <input type="submit" class="btn complete_purchase" style="margin-top: 25px;" value="Payout PayPal">
                                </form>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="purchase-item purchase-sidebar">
                    <div class="top">
                        <h4>Items</h4>
                        <ul>
                            <li>
                                <span>Order</span>
                                <span>$40.70</span>
                            </li>
                        </ul>
                    </div>
                    <div class="bottom">
                        <div class="total">
                            <span>Total</span>
                            <span>$40.70</span>
                        </div>
                    </div>
                </div>
            </div>

            <aside class="purchase-sidebar">
                <div class="top">
                    <h4>Items</h4>
                    <ul>
                        <li>
                            <span>Wallet cash out</span>
                            <span>${{ number_format(request()->amount, 2) }}</span>
                        </li>
                    </ul>
                </div>
                <div class="bottom">
                    <div class="total">
                        <span>Total</span>
                        <span>${{ number_format(request()->amount, 2) }}</span>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</section>

@section('bottom-footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="/mooimarkt/js/payments.js"></script>
@endsection

@include("site.inc.footer")

