<?php
require_once __DIR__ . '/dataBase.php';

class Sprint {
    public $id;
    public $nombre;
    public $fecha_inicio;
    public $fecha_fin;

    private PDO $conn;
    private string $table = "sprints";

    public function __construct() {
        $this->conn = Database::getInstance();
    }

    
    public function getAll(): array {
        $sql = "SELECT * FROM {$this->table} ORDER BY fecha_inicio ASC";
        $stmt = $this->conn->prepare($sql);            
        $stmt->execute();            
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(string $nombre, string $fecha_inicio, string $fecha_fin): bool {
        $sql = "INSERT INTO {$this->table} (nombre, fecha_inicio, fecha_fin)
                VALUES (:nombre, :fecha_inicio, :fecha_fin)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nombre',       $nombre,       PDO::PARAM_STR);
        $stmt->bindParam(':fecha_inicio', $fecha_inicio, PDO::PARAM_STR);
        $stmt->bindParam(':fecha_fin',    $fecha_fin,    PDO::PARAM_STR);
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

    public function delete(int $id): bool {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>