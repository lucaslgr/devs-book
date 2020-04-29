<?php
session_start();
require '../vendor/autoload.php';
require '../src/routes.php';

//Setando o timezone
date_default_timezone_set('America/Sao_Paulo');

$router->run( $router->routes );