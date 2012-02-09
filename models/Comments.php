<?php
require_once('../libraries/Database.php');

/**
 * This is the User Class
 * 
 */

class Comments {
	
	
	/**
	 * A method for retriving comments
	 * 
	 * @param array $data An array of key:value pairs.
	 *        Suggested param $data['user_id'], $data['recipe_id']
	 */
	public static function findComments(array $data) {
		$sql = 'SELECT * FROM comments';
  		$conditions = array();
  		//print_r($data);
  		if(count($data)) {
  			$flag = 0;
  			foreach($data as $key=>$value) {
  				if((++$flag) == 1){
  					$sql .= " WHERE {$key} = ?";
  					$conditions[] = $value;
  				}else{
  					$sql .= " AND {$key} = ?";
  					$conditions[] = $value;
  				}
  			}
  		}
  		//print_r($conditions);
  		//print_r($sql);
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
	 * A method for adding new comment
	 * 
	 * @param array $data An array of key:value pairs
	 * @return int last inserted id, or false
	 */
	public static function createComment(array $data) {
		
		$sql = 'INSERT INTO comments (rating, user_id, recipe_id, content, add_time) VALUES (?,?,?,?,?)';
  		$conditions = array($data['rating'], $data['user_id'], $data['recipe_id'], $data['content'], $data['add_time']);
  		
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
	
	
	public static function deleteComment(){
		
	}
	
	
	
}