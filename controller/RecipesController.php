<?php
session_start();

require_once(LIBRARY_PATH . DS . 'Template.php');
require_once(APP_PATH . DS . 'models/Recipes.php');
require_once(APP_PATH . DS . 'models/Favourites.php');
require_once(APP_PATH . DS . 'models/Menus.php');
require_once(APP_PATH . DS . 'models/Comments.php');
require_once(APP_PATH . DS . 'models/User.php');

class RecipesController
{
	public function __construct()
	{
		$this->template = new Template;
		$this->template->template_dir = APP_PATH . DS . 'views' . DS . 'recipes' . DS;
		
		$this->template->title = 'Recipes';
	}
	
	public function overview()
	{
		$menus = Menu::findMenu();
		$this->template->menus = $menus;
		
		$categories = Menu::findCategory();
		$this->template->categories = $categories;
	
		// get all the recipes with cover image
		$recipes = Recipe::findRecipe(array('recipe_images.is_cover'=>'yes'));
		
		// add the 3 newest recipes into $newestRecipes array
		$max_id = count($recipes)-1;
		$newestRecipes = array();
		for ($i=0; $i<3; $i++)
		{
			$newestRecipes[$i] = $recipes[$max_id-$i];
		}
		$this->template->newestRecipes = $newestRecipes;
		
		// add the 3 most favourited recipes into $hottest array
		$mostfavourite = Favourites::findPopularRecipes(3);
		$hottestRecipes = array();
		for ($i=0; $i<3; $i++)
		{
			$recipeid = $mostfavourite[$i]->recipe_id;
			$currentRecipe = Recipe::findRecipe(array('recipes.recipe_id'=>$recipeid, 'recipe_images.is_cover'=>'yes'));
			$hottestRecipes[$i] = $currentRecipe[0];
		}
		$this->template->hottestRecipes = $hottestRecipes;

		$this->template->display('overview.html.php');
	}
	
	public function all()
	{
		// get all the recipes with cover image
		$recipes = Recipe::findRecipe(array('recipe_images.is_cover'=>'yes'));	
		
		$this->template->recipes = $recipes;
		$this->template->display('list.html.php');
	}
	
	public function detail($id)
	{
		$recipes = Recipe::findRecipe(array('recipes.recipe_id'=>$id, 'recipe_images.is_cover'=>'yes'));
		$this->template->recipes = $recipes[0];
		
		$ingredients = Recipe::findRecipeIngredients($id);
		$this->template->ingredients = $ingredients[0];
		
		$steps = Recipe::findRecipeSteps($id);
		$this->template->steps = $steps[0];

		$categories = Recipe::findRecipeByMenu(array('category_recipe_choices.recipe_id'=>$id, 'recipe_images.is_cover'=>'yes'));
		$categorys = array();
		for ($i=0; $i<count($categories); $i++)
		{
			$categoryid = $categories[$i]->category_id;
			$temparray = Menu::findCategory(array('category_id'=>$categoryid));
			$categorys[$i] = $temparray[0];
		}
		$this->template->categorys = $categorys;
		
		// is the recipe already faved by session user
		$isFaved = false;
		if (isset($_SESSION['user']))
		{
			$favourites = Favourites::findFavourites(array('favourites.user_id'=>$_SESSION['user']['id']));
			if (count($favourites)!=0)
			{
				foreach ($favourites as $favourite)
				{
					if ($favourite->recipe_id == $id)
					{
						$isFaved = true;
					}
				}
			}
		}
		$this->template->isFaved = $isFaved;
		
		// calculate the rating
		$comments = Comments::findComments(array('recipe_id'=>$id));
		$sum = 0;
		$rating = 0;
		if (count($comments)!=0)
		{
			foreach ($comments as $comment)
			{
				$sum += $comment->rating;
			}
			$rating = round(($sum/count($comments)), 1);
		}
		$this->template->rating = $rating;
		// show comments
		$this->template->comments = $comments;
		
		// is the recipe commented by session user
		$isCommented = false;
		if (isset($_SESSION['user']))
		{
			if (count($comments)!=0)
			{
				foreach ($comments as $comment)
				{
					if ($comment->user_id == $_SESSION['user']['id'])
					{
						$isCommented = true;
					}
				}
			}
		}
		$this->template->isCommented = $isCommented;
		
		// get user info
		$users = User::findUser();
		$this->template->users = $users;
		
		$this->template->display('detail.html.php');
	}
	
	public function newrecipe()
	{
		// must be logged in to access this page
		if (!isset($_SESSION['user']))
		{
			header("Location: /myrecipe/session/new");
			exit;
		}
		
		$menus = Menu::findMenu();
		$this->template->menus = $menus;
		
		$categories = Menu::findCategory();
		$this->template->categories = $categories;
	
		$this->template->display('new.html.php');
	}
	
