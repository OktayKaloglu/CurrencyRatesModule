<?php

namespace App\CurrencyModule\Adapters;
use App\Http\Controllers\DatabaseFiller;

class GatherJob
{


    public function work($adapterPath,$configPath){


        $adapters=$this->getAdapters($adapterPath,$configPath);

        $df=new DatabaseFiller();

        foreach ($adapters as $adapter) {// use adapter objects to gather data
            $rates = $adapter->gather();
            if (!empty($rates)) {
                $df->ratesfill($rates);
            } else {
                echo "its empty\n";
            }
        }
    }

    public function getAdapters($adapterPath,$configPath){//create new adapter objects from the adapters config file

        $config = file_get_contents($configPath);
        $adapterName = json_decode($config, true);

        $adapters=array();
        foreach ($adapterName as $adapter){
            array_push($adapters,new ($adapterPath.$adapter["className"] )($adapter) );
            //echo $adapterPath.$adapter["className"];
        }
        return $adapters;

    }


    public function test($adapterPath,$configPath){
        $config = file_get_contents($configPath);
        $adapterName = json_decode($config, true);


        $adapters=array();
        foreach ($adapterName as $adapter){

            if($adapter["className"]=="AdapterEcb"){

                print_r ((new ($adapterPath.$adapter["className"])($adapter) )-> gather()) ;

                die();
            }

            //array_push($adapters,new ($adapterPath.$adapter["className"] ));
            //echo $adapterPath.$adapter["className"];
        }
    }


}
