<?php

    class DetourModel {
        private $db;

        public function __construct($db) {
            $this->db = $db;
        }

        public function getDetours() {
            $sql = "SELECT * FROM detour ORDER BY id ASC";
            return $this->db->query($sql);
        }
    }

?>