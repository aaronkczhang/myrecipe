<?php
require_once 'User.php';

//find all users from database
$users2 = User::findUser();
echo '<pre>';
print_r($users2);
echo '</pre>';

echo "***********************";
//find user by id and type
$values = array('user_type'=>'2','user_id'=>'staff09');
$users = User::findUser($values);
echo '<pre>';
print_r($users);
echo '</pre>';

echo "***********************";
//create user
/*$values = array('user_id'=>'user07','password'=>'user07','email'=>'user07@food.com','user_type'=>'1');
$result = User::createUser($values);
print_r($result);
*/

//update users
$values = array('password'=>'user007', 'email'=>'user07@myfood.com');
$result = User::updateUser('user07', $values);
print_r($result);