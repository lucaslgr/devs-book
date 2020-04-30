<?php

namespace src\handlers;

use src\models\Post;
use src\models\UserRelation;
use src\models\User;

class PostHandler{
    private const POST_PER_PAGE = 2;

    public static function addPost($idUser, $type, $body){
        $body = trim($body);
        if (!empty($idUser) && !empty($body)) {
            Post::insert([
                'id_user' => $idUser,
                'type' => $type,
                'body' => $body,
                'created_at' => date('Y-m-d H:i:s')
            ])->execute();
        }
    }

    //Feed da time lime
    public static function getHomeFeed($idUser, $page){
        
        //1. Pegar a lista de usuários que EU sigo.
        $usersList = UserRelation::select()->where('user_from',$idUser)->get();

        $users = [];
        foreach($usersList as $user){
            $users[] = $user['user_to'];
        }
        //Adicionando o id do user logado também
        $users[] = $idUser;

        //2. Pegar os posts dessa galera ordenado pela data.
        $page = intval($page);


        $postsList = $postsList = Post::select()
            ->where('id_user', 'in', $users)
            ->orderBy('created_at', 'desc')
            ->page($page, self::POST_PER_PAGE)
        ->get();
        

        //2.1. Calculando o número total de páginas
        $totalPosts = Post::select()
            ->where('id_user', 'in', $users)
        ->count();

        $totalPages = ceil($totalPosts / intval(self::POST_PER_PAGE));

        //3. Transformar o resultado em objetos dos modelos.
        $posts = self::_postListToObject($postsList, $idUser);

        
        //5. Retornar os resultados.
        return [
            'posts' => $posts,
            'totalPages' => $totalPages,
            'currentPage' => $page,
        ];
    }

    //Feed de um perfil
    public static function getUserFeed($idUser, $page, $loggedUserId){
        
        //1. Pegar os posts dessa galera ordenado pela data.
        $page = intval($page);

        $postsList = $postsList = Post::select()
            ->where('id_user', $idUser)
            ->orderBy('created_at', 'desc')
            ->page($page, self::POST_PER_PAGE)
        ->get();
        

        //1.1. Calculando o número total de páginas
        $totalPosts = Post::select()
            ->where('id_user', $idUser)
        ->count();

        $totalPages = ceil($totalPosts / intval(self::POST_PER_PAGE));

        //2. Transformar o resultado em objetos dos modelos.
        $posts = self::_postListToObject($postsList, $loggedUserId);
        
        //4. Retornar os resultados.
        return [
            'posts' => $posts,
            'totalPages' => $totalPages,
            'currentPage' => $page,
        ];
    }

    //Funcao auxiliar que transforma um postList em uma lista de objetos Post
    private function _postListToObject($postsList, $loggedUserId){
        $posts = []; //array que armazenará cada OBJETO post

        foreach ($postsList as $postItem) {
            $newPost = new Post();

            //3.1 Adicionando informações do post
            $newPost->id = $postItem['id'];
            $newPost->type = $postItem['type'];
            $newPost->created_at = $postItem['created_at'];
            $newPost->body = $postItem['body'];
            $newPost->mine = false; //Se true, post é do usuário logado

            //Verificando se o post eh do usuário que esta logado
            if ($postItem['id_user'] == $loggedUserId) {
                $newPost->mine = true;
            }

            //3. Preencher as informações adicionais no post
            $newUser = User::select()->where('id', $postItem['id_user'])->one();

            $newPost->user = new User();
            $newPost->user->setId($newUser['id']);
            $newPost->user->setName($newUser['name']);
            $newPost->user->setAvatar($newUser['avatar']);

            //TODO 3.1 Preencher as informações de like
            $newPost->likeCount = 0;

            //Flag que indica se o usuário logado curtiu a respectiva postagem
            $newPost->liked = false;

            //TODO 3.2 Preencher as informações de comments
            $newPost->comments = [];

            $posts[] = $newPost;
        }

        return $posts;
    }

    public static function getPhotosFrom($idUser){
        $photosData = Post::select()
            ->where('id_user', $idUser)
            ->where('type', 'photo')
        ->get();

        $photos = [];

        foreach ($photosData as $photo) {
            $newPost = new Post();
            $newPost->id = $photo['id'];
            $newPost->type = $photo['type'];
            $newPost->created_at = $photo['created_at'];
            $newPost->body = $photo['body'];

            $photos[] = $newPost;
        }

        return $photos;
    }
}