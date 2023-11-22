<?php

namespace App\Http\Controllers;

use App\Models\ActionLogs;
use App\Models\CustomerContact;
use App\Models\Like;
use App\Models\MessageStatus;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{

    //ADMIN DASHBOARD
    public function dashboard()
    {

        //view count
        $view_count = ActionLogs::get();
        $viewCount = count($view_count);
        function intWithStyle($n)
        {
            if ($n < 1000) {
                return $n;
            }

            $suffix = ['', 'k', 'M', 'G', 'T', 'P', 'E', 'Z', 'Y'];
            $power = floor(log($n, 1000));
            return round($n / (1000 ** $power), 1, PHP_ROUND_HALF_EVEN) . $suffix[$power];
        }
        $formattedCount = intWithStyle($viewCount);

        //total income
        $totalIncome = DB::table('orders')->sum('total_price');
        $formattedPrice = number_format($totalIncome);

        //orders
        $orders = Order::select('orders.*', 'customers.name as customer_name')
            ->leftJoin('customers', 'customers.id', 'orders.user_id')
            ->orderBy('orders.id', 'desc')
            ->paginate(5);

        //customer messages
        $customers = CustomerContact::select('customer_contacts.*', 'customers.image as image')
            ->leftJoin('customers', 'customers.id', 'customer_contacts.user_id')
            ->orderBy('customer_contacts.id', 'desc')
            ->take(3)
            ->get();

        //count like
        $likeCount = Like::get();

        //total message count
        $countMessage = CustomerContact::groupBy('user_id')
            ->select('user_id', DB::raw('count(*) as count'))
            ->orderBy('user_id', 'desc')
            ->where('status', 0)
            ->get();

        $message = MessageStatus::where('status', false)
            ->where('user_id', Auth::user()->id)->get();
        //  dd($message->toArray());
        //  if()
        return view('admin.dashboard.dashboard', compact('formattedCount', 'formattedPrice', 'orders', 'customers', 'likeCount', 'countMessage', 'message'));
    }

    //MASTER LAYOUTS
    public function layouts()
    {
        //total message count
        $countMessage = CustomerContact::groupBy('user_id')
            ->select('user_id', DB::raw('count(*) as count'))
            ->orderBy('user_id', 'desc')
            ->where('status', 0)
            ->get();
        $message = MessageStatus::where('status', false)
            ->where('user_id', Auth::user()->id)->get();
        return view('admin.layouts.master', compact('countMessage', 'message'));
    }

    //CHANGE PASSWORD PAGE
    public function changePasswordPage()
    {
        //total message count
        $countMessage = CustomerContact::groupBy('user_id')
            ->select('user_id', DB::raw('count(*) as count'))
            ->orderBy('user_id', 'desc')
            ->where('status', 0)
            ->get();
        $message = MessageStatus::where('status', false)
            ->where('user_id', Auth::user()->id)->get();
        return view('admin.account.changePassword', compact('countMessage', 'message'));
    }

    //CHANGING PASSWORD
    public function changePassword(Request $request)
    {
        $this->passwordValidation($request);
        $userId = Auth::user()->id;
        $user = User::where('id', $userId)->first();
        $dbPassword = $user->password;
        //checking old password & database password matches
        if (Hash::check($request->oldPassword, $dbPassword)) {
            //storing new password in database
            $newPassword = [
                'password' => Hash::make($request->newPassword),
            ];
            User::where('id', $userId)->update($newPassword);
            return back()->with(['changeSuccess' => 'The password is successfully changed!']);
        }
        return back()->with(['notMatch' => 'The old password does not match!Try again...']);
    }

    //ACCOUNT DETAILS PAGE
    public function detailsPage()
    {
        //total message count
        $countMessage = CustomerContact::groupBy('user_id')
            ->select('user_id', DB::raw('count(*) as count'))
            ->orderBy('user_id', 'desc')
            ->where('status', 0)
            ->get();
        $message = MessageStatus::where('status', false)
            ->where('user_id', Auth::user()->id)->get();
        $user = User::where('id', Auth::user()->id)->first();
        return view('admin.account.details', compact('user', 'countMessage', 'message'));
    }

    //ACCOUNT EDIT PAGE
    public function editPage()
    {
        //total message count
        $countMessage = CustomerContact::groupBy('user_id')
            ->select('user_id', DB::raw('count(*) as count'))
            ->orderBy('user_id', 'desc')
            ->where('status', 0)
            ->get();
        $message = MessageStatus::where('status', false)
            ->where('user_id', Auth::user()->id)->get();
        $user = User::where('id', Auth::user()->id)->first();
        return view('admin.account.edit', compact('user', 'countMessage', 'message'));
    }

    //ACCOUNT UPDATION
    public function update(Request $request)
    {
        $this->accountValidation($request);
        //user data
        $data = $this->userData($request);

        //checking user choose img or not
        $userId = Auth::user()->id;
        if ($request->hasFile('image')) {
            $dbValue = User::where('id', $userId)->first();
            $dbImage = $dbValue->image;
            if ($dbImage != null) {
                Storage::delete('public/' . $dbImage);
            }
            //unique img name
            $fileName = uniqid() . $request->file('image')->getClientOriginalName();
            //save in file & database
            $request->file('image')->storeAs('public/' . $fileName);
            $data['image'] = $fileName;
        }
        User::where('id', $userId)->update($data);
        return back()->with(['updateSuccess' => 'Account is successfully updated!']);

    }

    //ADMIN LISTS
    public function adminList()
    {
        $admins = User::when(request('key'), function ($query) {
            $query->orWhere('id', 'like', '%' . request('key') . '%')
                ->orWhere('name', 'like', '%' . request('key') . '%')
                ->orWhere('email', 'like', '%' . request('key') . '%')
                ->orWhere('phone', 'like', '%' . request('key') . '%')
                ->orWhere('gender', 'like', '%' . request('key') . '%')
                ->orWhere('address', 'like', '%' . request('key') . '%');
        })
            ->orderBy('id', 'desc')
            ->paginate(5);
        $admins->appends(request()->all());

        $adminCount = User::get();

        //total message count
        $countMessage = CustomerContact::groupBy('user_id')
            ->select('user_id', DB::raw('count(*) as count'))
            ->orderBy('user_id', 'desc')
            ->where('status', 0)
            ->get();
        $message = MessageStatus::where('status', false)
            ->where('user_id', Auth::user()->id)->get();

        return view('admin.adminLists.list', compact('admins', 'adminCount', 'countMessage', 'message'));
    }

    //ADMIN ACCOUNT DELETE
    public function accountDelete($id)
    {
        User::where('id', $id)->delete();
        return back();
    }

    //ADMINS ACCOUNT DETAILS
    public function accountDetail($id)
    {
        $admin = User::where('id', $id)->first();
        //total message count
        $countMessage = CustomerContact::groupBy('user_id')
            ->select('user_id', DB::raw('count(*) as count'))
            ->orderBy('user_id', 'desc')
            ->where('status', 0)
            ->get();
        $message = MessageStatus::where('status', false)
            ->where('user_id', Auth::user()->id)->get();
        return view('admin.adminLists.details', compact('admin', 'countMessage', 'message'));

    }

    //ORDER STATUS FROM ADMIN
    public function orderStatus(Request $request)
    {
        Order::where('id', $request->orderId)->update([
            'status' => $request->status,
        ]);
        return back();
    }

    //update validation
    private function accountValidation($request)
    {
        Validator::make($request->all(), [
            'image' => 'mimes:jpeg,png,jpg,webp|file',
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'gender' => 'required',
            'address' => 'required',
        ])->validate();

    }

    //user data
    private function userData($request)
    {
        return [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'address' => $request->address,
        ];
    }
    //password validation
    private function passwordValidation($request)
    {
        Validator::make($request->all(), [
            'oldPassword' => 'required',
            'newPassword' => 'required|min:6',
            'confirmPassword' => 'required|min:6|same:newPassword',
        ])->validate();
    }
}
