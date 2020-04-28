<?php
use core\Router;

$router = new Router();

$router->get('/', 'HomeController@index'); //Home

$router->get('/login', 'LoginController@signin'); //Login GET
$router->post('/login', 'LoginController@signinAction'); //Faz login POST

$router->get('/register', 'LoginController@signup'); //Cadastro
$router->post('/register', 'LoginController@signupAction'); //Faz cadastro POST
