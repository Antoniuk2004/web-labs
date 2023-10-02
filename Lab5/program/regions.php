<?php
    class Regions
    {
        private $array_of_regions = array();
        private $file;

        function __construct($file)
        {
            $this->file = $file;
        }

        public function get_array_of_regions()
        {
            return $this->array_of_regions;
        }

        public function create_array_of_regions()
        {
            $index = 0;
            while ($region = fgets($this->file)) {
                if ($index % 3 == 0) {
                    array_push($this->array_of_regions, $region);
                }
                $index++;
            }
        }
    }
