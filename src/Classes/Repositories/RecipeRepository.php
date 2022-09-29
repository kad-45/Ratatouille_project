<?php
namespace App\Classes\Repositories;

use App\Classes\Core\AbstractRepository;


class RecipeRepository extends AbstractRepository
{
  
  public function __construct()
  {
    $this->table = 'recipe';
  }
}
?>