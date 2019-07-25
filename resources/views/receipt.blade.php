@extends('layouts.main')

@push('styles') 
@endpush 

@section('content')
  @includeWhen(env('APP_DEBUG'), 'demo')

  @if ($code == $success_value)
    <div class="alert alert-success" role="alert">
        <h3>Your payment proccessed successfully! Please, print your receipt from <a target="_blank" href="{{ route('order-print', ['order' => $order]) }}">here</a></h3>
        <a href="{{ route('home') }}"><h4 class="text-uppercase text-muted font-italic text-secondary">back to your dashboard</h4></a>
    </div>
  @else
    <div class="alert alert-warning" role="alert">
        <strong>{{ $code }}</strong> {{ title_case($description) }}.
    </div>
    <a class="btn btn-link" href="{{ route('cart') }}">Go Back to Cart</a>
  @endif
@endsection

@push('scripts') 
@endpush