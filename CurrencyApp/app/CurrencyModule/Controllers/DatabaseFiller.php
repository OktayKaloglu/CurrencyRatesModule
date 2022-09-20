<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;


class DatabaseFiller  {





    public function fillVendors($vendors=null)
    {
        try{
            DB::table('vendors')->insert([
                ["name"=>'Türkiye Cumhuriyeti Merkez Bankası',"code"=>'TCMB'],
                ["name"=>'European Central Bank',"code"=>'ECB'],
                ["name"=>'Bank of Japan',"code"=>'BOJ'],
                ["name"=>'The Federal Reserve',"code"=>'FED'],
            ]);
            echo "Record inserted successfully.<br/>";
        }catch (QueryException $e){
            echo $e->getMessage(). '<br/>';

        }

    }


    public function parityfill($currencies) {
        #adding new parities to the db

        foreach ($currencies as $curr){

          try{
              DB::table("parities")
                  ->insert([
                      "code"=>$curr['code'],
                      "name"=>$curr['name'],
                      "vendor_id"=>$curr["vendor_id"],
                  ]) ;
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
                DB::table("rates")
                    ->insert([
                        "time"=> $curr["time"],
                        "vendor_id"=>$curr["vendor_id"],
                        "parity_id"=>$curr["parity_id"],
                        "buy_rate"=>$curr["buy_rate"],
                        "sell_rate"=>$curr["sell_rate"],
                    ]) ;

                echo "Record inserted successfully.<br/>";
            }
            catch (QueryException $e){
                echo $e->getMessage(). '<br/>';
            }
        }

    }

}
