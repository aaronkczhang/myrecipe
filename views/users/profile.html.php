<html>
<head>
<title>profile</title>
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
      Hi,<!--用户的名字--><?php echo $template->user->username; ?>
    </div>
    <div class="body_textarea">
      <!--用户的头像-->
    </div>
    <div class="body_textarea">
      <table>
<tr>
<td style="background:#A9A9A9;"><font size="3" color="#DCDCDC" >My recipes</font></td>
</tr>
<tr>
<!--把这个用户所有的recipe都调出来，用循环写入表格中-->
<?php
if (count($template->myrecipes)==0)
{
	echo "No Recipes";
}
else
{
	foreach ($template->myrecipes as $myrecipe)
	{
		echo '<td>' . $myrecipe->recipe_name . '</td>';
	}
	echo '<td><a href="/myrecipe/users/' . $template->user->user_id . '/recipes" class="reset">More</a></td>';
}
?>
</tr>
<tr>
<td style="background:#A9A9A9;"><font size="3" color="#DCDCDC" background= "#A9A9A9">My favorites</font></td>
</tr>
<tr>
<!--把这个用户所有的favorites都调出来，用循环写入表格中-->
<?php

if (count($template->myfavourites)==0)
{
	echo "No Favourites";
}
else
{
	foreach ($template->myfavourites as $myfavourite)
	{
		echo '<td>' . $myfavourite->recipe_name . '</td>';
	}
	echo '<td><a href="/myrecipe/users/' . $template->user->user_id . '/favourites" class="reset">More</a></td>';
}
?>
</tr>
<tr>
<td style="background:#A9A9A9;"><font size="3" color="#DCDCDC" background= "#A9A9A9">My comments</font></td>
</tr>
<tr>
<!--把这个用户所有的comments都调出来，用循环写入表格中-->
<?php
if (count($template->mycomments)==0)
{
	echo "No Comments";
}
else
{
	foreach ($template->mycomments as $mycomment)
	{
		if (count($template->recipes)!=0)
		{
			foreach ($template->recipes as $recipe)
			{
				if ($recipe->recipe_id == $mycomment->recipe_id)
				{
					echo '<td>' . $recipe->recipe_name . '</td>';
				}
			}
		}
	}
	echo '<td><a href="/myrecipe/users/' . $template->user->user_id . '/reviews" class="reset">More</a></td>';
}
?>
</tr>
</table>
    </div>

  </div>
  <div class="right">
  <div><a href = "/myrecipe/recipes/newrecipe" class="register">Upload new recipe</a></div>
  <div><a href = "/myrecipe/users/<? echo $template->user->user_id; ?>/edit" class="register">Edit my personal information</a></div>
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
