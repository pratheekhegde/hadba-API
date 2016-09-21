<?php 
		require_once '../../CoreLib.php';
		session_start();
		//Check for Login Flags
		if(($_SESSION['LoginStatus']==0)||($_SESSION['LoginStatus']==NULL)){
		header("location: ./index.php");
		}
		//Second Layer Of Checking For Empty FacCode Submission!
		if(!$_POST['FacCode'] ||!$_POST['FacName'] ||!$_POST['Dep']){
			header("location: ../../error.php");
			exit();
		}
		$FacCode = $_POST['FacCode'];
		$FacName = $_POST['FacName'];
		$Dep = $_POST['Dep'];
		$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
		mysql_select_db($mysql_database, $bd) or die("Could not select database");
		$query="INSERT INTO `table_data` SET ID='".$FacCode."',Data1='".$FacName."', Data2='".$Dep."'";
		if(!mysql_query($query,$bd)){
			die ("<b>Looks like something went wrong while saving, Please Try again!</b>");
		}else{
			echo "<b>".$FacName."</b> has been added with Fac Code <b>".$FacCode."</b>.";
		}
?>