<?php

namespace App\CurrencyModule\Adapters;

use PHPUnit\Framework\TestCase;

class HelpersTest extends TestCase
{

    public function testTimeControlNoStyle()
    {
        $response =Helpers::timeControl("",[]);
        $this->assertEquals(false,$response);

    }

    public function testTimeControlValidDaily()
    {
        $response =Helpers::timeControl("daily",[]);
        $this->assertEquals(false,$response);

    }

    public function testTimeControlDailyEmptyTimes()
    {
        $response =Helpers::timeControl("notDaily",[]);
        $this->assertEquals(false,$response);

    }
    public function testTimeControlDailyNotValid()
    {
        $response =Helpers::timeControl("daily",[]);
        $this->assertEquals(false,$response);


    }
    public function testTimeControlValidTime()
    {
        $times=[
            "announcementTime"=>array(0,0,0),
            "lastAnnouncementTime"=>array(23,59,59)
        ];

        $response =Helpers::timeControl("daily",$times);
        $this->assertEquals(true,$response);


    }
    public function testTimeControlSameTime()//if the 2 times equal it has to return true
    {
        $times=[
            "announcementTime"=>explode(':',date('H:i:s')),
            "lastAnnouncementTime"=>explode(':',date('H:i:s'))
        ];

        $response =Helpers::timeControl("daily",$times);
        $this->assertEquals(true,$response);
    }



    public function testTimeControlFirstTimeIsBig()//if the 2 times equal it has to return true
    {
        $times=[
            "announcementTime"=>explode(':',date('H:i:s')),
            "lastAnnouncementTime"=>explode(':',date('H:i:s'))
        ];
        $times['announcementTime'][0]+=1;
        $response =Helpers::timeControl("daily",$times);
        $this->assertEquals(false,$response);
    }

    public function testTimeControlSecondTimeIsSmall()//if the 2 times equal it has to return true
    {
        $times=[
            "announcementTime"=>explode(':',date('H:i:s')),
            "lastAnnouncementTime"=>explode(':',date('H:i:s'))
        ];
        $times['lastAnnouncementTime'][0]+=-1;
        $response =Helpers::timeControl("daily",$times);
        $this->assertEquals(false,$response);
    }


    public function testCheckConnectionValid()
    {
       $response =Helpers::checkConnection(["https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml"]);
       $this->assertEquals('https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml', $response);
    }
    public function testCheckConnectionBadURL()
    {
        $response = Helpers::checkConnection([".eu/stats/eurofxref/eurofxref-daily.xml"]);
        $this->assertEquals('',$response);
    }

    public function testCheckConnectionNull(){
        $response = Helpers::checkConnection([""]);
        $this->assertEquals('',$response);
    }

    public function testCheckConnectionRandomArray(){
        $response = Helpers::checkConnection(["","asdasd","123asdasd.wqddasd",'https://www.eurpa.eu/sts/eurofxref/eurofxref-daily.xml','https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml']);
        $this->assertEquals('https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml',$response);
    }


}
