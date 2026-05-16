<?php

class Database {
    private static string $host   = "localhost";
    private static string $dbname = "registro_retro_db";
    private static string $user   = "root";
    private static string $pass   = "";
    private static string $charset = "utf8mb4";

    private static ?PDO $instance = null;

    private function __construct() {}


    public static function getInstance(): PDO {
        if (self::$instance === null) {
            $dsn = "mysql:host=" . self::$host
                 . ";dbname=" . self::$dbname
                 . ";charset=" . self::$charset;

            $opciones = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,          
            ];

            try {
                self::$instance = new PDO($dsn, self::$user, self::$pass, $opciones);
            } catch (PDOException $e) {
                throw new RuntimeException("Error de conexión a la base de datos: " . $e->getMessage());
            }
        }

        return self::$instance;
    }

    /**
     * Ejecuta una consulta SELECT y devuelve los resultados.
     
     * @param string $sql
     * @param array $params
     * @return array
     */
    public static function query(string $sql, array $params = []): array {
        $stmt = self::getInstance()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Ejecuta una sentencia INSERT, UPDATE o DELETE.
     
     * @param string $sql
     * @param array $params
     * @return bool
     */
    public static function execute(string $sql, array $params = []): bool {
        $stmt = self::getInstance()->prepare($sql);
        return $stmt->execute($params);
    }
}