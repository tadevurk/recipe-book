<?php
require_once("../repository/authrepository.php");

class authcontroller{
    public function checkLogin(string $username, string $password){
        $authrepository = new authrepository();
        return $authrepository->checkLogin($username,$password);
    }

    public function register(string $firstName, string $lastName, string $username, string $password, string $confirm_password){
        $authrepository = new authrepository();
        $authrepository->register($firstName,$lastName,$username,$password,$confirm_password);
    }
}