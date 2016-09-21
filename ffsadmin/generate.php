<?php
require_once '../CoreLib.php';
session_start();
if(($_SESSION['LoginStatus']==0)||($_SESSION['LoginStatus']==NULL)){
header("location: index.php");
}
include '../assets/com.generate.php';
if(!($_POST['FacID'] || $_POST['Class'] || $_POST['Report'] || $_POST['ReportFormat'])){
header("location: ../error.php");
}
$Report=$_POST['Report'];
$Format=$_POST['ReportFormat'];
$FacID=strtolower($_POST['FacID']);
$FacName=GetFacName($_POST['FacID']);
$Class=$_POST['Class'];
$ClassName=GetClassName($Class);

//echo $Filename;
//echo $FacID;
//echo $Class;
if($Report=="All" && $Format=="csv"){
		$Filename=$FacName."-".$ClassName.".csv";
		$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
		mysql_select_db($mysql_database, $bd) or die("Could not select database");
		$qry="SELECT * FROM $FacID WHERE Class='".$Class."'";
		$result=mysql_query($qry);
		$num=mysql_num_rows($result);
		if($num==0){
			echo "No reports";
			header("location: LoadFac.php");
		}
		//$out = '';
		// Get all fields names in table from the database.
		$fields = mysql_list_fields($mysql_database,$FacID);
		// Count the table fields and put the value into $columns.
		$columns = mysql_num_fields($fields);
		//echo $columns;
	
		// Put the name of all fields to $out.
		$out='"Faculty ->","'.$FacName.'",';
		$out .="\n"; 
		$out.='"Class ->","'.$ClassName.'",';
		$out .="\n"; 
		$out.='"Timestamp","Q1","Q2","Q3","Q4","Q5","Q6","Q7","Q8","Q9","Q10","Q11","Q12","Q13","Q14","Q15","Q16","Q17","Q18","Q19","Q20","Q21"';
		$out .="\n"; 
	
		// Add all values in the table to $out.
		$numstud=0;//Number of entries
		while ($l = mysql_fetch_array($result)) {
			$numstud++;
			for ($i = 3; $i < $columns; $i++) {
				$out .='"'.$l["$i"].'",';
			}
			$out .="\n";
		}
		$out.='"Total Marks Column wise ->",';
		//finding column sums
		$TotalMarks=0;
		$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
		mysql_select_db($mysql_database, $bd) or die("Could not select database");
		for($i=1;$i<=20;$i++){
			$c="Q".$i;
			$result=mysql_query("SELECT SUM($c) AS colsum FROM $FacID WHERE Class='".$Class."'");
			while($row=mysql_fetch_assoc($result)){
				$out.='"'.$row['colsum'].'",';
				$TotalMarks+=$row['colsum'];
			}	
		}	
		$out .="\n";
		$Totalpercent=$TotalMarks/$numstud;
		$out.='"Total Students = '.$numstud.'",';$out .="\n";
		$out.='"Total Percentage = '.$Totalpercent.'%",';
		$out .="\n";
		//echo $out;
		//echo "total marks =".$TotalMarks;echo "<br>";
		//echo "Total students =".$numstud;echo "<br>";
		//echo $Totalpercent."%";
		//Open file export.csv.
		$f = fopen ("./reports/".$Filename."",'w');

		// Put all values from $out to csv.
		fputs($f, $out);
		fclose($f);
		header("Cache-control: private");
		header('Content-type: application/force-download');
		header("Content-transfer-encoding: binary\n");
		header('Content-Disposition: attachment; filename="'.$Filename.'"');
		readfile("./reports/".$Filename.""); 
		
}else if($Report=="Comments" && $Format=="csv"){ 
		$Filename=$FacName."-".$ClassName."- Comments.csv";
		$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
		mysql_select_db($mysql_database, $bd) or die("Could not select database");
		$qry="SELECT * FROM $FacID WHERE Class='".$Class."'";
		$result=mysql_query($qry);
		$num=mysql_num_rows($result);
		if($num==0){
			echo "No reports";
			header("location: LoadFac.php");
		}
		//$out = '';
		// Get all fields names in table from the database.
		$fields = mysql_list_fields($mysql_database,$FacID);
		// Count the table fields and put the value into $columns.
		$columns = mysql_num_fields($fields);
		//echo $columns;
	
		// Put the name of all fields to $out.
		$out='"Faculty ->","'.$FacName.'",';
		$out .="\n"; 
		$out.='"Class ->","'.$ClassName.'",';
		$out .="\n"; 
		$out.='"Timestamp","Comments"';
		$out .="\n"; 
		// Add only comments from the table to $out.
		$numstud=0;//Number of entries
		while ($l = mysql_fetch_array($result)) {
			$numstud++;
			for ($i = 3; $i <= $columns; $i++) {
				if($i==3 || $i==24){
					$out .='"'.$l["$i"].'",';
				}
			}
			$out .="\n";
		}
		$out.='"Total Students = '.$numstud.'",';
		$out .="\n";
		$f = fopen ("./reports/".$Filename."",'w');

		// Put all values from $out to csv.
		fputs($f, $out);
		fclose($f);
		header("Cache-control: private");
		header('Content-type: application/force-download');
		header("Content-transfer-encoding: binary\n");
		header('Content-Disposition: attachment; filename="'.$Filename.'"');
		readfile("./reports/".$Filename.""); 
	

}
end: 
exit;    
?>