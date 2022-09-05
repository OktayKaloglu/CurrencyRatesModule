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
    INSERT INTO currency_rates.vendors(name,code)
    values('Türkiye Cumhuriyeti Merkez Bankası','TCMB')
        .("European Central Bank","ECB")

    ;
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
    public function adapterTCMB(){
        #$url='https://www.tcmb.gov.tr/kurlar/202209/05092022.xml'; for test purpose.
        $url=$this->TCMBURL();
        $xml=null;
        try{
            $xml=simplexml_load_file($url);
        }
        catch (Throwable $e){
            echo $e->getMessage(). '<br/>';
        }
        if($xml!=null){
            $vendorCode="TCMB";
            $baseCode="TRY";
            $baseName="TURKISH LIRA";
            $parities=array();
            $time=$xml->attributes()["Date"];
            foreach ($xml->Currency as $curr){
                array_push($parities, [
                    "code"=>$curr->attributes()["CurrencyCode"].'/'.$baseCode,
                    "name"=>$curr->CurrencyName.' '.$baseName,
                    "buy_rate"=>(float)$curr->ForexBuying,
                    "sell_rate"=>(float)$curr->ForexSelling,
                ]);
            }
            $DBFiller=new DatabaseFiller();
            $DBFiller-> parityfill($baseCode,$baseName,$parities);
            $DBFiller->ratesfill($time,$vendorCode,$parities);
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
        $xml=simplexml_load_file($url) ;
        $vendorCode="ECB";
        $baseCode="EUR";
        $baseName="EURO";
        $parities=array();
        $currencies=$xml->Cube->Cube;
        $time=$currencies-> attributes()['time'];
        $name="UNKNOWN";
        $sell_rate=-1;
        foreach ($currencies->Cube as $curr){
            $code=(string)($curr->attributes()["currency"].'/'.$baseCode );
            $buy_rate=(float)($curr->attributes()["rate"] );
            array_push($parities, [
                "code"=>$code,
                "name"=>$name,
                "buy_rate"=>$buy_rate,
                "sell_rate"=>$sell_rate
            ]);
        }
        $DBFiller=new DatabaseFiller();
        $DBFiller-> parityfill($baseCode,$baseName,$parities);
        $DBFiller->ratesfill($time,$vendorCode,$parities);
    }




}
