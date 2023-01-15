<?php

class switchrouter{
    public function route($url)
    {
        require("../controllers/homecontroller.php");
        require("../controllers/recipecontroller.php");
        require("../controllers/usercontroller.php");
        $homeController = new homecontroller();
        $recipeController = new recipecontroller();
        $userController = new usercontroller();

        switch($url){
            case "/home/index":
            case "/":
                $homeController->index();
                break;
            case "/home/addrecipe":
                $recipeController->addrecipe();
                break;
            case "/home/recipe":
                $recipeController->recipe();
                break;
            case "/home/manageEditors":
                $userController->manageEditors();
                break;
            case "/home/login":
                $homeController->login();
                break;
            case "/home/logout":
                $homeController->logout();
                break;
            case "/home/aboutme":
                $homeController->aboutme();
                break;
            case "/home/register":
                $homeController->register();
                break;
            default:
                echo "Error 404 Page not found";
        }
    }
}