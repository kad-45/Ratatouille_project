<?php 
namespace App\Classes\Controllers;

abstract  class AbstractController {
    
     /**
     * @param string $path chemin du template à renvoyer
     * @param array $params tableau avec les paramètres renvoyer dans le template 
     * @return string retourne le code html correspond au chemin
     */
    public function renderView(string $path , array $assets = [] , array $params = []):string
    {
        return require_once dirname(__DIR__,2).$path;
    }
 
  
  
}



?>