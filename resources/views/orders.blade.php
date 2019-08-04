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
              <th>Subtotal <small>({{ env('CURRENCY') }})</small></th>
              <th>VAT  <small>({{ env('CURRENCY') }})</small></th>
              <th>Amount  <small>({{ env('CURRENCY') }})</small></th>
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