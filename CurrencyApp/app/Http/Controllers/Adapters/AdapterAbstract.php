<?php
namespace App\Http\Controllers\Adapters;

use App\Http\Controllers\Controller;
use App\Http\Middleware\TrimStrings;

abstract class AdapterAbstract extends Controller implements AdapterInterface {
    private $adapterCode;
    private $baseCode;
    private $baseName;
    private $adapterUrls;
    private $announcementTime;// an array that contains (h,m,s)/(15,30,15) to make an unix time us second as delay
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
    public function timeControl($time):bool{
        //if the time right for the adapter it will return ture else false
        //echo date("H").' '.date("m").' '.date("S").'\n';

        if(time()>=$time){
            echo "time is now\n";
            return true;

        }
        return false;
    }

    //checks whether time is reached,and tries to return a valid url
    public function checks($urls,$announcementTime){
        $time=mktime($announcementTime[0],$announcementTime[1],$announcementTime[2]);

        if($this->timeControl($time)){
            return $this->checkConnection($urls);//get a working url
        }

        return "";
    }

    abstract public function gather();

}

