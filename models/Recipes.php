<?php 
require_once('../libraries/Database.php');

/**
 * This is Recipe Class
 * 
 */

class Recipe {
	
	/**
	 * If validation fails, errors are written into this variable
	 * @param array An array of key:value pairs for storing errors
	 */
	private static $error;
	
	/**
	 * A method for validating data
	 *
	 * @param array $data An array of POSTed data
	 * @return bool Whether the data is valid or not
	 */
	public static function validates(array $data=array()) {
		if (count($data)){
			if($data['recipe_name']==""){
				array_push(self::$error, "no input in recipe name");
			}
		if($data['steps']==""){
				array_push(self::$error, "no input in steps");
			}
		if($data['ingredients']==""){
				array_push(self::$error, "no input in ingredients");
			}
			/*
		if($data['preparation_time']==""){
				array_push(self::$error, "no input in preparation_time");
			}
			
		if($data['cooking_time']==""){
				array_push(self::$error, "no input in cooking_time");
			}
		if($data['dexcription']==""){
				array_push(self::$error, "no input in recipe name");
			}
			*/
			if( strlen($data['steps'])<20){
				array_push(self::$error, "steps must have 20 characters ");
			}
		    if( strlen($data['ingredients'])<10){
				array_push(self::$error, "steps must have 10 characters ");
			}
			
		}
		return self::$error;
		
		
		
	}
	

	
	
	 /**
     * Returns any validation errors.
     *
     * @return array An array of errors, or an empty array.
     */
	public static function errors() {
		return self::$error;
	}
	
	
	
	/**
	 * A method for retrieving recipes from database mainly through setting recipe_name
	 * Table images and Table recipes are joined together.
	 * 
	 * @param array $data An optional array of key:value pairs to be used as parameters in the SQL query.
	 *        In most situation, the $data['recipe_image.is_cover'] should be set to 'yes'. 
	 * @return An array of database objects where each object represents a recipe.
	 */
	public static function findRecipe(array $data = array()){
		$sql = "SELECT *
		        FROM recipes INNER JOIN recipe_images 
		        ON recipes.recipe_id = recipe_images.recipe_id";
		
		$conditions = array();
			
		if(count($data)) {
			$flag = 0;
			foreach ($data as $key=>$value){
				if((++$flag)==1) {
					if($key == 'recipes.recipe_name'){
						$sql .= " WHERE {$key} REGEXP ?";
						$conditions[] = $value;
					}else{
						$sql .= " WHERE {$key} = ?";
						$conditions[] = $value;
					}
				}else {
					if($key == 'recipes.recipe_name'){
						$sql .= " AND {$key} REGEXP ?";
						$conditions[] = $value;
					}else{
						$sql .= " AND {$key} = ?";
						$conditions[] = $value;
					}
				}
			}
		}
		
		try{
			$database = Database::getInstance();
			$statement = $database->pdo->prepare($sql);
			$statement->execute($conditions);
			// result is FALSE if no rows found
			$result = $statement->fetchAll(PDO::FETCH_OBJ);
			//echo '<pre>';
			//print_r($result);
			//echo '</pre>';
			$database = null;
		}catch(PDOException $e){
			echo $e->getMessage();
			exit;
		}
		
		if(count($result)>=1){
			return $result;
		}else{
			return null;
		}
		
	}
	
	
	
