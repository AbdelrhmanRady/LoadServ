<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = Product::all();
        foreach ($products as $product) {
            if(strlen($product->description) > 50) {
                $product->description = substr($product->description,0,80) . ".....";
            }
        }
        return view('home.index',['products'=> $products]);
    }
    public function search(Request $request)
    {
        $products = Product::where('productName', 'LIKE', "%{$request->productName}%")->get();
        
        foreach ($products as $product) {
            if(strlen($product->description) > 50) {
                $product->description = substr($product->description,0,80) . ".....";
            }
        }
        return view('home.index',['products'=> $products]);
    }

    public function edit($productID)
    {
        if(Auth::user()["isAdmin"]){
            $product = Product::where("productId", $productID)->first();
            $sizes = ProductSize::where("productId", $productID)->get();
            $categories = Category::all();
            
            return view('home.edit',['product'=> $product,'sizes'=>$sizes,'categories'=> $categories]);
        }
    }

    public function update(Request $request,$productID){
        if(Auth::user()["isAdmin"]){
            $product = Product::where('productId', $productID)->first();

            if (!$product) {
                return response()->json(['message' => 'Product not found.'], 404);
            }
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images'), $imageName);
                $product->image = $imageName;
            }
            
            
            $product->productName = $request->productName;
            $product->mainCategory = $request->mainCategory;
            $product->subCategory = $request->subCategory;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->hasSizes = $request->hasSizes ? true : false; 
            $product->samePriceForAllSizes = $request->samePriceForAllSizes ? true : false; 
            $product->stock = $request->stock;
            
            if ($request->hasSizes) {
                $sizes = $request->sizes;
                
                $product->sizes()->delete();
            
                
                foreach ($sizes as $size) {
                    if ($request->input('samePriceForAllSizes')) {
                        ProductSize::create([
                            'productId' => $product->productId,
                            'size' => $size['size']
                        ]);
                    } else {
                        ProductSize::create([
                            'productId' => $product->productId,
                            'size' => $size['size'],
                            'price' => $size['price']
                        ]);
                    }
                }
            } else {
            
                $product->sizes()->delete();
            }
            
            $product->save();
            
            return redirect()->route('home.index', $productID);
    }
        
    }

    public function show($productID)
    {
        $product = Product::where("productId",$productID)->first();
        $sizeObjects = ProductSize::where("productId",$productID)->get();
        return view('home.show',['product'=> $product,"sizeObjects"=>$sizeObjects]);
    }

    public function create()
    {
        if(Auth::user()["isAdmin"]){
            $data = Category::all();
            return view('home.create',["categories"=>$data]);
        }
    }

    public function store(Request $request)
    {
        if(Auth::user()["isAdmin"]){
            $request->validate([
                'productName' => 'required|string|max:255',
                'mainCategory' => 'required|string|max:255',
                'subCategory' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'hasSizes' => 'nullable|boolean',
                'samePriceForAllSizes' => 'nullable|boolean',
                'sizes' => 'nullable|array',
                'sizes.*.size' => 'required_with:sizes|string|max:255',
                'sizes.*.price' => 'required_if:samePriceForAllSizes,0|nullable|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            
            $data = $request->except(['sizes']);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images'), $imageName);
                $data['image'] = $imageName; // Store the image file name
            }
            $product = Product::create($data);
            
            if ($request->input('hasSizes')) {
                foreach ($request->input('sizes', []) as $sizeData) {
                    if ($request->input('samePriceForAllSizes')) {
                        ProductSize::create([
                            'productId' => $product->productId,
                            'size' => $sizeData['size']
                        ]);
                    } else {
                        ProductSize::create([
                            'productId' => $product->productId,
                            'size' => $sizeData['size'],
                            'price' => $sizeData['price']
                        ]);
                    }
                }
            }
            
            return to_route("home.index");
    }
    }
}
