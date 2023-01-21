<?php
require_once("baserepository.php");
require_once __DIR__ . "/../model/recipe.php";
require_once __DIR__ . "/../model/user.php";

class reciperepository extends baserepository{

public function insertRecipe(recipe $recipe, int $userID){
    $stmt =$this->connection->prepare("INSERT into recipe (name, cuisine, instructions, created_at, user_id) 
                                                VALUES (:name,:cuisine,:instructions, now(), :user_id)");

    $data = [
        ':name' => $recipe->name,
        ':cuisine' =>$recipe->cuisine,
        ':instructions'=>$recipe->instructions,
        ':user_id'=> $userID
    ];

    $stmt->execute($data);
    $lastInsertedID = $this->connection->lastInsertId();
    $this->insertRecipeIngredients($recipe,$lastInsertedID);
}

public function insertRecipeIngredients(recipe $recipe, $lastInsertedID ){
    $stmtIngredient =$this->connection->prepare("INSERT into recipe_ingredients (recipe_id, ingredients_id, quantity, unit) 
                                                VALUES (:recipe_id,:ingredients_id,:quantity,:unit)");

    foreach ($recipe->ingredients as $ingredient){

        $dataIngredient = [
            ':recipe_id' => $lastInsertedID,
            ':ingredients_id' => $this->getIngredientIdByName($ingredient['ingredient']),
            ':unit'=>$ingredient['unit'],
            ':quantity'=> $ingredient['quantity']
        ];
        $stmtIngredient->execute($dataIngredient);
    }
}

//While updating the ingredients, if there are new ingredients.
public function addRecipeIngredients($recipeID,$ingredient_id,$unit, $quantity){
    $stmtIngredient =$this->connection->prepare("INSERT into recipe_ingredients (recipe_id, ingredients_id, quantity, unit) 
                                            VALUES (:recipe_id,:ingredients_id,:quantity,:unit)");

        $dataIngredient = [
            ':recipe_id' => $recipeID,
            ':ingredients_id' => $ingredient_id,
            ':unit'=>$unit,
            ':quantity'=> $quantity
        ];
        $stmtIngredient->execute($dataIngredient);
}

// Updating the recipe ingredients
public function updateRecipeIngredient($recipeID, $ingredient_id, $unit, $quantity) {
    $query = "UPDATE recipe_ingredients SET quantity = :quantity, unit = :unit WHERE ingredients_id = :ingredients_id AND recipe_id = :recipe_id";
    $stmt = $this->connection->prepare($query);
    $dataIngredient = [
        ':recipe_id' => $recipeID,
        ':ingredients_id' => $ingredient_id,
        ':unit'=>$unit,
        ':quantity'=> $quantity
    ];
    $stmt->execute($dataIngredient);
}


// if the old ones removed
public function deleteRecipeIngredient($recipeID, $ingredient_id) {
    $query = "DELETE FROM recipe_ingredients WHERE recipe_id = :recipe_id AND ingredients_id = :ingredients_id";
    $stmt = $this->connection->prepare($query);
    $stmt->bindValue(':recipe_id', $recipeID);
    $stmt->bindValue(':ingredients_id', $ingredient_id);
    $stmt->execute();
}


public function getIngredientIdByName($name){
    require_once ("ingredientrepository.php");
    $stmt = $this->connection->prepare("SELECT id FROM ingredients WHERE name=:name");
    $data = [':name'=>"$name"];
    $stmt->execute($data);

    if($stmt->rowCount() > 0) {
        return $stmt->fetchColumn();
    }
    else {
        // ingredient is not in the ingredients database, insert it
        $stmt = $this->connection->prepare("INSERT INTO ingredients (name) VALUES (:name)");
        $stmt->execute([':name' => $name]);
        return $this->connection->lastInsertId();
    }
}


public function getAllRecipe(){
    $stmt = $this->connection->prepare("SELECT * from recipe");
    $stmt->execute();

    $stmt->setFetchMode(PDO::FETCH_CLASS,'recipe');
    $recipes = $stmt->fetchAll();
    return $recipes;
}

public function getAllRecipeIngredients($recipe_id){
    $stmt = $this->connection->prepare("SELECT I.id, I.name, R.quantity, R.unit FROM `recipe_ingredients` as R
                                                JOIN ingredients as I WHERE I.id = R.ingredients_id AND R.recipe_id=:recipe_id;");
    $data = [':recipe_id'=>$recipe_id];
    $stmt->execute($data);

    $recipe_ingredients = $stmt->fetchAll();
    return $recipe_ingredients;
}

public function getAllRecipeNames(string $name)
{
    require_once("../model/recipe.php");
    try {
        $stmt = $this->connection->prepare("SELECT id, name FROM recipe WHERE name LIKE :name LIMIT 4");

        $data = [':name'=>"%$name%"];
        $stmt->execute($data);

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'recipe');
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

public function deleteRecipe($id){
    $stmt = $this->connection->prepare("DELETE FROM recipe WHERE id = :id");
    $stmt->bindValue(':id', $id);

    $stmt->execute();
}

public function getRecipeByID($id){
    $stmt = $this->connection->prepare("SELECT * FROM recipe WHERE id=:id LIMIT 1");

    $stmt->bindValue(':id',$id);

    $stmt->execute();

    $recipe = $stmt->fetch(PDO::FETCH_OBJ);
    return $recipe;
}

public function updateRecipe(recipe $recipe){
    $stmt = $this->connection->prepare("UPDATE recipe SET name=:name, cuisine=:cuisine, instructions=:instructions WHERE id=:recipe_id LIMIT 1");

    $data = [
        ':name' => $recipe->name,
        ':cuisine'=>$recipe->cuisine,
        ':instructions'=>$recipe->instructions,
        ':recipe_id'=>$recipe->id
    ];
    $stmt->execute($data);
}

public function updateIngredientInRecipe($recipe_id, $existing_ingredient){
    $stmt = $this->connection->prepare("UPDATE recipe_ingredients SET quantity=:quantity, unit=:unit WHERE recipe_id=:recipe_id LIMIT 1");

    $data = [
        ':quantity' => $existing_ingredient['quantity'],
        ':unit'=>$existing_ingredient['unit'],
        ':recipe_id'=>$recipe_id
    ];
    $stmt->execute($data);
}
}
?>