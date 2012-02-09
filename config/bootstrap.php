<?php

define('LIBRARY_PATH', APP_PATH . DS . 'libraries');

// 1. sanitise (remove magic quotes, slashes, global vars)
// 2. do the routing - convert path into controller and action
// 3. autoload objects
// 4. error level/reporting

// include routes
$routes = array();
$routes['#^/$#i'] = array('controller' => 'home', 'action' => 'index');
$routes['#^/home$#i'] = array('controller' => 'home', 'action' => 'index');
$routes['#^/home/index$#i'] = array('controller' => 'home', 'action' => 'index');

$routes['#^/users$#i'] = array('controller' => 'users', 'action' => 'overview');
$routes['#^/users/registry$#i'] = array('controller' => 'users', 'action' => 'registry');
$routes['#^/users/create$#i'] = array('controller' => 'users', 'action' => 'create');
$routes['#^/users/([0-9]{1,5})$#i'] = array('controller' => 'users', 'action' => 'profile');
$routes['#^/users/([0-9]{1,5})/edit$#i'] = array('controller' => 'users', 'action' => 'edit');
$routes['#^/users/([0-9]{1,5})/update$#i'] = array('controller' => 'users', 'action' => 'update');
$routes['#^/users/([0-9]{1,5})/recipes$#i'] = array('controller' => 'users', 'action' => 'recipes');
$routes['#^/users/([0-9]{1,5})/favourites$#i'] = array('controller' => 'users', 'action' => 'favourites');
$routes['#^/users/([0-9]{1,5})/reviews$#i'] = array('controller' => 'users', 'action' => 'reviews');

$routes['#^/recipes$#i'] = array('controller' => 'recipes', 'action' => 'overview');
$routes['#^/recipes/all$#i'] = array('controller' => 'recipes', 'action' => 'all');
$routes['#^/recipes/([0-9]{1,5})$#i'] = array('controller' => 'recipes', 'action' => 'detail');
$routes['#^/recipes/([0-9]{1,5})/view$#i'] = array('controller' => 'recipes', 'action' => 'view');
$routes['#^/recipes/([0-9]{1,5})/([A-Za-z0-9]+_[0-9]+.jpg)$#i'] = array('controller' => 'recipes', 'action' => 'setcover');
$routes['#^/recipes/([0-9]{1,5})/edit$#i'] = array('controller' => 'recipes', 'action' => 'edit');
$routes['#^/recipes/([0-9]{1,5})/update$#i'] = array('controller' => 'recipes', 'action' => 'update');
$routes['#^/recipes/([0-9]{1,5})/addFavourite$#i'] = array('controller' => 'recipes', 'action' => 'addFavourite');
$routes['#^/recipes/([0-9]{1,5})/deleteFavourite$#i'] = array('controller' => 'recipes', 'action' => 'deleteFavourite');
$routes['#^/recipes/createComment$#i'] = array('controller' => 'recipes', 'action' => 'createComment');
$routes['#^/recipes/newrecipe$#i'] = array('controller' => 'recipes', 'action' => 'newrecipe');
$routes['#^/recipes/create$#i'] = array('controller' => 'recipes', 'action' => 'create');
$routes['#^/recipes/category/([0-9]{1,5})$#i'] = array('controller' => 'recipes', 'action' => 'category');
$routes['#^/recipes/category/([0-9]{1,5})?page=([0-9]{1,5})$#i'] = array('controller' => 'recipes', 'action' => 'category');
$routes['#^/recipes/search$#i'] = array('controller' => 'recipes', 'action' => 'search');

$routes['#^/recipes/([0-9]{1,5})/addpic$#i'] = array('controller' => 'photos', 'action' => 'addpic');
$routes['#^/recipes/([0-9]{1,5})/uploadpic$#i'] = array('controller' => 'photos', 'action' => 'uploadpic');

$routes['#^/session/new$#i'] = array('controller' => 'session', 'action' => 'add');
$routes['#^/session/create$#i'] = array('controller' => 'session', 'action' => 'create');
$routes['#^/session/destroy$#i'] = array('controller' => 'session', 'action' => 'destroy');
