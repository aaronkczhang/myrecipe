<?php
require_once 'Menus.php';


//get all menu items
$menus = Menu::findMenu();
echo '<pre>';
print_r($menus);
echo '</pre>';
echo "***********************";


//get menu item by menu id
$menus = Menu::findMenu(array('menu_id'=>'2'));
echo '<pre>';
print_r($menus);
echo '</pre>';
echo "***********************";


//get all category items
$categories = Menu::findCategory();
echo '<pre>';
print_r($categories);
echo '</pre>';
echo "***********************";


//get category item by id
$categories = Menu::findCategory(array('category_id'=>'6'));
echo '<pre>';
print_r($categories);
echo '</pre>';
echo "***********************";

