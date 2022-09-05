<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;

class UserInsertController extends Controller {
    public function usercreate() {
        return view('user_create');
    }

    public function insert(Request $request) {

        try{
            DB::insert('insert into users (name,email,password,api_token) values(?,?,?,?)',[$request->input('name'),$request->input('email'), $request->input('password'),Str::random(60)]);
            echo "Record inserted successfully.<br/>";
            echo '<a href = "/insert">Click Here</a> to go back.';
            echo '<a href = "/main">Click Here</a> to go main page.';

        }
        catch (QueryException $e){
            echo $e->getMessage()."\n";
        }
    }
}
