@extends('layouts.main')

@push('styles')
<script src="https://test.oppwa.com/v1/paymentWidgets.js?checkoutId={{ $checkoutId }}"></script>
@endpush
 
@section('content')

<form action="{{ route('receipt') }}" class="paymentWidgets" data-brands="VISA MASTER MADA VISAELECTRON VISADEBIT "></form>

@endsection

@push('scripts') 

@endpush