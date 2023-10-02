<!DOCTYPE html>
<html lang="ua">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="table-styles.css">
    <?php include 'file-manager.php' ?>
</head>

<body>
    <?php
    $index = $_POST["myname"] * 3;

    $file_manager = new File_Manager("oblinfo.txt");
    $file_manager->open_file();

    $file = $file_manager->get_file();
    $array_of_lines = create_array_of_lines($file);
    $data = find_needed_data_by_index($index, $array_of_lines);

    $file_manager->close_file();

    echo "
    <table>
        <tr>
            <th>Область</th>
            <th>Населення, <br> тис.</th>
            <th>Кількість <br> вузлів</th>
            <th>Кількість вузлів <br> на 100тис. <br> населення</th>
        </tr>
        <tr>
            <td>$data->region</td>
            <td>$data->population</td>
            <td>$data->number_of_nodes</td>
            <td>$data->number_of_nodes_per_population</td>
        </tr>
    </table>
    ";

    function create_array_of_lines($file)
    {
        $array_of_lines = array();
        while ($line = fgets($file)) {
            array_push($array_of_lines, $line);
        }
        return $array_of_lines;
    }

    function find_needed_data_by_index($index, $array_of_lines)
    {
        $data = new Data();
        $data->region = $array_of_lines[$index];
        $data->population = $array_of_lines[$index + 1];
        $data->number_of_nodes = $array_of_lines[$index + 2];
        $data->calculate_number_of_nodes_per_population();
        return $data;
    }

    class Data
    {
        public $region;
        public $population;
        public $number_of_nodes;
        public $number_of_nodes_per_population;

        public function calculate_number_of_nodes_per_population()
        {
            $this->number_of_nodes_per_population = round($this->number_of_nodes
                / $this->population * 100, 2);
        }
    }

    ?>
</body>

</html>