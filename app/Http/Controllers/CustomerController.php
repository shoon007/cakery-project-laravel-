<?php

namespace App\Http\Controllers;

use App\Models\ChatInfo;
use App\Models\Customer;
use App\Models\CustomerContact;
use App\Models\MessageStatus;
use App\Models\Order;
use App\Models\OrderList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    //CUSTOMER LIST
    public function customerList()
    {
        $customerList = Customer::when(request('key'), function ($query) {
            $query->orWhere('name', 'like', '%' . request('key') . '%')
                ->orWhere('email', 'like', '%' . request('key') . '%');
        })
            ->orderBy('id', 'desc')
            ->paginate(5);
        $customerList->appends(request()->all());

        $customerCount = Customer::get();
        //total message count
        $countMessage = CustomerContact::groupBy('user_id')
            ->select('user_id', DB::raw('count(*) as count'))
            ->orderBy('user_id', 'desc')
            ->where('status', 0)
            ->get();
        $message = MessageStatus::where('status', false)
            ->where('user_id', Auth::user()->id)->get();
        return view('admin.customerLists.list', compact('customerList', 'customerCount', 'countMessage', 'message'));
    }

    //customer order list
    public function orderList($id, $orderCode)
    {
        $orderInfo = Order::select('orders.*', 'customers.name as name')
            ->leftjoin('customers', 'customers.id', 'orders.user_id')
            ->where('orders.id', $id)->first();

        $orderList = OrderList::select('order_lists.*', 'products.name as product_name', 'products.image as product_image')
            ->leftJoin('products', 'products.id', 'order_lists.product_id')
            ->where('order_lists.order_code', $orderCode)
            ->orderBy('order_lists.id', 'desc')
            ->paginate(3);

        //total message count
        $countMessage = CustomerContact::groupBy('user_id')
            ->select('user_id', DB::raw('count(*) as count'))
            ->orderBy('user_id', 'desc')
            ->where('status', 0)
            ->get();
        $message = MessageStatus::where('status', false)
            ->where('user_id', Auth::user()->id)->get();
        return view('admin.order.orderList', compact('orderList', 'orderInfo', 'countMessage', 'message'));
    }

    //customer contact page
    public function contactPage(Request $request, $id)
    {
        $message = MessageStatus::where('status', false)
            ->where('user_id', Auth::user()->id)->get();
        $groupName = ChatInfo::get();

        $customerMessage = CustomerContact::select('customer_contacts.*', 'customers.image as image')
            ->leftJoin('customers', 'customers.id', '=', 'customer_contacts.user_id')
            ->whereIn('customer_contacts.id', function ($query) {
                $query->selectRaw('MAX(id)')
                    ->from('customer_contacts')
                    ->groupBy('user_id');
            })
            ->orderBy('customer_contacts.id', 'desc')
            ->get();

        $countMessage = CustomerContact::groupBy('user_id')
            ->select('user_id', DB::raw('count(*) as count'))
            ->orderBy('user_id', 'desc')
            ->where('status', 0)
            ->get();

        $customerContact = CustomerContact::where('user_id', $id)->orderBy('id', 'desc')->paginate(5);

        $customerInfo = Customer::where('id', $id)->first();

        $message = MessageStatus::where('status', false)
            ->where('user_id', Auth::user()->id)->get();
        return view('admin.message.customerContact', compact('message', 'groupName', 'customerMessage', 'countMessage', 'customerContact', 'customerInfo', 'message'));
    }

    //delete customer message
    public function deleteMessage($id)
    {
        CustomerContact::where('id', $id)->delete();
        return back();
    }

    //view customer message
    public function messageView($id)
    {
        $info = CustomerContact::select('customer_contacts.*', 'customers.image as image')
            ->leftJoin('customers', 'customers.id', 'customer_contacts.user_id')
            ->where('customer_contacts.id', $id)->first();

        CustomerContact::where('id', $id)->update([
            'status' => 1,
        ]);

        //total message count
        $countMessage = CustomerContact::groupBy('user_id')
            ->select('user_id', DB::raw('count(*) as count'))
            ->orderBy('user_id', 'desc')
            ->where('status', 0)
            ->get();
        $message = MessageStatus::where('status', false)
            ->where('user_id', Auth::user()->id)->get();
        return view('admin.message.customerMessage', compact('info', 'countMessage', 'message'));
    }
}
