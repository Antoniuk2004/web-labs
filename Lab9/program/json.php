<?php
include "printFunctions.php";

$ip = $_POST["ip-adress"];
$link = "http://ip-api.com/json/";

$jsonData = getJSON($ip, $link);

$status = $jsonData["status"];
$countryCode = $jsonData["countryCode"];

if ($status === "fail") {
    $message =  $jsonData["message"];

    printWrong($ip, $message, $countryCode);
} else {
    printIpInformation($jsonData, $ip);
    printPElement("Geolocation Information", "special");
    printPElement("Country Code: {$jsonData["countryCode"]}", "regular");
    printImage($jsonData["countryCode"]);
    printPElement("Region Name: {$jsonData["regionName"]}", "regular");
    printPElement("Region: {$jsonData["region"]}", "regular");
    printPElement("City: {$jsonData["city"]}", "regular");
    printPElement("Postal Code: {$jsonData["zip"]}", "regular");
    printPElement("Latitude: {$jsonData["lat"]}", "regular");
    printPElement("Longitude: {$jsonData["lon"]}", "regular");
}


function getJSON($ip, $link)
{
    $link = $link . $ip;

    $curl = curl_init($link);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $out = curl_exec($curl);

    return json_decode($out, true);
}
