<?php

namespace App\Core\SQL;

use PDO;
use PDOException;

class SqlConnector
{
    private ?object $pdo = null;

    private string $dbName;

    public function __construct()
    {
    }

    public function connect(): void
    {
        if ($this->pdo === null) {

            $this->dbName = $_ENV['DATABASE'] ?? 'users';

            $dbHost = "localhost:3337";
            $dbUser = "root";
            $dbPass = "nexus123";

            $this->pdo = new PDO("mysql:host=$dbHost;dbname=$this->dbName", $dbUser, $dbPass);
        }
    }

    public function getDatabaseName(): string
    {
        return $this->dbName;
    }

    public function executeSelectQuery(string $query, array $params): array
    {
        $this->connect();
        $stmt = $this->pdo->prepare($query);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value, PDO::PARAM_STR);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function executeInsertQuery(string $query, array $params): string
    {
        $this->connect();
        $stmt = $this->pdo->prepare($query);

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value, PDO::PARAM_STR);
        }

        $stmt->execute();

        return $this->pdo->lastInsertId();
    }

    public function executeDeleteQuery(string $query, array $params): string
    {
        $this->connect();
        $stmt = $this->pdo->prepare($query);

        // Bind parameters manually
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value, PDO::PARAM_STR);
        }

        // Execute the query
        $stmt->execute();

        // Return the last inserted ID
        return $this->pdo->lastInsertId();
    }

    public function closeConnection(): void
    {
        $this->pdo = null;
    }
}