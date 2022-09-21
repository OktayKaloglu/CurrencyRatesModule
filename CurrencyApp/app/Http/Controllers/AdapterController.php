<?php
namespace App\Http\Controllers;

use App\CurrencyModule\Adapters\AdapterTcmb;
use App\CurrencyModule\Adapters\GatherJob;
use App\Http\Controllers\Adapters\AdapterEcb;
use App\Http\Requests;
use Throwable;


class AdapterController extends Controller {
    /*
     * For new adapters, please update the  VendorsSeeder
   */

    #Adapters works with the DatabaseFiller controller. Pushes necessary information to the parityfill and ratesfill as associative array.
    /*example array:
    [
        0:[
            "code"=>USD/EUR'
            "name"=>"United States Dollar / Euro",
            "buy_rate"=>"1.00001",
            "sell_rate"=>"0.9999999",
        ]
    ]

     */


    #run adapters for the first time
    public function ParitySeeder()
    {
        $DBFiller=new DatabaseFiller();
        $adapters=(new GatherJob())->getAdapters("App\CurrencyModule\Adapters\\" , ".\app\CurrencyModule\Adapters\adapterConfig.json");
        foreach ($adapters as $adapter){
            $DBFiller-> parityfill(($adapter)->gather(true));
            //print_r($adapter->gather(true));
        }


    }

    public function RatesSeeder()
    {
        $DF=new DatabaseFiller();
        $adapters=(new GatherJob())->getAdapters("App\CurrencyModule\Adapters\\" , ".\app\CurrencyModule\Adapters\adapterConfig.json");
        foreach ($adapters as $adapter){
            $DF-> ratesfill(($adapter)->gather(true));
        }
    }





}

