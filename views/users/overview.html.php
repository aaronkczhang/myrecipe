<html>
<head>
<title>community</title>
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
     <table border="1">
<tr>
Recipe Stars
</tr>
<tr>
<!--把发recipe最多的几个人显示出来(头像，名字)-->
</tr>
</table>
    </div>
    <div class="body_textarea">
 <table border="0">
<tr>
New members
</tr>
<tr>
<!--把新加入的会员显示出来(头像，名字)-->
<?php
if (count($template->newestUsers)!=0)
{
	foreach ($template->newestUsers as $user)
	{
		echo "<td>" . $user->username . "</td> ";
	}
}
?>
</tr>
</table>
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
</form>

</body>
</html>
