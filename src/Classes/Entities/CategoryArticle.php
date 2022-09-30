<?php
namespace App\Classes\Entities;

use App\Classes\Core\ModelIterator;

class CategoryArticle extends ModelIterator
{
  private   ?int $id;
  protected ?string $name;
  
  public function __construct()
  {
    
  }
  
  public function getId(): int
  {
    return $this->id;
  }

  public function getName(): ?string
  {
    return $this->name;
  }

  public function setName(string $name): self
  {
    $this->name = $name;
    return $this;
  }
}


?>