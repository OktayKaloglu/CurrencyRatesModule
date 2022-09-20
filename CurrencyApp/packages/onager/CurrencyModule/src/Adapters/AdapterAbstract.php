<?php
namespace App\CurrencyModule\Adapters;
use App\Http\Controllers\Controller;
use App\Http\Middleware\TrimStrings;

abstract class AdapterAbstract implements AdapterInterface {
    private $adapterCode;
    private $baseCode;
    private $baseName;
    private $adapterUrls;
    private $times;// an array that contains (h,m,s)/(15,30,15) to make an unix time us second as delay
    private $announcementStyle;//daily, monthly,hourly,every minute



    public function checkConnection($urls): string
    {
        foreach ($urls as $url)
            //if there is no url that doesn't exist, returns an empty string else returns the first url that exists
            if( !strpos( get_headers($url)[0], '404')){// If the status code is 404, it indicates URL doesn’t exist
                return $url;
            }
        return "";// there is no url that has proper connection
    }


    public function timeControl($style,$times):bool{
        if("daily"==($style)){

            //if the time right for the adapter it will return ture else false
            $time1=$times["announcementTime"];
            $time2=$times["lastAnnouncementTime"];

            $start=mktime($time1[0],$time1[1],$time1[2]);
            $end=mktime($time2[0],$time2[1],$time2[2]);
            $currTime=time();

            if($currTime>=$start&&$currTime<=$end){
                echo "time is now\n";
                return true;
            }


        }
        elseif("hourly"==($style)){
            return true;//test
        }

        return false;
    }

    //checks whether time is reached,and tries to return a valid url
    public function checks($urls,$announcementTime,$lastAnnouncementTime){
        if($this->timeControl($announcementTime,$lastAnnouncementTime)){
            return $this->checkConnection($urls);//get a working url
        }

        return "";
    }

    abstract public function gather();//return a  array that contains rates with vendor,time,buy_rate_sell_rate,

}

