<?php
/*$url = $_SERVER["REQUEST_URI"];

require("../router/switchrouter.php");
$router = new switchrouter();
$router->route($url);
*/


require __DIR__ . '/../patternrouter.php';

$uri = trim($_SERVER['REQUEST_URI'], '/');

$router = new PatternRouter();
$router->route($uri);
?>


