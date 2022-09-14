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
    private $insertStatus=false;


    public function gather()
    {

        $urls=$this->generateTcmbUrl($this->adapterUrls);
        array_push($urls,"https://www.tcmb.gov.tr/kurlar/202209/05092022.xml");//test purposes
        $url=$this->checkConnection($urls,$this->announcementTime);
        if (!empty($url)) {//is there a usable url exists
            if (!$this->timeControl($this->announcementTime)) {// does the announcement time meet
                //The announcement time has been met once, logic always tries to gather rate information.
                // After the first rates gather, insert status changed to true.
                //If earlier we gathered rates, we can't add this new information because it has been already added.
                //If announcement time has not met yet, we can change the insert status to false and wait for meeting the announcement time
                if (!$this->insertStatus) {
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
                    $this->insertStatus=true;//we added today's information
                    return $parities;
                }
            }
            else{
                $this->insertStatus=false;//announcement time hasn't met yet.
            }
        }
        return "";//if there is no new information gathered return empty string for control
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
