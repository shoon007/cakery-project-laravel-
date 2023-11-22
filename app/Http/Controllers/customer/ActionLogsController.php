<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\ActionLogs;
use App\Models\Cart;
use App\Models\Like;
use App\Models\Order;
use App\Models\OrderList;
use App\Models\Product;
use Illuminate\Http\Request;

class ActionLogsController extends Controller
{

    //set action log (view count)
    public function setActionLog(Request $request)
    {
        $data = [
            'user_id' => $request->user_id,
            'post_id' => $request->post_id,
        ];
        ActionLogs::create($data);

        Product::where('id', $request->post_id)->increment('view_count');

        $postData = ActionLogs::where('post_id', $request->post_id)->get();
        return response()->json([
            'post' => $postData,

        ]);
    }

    //send order
    public function productOrder(Request $request)
    {
        $data = [
            'user_id' => $request->user_id,
            'product_id' => $request->post_id,
            'quantity' => $request->quantity,
        ];
        $cart = Cart::create($data);
        return response()->json([
            'status' => $cart,
        ]);
    }

    //counting cart quantity
    public function cartCount(Request $request)
    {
        $cart = Cart::where('user_id', $request->user_id)->get();
        return response()->json([
            'count' => $cart,
        ]);
    }

    //orderlists
    public function cartLists(Request $request)
    {

        $cart = Cart::select('carts.*', 'products.name as product_name', 'products.image as product_image', 'products.price as product_price')
            ->leftJoin('products', 'products.id', 'carts.product_id')
            ->where('user_id', $request->user_id)
            ->orderBy('id', 'desc')
            ->get();
        return response()->json([
            'cart' => $cart,
        ]);
    }

    //increase product
    public function productQuantity(Request $request)
    {
        $data = [
            'user_id' => $request->user_id,
            'quantity' => $request->qty,
        ];
        Cart::where('id', $request->cart_id)->update($data);
        return response()->json([
            'status' => $data,
        ]);
    }

    //product delete
    public function productDelete(Request $request)
    {
        Cart::where('id', $request->cart_id)->delete();
        return response()->json([
            'status' => 'success',
        ]);
    }

    //clear cart
    public function clearCart(Request $request)
    {
        Cart::where('user_id', $request->user_id)->delete();
        return response()->json([
            'status' => 'success',
        ]);
    }

    //cart checkout
    public function checkout(Request $request)
    {
        //inserting for orderlist
        for ($i = 0; $i < count($request->cart_list); $i++) {
            $data = [
                'user_id' => $request->cart_list[$i]['user_id'],
                'product_id' => $request->cart_list[$i]['product_id'],
                'quantity' => $request->cart_list[$i]['quantity'],
                'total_price' => $request->cart_list[$i]['product_price'] * $request->cart_list[$i]['quantity'],
                'order_code' => $request->order_code,
            ];
            OrderList::create($data);

        }
        //inserting for order

        $data = [
            'user_id' => $request->user_id,
            'order_code' => $request->order_code,
            'total_price' => $request->total_price,
        ];
        Order::create($data);
        return response()->json([
            'orderSuccess' => 'We have received your order and it is currently being processed by our team. We kindly request you to wait for a confirmation email from us.',
        ]);
    }
    //cart history
    public function cartHistory(Request $request)
    {
        $order = Order::where('user_id', $request->user_id)->orderBy('id', 'desc')->get();

        return response()->json([
            'history' => $order,
        ]);
    }

    //add like
    public function addLike(Request $request)
    {
        $data = [
            'user_id' => $request->user_id,
            'product_id' => $request->post_id,

        ];

        Like::create($data);
        return response()->json([
            'likeData' => 'success',
        ]);

    }

    //remove like
    public function removeLike(Request $request)
    {
        Like::where('user_id', $request->user_id)->where('product_id', $request->post_id)->delete();
        return response()->json([
            'likeData' => 'success',
        ]);
    }

    //post like checked or not
    public function postLike(Request $request)
    {

        $data = Like::where('user_id', $request->user_id)->where('product_id', $request->post_id)->first();
        if (isset($data)) {
            return response()->json([
                'status' => true,
            ]);
        } else {
            return response()->json([
                'status' => false,
            ]);
        }
    }
    //like count
    public function likeCount(Request $request)
    {
        $likeCount = Like::where('product_id', $request->post_id)->get();
        return response()->json([
            'likeCount' => $likeCount,
        ]);
    }

    //all post like
    public function allPostLike(Request $request)
    {

        $likeCount = Like::where('product_id', $request->post_id)->get();
        return response()->json([
            'likeCount' => $likeCount,
        ]);
    }

}
