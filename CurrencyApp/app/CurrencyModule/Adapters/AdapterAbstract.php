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






    abstract public function gather( $testStatus);//return a  array that contains rates with vendor,time,buy_rate_sell_rate,

}

