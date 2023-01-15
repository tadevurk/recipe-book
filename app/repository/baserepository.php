<?php

class baserepository
{
    protected $connection;

    public function __construct()
    {
        $db_host = "mysql";
        $db_name = "recipe_book";
        $db_username = "root";
        $db_password = "secret123";

        try {
            $this->connection = new PDO("mysql:host=$db_host;dbname=$db_name",
                $db_username,
                $db_password);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

/*    public function __construct()
    {
        $db_host = "localhost";
        $db_name = "id20134453_recipe_book";
        $db_username = "id20134453_root";
        $db_password = "lSyaA(BWPTe9s\9%";

        try {
            $this->connection = new PDO("mysql:host=$db_host;dbname=$db_name",
                $db_username,
                $db_password);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }*/
}
