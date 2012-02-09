<html>
<head>
<title>recipe</title>
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
<!-- 这一行从数据库里调3个最新的recipes，然后分别放入3个不同的td中，每个都是名字+图片 -->
<?php
echo "<div class='newest'>******************** NEWEST ********************</div>";
foreach ($template->newestRecipes as $newestRecipe)
{
    echo "<div class='recipes'>";
	echo "<br />";
	echo "<font color = '#FF6699' size = '3'>" . $newestRecipe->recipe_name . "</font><br />";
	echo "<table>";
	echo "<tr><td>";
	$name = $newestRecipe->image_name;
	$head = "/myrecipe/webroot/upload/";
	$src = $head.$name;
	echo "<img src='" . $src . "' width='70' height='70'></td><td>";
	echo "Preparation Time: " . $newestRecipe->preparation_time . "<br />";
	echo "Cooking Time: " . $newestRecipe->cooking_time . "<br />";
	echo "Number of Servings: " . $newestRecipe->number_of_servings . "</td></tr></table><br />";
	echo '<a href="/myrecipe/recipes/' . $newestRecipe->recipe_id . '" class="reset">Detail</a>';
	echo "<br />";
	echo "</div>";
}
echo "<br />";
echo "<br />";
echo "<a href='/myrecipe/recipes/all' class='reset'>More</a>";
echo "<br />";
echo "<br />";
?>


    </div>
    <div class="body_textarea">
 

<!-- 这一行从数据库里调3个最热门的recipes，然后分别放入3个不同的td中，每个都是名字+图片 -->
<?php
echo "<div class='hotest'>******************** HOTTEST ********************</div>";
foreach ($template->hottestRecipes as $hottestRecipe)
{
    echo "<div class='recipes'>";
	echo "<br />";
	echo "<font color = '#FF6699' size = '3'>" . $hottestRecipe->recipe_name . "</font><br />";
	echo "<table>";
	echo "<tr><td>";
	$name = $hottestRecipe->image_name;
	$head = "/myrecipe/webroot/upload/";
	$src = $head.$name;
	echo "<img src='" . $src . "' width='70' height='70'></td><td>";
	echo "Preparation Time: " . $hottestRecipe->preparation_time . "<br />";
	echo "Cooking Time: " . $hottestRecipe->cooking_time . "<br />";
	echo "Number of Servings: " . $hottestRecipe->number_of_servings . "</td></tr></table><br />";
	echo '<a href="/myrecipe/recipes/' . $hottestRecipe->recipe_id . '" class="reset">Detail</a>';
	echo "<br />";
	echo "</div>";
}
echo "<br />";
echo "<br />";
echo "<a href='/myrecipe/recipes/all' class='reset'>More</a>";
echo "<br />";
echo "<br />";
?>


      </div>
    </div>
   
  <div class="right">
    <div class="login_area">
      <div class="login_top"></div>
      <div class="login_bodyarea">
        <div class="right_head">
		  <div align="center">Login</div>
        </div>
<?php if (isset($_SESSION['user'])) { ?>
	<p style="color:red"><?php echo "Hi, " . $_SESSION['user']['name'] . "!"; ?></p>
	<div><a href = "/myrecipe/session/destroy" class="register">Log out</a></div>
<?php } else {?>
		<form method="POST" action="/myrecipe/session/create">
        <div class="right_textbox">
          <label>
          <input name="username" type="text" class="righttextbox" value="Name" />
          </label>
        </div>
		<div class="right_textbox">
          <label>
          <input name="password" type="password" class="righttextbox" value="Password" />
          </label>
        </div>
        <div class="right_text">
          <label>
          <input type="checkbox" name="checkbox" value="checkbox" />
          </label>
        Remember Me</div>
		<div><a href="/myrecipe/users/registry" class="register">New user?</a></div>
        <div class="right_text">
          <div align="center"><a><input type="submit" name="submit" value="Login" /></a></div>
        </div>
		</form>
<?php } ?>
	  </div>
      <div class="login_bottom"></div>
    </div>
<?php
if (count($template->categories)!=0)
{
	if (count($template->menus)!=0)
	{
		foreach ($template->menus as $menu)
		{
			echo $menu->menu_name . ":<br />";
			foreach ($template->categories as $category)
			{
				if ($category->menu_id == $menu->menu_id)
				{
					echo "<li><a href='/myrecipe/recipes/category/" . $category->category_id . "'>" . $category->category_name . "</a></li>";
				}
			}
			echo "<br />";
		}
		echo "<br />";
	}
}
?>  
  </div>
</div>


<div id="fotter1">

  <div class="fotter_copyrights">
    <div align="center">&copy; Copyright Information Goes Here. All Rights Reserved</div>
  </div>
  

</div>

</body>
</html>
