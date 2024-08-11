@extends("layouts.app")
@section("title") Orders Page @endsection
@section("Body")
<style>
    .checkout-container {
        max-width: 800px;
        margin: auto;
        padding: 20px;
    }
    .order-summary {
        margin-top: 20px;
    }
    .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
</style>
<div class="container checkout-container">
    <h2>Order Summary</h2>
        <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Size</th>
                <th scope="col">Price</th>
                <th scope="col">Quantity</th>
              </tr>
            </thead>
            <tbody>
                @php $count = 1 @endphp
                @foreach($order_items as $order_item)
                    <tr>
                        <th scope="row">{{$count}}</th>
                        <td>{{$order_item->itemName}}</td>
                        <td>{{$order_item->itemSize ?? ""}}</td>
                        <td>{{$order_item->itemPrice}}</td>
                        <td>{{$order_item->itemQuantity}}</td>
                        @php $count+=1 @endphp
                    </tr>
                @endforeach
            </tbody>
          </table>
        <h4 id="Total">Total Price: {{$total_price}} L.E</h4>



@endsection