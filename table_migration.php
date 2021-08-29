<?php

require 'bootstrap.php';

$statement = <<<EOS
    CREATE TABLE IF NOT EXISTS statistics (
        id INT NOT NULL AUTO_INCREMENT,
        google_analytics INT NOT NULL,
        positive_guys INT NOT NULL,
        created_at DATE NOT NULL,
        PRIMARY KEY (id)
    ) ENGINE=INNODB;
EOS;

try {
    $createTable = $dbConnection->exec($statement);
    echo "Success!\n";
} catch (\PDOException $e) {
    exit($e->getMessage());
}