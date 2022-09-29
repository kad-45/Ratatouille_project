<?php 
namespace App\Classes\Entities;

use App\Classes\Core\ModelIterator;

class Article extends ModelIterator {
    
    private   ?int $id;
    protected ?string $title;
    protected ?string $file_path_img;
    protected ?string $description;
    protected ?string $date_published;
    protected ?int $user_id;
    protected ?int $categoryArticle_id;

    public function __construct(string $title, string $description, $file_path_img, int $user_id, int $categoryArticle_id,  string $date_published)
    {
        $this->title = $title;
        $this->description = $description;
        $this->date_published = $date_published;
        $this->file_path_img = $file_path_img; 
        $this->user_id = $user_id;
        $this->categoryArticle_id = $categoryArticle_id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
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


    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }


    public function getDate_published(): string
    {
        return $this->date_published;
    }

    
    public function setDate_published(?string $date_published): self
    {
        $this->date_published = $date_published;
        return $this;
    }
    
    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(?int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getCategoryArticle_id(): ?int
    {
        return $this->categoryArticle_id;
    }

    public function setCategoryArticle_id(?int $categoryArticle_id): self
    {
        $this->categoryArticle_id = $categoryArticle_id;
        return $this;
    }
}
?>