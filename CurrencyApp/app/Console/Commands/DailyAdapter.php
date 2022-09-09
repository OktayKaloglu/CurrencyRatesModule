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
        $DF=new DatabaseFiller();
        if( $this->argument('adapter')=='TCMB'){
            $DF->ratesfill ($adapters->adapterTCMB());

        }else if($this->argument('adapter')=="ECB") {
            $DF->ratesfill($adapters->adapterECB());

        }

    }
}
