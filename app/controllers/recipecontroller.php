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

            // New code

            // Array from the form
            $ingredientUpdateFormArray = [];

            foreach ($_POST['ingredient'] as $key=>$ingredient){
                $unit = htmlspecialchars($_POST['unit'][$key]);
                $quantity = htmlspecialchars($_POST['quantity'][$key]);
                array_push($ingredientUpdateFormArray, array('ingredient' => $ingredient, 'unit' => $unit, 'quantity' => $quantity));
            }

            // Existing recipe ingredients
            $recipe_ingredients = $this->getAllRecipeIngredients($recipe->id);

            // Loop through ingredients from form submission
            foreach ($ingredientUpdateFormArray as $ingredient) {
                // Check if ingredient already exists in recipe_ingredients table
/*                $ingredient_exists = false;
                foreach ($recipe_ingredients as $existing_ingredient) {
                    if ($ingredient['ingredient'] == $existing_ingredient['name']) {
                        // Update quantity and unit in recipe_ingredients table
                        $this->updateIngredientInRecipe($recipe->id,$existing_ingredient);
                        echo $existing_ingredient['name'];
                        echo $ingredient['ingredient'];
                        $ingredient_exists = true;
                        break;
                    }
                }
                // If ingredient doesn't exist in recipe_ingredients table, insert it
                /*if (!$ingredient_exists) {*/
                    require_once("../repository/reciperepository.php");
                    $recipeRepository = new reciperepository();
                    $ingredient_id = $recipeRepository->getIngredientByName($ingredient['ingredient']);

                    $recipeRepository->insertRecipeIngredients($recipe,$recipe->id);
                //}
            }

            // Until here..

            $url = "recipe";
            header("Location:$url");
            exit();
        }
    }

    public function updateIngredientInRecipe($recipe_id, $existing_ingredient){
        require_once("../repository/reciperepository.php");
        $recipeRepository = new reciperepository();
        $recipeRepository->updateIngredientInRecipe($recipe_id,$existing_ingredient);
    }
    public function getAllRecipeIngredients($recipe_id){
        require_once("../repository/reciperepository.php");
        $recipeRepository = new reciperepository();
        return $recipeRepository->getAllRecipeIngredients($recipe_id);
    }
}