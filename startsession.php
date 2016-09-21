<?php 
require_once './CoreLib.php';
	date_default_timezone_set('Asia/Kolkata');
	//connect to database and load startup row
	$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
	mysql_select_db($mysql_database, $bd) or die("Could not select database");
	$qry="SELECT * FROM `table_data` WHERE ID='Startup'";
	$res=mysql_query($qry);
	if(!mysql_query($qry,$bd)){
		die ("An unexpected error occured while saving the record, Please try again!");
	}
	$Startup=mysql_fetch_assoc($res);
	$status=$Startup['Data1'];
	if($status==0){
		header("location: index.php?e=1");
		exit();
	}
	$Class=$Startup['Data2'];
	session_start();
	$_SESSION['Class']=$Class;
	$ClientIP=HashString($_SERVER['REMOTE_ADDR']);
	//loading faculty allocations
	$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
	mysql_select_db($mysql_database, $bd) or die("Could not select database");
	$qry="SELECT * FROM `table_data` WHERE ID='".$Class."'";
	$res=mysql_query($qry);
	$allocation=mysql_fetch_assoc($res);
	
		
?>
<title>Choosing The Subject</title>
<DIV STYLE="font-family: 'Lucida Sans';">
<center><img src=assets/coll_header.jpg><br>
<table width=760 height=300 border=0>
<h3><?php echo GetClassName($Class);?></h3>
<h2><?php echo date('l F d, Y h:i');?></h2>
<tr><td><fieldset><legend>Choosing The Subject</legend>
	<table rules=cols align=center width=760 border=0>
	<tr bgcolor=#FFFF33><td align=center colspan=2><b>Please note that the feedback form for each subject can be filled and submitted only <font color=red>Once.</font></b></td></tr>
	<tr><td colspan=2><hr></td></tr>
	<tr align=center><td colspan=2>Choose a subject from the drop-down menu below and click the Open Form button to open it's feedback form.</td></tr>
	<tr><td colspan=2><hr></td></tr>
	<tr align=center><td><form action=form.php method=post><select name=AllocID><option value=none>Choose a subject...</option>
		<?php
			//disable options whose feedback was given;
			$n=1;
			while($allocation["Data$n"]){
				$FacID=strtolower(StripFaccode($allocation["Data$n"]));
				echo $FacID;
				$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
				mysql_select_db($mysql_database, $bd) or die("Could not select database");
				$qry="SELECT * FROM $FacID WHERE ClientIP='".$ClientIP."' AND Class='".$_SESSION['Class']."'";
				$res=mysql_query($qry);
				$row=mysql_fetch_assoc($res);
				if($row['SubStat']==1) $Fbstatus=" Disabled";
				echo "<option value=".$allocation["Data$n"]."".$Fbstatus.">".GetSubname(StripSubcode($allocation["Data$n"]))."</option>";
				$Fbstatus="";
				$n=$n+1;
			}
		?>	
	</select></td>
	<td><input type=submit value="Open Form"></td>
	</tr>
	</table>

</td></tr>
</table>
</div>