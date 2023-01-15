<?php

class recipecontroller
{

    public function addrecipe()
    {
        require_once("../repository/reciperepository.php");
        require_once("../model/user.php");
        require_once("../model/recipe.php");

        require("../view/home/addrecipe.php");
    }
    public function recipe()
    {
        require_once("../repository/reciperepository.php");
        $recipeRepository = new reciperepository();
        $recipes =  $recipeRepository->getAllRecipe();
        require ("../view/home/recipe.php");
    }

    public function insertRecipe(recipe $recipe, int $userID){
        require_once("../repository/reciperepository.php");
        $recipeRepository = new reciperepository();
        $recipes = $recipeRepository->insertRecipe($recipe,$userID);
    }

    public function deleteRecipe(){
        if (isset($_POST["delete_recipe"])){
            require_once("../repository/reciperepository.php");
            $recipeRepository = new reciperepository();

            $recipe_id =htmlspecialchars($_POST['delete_recipe']);

            try {
                $recipeRepository->deleteRecipe($recipe_id);
                $_SESSION['message'] = "Deleted successfully";
            }catch (PDOException $e){
                echo $e->getMessage();
            }

            $recipes =  $recipeRepository->getAllRecipe();
            require ("../view/home/recipe.php");
        }
    }

    public function updateRecipe(){
        require_once("../repository/reciperepository.php");
        $recipeRepository = new reciperepository();

        if (isset($_GET['id'])){
            $recipe_id =$_GET['id'];

            try {
                $recipe = $recipeRepository->getRecipeByID($recipe_id);
                require ("../view/home/update_recipe.php");
            }catch (PDOException $e){
                echo $e->getMessage();
            }

        }
        if (isset($_POST['updateRecipeButton'])){
            $recipe = new recipe();

            $recipe->id =htmlspecialchars($_POST['recipeID']);
            $recipe->name = htmlspecialchars($_POST['recipeName']);
            $recipe->cuisine =htmlspecialchars($_POST['recipeCuisine']);
            $recipe->instructions = htmlspecialchars($_POST['recipeInstructions']);

            $recipeRepository->updateRecipe($recipe);

            $url = "recipe";
            header("Location:$url");
            exit();
        }
    }
}