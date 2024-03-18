<?php
namespace src\controllers;

use \core\Controller;
use \src\handlers\UserHandler;
use \src\handlers\PostHandler;

class ProfileController extends Controller {

    private $loggedUser;

    public function __construct(){
        $this->loggedUser = UserHandler::checkLogin();
        if($this->loggedUser === false){
            $this->redirect('/login');
        }
    }

    public function index($args = []){
        $page = intval(filter_input(INPUT_GET, 'page'));

        //Detctando o usuario acessado
        $id = $this->loggedUser->id;
        if(!empty($args['id'])){
            $id = $args['id'];
        }

        //pegando informações do usuario
        $user = UserHandler::getUser($id, true);
        if(!$user){
            $this->redirect('/');
        }

        //pegando feed do usuario
        $feed = PostHandler::getUserFeed(
            $id, 
            $page, 
            $this->loggedUser->id);


        //verificar se Eu sigo o usuario
        $isFollowing = true;
        if($user->id != $this->loggedUser->id){
            $isFollowing = UserHandler::isFollowing($this->loggedUser->id, $user->id);
        }

        $this->render('profile',[
            'loggedUser' => $this->loggedUser,
            'user' => $user,
            'feed' => $feed,
            'isFollowing' => $isFollowing
        ]);
    }

    public function follow($args = []){
        $id = intval($args['id']);

        $exists = UserHandler::idExists($id);

        if($exists){

            if(!empty($id) && ($id != $this->loggedUser->id)){

                $follow = UserHandler::follow($this->loggedUser->id, $id);
    
            }
        }
      
        $this->redirect('/perfil/'.$id);
       
    }

    public function friends($args = []){
        //Detctando o usuario acessado
        $id = $this->loggedUser->id;
        if(!empty($args['id'])){
            $id = $args['id'];
        }

        //pegando informações do usuario
        $user = UserHandler::getUser($id, true);
        if(!$user){
            $this->redirect('/');
        }

        //verificar se Eu sigo o usuario
        $isFollowing = true;
        if($user->id != $this->loggedUser->id){
            $isFollowing = UserHandler::isFollowing($this->loggedUser->id, $user->id);
        }

        $this->render('profile_friends',[
            'loggedUser' => $this->loggedUser,
            'user' => $user,
            'isFollowing' => $isFollowing
        ]);

    }

    public function photos($args = []){
        //Detctando o usuario acessado
        $id = $this->loggedUser->id;
        if(!empty($args['id'])){
            $id = $args['id'];
        }

        //pegando informações do usuario
        $user = UserHandler::getUser($id, true);
        if(!$user){
            $this->redirect('/');
        }

        //verificar se Eu sigo o usuario
        $isFollowing = true;
        if($user->id != $this->loggedUser->id){
            $isFollowing = UserHandler::isFollowing($this->loggedUser->id, $user->id);
        }

        $this->render('profile_photos',[
            'loggedUser' => $this->loggedUser,
            'user' => $user,
            'isFollowing' => $isFollowing
        ]);

    }

    



}