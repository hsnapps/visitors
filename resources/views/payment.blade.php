@extends('layouts.main')

@push('styles') 
<link rel="stylesheet" href="{{ url('css/payment.css') }}">
@endpush 

@section('content')
  @include('components.credit_card', ['route' => 'pay'])
@endsection

@push('scripts') 
@endpush