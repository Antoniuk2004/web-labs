<?php
class Date
{
    public $hours;
    public $minutes;
    public $sunrise_minutes;
    public $sunset_minutes;
    public $sunrise_hours;
    public $sunset_hours;

    public function __construct($sunrise_time, $sunset_time)
    {
        $this->sunrise_minutes = (int)substr($sunrise_time, 3);
        $this->sunset_minutes = (int)substr($sunset_time, 3);

        $this->sunrise_hours = (int)substr($sunrise_time, 0, 3);
        $this->sunset_hours = (int)substr($sunset_time, 0, 3);

        // if ($this->sunset_minutes < $this->sunrise_minutes) $this->sunset_minutes += 60;
    }

    public function calculate_time()
    {
        $this->minutes = $this->sunset_minutes - $this->sunrise_minutes;
        $this->hours = $this->sunset_hours - $this->sunrise_hours;
    }

    public function get_title($time)
    {
        $title = "";
        if (in_array($time % 10, [2, 3, 4]) && !in_array($time, [12, 13, 14])) {
            $title =  "и";
        } else if ($time % 10 == 1 && $time != 11) $title =  "а";
        return $title;
    }
}
