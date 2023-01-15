<?php
require __DIR__ . '/../repository/reciperepository.php';

class RecipeNameService{
    public function getAllRecipeNames(string $name){
        // retrieve data
        $repository = new reciperepository();
        return $repository->getAllRecipeNames($name);
    }
}
?>