<?php
require __DIR__ . '/../patternrouter.php';

$uri = trim($_SERVER['REQUEST_URI'], '/');
// Session start here.

$router = new PatternRouter();
$router->route($uri);
?>


