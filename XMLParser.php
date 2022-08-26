<?php
$url = 'https://www.tcmb.gov.tr/kurlar/202208/25082022.xml';

#$url="https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml";
$xml=simplexml_load_file($url) or die("Error: Cannot create object");

#$arr=array_map( 'get_object_vars', iterator_to_array($xml, FALSE));
#print_r($arr[0]["Cube"]);




foreach ($xml->Currency as $curr){
    print_r($curr);
    $name=$curr->attributes()["CurrencyCode"];
    #echo "$name<br>";
}
