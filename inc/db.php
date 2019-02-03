<?php

class db
{
    private $connection;

    public function __construct($host, $db, $username, $password, $port = 3306)
    {
        try {
            $this->connection = new PDO("mysql:host=$host;dbname=$db;port=$port", $username, $password);
        } catch (Exception $exception) {
            die('ERROR IN DB CONNECTION CHECK SETTING CONFIG');
        }
    }

    public function connection()
    {
        return $this->connection;
    }

}