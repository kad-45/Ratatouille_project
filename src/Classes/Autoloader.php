<?php 
namespace App\Classes;

class Autoloader {
  
  static function register() {
    
    spl_autoload_register(array(__CLASS__, "autoload"));
  }

  static function autoload($class) {
    $class = str_replace(__NAMESPACE__ . '\\', '', $class);
    $class = str_replace('\\', '/', $class);
    if(file_exists(__DIR__ . '/' . $class . '.php')) {
      require __DIR__ . '/'. $class .'.php';  
    }else{
    http_response_code(404);
    echo "Erreur lors du chargement des classes ";
    }
  
  }
}
?>