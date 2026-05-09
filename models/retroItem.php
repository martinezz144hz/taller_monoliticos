<?php
require_once __DIR__ . '/dataBase.php';
    class RetroItem {
        public $id;
        public $sprint_id;
        public $categoria;
        public $descripcion;

        private PDO    $conn;
        private string $table = "retro_items";


        public function __construct() {
            $this->conn = Database::getInstance();
        }

        public function getAll()
        {   
            $query = "SELECT * FROM {$this->table}";
            $stmt  = $this->conn->prepare($query);            
            $stmt->execute();            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getWithSprint() {
            $query = "SELECT s.nombre as sprint, r.categoria, r.descripcion FROM {$this->table} r 
                INNER JOIN sprints s ON r.sprint_id = s.id";
            $stmt  = $this->conn->prepare($query);            
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function create($sprint_id, $categoria, $descripcion) {
            $query = "INSERT INTO {$this->table} (sprint_id, categoria, descripcion)
                    VALUES (:sprint_id, :categoria, :descripcion)";
            $stmt  = $this->conn->prepare($query);
            $stmt->bindParam(':sprint_id', $sprint_id);
            $stmt->bindParam(':categoria', $categoria);
            $stmt->bindParam(':descripcion', $descripcion);
            return $stmt->execute();
        }

        public function getPreviousActions($sprint_id) {
            $query = "SELECT * FROM retro_items
                    WHERE sprint_id = (
                        SELECT MAX(id) FROM sprints WHERE id < :id
                    )
                    AND categoria = 'accion'";
            $stmt  = $this->conn->prepare($query);
            $stmt->bindParam(':id', $sprint_id);
            $stmt->execute();
            return $stmt;
        }

        public function marcarCumplida($id) {
            $query = "UPDATE {$this->table} SET cumplida = 1 WHERE id = :id";
            $stmt  = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        }

        public function getById($id) {
            $query = "SELECT * FROM {$this->table} WHERE id = :id";
            $stmt  = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function update($id, $categoria, $descripcion) {
            $query = "UPDATE {$this->table}
                    SET categoria = :categoria, descripcion = :descripcion
                    WHERE id = :id";
            $stmt  = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':categoria', $categoria);
            $stmt->bindParam(':descripcion', $descripcion);
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