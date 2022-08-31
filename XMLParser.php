<?php

require_once('DataBaseConnection.php');
#$url = 'https://www.tcmb.gov.tr/kurlar/202208/25082022.xml';

#$url="https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml";
$url="C:/xampp/htdocs/CurrencyRatesModule/srcfiles/25082022.xml";
$xml=simplexml_load_file($url) or die("Error: Cannot create object");

#$arr=array_map( 'get_object_vars', iterator_to_array($xml, FALSE));
#print_r($arr[0]["Cube"]);



$DB=new DataBase();
$time=$xml->attributes()["Date"];
$time="$time";
#echo $time.'\n';
#print_r($xml);


/*
#adding new parities to the db
$target="parity(code,name)";
foreach ($xml->Currency as $curr){
    #print_r($curr);
    $code=$curr->attributes()["CurrencyCode"]."/TRY";
    $name=$curr->CurrencyName;
    $val="('$code','$name')";
    echo "$val\n";
    $DB->insertion($target,$val);
}
*/



# gathered rates information insert in to the rates table
$target="rates(time,currCode,adapterName,buy,sell)";
$val="";

foreach ($xml->Currency as $curr){
    #print_r($curr);
    $name=$curr->attributes()["CurrencyCode"];
    $buy=$curr->ForexBuying;
    $sell=$curr->ForexSelling;
    $currCode="$name/TRY";
    $val="('$time','$currCode','TCMB',$buy,$sell)";
    echo "$val \n";
    $DB->insertion($target,$val);

}


$sel="*";
$tar="rates";
$DB->query($tar,$sel  );
/*
$query = $DB->getInstance()->query('SHOW TABLES');
$query->fetchAll(PDO::FETCH_COLUMN);
*/

$tableList = array();
$result = $DB->getInstance()->query("SHOW TABLES");
$asd= $result->fetchAll(PDO::FETCH_COLUMN);
print_r($asd);