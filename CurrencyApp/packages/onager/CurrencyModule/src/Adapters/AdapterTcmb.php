<?php
namespace App\CurrencyModule\Adapters;

use App\Http\Controllers\Queries;

class AdapterTcmb extends AdapterAbstract
{
    private $adapterCode;
    private $baseCode;
    private $baseName;
    private $adapterUrls;
    private $times;
    private $announcementStyle;


    function __construct($jsn) {
        $this->adapterCode=$jsn["codeName"];
        $this->baseCode=$jsn["baseCode"];
        $this->baseName=$jsn["baseName"];
        $this->adapterUrls=$jsn["adapterUrls"];
        $this->times=$jsn["times"];
        $this->announcementStyle=$jsn["announcementStyle"];
    }


    public function gather()
    {
        $urls=$this->generateTcmbUrl($this->adapterUrls);
        //array_push($urls,"https://www.tcmb.gov.tr/kurlar/202209/05092022.xml");//test purposes
        $url=$this->checkConnection($urls);
        if (!empty($url)) {//is there a usable url exists
            if ($this->timeControl($this->announcementStyle,$this->times)) {// does the announcement time meet
                //The announcement time has been met once, logic always tries to gather rate information.
                // After the first rates gather, insert status changed to true.
                //If earlier we gathered rates, we can't add this new information because it has been already added.
                //If announcement time has not met yet, we can change the insert status to false and wait for meeting the announcement time
                $xml=simplexml_load_file($url);
                $vendor_id=((new Queries())->searchq($this->adapterCode,"vendors"))->id;
                $parities=array();
                $time=(string)$xml->attributes()["Date"];
                foreach ($xml->Currency as $curr){
                    $code=$curr->attributes()["CurrencyCode"].'/'.$this->baseCode;
                    $parity_id=((new Queries())->searchq($code,"parities"))->id;


                }
                $this->insertStatus=true;//we added today's information
                return $parities;

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
