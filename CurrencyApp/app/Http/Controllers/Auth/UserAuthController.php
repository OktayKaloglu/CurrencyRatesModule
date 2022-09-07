<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use http\Client\Curl\User;

use Illuminate\Validation\Rule;
use App\Http\Controllers\DatabaseFiller;class UserAuthController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
    }


    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }




    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);

        $data['password'] = bcrypt($request->password);

        $user = User::create($data);

        $token = $user->createToken('API Token')->accessToken;

        (new DatabaseFiller())->prefrencesFill($data['email']);

        return response([ 'user' => $user, 'token' => $token]);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($data)) {
            return response(['error_message' => 'Incorrect Details.
            Please try again']);
        }

        $token = auth()->user()->createToken('API Token')->accessToken;

        return response(['user' => auth()->user(), 'token' => $token]);

    }






    public function edit(){
        return view('accounts.edit',[
            'user'=>auth()->user()
        ]);

    }
    public function editPreferences(){
        return view('accounts.preferences',[
            'user'=>auth()->user()
        ]);

    }
    public function update(){
        $this->validate(request(),[
            'name'=>'required',
            //'email'=>'required|email|unique:users,email,'.auth()->id().',Null,active,1'
            'email'=>[
                'required',
                'email',
                Rule::unique('users','email')->ignore(auth()->id())
            ]

        ]);

        auth()->user()->update([
            'name'=>request('name'),
            'email'=>request('email')
        ]);
        return $this->edit();
    }
    public function tokens(){
        $rates=(new DatabaseFiller())->getRates();
        return $rates;
    }
}
