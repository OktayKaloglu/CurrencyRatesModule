<?php
namespace App\CurrencyModule\Adapters;

class Helpers{

    static public function checkConnection($urls): string
    {

        foreach ($urls as $url){
            //if there is no url that have been connected, returns an empty string else returns the first url that has been connected.

            if( filter_var($url, FILTER_VALIDATE_URL)){//checks wether it is fit to the url definition
                $headers = @get_headers($url);
                // Use condition to check the existence of URL
                if($headers && strpos( $headers[0], '200')) {// If the status code is 200, it indicates a valid connection has been established
                    return $url;
                }
            }
        }
        return "";// there is no url that has proper connection
    }


    static public function timeControl($style,$times):bool{
        if(is_array($times)&&!empty($times)&&array_key_exists("announcementTime",$times) &&key_exists("lastAnnouncementTime",$times)
                &&is_array($times['announcementTime'])&&!empty($times['announcementTime'])
                    &&is_array($times['lastAnnouncementTime'])&&!empty($times['lastAnnouncementTime'])
            ){
            if("daily"==($style)){

                //if the time right for the adapter it will return ture else false
                $currTime=time();
                $time1=$times["announcementTime"];
                $time2=$times["lastAnnouncementTime"];

                $start=mktime($time1[0],$time1[1],$time1[2]);
                $end=mktime($time2[0],$time2[1],$time2[2]);




                if($currTime>=$start&&$currTime<=$end){
                    return true;
                }


            }
            elseif("hourly"==($style)){
                return true;//test
            }

        }

        return false;

    }


}
