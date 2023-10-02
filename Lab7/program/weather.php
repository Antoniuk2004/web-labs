<!DOCTYPE html>
<html lang="ua">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php include 'draw.php' ?>
    <?php include 'data.php' ?>
</head>

<body>
    <?php
    $city = $_GET["city"];
    $lowered_city = mb_strtolower($city);
    if ($lowered_city == '') $lowered_city = 'черкаси';

    $width = $_GET["width"];
    $height = $_GET["height"];
    $padding_x = $_GET["padding-x"];
    $padding_y = $_GET["padding-y"];
    $font_size = $_GET["font-size"];

    $link = 'https://ua.sinoptik.ua/погода-' . $lowered_city;

    $data = new Data();
    $data = $data->get_data($link);
    $first_hour = $data["current_hour"];
    $date = $data["full_date"];

    ob_end_clean();
    header('Content-Type: image/png');

    $draw = new Draw($width, $height);
    $draw->create_canvas();
    $draw->set_font('fonts/Finlandica-Regular.ttf');

    $white_color = $draw->create_color(255, 255, 255);
    $red_color = $draw->create_color(255, 0, 0);
    $blue_color = $draw->create_color(0, 0, 255);

    $percentage = 30;
    $draw->draw_sun_light($padding_x, $padding_y, $data);
    $draw->draw_left_image($padding_y);
    $draw->draw_right_image($padding_y);
    $draw->draw_two_moons($percentage);
    $draw->draw_sun($percentage);

    $draw->draw_timeline($padding_x, $padding_y, $blue_color, $data, $font_size);

    $capitalized_city = capitalize($city);
    $draw->draw_city_and_date($white_color, $capitalized_city, $date, $font_size);

    $draw->draw_weather_graph($data, $red_color, $font_size, $padding_x, $padding_y);

    $draw->draw_canvas();

    function capitalize($string)
    {
        $fist_char = mb_substr($string, 0, 1);
        $fist_char = mb_strtoupper($fist_char);
        return $fist_char . mb_substr($string, 1);
    }
    ?>

</body>

</html>