<?php 
require_once('../libraries/Database.php');

/**
 * This is the User Class
 * 
 */

class User {
	/**
	 * If validation fails, errors are written to this variable.
	 */
	
	private static $error=array(); 
	
	/**
	 * A method for validating data
	 * 
	 * @param $data An array of POSTed data
	 * @return bool Whether the data is valid or not
	 */
	public static function validates(array $data=array()){
		if(count($data)) {
			if (strlen($data['username'])>15||strlen($data['username'])<5 ){
				array_push(self::$error, "username must be 3-10 characters");
			}
			if (strlen($data['password'])>15||strlen($data['password'])<7 ){
				array_push(self::$error, "password must be 3-10 characters");
			}
		    if ($data['password']!=$data['cpassword']){
				array_push(self::$error, "passwords don't match");
			}
			if(!filter_var($data['email'],FILTER_VALIDATE_EMAIL)){
			//if (eregi("^[a-zA-Z0-9_] @[a-zA-Z0-9\-] \.[a-zA-Z0-9\-\.] $]", $data['email'])){
				array_push(self::$error, "email address is not valid");
			}
			//check whether email has correct host 
			/*
			list($Username, $Domain) = split("@",$data['email']);
			if(!getmxrr($Domain, $MXHost)) {
				if(!fsockopen($Domain, 25, $errno, $errstr, 30)) {
					array_push($error, "email address is not valid");
				}
			}
			*/

		}
		return self::$error;
	}
	
	
    /**
     * Returns any validation errors.
     *
     * @return array An array of errors, or an empty array.
     */
    public static function errors() {    	
    	return self::$errors;
  }
	
	/**
	 * A method for retrieving users from the users table.
	 * 
	 * @param array $data An optional array of key:value pairs to be used as parameters in the SQL query
	 * @return array An array of database objects where each object represents a user.
	 */
  	public static function findUser(array $data = array()) {
  		$sql = 'SELECT * FROM users';
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
  	 * A method for creating a new user, and insert the new user into User Table
  	 * 
  	 * @param array $data An array of key:value pairs to be used as parameter in SQL query
  	 * @return bool Whether the creation process is succefull or not
  	 */
  	public static function createUser(array $data){
  		//do data check before create new user in UsersController
  		
  		$sql = 'INSERT INTO users (username, password, email, user_type) VALUES (?,?,?,?)';
  		$conditions = array($data['username'], md5($data['password']) , $data['email'], $data['user_type']);
  		
  		try {
  			$database = Database::getInstance();
  			$statement = $database->pdo->prepare($sql);
  			$result = $statement->execute($conditions);
			if($result)
			{
				$id = $database->pdo->lastInsertId();
			}
			$database = null;
  		}catch(PDOException $e){
  			echo $e->getMessage();
  			exit;
  		}
  		//return $result;
		if($result)
		{
			return $id;
		}
		else
		{
			return false;
		}
  	}
	
	/**
	 * A method for updating a user's information, and change the corresponding row of User Table in databse
	 * 
	 * @param string $user_id The user id of the user to be updated
	 * @param array $data An array of key:value pairs to be used for updating paremeters
	 * @return bool Whether the updating process is successful or not 
	 */
  	
  	public static function updateUser($user_id, $data){
  		//do data check before update user information in UsersController
  		//assume promoting user's right(from normal user to staff) is impossible 
  		$sql = 'UPDATE users SET password = ?, email = ? WHERE user_id = ?';
  		$conditions  = array(md5($data['password']), $data['email'], $user_id);
  		
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
  	
  	function getResultArray($query,$stack) {
  		try{
  			$database = Database::getInstance();
  			$statement = $database->pdo->prepare($sql);
  			$statement->execute($stack);
  			$result = $statement->fetchAll(PDO::FETCH_OBJ);
  			$database = null; //if $database->pdo = null, than fails.
  			return  $result;
  		}catch(PDOException $e){
  			echo $e->getMessage();
  			exit;
  		}

	}
  	
  	
  	
  	
}

?>