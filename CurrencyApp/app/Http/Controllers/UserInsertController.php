<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class UserInsertController extends Controller {
    public function usercreate() {
        return view('user_create');
    }

    public function insert(Request $request) {

        try{
            DB::insert('insert into users (name,email,password) values(?,?,?)',[$request->input('name'),$request->input('email'), $request->input('password')]);
            echo "Record inserted successfully.<br/>";
            echo '<a href = "/insert">Click Here</a> to go back.';
        }
        catch (QueryException $e){
            echo $e->getMessage()."\n";
        }
    }
}
