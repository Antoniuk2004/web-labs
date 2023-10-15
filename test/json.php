<?php
    $ip = $_POST["ip-adress"];
    $link = "http://ip-api.com/json/";

    $jsonData = getJSON($ip, $link);
    
    $countryCode = $jsonData["countryCode"];

    $data = [];
    $data["ip"] = $ip;
    $data["countryCode"] = $countryCode;
    $data["flag"] = strtolower($countryCode) . ".png";
    $data["countryName"] = $jsonData["country"];
    $data["region"] = $jsonData["region"];
    $data["regionName"] = $jsonData["regionName"];
    $data["cityName"] = $jsonData["city"];
    $data["postalCode"] = $jsonData["zip"];
    $data["lat"] = $jsonData["lat"];
    $data["lon"] = $jsonData["lon"];

    echo json_encode($data);

    function getJSON($ip, $link)
    {
        $link = $link . $ip;

        $curl = curl_init($link);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $out = curl_exec($curl);

        return json_decode($out, true);
    }
    ?>
