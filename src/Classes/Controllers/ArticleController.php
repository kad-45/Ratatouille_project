<?php
namespace App\Classes\Controllers;
use App\Classes\Controllers\AbstractController;
use App\Classes\Core\Service;
use App\Classes\Entities\Article;
use App\Classes\Repositories\ArticleRepository;
use App\Classes\Repositories\CategoryArticleRepository;
use App\Classes\Repositories\UserRepository;
use DateTimeImmutable;
use Exception;

class ArticleController extends AbstractController{

  /**
   * @param mixed $id
   * @return string
  */
    public function index($id = NULL)
    {
      $_SESSION['categoryArticle'] = $id;
      $articleRepository = new ArticleRepository();
    if (is_null($id)) 
    {
        $articles = $articleRepository->findAll();
        
    } else {
      
        $articles = $articleRepository->findBy(['categoryArticle_id' => $id]) ;
    }
    try {
      $libelle = $this->getCategoryArticle($id);
    } catch (Exception $e) {
      
      return $this->renderView('../../templates/Error/404.phtml', [], [
        'message' => $e->getMessage()
      ]);
    }
        return $this->renderView('../../templates/Articles/index.phtml', [], [
            'articles' => $articles,
            'libelle' => $libelle
        ]);
    }

     
    /**
     * @return string
    */
    public function add()
    {

        $fields = ['title', 'description', 'categoryArticle_id'];
        $errs = [];
        $errors = [];
        $message = NULL;
        $articleRepository = new ArticleRepository();
         $categoryArticleRepository = new CategoryArticleRepository();
         $categories = $categoryArticleRepository->findAll();
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST) && !empty($_FILES)) 
        {
            
            $errs = array_map(
              function($field) use (&$errors){ 
                if(!isset($_POST[$field]) || empty($_POST[$field])){
                  $errors[$field] = 'Le champ ' .$field .' doit être renseigner ';
                  return 'Le champ ' .$field .' doit être renseigner ';
                }
              }, $fields);
              if ($_FILES['img']['size'] === 0) {
                $errors['img'] = "Le champ image doit être renseigner "; 
              } 
              if(!empty($errors)){
                $message = 'Veuillez corriger les erreurs suivantes:';
                return $this->renderView("../../templates/Articles/article_add.phtml", [], [
                  "errors" => $errors,
                  "message" => $message,
                  "categories" => $categories
                ]);
              }
            $title = htmlspecialchars(strip_tags($_POST['title']));
            $description = htmlspecialchars(strip_tags($_POST['description']));
            $file_path_img = Service::moveFile($_FILES['img']) ;
            $categoryArticle_id = htmlspecialchars(strip_tags($_POST['categoryArticle_id']));
             
            $user_id = $_SESSION['user_id'];
            $date = new DateTimeImmutable();
            $article = new Article($title, $description, $file_path_img, $user_id, $categoryArticle_id, $date->format('Y-m-d H:s:i')); 
            $article = $articleRepository->create($article);
            $articles = $articleRepository->findAll();
            $successMsg = 'Votre article a été bien ajouté';
            return $this->renderView("../../templates/Articles/index.phtml", [], [
          
                "articles" => $articles,
                "successMsg" => $successMsg
              ]);     
        } else {
            return $this->renderView("../../templates/Articles/article_add.phtml", [], [
          
                "categories" => $categories
      
              ]);   
          }

    }

   /**  
    * @param mixed $id
    * @return string
   */
    public  function show($id)
    {
      $article = [];
      $categoryArticle = [];
      $user = NULL;

      if (isset($id)) {
        $articleRepository =new ArticleRepository();
        $userRepository = new UserRepository();
        $categoryArticleRepository = new CategoryArticleRepository();
        
        if (empty($articleRepository->find($id))) {
          return $this->renderView('../../templates/Error/404.phtml', [], []);
        }

        $article = $articleRepository->find($id)[0];
        $categoryArticle = $categoryArticleRepository->find($article['id']) ?? [];
        $user = $userRepository->find($article['user_id']);

      }
      return $this->renderView('./../templates/Articles/article_show.phtml.', [], [
        'article' => $article,
        'user' => $user,
        'categoryArticle' =>$categoryArticle
      ]);
    }

    /**
     * @param mixed $id
     * @return string
     */
    public function update($id)
    {
      
      $articleRepository = new ArticleRepository();
      $categoryArticleRepository = new CategoryArticleRepository();
      $categories = $categoryArticleRepository->findAll();
  
       if(empty($articleRepository->findBy(['id' => $id]))) {
            
          return $this->renderView('../../templates/Error/404.phtml', [], []);
        }
      $article = $articleRepository->findBy(['id' => $id])[0];

      if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        
        return $this->renderView('../../templates/Articles/article_update.phtml', [], [
          'article' => $article,
          'categories' => $categories
        ]);
      } else {
        $fields = ['title', 'description', 'categoryArticle_id'];
        $errs = [];
        $errors = [];
        $message = NULL;
        $articleRepository = new ArticleRepository();
        $categoryArticleRepository = new CategoryArticleRepository();
        $categories = $categoryArticleRepository->findAll();
        
        if (!empty($_POST)) {
          
          $errs = array_map(function($field) use (&$errors)
                { 
                  if(!isset($_POST[$field]) || empty($_POST[$field])){
                    $errors[$field] = 'Le champ ' .$field .' doit être renseigner ';
                    return 'Le champ ' .$field .' doit être renseigner ';
                  }
                }, $fields);
                  if ($_FILES['file_path_img']['size'] === 0) {
                      $errors['file_path_img'] = "Le champ image doit être renseigner ";
                  }
                  if(!empty($errors)){
                      $message = 'Veuillez corriger les erreurs suivantes:';
                      
                      return $this->renderView('../../templates/Articles/article_update.phtml',[], [
                        'errors' => $errors,
                        'message' => $message,
                        'article' => $article,
                        'categories' => $categories
                      ] );
                    }
          $title = strip_tags($_POST['title']);
          $description = strip_tags($_POST['description']);
          $file_path_img = Service::moveFile($_FILES['file_path_img']);
          $categoryArticle_id = strip_tags($_POST['categoryArticle_id']);
          
          $user_id = $_SESSION['user_id'];
          $date = new DateTimeImmutable();
          $article = new Article($title, $description, $file_path_img, $user_id, $categoryArticle_id, $date->format('Y-m-d H:s:i'));
  
          $articleRepository->update($id, $article);
  
          $successMsg = 'Votre article a été mise à jour';
                
        
        }
        return $this->renderView('../../templates/Articles/index.phtml', [], [
          'articles' => $articleRepository->findAll(),
          'successMsg' =>$successMsg,
          'libelle' => $this->getCategoryArticle($_SESSION['categoryArticle'])
        ]);
      
      }
    }
  
    /**
     * @return string
     */
    public function delete()
    {

      $article = [];
      $articleRepository = new ArticleRepository();
      if (Service:: ifUserIsConnected()
        && isset($_POST['article_id'])
   
      ) {
       $article = $articleRepository->delete(['id' => $_POST['article_id']]);
       
        if (is_nan($_SESSION['categoryArticle'])) 
        {
          
          $article = $articleRepository->findAll();
        
        } else {
          
          $article = $articleRepository->findBy(['categoryArticle_id' => $_SESSION['categoryArticle']]);
        }
       
      }
      return $this->renderView('../../templates/Articles/index.phtml', [], [
        'articles' => $article,
        'libelle' => $this->getCategoryArticle($_SESSION['categoryArticle']) 
      ]);
    }

  private function getCategoryArticle(int $id = NULL): string
  {
    if (is_null($id)) {
      return 'articles';
    } else {
      $categoryArticleRepository = new CategoryArticleRepository(); 
      if (!empty($categoryArticleRepository->find($id))) 
      {
        $categoryArticle = $categoryArticleRepository->find($id)[0]['name'];
        return $categoryArticle; 
      } else {
        throw new Exception('Cette page n\'existe pas');
      }
    }
  }

}

?>