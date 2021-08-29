<?php

namespace Src\Objects;

class Statistics
{
    /**
     * @var null
     */
    private $db = null;

    /**
     * Statistics constructor
     *
     * @param $db
     */
    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Get all statistics
     */
    public function get()
    {
        $currentMonth = date('Y-m');

        $statement = "SELECT google_analytics, positive_guys FROM statistics WHERE created_at LIKE '{$currentMonth}%';";

        try {
            $statement = $this->db->query($statement);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    /**
     * Get statistics by id
     *
     * @param $id
     */
    public function getById($id)
    {
        $currentMonth = date('Y-m');

        $statement = "SELECT google_analytics, positive_guys FROM statistics WHERE id = ? AND created_at LIKE '{$currentMonth}%';";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute([$id]);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }    
    }

    /**
     * Store new statistics
     *
     * @param array $input
     */
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

    /**
     * Update statistics
     *
     * @param $id
     * @param array $input
     */
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

    /**
     * Delete statistics by id
     *
     * @param $id
     */
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