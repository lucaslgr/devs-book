<?php
namespace src\controllers;

use \core\Controller;
use \src\handlers\UserHandler;

class LoginController extends Controller {

    public function signin(){
        $flash = '';

        //Verificando se tem alguma mensagem setada para ser mostrada
        if (!empty($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            unset($_SESSION['flash']);
        }
        $this->render('signin', [
            'flash' => $flash
        ]);
    }

    public function signinAction(){
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');

        if ($email && $password) {
            //Verificando se o login existe e se a senha bate, se sim, retorna o token do usuário
            $token = UserHandler::verifyLogin($email, $password);
            
            if ($token) { //Se o token foi retornado
                $_SESSION['token'] = $token;
                $this->redirect('/');
            } else { //Se foi retornado false
                $_SESSION['flash'] = 'E-mail e/ou senha não conferem.';
                $this->redirect('/login');
            }

        } else {
            $_SESSION['flash'] = 'Digite os campos de e-mail e/ou senha';
            $this->redirect('/login');
        }
    }

    public function signup(){
        $flash = '';

        //Verificando se tem alguma mensagem setada para ser mostrada
        if (!empty($_SESSION['flash'])) {
            $flash = $_SESSION['flash'];
            unset($_SESSION['flash']);
        }
        $this->render('signup', [
            'flash' => $flash
        ]);
    }

    public function signupAction(){
        $name = filter_input(INPUT_POST,'name');
        $email = filter_input(INPUT_POST,'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST,'password');
        $birthdate = filter_input(\INPUT_POST, 'birthdate');

        if ($name && $email && $password && $birthdate) { //Se foi tudo preenchido e validado
            //Verificando se a data de nascimento está correta 
            $birthdate = explode('/', $birthdate);
            if (count($birthdate) != 3) {
                $_SESSION['flash'] = 'Data de nascimento inválida!';
                $this->redirect('/register');
            }

            //Convertendo de padrão brasileiro para o padrão internacional do MySQL
            $birthdate = $birthdate[2].'-'.$birthdate[1].'-'.$birthdate[0];

            //Verificando se é uma data real, e não uma data futura
            if (strtotime($birthdate) === false) {
                $_SESSION['flash'] = 'Data de nascimento inválida!';
                $this->redirect('/register');
            }

            //Verificando se o email já não é cadastrado
            if(UserHandler::emailExists($email) === false){
                $token = UserHandler::addUser($name, $email, $password, $birthdate);
                $_SESSION['token'] = $token;
                $this->redirect('/');
            } else {
                $_SESSION['flash'] = 'E-mail já cadastrado!';
                $this->redirect('/register');
            }

        } else {
            $this->redirect('/register');
        }
    }

    public function logout(){
        unset($_SESSION['token']);
        $this->redirect('/login');
    }
}