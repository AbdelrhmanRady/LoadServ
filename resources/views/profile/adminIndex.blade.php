@extends("layouts.app")
@section("title") Admin dashboard @endsection
@section("Body")
<link rel="stylesheet" href="{{ asset('css/Admin.css') }}">


    <div class="AddListing-form">
        <a href="{{route("home.create")}}" style="text-decoration: none;color:black">
            <button  id="submitButton">Add Products</button>
        </a>
        <a href="{{route("categories.create")}}" style="text-decoration: none;color:black">
            <button  id="submitButton">Add Categories</button>
        </a>
    </div>

@endsection