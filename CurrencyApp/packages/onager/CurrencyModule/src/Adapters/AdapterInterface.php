<?php
namespace App\CurrencyModule\Adapters;

interface AdapterInterface
{
    public function checkConnection($urls):string;//checks the urls status and returns an url that works at the moment
    public function gather();
    public function timeControl($time1,$time2):bool;
}
