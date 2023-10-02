<?php
class File_Manager
{
    private $file;
    private $file_name;

    function __construct($file_name)
    {
        $this->file_name = $file_name;
    }

    public function get_file()
    {
        return $this->file;
    }

    public function open_file()
    {
        $this->file = fopen($this->file_name, "r");
    }

    public function close_file()
    {
        fclose($this->file);
    }
}
