<?php

namespace App\Http\Controllers;

use http\Client\Curl\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class AccountsAPIController extends Controller
{

    /**
     * Registration Req
     */
    public function registerAction(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:4',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $token = $user->createToken('Laravel-9-Passport-Auth')->accessToken;
        print_r(response()->json(['token' => $token], 200)) ;
        die;
        return response()->json(['token' => $token], 200);
    }

    /**
     * Login Req
     */
    public function loginAction(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (auth()->attempt($data)) {
            $token = auth()->user()->createToken('Laravel-9-Passport-Auth')->accessToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    public function userInfoAction()
    {

        $user = auth()->user();

        return response()->json(['user' => $user], 200);

    }

}
