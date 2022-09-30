<?php
namespace App\Classes\Repositories;

use App\Classes\Core\AbstractRepository;

class UserRepository extends AbstractRepository 
{
  
  public function __construct()
  {
    $this->table = 'user';
  }
}
?>