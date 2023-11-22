<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    //login
    public function login(Request $request)
    {
        $customer = Customer::where('email', $request->email)->first();
        if (isset($customer)) {
            if (Hash::check($request->password, $customer->password)) {
                return response()->json([
                    'customer' => $customer,
                    'token' => $customer->createToken(time())->plainTextToken,
                ]);
            }
        } else {
            return response()->json([
                'customer' => null,
                'token' => null,
            ]);
        }

    }

    //register
    public function register(Request $request)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ];

        if (Customer::where('email', $request->email)->exists()) {
            return response()->json([
                'customer' => null,
                'token' => null,
            ]);
        } else {

            Customer::create($data);
            $customer = Customer::where('email', $request->email)->first();
            return response()->json([
                'customer' => $customer,
                'token' => $customer->createToken(time())->plainTextToken,

            ]);
        }

    }
}
