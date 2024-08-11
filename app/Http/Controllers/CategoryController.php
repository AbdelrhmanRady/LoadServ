<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{

    public function mainIndex(){

        $categories = Category::all();
        return view("Categories.mainIndex",["categories"=>$categories]);
    }

    public function subShow($categoryName,$subCategoryName){
        $products = Product::where("mainCategory",$categoryName)->where("subCategory",$subCategoryName)->get();
        return view("Categories.subShow",["products"=>$products,"categoryName"=>$categoryName,"subCategoryName"=>$subCategoryName]);
    }

    public function mainShow($categoryName){
        $category = Category::where("categoryName",$categoryName)->first();
        $products = Product::where("mainCategory",$categoryName)->get();
        return view("Categories.mainShow",["category"=>$category,"products"=>$products]);

    }

    public function create(){
        if(Auth::user()["isAdmin"]){
            return view("categories.create");
        }
    }
    public function store(Request $request){
        $request->validate([
            'Category_Name' => 'required|string|max:255',
            'sub_categories' => 'required|array',
            'sub_categories.*' => 'string|max:255',
        ]);
        if(Auth::user()["isAdmin"]){
            $data = $request->all();
            $category = new Category();
            $category->categoryName = $data["Category_Name"];
            $category->subCategories = $data["sub_categories"];
            $category->save();   
            return to_route("home.index");
        }
    }
}
