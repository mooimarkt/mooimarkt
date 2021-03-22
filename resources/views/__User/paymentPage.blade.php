@extends('layouts.app')

@section('content')

<div class="container" style="background:#e0e0e0;">

  <div class="row justify-content-center" style="margin-top:10px;padding:10px;">
    @if (\Session::has('success'))
        <div class="alert alert-success">
            <ul>
                <li>{!! \Session::get('success') !!}</li>
                {!! \Session::forget('success') !!}
            </ul>
        </div>
    @endif
    @if(\Session::has('error'))
      <div class="alert alert-danger">
        <ul>
          <li>{!! \Session::get('error') !!}</li>
            {!! \Session::forget('error') !!}
          </ul>
      </div>
    @endif
    <div class=" col-md-12"><h2>Payment</h2></div>
  </div>
  <div class="row" style="margin-bottom: 10px;">
    <div class="col-lg-offset-2 col-md-offset-2 col-lg-8 col-md-8 col-xs-12 text-center" style="background:white;font-size: 20px;padding-top: 10px;padding-bottom: 10px;">
      Have a Cash voucher code? Apply Now!
      <form id="applyVoucherCodeForm" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="input-group">
          <input id="voucherCode" type="text" name="voucherCode" class="form-control" value="{{$voucherCode}}" placeholder="Enter Your Voucher Code" />
          <span class="input-group-btn">
            <button id="applyVoucherCode" class="btn btn-primary" type="button">Apply</button>
          </span>
         </div>
       </form>

    </div>
  </div>
  <div class="row">

    <div class="col-lg-offset-2 col-md-offset-2 col-lg-8 col-md-8 col-xs-12" style="background:white;">
      <?php $total_price = 0; ?>
      @foreach($transactionData as $data)
      
      <div class="col-md-10 col-xs-8" style="font-size:20px;margin-top:5px;margin-bottom:5px;">
        {{$data["title"]}}
      </div>
      <div class="col-md-2 col-xs-4" style="font-size:16px;margin-top:10px;margin-bottom:10px;text-align:right;">
        € {{number_format($data["price"],2)}}
      </div>
      <div class="col-md-10 col-xs-9" style="padding-left:25px;font-size:14px;margin-top:0px;margin-bottom:5px;">
        {!!$data["description"]!!}
      </div>
      
      @endforeach
      @if($totalDiscount)
      <div class="col-md-10 col-xs-8" style="font-size:20px;margin-top:10px;margin-bottom:10px;">
        Discount
      </div>
      <div class="col-md-2 col-xs-4" style="font-size:16px;margin-top:10px;margin-bottom:10px;text-align:right;">
        -€ 
        {{number_format($totalDiscount,2)}}
      </div>
      @endif
      <div class="col-md-8 col-xs-7" style=""></div>
      <div class="col-md-4 col-xs-5" style="font-size:16px;margin-top:10px;margin-bottom:10px;text-align:right;border-top:1px solid grey;padding-top:10px;">
        Total : € {{number_format($totalPrice,2)}}
      </div>
    </div>
    <div class="col-md-12 col-xs-12 text-center" style="margin-top:20px;margin-bottom:20px;">
      <form class="form-horizontal" method="POST" id="payment-form" role="form" action="{!! URL::route('addmoney.paypal') !!}" >
        {{ csrf_field() }}
        <input id="amount" type="hidden" class="form-control" name="amount" value="{{ $total_price }}" >
        <input id="amount" type="hidden" class="form-control" name="transactionId" value="{{$transactionId}}" >
        <input id="amount" type="hidden" class="form-control" name="item_name" value="EURO" >
        @if($totalPrice)
        <button type="submit" id="pay_with_paypal" style="width:228;height:auto;border:none;background:#e0e0e0;" >
          <img src="{{url("/img/paypal-btn.png")}}">
        </button>
        @else
        <button type="submit" id="pay_with_paypal" class="btn btn-danger btn-block place-ads-buttons uppercase-text" style="font-size:20px;width:228px;height:auto;border:none;margin:auto;" >
          Publish
        </button>
        @endif
      </form>
    </div>
    <div class="col-lg-offset-3 col-md-offset-3 col-lg-6 col-md-6 col-xs-12 text-center" style="font-size:10px;margin-top:5px;">
        By choosing a payment option, you agree to the B4MX <a style="color:#0af;" href="{{url('getTermsOfUse')}}">TERMS OF USE</a>.<br>
        Read about our <a style="color:#0af;" href="{{url('getPricingPage')}}">PRICING</a>.
    </div>
    <div class="col-md-12 col-xs-12 text-left" style="background-color:white;font-size:15px;padding-top:10px;">
      <a style="color:#0af;" href="{{url('getActiveAdsPage?btnMethod=draft')}}">Cancel Payment</a>
        
    </div>
  </div>
</div>


<script >
  $(document).ready(function() {
    $('#voucherCode').keydown(function (e){

      if(e.keyCode == 13){
        e.preventDefault();
        apply_voucher_code();
      }
    });
    $("#applyVoucherCode").click(function(event) {
      apply_voucher_code();

    });
  });

  function apply_voucher_code(){
    var formData = $("#applyVoucherCodeForm").serialize();
    $.post(location.protocol + '//' + location.host+"/applyVoucherCode", formData, function(r){
      console.log("r");
      console.log(r);
      if(r.status == "error"){
        alert(r.msg);
        window.location.reload();
      }else{
        alert(r.msg);
        window.location.reload();
      }
      //window.location.reload();

    },'json').fail(function(e){
      console.log("failed");
      console.log(e);
    });
  }
</script>
@endsection
