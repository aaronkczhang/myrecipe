<?php
session_start();

require_once(LIBRARY_PATH . DS . 'Template.php');
require_once(APP_PATH . DS . 'models/User.php');
require_once(APP_PATH . DS . 'models/Favourites.php');
require_once(APP_PATH . DS . 'models/Comments.php');
require_once(APP_PATH . DS . 'models/Recipes.php');

class UsersController
{
	public function __construct()
	{
		$this->template = new Template;
		$this->template->template_dir = APP_PATH . DS . 'views' . DS . 'users' . DS;
		
		$this->template->title = 'Users';
	}
	
	public function overview()
	{
		$users = User::findUser();
		// pick 5 newest users
		$max_id = count($users)-1;
		$newestUsers = array();
		for ($i=0; $i<5; $i++)
		{
			$newestUsers[$i] = $users[$max_id-$i];
		}
		$this->template->newestUsers = $newestUsers;
		$this->template->display('overview.html.php');
	}
	
	public function registry()
	{
		$this->template->display('registry.html.php');
	}
	
	public function create()
	{
		// must have some POSTed data
		if (!isset($_POST) || empty($_POST))
		{
			header("Location: /myrecipe/users/registry");
			exit;
		}
		// TODO need to validate data
		$data = array('username' => $_POST['username'], 'password' => $_POST['password'], 'cpassword' => $_POST['cpassword'], 'email' => $_POST['email']);
		// validate the input data
		$errorArray = User::validates($data);
		if (count($errorArray))
		{
			// store errors in session and redirect
			$_SESSION['user'] = $data;
			$_SESSION['user']['errors'] = $errorArray;
			header("Location: /myrecipe/users/registry");
			exit;
		}
		// create a new user, assume all new users are not staff
		$values = array('username'=>$_POST['username'],'password'=>$_POST['password'],'email'=>$_POST['email'],'user_type'=>'1');
		$id = User::createUser($values);
		// log the user in
		$_SESSION['user']['id'] = $id;
		$_SESSION['user']['name'] = $_POST['username'];
		$_SESSION['user']['type'] = '1';
		echo "id = " . $id;
		header("Location: /myrecipe/users/" . $id);
		exit;
	}
	
	public function profile($id)
	{	
		// must be logged in to access this page
		if (!isset($_SESSION['user']))
		{
			header("Location: /myrecipe/session/new");
			exit;
		}
		// this page is only accessable by self and admin (type 2)
		if (($_SESSION['user']['type'] != 2) && ($_SESSION['user']['id'] != $id))
		{
			header("Location: /myrecipe/users/{$_SESSION['user']['id']}");
			exit;
		}
	
		//get the user with id
		$user = User::findUser(array('user_id' => $id));
		$this->template->user = $user[0];
		
		$recipesArray = array();
		$commentsArray = array();
		$favouritesArray = array();
		
		$myrecipes = Recipe::findRecipe(array('recipes.user_id'=>$id, 'recipe_images.is_cover'=>'yes'));
		if (count($myrecipes)!=0)
		{
			$max_recipe = min(3, count($myrecipes)) - 1;
			for ($i=0; $i<min(3, count($myrecipes)); $i++)
			{
				$recipesArray[$i] = $myrecipes[$max_recipe-$i];
			}
		}
		$this->template->myrecipes = $recipesArray;
		
		$mycomments = Comments::findComments(array('user_id'=>$id));
		if (count($mycomments)!=0)
		{
			$max_comment = min(3, count($mycomments)) - 1;
			for ($i=0; $i<min(3, count($mycomments)); $i++)
			{
				$commentsArray[$i] = $mycomments[$max_comment-$i];
			}
		}
		$this->template->mycomments = $commentsArray;
		
		$myfavourites = Favourites::findFavourites(array('favourites.user_id'=>$id, 'recipe_images.is_cover'=>'yes'));
		if (count($myfavourites)!=0)
		{
			$max_favourite = min(3, count($myfavourites)) - 1;
			for ($i=0; $i<min(3, count($myfavourites)); $i++)
			{
				$favouritesArray[$i] = $myfavourites[$max_favourite-$i];
			}
		}
		$this->template->myfavourites = $favouritesArray;
		
		$recipes = Recipe::findRecipe(array('recipe_images.is_cover'=>'yes'));
		$this->template->recipes = $recipes;
		
		$this->template->display('profile.html.php');
	}
	