	/**
	 * A method for retrieving recipes from database by setting category or menu parameters;
	 * Table images, Table recipes and Table category_recipe_choice are joined together.
	 * 
	 * @param array $data An optional array of key:value pairs to be used as parameters in the SQL query
	 *        Either $data['category_recipe_choices.category_id'] or $data['category_recipe_choices.menu_id'] has to be setted. 
	 *        In most situation, the $data['recipe_image.is_cover'] should be set to 'yes'. 
	 *        Only $data['recipes.recipe_id'], $data['recipes.recipe_name'], $data['recipes.user_id'], 
	 *        $data['category_recipe_choices.category_id'], $data['category_recipe_choices.menu_id'] are suggested
	 * @return An array of database objects where each object represents a recipe.
	 */
	public static function findRecipeByMenu(array $data = array()){
		$sql = "SELECT * 
		        FROM recipes INNER JOIN recipe_images INNER JOIN category_recipe_choices
		        ON recipe_images.recipe_id = recipes.recipe_id 
		        AND recipes.recipe_id = category_recipe_choices.recipe_id
		        ";
		
		$conditions = array();
		if(count($data)) {
			$flag = 0;
			foreach ($data as $key=>$value){
				if((++$flag)==1) {
					if($key == 'recipes.recipe_name'){
						$sql .= " WHERE {$key} REGEXP ?";
						$conditions[] = $value;
					}else{
						$sql .= " WHERE {$key} = ?";
						$conditions[] = $value;
					}
				}else {
					if($key == 'recipes.recipe_name'){
						$sql .= " AND {$key} REGEXP ?";
						$conditions[] = $value;
					}else{
						$sql .= " AND {$key} = ?";
						$conditions[] = $value;
					}
				}
			}
		}
		
		try{
			$database = Database::getInstance();
			$statement = $database->pdo->prepare($sql);
			$statement->execute($conditions);
			// result is FALSE if no rows found
			$result = $statement->fetchAll(PDO::FETCH_OBJ);
			//echo '<pre>';
			//print_r($result);
			//echo '</pre>';
			$database = null;
		}catch(PDOException $e){
			echo $e->getMessage();
			exit;
		}
		
		if(count($result)>=1){
			return $result;
		}else{
			return null;
		}
	}
	
	
	/**
	 * A method for creating a new recipe, and insert data into Table recipes
	 * 
	 * @param array $data An array of key:value pairs to be used as parameter in SQL query
	 * @return bool Whether the creation process is succefull or not
	 */
	public static function createRecipe(array $data){
		//do data check before create new user in UsersController
		$sql = 'INSERT INTO recipes (recipe_name, preparation_time, cooking_time, number_of_servings, user_id) VALUES (?,?,?,?,?)';
		$conditions = array($data['recipe_name'], $data['preparation_time'], $data['cooking_time'], $data['number_of_servings'], $data['user_id']);
		
		try {
			$database = Database::getInstance();
  			$statement = $database->pdo->prepare($sql);
  			$result = $statement->execute($conditions);
  			
  			if($result){
  				$id = $database->pdo->lastInsertId();
  			}
  			$database = null;
		}catch(PDOException $e){
			echo $e->getMessage();
  			exit;
		}
		if($result){
			return $id;
		}else {
			return false;
		}
	}
	
	/**
	 * A method for updating recipe information in Table recipes
	 * 
	 * @param int $recipe_id id of the recipe to be updated
	 * @param array $data An array of key:value pairs to be used for updating paremeters
	 * @return bool Whether the updating process is successful or not 
	 */
	public static function updateRecipe($recipe_id, $data){
		$sql = 'UPDATE recipes SET recipe_name = ?, preparation_time = ?, cooking_time = ?, number_of_servings = ? 
		        WHERE recipe_id = ?';
		$conditions = array($data['recipe_name'], $data['preparation_time'], $data['cooking_time'], $data['number_of_servings'], $recipe_id);
		
		try{
			$database = Database::getInstance();
			$statement = $database->pdo->prepare($sql);
			$result = $statement->execute($conditions);
			$database = null;
		}catch(PDOException $e){
			echo $e->getMessage;
			exit;
		}
		return $result;
	}
	
	
	
	
	/**
	 * A method for retrieving all cooking steps of a recipe
	 * 
	 * @param int $recipe_id the Id of the recipe
	 * @return string All cooking steps
	 */
	public static function findRecipeSteps($recipe_id) {
		$sql = 'SELECT * FROM recipe_steps WHERE recipe_id = ?';
		$conditions = array($recipe_id);
		
		try{
  			$database = Database::getInstance();
  			$statement = $database->pdo->prepare($sql);
  			$statement->execute($conditions);
  			$result = $statement->fetchAll(PDO::FETCH_OBJ);
  			$database = null; //if $database->pdo = null, than fails.
  		}catch(PDOException $e){
  			echo $e->getMessage();
  			exit;
  		}
  		
  		if(count($result) >= 1){
  			//echo '<pre>';
			//print_r($result);
			//echo '</pre>';
  			return $result;
  		}else{
  			return null;
  		}
	}
	
	
	/**
	 * A method for creating cooking steps for a recipe
	 * 
	 * @param int $recipe_id
	 * @param string $steps
	 * @return bool
	 */
	public static function createRecipeSteps($recipe_id, $steps) {
		$sql = 'INSERT INTO recipe_steps(recipe_id, steps) VALUES(?,?)';
		$conditions = array($recipe_id, $steps);
		
		try {
			$database = Database::getInstance();
			$statement = $database->pdo->prepare($sql);
			$result = $statement->execute($conditions);
			$database = null;
		}catch(PDOException $e){
  			echo $e->getMessage();
  			exit;
		}
		return $result;
	}
	
	
	/**
	 * A method for updating cooking steps of a recipe
	 * 
	 * @param int $recipe_id
	 * @param string $steps
	 * @return bool
	 */
	public static function updateRecipeSteps($recipe_id, $steps) {
		$sql = 'UPDATE recipe_steps SET steps = ? WHERE recipe_id =?';
		$conditions = array($steps, $recipe_id);
		
		try {
			$database = Database::getInstance();
			$statement = $database->pdo->prepare($sql);
			$result = $statement->execute($conditions);
			$database = null;
		}catch(PDOException $e){
			echo $e->getMessage();
			exit;
		}
		return $result;
	}
	
