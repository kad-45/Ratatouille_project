<?php
namespace App\Classes\Controllers;


use App\Classes\Controllers\AbstractController;
use App\Classes\Entities\Ingredient;
use App\Classes\Repositories\IngredientRepository;
use App\Classes\Repositories\StepRepository;
use App\Classes\Repositories\RecipeRepository;

class IngredientController extends AbstractController {

/**
 * @return string
 */
    
    public function index()
    {
        return $this->renderView('../../templates/Recipes/index.phtml', [], []);
    }

    /**
     * @return string|void
     * @Router ingredient/update.
     */

    public function update()
    {
        $recipeRepository = new RecipeRepository();
        $ingredientRepository = new IngredientRepository();
        $stepRepository = new StepRepository();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' 
        && isset($_POST['name_ingredient'], $_POST['quantity_ingredient'], $_POST['unity_ingredient'], $_POST['id'])

        ) {
            $id = strip_tags($_POST['id']);
            $name_ingredient = strip_tags($_POST['name_ingredient']);
            $quantity_ingredient = strip_tags($_POST['quantity_ingredient']);
            $unity_ingredient = strip_tags($_POST['unity_ingredient']); 
            $recipe_id = strip_tags($_POST['recipe_id']);        
            
            $ingredient = new Ingredient($name_ingredient, $quantity_ingredient, $unity_ingredient, $recipe_id);  
            $ingredientRepository->update($id, $ingredient);
            
            $recipe = $recipeRepository->find($recipe_id)[0];
            $recipe['ingredients'] = $ingredientRepository->findBy(['recipe_id' => $recipe_id]);
            $recipe['steps'] = $stepRepository->findBy(['recipe_id' => $recipe_id]);
    
            $msg = 'Votre ingrédient a été modifié';
            //Mise à jour des ingrédients associés à la recette.
            
            return $this->renderView('../../templates/Recipes/show.phtml', [], [
                'recipe' => $recipe,
                'message' => $msg   
            ]);
            
         }
                    
    }

    /**
     * @return string|void
     * @Router ingredient/delete
     */
    
    public function delete()
    {
        $recipeRepository = new RecipeRepository();
        $stepRepository = new StepRepository();
        $ingredientRepository = new IngredientRepository();
        
        if (isset($_POST['id'], $_POST['recipe_id']) && !empty($_POST['id'])) {

            $recipe_id = strip_tags($_POST['recipe_id']); 
            
            $attributs = ['id' => $_POST['id']];
            $ingredientRepository->delete($attributs);

            $recipe = $recipeRepository->find($recipe_id)[0];
            $recipe['ingredients'] = $ingredientRepository->findBy(['recipe_id' => $recipe_id]);
            $recipe['steps'] = $stepRepository->findBy(['recipe_id' => $recipe_id]);            
            
            $msg = 'Votre ingrédient a été supprimé';

             return $this->renderView('../../templates/Recipes/show.phtml', [], [
            'recipe' => $recipe,
            'message' => $msg
        ]);

        }
      
    }
        
}

?>