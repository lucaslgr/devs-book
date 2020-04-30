<?php
namespace src\controllers;

use core\Controller;
use src\handlers\UserHandler;
use src\handlers\PostHandler;

class HomeController extends Controller {

    //Armazena o User logado
    private $loggedUser;

    /**
     * Verifica se tem algum token na sessão, se tiver verifica de qual usuário é e pega o usuário
     * Se não redireciona para o cadastro
    */
    public function __construct(){
        $this->loggedUser = UserHandler::checkLogin();
        
        if ( $this->loggedUser === false) {
            $this->redirect('/login');
        }
    }

    public function index() {
        $page = filter_input(INPUT_GET, 'p');

        $feed = '';
        $feed = PostHandler::getHomeFeed($this->loggedUser->getId(), $page);

        $this->render('home', [
            'loggedUser' => $this->loggedUser,
            'feed' => $feed
        ]);
    }

}