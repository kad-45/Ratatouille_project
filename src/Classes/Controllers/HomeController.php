<?php 
namespace App\Classes\Controllers;

class HomeController extends AbstractController {

  public function index() {
    $this->renderView('../../templates/home/index.phtml', [], []);
    
  }

}

?>