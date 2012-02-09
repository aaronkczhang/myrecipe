<html>
<head>
<title>Homepage</title>
<link href="/myrecipe/webroot/css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../webroot/js/userValidation.js">

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
	<form id="form" method="POST" action="create" ><!--增加1个validation的function并写入数据库，但是先要邮件验证，ajax我来做-->
	<table width="726" height="201">
		<tr>
			<td width="118" align="right" valign="top">Username</td>
			<td width="596"><h6>
		      <input class="text" id="username" name="username" type="username" value=""/>
		      <span class="STYLE1"> *5-15 characters,allow letters, numbers, and underscores </span></h6>
			  </td>
		</tr>
		<tr>
			<td align="right" valign="top">Password</td>
		  <td><h6>
		    <input class="text" id="password" name="password" type="password" value="" />
		  <span class="STYLE1"> *7-15 characters,allow letters and numbers </span></h6>
		    </td>
		</tr>
		<tr>
			<td align="right" valign="top">Comfirm Password</td>
			<td><h6>
			  <input class="text" id="cpassword" name="cpassword" type="password" value="" /> 
			  <span class="STYLE1">*retype your password  </span></h6></td>
		</tr>
		<tr>
			<td align="right" valign="top">E-mail Address</td>
		  <td><h6>
		    <input class="text" id="email" name="email" type="email" value="" />
		    <span class="STYLE1"> *validate email format:xx@xx.xx </span></h6>
		    </td>
		</tr>
<!--增加找回密码的回答问题和答案吗？-->
		<tr>
			<td height="23" align="right">
				<input type="RESET" value="Reset" />
		  </td>
			<td>
				<input type="SUBMIT" value="Submit" onClick="return validateFormOnSubmit()" /> 
			</td>
		</tr>
	</table>
	</form>
</div>
 
</div>
<div id="fotter">
  <div class="fotter_copyrights">
    <div align="center">&copy; Copyright Information Goes Here. All Rights Reserved</div>
  </div>

 

</body>
</html>
