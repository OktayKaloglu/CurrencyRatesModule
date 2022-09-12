<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Queries;
use Illuminate\Http\Request;

use http\Client\Curl\User;

use Illuminate\Validation\Rule;
use DB;
use Illuminate\Support\Str;
use Illuminate\Database\QueryException;

class UserAuthController extends Controller
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


    public function editTokens()
    {
        return view('accounts.apitokens', [
            'user' => auth()->user()
        ]);
    }

    public function tokensQuery($user_id){

        return DB::table('users_api_tokens')
            ->select('api_token','id')
            ->where('user_id', '=', $user_id)
            ->get();
    }

    public function generateToken(Request $request){
        try{
            DB::table("users_api_tokens")
                ->insert([
                    "user_id"=> $request->user_id,
                    "api_token"=>str::random(60),

                ]) ;

            echo "Record inserted successfully.<br/>";


        }
        catch (QueryException $e){
            echo $e->getMessage(). '<br/>';
        }

        return $this->editTokens();
    }
    public function deleteToken(Request $request){
        try{
            DB::table("users_api_tokens")
                ->where('id','=',$request->id)
                ->delete();
            echo "Record deleted successfully.<br/>";

        }
        catch (QueryException $e){
            echo $e->getMessage(). '<br/>';
        }

        return $this->editTokens();
    }




    public function editPreferences(){
        return view('accounts.preferences',[
            'user'=>auth()->user()
        ]);

    }

    public function prefQuery($user_id){

        return DB::select("
            SELECT user_preferences.id,user_preferences.user_id as 'user_id',vendors.code as 'vendor',parities.code as 'parity'
            FROM currency_rates.user_preferences LEFT JOIN currency_rates.parities ON user_preferences.parity_id= parities.id
            LEFT JOIN currency_rates.vendors ON user_preferences.vendor_id= vendors.id
            WHERE currency_rates.user_preferences.user_id=$user_id  " );

    }

    public function addPref(Request $request){
        if($request->vendor!='Vendor' || $request->parity!='Parity'||$request->id!=null){

            try{
                $qr=new Queries();
                $vendor_id=$qr->searchq("$request->vendor","vendors")->id;
                $parity_id=$qr->searchq("$request->parity","parities")->id;

                DB::insert('insert into user_preferences (user_id,parity_id,vendor_id) values(?,?,?)',[
                    $request->id,
                    $parity_id,
                    $vendor_id
                ]);

                echo "Record inserted successfully.<br/>";
            }
            catch (QueryException $e){
                echo $e->getMessage(). '<br/>';
            }

        }

        return $this->editPreferences();
    }
    public function deletePref(Request $request){
        if($request->id!=null){

            try{


                //DELETE FROM table_name WHERE condition;
                DB::select(
                    "DELETE FROM currency_rates.user_preferences
                            WHERE user_preferences.id=$request->id

                        "
                );
                echo "Record deleted successfully.<br/>";
            }
            catch (QueryException $e){
                echo $e->getMessage(). '<br/>';
            }
        }
        return $this->editPreferences();
    }



    }
