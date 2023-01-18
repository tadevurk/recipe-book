<?php

class ingredient implements JsonSerializable
{
public function jsonSerialize(): mixed
{
    return get_object_vars($this);
}

    public int $id;
    public string $name;
    public int $quantity;
    public string $unit;
    public recipe $recipe;
}