<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{

    public function adminIndex(){
        if(Auth::user()["isAdmin"]){
            return view("profile.adminIndex");
        }

    }
    
    public function index(){
        $user = Auth::user();
        return view("profile.index",["user"=>$user]);

    }
    public function ordersIndex(){
        $orders = Order::where("user_id",Auth::user()["id"])->get();
        return view("profile.ordersIndex",["orders"=>$orders]);
    }

    public function ordersShow($orderID){
        $order_items = OrderItem::where("order_id",$orderID)->get();
        $order = Order::where("order_id",$orderID)->first();
        return view("profile.ordersShow",["order_items"=>$order_items,"total_price"=> $order->totalPrice]);
    }

    public function updateAddress(Request $request, $id){
    $request->validate([
        'address' => 'required|string|max:255',
    ]);
    $address = Address::find($id);
    $address->address = $request->input('address');
    $address->save();

    return redirect()->back()->with('status', 'Address updated successfully.');
}

public function addAddress(Request $request){
    $request->validate([
        'address' => 'required|string|max:255',
    ]);

    $user = auth()->user();
    Address::create([
        'user_id' => $user->id,
        'address' => $request->input('address'),
    ]);

    return redirect()->back()->with('status', 'Address added successfully.');
}

public function removeAddress($id)
{
    $address = Address::find($id);
    $address->delete();

    return redirect()->back()->with('status', 'Address removed successfully.');
}

public function updateName(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
    ]);

    
    $user = User::find(Auth::user()->id);
    $user->update([
        'name'=> $request->input('name'),
    ]);

    return redirect()->back()->with('status', 'Name updated successfully.');
}
public function updateEmail(Request $request)
{
    $request->validate([
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
    ]);

    
    $user = User::find(Auth::user()->id);
    $user->update([
        'email'=> $request->input('email'),
    ]);

    return redirect()->back()->with('status', 'Email updated successfully.');
}
public function updatePhone(Request $request)
{
    $request->validate([
        'phone' => ['required', 'string','min:11','max:11','unique:users'],
    ]);
    $user = User::find(Auth::user()->id);
    $user->update([
        'phone'=> $request->input('phone'),
    ]);

    return redirect()->back()->with('status', 'Email updated successfully.');
}

public function updateBirthday(Request $request)
{
    $request->validate([
        'birthday' => 'required|date',
    ]);



    $user = User::find(Auth::user()->id);
    $user->update([
        'birthday' => $request->input('birthday')
    ]);

    return redirect()->back()->with('status', 'Birthday updated successfully.');
}

public function updateGender(Request $request)
{
    $request->validate([
        'gender' => 'required|string|in:male,female',
    ]);

    $user = User::find(Auth::user()->id);
    $user->update([
        'gender'=> $request->input('gender'),
    ]);
    return redirect()->back()->with('status', 'Gender updated successfully.');
}

}
