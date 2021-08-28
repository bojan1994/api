<?php

namespace Src\Objects;

class Statistics {

    private $db = null;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function get()
    {
        $statement = "SELECT * FROM statistics;";

        try {
            $statement = $this->db->query($statement);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function getById($id)
    {
        $statement = "SELECT * FROM statistics WHERE id = ?;";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array($id));
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }

    public function store(Array $input)
    {
        $statement = "INSERT INTO statistics (google_analytics, positive_guys, created_at) VALUES (:google_analytics, :positive_guys, :created_at);";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute([
                'google_analytics' => $input['google_analytics'],
                'positive_guys'  => $input['positive_guys'],
                'created_at' => date("Y-m-d"),
            ]);
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }

    public function update($id, Array $input)
    {
        $statement = "UPDATE statistics SET google_analytics = :google_analytics, positive_guys = :positive_guys WHERE id = :id;";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute([
                'id' => (int) $id,
                'google_analytics' => $input['google_analytics'],
                'positive_guys'  => $input['positive_guys'],
            ]);
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }

    public function delete($id)
    {
        $statement = "DELETE FROM statistics WHERE id = :id;";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(['id' => $id]);
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }
}