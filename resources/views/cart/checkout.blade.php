@extends("layouts.app")
@section("title") Checkout @endsection
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
    <h2>Checkout</h2>

    <form action="{{route("cart.confirm")}}" method="POST">
        @csrf
        <div class="mb-3">
            {{-- <label for="shippingAddress" class="form-label">Shipping Address</label>
            <input type="text" class="form-control" id="shippingAddress" name="shipping_address" required> --}}


            <label for="addressSelection" class="form-label">Shipping Address</label>
            <select class="form-control" id="addressSelection" required>
                <option value="" disabled selected>Select an address</option>
                @foreach($addresses as $address)
                    <option value="{{ $address->address }}">{{ $address->address }}</option>
                @endforeach
                <option value="new">Enter a new address</option>
            </select>

            <div id="newAddressContainer" style="display: none; margin-top: 15px;">
                <input type="text" class="form-control" id="newAddress" placeholder="Enter new address">
            </div>

            <label for="Credit" class="form-label">Credit Card No.</label>
            <input type="text" class="form-control" id="Credit" name="Credit" required>
            <label for="Exp" class="form-label">Exp</label>
            <input type="text" class="form-control" id="Exp" name="Exp" required>
            <label for="CCV" class="form-label">CCV</label>
            <input type="text" class="form-control" id="CCV" name="CCV" required>
        </div>
        <h3>Order Summary</h3>
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
                @foreach($items as $item)
                    <tr>
                        <th scope="row">1</th>
                        <td>{{$item["productName"]}}</td>
                        <td>{{$item["size"] ?? ""}}</td>
                        <td>{{$item["price"]}}</td>
                        <td>{{$item["quantity"]}}</td>
                    </tr>
                @endforeach
            </tbody>
          </table>
        <h4 id="Total">Total Price:</h4>
        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Complete Purchase</button>
        </div>
    </form>

    <script>
        $(document).ready(function(){
            var cartItems = @json($items);
            var totalCost = 0;
            for(item of cartItems){
                totalCost = totalCost + parseInt(item["quantity"]) * parseInt(item["price"]);
            }
            $("#Total")[0].outerHTML = "<h4 id=\"Total\">Total Price: "+ totalCost+ " L.E</h4>";

            function enforcePattern(element, pattern) {
                $(element).on('input', function() {
                    var value = $(this).val();
                    var regex = new RegExp(pattern);
                    if (!regex.test(value)) {
                        $(this).val(value.slice(0, -1));
                    }
                });
            }

            enforcePattern('#Credit', '^[0-9]{0,16}$');
            enforcePattern('#Exp', '^(0[1-9]|1[0-2])?/?([0-9]{0,2})?$');
            enforcePattern('#CCV', '^[0-9]{0,4}$');

            $('#addressSelection').change(function() {
                if ($(this).val() === 'new') {
                    $('#newAddressContainer').show();
                } else {
                    $('#newAddressContainer').hide();
                }
            });

            $('#checkoutForm').submit(function(event) {
                event.preventDefault();
                var selectedAddress = $('#addressSelection').val();
                if (selectedAddress === 'new') {
                    $('#shippingAddress').val($('#newAddress').val());
                } else {
                    $('#shippingAddress').val($('#addressSelection option:selected').text());
                }
                this.submit();
            });
        });
    </script>
@endsection