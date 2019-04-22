<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>RSOS 2019</title>

    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700,900" rel="stylesheet">

    <!-- Bootstrap -->
    <link type="text/css" rel="stylesheet" href="{{ url('css/bootstrap.min.css') }}" />

    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="{{ url('css/font-awesome.min.css') }}">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="row p-5">
                            <div class="col-md-6">
                                <img src="{{ url('img/site-logo.png') }}">
                            </div>

                            <div class="col-md-6 text-right">
                                <p class="font-weight-bold mb-1">Invoice #{{ $order->id }}</p>
                                <p class="text-muted">{{ $order->created_at->format('j M, Y') }}</p>
                            </div>
                        </div>

                        <hr class="my-5">

                        <div class="row pb-5 p-5">
                            <div class="col-md-6">
                                <p class="font-weight-bold mb-4">Client Information</p>
                                <p class="mb-1">{{ sprintf('%s, %s', $order->passport->last_name, $order->passport->first_name) }}</p>
                                <p>{{ $order->passport->work_place }}</p>
                                <p class="mb-1">{{ $order->passport->country }}</p>
                                <p class="mb-1">{{ $order->passport->mobile_no }}</p>
                            </div>

                            <div class="col-md-6 text-right">
                                <p class="font-weight-bold mb-4">Payment Details</p>
                                <p class="mb-1"><span class="text-muted">VAT ID: </span> {{ env('VAT_ID') }}</p>
                                <p class="mb-1"><span class="text-muted">Payment Type: </span> Online</p>
                                <p class="mb-1"><span class="text-muted">Card: </span> ****{{ $order->payment->card_last_4 }}</p>
                                <p class="mb-1"><span class="text-muted">Card Older: </span> {{ $order->payment->card_holder }}</p>
                            </div>
                        </div>

                        <div class="row p-5">
                            <div class="col-md-12">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="border-0 text-uppercase small font-weight-bold">#</th>
                                            <th class="border-0 text-uppercase small font-weight-bold">Item</th>
                                            <th class="border-0 text-uppercase small font-weight-bold">Description</th>
                                            <th class="border-0 text-uppercase small font-weight-bold">Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->items as $item)
                                        <tr>
                                            <td>{{ $loop->index }}</td>
                                            <td>{{ title_case($item->item_type) }}</td>
                                            <td>{{ $item->item_name }}</td>
                                            <td>SAR {{ $item->item_price }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="d-flex flex-row-reverse bg-dark text-white p-4">
                            <div class="py-3 px-5 text-right">
                                <div class="mb-2">Grand Total</div>
                                <div class="h2 font-weight-light">SAR {{ $order->subtotal }}</div>
                            </div>

                            <div class="py-3 px-5 text-right">
                                <div class="mb-2">Vat</div>
                                <div class="h2 font-weight-light">SAR {{ $order->subtotal * env('VAT') }}</div>
                            </div>

                            <div class="py-3 px-5 text-right">
                                <div class="mb-2">Sub - Total amount</div>
                                <div class="h2 font-weight-light">SAR {{ $order->amount }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-light mt-5 mb-5 text-center small">
            <span class="copyright">Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | RSOS</span>
        </div>
    </div>


    <!-- jQuery Plugins -->
    <script src="{{ url('js/jquery.min.js') }}"></script>
    <script src="{{ url('js/bootstrap.min.js') }}"></script>
</body>

</html>