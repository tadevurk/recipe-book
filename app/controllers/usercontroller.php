<?php

class usercontroller{

    public function getAllEditors(){
        require_once("../repository/userrepository.php");;
        $userrepository = new userrepository();
        $editors[] = $userrepository->getAllEditors();
        return $editors;
    }

    public function deleteUser(){
        if (isset($_POST["delete_user"])){
            require_once("../repository/userrepository.php");
            $userrepository = new userrepository();

            $editor_id =htmlspecialchars($_POST['delete_user']);

            try {
                $userrepository->deleteUser($editor_id);
                $_SESSION['message'] = "Deleted successfully";
            }catch (PDOException $e){
                echo $e->getMessage();
            }

            $editors = $userrepository->getAllEditors();
            header("Location: /home/manageeditors");
        }
    }

    public function updateUser(){
        require_once("../repository/userrepository.php");;
        $userrepository = new userrepository();

        if (isset($_GET['id'])){
            $user_id =$_GET['id'];

            try {
                $user = $userrepository->getUserByID($user_id);
                require ("../view/admin/update_user.php");
            }catch (PDOException $e){
                echo $e->getMessage();
            }
        }
        if (isset($_POST['updateUserButton'])){
            $user_id = htmlspecialchars($_POST['userID']);
            $user = $userrepository->getUserByID($user_id);

            $user->firstName = htmlspecialchars($_POST['firstName']);
            $user->lastName =htmlspecialchars($_POST['lastName']);
            $user->username = htmlspecialchars($_POST['username']);

            $userrepository->updateUser($user);

            $url = "manageEditors";
            header("Location:$url");
            exit();
        }
    }

    public function manageEditors(){
        require_once("../repository/userrepository.php");
        $userrepository = new userrepository();
        $editors = $userrepository->getAllEditors();
        require("../view/admin/manage_editors.php");
    }
}