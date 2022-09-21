<?php

namespace App\CurrencyModule\Adapters;

use PHPUnit\Framework\TestCase;

class GatherJobTest extends TestCase
{

    public function testGetAdaptersTruePaths()
    {
        $adapters=[
            'App\CurrencyModule\Adapters\AdapterEcb','App\CurrencyModule\Adapters\AdapterTcmb'
        ];
        $response =(new GatherJob())->getAdapters("App\CurrencyModule\Adapters\\" , ".\app\CurrencyModule\Adapters\adapterConfig.json");
        $stat=true;
        foreach ($response as $adapter){

            if (!in_array(get_class($adapter),$adapters,false)){
                $stat=false;
            }
        }
        $this->assertEquals(true,$stat);
    }


    public function testGetAdaptersWrongConfigPath()
    {
        $response =(new GatherJob())->getAdapters('asd','mıocmıo');


        $this->assertEquals(false,$response);

    }
    public function testGetAdaptersWrongAdapterPath()
    {
        $response =(new GatherJob())->getAdapters('asd','./app/CurrencyModule/Adapters/adapterConfig.json');

        $this->assertEquals(false,$response);
    }


    public function testWorkTruePaths()
    {
        $response =(new GatherJob())->work("App\CurrencyModule\Adapters\\" , ".\app\CurrencyModule\Adapters\adapterConfig.json");
        $this->assertEquals(true,$response);
    }


    public function testWorkWrongConfigPath()
    {
        $response =(new GatherJob())->work('asd','mıocmıo');


        $this->assertEquals(false,$response);

    }
    public function testWorkWrongAdapterPath()
    {
        $response =(new GatherJob())->work('asd','./app/CurrencyModule/Adapters/adapterConfig.json');

        $this->assertEquals(false,$response);
    }





}
