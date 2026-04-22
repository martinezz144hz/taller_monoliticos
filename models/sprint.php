<?php
    class Sprint {
        public $id;
        public $nombre;
        public $fecha_inicio;
        public $fecha_fin;

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

        public function getById($id) {
            $query = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";
            $stmt  = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function create($nombre, $fecha_inicio, $fecha_fin) {
            $query = "INSERT INTO {$this->table} (nombre, fecha_inicio, fecha_fin)
                    VALUES (:nombre, :fecha_inicio, :fecha_fin)";
            $stmt  = $this->conn->prepare($query);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':fecha_inicio', $fecha_inicio);
            $stmt->bindParam(':fecha_fin', $fecha_fin);
            return $stmt->execute();
        }

        public function update($id, $nombre, $fecha_inicio, $fecha_fin) {
            $query = "UPDATE {$this->table}
            SET nombre = :nombre, fecha_inicio = :fecha_inicio, fecha_fin = :fecha_fin
            WHERE id = :id";
            $stmt  = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':fecha_inicio', $fecha_inicio);
            $stmt->bindParam(':fecha_fin', $fecha_fin);
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