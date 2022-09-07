<?php

namespace App\Http\Controllers;

use http\Client\Curl\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class AccountsAPIController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
    }
    public function view(){
        return view('accounts.apitokens',[
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
    }
    public function tokens(){
        $rates=(new DatabaseFiller())->getRates();
        return $rates;
    }

}
