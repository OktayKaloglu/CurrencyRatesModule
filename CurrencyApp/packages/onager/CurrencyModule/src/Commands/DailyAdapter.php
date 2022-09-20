<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\DatabaseFiller;
use App\CurrencyModule\Adapters\GatherJob;
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
        //use GatherJob to gather new rates from adapters
        (new GatherJob())->work("App\CurrencyModule\Adapters\\" , ".\app\CurrencyModule\Adapters\adapterConfig.json");
        #(new GatherJob())->test("App\CurrencyModule\Adapters\\" , ".\app\CurrencyModule\Adapters\adapterConfig.json");


    }
}
