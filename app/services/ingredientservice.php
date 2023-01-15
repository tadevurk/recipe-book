<?php
require __DIR__ . '/../repository/ingredientrepository.php';

class IngredientService{

    public function getAllByName(string $name) {
        // retrieve data
        $repository = new ingredientrepository();
        return $repository->getAllByName($name);
    }

    public function postIngredient(string $name){
        $repository = new ingredientrepository();
        $repository->post($name);
    }
}
?>