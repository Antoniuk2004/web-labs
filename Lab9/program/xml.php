<?php
include "printFunctions.php";

$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];

$url = 'http://ip-api.com/xml/' . $ip;
$xml = simplexml_load_file($url);

$status = $xml->status;

if ($status == "fail") {
    $message =  $xml->message;
    printWrong($ip, $message, $xml->countryCode);
} else {
    printIpInformation($jsonData, $xml->query);
    printPElement("Geolocation Information", "special");
    printPElement("Country Code: {$xml->countryCode}", "regular");
    printImage($xml->countryCode);
    printPElement("Region Name: {$xml->regionName}", "regular");
    printPElement("Region: {$xml->region}", "regular");
    printPElement("City: {$xml->city}", "regular");
    printPElement("Postal Code: {$xml->zip}", "regular");
    printPElement("Latitude: {$xml->lat}", "regular");
    printPElement("Longitude: {$xml->lon}", "regular");
}
