<?php 
require_once '../CoreLib.php';
session_start();
if(($_SESSION['LoginStatus']==0)||($_SESSION['LoginStatus']==NULL)){
header("location: index.php");
}
$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
	mysql_select_db($mysql_database, $bd) or die("Could not select database");
	$qry="SELECT * FROM `table_data` LIMIT 29,999999999999";
	$res=mysql_query($qry);
	if(!mysql_query($qry,$bd)){
		die ("An unexpected error occured while saving the record, Please try again!");
	}
	
?>
<title>Admin Panel</title><center>
<DIV STYLE="font-family: 'Lucida Sans';">
<center><img src="../assets/coll_header.jpg">
<h1>ADMIN PANEL</h1>
<center><form action=adminlogout.php method=post>
<input type=hidden name=val value=logout>
<input type=submit value=Logout></form>
<table border=0 width=760><tr><td><fieldset>
<legend>Feedback Session</legend><center>
<table border=0><tr><td align=center><a href=classselection.php><button>Start Feedback Session</button></a></td></tr></table>


</center></fieldset></td></tr>
</table></center>
<center><table width=760 border=0>
<tr><td><fieldset><legend>Reports</legend>
	<table rules=cols align=center width=700 border=0>
	<tr bgcolor=#FFFF33><td colspan=2 align=center><b><font color=red>For the Faculty and the Class you choose, Reports can be<font color=green> downloaded</font> only if a feedback session was conducted.</b></font></td></tr>
	<tr><td colspan=2><hr></td></tr>
	<tr><td>Choose a Department.</td><td align=center width=470>Choose Faculty,Class and other options.</td></tr>
	<tr><td><form action=LoadFac.php method=post target=LoadFacFrame>
		<br><Button name=dep value=BS>Basic Science</button><br><br>
		<button name=dep value=CS>Computer Science Engineering.</button><br><br>
		<Button name=dep value=EC>E & C Engineering</button><br><br>
		<Button name=dep value=CV>Civil Engineering</button><br><br>
		<Button name=dep value=ME>Mechanical Engineering</button></form>
		
	</select></td>
	<td width=470 height=250 align=center>
	<iframe src=LoadFac.php width=470 height=250 name=LoadFacFrame frameborder=0></iframe>
	</td></tr>
	</table>
</td></tr>

</table></center>
</div>