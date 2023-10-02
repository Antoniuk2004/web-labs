<!DOCTYPE html>
<html lang="ua">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab5</title>
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="menu-styles.css">
    <?php include 'regions.php' ?>
    <?php include 'file-manager.php' ?>
</head>

<body>
    <p class="title">Виберіть область:</p>
    <form method="post" action="table.php">
        <select name="myname" id="">
            <?php
            $file_manager = new File_Manager("oblinfo.txt");
            $file_manager->open_file();
            $file = $file_manager->get_file();

            $regions = new Regions($file);
            $regions->create_array_of_regions();
            $array_of_regions = $regions->get_array_of_regions();

            $array_length = count($array_of_regions);
            for ($index = 0; $index < $array_length; $index++) {
                $value = $array_of_regions[$index];
                echo "<option value=\"$index\">$value</option>";
            }

            $file_manager->close_file();
            ?>
        </select>
        <input type="submit" value="Відправити запит">
    </form>
</body>

</html>
