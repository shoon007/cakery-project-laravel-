<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class PostController extends Controller
{
//get all post
    public function getAllPost()
    {
        $post = Product::orderBy('id', 'desc')->get();
        return response()->json([
            'post' => $post,
        ]);
    }

//get all best seller product
    public function bestSeller()
    {
        $bestSellerProduct = Product::orderBy('view_count', 'desc')->take(10)->get();
        return response()->json([
            'result' => $bestSellerProduct,
        ]);
    }

//post details
    public function postDetails(Request $request)
    {
        $id = $request->postId;
        $post = Product::where('id', $id)->first();
        return response()->json([
            'post' => $post,
        ]);
    }
}
