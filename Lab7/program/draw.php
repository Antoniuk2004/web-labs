<?php

class Draw
{
    private $im;
    private $width;
    private $height;
    private $font;
    private $gap_width;
    private $first_hour_pos;
    private $last_hour_pos;

    public function __construct($width, $height)
    {
        $this->width = $width;
        $this->height = $height;
    }

    public function draw_timeline($padding_x, $padding_y, $color, $data, $font_size)
    {
        $x2 = $this->width - $padding_x;
        $y = $this->height - $padding_y;

        list($gap_width, $x) = $this->do_calcs($padding_x);

        $this->draw_line($padding_x, $y, $x2, $y, $color);
        $this->draw_numbers($x, $gap_width, $data, $y, $color, $font_size);
        $this->draw_dashes($x, $gap_width, $data, $y, $color, $font_size);
    }

    private function draw_numbers($x, $gap_width, $data, $y, $color, $font_size)
    {
        $hour = $data["first_time"];
        $arr = $data["temperature"];
        $y += $font_size + 10;
        foreach ($arr as $value) {
            $this->draw_text_in_the_middle($font_size, $hour, $color, $x, $y);
            $hour += 3;
            $x += $gap_width;
        }
    }

    private function do_calcs($padding_x)
    {
        $timeline_width = $this->width - 2 * $padding_x;
        $gap_width = $timeline_width / 7;
        $this->gap_width = $gap_width;
        $x = $padding_x;
        return [$gap_width, $x];
    }

    private function draw_dashes($x, $gap_width, $data, $y, $color, $font_size)
    {
        $hour = $data["first_time"];
        $arr = $data["temperature"];
        foreach ($arr as $value) {
            $this->draw_line($x, $y, $x, $y - $font_size / 2, $color);
            $hour += 3;
            $x += $gap_width;
        }
    }

    public function get_canvas()
    {
        return $this->im;
    }

    public function draw_canvas()
    {
        imagepng($this->im);
        imagedestroy($this->im);
    }

    public function create_color($red, $green, $blue)
    {
        return imagecolorallocate($this->im, $red, $green, $blue);
    }

    public function draw_text($size, $x, $y, $color, $text)
    {
        imagefttext($this->im, $size, 0, $x, $y, $color, $this->font, $text);
    }

    public function draw_line($x1, $y1, $x2, $y2, $color)
    {
        imageline($this->im, $x1, $y1, $x2, $y2, $color);
    }

    public function set_font($font)
    {
        $this->font = $font;
    }

    public function draw_city_and_date($color, $city, $date, $font_size)
    {
        $text = "м. " . $city . " " . $date;
        $bbox = imagettfbbox($font_size, 0, $this->font, $text);
        $text_width = $bbox[2] - $bbox[0];
        $x = ($this->width - $text_width) / 2;
        $y = $this->height - 10;
        $this->draw_text($font_size, $x, $y, $color, $text);
    }

    private function draw_text_in_the_middle($font_size, $text, $color, $x, $y)
    {
        $bbox = imagettfbbox($font_size, 0, $this->font, $text);
        $text_width = $bbox[2] - $bbox[0];
        $x = $x - $text_width / 2;
        $this->draw_text($font_size, $x, $y, $color, $text);
    }

    public function create_canvas()
    {
        $width = $this->width;
        $height = $this->height;

        $this->im = @imagecreatetruecolor($width, $height);
        imageantialias($this->im, true);
    }

    public function draw_two_moons($percentage)
    {
        $file_name = "images/moon_sm.png";

        $image = imagecreatefrompng($file_name);
        $width = imagesx($image);
        $height = imagesy($image);

        $new_width = $this->height * $percentage / 100;
        $new_height = $this->height * $percentage / 100;

        $offset = $this->height / 40;
        imagecopyresized($this->im, $image, $offset, $offset, 0, 0, $new_width, $new_height, $width, $height);

        $second_offshet = $this->width - $new_width - $offset;
        imagecopyresized($this->im, $image, $second_offshet, $offset, 0, 0, $new_width, $new_height, $width, $height);
    }

    public function draw_sun($percentage)
    {
        $file_name = "images/sun_sm.png";

        $image = imagecreatefrompng($file_name);
        $width = imagesx($image);
        $height = imagesy($image);

        $new_width = $this->height * $percentage / 100;
        $new_height = $this->height * $percentage / 100;

        $offset = $this->height / 40;
        $second_offshet = $this->width / 2 - $new_width / 2;
        imagecopyresized($this->im, $image, $second_offshet, $offset, 0, 0, $new_width, $new_height, $width, $height);
    }

    public function draw_sun_light($padding_x, $padding_y, $data)
    {
        $file_name = "images/center.png";

        list($gap_width, $x) = $this->do_calcs($padding_x);
        $this->gap_width = $gap_width;

        $image = imagecreatefrompng($file_name);
        $width = imagesx($image);
        $height = imagesy($image);

        list($left_margin, $right_margin) = $this->calculate_sun_light_image_position($padding_x, $data);

        $this->first_hour_pos = $left_margin;
        $this->last_hour_pos = $this->width - $right_margin - $gap_width / 3;

        $left_margin += $gap_width / 3;
        $right_margin += $gap_width / 3;

        $new_width = $this->width - $left_margin - $right_margin;
        $new_height = $this->height;
        imagecopyresized($this->im, $image, $left_margin - 1, 0, 0, 0, $new_width + 2, $new_height - $padding_y, $width, $height);
    }

