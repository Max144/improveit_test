<?php

class MySqlDatabaseConnection
{
    private string $host;
    private string $username;
    private string $password;
    private string $database;

    public function __construct()
    {
        //get variables from env
        $this->host = 'localhost';
        $this->username = 'root';
        $this->password = 'root';
        $this->database = 'improveit';
    }

    public function connect(): ?PDO
    {
        try {
            $connection = new PDO("mysql:host=$this->host;dbname=$this->database", $this->username, $this->password);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $connection;
        } catch (PDOException $e) {
            //log error
            echo "Connection failed: " . $e->getMessage();
            return null;
        }
    }
}