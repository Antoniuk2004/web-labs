<?php
function printIpInformation($message, $ip)
{
    echo
    "<div class='ip-details-container'>
        <p style='padding-right: 10px;' class='regular'>IP details for $ip\0</p>
    ";
    if ($message == "invalid query") {
        echo "<span style='color: red;'>[Invalid IP Adress]</span>";
    } else if ($message == "reserved range" || $message == 'private range') {
        echo "<span style='color: green;'>[Reversed IP Adress]</span>";
    }
    echo "</div>";
}

function printPElement($text, $className)
{
    echo "<p class='$className'>$text</p>";
}

function printImage($countryCode)
{
    if ($countryCode == "") $countryCode = "_unitednations";
    $flag = "images/" . strtolower($countryCode) . ".png";

    echo "
        <div class='flag-row-container'>
        <p class='regular'>Flag: </p>
        <img src=\"$flag\" alt=\"$flag\"></img>
        </div>
        ";
}

function printWrong($ip, $message, $countryCode)
{
    printIpInformation($message, $ip);
    printPElement("Geolocation Information", "special");
    printPElement("Country Code: N/A", "regular");
    printImage($countryCode);
    printPElement("Region Name: N/A", "regular");
    printPElement("Region: N/A", "regular");
    printPElement("City: N/A", "regular");
    printPElement("Postal Code: N/A", "regular");
    printPElement("Latitude: N/A", "regular");
    printPElement("Longitude: N/A", "regular");
}
