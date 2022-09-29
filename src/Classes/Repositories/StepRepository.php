<?php 
namespace App\Classes\Repositories;

use App\Classes\Core\AbstractRepository;

class StepRepository extends AbstractRepository
{
  public function __construct()
  {
    $this->table = 'step';
  }
}
?>