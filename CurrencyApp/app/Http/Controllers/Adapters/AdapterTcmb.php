<?php
namespace App\Http\Controllers\Adapters;

use App\Http\Controllers\Queries;

class AdapterTcmb extends AdapterAbstract
{
    private $adapterCode="TCMB";
    private $baseCode="TRY";
    private $baseName="TURKISH LIRA";
    private $adapterUrls=array("https://www.tcmb.gov.tr/kurlar/");
    private $announcementTime=array(15,30,5);
    private $announcementStyle="daily";//daily, monthly,hourly,every minute



    public function gather()
    {

        $urls=$this->generateTcmbUrl($this->adapterUrls);
        array_push($urls,"https://www.tcmb.gov.tr/kurlar/202209/05092022.xml");
        $url=$this->checks($urls,$this->announcementTime);
        if (!empty($url)){
            $xml=simplexml_load_file($url);
            $vendor_id=((new Queries())->searchq($this->adapterCode,"vendors"))->id;
            $parities=array();
            $time=(string)$xml->attributes()["Date"];
            foreach ($xml->Currency as $curr){
                $code=$curr->attributes()["CurrencyCode"].'/'.$this->baseCode;
                $parity_id=((new Queries())->searchq($code,"parities"))->id;

                array_push($parities, [
                    "time"=>$time,
                    "vendor_id"=>$vendor_id,
                    "parity_id"=>$parity_id,
                    "code"=>$code,
                    "name"=>$curr->CurrencyName.' '.$this->baseName,
                    "buy_rate"=>(float)$curr->ForexBuying,
                    "sell_rate"=>(float)$curr->ForexSelling,
                ]);
            }
            return $parities;
        }


        return "";
    }
    private function generateTcmbUrl($urls){//TCMB's url for today
        $year=date('Y');
        $month=date('m');
        $day=date('d');
        $rtrnarray=array();
        foreach ($urls as $url){
            array_push($rtrnarray,$url.$year.$month.'/'.$day.$month.$year.'.xml');
        }


    return $rtrnarray;

}



}
