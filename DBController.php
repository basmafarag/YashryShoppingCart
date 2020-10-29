<?php
class DBController {

    private $db = null;

    public function __construct()
    {
        $host = "127.0.0.1";
        // $port = "8889";
        $db   = "yashry";
        $user = "root";
        $pass = "";

        try {
            $this->db = new \PDO(
                "mysql:host=$host;charset=utf8mb4;dbname=$db",
                $user,
                $pass
            );
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->db;
    }
}