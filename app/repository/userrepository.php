<?php
require_once __DIR__ . '/baserepository.php';
require_once __DIR__ . '/../model/user.php';
require_once __DIR__ . '/../model/role.php';

class userrepository extends baserepository{
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