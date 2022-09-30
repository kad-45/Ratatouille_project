<?php

namespace App\Classes\Core;


class ModelIterator
{
  /**
   * Cette méthode permet de réccuperer les attributs et les valeurs des propiriètés d'un objet
   * @return array $attributes.
   */
  public function getAttributes() 
  {
    $attributes = [];
    foreach ($this as $key => $value) {
        if($key !=='id') {
            
            $attributes[$key] = $value;
        }
    }
    return $attributes; 
  }
}

?>