<?php
include 'date.php';

class Data
{
    public function get_data($link)
    {
        $out = $this->read_data_from_the_site($link);

        echo $out;

        $temperature_pattern = '/<span class="goods-tile__title">(.*?)<\/span>/';
        $array_of_product_names = $this->find_multiple_values($temperature_pattern, $out);

        $data = $this->create_array_of_data($array_of_product_names, null);
        // $today_weather_pattern = '/<div class="img">.*?<img[^>]+alt="([^"]+)"/s';
        // $today_weather = $this->find_one_value($today_weather_pattern, $out);

        // $today_temperature_pattern = '/<p class="today-temp">([^<]+)<\/p>/';
        // $today_temperature = $this->find_one_value($today_temperature_pattern, $out);

        return $data;
    }

    private function create_array_of_data($array_of_product_names, $array_of_product_prices){
        
        $data = [];
        $data["c"] = ["1", "2"];
        $data["a"] = $array_of_product_names;
        $data["b"] = $array_of_product_prices;
        return $data;
    }

    private function read_data_from_the_site($link)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $out = curl_exec($curl);
        return $out;
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
