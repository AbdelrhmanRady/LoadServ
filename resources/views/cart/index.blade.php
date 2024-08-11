@extends("layouts.app")
@section("title") Cart Page @endsection
@section("Body")
<link rel="stylesheet" href="{{ asset('css/Cart.css') }}">
<form action="{{route("cart.checkout")}}" method="POST">
    @csrf
<div class="shopping-cart">
    <!-- Title -->
    <div class="title">
      Shopping Bag
    </div>
    
    @php $count = 0 @endphp

    @foreach($cartItems as $item)
    
    <div class="item">
        <input class="product_name" type="text" hidden name="products[{{$count}}][productName]" value="{{$item["productName"]}}">
        <input type="text" hidden name="products[{{$count}}][price]" value="{{$item["price"]}}">
        <input type="text" hidden name="products[{{$count}}][size]" value="{{$item["size"]}}">
        <div class="buttons">
            <a href="{{route("cart.destroy",$item["productName"])}}"><img src="{{asset('images/delete-icn.svg') }}" class="delete"  alt="" /> </a>
        </div>
        <div class="image">
            <img src="{{asset('images/'. $item["image"]) }}" alt="" style="width: 85px;" />
        </div>

        <div class="description">
            <span>{{$item["productName"]}}</span>
            <span>{{$item["mainCategory"]}}</span>
            <span>{{$item["subCategory"]}}</span>
            @if($item["size"] != null)
                <span>Size: {{$item["size"]}}</span>
            @endif
        </div>

        <div class="quantity">
            <p hidden > {{$item["stock"]}} </p>
            <button class="minus-btn cartbtn" type="button" name="button">
                <img src="{{asset('images/minus.svg') }}" alt="" />
            </button>
            <input class="quantity_inputs" type="text" name="products[{{$count}}][quantity]" value="{{$item["quantity"]}}">
            <button class="plus-btn cartbtn" type="button" name="button">  
                <img src="{{asset('images/plus.svg') }}" alt="" />
            </button>

        </div>

        <div class="total-price">{{$item["price"]}}</div>
    </div>
    @php $count = $count + 1 @endphp
    @endforeach
    <div class="title justify-content-center align-content-center d-flex h-75" style="border:  0">
        @if(count($cartItems) == 0)
        <span >No Products In Cart</span>
        @else
        <span >Total Cost: <input id="totalCost" name="totalCost" type="text" value="0" disabled style="text-align:center"></span>
        <div class="title justify-content-end d-flex h-75 border-0">
            <button style="order:2 ; margin:0 5px;" class="btn btn-primary">Checkout</button>
        </form>
        <form action="{{route("cart.delete")}}" method="POST">
            @csrf
            @method("DELETE")
            <button style="order:1" class="btn btn-danger">Cancel</button>
        </form>
        </div>   
        @endif 
    </div>    
</div>

<script>
    $("document").ready(function(){

        var cartItems = @json($cartItems);

        function changePrice(){
            var totalCost = 0
    
            for(item of cartItems){
                
                totalCost = totalCost + parseInt(item["quantity"]) * parseInt(item["price"])
            }
            $("#totalCost").val(totalCost)
        }

        changePrice()
        $(".minus-btn").on("click",function(){
            var input = $(this).siblings("input");
            var value = parseInt(input.val())
            if(value <=1) return
            value -=1
            input.val(value)
            var productNameInput = $(this).closest('.item').find('.product_name').val();
            var item = cartItems.filter(item => item["productName"] == productNameInput)[0]
            item["quantity"] = value
            changePrice()
        })
        $(".plus-btn").on("click",function(){
            var stock = parseInt($(this).siblings("p")[0].outerText);
            var input = $(this).siblings("input");
            var value = parseInt(input.val())
            value +=1
            if(value>=stock) value = stock
            input.val(value)
            var productNameInput = $(this).closest('.item').find('.product_name').val();
            var item = cartItems.filter(item => item["productName"] == productNameInput)[0]
            item["quantity"] = value
            changePrice()
        })


        
    })

</script>

@endsection
