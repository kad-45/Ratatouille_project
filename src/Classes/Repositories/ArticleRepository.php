<?php
namespace App\Classes\Repositories;

use App\Classes\Core\AbstractRepository;


class ArticleRepository extends AbstractRepository
{
  
  public function __construct()
  {
    $this->table = 'article';
  }
}
?>