	public function edit($id)
	{
		// must be logged in to access this page
		if (!isset($_SESSION['user']))
		{
			header("Location: /myrecipe/session/new");
			exit;
		}
		// this page is only accessable by self
		if ($_SESSION['user']['id'] != $id)
		{
			header("Location: /myrecipe/users/{$_SESSION['user']['id']}");
			exit;
		}
	
		if(!$user = User::findUser(array('user_id' => $id)))
		{
			// something has gone wrong with db request
			header("Location: /myrecipe/users/".$id);
			exit;
		}
		$this->template->user = $user[0];
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
		// this page is only accessable by self
		if ($_SESSION['user']['id'] != $id)
		{
			header("Location: /myrecipe/users/{$_SESSION['user']['id']}");
			exit;
		}
	
		// must have some POSTed data
		if (!isset($_POST) || empty($_POST))
		{
			header("Location: /myrecipe/users/{$id}/edit");
			exit;
		}
		
		// TODO need to validate data
		$data = array('username' => 'testusername', 'password' => $_POST['password'], 'cpassword' => $_POST['cpassword'], 'email' => $_POST['email']);
		$errorArray = User::validates($data);
		if (count($errorArray))
		{
			// store errors in session and redirect
			$_SESSION['user']['errors'] = $errorArray;
			header("Location: /myrecipe/users/{$id}/edit");
			exit;
		}
		//update user
		$values = array('password'=>$_POST['password'], 'email'=>$_POST['email']);
		User::updateUser($id, $values);
		header("Location: /myrecipe/users/{$id}");
	}
	
	public function recipes($id)
	{
		// must be logged in to access this page
		if (!isset($_SESSION['user']))
		{
			header("Location: /myrecipe/session/new");
			exit;
		}
		// this page is only accessable by self and admin (type 2)
		if (($_SESSION['user']['type'] != 2) && ($_SESSION['user']['id'] != $id))
		{
			header("Location: /myrecipe/users/{$_SESSION['user']['id']}");
			exit;
		}
	
		if(!$user = User::findUser(array('user_id' => $id)))
		{
			// something has gone wrong with db request
			header("Location: /myrecipe/users/".$id);
			exit;
		}
		$this->template->user = $user[0];
		
		// get all the recipes uploaded by the user
		$myrecipes = Recipe::findRecipe(array('recipes.user_id'=>$id, 'recipe_images.is_cover'=>'yes'));
		$this->template->myrecipes = $myrecipes;
/*		echo "<pre>";
		print_r($myrecipes);
		echo "</pre>";
*/	
		$this->template->display('recipes.html.php');
	}
	
	public function favourites($id)
	{
		// must be logged in to access this page
		if (!isset($_SESSION['user']))
		{
			header("Location: /myrecipe/session/new");
			exit;
		}
		// this page is only accessable by self and admin (type 2)
		if (($_SESSION['user']['type'] != 2) && ($_SESSION['user']['id'] != $id))
		{
			header("Location: /myrecipe/users/{$_SESSION['user']['id']}");
			exit;
		}
	
		if(!$user = User::findUser(array('user_id' => $id)))
		{
			// something has gone wrong with db request
			header("Location: /myrecipe/users/".$id);
			exit;
		}
		$this->template->user = $user[0];
		
		// find all the favourites
		$data = array('favourites.user_id'=>$id, 'recipe_images.is_cover'=>'yes');
		$favourites = Favourites::findFavourites($data);
		$this->template->favourites = $favourites;
/*		echo "<pre>";
		print_r($favourites);
		echo "</pre>";
*/
		$this->template->display('favourites.html.php');
	}
	
	public function reviews($id)
	{
		// must be logged in to access this page
		if (!isset($_SESSION['user']))
		{
			header("Location: /myrecipe/session/new");
			exit;
		}
		// this page is only accessable by self and admin (type 2)
		if (($_SESSION['user']['type'] != 2) && ($_SESSION['user']['id'] != $id))
		{
			header("Location: /myrecipe/users/{$_SESSION['user']['id']}");
			exit;
		}
	
		if(!$user = User::findUser(array('user_id' => $id)))
		{
			// something has gone wrong with db request
			header("Location: /myrecipe/users/".$id);
			exit;
		}
		$this->template->user = $user[0];
		
		$mycomments = Comments::findComments(array('user_id'=>$id));
		$this->template->mycomments = $mycomments;
/*		echo "<pre>";
		print_r($mycomments);
		echo "</pre>";
*/
		$recipes = Recipe::findRecipe(array('recipe_images.is_cover'=>'yes'));
		$this->template->recipes = $recipes;

		$this->template->display('reviews.html.php');
	}
}