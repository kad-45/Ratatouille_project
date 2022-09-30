<?php
namespace App\Classes\Entities;

use App\Classes\Core\ModelIterator;

class Ingredient extends ModelIterator
{
    private   ?int $id;

    protected ?string $name_ingredient;
    
    protected ?string $quantity_ingredient;
   
    protected ?string $unity_ingredient;
    
    protected ?int $recipe_id;


    public function __construct(string $name_ingredient, string $quantity_ingredient, string $unity_ingredient, int $recipe_id)
    {
        $this->name_ingredient = $name_ingredient;
        $this->quantity_ingredient = $quantity_ingredient;
        $this->unity_ingredient = $unity_ingredient;
        $this->recipe_id = $recipe_id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameIngredient(): ?string
    {
        return $this->name_ingredient;
    }

    public function setName(string $name_ingredient): self
    {
        $this->name_ingredient = $name_ingredient;

        return $this;
    }

    
    
    public function getQuantityIngredient(): string
    {
        return $this->quantity_ingredient;
    }

    public function setQuantitIngredienty(string $quantity_ingredient): self
    {
         $this->quantity_ingredient = $quantity_ingredient;
         return $this;
    }

    public function getUnityIngredient(): string
    {
        return $this->unity_ingredient;
    }

    public function setUnity(string $unity_ingredient): self
    {
         $this->unity_ingredient = $unity_ingredient;
         return $this;
    }

    public function getRecipeId(): ?int
    {
        return $this->recipe_id;
    }

    public function setRecipeId(int $recipe_id): self
    {
         $this->recipe_id = $recipe_id;
         return $this;
    }
}