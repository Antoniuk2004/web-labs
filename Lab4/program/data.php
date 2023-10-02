<?php
class Data
{
    public function manipulate_data($old_data)
    {
        $new_data = [];
        $is_new_speciality = false;
        $previous_speciality = "";
        
        for ($index = 0; $index < sizeof($old_data); $index++) {
            $value = $old_data[$index];
            if ($value == "") {
                $is_new_speciality = true;
            } else if ($is_new_speciality) {
                $previous_speciality = $value;
                $new_data[$value] = [];
                $is_new_speciality = false;
                $index += 1;
            } else {
                $row = $this->create_new_row($old_data, $index);
                array_push($new_data[$previous_speciality], $row);
                $index += 3;
            }
        }
        return $new_data;
    }

    private function create_new_row($old_data, $index)
    {
        $avg_points = $old_data[$index];
        $number_of_budget_students = $old_data[$index + 1];
        $number_of_contract_students = $old_data[$index + 2];
        $name = $old_data[$index + 3];
        $row = new Row($avg_points, $number_of_budget_students, $number_of_contract_students, $name);
        return $row;
    }
}

class Row
{
    public $avg_points;
    public $number_of_budget_students;
    public $number_of_contract_students;
    public $name;
    public function __construct($avg_points, $number_of_budget_students, $number_of_contract_students, $name)
    {
        $this->avg_points = $avg_points;
        $this->number_of_budget_students = $number_of_budget_students;
        $this->number_of_contract_students = $number_of_contract_students;
        $this->name = $name;
    }
}
