<?php
require_once __DIR__ . '/dataBase.php';

class RetroItem {
    public $id;
    public $sprint_id;
    public $categoria;
    public $descripcion;
    public $cumplida;

    private PDO $conn;
    private string $table = "retro_items";

    public function __construct() {
        $this->conn = Database::getInstance();
    }

    public function getAll(): array {
        $sql = "SELECT * FROM {$this->table}";
        $stmt = $this->conn->prepare($sql);            
        $stmt->execute();            
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getWithSprint(): array {
        $sql = "SELECT s.nombre AS sprint, r.categoria, r.descripcion, r.cumplida 
                FROM {$this->table} r 
                INNER JOIN sprints s ON r.sprint_id = s.id";
        $stmt = $this->conn->prepare($sql);            
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function create(int $sprint_id, string $categoria, string $descripcion): bool {
        $sql = "INSERT INTO {$this->table} (sprint_id, categoria, descripcion, cumplida)
                VALUES (:sprint_id, :categoria, :descripcion, 0)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':sprint_id', $sprint_id, PDO::PARAM_INT);
        $stmt->bindParam(':categoria', $categoria, PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        return $stmt->execute();
    }

    
    public function getPreviousActions(int $sprint_id): array {
        $sql = "SELECT * FROM {$this->table}
                WHERE sprint_id = (
                    SELECT MAX(id) FROM sprints WHERE id < :id
                )
                AND categoria = 'accion'";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $sprint_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

   
    public function marcarCumplida(int $id): bool {
        $sql = "UPDATE {$this->table} SET cumplida = 1 WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getById(int $id): ?array {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

 
    public function update(int $id, string $categoria, string $descripcion): bool {
        $sql = "UPDATE {$this->table}
                SET categoria = :categoria, descripcion = :descripcion
                WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':categoria', $categoria, PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        return $stmt->execute();
    }

    
    public function delete(int $id): bool {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>