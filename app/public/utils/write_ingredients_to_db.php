<?php

require_once("database_connection.php");

//Read Json File
$json = file_get_contents("dataset-recipe.json");
if ($json == null){
    throw new Exception("File not found");
}

//Decode the JSON string into a PHP array
$data = json_decode($json,true);

if ($data == null){
    throw new Exception("Dataset is empty");
}

$stmt = $connection->prepare("INSERT INTO ingredients
                            (name)
                                VALUES 
                                    (:ingredient_name)");

$stmt->bindParam(':ingredient_name',$ingredient_name);

$ingredients = [];


foreach ($data as $key => $value){
    if ($key == 500){
        break;
        echo "broke the loop";
    }
    $ingredients = array_merge($ingredients,$value['ingredients']);
}

$unique_ingredients = array_values(array_unique($ingredients));

foreach ($unique_ingredients as $element){
    $ingredient_name = $element;
    $stmt->execute();
    echo "$element is written";
}