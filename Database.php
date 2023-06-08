<?php

require_once "config.php";

class Database
{
    private $useername;
    private $password;
    private $host;
    private $database;

    public function __construct()
    {
        $this->useername = USERNAME;
        $this->password = PASSWORD;
        $this->host = HOST;
        $this->database = DATABASE;
    }

    public function connect()
    {
        try {
            $connString = "pgsql:host=$this->host;port=5432;dbname=$this->database";
            $conn = new PDO(
                $connString,
                $this->useername,
                $this->password
            );

            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        }
        catch (PDOException $exception)
        {
            die("Connection faqiled: ".$exception->getMessage());
        }
    }


}