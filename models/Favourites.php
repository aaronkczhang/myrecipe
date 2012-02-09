<?php
require_once('../libraries/Database.php');

/**
 * This is the Favourites Class
 * 
 */

class Favourites {
	
	/**
	 * A method for retriving a user's favourites recipes
	 * Table favourites, Table recipe_images and Table recipes will be joined together
	 * @param $data An array contains parameters for sql query.
	 *        At least 2 parameters are required: $data['favourites.user_id'], and by Default $data['recipe_images.is_cover'] is set to 'yes'
	 * @return a object list array
	 */
	public static function findFavourites(array $data) {
		$sql = "SELECT * 
		        FROM favourites INNER JOIN recipes INNER JOIN recipe_images
		        ON recipe_images.recipe_id = recipes.recipe_id 
		        AND recipes.recipe_id = favourites.recipe_id
		        WHERE recipe_images.is_cover = 'yes' AND favourites.user_id = ? ";
		$conditions = array();
		$conditions[] = $data['favourites.user_id'];
//		echo '<pre>';
//		print_r($conditions);
//		echo '</pre>';
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
	 * A method for adding new favourite recipe to a user's favourite recipe list
	 * 
	 * @param array $data An array of key:value pairs 
	 *        
	 * @return bool
	 */
	public static function createFavourite(array $data) {
		$sql = 'INSERT INTO favourites (user_id, recipe_id, add_time) VALUES (?,?,?)';
		$conditions = array($data['user_id'], $data['recipe_id'], $data['add_time']);
		
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
	 * A method for deleting a favourite recipe from a user's favourite recipe list
	 * 
	 * @param int $recipe_id
	 * @return bool
	 */
	public static function deleteFavourite($user_id, $recipe_id) {
		$sql = 'DELETE FROM favourites WHERE user_id = ? AND recipe_id = ?';
		$conditions = array($user_id,$recipe_id);
		
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
	 * A method for retrieving first N popular recipes
	 * 
	 * @param int $limitedNumber Show first N popular recipes
	 * @return array An array of object of store first n popular recipes, (recipe_id, times being stored)
	 */
	public static function findPopularRecipes($limitedNumber){
		$sql = "SELECT recipe_id, count(recipe_id) FROM favourites
		        GROUP BY recipe_id
		        ORDER BY count(recipe_id) DESC
		        LIMIT 3 ";
		$conditions = array($limitedNumber);
		
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
}