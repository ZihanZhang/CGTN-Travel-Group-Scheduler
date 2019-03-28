<?php
    class WorkDay {
        public $name;
        public $limit;
        // public $person1;
        // public $person2;
        // public $person3;
        // public $person4;
        // public $person5;
        public $people = array();
        public function __construct($name) {
            $this->name = $name;
            if ($name == "Saturday" || $name == "Sunday") {
                $this->limit = 2;
            }
            else {
                $this->limit = 3;
            }
            // $this->person1 = new Person("123", 1,1,1,1,1,1,1);
            // $this->person2 = new Person("123", 1,1,1,1,1,1,1);
            // $this->person3 = new Person("123", 1,1,1,1,1,1,1);
            // $this->person4 = new Person("123", 1,1,1,1,1,1,1);
            // $this->person5 = new Person("123", 1,1,1,1,1,1,1);
        }
    }
?>