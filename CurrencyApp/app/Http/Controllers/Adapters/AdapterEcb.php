<?php
namespace App\Http\Controllers\Adapters;

use App\Http\Controllers\Queries;

class AdapterEcb  extends AdapterAbstract
{
    private $adapterCode="ECB";
    private $baseCode="EUR";
    private $baseName="EURO";
    private $adapterUrls=array("https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml");
    private $announcementTime=array(17,00,5);
    private $announcementStyle="daily";//daily, monthly,hourly,every minute



    public function gather()
    {
        $url=$this->checks($this->adapterUrls,$this->announcementTime);
        if (!empty($url)){
            $xml=simplexml_load_file($url);
            $vendor_id=((new Queries())->searchq($this->adapterCode,"vendors"))->id;
            $parities=array();

            $currencies = $xml->Cube->Cube;
            $time =(string) $currencies->attributes()['time'];

            $time=substr($time, 5,2).'/'.substr($time, 8,2).'/'.substr($time,0,4);
            $name = "UNKNOWN $this->baseName";
            $sell_rate = -1;
            foreach ($currencies->Cube as $curr) {
                $code = (string)($curr->attributes()["currency"] . '/' . $this->baseCode);
                $parity_id=((new Queries())->searchq($code,"parities"))->id;

                $buy_rate = (float)($curr->attributes()["rate"]);
                array_push($parities, [

                    "time"=>$time,
                    "vendor_id"=>$vendor_id,
                    "parity_id"=>$parity_id,
                    "code" => $code,
                    "name" => $name,
                    "buy_rate" => $buy_rate,
                    "sell_rate" => $sell_rate
                ]);
            }
            return $parities;
        }


        return "";
    }




}
