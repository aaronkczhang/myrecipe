<?php
require_once 'Comments.php';

//get all comments belongs to a user
/*$data = array('user_id'=>'user01');
$comments = Comments::findComments($data);
echo '<pre>';
print_r($comments);
echo '</pre>';*/


//get all comments belongs to a recipe
/*$data = array('recipe_id'=>'3');
$comments = Comments::findComments($data);
echo '<pre>';
print_r($comments);
echo '</pre>';
*/

//create a comment on a recipe
$data = array('rating'=>'4', 'user_id'=>'user01', 'recipe_id'=>6, 'content'=>'GOOOOOOOOD!', 'add_time'=>'2011-09-03');
$result = Comments::createComment($data);
echo '<pre>';
print_r($result);
echo '</pre>';