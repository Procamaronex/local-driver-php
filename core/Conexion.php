<?php
    class Conexion{
        private static $conexion = null;

        private function __construct(){
        }

        public static function getConexion()
        {
            $db = require_once 'config/database.php';
            try {
                if (!isset(self::$conexion)) {
                    self::$conexion = new PDO($db['driver'] . ':host=' . $db['host'] . '; dbname=' . $db['db'], $db['user'], $db['pasw']);
                    self::$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    self::$conexion->exec("SET CHARACTER SET " . $db['charset']);
                }
            } catch (Exception $e) {
                die('Error ' . $e->getMessage());
            }
            return self::$conexion;
        }
    }
?>