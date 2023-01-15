<?php

class user {
    public int $id;
    public string $firstName;
    public string $lastName;
    public string $username;
    public int $role;

    public function __construct(int $id,string $firstName, string $lastName, string $username, int $role = 0) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->username = $username;

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