	/**
	 * A method for deleting cooking steps belonging to a recipe
	 * 
	 * @param int $recipe_id
	 * @return bool
	 */
	public static function deleteRecipeSteps($recipe_id) {
		$sql = 'DELETE FROM recipe_steps WHERE recipe_id = ?';
		$conditions = array($recipe_id);
		
		try {
			$database = Database::getInstance();
			$statement = $database->pdo->prepare($sql);
			$result = $statement->execute($conditions);
			$database = null;
		}catch(PDOException $e){
			echo $e->getMessage();
			exit;
		}
		return $result;
	}
	
	
	
	/**
	 * A method for retrieving ingrediets of a recipe
	 * 
	 * @param int $recipe_id the Id of the recipe
	 * @return string All cooking ingredients
	 */
//	public static function findRecipeSteps($recipe_id) {
	public static function findRecipeIngredients($recipe_id) {
		$sql = 'SELECT * FROM recipe_ingredients WHERE recipe_id = ?';
		$conditions = array($recipe_id);
		
		try{
  			$database = Database::getInstance();
  			$statement = $database->pdo->prepare($sql);
  			$statement->execute($conditions);
  			$result = $statement->fetchAll(PDO::FETCH_OBJ);
  			$database = null; 
  		}catch(PDOException $e){
  			echo $e->getMessage();
  			exit;
  		}
  		
  		if(count($result) >= 1){
  			//echo '<pre>';
			//print_r($result);
			//echo '</pre>';
  			return $result;
  		}else{
  			return null;
  		}
	}
	
	
	/**
	 * A method for creating ingredients for a recipe
	 * 
	 * @param int $recipe_id
	 * @param string $ingredients
	 * @return bool
	 */
	public static function createRecipeIngredients($recipe_id, $ingredients) {
		$sql = 'INSERT INTO recipe_ingredients(recipe_id, ingredients) VALUES(?,?)';
		$conditions = array($recipe_id, $ingredients);
		
		try {
			$database = Database::getInstance();
			$statement = $database->pdo->prepare($sql);
			$result = $statement->execute($conditions);
			$database = null;
		}catch(PDOException $e){
  			echo $e->getMessage();
  			exit;
		}
		return $result;
	}
	
	
	/**
	 * A method for updating ingredients of a recipe
	 * 
	 * @param int $recipe_id
	 * @param string $ingredient
	 * @return bool
	 */
//	public static function updateRecipeSteps($recipe_id, $ingredients) {
	public static function updateRecipeIngredients($recipe_id, $ingredients) {
		$sql = 'UPDATE recipe_ingredients SET ingredients = ? WHERE recipe_id =?';
		$conditions = array($ingredients, $recipe_id);
		
		try {
			$database = Database::getInstance();
			$statement = $database->pdo->prepare($sql);
			$result = $statement->execute($conditions);
			$database = null;
		}catch(PDOException $e){
			echo $e->getMessage();
			exit;
		}
		return $result;
	}
	
	/**
	 * A method for deleting ingredients belonging to a recipe
	 * 
	 * @param int $recipe_id
	 * @return bool
	 */
//	public static function deleteRecipeSteps($recipe_id) {
	public static function deleteRecipeIngredients($recipe_id) {
		$sql = 'DELETE FROM recipe_ingredients WHERE recipe_id = ?';
		$conditions = array($recipe_id);
		
		try {
			$database = Database::getInstance();
			$statement = $database->pdo->prepare($sql);
			$result = $statement->execute($conditions);
			$database = null;
		}catch(PDOException $e){
			echo $e->getMessage();
			exit;
		}
		return $result;
	}
	
	
	
	
	
