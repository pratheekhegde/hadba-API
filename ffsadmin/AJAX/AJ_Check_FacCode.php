<?php 
		require_once '../../CoreLib.php';
		session_start();
		//Check for Login Flags
		if(($_SESSION['LoginStatus']==0)||($_SESSION['LoginStatus']==NULL)){
		header("location: ./index.php");
		}
		//Second Layer Of Checking For Empty FacCode Submission!
		if(!$_GET['FacCode']){
			header("location: ../../error.php");
			exit();
		}
		$inputFac_Code=strtoupper($_GET['FacCode']);
		
		$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
		mysql_select_db($mysql_database, $bd) or die("Could not select database");
		$qry="SELECT * FROM `table_data` WHERE ID='".$inputFac_Code."'";
		$result=mysql_query($qry);
	 
		if($result) {
			if(mysql_num_rows($result) > 0) {
				//FacCode In Use
				$row=mysql_fetch_assoc($result);
				$output['Status']="No";
				$output['FacName']=$row['Data1'];
				$output['FacDep']=$row['Data2'];
				$output['FacCode']=$row['ID'];
				echo json_encode($output,JSON_PRETTY_PRINT); 
		
		}else{
				//FacCode Not in Use
				$output['Status']="Yes";
				echo json_encode($output,JSON_PRETTY_PRINT); 
				
			}
		}else {
			die("Query failed");
		}
?>