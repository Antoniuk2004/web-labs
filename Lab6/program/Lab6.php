<!DOCTYPE html>
<html lang='ua'>

<head>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='stylesheet' href='reset.css'>
    <link rel='stylesheet' href='styles.css'>
    <?php include 'data.php' ?>
    <script src='https://kit.fontawesome.com/e98af1ed48.js' crossorigin='anonymous'></script>
    <link rel='preconnect' href='https://fonts.googleapis.com'>
    <link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>
    <link href='https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@200;400;600&display=swap' rel='stylesheet'>
</head>

<body>
    <?php
    $city = $_GET["city"];

    $lowered_city = mb_strtolower($city);


    if ($lowered_city == '') $lowered_city = 'черкаси';


    $link = 'https://ua.sinoptik.ua/погода-' . $lowered_city;

    $data = new Data();
    $data = $data->get_data($link);

    if ($data["city_name"] == !"") {
        echo "<title>Погода {$data["city_name"]}</title>";

        echo "
    <div class='wrapper'>
        <div class='header'>
            <div class='city-name'>
                <h1>Погода {$data["city_name"]}</h1>
                <p class='date'>{$data["current_week_day"]} {$data["current_day"]} {$data["current_month"]}</p>
            </div>
            <div class='city-name-input'>
                <form action='Lab6.php'>
                    <input name='city' type='text'><button type='submit' class='submit-button'>
                        <i class='fa-solid fa-magnifying-glass'></i>
                    </button>
                </form>
            </div>
        </div>
        <div class='center'>
            <div class='left-side p-50'>
                <div class='today-weather-image-container'>
                   ";

        $current_hour = $data["current_hour"];
        render_image($data["today_weather"], 0, $current_hour);

        echo
        "
                </div>
                <div class='today-weather-container'>
                    <p class='temperature'>{$data["today_temperature"]}</p>
                    <p class='weather-description'>{$data["today_weather"]}</p>
                </div>
            </div>
            <div class='line'></div>
            <div class='right-side p-50'>
                <div class='left-side'>
                    <div class='one-column'>
                        <div class='sunrise-container'>
                            <p class='time'>{$data["sunrise_time"]}</p>
                            <p class='weather-description'>Схід</p>
                        </div>
                        <div class='sunset-container'>
                            <p class='time'>{$data["sunset_time"]}</p>
                            <p class='weather-description'>Захід</p>
                        </div>
                    </div>
                </div>
                <div class='right-side'>
                    <div class='length-of-day-container'>
                    <p class='day-duration'>{$data["day_duration"]}</p>
                    <p class='day-duration-title'>Тривалість дня</p>    
                    </div>
                </div>
            </div>
        </div>
        <div class='footer'>
            <h2>Погода сьогодні</h2>
            <div class='temperature-container'>
    ";

        $arr = $data["temperature"];
        $arr_of_weather = $data["arr_of_weather"];
        $time = $data["first_time"];
        $step = 0;
        $date = $data["date"];

        foreach ($arr as $val) {
            if ($val != 'td' && $val != '') {
                $str_time = add_addition_data($time);
                echo
                "
            <div class='temperature-card'>
            <p>$str_time</p>
            ";
                render_image($arr_of_weather[$step], $date, $time);
                echo "
            <p>$val</p>
            </div>
            ";
                $time += 3;
                $step++;
            }
        }

        "  
            </div>
        </div>
    </div>
    ";
    } else {
        echo "
        <div class='impossible'>
        <div class='wrapper'>
        <div class='city-name-input'>
        <form action='Lab6.php'>
        <input name='city' type='text'><button type='submit' class='submit-button'>
        <i class='fa-solid fa-magnifying-glass'></i>
        </button>
        </form>
        </div>
        <div class='no-forecast-container'>
        <p>Неможливо отримати<br>прогноз погоди</p>
        </div>
        </div>
        <div class=''>
        </div>
        </div>
        ";
    }

    function render_image($weather, $date, $time)
    {
        $weather = mb_strtolower($weather);
        $weather_icon = "";

        $sunrise_hours = $date->sunrise_hours;
        $sunset_hours = $date->sunset_hours;

        if ($time < $sunrise_hours || $time > $sunset_hours) {
            $time_of_day = "night";
        } else $time_of_day = "day";

        if (str_contains($weather, "ясно")) {
            if ($time_of_day == "night") {
                $weather_icon = "wi-night-clear.svg";
            } else {
                $weather_icon = "wi-day-sunny.svg";
            }
        } else if (str_contains($weather, "сні")) $weather_icon = "wi-{$time_of_day}-snow.svg";
        else if (str_contains($weather, "дощ")) $weather_icon = "wi-{$time_of_day}-rain.svg";
        else if (str_contains($weather, "хмар")) $weather_icon = "wi-{$time_of_day}-cloudy.svg";
        else $weather_icon = 'wi-na.svg';
        $img = "<img class='today-weather-image' title='{$weather}' src='svg/{$weather_icon}' alt='{$weather}'>";
        echo $img;
    }

    function add_addition_data($time)
    {
        if ($time < 10) return "0" . $time . ":00";
        else return $time . ":00";
    }
    ?>

</body>

</html>