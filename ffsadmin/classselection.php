<?php 
require_once '../CoreLib.php';
session_start();
if(($_SESSION['LoginStatus']==0)||($_SESSION['LoginStatus']==NULL)){
	header("location: index.php");
	goto end;
}
$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
	mysql_select_db($mysql_database, $bd) or die("Could not select database");
	$qry="SELECT * FROM `table_data` WHERE ID='Startup'";
	$res=mysql_query($qry);
	if(!mysql_query($qry,$bd)){
		die ("An unexpected error occured while saving the record, Please try again!");
	}
	$Startup=mysql_fetch_assoc($res);
	if($Startup['Data1']==1){
		$Status="<font color=green>Session is running.</font>";
		$Class=GetClassName($Startup['Data2']);
	}else{
		$Status="<font color=red>No Session is running.</font>";
		$Class="Click a class to start";
	}
?>
<title>Class Selection</title>
<center><img src=../assets/coll_header.jpg></center>
<DIV STYLE="font-family: 'Lucida Sans';">
<br><br>
<center><table height=600 width=800 border=0 rules=rows>
<tr><td colspan=4><center><h1>Click a class to start it's <font color=blue>Feedback Session</font>.</h1></center>
<table><tr bgcolor=#FFFF33><td align=left width=400><b>Status</b> : <?php echo $Status;?></td><td align=right width=400><b>Class</b> : <?php echo $Class;?></td></tr></table>
	</td></tr>
<tr><td align=center width=200><fieldset>
<legend>1st Year</legend>
<form action=loadclass.php method=post>
	<input name=id type=hidden value="Class1A"><input name="" type="submit" value="<?php echo GetClassName("Class1A");?>"></form><br>
<form action=loadclass.php method=post>
	<input name=id type=hidden value="Class1B"><input name="" type="submit" value="<?php echo GetClassName("Class1B");?>"></form><br>
<form action=loadclass.php method=post>
	<input name=id type=hidden value="Class1C"><input name="" type="submit" value="<?php echo GetClassName("Class1C");?>"></form><br>
<form action=loadclass.php method=post>
	<input name=id type=hidden value="Class1D"><input name="" type="submit" value="<?php echo GetClassName("Class1D");?>"></form><br>
<form action=loadclass.php method=post>
	<input name=id type=hidden value="Class1E"><input name="" type="submit" value="<?php echo GetClassName("Class1E");?>"></form><br>
<form action=loadclass.php method=post>
	<input name=id type=hidden value="Class1F"><input name="" type="submit" value="<?php echo GetClassName("Class1F");?>"></form><br>
<form action=loadclass.php method=post>
	<input name=id type=hidden value="Class1G"><input name="" type="submit" value="<?php echo GetClassName("Class1G");?>"></form>
</fieldset>
</td>
<td align=center width=200><fieldset>
<legend>2nd Year</legend>
<form action=loadclass.php method=post>
	<input name=id type=hidden value="Class2A"><input name="" type="submit" value="<?php echo GetClassName("Class2A");?>"></form><br>
<form action=loadclass.php method=post>
	<input name=id type=hidden value="Class2B"><input name="" type="submit" value="<?php echo GetClassName("Class2B");?>"></form><br>
<form action=loadclass.php method=post>
	<input name=id type=hidden value="Class2C"><input name="" type="submit" value="<?php echo GetClassName("Class2C");?>"></form><br>
<form action=loadclass.php method=post>
	<input name=id type=hidden value="Class2D"><input name="" type="submit" value="<?php echo GetClassName("Class2D");?>"></form><br>
<form action=loadclass.php method=post>
	<input name=id type=hidden value="Class2E"><input name="" type="submit" value="<?php echo GetClassName("Class2E");?>"></form><br>
<form action=loadclass.php method=post>
	<input name=id type=hidden value="Class2F"><input name="" type="submit" value="<?php echo GetClassName("Class2F");?>"></form><br>
<form action=loadclass.php method=post>
	<input name=id type=hidden value="Class2G"><input name="" type="submit" value="<?php echo GetClassName("Class2G");?>"></form>
</fieldset></td>
<td align=center width=200><fieldset>
<legend>3rd Year</legend>
<form action=loadclass.php method=post>
	<input name=id type=hidden value="Class3A"><input name="" type="submit" value="<?php echo GetClassName("Class3A");?>"></form><br>
<input name="" type="submit" value="Class3B - B (C.S.E)"><br><br><br>
<form action=loadclass.php method=post>
	<input name=id type=hidden value="Class3C"><input name="" type="submit" value="<?php echo GetClassName("Class3C");?>"></form><br>
<input name="" type="submit" value="Class3D - B (E.C.E)"><br><br><br>
<form action=loadclass.php method=post>
	<input name=id type=hidden value="Class3E"><input name="" type="submit" value="<?php echo GetClassName("Class3E");?>"></form><br>
<form action=loadclass.php method=post>
	<input name=id type=hidden value="Class3F"><input name="" type="submit" value="<?php echo GetClassName("Class3F");?>"></form><br>
<form action=loadclass.php method=post>
	<input name=id type=hidden value="Class3G"><input name="" type="submit" value="<?php echo GetClassName("Class3G");?>"></form>
</fieldset></td>

<td align=center width=200><fieldset>
<legend>4th Year</legend>
<form action=loadclass.php method=post>
	<input name=id type=hidden value="Class4A"><input name="" type="submit" value="<?php echo GetClassName("Class4A");?>"></form><br>
<input name="" type="submit" value="Class4B - B (C.S.E)"><br><br><br>
<form action=loadclass.php method=post>
	<input name=id type=hidden value="Class4C"><input name="" type="submit" value="<?php echo GetClassName("Class4C");?>"></form><br>
<input name="" type="submit" value="Class4D - B (E.C.E)"><br><br><br>
<form action=loadclass.php method=post>
	<input name=id type=hidden value="Class4E"><input name="" type="submit" value="<?php echo GetClassName("Class4E");?>"></form><br>
<input name=id type=submit value="Class3F - B (M.E)"><br><br><BR>
<form action=loadclass.php method=post>
	<input name=id type=hidden value="Class4G"><input name="" type="submit" value="<?php echo GetClassName("Class4G");?>"></form>
</fieldset></td>
</tr>
<tr><form action=loadclass.php method=post>
<input name=id type=Hidden id=id value="EndSession">
<td colspan=4 align=center><input name="" type="submit" id=end value="End Feedback Session"></form></td></tr>
</table></center>
</div>
<?php 
end:
?>