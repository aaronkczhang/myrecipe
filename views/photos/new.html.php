<html>
<head>
<title>Upload Recipe</title>
<link href="/myrecipe/webroot/css/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
 <div id="topheader">
   <div class="logo"></div>
 </div>
 <div id="search_strip">
  <div class="search_area">
    <div class="search_box">
	<form method="POST" action="/myrecipe/recipes/search">
      <label>
      <input name="textfield" type="text" class="searchtextbox" />
      </label>
    </div>
    <div class="search_go">
      <div align="center"><a><input type="submit" name="submit" value="Go" /></a></div>
    </div>
	</form>
  </div>
 </div>
<div id="body_area">
  <div class="left">
    <div class="left_menutop"></div>
    <div class="left_menu_area">
      <div align="right"><a href="/myrecipe" class="left_menu">Home</a><br />
          <a href="/myrecipe/recipes" class="left_menu">Recipes</a><br />
          <a href="/myrecipe/users" class="left_menu">Community</a><br />
<?php if (isset($_SESSION['user'])) { ?>
	<a href="/myrecipe/users/<?php echo $_SESSION['user']['id']; ?>" class="left_menu">My Kitchen</a><br />
<?php } ?>
    </div>
    </div>
  </div>
  <div class="midarea">
    <div class="body_textarea">
	<div>Recipe name: <?php echo $template->recipe_name; ?></div>
<form id="form" method="POST" action="uploadpic" enctype="multipart/form-data">
<div><input type="hidden" name="MAX_FILE_SIZE" value="1048576">
<input type="file" name="myfile" id="myfile" size="50"></div>
<div align="mid"><input type="reset" value="Reset" /><input align = "middle" type="submit" value="Submit" onClick="return validateFormOnSubmit()"/></div>



</form>
<?php
if (isset($_SESSION['pic']['err']))
{
	echo $_SESSION['pic']['err'];
}
?>
    </div>

  </div>
  <div class="right">
  <div><a href = "/myrecipe/recipes/newrecipe" class="register">Upload new recipe</a></div>
  <div><a href = "/myrecipe/users/<? echo $_SESSION['user']['id']; ?>/edit" class="register">Edit my personal information</a></div>
  </div>
</div>


<div id="fotter">
  <div class="fotter_copyrights">
    <div align="center">&copy; Copyright Information Goes Here. All Rights Reserved</div>
  </div>
</div>

</body>
</html>
