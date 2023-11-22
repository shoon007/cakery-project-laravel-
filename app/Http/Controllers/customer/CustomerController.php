<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
//customer account edit
    public function accountEdit(Request $request)
    {
        $customer = Customer::where('id', $request->userId)->first();
        return response()->json([
            'customerAccount' => $customer,
        ]);

    }

//customer account update
    public function accountUpdate(Request $request, $id, $name, $email)
    {
        $data = [
            'name' => $name,
            'email' => $email,
        ];
        if ($request->hasFile('image')) {
            $dbValue = Customer::where('id', $id)->first();
            $dbImage = $dbValue->image;
            if ($dbImage != null) {
                Storage::delete('public/images/' . $dbImage);
            }
            $file = $request->file('image');
            $filename = uniqid() . $file->getClientOriginalName();
            $path = $file->storeAs('public/images', $filename);
            $data['image'] = $filename;
        }

        Customer::where('id', $id)->update($data);
        $customer = Customer::where('id', $id)->first();
        return response()->json([
            'customerAccount' => $customer,
        ]);

    }

//change password
    public function changePassword(Request $request)
    {
        $customer = Customer::where('id', $request->userId)->first();
        $dbPassword = $customer->password;
        if (Hash::check($request->oldPassword, $dbPassword)) {
            //storing new password in database
            $newPassword = [
                'password' => Hash::make($request->newPassword),
            ];
            Customer::where('id', $request->userId)->update($newPassword);
            return response()->json([
                'updatePassword' => true,
            ]);

        } else {
            return response()->json([
                'updatePassword' => false,
            ]);
        }
    }

//customer delete profile
    public function deleteImg(Request $request)
    {

        $data = [
            'image' => null,
        ];

        $dbValue = Customer::where('id', $request->userId)->first();
        $dbImage = $dbValue->image;
        if ($dbImage != null) {
            Storage::delete('public/images/' . $dbImage);
        }
        Customer::where('id', $request->userId)->update($data);
        return response()->json([
            'status' => 'the image is deleted',
        ]);
    }
//customer check information for contact
    public function customerCheckInfo(Request $request)
    {
        $customerInfo = Customer::where('id', $request->userId)
            ->where('name', $request->name)
            ->where('email', $request->email)->get();
        if (count($customerInfo) > 0) {
            return response()->json([
                'status' => true,
            ]);
        } else {
            return response()->json([
                'status' => false,
            ]);
        }

    }
//customer contact
    public function customerContact(Request $request)
    {
        $data = [
            'user_id' => $request->userId,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'message' => $request->message,
        ];
        CustomerContact::create($data);
        return response()->json([
            'contactStatus' => 'success',
        ]);
    }
}
