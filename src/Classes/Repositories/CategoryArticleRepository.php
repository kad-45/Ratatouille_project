<?php
namespace App\Classes\Repositories;

use App\Classes\Core\AbstractRepository;

class CategoryArticleRepository extends AbstractRepository{
    
    public function __construct()
  {
    $this->table = 'categoryarticle';
  }
}
?>