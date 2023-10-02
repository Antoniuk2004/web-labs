<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab4</title>
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="form-styles.css">
    <link rel="stylesheet" href="table-styles.css">
    <?php include 'file-manager.php' ?>
    <?php include 'data.php' ?>
</head>

<body>
    <?php
    $specialty = $_POST["specialty"];
    echo "
    <h1 class='mx-5 my-2'>Назва спеціальності: $specialty</h1>
    ";
    $file_manager = new File_Manager("data.txt");
    $file_manager->open_file();
    $file_manager->get_all_data_from_file();
    $arr_of_data = $file_manager->get_data();

    $data = new Data();
    $new_data = $data->manipulate_data($arr_of_data);

    $file_manager->close_file();

    echo "
    <div class='table-container'>
        <table>
            <tbody>
                <tr>
                    <th>N</th>
                    <th>Середній бал<br>поступивших<br>на бюджет</th>
                    <th>Кількість<br>поступивших<br>на бюджет</th>
                    <th>Недобір</th>
                    <th>Кількість<br>контрактників</th>
                    <th>ВНЗ</th>
                </tr>
    ";

    $rows = $new_data[$specialty];

    foreach ($rows as $index => $row) {
        $number = $index + 1;
        $number_of_contract_student = $row->number_of_contract_students;
        $arr_of_data = edit_shortage_and_number_of_contract_students($number_of_contract_student);
        $number_of_contract_student = $arr_of_data[0];
        $shortage = $arr_of_data[1];

        echo "
        <tr>
            <td>$number</td>
            <td>$row->avg_points</td>
            <td>$row->number_of_budget_students</td>
            <td>$shortage</td>
            <td>$number_of_contract_student</td>
            <td>$row->name</td>
        </tr>
        ";
    }
    echo "
            </tbody>
        </table>
    </div>
    "
    ?>


    <?php
    function edit_shortage_and_number_of_contract_students($number_of_contract_students)
    {
        $shortage = '-';
        if ($number_of_contract_students < 0){
            $number_of_contract_students = '-';
            $shortage = '+';
        }
        else if ($number_of_contract_students == 0) $number_of_contract_students = '-';
        return [$number_of_contract_students, $shortage];
    }
    ?>

</body>

</html>