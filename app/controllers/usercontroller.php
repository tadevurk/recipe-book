<?php

class usercontroller{
    public function manageEditors(){
        require_once("../repository/authrepository.php");
        $authRepository = new authrepository();
        $editors = $authRepository->getAllEditors();
        require("../view/admin/manage_editors.php");
    }

    public function deleteUser(){
        if (isset($_POST["delete_user"])){
            require_once("../repository/authrepository.php");
            $authRepository = new authrepository();

            $editor_id =htmlspecialchars($_POST['delete_user']);

            try {
                $authRepository->deleteUser($editor_id);
                $_SESSION['message'] = "Deleted successfully";
            }catch (PDOException $e){
                echo $e->getMessage();
            }

            $editors = $authRepository->getAllEditors();
            require("../view/admin/manage_editors.php");
        }
    }

    public function updateUser(){
        require_once("../repository/authrepository.php");
        $authRepository = new authrepository();

        if (isset($_GET['id'])){
            $user_id =$_GET['id'];

            try {
                $user = $authRepository->getUserByID($user_id);
                require ("../view/admin/update_user.php");
            }catch (PDOException $e){
                echo $e->getMessage();
            }
        }
        if (isset($_POST['updateUserButton'])){
            $user_id = htmlspecialchars($_POST['userID']);
            $user = $authRepository->getUserByID($user_id);

            $user->firstName = htmlspecialchars($_POST['firstName']);
            $user->lastName =htmlspecialchars($_POST['lastName']);
            $user->username = htmlspecialchars($_POST['username']);

            $authRepository->updateUser($user);

            $url = "manageEditors";
            header("Location:$url");
            exit();
        }
    }
}