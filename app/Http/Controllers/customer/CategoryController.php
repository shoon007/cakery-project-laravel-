<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //get all category
    public function getAllCategory()
    {
        $category = Category::orderBy('id', 'desc')->get();
        return response()->json([
            'category' => $category,
        ]);
    }
    //search category
    public function categorySearch(Request $request)
    {

        $searchCategory = Product::where('category_id', $request->key)->orderBy('id', 'desc')->get();

        return response()->json([
            'result' => $searchCategory,
        ]);
    }

    //search product name
    public function productSearch(Request $request)
    {
        $productSearch = Product::select('products.*', 'categories.name as category_name')
            ->leftJoin('categories', 'categories.id', 'products.category_id')
            ->orWhere('products.name', 'like', '%' . $request->key . '%')
            ->orWhere('categories.name', 'like', '%' . $request->key . '%')
            ->orderBy('categories.id','desc')
            ->orderBy('products.id','desc')
            ->get();
        return response()->json([
            'result' => $productSearch,
        ]);
    }
}
