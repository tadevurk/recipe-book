<?php

class recipe
{
    public int $id;
    public string $name;
    public string $instructions;
    public string $cuisine;
    public string $created_at;
    public user $user;
    public array $ingredients;
    public function __construct()
    {
        $this->ingredients = array();
    }
}