@extends("layouts.app")
@section("title") Main Categories Page @endsection
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
    <br>
    <h1 style="text-align: center"> Main Categories </h1>

    <div class="home-products py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-start">
                @forEach($categories as $category)
                <a href="{{route("category.mainShow",$category->categoryName)}}" style="border:  2px solid black; text-align:center; padding:80px 0 80px 0;color:black;text-decoration: none; margin: 20px 50px">
                {{$category->categoryName}}
                </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection