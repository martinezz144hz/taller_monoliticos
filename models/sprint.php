<?php
require_once __DIR__ . '/dataBase.php';

class Sprint {
    public $id;
    public $nombre;
    public $fecha_inicio;
    public $fecha_fin;

    private PDO $conn;
    private $table = "sprints";

    public function __construct() {
        $this->conn = Database::getInstance();
    }

    public function getAll(){
        $query = "SELECT * FROM {$this->table}";
        $stmt  = $this->conn->prepare($query);            
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

} 

?>