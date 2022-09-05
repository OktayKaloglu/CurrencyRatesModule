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


    /*
        INSERT INTO currency_rates.vendors(name,code)
        values('Türkiye Cumhuriyeti Merkez Bankası','TCMB')
        ;
    */

    public function parityfill(Request $request) {
        #adding new parities to the db

        $url='https://www.tcmb.gov.tr/kurlar/202208/31082022.xml';
        $xml=simplexml_load_file($url) ;
        #print_r($xml);
        foreach ($xml->Currency as $curr){

          $code=$curr->attributes()["CurrencyCode"]."/TRY";
          $name=($curr->CurrencyName).' / TURKISH LIRA';

          try{
              DB::insert('insert into parities (code,name) values(?,?)',[$code,$name]);
              echo "Record inserted successfully.<br/>";
          }
          catch (QueryException $e){
              echo $e->getMessage(). '<br/>';

          }

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

    public function ratesfill(Request $request) {
        #adding new parities to the db

        $url='https://www.tcmb.gov.tr/kurlar/202208/31082022.xml';
        $xml=simplexml_load_file($url) ;
        $time=$xml->attributes()["Date"];


        $vendor_id=$this->idFounder('TCMB',"vendors");
        echo $time.'<br/>';
        echo $vendor_id.'<br/>';


        foreach ($xml->Currency as $curr){

            $code=$curr->attributes()["CurrencyCode"]."/TRY";
            $parity_id=$this->idFounder($code,"parities");
            $buy_rate=$curr->ForexBuying;
            $sell_rate=$curr->ForexSelling;
            echo $buy_rate.'<br/>';

            echo $sell_rate.'<br/>';

            try{
                DB::insert('insert into rates (time,vendor_id,parity_id,buy_rate,sell_rate) values(?,?,?,?,?)',["$time",$vendor_id,$parity_id, $buy_rate,$sell_rate]);
                echo "Record inserted successfully.<br/>";
            }
            catch (QueryException $e){
                echo $e->getMessage(). '<br/>';

            }

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
            echo 'Time: '.$q->time.' VendorID: '.$q->vendor_id. ' ParityID: '.$q->parity_id.' BuyRate: '. $q->buy_rate.' SellRate: '. $q->sell_rate.'<br/>';
        }

        echo '<a href = "/main">Click Here</a> to go back.';
    }
}
