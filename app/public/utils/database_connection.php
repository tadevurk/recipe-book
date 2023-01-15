<?php
session_start();

require_once("config.php");

try {
    $connection = new PDO("mysql:host=$db_host;dbname=$db_name",
        $db_username,
        $db_password);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}