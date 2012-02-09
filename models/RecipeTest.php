<?php
require_once 'Recipes.php';
//get all recipes all their cover image
/*$recipe = Recipe::findRecipe(array('recipe_images.is_cover'=>'yes'));
echo '<pre>';
print_r($recipe);
echo '</pre>';*/


echo "***********************";


//find recipes by menu
$data = array('category_id'=>1,'is_cover'=>'yes');
$recipes = Recipe::findRecipeByMenu($data);
echo '<pre>';
print_r($recipe);
echo '</pre>';


//find cooking steps of a recipe
$recipe_id = 5;
$steps = Recipe::findRecipeSteps($recipe_id);
echo '<pre>';
print_r($steps);
echo '</pre>';
