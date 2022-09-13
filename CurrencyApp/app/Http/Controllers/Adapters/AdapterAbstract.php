<?php
namespace App\Http\Controllers\Adapters;

use App\Http\Controllers\Controller;
use App\Http\Middleware\TrimStrings;

abstract class AdapterAbstract extends Controller implements AdapterInterface {
    private $adapterCode;
    private $baseCode;
    private $baseName;
    private $adapterUrls;
    private $announcementTime;//unix time mktime(h,m,s)/(15,30,15) ,use s as delay
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

        if(mktime(0)>=$time){

            return true;
        }
        return false;
    }


    abstract public function gather();
    abstract public function checks();//checks the url is exists and the announcement time is met


}