	public function create()
	{
		// must be logged in to access this page
		if (!isset($_SESSION['user']))
		{
			header("Location: /myrecipe/session/new");
			exit;
		}
	
		// must have some POSTed data
		if (!isset($_POST) || empty($_POST))
		{
			header("Location: /myrecipe/recipes/newrecipe");
			exit;
		}
		
		// TODO need to validate data
		$data = array('user_id'=>$_SESSION['user']['id'],'recipe_name'=>$_POST['name'], 'preparation_time'=>$_POST['ptime'], 'cooking_time'=>$_POST['ctime'], 'number_of_servings'=>$_POST['num'], 'ingredients'=>$_POST['ingredients'], 'steps'=>$_POST['steps']);
		$errorArray = Recipe::validates($data);
		if (count($errorArray))
		{
			// store errors in session and redirect
			$_SESSION['recipe'] = $data;
			$_SESSION['recipe']['errors'] = $errorArray;
			header("Location: /myrecipe/recipes/newrecipe");
			exit;
		}
		
		// create a new recipe
		$value = array('recipe_name'=>$_POST['name'], 'preparation_time'=>$_POST['ptime'], 'cooking_time'=>$_POST['ctime'], 'number_of_servings'=>$_POST['num'], 'user_id'=>$_SESSION['user']['id']);
		$recipe_id = Recipe::createRecipe($value);
		Recipe::createRecipeSteps($recipe_id, $_POST['steps']);
		Recipe::createRecipeIngredients($recipe_id, $_POST['ingredients']);
		Recipe::createRecipeImage(array('recipe_id'=>$recipe_id, 'image_name'=>'default.jpg', 'is_cover'=>'yes'));

		// create related choices
		if ($_POST['s1'] != '[null]')
		{
			Recipe::createChoice(array('recipe_id'=>$recipe_id, 'category_id'=>$_POST['s1'], 'menu_id'=>1));
		}
		if ($_POST['s2'] != '[null]')
		{
			Recipe::createChoice(array('recipe_id'=>$recipe_id, 'category_id'=>$_POST['s2'], 'menu_id'=>2));
		}
		if ($_POST['s3'] != '[null]')
		{
			Recipe::createChoice(array('recipe_id'=>$recipe_id, 'category_id'=>$_POST['s3'], 'menu_id'=>3));
		}
		if ($_POST['s4'] != '[null]')
		{
			Recipe::createChoice(array('recipe_id'=>$recipe_id, 'category_id'=>$_POST['s4'], 'menu_id'=>4));
		}
		
		header("Location: /myrecipe/recipes/" . $recipe_id);
		exit;
	}
	
	public function edit($id)
	{
		// must be logged in to access this page
		if (!isset($_SESSION['user']))
		{
			header("Location: /myrecipe/session/new");
			exit;
		}

		$menus = Menu::findMenu();
		$this->template->menus = $menus;
		
		$categories = Menu::findCategory();
		$this->template->categories = $categories;
		
		$this->template->display('edit.html.php');
	}
	
	public function update($id)
	{
		// must be logged in to access this page
		if (!isset($_SESSION['user']))
		{
			header("Location: /myrecipe/session/new");
			exit;
		}
	
		// must have some POSTed data
		if (!isset($_POST) || empty($_POST))
		{
			header("Location: /myrecipe/recipes/" . $id);
			exit;
		}
		
		// TODO need to validate data
		$data = array('user_id'=>$_SESSION['user']['id'],'recipe_name'=>$_POST['name'], 'preparation_time'=>$_POST['ptime'], 'cooking_time'=>$_POST['ctime'], 'number_of_servings'=>$_POST['num'], 'ingredients'=>$_POST['ingredients'], 'steps'=>$_POST['steps']);
		$errorArray = Recipe::validates($data);
		if (count($errorArray))
		{
			// store errors in session and redirect
			$_SESSION['recipe'] = $data;
			$_SESSION['recipe']['errors'] = $errorArray;
			header("Location: /myrecipe/recipes/" . $id . "/edit");
			exit;
		}
		
		// update the recipe
		$value = array('recipe_name'=>$_POST['name'], 'preparation_time'=>$_POST['ptime'], 'cooking_time'=>$_POST['ctime'], 'number_of_servings'=>$_POST['num']);
		Recipe::updateRecipe($id, $value);
		Recipe::updateRecipeSteps($id, $_POST['steps']);
		Recipe::updateRecipeIngredients($id, $_POST['ingredients']);
		
		// update related choices
		Recipe::deleteChoiceByRecipeId($id);
		if ($_POST['s1'] != '[null]')
		{
			Recipe::createChoice(array('recipe_id'=>$id, 'category_id'=>$_POST['s1'], 'menu_id'=>1));
		}
		if ($_POST['s2'] != '[null]')
		{
			Recipe::createChoice(array('recipe_id'=>$id, 'category_id'=>$_POST['s2'], 'menu_id'=>2));
		}
		if ($_POST['s3'] != '[null]')
		{
			Recipe::createChoice(array('recipe_id'=>$id, 'category_id'=>$_POST['s3'], 'menu_id'=>3));
		}
		if ($_POST['s4'] != '[null]')
		{
			Recipe::createChoice(array('recipe_id'=>$id, 'category_id'=>$_POST['s4'], 'menu_id'=>4));
		}
		
		header("Location: /myrecipe/recipes/" . $id);
		exit;
	}
	
