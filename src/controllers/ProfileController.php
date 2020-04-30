<?php
    namespace src\controllers;

use DateTime;
use core\Controller;
use src\handlers\UserHandler;
use src\handlers\PostHandler;

class ProfileController extends Controller{
    private $loggedUser;

    public function __construct(){
        $this->loggedUser= UserHandler::checkLogin();
        if ($this->loggedUser===false) {
            $this->redirect('/login');
        }
    }

    public function index($atts = []){
        $page = filter_input(INPUT_GET, 'p');

        //Por padrão se não for enviado um id de usuário abre o profile do usuário logado
        $id = $this->loggedUser->getId();

        //Se foi enviado id de outro usuário, abre o profile dele
        if (!empty($atts['id'])) {
            $id = $atts['id'];
        }

        //Verifica se o $id selecionado para abrir o profile é um $id que existe e pega o usuario
        $user = UserHandler::getUser($id, true);

        if (!$user) {
            $this->redirect('/');
        }

        //Calculando a idade do user
        $dateFrom = new DateTime($user->getBirthDate());
        $dateNow = new DateTime(); //Pega a data de hoje
        $user->agrYears = $dateNow->diff($dateFrom)->y;

        $feed = PostHandler::getUserFeed(
            $id,
            $page,
            $this->loggedUser->getId()
        );

        //Pegando as informações do usuário do respectivo id
        $this->render('profile', [
            'loggedUser' => $this->loggedUser,
            'user' => $user,
            'feed' => $feed
        ]);
    }
}