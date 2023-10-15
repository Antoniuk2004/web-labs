<?php

class Data
{
    public function getData($pageNumber, $productName)
    {
        $html = $this->getPageByUrl($pageNumber, $productName);

        $imagesPattern = '/<img[^>]+src=["\']([^"\']+\.jpg)["\']/i';
        $arrOfImages = $this->find_multiple_values($imagesPattern, $html);
        
        $titlesPattern = '/<h3[^>]+class=["\']br-pp-desc br-pp-ipd-hidden[^>]*>[^<]*<a[^>]+href=["\'][^"\']*["\'][^>]*>([^<]+)<\/a>/i';
        $arrOfTitles = $this->find_multiple_values($titlesPattern, $html);

        $pricesPattern = '/<div\s*class\s*=\s*["\']br-pp-ss[^>]*>.*?<span\s*itemprop\s*=\s*["\']price["\'][^>]*>(\d+)<\/span>/is';
        $arrOfPrices = $this->find_multiple_values($pricesPattern, $html);

        $descriptionPattern = '/<div\s*class\s*=\s*["\']br-pp-i[^>]*>\s*([^<]*)\s*<\/div>/is';
        $arrOfDescriptions = $this->find_multiple_values($descriptionPattern, $html);

        $numberOfPagesPattern = '/<a[^>]*>(\d+)<\/a>/'; 
        $arrOfPagesNumbers = $this->find_multiple_values($numberOfPagesPattern, $html);

        $data = [];
        $data["arrOfImages"] = $arrOfImages;
        $data["arrOfTitles"] = $arrOfTitles;
        $data["arrOfPrices"] = $arrOfPrices;
        $data["arrOfDescriptions"] = $arrOfDescriptions;
        $data["numberOfPages"] = end($arrOfPagesNumbers);
        return $data;
    }

    function getPageByUrl($pageNumber, $productName)
    {
        $productName = str_replace(" ", "%20", $productName);
        $url = "https://brain.com.ua/ukr/search/page=" . $pageNumber . "/?Search=" . $productName;

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);

        $result = curl_exec($curl);

        return $result;
    }

    private function find_one_value($pattern, $out)
    {
        preg_match($pattern, $out, $matches);
        return $matches[1];
    }

    private function find_multiple_values($pattern, $html)
    {
        preg_match_all($pattern, $html, $matches);
        return $matches[1];
    }
}
