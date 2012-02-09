<?php 
require_once('../libraries/Database.php');

/**
 * This is the Photo Class
 * 
 */

class Photo {
	
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
		//echo '<pre>';
		//print_r($conditions);
		//echo '</pre>';
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
	 * A method for deleting a recipe image from database
	 * 
	 * @param int $recipe_id
	 * @param string $image_name
	 * @return bool Whether the delete process is successful or not
	 */
	public static function deleteRecipeImage($recipe_id, $image_name){
		$sql = 'DELETE FROM recipe_images WHERE recipe_id = ?, image_name = ?';
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
}
?>