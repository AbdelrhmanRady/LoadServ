@extends("layouts.app")
@section("title") Orders Page @endsection
@section("Body")
<style>
.list-group{

position: absolute;
left: 0;
width: 20%;
}
</style>
<div class="row" style="padding-bottom:50px">
    <div class="col-3" style="padding-left:50px">
      <div class="list-group" id="list-tab" role="tablist">
        <a class="list-group-item list-group-item-action" id="list-home-list"  href="{{route("profile.index")}}" role="tab" aria-controls="list-home">User Info</a>
        <a class="list-group-item list-group-item-action active " id="list-messages-list"  role="tab" aria-controls="list-messages">Orders</a>
        
      </div>
    </div>
    <div class="col-9" style="padding-top:100px">
      <div class="tab-content" id="nav-tabContent">
        
        <div class="tab-pane fade show active" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">
  
          
            <div class="container">
                <div class="row">
                  <div class="col-md-12">
                    <table class="table table-striped table-hover" style="border: 1px solid black">
                      <thead class="thead-dark">
                        <tr>
                          <th scope="col">Order ID</th>
                          <th scope="col">Order Price</th>
                          <th scope="col">Order Date</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>
                                <a href="{{route("profile.ordersShow",$order->order_id)}}">
                                    <strong>{{$order->order_id}}</strong><br>
                                </a>
                            </td>
                            <td>{{$order->totalPrice}} L.E</td>
                            <td>{{$order->created_at}}</td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
  
  
        </div>
        
      </div>
    </div>
  </div>
  
@endsection
