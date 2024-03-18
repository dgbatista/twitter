<?php
namespace src\controllers;

use \core\Controller;
use \src\handlers\UserHandler;
use \src\handlers\UploadsHandler;
use \src\models\User;

class ConfigController extends Controller {

    private $loggedUser;

    public function __construct(){
        $this->loggedUser = UserHandler::checkLogin();
        if($this->loggedUser === false){
            $this->redirect('/login');
        }
    }

    public function index() {
        $flash = '';
        if(!empty($_SESSION['flash'])){
            $flash = $_SESSION['flash'];
            $_SESSION['flash'] = '';
        }        

        //pegando informações do usuario
        $user = UserHandler::getUser($this->loggedUser->id, true);
        if(!$user){
            $this->redirect('/');
        }

        $this->render('config',[
            'loggedUser' =>$this->loggedUser,
            'user' => $user,
            'flash' => $flash
        ]);  
    }

    public function save(){
        
        $updateFields = [];
        $flash = [];
        $id =  intval(filter_input(INPUT_POST, 'id'));
        $name = filter_input(INPUT_POST, 'name');
        $birthdate = filter_input(INPUT_POST, 'birthdate');
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $city = filter_input(INPUT_POST, 'city');
        $work = filter_input(INPUT_POST, 'work');
        $password = filter_input(INPUT_POST, 'password');
        $password_confirm = filter_input(INPUT_POST, 'password_confirm');

        $user = UserHandler::getUser($this->loggedUser->id, true);
        if(!$user){
            $this->redirect('/');
        }

        //verifica se usuário existe
        if(!UserHandler::idExists($id)){
            $_SESSION['flash'] = 'Usuário  não existe!';
            $this->redirect('/config');
        }

        //verifica se todos os campos obrigatorios existem e estão preenchidos
        if((isset($name) && empty($name)) || (isset($birthdate) && empty($birthdate)) || (isset($email) && empty($email))){
            $_SESSION['flash'] = 'Prencha todos os campos obrigatórios!';
            $this->redirect('/config');
        }  else {

            //BIRTHDATE
            $birthdate = explode('/', $birthdate); 
            if(count($birthdate) != 3){
                $_SESSION['flash'] = 'Data de Nascimento inválida!';
                $this->redirect('/config');
            }
            $birthdate = $birthdate[2].'-'.$birthdate[1].'-'.$birthdate[0];
            if(strtotime($birthdate) === false){                  
                $_SESSION['flash'] = 'Data de Nascimento inválida!';
                $this->redirect('/config');

            }
            $updateFields['birthdate'] = $birthdate;         
            
            //PASSWORD  
            if(isset($password) && !empty($password)){
                
                if($password === $password_confirm){
                    $updateFields['password'] = $password;    
                } else {
                    $_SESSION['flash'] = 'As senhas não conferem';
                    $this->redirect('/config');
                }
            }     
        
            //EMAIL
            if($user->email != $email){
                if(!UserHandler::emailExists($email)){
                    $updateFields['email'] = $email;
                }else{
                    $_SESSION['flash'] = 'E-mail já existe!';
                    $this->redirect('/config');
                }
            }

            //CAMPOS NORMAIS
            $updateFields['name'] = trim($name);
            $updateFields['work'] = trim($work);
            $updateFields['city'] = trim($city);      

            ///AVATAR
            if(isset($_FILES['avatar']) && !empty($_FILES['avatar']['tmp_name'])){
                $newAvatar = $_FILES['avatar'];

                if(in_array($newAvatar['type'], ['image/jpeg','image/jpg', 'image/png'])){
                    $avatarName = UploadsHandler::cutImage($newAvatar, 200, 200, 'media/avatars');
                    $updateFields['avatar'] = $avatarName;
                    if($user->avatar != 'avatar.jpg') {
                        unlink($_SERVER['DOCUMENT_ROOT'].'/devsbook/public/media/avatars/'.$user->avatar);
                    }
                }
            }

            //COVER
            if(isset($_FILES['cover']) && !empty($_FILES['cover']['tmp_name'])){
                $newCover = $_FILES['cover'];

                if(in_array($newCover['type'], ['image/jpeg','image/jpg', 'image/png'])){
                    $coverName = UploadsHandler::cutImage($newCover, 850, 310, 'media/covers');
                    $updateFields['cover'] = $coverName;
                    if($user->cover != 'cover.jpg') {
                        unlink($_SERVER['DOCUMENT_ROOT'].'/devsbook/public/media/covers/'.$user->cover);
                    }
                }
            }
          
            UserHandler::updateUser($updateFields, $this->loggedUser->id);

        }

        $this->redirect('/config');
             
    }

}