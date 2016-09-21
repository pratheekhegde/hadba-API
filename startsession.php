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
<head>
<title>Choosing The Subject</title>
<script src="pace/pace.js"></script>
<link href="pace/pace-flash.css" rel="stylesheet" />
<style>
fieldset{
	border-color: black;
}
#OpenForm{
	
    border: 1px solid #006;
	color: #FC8505;
	font-size: 18px;
	background: white;
	border-color: #FC8505;
	border-width: thin;
}
select{
	font-size: 18px;
	border-color: #FC8505;
}
#OpenForm:hover{
	 background: #FC8505;
	 color: white;
	 border: 2px solid;
}

</style>
</head>
<body>
<DIV STYLE="font-family: 'Lucida Sans';">
<center><img src=assets/coll_header.jpg><br>
<table width=760 height=300 border=0>
<h3><?php echo GetClassName($Class);?></h3>
<h2><?php echo date('l F d, Y h:i');?></h2>
<form action=form.php method=post>
<tr><td><div id="chosing_subjects"><fieldset><legend>Choosing The Subject</legend>
	<table rules=cols align=center width=760 border=0>
	<tr bgcolor=#FFFF33><td align=center colspan=2><b>Please note that the feedback form for each subject can be filled and submitted only <font color=red>Once.</font></b></td></tr>
	<tr><td colspan=2><hr color=black></td></tr>
	<tr align=center><td colspan=2>Choose a subject from the drop-down menu below and click the Open Form button to open it's feedback form.</td></tr>
	<tr><td colspan=2><hr color=black></td></tr>
	<tr align=center><td><select name="AllocID" id="AllocID"><option value=none>Choose a subject...</option>
		<?php
			//disable options whose feedback was given;
			$n=1;
			$completed_count=0;
			while($allocation["Data$n"]){
				$FacID=strtolower(StripFaccode($allocation["Data$n"]));
				//echo $FacID;
				$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
				mysql_select_db($mysql_database, $bd) or die("Could not select database");
				$qry="SELECT * FROM $FacID WHERE ClientIP='".$ClientIP."' AND Class='".$_SESSION['Class']."'";
				$res=mysql_query($qry);
				$row=mysql_fetch_assoc($res);
				if($row['SubStat']==1){
					$completed_count++;
					$Fbstatus=" Disabled";
				}
				echo "<option value=".$allocation["Data$n"]."".$Fbstatus.">".GetSubname(StripSubcode($allocation["Data$n"]))."</option>";
				$Fbstatus="";
				$n++;
			}
		?>	
	</select></td>
	<td><input type=submit value="Open Form" id="OpenForm"></td>
	</tr>
	</table></fieldset></div><div id="feedback_done" style="display:none;">
	<fieldset>
		<table rules=cols align=center width=760 border=0>
		<tr><td align=center><b><font color=black><big>Thank you</big>, for submitting your valuable feedbacks.<img src=assets/thumbsup.png width=15><br>
								We hope you enjoyed this session.<br>You can leave now.<br>
								<big>We'll Meet You Next Semester. BYE!</big><br><img src=assets/smile.png width=100></b></font></td></tr>
		</table>
	</fieldset></div>
</td></tr>
<tr><td colspan="2" align="center"><div id="feedback_status">
		<table border="2" rules=rows >
		<th colspan=2 bgcolor="#06D206">Feedback Completed Subjects (<?=$completed_count;?>/<?=--$n;?>)</th>
			<?php
			//Show the subjects whose feedbacks have been completed
			$n=1;
			while($allocation["Data$n"]){
				$FacID=strtolower(StripFaccode($allocation["Data$n"]));
				//echo $FacID;
				$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
				mysql_select_db($mysql_database, $bd) or die("Could not select database");
				$qry="SELECT * FROM $FacID WHERE ClientIP='".$ClientIP."' AND Class='".$_SESSION['Class']."'";
				$res=mysql_query($qry);
				$row=mysql_fetch_assoc($res);
				if($row['SubStat']==1){
					echo "<tr><td>".GetSubname(StripSubcode($allocation["Data$n"]))."</td><td align=right><img src=assets/done.png width=20></td></tr>";
				}
				$n=$n+1;
			}
		?>	
		</table>
		</div></td></tr>
</table>
</form>

<?php GetBuildInfo();?>
</div>
</body>
<script type="text/javascript" src ="jquery-1.11.1.min.js"> </script>
<script type="text/javascript">
$(function(){
		$("#feedback_status").hide().fadeIn(1000);
		if(<?=$completed_count;?>==<?=--$n;?>){
			$("#chosing_subjects").slideUp(1200);
			$("#feedback_done").fadeIn(1500);
			
		}
});
	
</script>