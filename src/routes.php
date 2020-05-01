<?php
use core\Router;

$router = new Router();

$router->get('/', 'HomeController@index'); //Home

$router->get('/login', 'LoginController@signin'); //Login GET
$router->post('/login', 'LoginController@signinAction'); //Faz login POST

$router->get('/register', 'LoginController@signup'); //Cadastro
$router->post('/register', 'LoginController@signupAction'); //Faz cadastro POST

$router->post('/post/new', 'PostController@new'); //Faz a postagem de um comentário

$router->get('/profile/{id}/photos', 'ProfileController@photos'); //Pagina que exibe as fotos do usuário do respectivo id passado
$router->get('/profile/{id}/friends', 'ProfileController@friends'); //Pagina de amigos do usuário do respectivo id passado
$router->get('/profile/{id}/follow', 'ProfileController@follow'); //Usuário logado segue o usuário do respectivo id
$router->get('/profile/{id}', 'ProfileController@index'); //Abre o profile de um usuário sem ser o usuário logado
$router->get('/profile', 'ProfileController@index'); //Abre o profile do usuário logado

$router->get('/friends', 'ProfileController@friends'); //Pagina de amigos do usuário do usuário logado
$router->get('/photos', 'ProfileController@photos'); //Pagina que exibe as fotos do usuário logado

$router->get('/search', 'SearchController@index'); //Faz a pesquisa do nome de um usuário do facebook

$router->get('/settings', 'ProfileController@settings'); //Pagina de configurações da conta de usuário
$router->post('/settings', 'ProfileController@settingsAction'); //Atualiza as informações do usuário

$router->get('/logout', 'LoginController@logout'); //Faz o logout do usuário


/**
 * $router->get('/search');
 * $router->get('/profile')
 * $router->get('/friends')
 * $router->get('/photos')
 * $router->get('/settings')
 * $router->get('/logout')
*/