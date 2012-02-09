<?php
session_start();

require_once(LIBRARY_PATH . DS . 'Template.php');
require_once(APP_PATH . DS . 'models/Recipes.php');
require_once(APP_PATH . DS . 'models/Photos.php');
require_once(APP_PATH . DS . 'models/File.php');

class PhotosController
{
	public function __construct()
	{
		$this->template = new Template;
		$this->template->template_dir = APP_PATH . DS . 'views' . DS . 'photos' . DS;
		
		$this->template->title = 'Recipes';
	}
	
	public function addpic($id)
	{
		// must be logged in to access this page
		if (!isset($_SESSION['user']))
		{
			header("Location: /myrecipe/session/new");
			exit;
		}
		
		$recipes = Recipe::findRecipe(array('recipes.recipe_id'=>$id, 'recipe_images.is_cover'=>'yes'));
		$this->template->recipe_name = $recipes[0]->recipe_name;
		$this->template->recipe_id = $id;
		$this->template->display('new.html.php');
	}
	
	public function uploadpic($id)
	{
		// must be logged in to access this page
		if (!isset($_SESSION['user']))
		{
			header("Location: /myrecipe/session/new");
			exit;
		}
		
		// TODO need to validate data
		// largest 640k
		if (File::validateFile($_FILES['myfile'], $id, 655360, "../webroot/upload/"))
		{
			unset($_SESSION['pic']['err']);
			$picname = File::uploadFile($_FILES['myfile'], $id, "../webroot/upload/");
			$createRecipeImage = Photo::createRecipeImage(array('recipe_id'=>$id, 'image_name'=>$picname, 'is_cover'=>'no'));
			header("Location: /myrecipe/recipes/" . $id);
		}
		else
		{
			$_SESSION['pic']['err'] = "Selected file is not valid!";
			header("Location: /myrecipe/recipes/" . $id . "/addpic");
		}
	}
}