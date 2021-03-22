@include("site.inc.header")

<section class="s-checkout">
    <div class="container">
        <div class="title-box">
            <h1>Wallet History</h1>
        </div>

        <div class="purchase-box">
            <div class="purchase-item">
                <h2>History Transactions</h2>

                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Method</th>
                        <th scope="col">Type</th>
                        <th scope="col">Status</th>
                        <th scope="col">Currency</th>
                        <th scope="col">Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $transaction)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $transaction->method }}</td>
                                <td>{{ ucfirst($transaction->type) }}</td>
                                <td>{{ ucwords(str_replace(['-', '_'], ' ', $transaction->status)) }} @if($transaction->status == 'no_register')<small>(Please register PayPal account (email: <b>{{ $transaction->email }}</b>))</small>@endif</td>
                                <td>{{ $transaction->currency }}</td>
                                <td>{{ number_format($transaction->total, 2) }}</td>
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
@endsection

@include("site.inc.footer")