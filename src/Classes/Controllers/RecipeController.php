<?php 
namespace App\Classes\Controllers;

use App\Classes\Core\Validation;
use App\Classes\Repositories\RecipeRepository;
use App\Classes\Repositories\IngredientRepository;
use App\Classes\Entities\Recipe;
use App\Classes\Entities\Step;
use App\Classes\Core\Service;
use App\Classes\Entities\Ingredient;
use App\Classes\Repositories\CategoryRepository;
use App\Classes\Repositories\StepRepository;
use DateTimeImmutable;
use Exception;

class RecipeController extends AbstractController {
    
 /**
  *@param mixed $id 
  *@return string|void
  */ 
  
  public function index($id = null) {
    $_SESSION['category'] = $id;
    $recipeRepository = new RecipeRepository();
    if (is_null($id)) {
        $recipes = $recipeRepository->findAll();
    } else {
        $recipes = $recipeRepository->findBy(['category_id' => $id]) ;
      
        
    }
    try {
      $libelle =  $this->getCategory($id);
      
    } catch (Exception $e) {
      
      return $this->renderView('../../templates/Error/404.phtml', [], [
        'message' => $e->getMessage()
      ]);
    }
    
    $this->renderView('../../templates/Recipes/index.phtml', [], [
      'recipes' => $recipes,
      'libelle' => $libelle
    ]);

  }

  /**
   * @return string
   */
  public function add() 
  {

    $fields = [
        'title' => ['validRequired'],
        'description' => ['validRequired'],
        'duration' => ['validRequired'],
        'name_ingredient' => ['validRequired'],
        'quantity_ingredient' => ['validSize'],
        'unity_ingredient' => ['validRequired'],
        'order_step' => ['validSize'],
        'description_step' => ['validRequired'],
        'category_id' => ['validSize']
    ];
    $errs = [];
    $errors = [];
    $message = NULL;
    $recipeRepository = new RecipeRepository();
    $stepRepository = new StepRepository();
    $ingredientRepository= new IngredientRepository(); 
    $categoryRepository = new CategoryRepository();
    $categories = $categoryRepository->findAll();

    if (!empty($_POST)) 
      {

          $formValid = new Validation($_POST);
          $fileValid = new Validation($_FILES['img']);
          $isFormvalid = $formValid->isValid($fields);
          $isFileValid = $fileValid->isValid(['size' =>['validFile']]);


          if(!$isFormvalid || !$isFileValid){
              $message = 'Veuillez corriger les erreurs suivantes:';
              return $this->renderView("../../templates/Recipes/add.phtml", [], [
                  "errors" => array_merge($formValid->getErrors(), $fileValid->getErrors()),
                  "message" => $message,
                  "categories" => $categories,
                  "parameters" => $_POST
              ]);
          }else {
              $title = strip_tags($_POST['title']);
              $description = strip_tags($_POST['description']);
              $duration = strip_tags($_POST['duration']);
              $file_path_img = Service::moveFile($_FILES['img']);
              $category_id = strip_tags($_POST['category_id']);
              $ingredients = Service::getElements($_POST, 'ingredient');
              $steps = Service::getElements($_POST, 'step');

              $date = new DateTimeImmutable();
              $recipe = new Recipe($title, $description, $duration, $file_path_img, $_SESSION['user_id'], $category_id, $date->format('Y-m-d H:s:i'), $date->format('Y-m-d H:s:i'));

              $recipe_id = $recipeRepository->create($recipe);
              $step_ids = [];
              $ingredient_ids = [];
              foreach ($steps as $stp) {

                  $step = new Step($stp['order_step'], $stp['description_step'], $recipe_id);
                  $step_ids[] = $stepRepository->create($step);

              }
              foreach ($ingredients as $ing) {
                  $ingredient = new Ingredient($ing['name_ingredient'], $ing['quantity_ingredient'], $ing['unity_ingredient'], $recipe_id);
                  $ingredient_ids[] = $ingredientRepository->create($ingredient);
              }
          }
          $message = 'La rectte a été crée avec succée';
          return $this->renderView('../../templates/Recipes/index.phtml', [], [
            'recipes' => $recipeRepository->findAll(),
            'libelle' => $this->getCategory($_SESSION['category']),
            'successMsg' => $message
             
       ]);   
  

      } else { 
        return $this->renderView("../../templates/Recipes/add.phtml", [], [
          
          "categories" => $categories

        ]);
    }
     

  }

  /**
   *@param mixed $id
   *@return string
  */
  public function show($id)
  {
    
    $recipe = []; 
    if (isset($id)) {
        $recipeRepository = new RecipeRepository();
        if(empty($recipeRepository->find($id))) {
          
          return $this->renderView('../../templates/Error/404.phtml', [], []);
        }

        $recipe = $recipeRepository->find($id)[0];
        
        $ingredientRepository = new IngredientRepository();
        $recipe['ingredients'] = $ingredientRepository->findBy(['recipe_id' => $id]);
        
        $stepRepository = new StepRepository();
        $recipe['steps'] = $stepRepository->findBy(['recipe_id' => $id]);


        
    } 
    return $this->renderView('../../templates/Recipes/show.phtml', [], ['recipe' => $recipe]);
    
  }

  /**  
   *@param mixed $id
   *@return string
  */

