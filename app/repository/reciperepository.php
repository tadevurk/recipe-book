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

    $stmtIngredient =$this->connection->prepare("INSERT into recipe_ingredients (recipe_id, ingredients_id, quantity, unit) 
                                                VALUES (:recipe_id,:ingredients_id,:quantity,:unit)");

    foreach ($recipe->ingredients as $ingredient){
        $dataIngredient = [
            ':recipe_id' => $lastInsertedID,
            ':ingredients_id' => $this->getIngredientByName($ingredient['ingredient']),
            ':unit'=>$ingredient['unit'],
            ':quantity'=> $ingredient['quantity']
        ];
        $stmtIngredient->execute($dataIngredient);
    }
}
public function getIngredientByName($name){
    $stmt = $this->connection->prepare("SELECT id FROM ingredients WHERE name=:name");
    $data = [':name'=>"$name"];
    $stmt->execute($data);

    if($stmt->rowCount() > 0) {
        return $stmt->fetchColumn();
    }
    return null;
}

public function getAllRecipe(){
    $stmt = $this->connection->prepare("SELECT * from recipe");
    $stmt->execute();

    $stmt->setFetchMode(PDO::FETCH_CLASS,'recipe');
    $recipes = $stmt->fetchAll();
    return $recipes;
}

public function getAllRecipeIngredients($recipe_id){
    $stmt = $this->connection->prepare("SELECT I.name, R.quantity, R.unit FROM `recipe_ingredients` as R
                                                JOIN ingredients as I WHERE I.id = R.ingredients_id AND R.recipe_id=:recipe_id;");
    $data = [':recipe_id'=>$recipe_id];
    $stmt->execute($data);

    $recipe_ingredients = $stmt->fetchAll();
    return $recipe_ingredients;
}

public function getAllRecipeByName(string $name)
{
    require("../model/recipe.php");
    try {
        $stmt = $this->connection->prepare("SELECT * FROM recipe WHERE name LIKE :name LIMIT 3");

        $data = [':name'=>"%$name%"];
        $stmt->execute($data);

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'recipe');
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

public function getUniqueCuisine(){
    $stmt = $this->connection->prepare("SELECT DISTINCT cuisine FROM recipe ORDER BY cuisine");
    $stmt->execute();

    $uniqueCuisines = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $uniqueCuisines;
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
}
?>