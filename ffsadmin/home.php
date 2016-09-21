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
<head><title>Admin Panel</title>
<style>
fieldset{
	border-color:black;
}
button#depbutton,#startFB,#Logout{
	font-family: "Lucida Sans";
		border: 1 solid;
}
button#depbutton:hover{
	 background-color: white;
		color:#FC8505;
		font-size: 14;
		border: 2 solid;
}
button#startFB:hover{
	 background: #06D206;
	 color: white;
}
#Logout:hover{
	 background: red;
	 color: white;
}
</style>
</head>
<center>
<DIV STYLE="font-family: 'Lucida Sans';">
<center><img src="../assets/coll_header.jpg">
<h1>ADMIN PANEL</h1>
<form action="adminlogout.php" method="post">
<input type=hidden name=val value="logout">
<input type=submit value=Logout id="Logout">
</form>
<center>
<table border=0 width=800><tr><td><fieldset>
<legend>Feedback Session</legend><center>
<table border=0 width=800><tr><td align=center><a href=classselection.php><button id="startFB">Start Feedback Session</button></a></td></tr></table>
</center></fieldset></td></tr>
</table></center>
<center><table width=800 border=0>
<tr><td><fieldset><legend>Reports</legend>
	<table rules=cols align=center width=800 border=0>
	<tr bgcolor=#FFFF33><td colspan=2 align=center><b><font color=red>For the Faculty and the Class you choose, Reports can be<font color=green> downloaded</font> only if a feedback session was conducted.</b></font></td></tr>
	<tr><td colspan=2><hr color=black></td></tr>
	<tr><td><b><u>Choose a Department.</u></b></td><td align=center width=550><b><u>Choose Faculty,Class and other options.</u></b></td></tr>
	<tr><td><form action=LoadFac.php method=post target=LoadFacFrame name="LoadFacultyForm">
		<br>
		<Button name=dep value=BS id="depbutton">Basic Science</button><br><br>
		<button name=dep value=CS id="depbutton">C.S Engineering</button><br><br>
		<Button name=dep value=EC id="depbutton">E & C Engineering</button><br><br>
		<Button name=dep value=CV id="depbutton">Civil Engineering</button><br><br>
		<Button name=dep value=ME id="depbutton">Mech. Engineering</button>
	</select></form></td>
	<td width=470 align=center valign=top>
	<iframe src=LoadFac.php width=550 height=200 name=LoadFacFrame frameborder=0></iframe>
	</td></tr>
	</table>
</td></tr>
<tr><td><fieldset><legend>Configuration</legend>
<table border="0" width="800" align="center"><tr>	<td><button>Faculty-Subjects Mappings</button></td>
						<td><button>Add/Remove Subject(s)</button></td>
						<td><a href="fac_management.php"><button>Add/Remove Faculty(s)</button></a></td>
						

					</tr>
</table>				
</fieldset></td></tr>
</table>
</center>
</div>