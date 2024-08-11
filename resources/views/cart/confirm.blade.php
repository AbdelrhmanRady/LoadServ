
    <style>
        .success-container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
        }
    </style>
@extends("layouts.app")
@section("title") Order Confirm @endsection
@section("Body")
<div class="container success-container">
    <h2>Payment Successful</h2>
    <div class="alert alert-success" role="alert">
        <h4 class="alert-heading">Thank you for your purchase!</h4>
        <p>Your order has been successfully processed. Below are the details of your order:</p>
        <hr>
        {{-- Add order id when you create Transaction database --}}
        <p>Order ID:{{$order_id}}</p>
        <h3>Order Summary</h3>
        <ul class="list-group">
            @foreach ($cart as $item)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{$item["productName"]}} {{$item["size"] ?? " "}} x{{$item["quantity"]}}
                    <span>{{$item["quantity"] * $item["price"]}} L.E</span>
                </li>
            @endforeach
        </ul>
        <div class="mt-3">
            @php $totalPrice = 0  @endphp
            @foreach($cart as $item)
            @php $totalPrice += $item["price"] * $item["quantity"]  @endphp
            @endforeach
            
            <h4>Total: {{$totalPrice}} L.E</h4>
        </div>
    </div>
</div>
@endsection
