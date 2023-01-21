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
                header("Location: /home/recipe");
            }catch (PDOException $e){
                echo $e->getMessage();
            }
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
            $recipe->ingredients = $ingredientUpdateFormArray;
            $updated_recipe_ingredients = array();

            foreach ($ingredientUpdateFormArray as $form_ingredient) {
                $found = false;
                // Check if the ingredient already exists in existing recipe ingredients
                foreach ($recipe_ingredients as $existing_ingredient) {
                    if ($form_ingredient['ingredient'] == $existing_ingredient['name']) {
                        $recipeRepository->updateRecipeIngredient($recipe->id,$existing_ingredient['id'], $form_ingredient['unit'], $form_ingredient['quantity']);
                        $found = true;
                    }
                }
                if (!$found) {
                    // Ingredient does not exist, add new ingredient
                    $updated_recipe_ingredients[] = array(
                        'name' => $form_ingredient['ingredient'],
                        'unit' => $form_ingredient['unit'],
                        'quantity' => $form_ingredient['quantity']
                    );
                }
            }

            foreach ($recipe_ingredients as $existing_ingredient) {
                $found = false;
                foreach ($ingredientUpdateFormArray as $form_ingredient) {
                    if ($form_ingredient['ingredient'] == $existing_ingredient['name']) {
                        $found = true;
                        break;
                    }
                }
                if (!$found) {
                    $recipeRepository->deleteRecipeIngredient($recipe->id, $existing_ingredient['id']);
                }
            }

            foreach ($updated_recipe_ingredients as $ingredient) {
                //echo "Ingredient Name: ".$ingredient['name']." Unit: ".$ingredient['unit']." Quantity: ".$ingredient['quantity']."\n";
                require_once("../repository/reciperepository.php");
                $recipeRepository = new reciperepository();
                $ingredient_id = $recipeRepository->getIngredientIdByName($ingredient['name']);
                $recipeRepository->addRecipeIngredients($recipe->id,$ingredient_id,$ingredient['unit'],$ingredient['quantity']);
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