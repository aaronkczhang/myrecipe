<?php
require_once 'Photos.php';


$photo =Photo::findRecipeImagesById('3');
echo '<pre>';
print_r($photo);
echo '</pre>';