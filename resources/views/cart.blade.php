@extends('layouts.main')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.3/css/uikit.min.css">
<style>
    th {text-transform: uppercase;}
    .btn {
        margin: 40px 0px;
        padding: 9px 39px;
    }
</style>
@endpush
 
@section('content')
<h1>CART</h1>
@if (auth()->user()->cart->count() > 0)
    <table class="uk-table uk-table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Item Type</th>
                <th>Item Name</th>
                <th>Starts On</th>
                <th>Duration <small>(Days)</small></th>
                <th>Price</th>
                <th></th>
            </tr>
        </thead>
        
        <tbody>
            @foreach (auth()->user()->cart as $item) 
            @php 
                $item_type = str_singular(title_case($item->item_type)) ;
                $subtotal = auth()->user()->cart()->sum('price');
                $vat = auth()->user()->cart()->sum('price') * env('VAT');
                $total = $subtotal + $vat;
            @endphp
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $item_type }}</td>
                <td>{{ $item->title }}</td>
                <td>{{ isset($item->starts_on) ? $item->starts_on->format('d/m/Y') : 'N/A' }}</td>
                <td>{{ $item->days }}</td>
                <td>${{ $item->price }}</td>
                <td>
                    <button class="uk-button uk-button-small uk-button-danger" type="button" onclick="document.getElementById('remove_{{ $item->id }}').submit();">
                        <span class="fa fa-trash"></span>
                    </button>

                    <form id="remove_{{ $item->id }}" action="{{ route('remove-course-from-cart') }}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $item->id }}">
                    </form>
                </td>
            </tr>
            @endforeach
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="uk-float-right">
                    <b>Subtotal</b><br/>
                    <b>VAT (5%)</b><br/>
                    <b>Total</b><br/>
                </td>
                <td>
                    ${{ $subtotal }}<br/>
                    ${{ $vat }}<br/>
                    ${{ $total }}<br/>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="">
        <button class="uk-float-right uk-button uk-button-xl uk-button-primary" type="button" onclick="document.getElementById('prepare-payment').submit();">
            <span class="fa fa-credit-card "></span> Pay Here
        </button>
        @include('back')
    </div>

    <form id="prepare-payment" action="{{ route('prepare-payment') }}" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="subtotal" value="{{ number_format($subtotal, 2, '.', ',') }}">    
        <input type="hidden" name="vat" value="{{ number_format($vat, 2) }}">
        <input type="hidden" name="amount" value="{{ number_format($total, 2) }}">
    </form>

@else
    @include('empty_cart')
@endif
@endsection

@push('scripts') 
<script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.3/js/uikit.min.js"></script>
@endpush