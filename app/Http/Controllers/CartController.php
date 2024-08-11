<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function store(Request $request)
    {
        $product = Product::where("productId", $request->productID)->first();
        $cart = Session::get('cart', []);

        if ($request->has('size') && !$request->has('samePriceForAllSizes')) {
            $priceForSize = ProductSize::where("productId", $request->productID)
                ->where("size", $request->size)
                ->first()
                ->price;
        } else {
            $priceForSize = $product->price;
        }
        
        $cartItem = [
            'productName' => $product->productName,
            'mainCategory' => $product->mainCategory,
            'subCategory' => $product->subCategory,
            'price' => $priceForSize,
            'stock' => $product->stock,
            'size' => $request->size ?? null,  
            'quantity' => $request->quantity,
            'image' => $product->image
        ];
        // dd($cartItem);
        
        $found = false;
        if ($request->has('size')) {
            foreach ($cart as &$item) {
                if ($item['productName'] == $product->productName && $item['size'] == $request->size) {
                    $item['quantity'] += $request->quantity;  
                    $found = true;
                    break;
                }
            }
        }
        else{
            foreach ($cart as &$item) {
                if ($item['productName'] == $product->productName) {
                    $item['quantity'] += $request->quantity;  
                    $found = true;
                    break;
                }
            }
        }

        
        if (!$found) {
            $cart[] = $cartItem;
        }
        
        Session::put('cart', $cart);

        return to_route("home.index");
    }

    public function index()
    {
        $cart = Session::get('cart', []);
        // dd($cart);
        return view('cart.index', ['cartItems'=> $cart]);
    }

    public function destroy($product){
        $keyToRemove = 'productName';
        $valueToRemove = $product;

        $cart = Session::get('cart', []);
        
        $array = array_filter($cart, function($item) use ($keyToRemove, $valueToRemove) {
            return $item[$keyToRemove] !== $valueToRemove;
        });
        Session::put('cart', $array);
        return to_route("cart.index");
    }

    public function checkout(Request $request){
        $cart = Session::get('cart', []);
        $items = $request->all()["products"];
        $addresses = Address::where("user_id",Auth::user()["id"])->get();

        for($i = 0; $i < count($cart); ++$i){
            if($cart[$i]["quantity"] != $items[$i]["quantity"]){
                $cart[$i]["quantity"] = $items[$i]["quantity"];
            }
        }
        Session::put('cart', $cart);
        return view("cart.checkout",["items"=>$items,"addresses"=> $addresses]);
    }
    
    public function confirm(){
        $cart = Session::get('cart', []);
        
        
        $total_price = 0;
        foreach($cart as $item){
            Product::where('productName', $item["productName"])->update([
                'stock' => DB::raw('stock - ' . (int)$item['quantity']),
            ]);
            $total_price += intval($item['quantity']) * intval($item['price']);
        }
        
        $user = User::find(Auth::user()['id']);

        $order = $user->orders()->create(
            [
                'totalPrice' => $total_price,
            ]
            );

        foreach($cart as $item){
            $order->orderItems()->create([
                'itemName' => $item["productName"],
                'itemQuantity' => $item["quantity"],
                'itemPrice' => $item["price"],
                'itemSize' => $item["size"],

            ]);
        }
        Session::forget('cart');
        return view("cart.confirm",["cart"=> $cart,"order_id"=> $order->id]);
    }
    public function delete(){
        Session::forget('cart');
        return to_route('home.index');
    }


}
