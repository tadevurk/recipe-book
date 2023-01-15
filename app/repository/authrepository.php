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
                return new user($id,$firstname,$lastname,$username,$hashed_password,$role);
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

            return new user($this->connection->lastInsertId(), $firstName,$lastName, $username, $hashed_password, 1);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getAllEditors(){
            // role 1 is the Editor
            $stmt = $this->connection->prepare("SELECT * from user WHERE role=1");
            $stmt->execute();

            // Fetch rows as associative arrays
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $users = $stmt->fetchAll();

            $editors = [];
            foreach ($users as $user) {
                // Create a new user object and pass in the necessary arguments
                $editors[] = new user(
                    $user['id'],
                    $user['firstname'],
                    $user['lastname'],
                    $user['username'],
                    $user['hashed_password'],
                    $user['role']
                );
            }
            return $editors;
        }

    public function deleteUser($id){
        $stmt = $this->connection->prepare("DELETE FROM user WHERE id = :id");
        $stmt->bindValue(':id', $id);

        $stmt->execute();
    }

    public function getUserByID($id){
        $stmt = $this->connection->prepare("SELECT * FROM user WHERE id=:id LIMIT 1");

        $stmt->bindValue(':id',$id);

        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_OBJ);

        $user = new user(
            $user->id,
            $user->firstname,
            $user->lastname,
            $user->username,
            $user->hashed_password,
            $user->role
        );

        return $user;
    }

    public function updateUser(user $user){
        $stmt = $this->connection->prepare("UPDATE user SET firstname=:firstname, lastname=:lastname, username=:username WHERE id=:user_id LIMIT 1");

        $data = [
            ':firstname' => $user->firstName,
            ':lastname'=>$user->lastName,
            ':username'=>$user->username,
            ':user_id'=>$user->id
        ];
        $stmt->execute($data);
    }
}

