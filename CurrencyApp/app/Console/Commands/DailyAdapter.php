<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\AdapterController;
use App\Http\Controllers\DatabaseFiller;
class DailyAdapter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'adapter:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Artisan command to gather daily exchange rates from vendors. Specify the adapter short name';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $df=new DatabaseFiller();
        $adapterPath="App\Http\Controllers\Adapters\\";

        $config = file_get_contents(".\app\Console\Commands\adapterConfig.json");
        $adapterName = json_decode($config, true);

        $adapters=array();
        foreach ($adapterName as $adapter){
            array_push($adapters,new ($adapterPath.$adapter["className"]));
            //echo $adapterPath.$adapter["className"];
        }

        foreach ($adapters as $adapter){
            $rates=$adapter->gather();
            if(!empty($rates)){
                $df->ratesfill ($rates);
            }else{
                echo "its empty\n";
            }
        }


    }
}
