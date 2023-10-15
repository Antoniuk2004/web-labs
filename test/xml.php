<?php

$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];


$url = 'http://ip-api.com/xml/' . $ip;
$xml = simplexml_load_file($url);


echo "IP Address: {$xml->query}\n";
echo "City: {$xml->city}\n";
echo "Country: {$xml->country}\n";

?>
