<?php

class user {
    public int $id;
    public string $firstName;
    public string $lastName;
    public string $username;
    public string $hashed_password;
    public int $role;

    public function __construct(int $id,string $firstName, string $lastName, string $username, string $hashed_password, int $role = 0) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->username = $username;
        $this->hashed_password = $hashed_password;

        switch ($role) {
            case 1:
                $this->role = role::Editor;
                break;
            case 2:
                $this->role = role::Admin;
                break;
            default:
                $this->role = role::Editor;
        }
    }
}
?>