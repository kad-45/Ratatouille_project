<?php 
namespace App\Classes\Repositories;

use App\Classes\Core\AbstractRepository;

class IngredientRepository extends AbstractRepository
{
  public function __construct()
  {
    $this->table = 'ingredient';
  }
}
?>