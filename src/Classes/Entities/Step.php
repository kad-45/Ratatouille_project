<?php
namespace App\Classes\Entities;

use App\Classes\Core\ModelIterator;

class Step extends ModelIterator
{
    private   int $id;

    protected int $order_step;

    protected string $description_step;

    protected int $recipe_id;
    
    public function __construct(int $order_step, string $description_step, int $recipe_id)
    {
        $this->order_step = $order_step;
        $this->description_step = $description_step;
        $this->recipe_id = $recipe_id;

      
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getOrderStep(): string
    {
        return $this->order_Step;
    }

    public function setOrderStep(string $order_Step): self
    {
        $this->order_Step = $order_Step;

        return $this;
    }

    public function getDescriptionStep(): string
    {
        return $this->description_step;
    }

    public function setDescriptionStep(string $description_step): self
    {
        $this->description_step = $description_step;

        return $this;
    }

    public function getRecipeId(): int
    {
        return $this->recipe_id;
    }

    public function setRecipeId(int $recipe_id): self
    {
        $this->recipe_id = $recipe_id;

        return $this;
    }
}