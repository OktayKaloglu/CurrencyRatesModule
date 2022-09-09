<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Nyholm\Psr7\Response;
use App\Http\Controllers\DatabaseFiller;
use function PHPUnit\Framework\isEmpty;

class Queries extends Controller
{

    public function viewrates(){
        return view('data.rates',[
            'user'=>auth()->user(),
            'rates'=>$this->rates(auth()->user()->id)
        ]);

    }

    public function returnRates(Request $request){
        $rates=$this->rates($request->id,$request->date,$request->code);
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

    public function getVendors(){

        return DB::table('vendors')
            ->get();
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


        $baseQuery="
            SELECT rates.time ,user_preferences.user_id as 'user_id',vendors.code as 'vendor',parities.code as 'parity',rates.buy_rate,rates.sell_rate
            FROM currency_rates.rates LEFT JOIN currency_rates.parities ON rates.parity_id= parities.id
            LEFT JOIN currency_rates.vendors ON rates.vendor_id= vendors.id
            INNER JOIN currency_rates.user_preferences ON rates.vendor_id = user_preferences.vendor_id and rates.parity_id= user_preferences.parity_id
            WHERE currency_rates.user_preferences.user_id=$user_id" ;

        if(!empty($date)){
            $baseQuery="$baseQuery and rates.time='$date'";
        }
        if(!empty($code) ){
            $baseQuery="$baseQuery and parities.code='$code'";
        }


        return DB::select($baseQuery) ;

    }



    public function apiRates(Request $request ){
        $DF=new DatabaseFiller();
        $user_id=($DF->searchq($request->api_token,"users_api_tokens","api_token"))->user_id;
        $date=$request->date;


        $baseQuery="
            SELECT rates.time ,user_preferences.user_id as 'user_id',vendors.code as 'vendor',parities.code as 'parity',rates.buy_rate,rates.sell_rate
            FROM currency_rates.rates LEFT JOIN currency_rates.parities ON rates.parity_id= parities.id
            LEFT JOIN currency_rates.vendors ON rates.vendor_id= vendors.id
            INNER JOIN currency_rates.user_preferences ON rates.vendor_id = user_preferences.vendor_id and rates.parity_id= user_preferences.parity_id
            WHERE currency_rates.user_preferences.user_id=$user_id" ;

        if($request->has("date") && !empty($request->date)){
            $baseQuery="$baseQuery and rates.time='$request->date'";
        }
        if($request->has("code") && !empty($request->code) ){
            $baseQuery="$baseQuery and parities.code='$request->code'";
        }


        return DB::select($baseQuery) ;

    }




}
