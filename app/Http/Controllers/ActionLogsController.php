<?php

namespace App\Http\Controllers;

use App\Models\CustomerContact;
use App\Models\Like;
use App\Models\MessageStatus;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ActionLogsController extends Controller
{

    //viewCount list
    public function viewCount()
    {
        $actionLogs = Product::orderBy('id', 'desc')
            ->paginate(5);

        //total message count
        $countMessage = CustomerContact::groupBy('user_id')
            ->select('user_id', DB::raw('count(*) as count'))
            ->orderBy('user_id', 'desc')
            ->where('status', 0)
            ->get();
        $message = MessageStatus::where('status', false)
            ->where('user_id', Auth::user()->id)->get();
        return view('admin.actionLogs.viewList', compact('actionLogs', 'countMessage', 'message'));
    }

    //likeCount list
    public function likeCount()
    {
        $likeCount = Like::select('likes.*', 'customers.name as customer_name', 'products.name as product_name', 'products.image as product_image')
            ->leftJoin('customers', 'customers.id', 'likes.user_id')
            ->leftJoin('products', 'products.id', 'likes.product_id')
            ->orderBy('id', 'desc')
            ->paginate(5);

        //total message count
        $countMessage = CustomerContact::groupBy('user_id')
            ->select('user_id', DB::raw('count(*) as count'))
            ->orderBy('user_id', 'desc')
            ->where('status', 0)
            ->get();
        $message = MessageStatus::where('status', false)
            ->where('user_id', Auth::user()->id)->get();
        return view('admin.actionLogs.likeList', compact('likeCount', 'countMessage', 'message'));
    }

    //income list
    public function incomeList()
    {
        $orders = Order::orderBy('id', 'desc')
            ->paginate(5);
        //total message count
        $countMessage = CustomerContact::groupBy('user_id')
            ->select('user_id', DB::raw('count(*) as count'))
            ->orderBy('user_id', 'desc')
            ->where('status', 0)
            ->get();
        $message = MessageStatus::where('status', false)
            ->where('user_id', Auth::user()->id)->get();
        return view('admin.actionLogs.incomeList', compact('orders', 'countMessage', 'message'));
    }

}
