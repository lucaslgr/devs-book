<?php
namespace src\handlers;

use \src\models\User;

class LoginHandler {

    /**
     * Verifica se existe algum usuáro logado com um token armazenado na sessão
    */
    public static function checkLogin(){
        if (!empty($_SESSION['token'])) {

            $user = new User();

            //Pegando o respectivo usuário no banco
            $data = $user::select()->where('token',$_SESSION['token'])->one();
            if (count($data)>0) {
                //Setando o usuário logado e retornando
                $loggedUser = new User();
                $loggedUser->setId($data['id']);
                $loggedUser->setEmail($data['email']);
                $loggedUser->setName($data['name']);
                $loggedUser->setAvatar($data['avatar']);
                $loggedUser->setBirthDate($data['birthdate']);

                return $loggedUser;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Verifica se o email e senha batem e retorna o token do usuário ou retorna false caso contrário
    */
    public static function verifyLogin($email, $password){

        //Pegando o usuário do respectivo email
        $user = User::select()->where('email', $email)->one();

        //Verificando se a senha confere
        if ($user && password_verify($password, $user['password'])) {
            //Gerando um token aleatório
            $token = md5(time().rand(0, 99999).time()); 

            //Salvando o token no usuário no banco
            User::update()
                ->set('token', $token)
                ->where('id', $user['id'])
            ->execute();

            return $token;
        } else {
            return false;
        }
    }

    /**
     * Verifica se já tem um usuário cadastrado com esse email
    */
    public static function emailExists($email){
        return User::select()->where('email', $email)->one() ? true: false;
    }

    /**
     * Adiciona o usuário
    */
    public static function addUser($name, $email, $password, $birthdate){
        //Criptografando a senha
        $hash = password_hash($password, PASSWORD_BCRYPT);

        //Gerando um token para o usuário já logar
        $token = md5(time().rand(0, 99999).time()); 

        User::insert([
            'name' => $name,
            'email' => $email,
            'password'=> $hash,
            'birthdate' => $birthdate,
            'token' => $token
        ])->execute();

        return $token;
    }
}