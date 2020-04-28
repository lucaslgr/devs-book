<?php
namespace src\controllers;

use \core\Controller;
use \src\handlers\LoginHandler;

class HomeController extends Controller {

    //Armazena o User logado
    private $loggedUser;

    /**
     * Verifica se tem algum token na sessão, se tiver verifica de qual usuário é e pega o usuário
     * Se não redireciona para o cadastro
    */
    public function __construct(){
        $this->loggedUser = LoginHandler::checkLogin();
        
        if ( $this->loggedUser === false) {
            $this->redirect('/login');
        }
    }

    public function index() {
        $this->render('home', ['nome' => 'Lucas']);
    }

}