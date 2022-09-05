<?php

namespace App\Http\Controllers;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class UserProfile extends Controller
{

    public function showuser()
    {
        return view('user_profile');
    }

    public function apiToken()
    {
        #adding new parities to the db
        $users=DB::table('users')->get();
        foreach ($users as $user) {
            #validate the user and Show the necessary token to right user
            echo 'API Token: '.$user->api_token. '<br/>';
        }

        echo '<a href = "/user">Click Here</a> to go user profile.'.'</br>';
        echo '<a href = "/main">Click Here</a> to go main page.'.'</br>';
    }


    public function updateToken(Request $request)
    {
        $token = Str::random(60);

        $request->user()->forceFill([
            'api_token' => hash('sha256', $token),
        ])->save();

        #return ['token' => $token];
        return view('user_profile');
    }


    public function userPrefQuery()
    {
        echo "Token </br>";
    }

}


