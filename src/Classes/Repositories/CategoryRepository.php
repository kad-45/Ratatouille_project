<?php

namespace App\Classes\Repositories;

use App\Classes\Core\AbstractRepository;

class CategoryRepository extends AbstractRepository
{
  public function __construct()
  {
    $this->table = 'category';
  }
}
?>