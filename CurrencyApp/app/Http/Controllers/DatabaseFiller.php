<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class DatabaseFiller extends Controller {
    public function mainpage() {
        return view('main');
    }


    public function idFounder($name,$table){
        try {
            $query=DB::table($table)->get();
            foreach ($query as $q) {
                if ($q->code==$name){
                    return $q->id;
                }
            }

        }catch (QueryException $e){
            echo $e->getMessage(). '<br/>';
        }
        return -1;
    }


    public function parityfill($baseCode,$baseName,$currencies) {
        #adding new parities to the db

        foreach ($currencies as $curr){

          $code=$curr["code"]."/$baseCode";
          $name=$curr["name"]."/$baseName";
          echo $code.' '.$name.'</br>';
        /*
          try{
              DB::insert('insert into parities (code,name) values(?,?)',[$code,$name]);
              echo "Record inserted successfully.<br/>";
          }
          catch (QueryException $e){
              echo $e->getMessage(). '<br/>';

          }
        */
        }

        echo '<a href = "/main">Click Here</a> to go back.';
    }

    public function showparity(Request $request) {
        #adding new parities to the db
        $parities=DB::table('parities')->get();
        foreach ($parities as $parity) {
            echo $parity->code.' '.$parity->name.'<br/>';
        }

        echo '<a href = "/main">Click Here</a> to go back.';
    }

    public function ratesfill($time,$vendor,$rates) {

        $vendor_id=$this->idFounder($vendor,"vendors");



        foreach ($rates as $curr){

            $code=$curr["code"];
            $parity_id=$this->idFounder($code,"parities");
            $buy_rate=$curr["buy_rate"];
            $sell_rate=$curr["sell_rate"];

            echo "$time,$vendor_id,$parity_id, $curr[buy_rate],$curr[sell_rate] </br>";

            /*
            try{
                DB::insert('insert into rates (time,vendor_id,parity_id,buy_rate,sell_rate) values(?,?,?,?,?)',["$time",$vendor_id,$parity_id, $curr["buy_rate"],$curr["sell_rate"]]);
                echo "Record inserted successfully.<br/>";
            }
            catch (QueryException $e){
                echo $e->getMessage(). '<br/>';

            }
            */
        }


        echo '<a href = "/main">Click Here</a> to go back.';
    }

    public function getrates()
    {
        #adding new parities to the db
        $query=DB::table('rates')

            ->Join('parities', 'rates.parity_id', '=', 'parities.id')
            ->Join('vendors', 'rates.vendor_id', '=', 'vendors.id')
            ->select('time','parities.code as parity','vendors.code as vendor','buy_rate','sell_rate')

            ->get();
        return $query;
    }
    public function showrates(Request $request) {

        $query=$this->getrates();
        foreach ($query as $q) {
            echo 'Time: '.$q->time.' VendorName: '.$q->vendor. ' ParityID: '.$q->parity.' BuyRate: '. $q->buy_rate.' SellRate: '. $q->sell_rate.'<br/>';
        }

        echo '<a href = "/main">Click Here</a> to go back.';
    }
}
