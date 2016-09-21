<?php 
require_once '../CoreLib.php';
session_start();
if($_SESSION['LoginStatus']==1){
	header("location: home.php");
}
?>
<title>Admin Panel</title>
<DIV STYLE="font-family: 'Lucida Sans';">
<center><img src="../assets/coll_header.jpg">
<h1>ADMIN PANEL</h1>
<h2>Login Page</h2>
<form action=adminlogin.php method=post>
<table width=300 border=0>
<tr><td><fieldset><legend>Login</legend>
<center>
<table><tr><td>Username : </td><td><input type=text name=uname></td></tr>
<tr><td>Password : </td><td><input type=password name=pass></td></tr>
<tr><td colspan=2><hr></td></tr>
<tr align=center><td colspan=2><input type=submit value=Login></tr>
<?php if($_SESSION['LoginError']==1) echo "<tr bgcolor=#FFFF33><td colspan=2><b><font color=red>Invalid</font> Username  Or Password!</b></td></tr>";?>
</table>
</center>
</fieldset>
</td></tr>
</table>
</form>

