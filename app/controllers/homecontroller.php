<?php
require __DIR__ . '/../services/ingredientservice.php';
require "recipecontroller.php";
require "usercontroller.php";
class homecontroller
{
    // Everything routes from here (recipe, user, auth controllers)
    public function index()
    {
        $this->recipe();
    }

    public function addrecipe()
    {
        $recipeController = new recipecontroller();
        $recipeController->addrecipe();
    }

    public function recipe()
    {
        $recipeController = new recipecontroller();
        $recipeController->recipe();
    }

    public function deleteRecipe(){
        $recipeController = new recipecontroller();
        $recipeController->deleteRecipe();
    }

    public function updateRecipe(){
        $recipeController = new recipecontroller();
        $recipeController->updateRecipe();
    }

    public function manageEditors(){
        $userController = new usercontroller();
        $userController->manageEditors();
    }

    public function deleteUser(){
        $userController = new usercontroller();
        $userController->deleteUser();
    }

    public function updateUser(){
        $userController = new usercontroller();
        $userController->updateUser();
    }

    public function login()
    {
        require ("../view/login/login.php");
    }

    public function register()
    {
        require("../view/admin/register.php");
    }

    public function aboutme()
    {
        require ("../view/home/aboutme.php");
    }

    public function contact()
    {
        require ("../view/home/contact.php");
    }

    public function logout()
    {
        require ("../view/login/logout.php");
    }
}



