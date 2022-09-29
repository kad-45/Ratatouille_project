<?php 
namespace App\Classes\Controllers;
//use App\Classes\Controllers\AbstractController;

class HomeController extends AbstractController {

  public function index() {
    
    
    $this->renderView('../../templates/home/index.phtml', [], []);
    
  }

}





?>