  public function update($id = null)
  {
    if (is_null($id)) {
      return $this->renderView('../../templates/Error/404.phtml', [], [
        'message' => 'Erreur 400 : syntaxe invalide.'
      ]);

    }

      $recipeRepository = new RecipeRepository();
      $ingredientRepository = new IngredientRepository();
      $stepRepository = new StepRepository();
      $categoryRepository = new CategoryRepository();
      $categories = $categoryRepository->findAll();
      $recipe = $recipeRepository->findBy(['id' => $id]);
      if(empty($recipe)) {
          
        return $this->renderView('../../templates/Error/404.phtml', [], [
          'message' => 'Erreur 404 : Cette recette n\'existe pas'
        ]);
      }

      $recipe = $recipe[0];
      if ($recipe['user_id'] !== $_SESSION['user_id'] || $_SESSION['role'] !== ROLE_ADMIN ) {
        return $this->renderView('../../templates/Error/404.phtml', [], [
          'message' => 'Erreur 403 : Vous n\'avez pas les droits d\'accées à cette recette' 
        ]);
      }
      $recipe['ingredients'] = $ingredientRepository->findBy(['recipe_id' => $id]);

      $recipe['steps'] = $stepRepository->findBy(['recipe_id' => $id]);


      if($_SERVER['REQUEST_METHOD'] === 'GET')
      {
        
        //creation du formulaire pre-rempli,pour modifier ou mettre à jour la recette     
        return $this->renderView('../../templates/Recipes/template_part/add_form.phtml', [],
        ['recipe' => $recipe, 'categories' => $categories]);

        
      } else {
        $fields = ['title', 'description', 'duration', 'name_ingredient', 'quantity_ingredient', 'unity_ingredient', 'order_step', 'description_step', 'category_id'];
        $errs = [];
        $errors = [];
        $user_id = 1;
        $message = NULL;
        $recipeRepository = new RecipeRepository();
        $stepRepository = new StepRepository();
        $ingredientRepository= new IngredientRepository(); 
        $categoryRepository = new CategoryRepository();
        $categories = $categoryRepository->findAll();
       
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
                    
                    return $this->renderView("../../templates/Recipes/template_part/add_form.phtml", [], [
                        "errors" => $errors,
                        "message" => $message,
                        'recipe' => $recipe,
                        'categories' => $categories
                    ]);
                }
            $title = strip_tags($_POST['title']);
            $description = strip_tags($_POST['description']);
            $duration = strip_tags($_POST['duration']);
            $file_path_img = Service::moveFile($_FILES['file_path_img']);
            $category_id = strip_tags($_POST['category_id']);
            $ingredients = Service::getElements($_POST, 'ingredient', 'update');
            
            $steps = Service::getElements($_POST, 'step', 'update');
            $date =new DateTimeImmutable();
            $recipe = new Recipe($title, $description, $duration, $file_path_img, $user_id,  $category_id,  $date->format('Y-m-d H:s:i'), $date->format('Y-m-d H:s:i'));
            // mise a jour de la recette
            
            $recipeRepository->update($id, $recipe);

            //mise a jour des ingredients associés a la recette
            foreach ($ingredients as $ing)
            {
              $ingredient = new Ingredient($ing['name_ingredient'], $ing['quantity_ingredient'], $ing['unity_ingredient'], $id);
              $ingredientRepository->update($ing['id_ingredient'], $ingredient);

            }
            //mise a jour des etapes associés a la recette            
            
            foreach ($steps as $stp)
            {
              $step = new Step($stp['order_step'],$stp['description_step'], $id);
              $stepRepository->update($stp['id_step'], $step);
            }

            //mise à jour de la categorie associé à la recette
           
            $successMsg = "Votre recette a été mise à jour";
        } 
        return $this->renderView('../../templates/Recipes/index.phtml', [], [
          'recipes' => $recipeRepository->findAll(),
          'successMsg' => $successMsg,
          'libelle' => $this->getCategory($_SESSION['category'])

        ]);

      }

  }

   /**
     * @return string|void
    */

  public function delete()
  {
    $recipe = [];
    $step = [];
    $ingredient = [];
    $stepRepository = new StepRepository();
    $ingredientRepository = new IngredientRepository();
    $recipeRepository = new RecipeRepository();
    $recipe = $recipeRepository->findBy(['id' => $_POST['recipe_id']])[0];
    if ((Service::ifUserIsConnected()
     && !empty($recipe) && $_SESSION['user_id'] === $recipe['user_id']) || $_SESSION['role'] === ROLE_ADMIN)
   
     {
        $attributs = ['recipe_id' => $_POST['recipe_id']];
        $steps = $stepRepository->delete( $attributs);
        $ingredients = $ingredientRepository->delete($attributs);
        $recipe = $recipeRepository->delete(['id' => $_POST['recipe_id']]);
        if (is_null($_SESSION['category'] )) 
        {
          $recipes = $recipeRepository->findAll();
        } else {
          $recipes = $recipeRepository->findBy(['category_id' => $_SESSION['category']]);
        
        }
        $successMsg = "Votre recette a été supprimé";
        return $this->renderView('../../templates/Recipes/index.phtml', [], [
          'recipes' => $recipes,
          'libelle' => $this->getCategory($_SESSION['category']),
           'successMsg' => $successMsg,
           
     ]);   

     }
     
    
  }

  private function getCategory(int $id = NULL): string
  {
    if (is_null($id)) {
      return 'recettes';
    } else { 
      $categoryRepository= new CategoryRepository();
      if (!empty($categoryRepository->find($id))) {
          $category = $categoryRepository->find($id)[0]['name'];        
          return $category; 
      } else {
          throw new Exception('Cette page n\'existe pas');
        }   
    }  
  }
}

?>