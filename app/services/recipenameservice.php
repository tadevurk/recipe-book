<?php
require __DIR__ . '/../repository/reciperepository.php';

class RecipeNameService{

    public function getAllRecipeByName(string $name) {
        // retrieve data
        $repository = new reciperepository();
        return $repository->getAllRecipeByName($name);
    }

}
?>