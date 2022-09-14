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
    private $insertStatus=false;//control for the addtion if added today it will become true


    public function gather()
    {
        $url=$this->checkConnection($this->adapterUrls,$this->announcementTime);

        if (!empty($url)){//is there a usable url exists
            if(!$this->timeControl($this->announcementTime)){// does the announcement time meet
                //The announcement time has been met once,logic always tries to gather rate information.
                // After the first rates gather, insert status changed to true.
                //If earlier we gathered rates, we can't add this new information because it has been already added.
                //If announcement time has not met yet, we can change the insert status to false and wait for the announcement meeting time
                if(!$this->insertStatus){
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
                    $this->insertStatus=true;
                    return $parities;
                }
            }else{
                $this->insertStatus=false;//announcement time hasn't met yet.
            }
        }


        return "";//if there is no new information gathered return empty string for control
    }




}
