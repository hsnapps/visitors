@push('styles') 
<link rel="stylesheet" href="{{ url('css/payment.css') }}">
@endpush 

<div class="container col-md-8 col-md-offset-2" style="margin-top: -20px;">
  <form class="form-horizontal" role="form" action="{{ route('cc-pay') }}" method="POST">
    <div class="well well-sm">
      <h3>Amount: {{ $currency.' '.$amount_formated }}</h3>
    </div>

    <fieldset>
      <legend>Payment</legend>

      <!-- Card Type -->
      <div class="row">
        <div class="paymentWrap">
          <div class="btn-group paymentBtnGroup btn-group-justified" data-toggle="buttons">
            <label class="btn paymentMethod active">
              <div class="method visa"></div>
                <input type="radio" name="cardType" data-title="visa" value="VISA" checked> 
            </label>

            <label class="btn paymentMethod">
              <div class="method master-card"></div>
                <input type="radio" name="cardType" data-title="master card" value="MASTER"> 
            </label>

            <label class="btn paymentMethod">
              <div class="method mada"></div>
                <input type="radio" name="cardType" data-title="mada" value="MADA">
            </label>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-4 col-md-offset-4">
          <h4 class="text-center" id="card-type"></h4>
        </div>
      </div>

      <!-- Name on Card -->
      <div class="form-group">
        <label class="col-sm-3 control-label" for="card-holder-name">Name on Card</label>
        <div class="col-sm-9">
          <input type="text" class="form-control" name="card_holder_name" id="card-holder-name" placeholder="Card Holder's Name">
        </div>
      </div>

      <!-- Card Number -->
      <div class="form-group">
        <label class="col-sm-3 control-label" for="card-number">Card Number</label>
        <div class="col-sm-9">
          <input type="text" class="form-control" name="card_number" id="card-number" placeholder="Debit/Credit Card Number">
        </div>
      </div>

      <!-- Expiration Date -->
      <div class="form-group">
        <label class="col-sm-3 control-label" for="expiry-month">Expiration Date</label>
        <div class="col-sm-9">
          <div class="row">
            <div class="col-xs-3">
              <select class="form-control col-sm-2" name="expiry_month" id="expiry-month">
                  <option>Month</option>
                  @foreach ($months as $month)
                  <option value="{{ $loop->index + 1 }}">{{ $month }}</option>
                  @endforeach
              </select>
            </div>
            <div class="col-xs-3">
              <select class="form-control" name="expiry_year">
                    @foreach ($years as $year)
                    <option value="{{ $year }}">{{ $year }}</option>
                    @endforeach
                  </select>
            </div>
          </div>
        </div>
      </div>

      <!-- Card CVV -->
      <div class="form-group">
        <label class="col-sm-3 control-label" for="cvv">Card CVV</label>
        <div class="col-sm-3">
          <input type="text" class="form-control" maxlength="3" name="cvv" id="cvv" placeholder="Security Code">
        </div>
      </div>

      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-9">
          <button type="submit" class="btn btn-success">Pay Now</button>
        </div>
      </div>
    </fieldset>

    <input type="hidden" name="subtotal" value="{{ $subtotal }}">
    <input type="hidden" name="vat" value="{{ $vat }}">
    <input type="hidden" name="amount" value="{{ $amount }}">
    {{ csrf_field() }}
  </form>
</div>

@push('scripts')
<script>
  $('#card-type').text('VISA');

  $('[name="cardType"]').change(function(){
    $('#card-type').text($(this).data('title').toUpperCase());
  });

</script>

@endpush