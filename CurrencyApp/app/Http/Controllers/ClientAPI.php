<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\DatabaseFiller;
class ClientAPI extends Controller
{

    function getData(){
        $rates=(new DatabaseFiller())->getRates();
        return $rates;
    }


}
