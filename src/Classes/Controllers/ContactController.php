<?php 
namespace App\Classes\Controllers;
use App\Classes\Controllers\AbstractController;
use App\Classes\Core\Validation;

class ContactController extends AbstractController {

  public function index()
  {
        if($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->renderView('../../templates/_contact.phtml', [], []);
            
        } else {
            //On va récupérer toutes les valeures de formulaire.
            $name = htmlspecialchars(strip_tags($_POST['name']));
            $email = htmlspecialchars(strip_tags($_POST['email']));
            $phone = htmlspecialchars(strip_tags($_POST['phone']));
            $company = htmlspecialchars(strip_tags($_POST['company']));
            $message = htmlspecialchars(strip_tags($_POST['message']));

            if (!empty($_POST) && isset($name, $email, $phone, $message)) {
              
              $errors = [];
              $fields = ['name'=>['validRequired'], 'email'=>['validEmail'], 'phone'=>['validPhone'], 'message'=>['validRequired']];
              $form = new Validation($_POST);
              if(!$form->isValid($fields)) {
                return $this->renderView('../../templates/_contact.phtml',[], [
                    'errors' => $form->getErrors(),
                    'parametrs'=> $_POST
                ] );            
            
              } else {
                $successMsg = 'Merci pour votre message. Notre équipe prendra contact avec vous dans des brèfs délai';
                
                return $this->renderView('../../templates/_contact.phtml', [], [
                  'successMsg' => $successMsg
                ]);
                
              }
      
     
            }
    
        }
  }
    
}


?>