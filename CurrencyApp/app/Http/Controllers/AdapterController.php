<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use App\Http\Controllers\DatabaseFiller;
use Throwable;

class AdapterController extends Controller {
    /*
     * For new adapters, please update the  VendorsSeeder
   */

    #Adapters works with the DatabaseFiller controller. Pushes necessary information to the parityfill and ratesfill as associative array.
    /*example array:
    [
        0:[
            "code"=>USD/EUR'
            "name"=>"United States Dollar / Euro",
            "buy_rate"=>"1.00001",
            "sell_rate"=>"0.9999999",
        ]
    ]

     */

    #run adapters for the first time
    public function ParitySeeder()
    {

        $DBFiller=new DatabaseFiller();

        $parities=$this->adapterTCMB();
        $DBFiller-> parityfill($DBFiller->idFounder('TCMB','vendors'),$parities);

        $parities=$this->adapterECB();
        $DBFiller-> parityfill($DBFiller->idFounder('ECB','vendors'),$parities);

    }

    public function RatesSeeder()
    {
        $DF=new DatabaseFiller();
        $DF->ratesfill( $this->adapterECB());
        $DF->ratesfill($this->adapterTCMB());
    }

    public function adapterTCMB(){
        $url='https://www.tcmb.gov.tr/kurlar/202209/05092022.xml'; #for test purpose.
        #$url=$this->TCMBURL();
        $xml=null;
        try{
            $xml=simplexml_load_file($url);
        }
        catch (Throwable $e){
            echo $e->getMessage(). '<br/>';
        }
        if($xml!=null){
            $vendor_id=(new DatabaseFiller())->idFounder("TCMB","vendors");
            $baseCode="TRY";
            $baseName="TURKISH LIRA";
            $parities=array();
            $time=(string)$xml->attributes()["Date"];
            foreach ($xml->Currency as $curr){
                array_push($parities, [
                    "time"=>$time,
                    "vendor_id"=>$vendor_id,
                    "code"=>$curr->attributes()["CurrencyCode"].'/'.$baseCode,
                    "name"=>$curr->CurrencyName.' '.$baseName,
                    "buy_rate"=>(float)$curr->ForexBuying,
                    "sell_rate"=>(float)$curr->ForexSelling,
                ]);
            }
        return $parities;
        }

    }
    public function TCMBURL(){
        $year=date('Y');
        $month=date('m');
        $day=date('d');
        $url='https://www.tcmb.gov.tr/kurlar/'.$year.$month.'/'.$day.$month.$year.'.xml';
        return $url;
    }

    #
    public function adapterECB(){
        $url='https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml';

        $xml=null;
        try{
            $xml=simplexml_load_file($url);
        }
        catch (Throwable $e){
            echo $e->getMessage(). '<br/>';
        }
        $vendor_id=(new DatabaseFiller())->idFounder("TCMB","vendors");

        if($xml!=null) {

            $vendorCode = "ECB";
            $baseCode = "EUR";
            $baseName = "EURO";
            $parities = array();
            $currencies = $xml->Cube->Cube;
            $time =(string) $currencies->attributes()['time'];

            $time=substr($time, 5,2).'/'.substr($time, 8,2).'/'.substr($time,0,4);
            $name = "UNKNOWN";
            $sell_rate = -1;
            foreach ($currencies->Cube as $curr) {
                $code = (string)($curr->attributes()["currency"] . '/' . $baseCode);
                $buy_rate = (float)($curr->attributes()["rate"]);
                array_push($parities, [

                    "time"=>$time,
                    "vendor_id"=>$vendor_id,
                    "code" => $code,
                    "name" => $name,
                    "buy_rate" => $buy_rate,
                    "sell_rate" => $sell_rate
                ]);
            }
            return $parities;
        }
    }




}
