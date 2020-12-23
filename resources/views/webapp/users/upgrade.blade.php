@extends('layouts.argon.dashboard')

@section('title', 'Upgrade')

@section('content')
<div id="paypal-button-container"></div>
@endsection

@section('scripts')
<script
src="https://www.paypal.com/sdk/js?client-id=AeNwUQA-mvG0mc2EdNR4HueO60Jj8HpQaGeXdLWNJNq1w5M-txV4Yn9mDRHma9WEEspItoK3tjtGLpS0"> // Required. Replace SB_CLIENT_ID with your sandbox client ID.
</script>

<script>
  paypal.Buttons({
    createOrder: function(data, actions) {
      // This function sets up the details of the transaction, including the amount and line item details.
      return actions.order.create({
        purchase_units: [{
          amount: {
            value: '0.01'
          }
        }]
      });
    }
  }).render('#paypal-button-container');
</script>
@endsection
