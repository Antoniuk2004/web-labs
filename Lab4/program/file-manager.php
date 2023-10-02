<?php
class File_Manager
{
    private $file;
    private $file_name;
    private $data;

    function __construct($file_name)
    {
        $this->file_name = $file_name;
    }

    public function get_file()
    {
        return $this->file;
    }

    public function get_data()
    {
        return $this->data;
    }

    public function open_file()
    {
        $this->file = fopen($this->file_name, "r");
    }

    public function close_file()
    {
        fclose($this->file);
    }

    public function get_all_data_from_file()
    {
        $data = array();
        while ($line = fgets($this->file)) {
            $line = str_replace("\n", "", $line);
            $line = str_replace("\r", "", $line);

            array_push($data, $line);
        }
        $this->data = $data;
    }
}
