<!DOCTYPE html>
<html lang="ua">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Lab3</title>
</head>

<body>
    <?php
    $file_name = "oblinfo.txt";
    $file = fopen($file_name, "r");
    echo "
    <table>
    <tr>
        <th>N</th>
        <th>Область</th>
        <th>Населення, <br> тис.</th>
        <th>Кількість <br> вузлів</th>
        <th>Кількість вузлів <br> на 100тис. <br> населення</th>
    </tr>
    ";

    $index = 1;
    while ($region = fgets($file)) {
        echo "
        <tr>
            <td>$index</td>
            <td>$region</td>
        ";

        $population = fgets($file);
        $number_of_nodes = fgets($file);
        $number_of_nodes_per_population = round($number_of_nodes / $population * 100, 2);

        echo "<td>$population</td>";
        echo "<td>$number_of_nodes</td>";
        echo "<td>$number_of_nodes_per_population</td>";

        echo "
        </tr>
        ";
        $index++;
    };

    echo "
    </table>
    ";

    fclose($file);
    ?>
</body>

</html>