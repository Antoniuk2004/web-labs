<?php
include 'date.php';

class Data
{
    public function get_data($link)
    {
        $out = $this->read_data_from_the_site($link);

        $city_name_pattern = '/<strong>(?:(.*?))<\/strong>/';
        $city_name = $this->find_one_value($city_name_pattern, $out);

        $sunrise_time_pattern = '/<span>(?:(\d{2}:\d{2}))<\/span>/';
        $sunrise_time = $this->find_one_value($sunrise_time_pattern, $out);

        $sunset_time_pattern = '/Захід\s*<span>(\d{2}:\d{2})<\/span>/';
        $sunset_time = $this->find_one_value($sunset_time_pattern, $out);

        $first_time_pattern = '/<tr class="gray time">\s*<td[^>]*>\s*([^<]+)\s*<\/td>/i';
        $first_time = $this->find_one_value($first_time_pattern, $out);

        // $date_pattern = '/<div id="infoTime">Оновлено (\d{2}.\d{2}.\d{4})/';
        // $date = $this->find_one_value($date_pattern, $out);

        $current_time_pattern = '/Оновлено\s+\d{2}\.\d{2}.\d{4}\s+о\s+(\d{2}:\d{2})/';
        $current_time = $this->find_one_value($current_time_pattern, $out);
        $current_hour = $this->get_current_hour($current_time);

        $date = new Date($sunrise_time, $sunset_time);

        $temperature_pattern = '/<tr class="temperature">(.*?)<\/tr>/';
        $temperature = $this->find_multiple_values($temperature_pattern, $out);

        $today_weather_pattern = '/<div class="img">.*?<img[^>]+alt="([^"]+)"/s';
        $today_weather = $this->find_one_value($today_weather_pattern, $out);

        $today_temperature_pattern = '/<p class="today-temp">([^<]+)<\/p>/';
        $today_temperature = $this->find_one_value($today_temperature_pattern, $out);

        $current_day_pattern = '/<p class="date[^"]*">(\d{2})<\/p>/';
        $current_day = $this->find_one_value($current_day_pattern, $out);

        $current_week_day_pattern = '/<p class="day-link".*?>(.*?)<\/p>/s';
        $current_week_day = $this->find_one_value($current_week_day_pattern, $out);

        $current_month_pattern = '/<p class="month".*?>(.*?)<\/p>/s';
        $current_month = $this->find_one_value($current_month_pattern, $out);

        $arr_of_weather_pattern = '/<div class="weatherIco[^"]+" title="([^"]+)">/';
        $arr_of_weather = $this->find_multiple_values($arr_of_weather_pattern, $out);

        $data = $this->make_array_of_values($city_name, $sunrise_time, $sunset_time, $date, $temperature, $today_weather, $today_temperature, $current_day, $current_week_day, $current_month, $arr_of_weather, $first_time, $current_hour);
        return $data;
    }

    private function make_array_of_values($city_name, $sunrise_time, $sunset_time, $date, $temperature, $today_weather, $today_temperature, $current_day, $current_week_day, $current_month, $arr_of_weather, $first_time, $current_hour)
    {
        $data = [];
        $data["city_name"] = $city_name;
        $data["sunrise_time"] = $sunrise_time;
        $data["sunset_time"] = $sunset_time;
        $data["day_duration"] = $this->get_day_duration($date);
        $data["date"] = $date;    
        $data["current_hour"] = $current_hour;  
        $data["first_time"] = (int)substr($first_time, 0, 1);
        $data["temperature"] = $this->convert_to_array($temperature[0]);
        $data["today_weather"] = $today_weather;
        $today_temperature = $this->remove_centigrade_symbol($today_temperature);
        $data["today_temperature"]  = $this->remove_plus_if_necessary($today_temperature);
        $data["current_day"] = (int)$current_day;
        $data["current_week_day"] = $current_week_day;
        $data["current_month"] = $current_month;
        $data["arr_of_weather"] = $this->remove_unnecessary_values($arr_of_weather); 
                
        return $data;
    }

    private function get_day_duration($date)
    {
        $date->calculate_time();

        $hours = $date->hours;
        $minutes = $date->minutes;

        $title = $date->get_title($hours);
        $hours_title = "{$hours} годин{$title}";

        $title = $date->get_title($minutes);
        $minutes_title = "{$minutes} хвилин{$title}";

        if ($minutes == 0) {
            return "рівно {$hours_title}";
        } else {
            return "{$hours_title} {$minutes_title}";
        }
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

    private function convert_to_array($str)
    {
        $arr = explode(" ", $str);
        $new_arr = [];
        foreach ($arr as $val) {
            if (!$this->check_if_contains($val)) {
                $val = $this->remove_unnecessary_symbol($val);
                $val = $this->remove_plus_if_necessary($val);
                array_push($new_arr, $val);
            }
        }
        return $new_arr;
    }

    private function check_if_contains($val)
    {
        if (str_contains($val, "class")) return true;
        else if (str_contains($val, "bR")) return true;
        else if (str_contains($val, '"')) return true;
        else if (str_contains($val, "cur")) return true;
        else return false;
    }

    private function remove_unnecessary_symbol($val)
    {
        return substr($val, 1);
    }

    private function remove_unnecessary_values($arr){
        return array_slice($arr, 7);   
    }

    private function remove_centigrade_symbol($val)
    {
        return substr($val, 0, strlen($val) - 1);
    }

    private function remove_plus_if_necessary($val)
    {
        $first_char = substr($val, 0, 1);
        if ($first_char == '+') {
            return substr($val, 1, strlen($val) - 1);
        } else return $val;
    }

    private function get_current_hour($current_time){
        $index = strpos($current_time, ":");
        return substr($current_time, 0, $index);
    }
}
