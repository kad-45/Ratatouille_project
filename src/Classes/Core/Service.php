<?php
namespace App\Classes\Core;
/*require_once '../config/config.php';*/

use App\Classes\Repositories\UserRepository;
use DateTimeImmutable;

class Service {
      
  
    /**
     * @param array $file
     * @return null|string
     */
    public static function moveFile(array $file): ?string
    {
      
      $filePath = null;
      $folder = dirname(__DIR__, 3) . "/public/".  UPLOADDIRICTORY;
      if (!file_exists($folder)) {
        mkdir($folder, 0777);
      }
      
      $filename = self::renameFile($file["name"]);
      //move_uploaded_file() — Déplace un fichier téléchargé
      if (move_uploaded_file($file["tmp_name"], $folder . $filename)) {
        $filePath = UPLOADDIRICTORY. $filename;
      }
      
      return $filePath;
    }
          
          
    //Méthode qui renomme le fichier selon un new DateTimeImmutable("now"))->format("Ymdhis") et l'extention de fichier (.png).
    /**
     * @param string $filename
     * @return string
    */
    public static function renameFile(string $filename): string
    {
      $filename_array = explode(".", $filename);
      return (new DateTimeImmutable("NOW"))->format("YmdHis") . "." . end($filename_array);
    }

   /**@param array $tab
    *@param string $name
    *@param string $action
    *@return array
    */
   
    public static function getElements(array $tab, string $name, string $action = 'add'): array
    {
      $elements = [];
      $prefix = '';
      $keys = [];
      if ($name == 'ingredient') {
        $prefix = 'name';
        $keys = ['name_ingredient', 'quantity_ingredient', 'unity_ingredient'];
      } 
      if ($name == 'step') {
        $prefix = 'order';
        $keys = ['order_step', 'description_step'];

      }
      if ($action ==='update'){
        $keys[] = 'id_'.$name;
      } 
      $field = $prefix.'_' .$name;
      $nbrElements = count($tab[$field]);
      for ($i = 0; $i < $nbrElements; $i++) {
        $element = []; 
        foreach ($keys as $key) {
          $element[$key] = $tab[$key][$i];
        }
          $elements[] = $element;
      }
      
      return $elements;
    }

    /**
     * @return bool
    */

    public static function ifUserIsConnected()
    {
      $user_is_connected = false;
      $userRepository = new UserRepository();
      if (
        isset(
          $_SESSION['user_is_connected'],
          $_SESSION['user_id']
        )
        && $_SESSION['user_is_connected']
        && $userRepository->find($_SESSION['user_id'])
      ) {
        $user_is_connected =true;
      }
      return $user_is_connected;
    }
          
}