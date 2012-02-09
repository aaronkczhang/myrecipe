<?php
require_once 'Favourites.php';
//find all favourite recipes belonging to a user
/*$data = array('favourites.user_id'=>'user03');
$favourites = Favourites::findFavourites($data);
echo '<pre>';
print_r($favourites);
echo '</pre>';*/

//delete a user's favourtie recipe
/*$result = Favourites::deleteFavourite('user01',1);
echo '<pre>';
print_r($result);
echo '</pre>';*/



//add a recipe to user's favourites
$data111= array('user_id'=>'user01','recipe_id'=>7,'add_time'=>'2011-09-01');
$result = Favourites::createFavourite($data111);
echo '<pre>';
print_r($result);
echo '</pre>';