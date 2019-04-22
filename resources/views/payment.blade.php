@extends('layouts.main') 

@push('styles')
@endpush

@section('content')
<div class="well well-sm">
  <h3>Amount: {{ $currency.' '.$amount_formated }}</h3>
</div>
<form action="{{ route('payment-result') }}" class="paymentWidgets" data-brands="VISA MASTER MADA"></form>
@endsection
 
@push('scripts')
  @if (env('APP_DEBUG'))
  <script src="https://test.oppwa.com/v1/paymentWidgets.js?checkoutId={{ $checkoutId }}"></script>
  @else
  <script src="https://oppwa.com/v1/paymentWidgets.js?checkoutId={{ $checkoutId }}"></script>
  @endif
@endpush