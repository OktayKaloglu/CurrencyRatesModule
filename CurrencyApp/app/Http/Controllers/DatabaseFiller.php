<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;


class DatabaseFiller extends Controller {


    public function view(){
        return view('Accounts.apitokens',[
            'user'=>auth()->user()
        ]);

    }

    public function mainpage() {
        return view('main');
    }

    public function viewparity(){
        return view('data.parities',[
            'user'=>auth()->user()
        ]);

    }

    public function viewvendors(){
        return view('data.vendors',[
            'user'=>auth()->user()
        ]);

    }


    public function fillVendors($vendors=null)
    {
        if ($vendors==null){
             $vendors= array(
                array(
                    "name"=>"Türkiye Cumhuriyeti Merkez Bankası",
                    "code"=>"TCMB"
                ),
                array(
                    "name"=>"European Central Bank",
                    "code"=>"ECB"
                ),
                array(
                    "name"=>"Bank of Japan",
                    "code"=>"BOJ"
                ),
                array(
                    "name"=>"the Federal Reserve",
                    "code"=>"FED"
                ),
            );

        }


        foreach ($vendors as $vendor) {


              try{
                  DB::insert('insert into vendors (code,name) values(?,?)',[$vendor["code"],$vendor["name"]]);
                  echo "Record inserted successfully.<br/>";
              }
              catch (QueryException $e){
                  echo $e->getMessage(). '<br/>';

              }

        }
    }



    public function getVendors(){

        #adding new parities to the db
        $query=DB::table('vendors')->get();

        return $query;

    }


    public function searchq($name,$table,$column="code"){
        try {
            $query=DB::table($table)->get();
            foreach ($query as $q) {
                if ($q->$column==$name){
                    return $q;
                }
            }

        }catch (QueryException $e){
            echo $e->getMessage(). '<br/>';
        }
        return -1;
    }







    public function parityfill($currencies) {
        #adding new parities to the db

        foreach ($currencies as $curr){

          try{
              DB::insert('insert into parities (code,name,vendor_id) values(?,?,?)',[$curr['code'],$curr['name'],$curr["vendor_id"]]);
              echo "Record inserted successfully.<br/>";
          }
          catch (QueryException $e){
              echo $e->getMessage(). '<br/>';

          }

        }

    }

    public function showparity() {

        #adding new parities to the db
        $parities=DB::table('parities')->get();
        /*
        foreach ($parities as $parity) {
            echo $parity->code.' '.$parity->name.'<br/>';
        }

        echo '<a href = "/main">Click Here</a> to go back.';
        */
        return $parities;
    }



    public function ratesfill($rates) {

        foreach ($rates as $curr){
            try{
                DB::insert('insert into rates (time,vendor_id,parity_id,buy_rate,sell_rate) values(?,?,?,?,?)',[$curr["time"],$curr["vendor_id"],$curr["parity_id"], $curr["buy_rate"],$curr["sell_rate"]]);
                echo "Record inserted successfully.<br/>";
            }
            catch (QueryException $e){
                echo $e->getMessage(). '<br/>';
            }
        }

    }

    public function getrates()
    {
        #adding new parities to the db
        $query=DB::table('rates')

            ->Join('parities', 'rates.parity_id', '=', 'parities.id')
            ->Join('vendors', 'rates.vendor_id', '=', 'vendors.id')
            ->select('time','parities.code as parity','vendors.code as vendor','buy_rate','sell_rate')

            ->get();
        return $query;
    }
    public function showrates( ) {

        $query=$this->getrates();
        foreach ($query as $q) {
            echo 'Time: '.$q->time.' VendorName: '.$q->vendor. ' ParityID: '.$q->parity.' BuyRate: '. $q->buy_rate.' SellRate: '. $q->sell_rate.'<br/>';
        }


    }


    public function getUniqueParities(){
        $query=DB::select(
            DB::raw("

                select *
                from parities
                group by('code')

            ")

        );
        return $query;
    }

    public function prefrencesFill($email) {

        $id=($this->searchq($email,'users','email'))->id;
        $queries=$this->getUniqueParities();

        foreach ($queries as $query) {

            try {
                DB::insert('insert into dummy_preferences (user_id,vendor_id,parity_id) values(?,?,?)', [$id, $query->vendor_id, $query->id]);
                echo "Record inserted successfully.<br/>";

            } catch (QueryException $e) {
                echo $e->getMessage() . '<br/>';

            }
        }
    }


    public function test() {

        print_r((new AdapterController())->adapterECB());
        print_r((new AdapterController())->adapterTCMB());

    }




}
