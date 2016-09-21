<DIV STYLE="font-family: 'Lucida Sans';">
<?php 
require_once './CoreLib.php';
date_default_timezone_set('Asia/Kolkata');
$Timestamp=date('d-m-Y h:i:s');
session_start();
$Class=$_SESSION['Class'];
$ClientIP=HashString($_SERVER['REMOTE_ADDR']);
$FacID=$_POST['FacID'];
$FacName=GetFacName($FacID);
if($FacID==NULL){
	header("location: error.php");
	exit();
}
//echo $_POST['FacID'];
//echo $_POST['21'];
//echo $_SESSION['Class'];echo "<br>";
//echo $_POST['20'];echo "<br>";
//echo $ClientIP;

/* //Check if questions were not answered
	if(!$_POST['1'] || !$_POST['2'] || !$_POST['3'] || !$_POST['4'] || !$_POST['5'] || !$_POST['6'] || !$_POST['7'] || !$_POST['8'] || !$_POST['9'] || !$_POST['10'] || !$_POST['11'] || !$_POST['12'] || !$_POST['13'] || !$_POST['14'] || !$_POST['15'] || !$_POST['16'] || !$_POST['17'] || !$_POST['18'] || !$_POST['19'] || !$_POST['20']){
	echo "<title>Questions Not Answered!</title>
			<center><img src=assets/coll_header.jpg><br>
			<img src=assets/qnotans.jpg><hr color=red width=760>
			<a href=startsession.php><button>Go Back to Subject Selection Page</button></a></center>";
	goto end;
} */
//Check if feedback was already submitted once
	$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
	mysql_select_db($mysql_database, $bd) or die("Could not select database");
	$qry="SELECT * FROM $FacID WHERE ClientIP='".$ClientIP."' AND Class='".$_SESSION['Class']."'";
	$res=mysql_query($qry);
	if(!mysql_query($qry,$bd)){
		die ("An unexpected error occured while checking some things, Please try again!");
	}
	$row=mysql_fetch_assoc($res);
	$status=$row['SubStat'];
	if($status==1){
		echo"<title>Feedback Not Saved!</title>
			<center><img src=assets/coll_header.jpg><br>
			<img src=assets/fb_Notsaved.jpg>
			<h2><font color=blue> Feedback</font> for ";echo $FacName;
			echo " was not<font color=red> saved</font><br> since you have already submitted it once.</h2><hr color=red width=760>
			<a href=startsession.php><button>Go Back to Subject Selection Page</button></a></center>";
		goto end;
	}

//connect to database and save
	$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
	mysql_select_db($mysql_database, $bd) or die("Could not select database");
	$qry="UPDATE $FacID SET Timestamp='".$Timestamp."', SubStat='1', Q1='".$_POST['1']."', Q2='".$_POST['2']."', Q3='".$_POST['3']."', Q4='".$_POST['4']."', Q5='".$_POST['5']."', Q6='".$_POST['6']."', Q7='".$_POST['7']."', Q8='".$_POST['8']."', Q9='".$_POST['9']."', Q10='".$_POST['10']."', Q11='".$_POST['11']."', Q12='".$_POST['12']."', Q13='".$_POST['13']."', Q14='".$_POST['14']."', Q15='".$_POST['15']."', Q16='".$_POST['16']."', Q17='".$_POST['17']."', Q18='".$_POST['18']."', Q19='".$_POST['19']."', Q20='".$_POST['20']."',Q21='".$_POST['21']."' WHERE ClientIP='".$ClientIP."' AND Class='".$_SESSION['Class']."'";
	if(!mysql_query($qry,$bd)){
		die ("An unexpected error occured while saving the record, Please try again!");
	}
	
	echo "<title>Feedback Saved!</title>
	<center><img src=assets/coll_header.jpg><br>
	<img src=assets/fb_saved.jpg>
	<h2><font color=blue> Feedback</font> for ";echo $FacName;
	echo " has been<font color=green> saved</font>.</h2><hr color=green width=760>
	<a href=startsession.php><button>Go Back to Subject Selection Page</button></a></center>";
	end:
	?>
	</div>
