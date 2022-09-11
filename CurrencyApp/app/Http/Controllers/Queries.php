<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use stdClass;

class Queries extends Controller
{
    public function view(){
        return view('Accounts.apitokens',[
            'user'=>auth()->user()
        ]);

    }

    public function mainpage() {
        return view('main');
    }

    public function viewparity(){
        return view('data.parities',[
            'user'=>auth()->user()
        ]);

    }
    public function showparity(){

        #adding new parities to the db
        $query=DB::table('parities')->get();

        return $query;

    }

    public function viewvendors(){
        return view('data.vendors',[
            'user'=>auth()->user()
        ]);

    }

    public function getVendors(){

        #adding new parities to the db
        $query=DB::table('vendors')->get();

        return $query;

    }


    public function searchq($name,$table,$column="code"){
        /*
          The function expected to return an query object
         * */
        try {
            $query=DB::table($table)->get();
            foreach ($query as $q) {
                if ($q->$column==$name){
                    return $q;
                }
            }

        }catch (QueryException $e){
            echo $e->getMessage(). '<br/>';
        }
        /*
         If the data couldn't find in the table function will return an object that satisfies the expected properties
         */
        $obj = new stdClass();
        $obj->id=-1;
        $obj->user_id=-1;
        return  $obj ;
    }



    public function viewRates(Request $request){

        return view('data.rates',[
            'user'=>auth()->user(),

        ] );

    }

    public function returnRates(Request $request){
        $rates=$this->rates($request->id,$request-> has('date') ? $request->date: null,  $request-> has('code')  ? $request->code : null);

        return view('data.searchrates',[
            'user'=>auth()->user(),
            'rates'=>$rates,

        ] );

    }



    public function token($api_token){
        return  DB::table('users_api_tokens')
            ->where('users_api_tokens.api_token','=', $api_token)
            ->first();

    }

    public function getTable($table)
    {
        return DB::table($table)->get();
    }



    public function getParities(){

        return DB::table('parities')
            ->get();
    }


    public function getPreferences($user_id){

        return DB::table('user_preferences')
                ->join('parities','user_preferences.parity_id','=','parities.id')
                ->where('user_id','=',$user_id)
                ->get()
            ;
    }


    public function rates($user_id,$date=null,$code=null ){
        /*
         this code joins rates to vendors and parities tables.
         with inner join of the user_preferences table
         we can make queries that based on the user preferenced currency and vendors
         with the addition of the date and parity code where clauses, we can further filter down the query
         if date or parity code didn't supply with the request, query will return all the stored rates based on the user preferences
         */
        $rates=DB::table("rates")
                ->select("rates.time","vendors.code  as vendor", "parities.code  as parity","rates.buy_rate","rates.sell_rate" )
                    ->join("parities","rates.parity_id","=","parities.id")
                        ->join("vendors","rates.vendor_id","=","vendors.id")

                            ->join("user_preferences",function($join){
                                $join->on("user_preferences.parity_id","=","parities.id")
                                    ->on("user_preferences.vendor_id","=","vendors.id");
                    })
                ->where("user_preferences.user_id","=",$user_id);
        if(!empty($date)){
            $rates->where("rates.time","=","$date");

        }
        if(!empty($code && $code!='Parity') ){
            $rates->where("parities.code","=","$code");

        }
        return $rates->get();

    }



    public function apiRates(Request $request ){
        $user_id=($this->searchq($request->api_token,"users_api_tokens","api_token"))->user_id;

        return response()->json($this->rates($user_id,$request->date,$request->code));

    }




}
