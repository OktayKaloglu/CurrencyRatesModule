<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class VendorsSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::insert("
            INSERT INTO currency_rates.vendors(name,code)
            values
                ('Türkiye Cumhuriyeti Merkez Bankası','TCMB'),
                ('European Central Bank','ECB'),
                ('Bank of Japan','BOJ'),
                ('The Federal Reserve','FED')


        ");




    }
}
