<?php
// available vars:
?>
<html>
<head>
<title>sesseion add</title>
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
	<?php if (isset($template->error)): ?>
  <p style="color:red"><?php echo $template->error; ?></p>
  <?php endif; ?>
<form method="POST" action="/myrecipe/session/create">
<table>
<tr>
<td align="right"> Username:</td>
<td><input type="text" name="username"/></td>
</tr>
<tr>
 <td align="right"> Password:</td>
<td><input type="password" name="password"/></td>
</tr>
 <tr><td align="right"><input type="submit" name="submit" value="Login"/></td>
 <td><input type="reset" name="reset" value="reset"></td>
 </tr>
 </table>
  </form>
    </div>
    </div>
   
  <div class="right">
    

  </div>
</div>


<div id="fotter">
  <div class="fotter_copyrights">
    <div align="center">&copy; Copyright Information Goes Here. All Rights Reserved</div>
  </div>
</div>

</body>
</html>
