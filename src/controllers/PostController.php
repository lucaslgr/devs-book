<?php
namespace src\controllers;

use core\Controller;
use src\handlers\LoginHandler;
use src\handlers\PostHandler;

class PostController extends Controller{
    private $loggedUser;

    public function __construct(){
        //Verifica se o user está logado se não estiver leva para o login
        $this->loggedUser = LoginHandler::checkLogin();
        if ($this->loggedUser === false) {
            $this->redirect('/login');
        }
    }

    //Action que recebe a requisição de uma nova postagem
    public function new(){
        $body = filter_input(INPUT_POST,'body');

        if ($body) {
            PostHandler::addPost(
                $this->loggedUser->getId(),
                'text',
                $body
            );
        }

        $this->redirect('/');
    }
}