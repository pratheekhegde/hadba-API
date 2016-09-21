<style>
body{
	background-repeat:no-repeat;
	background-position:center;
	background-attachment:fixed;
	background-size:cover;
	-o-background-size:cover;
	-webkit-background-size:cover;
	background-image:url(assets/fbimage.jpg);
}
button{
	font-family:"Segoe UI";
	font-size:30px;
	border-radius:1px;
	text-decoration:none;
	color:blue;
	border-color:black;
	background-color:white;
}
</style>
<title>Online Student Faculty Feedback</title>
<?php 
require_once './CoreLib.php';
$end=0;
if($_GET['e']!=NULL)$end=$_GET['e'];
//connect to database
	$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
	mysql_select_db($mysql_database, $bd) or die("Could not select database");
	$qry="SELECT * FROM `table_data` WHERE ID='Startup'";
	$res=mysql_query($qry);
	if(!mysql_query($qry,$bd)){
		die ("An unexpected error occured while saving the record, Please try again!");
	}
	$Startup=mysql_fetch_assoc($res);
	$status=$Startup['Data1'];
?>
<body><center>
<table height=450 border=0>
<div id=status></div>
<?php 
	if($end==0){
		if($status==0){
		//echo "status 0";
			echo "<tr height=250><td></td></tr><tr height=150><td>";
			echo "<center><img src=assets/index_wait.png><br><img src=assets/progress.gif height=50><center>";
		}else{
		//status=1
			echo "<tr height=360><td></td></tr><tr><td>";
			echo "<center><img src=assets/index_ready.png><br><br>";
			echo "<a href=startsession.php><button>Start Feedback</button></a></center>";
		}
	}else{
			echo "<tr height=330><td></td></tr><tr><td>";
			echo "<br><br><br><center><img src=assets/sessend.png>";
	}
	?>
	</td></tr></table></center><br><br>
<center><img src=assets/footer.png></center>