	/**
	 * A method for retrieving all images file names of a certain recipe
	 * 
	 * @param string $recipe_id Id to find images belonging to it
	 * @param string $is_cover An optional param
	 * @return array An array of database Objects, which contains (recipe_id, image_name, cover)
	 */
	public static function findRecipeImagesById($recipe_id, $is_cover = ''){
		$sql = 'SELECT * FROM recipe_images WHERE recipe_id = ?';
		$conditions = array();
		$conditions[] = $recipe_id;
		if($is_cover != ''){
			$sql .= " AND is_cover = ?";
			$conditions[] = $is_cover;
		}
		
		try{
			$database = Database::getInstance();
			$statement = $database->pdo->prepare($sql);
			$statement->execute($conditions);
			$result = $statement->fetchAll(PDO::FETCH_OBJ);
			$database = null;
		}catch(PDOException $e){
			echo $e->getMessage;
			exit;
		}
		return $result;
	}
	
	
	/**
	 * A method for storing new recipe image file information into database
	 * 
	 * @param array $data An array of key:value pairs.
	 *        Required parameters: $data['recipe_id'], $data['image_name'], $data['is_cover']
	 * @return bool Whether the creation process is successful or not
	 */
	public static function createRecipeImage(array $data){
		$sql = 'INSERT INTO recipe_images (recipe_id, image_name, is_cover) VALUES (?,?,?)';
		$conditions = array($data['recipe_id'], $data['image_name'], $data['is_cover']);
		
		try {
  			$database = Database::getInstance();
  			$statement = $database->pdo->prepare($sql);
  			$result = $statement->execute($conditions);
  			$database = null;
  		}catch(PDOException $e){
  			echo $e->getMessage();
  			exit;
  		}
  		return $result;
	}
	
	
	/**
	 * A method for update recipe image file information into database
	 * 
	 * @param array $data An array of key:value pairs.
	 *        Required parameters: $data['recipe_id'], $data['image_name'], $data['is_cover']
	 * @return bool Whether the creation process is successful or not
	 */
	public static function updateRecipeImage(array $data){
		$sql = 'UPDATE recipe_images SET is_cover = ? WHERE recipe_id = ? AND image_name = ?';
		$conditions = array($data['is_cover'], $data['recipe_id'], $data['image_name']);
		
		try {
  			$database = Database::getInstance();
  			$statement = $database->pdo->prepare($sql);
  			$result = $statement->execute($conditions);
  			$database = null;
  		}catch(PDOException $e){
  			echo $e->getMessage();
  			exit;
  		}
  		return $result;
	}
	
	
	/**
	 * A method for deleting a recipe image from database
	 * 
	 * @param int $recipe_id
	 * @param string $image_name
	 * @return bool Whether the delete process is successful or not
	 */
	public static function deleteRecipeImage($recipe_id, $image_name){
		$sql = 'DELETE FROM recipe_images WHERE recipe_id = ? AND image_name = ?';
		$conditions = array($recipe_id, $image_name);
		
		try {
  			$database = Database::getInstance();
  			$statement = $database->pdo->prepare($sql);
  			$result = $statement->execute($conditions);
  			$database = null;
  		}catch(PDOException $e){
  			echo $e->getMessage();
  			exit;
  		}
  		return $result;
	}
	
	
	
	public static function findChoice(array $data){
		
	}
	
	/**
	 * A method for creating new choice, maping a recipe to a certain menu and a category under that menu
	 * 
	 * @param array $data An array of key:value pair
	 *        Required parameters: $data['recipe_id'], $data['category_id'], $data['menu_id']
	 * @return bool(false), or int(true) last inserted id
	 */	
	public static function createChoice(array $data) {
		$sql = 'INSERT INTO category_recipe_choices (recipe_id, category_id, menu_id) VALUES(?,?,?)';
		$conditions = array($data['recipe_id'], $data['category_id'], $data['menu_id']);
		
		try {
			$database = Database::getInstance();
  			$statement = $database->pdo->prepare($sql);
  			$result = $statement->execute($conditions);
  			
  			if($result){
  				$id = $database->pdo->lastInsertId();
  			}
  			$database = null;
		}catch(PDOException $e){
			echo $e->getMessage();
  			exit;
		}
		if($result){
			return $id;
		}else {
			return false;
		}
	}
	
	
	/**
	 * A method for deleting catogory_recipe_choices units through setting recipe_id,
	 * All records about that recipe_id will be delted
	 * 
	 * @param int $recipe_id
	 * @return bool
	 */
	public static function deleteChoiceByRecipeId($recipe_id) {
		$sql = 'DELETE FROM category_recipe_choices WHERE recipe_id = ?';
		$conditions = array($recipe_id);
		
		try {
  			$database = Database::getInstance();
  			$statement = $database->pdo->prepare($sql);
  			$result = $statement->execute($conditions);
  			$database = null;
  		}catch(PDOException $e){
  			echo $e->getMessage();
  			exit;
  		}
  		return $result;
	}
	
	
}
?>