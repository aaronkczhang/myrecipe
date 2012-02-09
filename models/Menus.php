<?php
require_once('../libraries/Database.php');

/**
 * This is the Menu Class
 * 
 */

class Menu {
	
	
	/**
	 * A method for retrieving menu items from database
	 * 
	 * @param array $data An optional array of key:value pairs, this array only accept one item or empty.
	 * Suggested parameters: $data['menu_id'], or $data['menu_name']
	 * @return array An array of menu objects.
	 */
	public static function findMenu(array $data = array()) {
		$sql = 'SELECT * FROM menus';
		$conditions = array();
		if(count($data)){
			foreach($data as $key=>$value){
				$sql .= " WHERE {$key} = ?";
				$conditions[] = $value; 
			}			
		}
		
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
	 * A method for retrieving category items from database
	 * 
	 * @param array $data An optional array of key:value pairs, this array only accept one item or empty.
	 *        Suggested parameters: $data['category_id'], $data['category_name'], or $['menu_id']
	 * @return array An array of category objects.
	 */
	public static function findCategory(array $data = array()) {
		$sql = 'SELECT * FROM categories';
		$conditions = array();
		if(count($data)){
			foreach($data as $key=>$value){
				$sql .= " WHERE {$key} = ?";
				$conditions[] = $value; 
			}
		}
		
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