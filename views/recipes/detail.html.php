<html>
<head>
<title>Recipe Detail</title>
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
     <table width="500">
	
<tr>
<td><?php echo "<font color = '#FF6699' size = '3'>".$template->recipes->recipe_name."</font>"; ?></td>
</tr>
 <tr height="20"></tr>
<tr><td>
<?php 
$name = $template->recipes->image_name;
$head = "/myrecipe/webroot/upload/";
$src = $head.$name;
echo "<a href='/myrecipe/recipes/" . $template->recipes->recipe_id . "/view'><img src='".$src."' width='120' height='120'></a></td><tr>";
 ?>
 <tr height="20"></tr>
<tr>
<td align = "mid">Labels</td>
<td>
<?php
foreach ($template->categorys as $category)
{
	echo $category->category_name . ", ";
}
?>
</td>
</tr>
 <tr height="20"></tr>
<tr>
<td align = "mid">Number of Servings</td>
<td><?php echo $template->recipes->number_of_servings; ?></td>
</tr>
 <tr height="20"></tr>
<tr>
<td align = "mid">Preparing Time</td>
<td><?php echo $template->recipes->preparation_time; ?></td>
</tr>
 <tr height="20"></tr>
<tr>
<td align = "mid">Cooking Time</td>
<td><?php echo $template->recipes->cooking_time; ?></td>
</tr>
 <tr height="20"></tr>
<tr>
<td align = "mid">Materials</td>
<td><?php echo $template->ingredients->ingredients; ?></td>
</tr>
 <tr height="20"></tr>
<tr>
<td align = "mid">Steps</td>
<td><?php echo $template->steps->steps; ?></td>
</tr>
</table>

 <!--这里掉出所有的comments，用foreach每个1个tr-->
 <?php
if (count($template->comments)!=0)
{
echo "<br />Comments:<br /><br />";
$records_per_page = 2;
if (isset($_GET["page"]))
{
$page = $_GET["page"];
}
else
{
$page = 1;
}
$total_records = count($template->comments);
$total_pages = ceil($total_records / $records_per_page);
$started_record = $records_per_page * ($page - 1);
//echo $total_pages;
if (($page*$records_per_page) > $total_records)
{
$j = ($page*$records_per_page) - $total_records;
}
else
{
$j = 0;
}
$i = $started_record;
$recipesarr = array($template->recipes);
while($template->comments AND $j<$records_per_page)
	{
		if (count($template->users!=0))
		{
			foreach ($template->users as $user)
			{
				if ($user->user_id == $template->comments[$i]->user_id)
				{
					echo $user->username . ": [";
				}
			}
		}
		echo $template->comments[$i]->rating . "] ";
		echo $template->comments[$i]->content . "<br />";
		echo "by: " . $template->comments[$i]->add_time . "<br /><br />";
		$i++;
		$j++;
	}
if ($page > 1)
{
echo "<a a class='register' href='?page=".($page-1)."'>Previous</a>";
}
for ($m =1; $m <= $total_pages; $m++)
{
if ($m == $page)
{
echo $m;
}
else
{
echo "<a a class='register' href='?page=".$m."'>".$m."</a>";
}
}
if ($page < $total_pages)
{
echo "<a class='register' href='?page=".($page+1)."'>Next</a>";
}
}
?>
 
<?php if (isset($_SESSION['user'])) { ?>
<?php if(!$template->isCommented) { ?>
<form method="post" action="createComment">
<table>
  <tr height="20"></tr>
  <tr>
	<td width="200"><font size="3">Rating</font>
	</td>
	<td>
	<input type="radio" name="rate" value="1">1
	<input type="radio" name="rate" value="2">2
	<input type="radio" name="rate" value="3">3
	<input type="radio" name="rate" value="4">4
	<input type="radio" name="rate" value="5" CHECKED>5
	</td>
  </tr>
</table>

<table>
<tr>
	<td align = "mid">Commnet</td>
</tr>
<tr>
	<td width="500"><input class="text" id="content" name="content" style="width:500px; height:100px" /></td>
	</tr>
</table>
<table>
<tr>
	<input type="hidden" name="recipe_id" value="<?php echo $template->recipes->recipe_id; ?>" />
	<td align="right"><input type="reset" value="Reset" /></td>
	<td>
	<input align = "middle" type="submit" value="Submit"/>
	</td>
</tr>
</table>
</form>
<?php } else { ?>
<font color="red">Commented</font>
<?php } ?>
<?php } ?>
    </div>

  </div>

   

  <div class="right">
  <div><font size="3" color="red" style="normal">Rating <?php echo $template->rating; ?></font></div>
  <div class="star"></div>
  <?php 
  if (isset($_SESSION['user'])) {
  if (!$template->isFaved) { ?>
  <div><a href="/myrecipe/recipes/<?php echo $template->recipes->recipe_id; ?>/addFavourite" class="register">Add to faviroute</a></div>
  <?php } else {?>
  <div>Favourited</div>
  <div><a href="/myrecipe/recipes/<?php echo $template->recipes->recipe_id; ?>/deleteFavourite" class="register">Remove</a></div>
  <?php }
  if ($template->recipes->user_id == $_SESSION['user']['id']) { ?>
  <div><a href="/myrecipe/recipes/<?php echo $template->recipes->recipe_id; ?>/edit">Edit</a></div>
  <div><a href="/myrecipe/recipes/<?php echo $template->recipes->recipe_id; ?>/addpic">Add Picture</a></div>
<?php }}?>
  </div>   
   
   
   
  


<div id="fotter1">
  
  <div class="fotter_copyrights">
    <div align="center">&copy; Copyright Information Goes Here. All Rights Reserved</div>
  </div>
  
</div>


</body>
</html>
