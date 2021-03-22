@include("site.inc.header")

<section class="s-checkout">
    <div class="container">
        <div class="title-box">

            <ul class="biling-tabs">
                <li class="active" data-toggle_id="wallet">
                    <h1>Wallet top up</h1>
                </li>
                <li data-toggle_id="transactions">
                    <h1>Transactions</h1>
                </li>
            </ul>
        </div>

        <div class="tab-content">
            <div class="tab-pane active" id="wallet">

                <div class="amount-items">
                    <div class="amount-item active">
                        <div class="currency">€</div>
                        <div class="value">2</div>
                    </div>
                    <div class="amount-item">
                        <div class="currency">€</div>
                        <div class="value">5</div>
                    </div>
                    <div class="amount-item">
                        <div class="currency">€</div>
                        <div class="value">10</div>
                    </div>
                </div>
                <div>
                    <form action="{{ route('payment_mollie') }}" method="post">
                        <input type="hidden" name="_token" value="{{ @csrf_token() }}">
                        <input type="hidden" name="amount" value="{{ request()->amount }}">
                        <input type="submit" class="btn complete_purchase" style="margin: 0 auto; text-transform:none;" value="Pay Now">
                    </form>
                </div>

                <!-- <h2>Choose your payment method</h2> -->
                <?php /*
                <div class="purchase-box">
                    <div class="left">
                        <div class="purchase-item">

                            



                            
                            <div class="tabs">
                                <ul class="tabs-nav">
                                    <li class="tab-active"><a href="#tab-0">Mollie</a></li>
                                    <!-- <li class=""><a href="#tab-1">Card</a></li> -->
                                    <li class=""><a href="#tab-2">PayPal</a></li>
                                </ul>
                                <div class="tabs-stage-payment">
                                    <div id="tab-0" >
                                        <form action="{{ route('payment_mollie') }}" method="post">
                                            <input type="hidden" name="_token" value="{{ @csrf_token() }}">
                                            <input type="hidden" name="amount" value="{{ request()->amount }}">

                                            <input type="submit" class="btn complete_purchase" style="margin: 0 auto;" value="Pay Mollie">
                                        </form>
                                    </div>
                                    <div id="tab-1" style="display: none;">
                                        <div class="checkout_body checkout_card_info" style="">
                                            <div class="item_row checkout_header">
                                                <p>We use a 256-bit SSL encryption to protect your payment information</p>
                                                <form action="#" class="form-payment-card">
                                                    <input type="hidden" name="_token" value="{{ @csrf_token() }}">
                                                    <input type="hidden" name="amount" value="{{ request()->amount }}">

                                                    <div class="inputs_flex">
                                                        <div class="item">
                                                            <label>Card number</label>
                                                            <input type="text" class="text_input" data-mask="0000 0000 0000 0000" name="card_number" placeholder="16 digits" required>
                                                            <span class="error_input_text"></span>
                                                        </div>
                                                        <div class="item">
                                                            <label>Name on card</label>
                                                            <input type="text" class="text_input" name="card_name" placeholder="Name on card" required>
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

                                                    <input type="submit" class="btn complete_purchase" style="margin-top: 25px;" value="Submit Payment">
                                                </form>
                                            </div>
                                        </div>

                                    </div>
                                    
                                    <div id="tab-2" style="display: none;">
                                        <form action="{{ route('payment_pay_pal') }}" method="post">
                                            <input type="hidden" name="_token" value="{{ @csrf_token() }}">
                                            <input type="hidden" name="amount" value="{{ request()->amount }}">

                                            <input type="submit" class="btn complete_purchase" style="margin: 0 auto;" value="Pay PayPal">
                                        </form>
                                    </div>
                                </div>
                            </div>
                            

                        </div>
                    </div>
                </div>
                */ ?>
            </div>
            <div class="tab-pane" id="transactions">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Payment Method</th>
                        <th scope="col">Item</th>
                        <th scope="col">Status</th>
                        <th scope="col">Timestamp</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($transactions as $transaction)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ number_format($transaction->total, 2).' '.$transaction->currency }}</td>
                            <td>{{ $transaction->method }}</td>
                            <td>{{ ucfirst($transaction->type).' '.number_format($transaction->total, 2).' '.$transaction->currency }}</td>
                            <td>{{ ucwords(str_replace(['-', '_'], ' ', $transaction->status)) }} @if($transaction->status == 'no_register')<small>(Please register PayPal account (email: <b>{{ $transaction->email }}</b>))</small>@endif</td>
                            <td>{{ $transaction->created_at }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>


    </div>
</section>

@section('bottom-footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="/mooimarkt/js/payments.js"></script>

    <script>
        setAmount();

        $('.biling-tabs li').on('click', function () {
            let element = $(this);

            $('.biling-tabs li').removeClass('active');
            element.addClass('active');

            $('.tab-pane').removeClass('active');

            $.each($('.tab-pane'), function (i, el) {
                if ($(el).attr('id') == element.data('toggle_id')){
                    console.log(el);
                    $(el).addClass('active');
                }
            });

        });

        $('.amount-item').on('click', function () {
            $('.amount-item').removeClass('active');
            $(this).addClass('active');

            setAmount();
        });

        function setAmount() {
            $('input[name="amount"]').val($('.amount-item.active').find('.value').text());
        }
    </script>
@endsection

@include("site.inc.footer")