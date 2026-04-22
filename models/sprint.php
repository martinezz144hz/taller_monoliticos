<?php
    class Sprint {
        private $conn;
        private $table = "sprints";

        public function __construct($db) {
            $this->conn = $db;
        }
        
        public function getAll() {
        $query = "SELECT * FROM {$this->table} ORDER BY id DESC";
        $stmt  = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
        }

        public function create(Sprint $sprint) {
            $query = "INSERT INTO {$this->table} (nombre, fecha_inicio, fecha_fin)
                    VALUES (:nombre, :fecha_inicio, :fecha_fin)";
            $stmt  = $this->conn->prepare($query);
            $stmt->bindParam(':nombre',       $sprint->nombre);
            $stmt->bindParam(':fecha_inicio', $sprint->fecha_inicio);
            $stmt->bindParam(':fecha_fin',    $sprint->fecha_fin);
            return $stmt->execute();
        }

        public function update(Sprint $sprint) {
            $query = "UPDATE {$this->table}
            SET nombre = :nombre, fecha_inicio = :fecha_inicio, fecha_fin = :fecha_fin
            WHERE id = :id";
            $stmt  = $this->conn->prepare($query);
            $stmt->bindParam(':id',           $sprint->id);
            $stmt->bindParam(':nombre',       $sprint->nombre);
            $stmt->bindParam(':fecha_inicio', $sprint->fecha_inicio);
            $stmt->bindParam(':fecha_fin',    $sprint->fecha_fin);
            return $stmt->execute();
        }

        public function delete($id) {
            $query = "DELETE FROM {$this->table} WHERE id = :id";
            $stmt  = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        }
        
    }
?>