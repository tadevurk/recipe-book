<?php
require_once("../repository/authrepository.php");

class authcontroller
{
    public function checkLogin(){
        session_start();
        $authrepository = new authrepository();

        try {
            if (isset($_SESSION['admin'])) {
                header("Location: /home/manageeditors");
                exit();
            }
        
            if (isset($_SESSION['user'])) {
                header("Location: /home/recipe");
                exit();
            }
        
            if (isset($_POST["registerNewUser"])){
                header("location:register");
            }

        if (isset($_POST["login"])){
            $username = htmlspecialchars(trim($_POST['username']));
            $password = htmlspecialchars(trim($_POST['password']));
    
            // check the login
            $loggedInUser = $authrepository->checkLogin($username,$password);
            if ($loggedInUser) {
                if ($loggedInUser->role === role::Admin){
                    $_SESSION['admin'] =  $loggedInUser;
                    $_SESSION['adminID'] = $loggedInUser->id;
                    $_SESSION['role'] = $loggedInUser->role;
                    $_SESSION['lastname'] = $loggedInUser->lastName;
                    header("location:manageEditors");
                }
                if ($loggedInUser->role === role::Editor){
                    $_SESSION['user'] =  $loggedInUser;
                    $_SESSION['userID'] = $loggedInUser->id;
                    $_SESSION['lastname'] = $loggedInUser->lastName;
                    header("location:recipe");
                }
                return $loggedInUser;
            } else {
                // login failed
                $_SESSION['message'] = "Invalid username or password";
                header("location:login");
                exit();
            }
        }            
    }
        catch (PDOException $error){
            $message =$error->getMessage();
        }
    }
    
    public function registerUser(){   
        session_start();     
        if (isset($_POST["register"])) {
            // retrieve the form data , remove the whitespace with trim
            $firstName = htmlspecialchars(trim($_POST['firstName']));
            $lastName = htmlspecialchars(trim($_POST['lastName']));
            $username = htmlspecialchars(trim($_POST['username']));
            $password = htmlspecialchars(trim($_POST['password']));
            $confirm_password = htmlspecialchars(trim($_POST['confirm_password']));
    
            // basic form validation
            if (empty($firstName) || empty($lastName) || empty($username)) {
                $_SESSION['register_error'] = 'Please fill out all required fields.';
                header("Location: register");
            } elseif ($password !== $confirm_password) {
                $_SESSION['register_error'] = 'Passwords do not match.';
                header("Location: register");
            } else {
                try {
                    $authrepository = new authrepository();
                    $newEditor = $authrepository->register($firstName,$lastName,$username,$password,$confirm_password);
                    header("Location: manageeditors");
                    exit;
                } catch (Exception $e) {
                    // there was an error during registration, store it in the session and display it
                    $_SESSION['register_error'] = $e->getMessage();
                }
            }
        }
    }
}