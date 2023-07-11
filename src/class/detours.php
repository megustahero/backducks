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
        // GET every detour
        public function getDetours(){
            $sqlQuery = "SELECT id, parcel_number, type, delivery_day, insert_date FROM " . $this->db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }
        // CREATE a detour
        public function createDetour(){
            $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
                        SET
                            parcel_number = :parcel_number,
                            type = :type,
                            delivery_day = :delivery_day,
                            insert_date = now()";
            
            $stmt = $this->conn->prepare($sqlQuery);

            // satanize
            $this->parcel_number=htmlspecialchars(strip_tags($this->parcel_number));
            $this->type=htmlspecialchars(strip_tags($this->type));
            $this->delivery_day=htmlspecialchars(strip_tags($this->delivery_day));
            
            // binding
            $stmt->bindParam(":parcel_number", $this->parcel_number);
            $stmt->bindParam(":type", $this->type);
            $stmt->bindParam(":deliver_day", $this->delivery_day);
            
            if($stmt->execute()){
                return true;
            }
            return false;
        }

        // READ a detour
        
    }
?>