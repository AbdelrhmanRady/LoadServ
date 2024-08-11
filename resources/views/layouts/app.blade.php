{{-- <!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

           
    </div>
    @yield('Body')
</body>
</html> --}}


 <!DOCTYPE html>
<html>
<head>
    <title>@yield("title")</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://kit.fontawesome.com/9c10bb64f2.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


</head>

<style>
.cart-icon {
    position: relative;
}
  
.cart-badge {
    position: absolute;
    top: 10px;
    right: -15px;
    background-color: #f9aa33; /* Warm Orange */
    color: #ffffff;
    border-radius: 50%;
    padding: 3px 6px;
    font-size: 10px;
}
.log{
    text-decoration: none;
    color: black;
    margin-left: 0.5%
}
</style>

<body>
  <nav class="navbar navbar-expand-lg" style="background-color: #e3f2fd; margin-bottom:1px";>
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('home.index') }}">LoadServ</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end " id="navbarSupportedContent">
            <form method="POST" action="{{route("home.search")}}" class="d-flex mx-auto" role="search">
                @csrf
                <input name="productName" class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>

              <a href="{{route("cart.index")}}">
                  <div class="ml-3 cart-icon" style="margin-right:18px;">
                      <i class="fa-solid fa-cart-shopping"></i>
                      <span class="cart-badge">{{count(Session::get('cart', []))}}</span>
                    </div>
                </a>
                <a style="text-decoration:none" href="{{route("category.mainIndex")}}"> Main Categories </a>
                
                @guest
                <a class="log" href="{{ route('login') }}">{{ __('Login') }}</a>
                <a class="log" href="{{ route('register') }}">{{ __('Register') }}</a>
                @else
                <div class="User" style="margin-left:1%">
                    @if(Auth::user()["isAdmin"])
                    <a href="{{route("profile.adminIndex")}}" style="text-decoration: none;margin: 0 20px">Admin Dashboard </a>
                    @endif
                    <a href="{{route("profile.index")}}" style="text-decoration: none">
                
                        <i class="fa-solid fa-user"></i>
                        {{ Auth::user()->name }}
                    </a>
                </div>
                <a style="margin-left:50px" href="{{ route('logout') }}"onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
                @endif
            </div>
    </div>
</nav>
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
    @yield("Body")
</body>
</html> 

