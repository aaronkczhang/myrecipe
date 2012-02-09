<html>
<head>
<title>edit recipe</title>
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
	<!-- 这里都有本来的数据，让用户改-->
<form method="POST" action="update">
     <table>
<tr>
<td align = "right">Recipe name</td>
<td><input class="text" id="name" name="name"/></td>
</tr>
<tr>
<td align = "right">Labels</td>
<td><!-- 这里做几个下拉菜单给用户选，从数据库里面调-->

		<select name="s1">
			<option value="[null]">-Course-</option>
<?php
	if (count($template->categories)!=0)
	{
		foreach ($template->categories as $category)
		{
			if ($category->menu_id == 1)
			{
				echo "<option value='" . $category->category_id . "'>" . $category->category_name . "</option>";
			}
		}
	}
?>
		</select>
		<select name="s2">
			<option value="[null]">-Cuisines-</option>
<?php
	if (count($template->categories)!=0)
	{
		foreach ($template->categories as $category)
		{
			if ($category->menu_id == 2)
			{
				echo "<option value='" . $category->category_id . "'>" . $category->category_name . "</option>";
			}
		}
	}
?>
		</select>
		<select name="s3">
			<option value="[null]">-Ingredient-</option>
<?php
	if (count($template->categories)!=0)
	{
		foreach ($template->categories as $category)
		{
			if ($category->menu_id == 3)
			{
				echo "<option value='" . $category->category_id . "'>" . $category->category_name . "</option>";
			}
		}
	}
?>
		</select>
		<select name="s4">
			<option value="[null]">-Diets-</option>
<?php
	if (count($template->categories)!=0)
	{
		foreach ($template->categories as $category)
		{
			if ($category->menu_id == 4)
			{
				echo "<option value='" . $category->category_id . "'>" . $category->category_name . "</option>";
			}
		}
	}
?>
		</select>
	</td>
</tr>
<tr>
<td align = "right">Number of Servings</td>
	<td>
	<select  name="num">
	<option value="1">1</option>
	<option value="2">2</option>
	<option value="3">3</option>
	<option value="4">4</option>
	<option value="5">5</option>
	<option value="6">6</option>
	<option value="7">7</option>
	<option value="8">8</option>
	<option value="9">9</option>
	<option value="10">10</option>
	<option value="99">More than 10</option>
	</select>
	</td>
</tr>
<tr>
	<td align = "Right">Preparing Time</td>
	<td>
	<select  name="ptime">
	<option value="5">5 Mins</option>
	<option value="10">10 Mins</option>
	<option value="30">30 Mins</option>
	<option value="60">60 Mins</option>
	<option value="120">120 Mins</option>
	<option value="9999">More than 120 Mins</option>
	</select>
	</td>
</tr>
<tr>
	<td align = "Ptime">Cooking Time</td>
	<td>
	<select  name="ctime">
	<option value="5">5 Mins</option>
	<option value="10">10 Mins</option>
	<option value="30">30 Mins</option>
	<option value="60">60 Mins</option>
	<option value="120">120 Mins</option>
	<option value="9999">More than 120 Mins</option>
	</select>
	</td>
</tr>
<tr>
<td align = "right">Materials</td>
<td><input class="text" id="ingredients" name="ingredients"/></td>
</tr>
<tr>
<td align = "right">Steps</td>
<td><input class="text" id="steps" name="steps"/></td>
</tr>
<tr>
<td align="right"><input type="reset" value="Reset" /></td>
<td>
<input valign = "middle" type="submit" value="Submit"/>
</td>
</tr>
</table>
</form>
    </div>

  </div>
  <div class="right">
  <div><a href = "/myrecipe/recipes/newrecipe" class="register">Upload new recipe</a></div>
  <div><a href = "/myrecipe/users/<? echo $_SESSION['user']['id']; ?>/edit" class="register">Edit my personal information</a></div>
  <div><a href = "/myrecipe/session/destroy" class="register">Log out</a></div>
  </div>
</div>


<div id="fotter">
  <div class="fotter_links">
    <div align="center"><a href="#" class="fotterlink">Home</a>  |  <a href="#" class="fotterlink">About Us</a>  |  <a href="#" class="fotterlink">Companies Success</a>  |  <a href="#" class="fotterlink">Client Testimonials</a>  |  <a href="#" class="fotterlink">Methods of Development</a>  |  <a href="#" class="fotterlink">Newsletter</a>  |  <a href="#" class="fotterlink">Subscribe Info</a>  |  <a href="#" class="fotterlink">Oppotunities</a>  |  <a href="#" class="fotterlink">Current Events</a>  |  <a href="#" class="fotterlink">Contact Us</a></div>
  </div>
  <div class="fotter_copyrights">
    <div align="center">&copy; Copyright Information Goes Here. All Rights Reserved</div>
  </div>
  <div class="fotter_validation">
    <div align="center"><a href="http://validator.w3.org/check?uri=referer" target="_blank" class="xhtml">XHTML</a> <a href="http://jigsaw.w3.org/css-validator/check/referer" target="_blank" class="css">CSS</a><br />
    </div>
  </div>
  <div class="fotter_designed">
    <div align="center">Designed By : <a href="#" class="fotter_designedlink">Template World</a></div>
  </div>
</div>

</body>
</html>
