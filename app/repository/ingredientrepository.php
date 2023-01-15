<?php
require("baserepository.php");
class ingredientrepository extends baserepository{

    public function getAllByName(string $name)
    {
        require("../model/ingredient.php");
        try {
            $stmt = $this->connection->prepare("SELECT * FROM ingredients WHERE name LIKE :name LIMIT 4");

            $data = [':name'=>"%$name%"];
            $stmt->execute($data);

            $stmt->setFetchMode(PDO::FETCH_CLASS, 'ingredient');
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    // Insert ingredient name which doesn't exist in the ingredients database
    public function post(string $name){
        require("../model/ingredient.php");

        try {

            $stmt = $this->connection->prepare("INSERT INTO ingredients
                                        (name)
                                        VALUES
                                        (:name");

            $data = [':name'=>$name];
            $stmt->execute($data);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}