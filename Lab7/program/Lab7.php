<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab7</title>
    <script src='https://kit.fontawesome.com/e98af1ed48.js' crossorigin='anonymous'></script>
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="styles.css">
    <link href='https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@200;400;600&display=swap' rel='stylesheet'>
    <?php include "data.php"?>
</head>

<body>
    <div class='wrapper'>
        <form action='Lab7.php'>
            <input name='city' type='text'><button type='submit' class='submit-button'>
                <i class='fa-solid fa-magnifying-glass'></i>
            </button>
        </form>
        <?php
        $width = 1000;
        $height = 400;
        $font_size = 25;
        $padding_x = 25;
        $padding_y = 80;
        $city = mb_strtolower($_GET["city"]);
        $link = "http://localhost:3000/weather.php?city={$city}&width={$width}&height={$height}&font-size={$font_size}&padding-x={$padding_x}&padding-y={$padding_y}";
        
        $link2 = "https://ua.sinoptik.ua/погода-{$city}";
        $data = new Data();
        $data_array = $data->get_data($link2);
        $city = $data_array["city_name"];
        echo "
        <p>Погода $city</p>
        <div class='custom-city-weather-container'>
        <img src=\"{$link}\" alt=\"{$link}\">
        </div>
        ";
        ?>
        <p class='weather-in-ukrainian-cities'>Погода в містах України</p>
        <div class='weather-in-ukraine-container'>
            <?php
            $arr_of_cities = ["Черкаси", "Київ", "Харків", "Одеса"];
            foreach ($arr_of_cities as $element) {
                $link = "http://localhost:3000/weather.php?city={$element}&width={$width}&height={$height}&font-size={$font_size}&padding-x={$padding_x}&padding-y={$padding_y}";
                echo "<img class='ukrainian-city' src=\"{$link}\" alt=\"{$link}\">";
            }
            ?>
        </div>
        <p class='weather-in-ukrainian-cities'>Погода в світі</p>
        <div class='weather-in-the-world-container'>
            <?php
            $arr_of_cities = ["Лондон", "Барселона", "Тампере", "Єллоунайф"];
            foreach ($arr_of_cities as $element) {
                $link = "http://localhost:3000/weather.php?city={$element}&width={$width}&height={$height}&font-size={$font_size}&padding-x={$padding_x}&padding-y={$padding_y}";
                echo "<img class='ukrainian-city' src=\"{$link}\" alt=\"{$link}\">";
            }
            ?>
        </div>
    </div>

</body>

</html>