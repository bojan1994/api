<?php

namespace Src\Config;

class Database
{
    /**
     * @var \PDO|null
     */
    private $dbConnection = null;

    /**
     * Database constructor
     */
    public function __construct()
    {
        $host = getenv('DB_HOST');
        $port = getenv('DB_PORT');
        $db   = getenv('DB_DATABASE');
        $user = getenv('DB_USERNAME');
        $pass = getenv('DB_PASSWORD');

        try {
            $this->dbConnection = new \PDO(
                "mysql:host=$host;port=$port;charset=utf8mb4;dbname=$db",
                $user,
                $pass
            );
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    /**
     * Returns connection
     *
     * @return \PDO|null
     */
    public function getConnection()
    {
        return $this->dbConnection;
    }
}