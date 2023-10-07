<?php

$url = "https://rozetka.com.ua/ua/search/?text=%D0%BC%D0%B0%D1%88%D0%B8%D0%BD%D0%B0";

$ch = curl_init($url);

// Set cURL options
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_MAXREDIRS, 5); // Set a maximum number of redirects

// Execute cURL session and get the content
$response = curl_exec($ch);

// Check for cURL errors
if (curl_errno($ch)) {
    echo 'Curl error: ' . curl_error($ch);
}

// Close cURL session
curl_close($ch);

// Create a DOMDocument object
$dom = new DOMDocument();

// Load HTML content into the DOMDocument
$dom->loadHTML($response);

// Example: Extract and display image URLs
$images = $dom->getElementsByTagName('img');
foreach ($images as $image) {
    $src = $image->getAttribute('src');
    echo 'Image URL: ' . $src . '<br>';
}

// Example: Extract and display goods names
$names = $dom->getElementsByTagName('h2');
foreach ($names as $name) {
    echo 'Goods Name: ' . $name->nodeValue . '<br>';
}
?>
