@extends("layouts.app")
@section("title") Product @endsection
@section("Body")
<link rel="stylesheet" href="{{ asset('css/Product.css') }}">

<style>
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

</style>

<div class="productBody">
    <form action="{{route("cart.store")}}" method="POST" >
        @csrf
        <input name="productID" type="text" hidden value="{{$product->productId}}">
        
        <section class="py-5 productFrame">
            <div class="container px-4 px-lg-5 my-5 product-container">
                <div class="row gx-4 gx-lg-5 align-items-center">
                    <div class="col-md-6 mb-5 mb-md-0">
                        <img class="productIMG" src="{{ asset('images/' . $product->image) }}" alt="Product Image" />
                    </div>
                    <div class="col-md-6">
                        <div class="small mb-1">
                            <h5>Category: {{$product->mainCategory}}</h5>
                        </div>
                        <h1 class="display-5 fw-bolder">{{$product->productName}}</h1>
                        <div class="fs-5 mb-5">
                            <span id="product-price">{{$product->price}} L.E.</span>
                        </div>
                        <p class="lead">{{$product->description}}</p>
                        @if($product->hasSizes)
                            @if($product->samePriceForAllSizes)
                            <input name="samePriceForAllSizes" type="text" hidden value="1">
                            @endif
                            
                            <div class="mb-3">
                                <label for="size" class="form-label">Select Size</label>
                                <select name="size" id="size" class="form-select">
                                    @foreach($sizeObjects as $sizeObject)
                                        <option value="{{ $sizeObject->size }}">{{ $sizeObject->size }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <div class="d-flex align-items-center">
                            @if($product->stock>0)
                            <div class="quantity-selector">
                                <button id="decrease" type="button" class="btn btn-light quantity-btn">-</button>
                                <input value="1"  name="quantity" id="quantity" type="number" class="quantity-input">
                                <button id="increase" type="button" class="btn btn-light quantity-btn">+</button>
                            </div>
                            <button type="submit" class="btn btn-warning btn-long add-to-cart">
                                <i class="fa fa-shopping-cart"></i> Add to cart
                            </button>
                            @else
                            <h6 class="fw-holder">Out of Stock!</h6>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            @if($product->hasSizes && !$product->samePriceForAllSizes)
                var sizeObjects = @json($sizeObjects);

                var selectedSize = $('#size').val();
                var selectedPrice = sizeObjects.filter(object=>(object.size==selectedSize))[0].price
                $('#product-price').text(`${selectedPrice} L.E.`);
                $('#size').on('change',function() {
                    var selectedSize = $('#size').val();
                    var selectedPrice = sizeObjects.filter(object=>(object.size==selectedSize))[0].price
                    $('#product-price').text(`${selectedPrice} L.E.`);
                });
            @endif
            $("#increase").on("click",function(){
                var product = @json($product);
                var stock = product.stock
                var currentValue = $('#quantity').val();
                newvalue = parseInt(currentValue) + 1
                if(newvalue>=stock) newvalue = stock
                $('#quantity').val(newvalue.toString());
            })
            $("#decrease").on("click",function(){
                var currentValue = $('#quantity').val();
                if(currentValue==1)return;
                $('#quantity').val((parseInt(currentValue)-1).toString());
            })
            $("#quantity").on("input", function() {
                var productObject = @json($product);
                var stock = productObject.stock;
                console.log(stock)

                var value = $(this).val();
                
                value = value.replace(/[^0-9]/g, '');

                var numericValue = parseInt(value);

                if (isNaN(numericValue)) {
                    $(this).val(0);
                } else {
                    if (numericValue < 0) {
                        $(this).val(0);
                    } else if (numericValue > stock) {
                        $(this).val(stock);
                    } else {
                        $(this).val(numericValue);
                    }
                }
    });
        </script>        
</div>
@endsection
