<?php
require dirname(__DIR__, 2) . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 2));
$dotenv->load();

// connectie met de api 
$gluApiUrl = $_ENV['GLU_API_URL']; // de api bron 
$gluApikey = $_ENV['GLU_API_KEY']; // de key 

?>