	public function category($id)
	{
		$recipes = Recipe::findRecipeByMenu(array('category_recipe_choices.category_id' => $id, 'recipe_images.is_cover' => 'yes'));
		$this->template->recipes = $recipes;
		$this->template->display('list.html.php');
	}
	
	public function addFavourite($id)
	{
		// must be logged in to access this page
		if (!isset($_SESSION['user']))
		{
			header("Location: /myrecipe/session/new");
			exit;
		}
		
		if (isset($_SESSION['user']))
		{
			Favourites::createFavourite(array('user_id'=>$_SESSION['user']['id'], 'recipe_id'=>$id, 'add_time'=>date("Y-m-d")));
		}
		header("Location: /myrecipe/recipes/{$id}");
	}
	
	public function deleteFavourite($id)
	{
		// must be logged in to access this page
		if (!isset($_SESSION['user']))
		{
			header("Location: /myrecipe/session/new");
			exit;
		}
		
		if (isset($_SESSION['user']))
		{
			Favourites::deleteFavourite($_SESSION['user']['id'], $id);
		}
		header("Location: /myrecipe/recipes/{$id}");
	}
	
	public function createComment()
	{
		// must be logged in to access this page
		if (!isset($_SESSION['user']))
		{
			header("Location: /myrecipe/session/new");
			exit;
		}
		
		echo "create comment";
		// must be logged in to access this page
		if (!isset($_SESSION['user']))
		{
			header("Location: /myrecipe/session/new");
			exit;
		}
	
		// must have some POSTed data
		if (!isset($_POST) || empty($_POST))
		{
			header("Location: /myrecipe/recipes");
			exit;
		}
		
		// create a new comment
		if (isset($_SESSION['user']))
		{
			Comments::createComment(array('rating'=>$_POST['rate'], 'user_id'=>$_SESSION['user']['id'], 'recipe_id'=>$_POST['recipe_id'], 'content'=>$_POST['content'], 'add_time'=>date("Y-m-d")));
		}
		header("Location: /myrecipe/recipes/{$_POST['recipe_id']}");
	}
	
	public function search()
	{
		// must have some POSTed data
		if (!isset($_POST) || empty($_POST))
		{
			header("Location: /myrecipe/recipes");
			exit;
		}
		
		if (isset($_POST['textfield']))
		{
			$recipes = Recipe::findRecipe(array('recipes.recipe_name'=>$_POST['textfield'], 'recipe_images.is_cover'=>'yes'));
		}
		
		$this->template->recipes = $recipes;
		$this->template->display('list.html.php');
	}
	
	public function view($id)
	{
		$images = Recipe::findRecipeImagesById($id);
		$this->template->images = $images;
		
		$recipes = Recipe::findRecipe(array('recipes.recipe_id'=>$id, 'recipe_images.is_cover'=>'yes'));
		if (count($recipes)==1)
		{
			$this->template->recipe = $recipes[0];
		}
		
		$this->template->display('view.html.php');
	}
	
	public function setcover($id)
	{
		// must be logged in to access this page
		if (!isset($_SESSION['user']))
		{
			header("Location: /myrecipe/session/new");
			exit;
		}
		
		$query = explode('/', $_GET['url']);
		$image_name = $query[2];
		
		$images = Recipe::findRecipeImagesById($id);
		if (count($images)!=0)
		{
			foreach ($images as $image)
			{
				$r_id = $image->recipe_id;
				$i_name = $image->image_name;
				Recipe::updateRecipeImage(array('is_cover'=>'no', 'recipe_id'=>$r_id, 'image_name'=>$i_name));
			}
		}
		Recipe::updateRecipeImage(array('is_cover'=>'yes', 'recipe_id'=>$id, 'image_name'=>$image_name));
		// delete the default.jpg
		Recipe::deleteRecipeImage($id, 'default.jpg');
		
		header("Location: /myrecipe/recipes/" . $id . "/view");
	}
}