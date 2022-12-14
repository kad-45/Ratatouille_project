<?php 
namespace App\Classes\Controllers;
use App\Classes\Controllers\AbstractController;
use App\Classes\Repositories\IngredientRepository;
use App\Classes\Repositories\RecipeRepository;
use App\Classes\Repositories\StepRepository;
use App\Classes\Entities\Step;

class StepController extends AbstractController {

    /**
     * @return string
     */

    public function index()
    {
        return $this->renderView('../../templates/Recipes/index.phtml', [], []);
    }

     /**
     * @return string|void
     */

    public function update()
    {
        $recipeRepository = new RecipeRepository();
        $ingredientRepository = new IngredientRepository();
        $stepRepository = new StepRepository();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' 
            && isset($_POST['order_step'], $_POST['description_step'], $_POST['id'])
        ) {

            $id = strip_tags($_POST['id']);
            $order_step = strip_tags($_POST['order_step']);
            $description_step = strip_tags($_POST['description_step']);
            $recipe_id = strip_tags($_POST['recipe_id']);

            $step = new Step($order_step, $description_step, $recipe_id);
            $stepRepository->update($id, $step);

            $recipe = $recipeRepository->find($recipe_id)[0];
            $recipe['ingredients'] = $ingredientRepository->findBy(['recipe_id' => $recipe_id]);
            $recipe['steps'] = $stepRepository->findBy(['recipe_id' => $recipe_id]);
            
            $msg = 'Votre étape a été modifier';
            
            return $this->renderView('../../templates/Recipes/show.phtml', [], [
            'recipe' => $recipe,
            'message' => $msg
            ]);            
        }
    }

    /**
     * @return string|void
     */

    public function delete()
    {
        $stepRepository = new StepRepository();
        $recipeRepository = new RecipeRepository();
        $ingredientRepository = new IngredientRepository();
        
        if (isset($_POST['id'], $_POST['recipe_id']) && !empty($_POST['id'])) {
        
            $recipe_id = strip_tags($_POST['recipe_id']);
            $attributs = ['id' => $_POST['id']];
            $stepRepository->delete($attributs);

            $recipe = $recipeRepository->find($recipe_id)[0];
            $recipe['ingredients'] = $ingredientRepository->findBy(['recipe_id' => $recipe_id]);
            $recipe['steps'] = $stepRepository->findBy(['recipe_id' => $recipe_id]);

            $msg = 'Votre étape a été supprimée';
            
            return $this->renderView('../../templates/Recipes/show.phtml', [], [
                'recipe' => $recipe,
                'message'=> $msg  
            ]);
            
        
        }
        
    }
}

?>