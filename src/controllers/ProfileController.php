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

        //Se o usuário do respectivo id não existir ele é redirecionado
        if (!$user) {
            $this->redirect('/');
        }

        //Calculando a idade do user
        $dateFrom = new DateTime($user->getBirthDate());
        $dateNow = new DateTime(); //Pega a data de hoje
        $user->agrYears = $dateNow->diff($dateFrom)->y;

        //Pegando o feed do usuário
        $feed = PostHandler::getUserFeed(
            $id,
            $page,
            $this->loggedUser->getId()
        );

        $isFollowing = false;
        //Verificando se o usuário logado segue o usuário do perfil aberto
        if ($user->getId() != $this->loggedUser->getId()) {
            $isFollowing = UserHandler::isFollowing($this->loggedUser->getId(), $user->getId());
        }

        //Pegando as informações do usuário do respectivo id
        $this->render('profile', [
            'loggedUser' => $this->loggedUser,
            'user' => $user,
            'feed' => $feed,
            'isFollowing'=>  $isFollowing 
        ]);
    }

    public function follow($atts){
        $to = intval($atts['id']);
        
        if (UserHandler::idExists($to)) {
            if (UserHandler::isFollowing($this->loggedUser->getId(), $to)) {
                //Deixar de seguir
                UserHandler::unfollow($this->loggedUser->getId(), $to);
            } else{
                //Seguir
                UserHandler::follow($this->loggedUser->getId(), $to);
            }
        }

        $this->redirect('/profile/'.$to);
    }

    public function friends($atts = []){
        //Por padrão se não for enviado um id de usuário abre o profile do usuário logado
        $id = $this->loggedUser->getId();

        //Se foi enviado id de outro usuário, abre o profile dele
        if (!empty($atts['id'])) {
            $id = $atts['id'];
        }

        //Verifica se o $id selecionado para abrir o profile é um $id que existe e pega o usuario
        $user = UserHandler::getUser($id, true);

        //Se o usuário do respectivo id não existir ele é redirecionado
        if (!$user) {
            $this->redirect('/');
        }

        $isFollowing = false;
        //Verificando se o usuário logado segue o usuário do perfil aberto
        if ($user->getId() != $this->loggedUser->getId()) {
            $isFollowing = UserHandler::isFollowing($this->loggedUser->getId(), $user->getId());
        }

        //Calculando a idade do user
        $dateFrom = new DateTime($user->getBirthDate());
        $dateNow = new DateTime(); //Pega a data de hoje
        $user->agrYears = $dateNow->diff($dateFrom)->y;



        //Pegando as informações do usuário do respectivo id
        $this->render('profile_friends', [
            'loggedUser' => $this->loggedUser,
            'user' => $user,
            'isFollowing'=>  $isFollowing 
        ]);
    }

    public function photos($atts = []){
        //Por padrão se não for enviado um id de usuário abre o profile do usuário logado
        $id = $this->loggedUser->getId();

        //Se foi enviado id de outro usuário, abre o profile dele
        if (!empty($atts['id'])) {
            $id = $atts['id'];
        }

        //Verifica se o $id selecionado para abrir o profile é um $id que existe e pega o usuario
        $user = UserHandler::getUser($id, true);

        //Se o usuário do respectivo id não existir ele é redirecionado
        if (!$user) {
            $this->redirect('/');
        }

        $isFollowing = false;
        //Verificando se o usuário logado segue o usuário do perfil aberto
        if ($user->getId() != $this->loggedUser->getId()) {
            $isFollowing = UserHandler::isFollowing($this->loggedUser->getId(), $user->getId());
        }

        //Calculando a idade do user
        $dateFrom = new DateTime($user->getBirthDate());
        $dateNow = new DateTime(); //Pega a data de hoje
        $user->agrYears = $dateNow->diff($dateFrom)->y;

        //Pegando as informações do usuário do respectivo id
        $this->render('profile_photos', [
            'loggedUser' => $this->loggedUser,
            'user' => $user,
            'isFollowing'=>  $isFollowing 
        ]);
    }

    public function settings(){
        $flash = '';

        //Verificando se tem alguma mensagem setada para ser mostrada
        if (!empty($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            unset($_SESSION['flash']);
        }

        $this->render('settings',[
            'loggedUser' => $this->loggedUser,
            'flash' => $flash
        ]);
    }

    public function settingsAction(){
        //1. Pegando as informações e validando
        $name = filter_input(INPUT_POST, 'name');
        $birthDate = filter_input(INPUT_POST, 'birthdate');
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $city = filter_input(INPUT_POST, 'city');
        $work = filter_input(INPUT_POST, 'work');
        $newPass = filter_input(INPUT_POST, 'new-password');
        $confirmPass = filter_input(INPUT_POST, 'confirm-password');

        //1.1 Verificando se os dados obrigatórios foram enviados
        if ($name && $birthDate && $email) {
            //1.2 Validando a data de nascimento
            $birthDate = trim($birthDate);
            $birthDate = explode('/',$birthDate);
            if(empty($birthDate[2]) || empty($birthDate[1]) || empty($birthDate[0])) {
                $_SESSION['flash'] = 'Data de nascimento inválida!';
                $this->redirect('/settings');
            }

            $birthDate = $birthDate[2].'-'.$birthDate[1].'-'.$birthDate[0];

            if(strtotime($birthDate) === false){
                $_SESSION['flash'] = 'Data de nascimento inválida!';
                $this->redirect('/settings');
            }

            //1.3 Validando o email, se já não é existente
            if(UserHandler::emailExists($email, $this->loggedUser->getId())){
                $_SESSION['flash'] = 'E-mail já cadastrado!';
                $this->redirect('/settings');
            }

            //1.4 Verificando se as senhas foram enviadas, e se foram, validando se as elas batem
            if($newPass && $confirmPass){
                //1.4.1 Verificando se elas batem
                if ($newPass != $confirmPass) {
                    $_SESSION['flash'] = 'As senhas não conferem!';
                    $this->redirect('/settings');
                } else {
                    UserHandler::editUser($this->loggedUser->getId(), $name, $email, $birthDate, $city, $work, $newPass);
                }
            } else {
                UserHandler::editUser($this->loggedUser->getId(), $name, $email, $birthDate, $city, $work);
            }

        } else{
            $_SESSION['flash'] = 'Os dados obrigatórios não foram preenchidos!';
            $this->redirect('/settings');
        }

        $this->redirect('/settings');
    }
}