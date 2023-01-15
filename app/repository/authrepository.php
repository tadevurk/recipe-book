<?php
require_once __DIR__ . '/baserepository.php';
require_once __DIR__ . '/../model/user.php';
require_once __DIR__ . '/../model/role.php';

class authrepository extends baserepository {

    public function checkLogin(string $username, string $password) {
        try {
            // retrieve the user's salt and hashed password from the database
            $stmt = $this->connection->prepare('SELECT id, firstname, lastname, hashed_password,role
                                                        FROM user WHERE username = :username');
            $data = [
                ':username' => $username
            ];
            $stmt->execute($data);

            // check if a user was found
            $count = $stmt->rowCount();
            if ($count == 0) {
                return false;
            }

            // retrieve the salt and hashed password from the result
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $id = $row['id'];
            $firstname = $row['firstname'];
            $lastname = $row['lastname'];
            $role = $row['role'];
            $hashed_password = $row['hashed_password'];

            // compare the hashed password from the database to the hashed input
            if (password_verify($password,$hashed_password)){
                return new user($id,$firstname,$lastname,$username,$role);
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }



    public function register(string $firstName, string $lastName, string $username, string $password, string $confirm_password)
    {
        try {
            // check if the passwords match
            if ($password !== $confirm_password) {
                throw new Exception("The passwords do not match.");
            }

            //use password_hash to hash the password
            $hashed_password = password_hash($password,PASSWORD_DEFAULT);


            //insert the new user into the database
            $stmt = $this->connection->prepare('INSERT INTO user (firstname, lastname, hashed_password, role, username)
                                                        VALUES (:firstname, :lastname, :hashed_password,:role, :username)');

            $data = [
                ':firstname' =>$firstName,
                ':lastname' =>$lastName,
                ':hashed_password'=>$hashed_password,
                ':role'=>1,
                ':username'=>$username
            ];

            $stmt->execute($data);

            return new user($this->connection->lastInsertId(), $firstName,$lastName, $username, 1);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}

