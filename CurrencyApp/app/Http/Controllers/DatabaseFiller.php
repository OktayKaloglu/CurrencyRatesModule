<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;


class DatabaseFiller extends Controller {





    public function fillVendors($vendors=null)
    {
        try{
            DB::table('vendors')->insert([
                ["name"=>'Türkiye Cumhuriyeti Merkez Bankası',"code"=>'TCMB'],
                ["name"=>'European Central Bank',"code"=>'ECB'],
                ["name"=>'Bank of Japan',"code"=>'BOJ'],
                ["name"=>'The Federal Reserve',"code"=>'FED'],
            ]);
        }catch (QueryException $e){
            echo $e->getMessage(). '<br/>';

        }

    }


    public function parityfill($currencies) {
        #adding new parities to the db

        foreach ($currencies as $curr){

          try{
              DB::insert('insert into parities (code,name,vendor_id) values(?,?,?)',[$curr['code'],$curr['name'],$curr["vendor_id"]]);
              echo "Record inserted successfully.<br/>";
          }
          catch (QueryException $e){
              echo $e->getMessage(). '<br/>';

          }

        }

    }





    public function ratesfill($rates) {

        foreach ($rates as $curr){
            try{
                DB::insert('insert into rates (time,vendor_id,parity_id,buy_rate,sell_rate) values(?,?,?,?,?)',[$curr["time"],$curr["vendor_id"],$curr["parity_id"], $curr["buy_rate"],$curr["sell_rate"]]);
                echo "Record inserted successfully.<br/>";
            }
            catch (QueryException $e){
                echo $e->getMessage(). '<br/>';
            }
        }

    }

}