    public function calculate_sun_light_image_position($padding_x, $data)
    {
        $one_hour_width = $this->gap_width / 3;

        $date = $data["date"];
        $sunrise_hours = $date->sunrise_hours;
        $sunrise_minutes = $date->sunrise_minutes;
        $sunrise_time = $sunrise_hours + $sunrise_minutes / 60;


        // $white_color = $this->create_color(255, 255, 255);
        // $this->draw_text(30, 200, 200, $white_color, $sunrise_time);


        $sunset_hours = $date->sunset_hours;
        $sunset_minutes = $date->sunset_minutes;
        $sunset_time = $sunset_hours + $sunset_minutes / 60;

        $first_hour = $data["first_time"];
        $last_hour = 21 + $first_hour;

        // $white_color = $this->create_color(255, 255, 255);
        // $this->draw_text(30, 100, 200, $white_color, $sunset_minutes);

        $left_margin = ($sunrise_time - $first_hour) * $one_hour_width + $padding_x;
        $right_margin = ($last_hour - $sunset_time) * $one_hour_width + $padding_x;
        return [$left_margin, $right_margin];
    }

    public function draw_left_image($padding_y)
    {
        $file_name = "images/left.png";

        $image = imagecreatefrompng($file_name);
        $width = imagesx($image);
        $height = imagesy($image);

        $new_width = $this->gap_width / 3;
        $new_height = $this->height - $padding_y;
        imagecopyresized($this->im, $image, $this->first_hour_pos, 0, 0, 0, $new_width, $new_height, $width, $height);
    }

    public function draw_right_image($padding_y)
    {
        $file_name = "images/right.png";

        $image = imagecreatefrompng($file_name);
        $width = imagesx($image);
        $height = imagesy($image);

        $new_width = $this->gap_width / 3;
        $new_height = $this->height - $padding_y;
        imagecopyresized($this->im, $image, $this->last_hour_pos, 0, 0, 0, $new_width, $new_height, $width, $height);
    }

    public function draw_weather_graph($data, $color, $font_size, $padding_x, $padding_y)
    {
        imageantialias($this->im, true);

        $weather = $data["temperature"];

        $max_y = ($this->height - $padding_y - $font_size / 2);
        $min_y = 100;

        $max_value = $this->find_max($weather);
        $min_value = $this->find_min($weather);

        $graph_height = $max_y - $min_y;

        list($arr_of_x_values, $arr_of_y_values) = $this->draw_weather_graph_numbers($weather, $max_value, $min_value, $graph_height, $color, $padding_x, $font_size, $padding_y);

        $this->draw_weather_graph_curve($arr_of_x_values, $arr_of_y_values, $padding_x, $font_size, $color);
    }

    private function draw_weather_graph_numbers($weather, $max_value, $min_value, $graph_height, $color, $x, $font_size, $padding_y)
    {
        $max_y = 300;
        $min_y = $padding_y + $font_size;

        $graph_height = $max_y - $min_y;

        $arr_of_y_values = [];
        $arr_of_x_values = [];
        foreach ($weather as $value) {
            $percentage = ($value - $min_value) / ($max_value - $min_value);
            $y = $min_y + $percentage * $graph_height;
            $y*= -1;
            $y += $this->height;
            $value = str_contains($value, "-") || $value == "0" ? $value : "+" . $value;
            $this->draw_text_in_the_middle($font_size, $value, $color, $x, $y);
            array_push($arr_of_y_values, $y);
            array_push($arr_of_x_values, $x - $font_size);
            $x += $this->gap_width;
        }
        return [$arr_of_x_values, $arr_of_y_values];
    }

    private function draw_weather_graph_curve($arr_of_x_values, $arr_of_y_values, $padding_x, $font_size, $color)
    {
        for ($index = 0; $index < sizeof($arr_of_x_values) - 1; $index++) {
            $x1 = $arr_of_x_values[$index] + $padding_x;
            $y1 = $arr_of_y_values[$index];

            $x2 = $arr_of_x_values[$index + 1] + $padding_x;
            $y2 = $arr_of_y_values[$index + 1];
            $this->draw_line($x1, $y1 + $font_size / 2, $x2, $y2 + $font_size / 2, $color);
        }
    }

    private function find_max($arr)
    {
        $max = PHP_INT_MIN;
        for ($index = 0; $index < sizeof($arr); $index++) {
            $value = (int)$arr[$index];
            if ($value > $max) {
                $max = $value;
            }
        }
        return $max;
    }

    private function find_min($arr)
    {
        $min = PHP_INT_MAX;
        for ($index = 0; $index < sizeof($arr); $index++) {
            $value = (int)$arr[$index];
            if ($value < $min) {
                $min = $value;
            }
        }
        return $min;
    }
}
