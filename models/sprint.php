<?php
    class Sprint {
        private $conn;
        private $table = "sprints";

        public function __construct($db) {
            $this->conn = $db;
        }
        
    }
?>