<?php
namespace App\Http\Controllers;

use App\CurrencyModule\Adapters\AdapterTcmb;
use App\Http\Controllers\Adapters\AdapterEcb;
use App\Http\Requests;
use App\CurrencyModule\Adapters\GatherJob;

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
    const baseURLs = [
        'TCMB'=>"https://www.tcmb.gov.tr/kurlar/",
        'ECB'=>"https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml",
    ];

    #run adapters for the first time
    public function ParitySeeder()
    {

        $DBFiller=new DatabaseFiller();
        $adapters=(new GatherJob())->getAdapters("App\CurrencyModule\Adapters\\" , ".\app\CurrencyModule\Adapters\adapterConfig.json");
        foreach ($adapters as $adapter){
            $rates=$adapter->gather(true);
            $DBFiller->parityfill($rates);
        }

    }

    public function RatesSeeder()
    {
        $DBFiller=new DatabaseFiller();
        $adapters=(new GatherJob())->getAdapters("App\CurrencyModule\Adapters\\" , ".\app\CurrencyModule\Adapters\adapterConfig.json");
        foreach ($adapters as $adapter){
            $rates=$adapter->gather(true);
            $DBFiller->ratesfill($rates);

        }

    }





}

