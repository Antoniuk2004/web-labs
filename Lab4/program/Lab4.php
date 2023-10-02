<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab4</title>
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="form-styles.css">
    <?php include 'file-manager.php' ?>
</head>

<body>
    <h1 class="mx-5 my-2">Виберіть спеціальність</h1>
    <?php
    $file_manager = new File_Manager("napr.txt");
    $file_manager->open_file();
    $file_manager->get_all_data_from_file();
    
    $data = $file_manager->get_data();
    $data = bubble_sort($data);
    
    echo '
    <form method="post" name action="table.php">
    ';

    foreach ($data as $value) {
        echo "
        <div class='one-line mx-5 my-2'>
            <input type='radio' name='specialty' value='$value'>$value</input>
        </div>
        ";
    }

    echo '        
        <input class="submit-button mx-5" type="submit" value="Відправити запит">
    </form>
    ';


    $file_manager->close_file();



    function bubble_sort($array)
    {
        for ($i = 0; $i < sizeof($array); $i++) {
            for ($j = 0; $j < sizeof($array) - 1; $j++) {
                if ($array[$i] < $array[$j]) {
                    $temp = $array[$i];
                    $array[$i] = $array[$j];
                    $array[$j] = $temp;
                }
            }
        }
        return $array;
    }
    ?>
</body>

</html>