<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\AdapterController;

class DailyAdapter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'adapter:daily {adapter}';

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
        $adapters=new AdapterController();
        if( $this->argument('adapter')=='TCMB'){
            $adapters->adapterTCMB();

        }else if($this->argument('adapter')=="ECB") {
            $adapters->adapterECB();

        }

    }
}
