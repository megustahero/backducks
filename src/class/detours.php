<?php
    class Detour{
        //Connection to my db
        private $conn;
        //Define the table where detours are stored
        private $db_table = "detour";
        //Columns in the table
        public $id;
        public $parcel_number;
        public $type;
        public $delivery_day;
        public $insert_date;
        // DB connection
        public function __construct($db){
            $this->conn = $db;
        }
        // Get everything
        public function getDetours(){
            $sqlQuery = "SELECT id, parcel_number, type, delivery_day, insert_date FROM " . $this->db_table . "";
            $alldet = $this->conn->prepare($sqlQuery);
            $alldet->execute();
            return $alldet;
        }
    }
?>