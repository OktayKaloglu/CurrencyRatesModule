<?php

namespace App\Http\Controllers;

use http\Client\Curl\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class AccountsController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
    }


    public function edit(){
        return view('accounts.edit',[
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
}
