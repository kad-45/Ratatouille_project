<?php
namespace App\Classes\Entities;

use App\Classes\Core\ModelIterator;

class Recipe extends ModelIterator
{
    private   int $id;
    
    protected string $title;

    protected string $description;

    protected string $duration;

    protected string $file_path_img;
    
    protected int $user_id;

    protected int $category_id;
    
    protected string $created_at;

    protected string $updated_at;




    public function __construct(string $title, string $description, string $duration, $file_path_img, int $user_id, int $category_id, string $created_at, string $updated_at)
    {
        $this->title = $title;
        $this->description = $description;
        $this->duration = $duration;
        $this->file_path_img = $file_path_img; 
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->user_id = $user_id;
        $this->category_id = $category_id;

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
    public function getDuration(): string
    {
        return $this->duration;
    }

    public function setDuration($duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getFilePathImg()
    {
        return $this->file_path_img;
    }

    public function setFilePathImg($file_path_img)
    {
        $this->file_path_img = $file_path_img ;
        return $this;

    }

    public function getCreated_at(): string
    {
        return $this->created_at;
    }

    public function setCreated_at(string $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdate_at(): string
    {
        return $this->updated_at;
    }

    public function setUpdated_at(string $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function setUserId(?int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getCategoryId(): int
    {
        return $this->category_id;
    }

    public function setCategoryId(?int $category_id): self
    {
        $this->category_id = $category_id;

        return $this;
    }







}