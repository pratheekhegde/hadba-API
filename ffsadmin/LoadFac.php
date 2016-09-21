<?php 
require_once '../CoreLib.php';
session_start();
//Main Logic Starts here
if(($_SESSION['LoginStatus']==0)||($_SESSION['LoginStatus']==NULL)){
header("location: index.php");
exit();
}
$Dep=$_POST['dep'];
if($Dep==NULL){
	echo "<br><br><br><br><b><font face=\"Lucida Sans\" size=5><center><em>Click a department to load it's faculty and class list.</em></center></font></b>";
	goto end;
}

$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
	mysql_select_db($mysql_database, $bd) or die("Could not select database");
	$qry="SELECT * FROM `table_data` WHERE Data2='".$Dep."'";
	$res=mysql_query($qry);
	if(!mysql_query($qry,$bd)){
		die ("An unexpected error occured while saving the record, Please try again!");
	}
	
?>	
<DIV STYLE="font-family: 'Lucida Sans';">
<br>
<center>
<form method="POST" action="GeneratePDF.php">
<table width=460 border=0 rules=cols>
<tr><td align=center><b>Faculty</b></td><td align=center><b>Class</b></td></tr>
<tr><td align=center>
		<select name="FacID" id="FacID">
		<?php 
			while($result=mysql_fetch_array($res)){
			echo "<option value=".$result['ID'].">".$result['Data1']."</option>";
			}
		?>	
		</select></td>
	<td align=center><select name="Class" id="Class">
		<?php 
			if($Dep=="CS"){
				echo "<option value=Class1A>1st Year A Section</option>
					  <option value=Class1B>1st Year B Section</option>
					  <option value=Class1C>1st Year C Section</option>
					  <option value=Class1D>1st Year D Section</option>
					  <option value=Class1E>1st Year E Section</option>
					  <option value=Class1F>1st Year F Section</option>
					  <option value=Class1G>1st Year G Section</option>
					  <option value=Class2A>2nd Year C.S.E A Section</option>
					  <option value=Class2B>2nd Year C.S.E B Section </option>
					  <option value=Class3A>3rd Year C.S.E A Section</option>
					  <option value=Class3B>3rd Year C.S.E B Section</option>
					  <option value=Class4A>4th Year C.S.E A Section </option>
					  <option value=Class3D>3rd Year E.C.E B Section </option>
					  <option value=Class3C>3rd Year E.C.E A Section </option>";
			}else if($Dep=="EC"){
				echo "<option value=Class1A>1st Year A Section</option>
					  <option value=Class1B>1st Year B Section</option>
					  <option value=Class1C>1st Year C Section</option>
					  <option value=Class1D>1st Year D Section</option>
					  <option value=Class1E>1st Year E Section</option>
					  <option value=Class1F>1st Year F Section</option>
					  <option value=Class1G>1st Year G Section</option>
					  <option value=Class2C>2nd Year E.C.E A Section</option>
					  <option value=Class2D>2nd Year E.C.E B Section</option>
					  <option value=Class3C>3rd Year E.C.E A Section</option>
					  <option value=Class3D>3rd Year E.C.E B Section</option>
					  <option value=Class4C>4th Year E.C.E A Section</option>";
			}else if($Dep=="ME"){
				echo "<option value=Class1A>1st Year A Section</option>
					  <option value=Class1B>1st Year B Section</option>
					  <option value=Class1C>1st Year C Section</option>
					  <option value=Class1D>1st Year D Section</option>
					  <option value=Class1E>1st Year E Section</option>
					  <option value=Class1F>1st Year F Section</option>
					  <option value=Class1G>1st Year G Section</option>
					  <option value=Class2E>2nd Year M.E A Section</option>
					  <option value=Class2F>2nd Year M.E B Section</option>
					  <option value=Class3E>3rd Year M.E A Section</option>
					  <option value=Class3F>3rd Year M.E B Section</option>
					  <option value=Class4E>4th Year M.E A Section</option>";
			}else if($Dep=="CV"){
				echo "<option value=Class1A>1st Year A Section</option>
					  <option value=Class1B>1st Year B Section</option>
					  <option value=Class1C>1st Year C Section</option>
					  <option value=Class1D>1st Year D Section</option>
					  <option value=Class1E>1st Year E Section</option>
					  <option value=Class1F>1st Year F Section</option>
					  <option value=Class1G>1st Year G Section</option>
					  <option value=Class2G>2nd Year Civ.E A Section</option>
					  <option value=Class3G>3rd Year Civ.E A Section</option>
					  <option value=Class4G>4th Year Civ.E A Section</option>";
			}else if($Dep=="BS"){
				echo "<option value=Class1A>1st Year A Section</option>
					  <option value=Class1B>1st Year B Section</option>
					  <option value=Class1C>1st Year C Section</option>
					  <option value=Class1D>1st Year D Section</option>
					  <option value=Class1E>1st Year E Section</option>
					  <option value=Class1F>1st Year F Section</option>
					  <option value=Class1G>1st Year G Section</option>
					  <option value=Class2A>2nd Year C.S.E A Section</option>
					  <option value=Class2B>2nd Year C.S.E B Section </option>
					  <option value=Class2C>2nd Year E.C.E A Section</option>
					  <option value=Class2D>2nd Year E.C.E B Section</option>
					  <option value=Class2E>2nd Year M.E A Section</option>
					  <option value=Class2F>2nd Year M.E B Section</option>
					  <option value=Class2G>2nd Year Civ.E A Section</option>";
			}
		?>
		</select>
		
	</td>
</tr>
<tr><td colspan=2><hr></td></tr>
<tr><td colspan=2 align=center><input type="submit" value="Generate PDF Report"></td></tr>
</table>
</form>
</center>
</div>
<?php
end:
?>
