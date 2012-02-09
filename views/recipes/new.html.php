<html>
<head>
<title>New Recipe</title>
<link href="/myrecipe/webroot/css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../webroot/js/recipeValidation.js">
</script>
<style type="text/css">
<!--
.STYLE1 {color: #FF0000}
-->
</style>

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
<form id="form" method="POST" action="create">
     <table>
<tr>
	<td width="175" align = "right" valign="top">Recipe name<span class="STYLE1">*</span></td>
	<td width="374"><h6>
	  <input class="text" id="name" name="name"/>
	</h6></td>
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
	<td align = "right">Cooking Time</td>
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
	<td align = "right" valign="top"><p>Ingredients</p>
	  <p><span class="STYLE1">*more than 20 characters</span></p></td>
	<td valign="middle"><h6>
	  <input class="text" id="ingredients" name="ingredients" style="width:200px; height:200px;" />
	</h6></td>
</tr>
<tr>
	<td align = "right" valign="top"><p>Steps</p>
	  <p><span class="STYLE1">*more than 20 characters</span></p></td>
	<td><h6>
	  <input class="text" id="steps" name="steps" style="width:200px; height:200px;" />
	  <span class="STYLE1">*more than 20 characters</span></h6></td>
</tr>
<tr>
	<td align="right"><input type="reset" value="Reset" /></td>
	<td>
	<input align = "middle" type="submit" value="Submit" onClick="return validateFormOnSubmit()"/>
	</td>
</tr>
</table>
</form>
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
