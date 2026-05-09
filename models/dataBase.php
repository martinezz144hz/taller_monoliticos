<?php

class Database {
    private static string $host   = "localhost";
    private static string $dbname = "registro_retro_db";
    private static string $user   = "root";
    private static string $pass   = "";
    private static string $charset = "utf8mb4";

    private static ?PDO $instance = null;

    private function __construct() {}

    /**
     * Devuelve la única instancia PDO de la aplicación.
     * Si no existe, la crea con las opciones recomendadas.
     *
     * @return PDO
     * @throws RuntimeException si la conexión falla
     */
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
}