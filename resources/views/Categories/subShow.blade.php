@extends("layouts.app")
@section("title") Sub Category @endsection
@section("Body")

<style>
    .home-welcome-one {
        color: white;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
    }
    .home-welcome-two {
        background-color: #e3f2fd; /* Light blue background */
        padding: 2rem 1rem;
    }
    .home-welcome-two h3 {
        margin-top: 1rem;
    }
    .home-products {
        padding: 3rem 0;
    }
</style>

<div class="HomeContainer">
    <div class="home-welcome-one py-5 bg-dark">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">LoadServ</h1>
                <p class="lead fw-normal mb-0">YOUR ONE STOP WORLDWIDE MARKET</p>
            </div>
        </div>
    </div>

    <section class="home-welcome-two text-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div>
                        <FontAwesomeIcon icon={faHome} size="7x"/>
                        <h3 class="h5">Shop from home</h3>
                        <p class="text-muted">If you don't feel like going outside, use our site to browse through items and fill up your cart!</p>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div>
                        <Mouse size={115} />
                        <h3 class="h5">One Click Away</h3>
                        <p class="text-muted">Order your items with one click. Save time. What are you waiting for!</p>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div>
                        <FontAwesomeIcon icon={faShieldAlt} size="7x" />
                        <h3 class="h5">Buy with confidence</h3>
                        <p class="text-muted">Shop safely. Everything is secure and your data is encrypted.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <h1 style="text-align: center">{{$categoryName}}, {{$subCategoryName}} Products </h1>

    <div class="home-products py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-start">
                @forEach($products as $product)
                <div class="col mb-5">
                    <div class="card h-100">
                        <img class="productIMG" src="{{ asset('images/' . $product->image) }}" alt="Product Image" />
                        <div class="card-body p-1">
                            <div class="text-center">
                                <h4 class="card-title text-center fw-bolder">{{$product->productName}}</h4>
                                <p class = "home-product-description">Category : {{$product->mainCategory}}</p>
                                <p class = "home-product-description">Sub Category : {{$product->subCategory}}</p>
                            </div>
                        </div>
                        <div class="card-body p-2">
                            <div class="text-center">
                                <h6 class="fw-holder">Avaliable Quantity: {{$product->stock}}</h6>
                                <h6>Price: {{$product->price}} L.E. </h6>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <div class="text-center">
                                <p class = "home-product-description">{{$product->description}}</p>
                            </div>
                        </div>
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="home-product-card row">
                                    <a href="{{route("home.show",$product->productId)}}" class="btn btn-primary view-product  mt-auto mb-2" >View Product</a>
                                    @if(Auth::user() && Auth::user()["isAdmin"])
                                    <a href="{{route("home.edit",$product->productId)}}" class="btn btn-warning view-product  mt-auto" >Edit Product</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
</div>
@endsection