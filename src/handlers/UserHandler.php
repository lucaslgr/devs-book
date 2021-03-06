<?php
namespace src\handlers;

use \src\models\User;
use src\models\UserRelation;

class UserHandler {

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
                $loggedUser->setCity($data['city']);
                $loggedUser->setWork($data['work']);
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
    public static function emailExists($email, $idOwner = ''){
        if(empty($idOwner))
            return User::select()
                ->where('email', $email)
            ->one() ? true: false;
        else
            return User::select()
                ->where('email', $email)
                ->where('id', '!=', $idOwner)
            ->one() ? true: false;
    }

    /**
     * Verifica se já tem um usuário cadastrado com esse id
    */
    public static function idExists($id){
        return User::select()->where('id', $id)->one() ? true: false;
    }

    /**
     * Pega as informações do usuário do respectivo id
    */
    public static function getUser($id, $full = false){
        $data = User::select()->where('id', $id)->one();

        if ($data) {
            $user = new User();
            $user->setId($data['id']);
            $user->setName($data['name']);
            $user->setBirthDate($data['birthdate']);
            $user->setCity($data['city']);
            $user->setWork($data['work']);
            $user->setAvatar($data['avatar']);
            $user->setCover($data['cover']);

            

            if ($full) {
                $user->followers = [];
                $user->followings = [];
                $user->photos = [];

                //followers
                $followers = UserRelation::select()->where('user_to', $id)->get();
                foreach ($followers as $follower) {
                    //Pegando as informações do usuário
                    $userData = User::select()->where('id', $follower['user_from'])->one();

                    $newUser = new User();
                    $newUser->setId($userData['id']);
                    $newUser->setName($userData['name']);
                    $newUser->setAvatar($userData['avatar']);

                    $user->followers[] = $newUser;
                }

                //following
                $followings = UserRelation::select()->where('user_from', $id)->get();
                foreach ($followings as $following) {
                    //Pegando as informações do usuário
                    $userData = User::select()->where('id', $following['user_to'])->one();

                    $newUser = new User();
                    $newUser->setId($userData['id']);
                    $newUser->setName($userData['name']);
                    $newUser->setAvatar($userData['avatar']);

                    $user->followings[] = $newUser;
                }

                //photos
                $user->photos = PostHandler::getPhotosFrom($id);
            }

            return $user;
        }
        return false;
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

    /**
     * Altera os dados do usuário
    */
    public static function editUser($id, $name, $email, $birthdate, $city, $work, $password = ''){
        //Criptografando a senha
        if(!empty($password)){
            $hash = password_hash($password, PASSWORD_BCRYPT);

            User::update()
                ->set([
                    'email' => $email,
                    'name' => $name,
                    'password' => $hash,
                    'birthdate' => $birthdate,
                    'city' => $city,
                    'work' => $work
                ])
                ->where('id', $id)
            ->execute();
        } else {
            User::update()
                ->set([
                    'email' => $email,
                    'name' => $name,
                    'birthdate' => $birthdate,
                    'city' => $city,
                    'work' => $work
                ])
                ->where('id', $id)
            ->execute();
        }
    }

    /**
     * Verifica se o usuári do respectivo id passado no primeiro parâmetro segue o respectivo usuário do id passado no ssegundo parametro
    */
    public static function isFollowing($from, $to){
        $data = UserRelation::select()
            ->where('user_from', $from)
            ->where('user_to', $to)
        ->one();

        return ($data)?true:false;
    }

    public static function unfollow($from, $to){
        UserRelation::delete()
            ->where('user_from', $from)
            ->where('user_to', $to)
        ->execute();
    }

    public static function follow($from, $to){
        UserRelation::insert([
            'user_from' => $from,
            'user_to' => $to
        ])->execute();
    }

    /**
     * Faz a busca de usuários por um termo digitado e passado no parâmetro
    */
    public static function searchUser($searchTerm){
        $data = User::select()->where('name', 'like', '%'.$searchTerm.'%')->get();

        $users = [];
        if ($data) {
            foreach($data as $user){
                $newUser = new User();
                $newUser->setId($user['id']);
                $newUser->setName($user['name']);
                $newUser->setAvatar($user['avatar']);
    
                $users[] = $newUser;
            }
        }
        return $users;
    }
}