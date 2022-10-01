<?php 
namespace App\Classes\Controllers;

use App\Classes\Controllers\AbstractController;
use App\Classes\Repositories\UserRepository;
use App\Classes\Entities\User;
use \DateTimeImmutable;
use App\Classes\Core\Validation;
use App\Classes\Core\Service;

class UserController extends AbstractController {

  public function index() {
   $userRepository = new UserRepository();
   $users = $userRepository->findAll(); 
   $this->renderView('../../templates/Users/index.phtml', [], ['users' =>$users]);
  }
  
  /**
   * @return string
   */
  public function add() {
    $role = 'user';
    $error = null;
    $message = "";
    //Verification de l'existence des indexs dans $_POST
    if(!empty($_POST) && isset($_POST['lastname'], $_POST['firstname'], $_POST['email'],$_POST['password'])) {
        $errors = [];
        $fields = ['lastname'=>['validRequired'], 'firstname'=>['validRequired'], 'email'=>['validEmail'], 'password'=>['validRequired']];
        $form = new Validation($_POST);
        if(!$form->isValid($fields)) {

            return $this->renderView('../../templates/Users/user_add.phtml',[], [
                'errors' => $form->getErrors(),
                'parametrs'=> $_POST
            ] );

        } else {
            $userRepository = new UserRepository();
            //Déclaration et assignation des variables avec vérification de l'existence des valeurs valides.

            $lastname = strip_tags($_POST['lastname']);
            $firstname = strip_tags($_POST['firstname']);
            $email = strip_tags($_POST['email']);
            $password = strip_tags($_POST['password']);

            //Vérification si un utilisateur n'existe pas dèjà avec cet email.
            $message = "Erreur : l'utilisateur existe dèjà.";
            if (empty($userRepository->findBy(['email' => $email]))) {
                //Instanciation de User.
                $date = new DateTimeImmutable();
                $user = new User($lastname, $firstname, $email, $role, $date->format('Y-m-d H:s:i'), $date->format('Y-m-d H:s:i'));
                $user->setPassword($password);
                //Création d'un nouveau utilisateur dans la BDD
                $userRepository->create($user);
                //Gestion d'erreur
                $message = "L'utilisateur a été créé";

                return $this->renderView('../../templates/Users/index.phtml', [], [
                    'successMsg' => $message,
                    'users' => $userRepository->findAll()
                ]);
            } else {
                //l'utilisateur exist
            }
        }
        
    }else {
     
        //Renvoie de la vue correspondante avec des paramètres.
        $userRepository = new UserRepository('user');
        $users = $userRepository->findAll();
        $this->renderView('../../templates/Users/user_add.phtml', [
          "users" => $users,
          "error" => $error,
          "message" => $message
        ]);
      }
    
  }
  
  /**
   * @param mixed $id
   * @return string
   */
  public function update($id)
  {
    
    $userRepository = new UserRepository();
    $user = $userRepository->findBy(['id' => $id])[0]; 
    if (empty($user)) {
      return $this->renderView('../../templates/Error/404.phtml', [], []);
      
    } 

    if ($_SERVER['REQUEST_METHOD'] === 'GET') 
    {
      return $this->renderView('../../templates/Users/user_update.phtml', [], [
        'user' => $user
      ]); 
    } else {
      $errs = [];
      $errors = [];
      $message = NULL;
      $userRepository = new UserRepository();
      $fields = ['lastname'=>['validRequired'], 'firstname'=>['validRequired'], 'email'=>['validEmail'], 'password'=>['validRequired']];
        $form = new Validation($_POST);
        if(!$form->isValid($fields)) {

            return $this->renderView('../../templates/Users/user_update.phtml',[], [
                'errors' => $form->getErrors(),
                'parametrs'=> $_POST,
                'user' => $user 
            ] );

        }else{
                
            $lastname = strip_tags($_POST['lastname']);
            $firstname = strip_tags($_POST['firstname']);
            $email = strip_tags($_POST['email']);
            $role = 'user';

            $password = strip_tags($_POST['password']);
            $date = new DateTimeImmutable();
            $newUser = new User($lastname, $firstname, $email, $role, $date->format('Y-m-d H:s:i'), $date->format('Y-m-d H:s:i'));
            if ($user['password'] !== $password) {
               $newUser->setPassword($password);
            }

            $userRepository->update($id, $newUser);
           // $user = $userRepository->findAll();
            $successMsg = 'Votre utilisateur a été mi à jour';
                
      }
      return $this->renderView('../../templates/Users/index.phtml', [], [
        'users' => $userRepository->findAll(),
        'successMsg' => $successMsg  
      ]);
    }
  } 

  /**
   * @return string
   */
  public function delete()
  {
    $message = NULL;
    $user = [];
    $userRepository = new UserRepository();

    if (Service:: ifUserIsConnected()
    && isset($_POST['user_id'])
   
    ) {
      $user = $userRepository->findBy(['id' => $_POST['user_id']])[0]; 
      if (empty($user)) {
        return $this->renderView('../../templates/Error/404.phtml', [], []);
        
      }             
      $updateAt = new DateTimeImmutable();

      $newUser = new User($user['lastname'], $user['firstname'], $user['email'], $user['role'], $user['created_at'], $updateAt->format('Y-m-d H:s:i'));
      $newUser->setActif(0);
      $userRepository->update($_POST['user_id'], $newUser);

      $message = 'L\'utilisateur a été supprimé';
     }
     return $this->renderView('../../templates/Users/index.phtml', [], [
          'users' => $userRepository->findAll(),
          'successMsg' => $message
           
     ]);   
     

  }

  /**
   * @Route user/connexion
   * @return string
   */

   public function connexion()
   {
    $error = NULL;
    //On vérifie si tous les champs requis sont remplis.
  if (isset($_POST['email'], 
    $_POST['password'])
    && !empty($_POST['email'])
    && !empty($_POST['password'])
    ) {
      $userRepository = new UserRepository('user');
      $user = $userRepository->findBy(['email' => $_POST['email'], 'actif' => 1]);
    // var_dump($_POST['password']); 
    // var_dump($user); 
      //password_verify — Vérifie qu'un mot de passe correspond à un hachage.

      if (!empty($user) && password_verify($_POST['password'], $user[0]['password'])) {
        
          $_SESSION['user_is_connected'] = true;
          $_SESSION['user_id'] = $user[0]['id'];
          $_SESSION['role'] = $user[0]['role'];

          header('Location: /home/index');
          echo "<div class='alert-success' style = 'background:green; item-align: center; font-size:16px;>Vous êtes connecté</div>";
      } else {
        echo "<div class='alert' style = 'background:red; padding-top:10px;color:white; text-align: center; margin-left:36%; width:400px; height:40px; font-size:16px;'>Identifiant ou mot de passe incorrect</div>";
      }
      
    }
    return $this->renderView('../../templates/Users/login.phtml', [], [
      'error' => $error
    ]);
    
   }

    /**
     * @return void
     * @Route user_disconnect 
     */

     public function disconnect()
     {
      unset($_SESSION['user_is_connected']);
       header('Location: /home/index');
     }
}

?>