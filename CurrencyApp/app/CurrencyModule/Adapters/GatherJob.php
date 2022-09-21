<?php

namespace App\CurrencyModule\Adapters;
use App\Http\Controllers\DatabaseFiller;
use Mockery\Exception;
use Nette\DirectoryNotFoundException;
use function PHPUnit\Framework\fileExists;

class GatherJob
{




    public function work($adapterPath,$configPath){


        $adapters=$this->getAdapters($adapterPath,$configPath);
        if(!empty($adapters)){
            $df=new DatabaseFiller();
            foreach ($adapters as $adapter) {// use adapter objects to gather data
                $rates = $adapter->gather();
                if (!empty($rates)) {
                    $df->ratesfill($rates);
                } else {
                    echo "its empty\n";
                }
            }
            return true;
        }
        return false;
    }

    public function getAdapters($adapterPath,$configPath){//create new adapter objects from the adapters config file

        try{
            if(is_file($configPath)  ){
                $config = file_get_contents($configPath);
                $adapterName = json_decode($config, true);
                $adapters=array();
                foreach ($adapterName as $adapter){
                    $classPath=$adapterPath.$adapter["className"] ;

                    if(class_exists($classPath)){
                        array_push($adapters,new ($classPath)($adapter));

                    }else{

                        throw new Exception("Class Path Couldn't found");
                    }
                }
                return $adapters;
            }else{
               throw new Exception("Config Couldn't found",);
            }
        }catch (Exception $e){
            $e->getMessage();
        }
        return false;

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
