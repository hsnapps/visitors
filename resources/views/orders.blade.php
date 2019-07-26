@extends('layouts.main')

@push('styles') 
<style>
    th{text-transform: capitalize;}
</style>
@endpush 

@section('content')
    @include('components.back')

  <table class="table table-striped table-inverse table-responsive">
      <thead class="thead-default">
          <tr>
              <th></th>
              <th>Date</th>
              <th>Subtotal</th>
              <th>VAT</th>
              <th>Amount</th>
              <th>status</th>
          </tr>
          </thead>
          <tbody>
                @each('components.orders_list', $orders, 'order', 'components.orders_empty')
          </tbody>
  </table>

  {{ $orders->links() }}
@endsection

@push('scripts') 
@endpush