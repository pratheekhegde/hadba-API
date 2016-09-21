<?php 
require_once './CoreLib.php';
session_start();
$Class=$_SESSION['Class'];
date_default_timezone_set('Asia/Kolkata');
$date=date('d-m-Y');
$Allocation=$_POST['AllocID'];
if($Allocation==NULL){
	header("location: error.php");
	exit();
}else if($Allocation=="none"){
	header("location: startsession.php");
	exit();
}
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
	if($status==0) header("location: index.php?e=1");
	
	
$Subject=GetSubName(StripSubCode($Allocation));
$FacName=GetFacName(StripFacCode($Allocation));
$FacCode=strtolower(StripFacCode($Allocation));
$ClientIP=HashString($_SERVER['REMOTE_ADDR']);
echo $_SERVER['REMOTE_ADDR'];echo "<br>";
echo $ClientIP;
//echo $Subject;
//echo $FacName;echo "<br>";
//echo $FacCode;

//Create a new table if the table doesn't exists
$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
	mysql_select_db($mysql_database, $bd) or die("Could not select database");
	if(mysql_num_rows(mysql_query("SHOW TABLES LIKE '".$FacCode."'"))==0){
		$query="CREATE TABLE $FacCode LIKE `dummy`";
		//$res=mysql_query($query);
		if(!mysql_query($query)){
			die ("An unexpected error occured while creating the new table");
		}
	}

	//echo "Create new entry for the IP";
	$qry="SELECT * FROM $FacCode WHERE ClientIP='".$ClientIP."' AND Class='".$_SESSION['Class']."'";
	$res=mysql_query($qry);
	$num=mysql_num_rows($res);
	//echo $num;echo "<br>";
	if(!($num>0)){
		//echo "inside if";
		$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
		mysql_select_db($mysql_database, $bd) or die("Could not select database");
		$qry="INSERT INTO $FacCode SET ClientIP='".$ClientIP."', Class='".$_SESSION['Class']."'";
		$res=mysql_query($qry);
	}
?>
<head>
<!-- It's nice, you wanna see the code. Okay, check it out. Call us, we'll it explain if you want! -->
<script src="pace/pace.js"></script>
<link href="pace/pace-flash.css" rel="stylesheet" />
<style>
#submitfeedback,#goback{
	color: black;
	border: 1px solid;
	font-weight: bold;
}
#submitfeedback:hover{
	background: #06D206;
	color: white;
}
#goback:hover{
	background: orange;
	color: white;
}
textarea{
	resize:none;
	border:0;
	outline: none;
}
table{
	border-width: thin;
	border-style: none;
	border-spacing: 1px;
	border-color: black;
	border-collapse: collapse;
}
</style>
<title>Feedback Form</title>
</head>
<body>
<center><img src=assets/coll_header.jpg></center><br>
<DIV STYLE="font-family: 'Calibri';">
<center><u><b>Online Student Evaluation of Faculty</b></u></center>
<center><table width=760 border=0>
	<tr>
		<td align=right width=100>Faculty Name:</td><td width=450>&nbsp;<b><?php echo $FacName;?></b></td><td align=left>Date: <b><?php echo $date;?></td>
	</tr>
	<tr>
		<td align=right width=100>Subject:</td><td width=450>&nbsp;<b><?php echo $Subject;?></b></td><td align=left>Class: <b><?php echo GetClassName($_SESSION['Class']);?></b></td>
	</tr>
	<tr><td colspan=3><hr color=black></td></tr>
	<tr><td colspan=3>Grading Marks:</td></tr>
</table>
<table width=760 border=1>
<tr align=center><td>Strongly Agree</td><td>Agree</td><td>Neither Agree or Disagree</td><td>Disagree</td><td>Strongly Disagree</td></tr>
<tr align=center><td>5</td><td>4</td><td>3</td><td>2</td><td>1</td></tr>
</table>
<table width=760><tr><td><b><u>Note:</u></b><ul><li> Click on the appropriate circles to mark your answers.</li><li>All Questions are compulsory except the Comments.</li>
												<li> <b>Feel free to comment, we promise you that your Identity will remain undisclosed.</b></ul></td></tr>
</table>
<form action="submitfeedback.php" method=post name="feedback" id="feedbackform">
<input type=hidden name=FacID value="<?php echo $FacCode;?>">
<table width=760 border=1><tr><th align=left>Assessment about Teacher</th><th>5</th><th>4</th><th>3</th><th>2</th><th>1</th></tr>
<tr id="q1"><td><ol><li>Follows the course handout closely in all respects and completes<br>syllabus in time.</td>
	<td	align=center><input type=radio name=1 value=5<?php ?>></td>
	<td	align=center><input type=radio name=1 value=4<?php ?>></td>
	<td	align=center><input type=radio name=1 value=3<?php ?>></td>
	<td	align=center><input type=radio name=1 value=2<?php ?>></td>
	<td	align=center><input type=radio name=1 value=1<?php ?>></td>
</tr>
<tr id="q2"><td><ol><li value=2>Uses class time well and takes classes regularly.</li></td>
	<td	align=center><input type=radio name=2 value=5<?php ?>></td>
	<td	align=center><input type=radio name=2 value=4<?php ?>></td>
	<td	align=center><input type=radio name=2 value=3<?php ?>></td>
	<td	align=center><input type=radio name=2 value=2<?php ?>></td>
	<td	align=center><input type=radio name=2 value=1<?php ?>></td>
</tr>
<tr id="q3"><td><ol><li value=3>Seems well prepared for each class and clearly explains structure,<br>objectives and requirements of the course.</li></td>
	<td	align=center><input type=radio name=3 value=5<?php ?>></td>
	<td	align=center><input type=radio name=3 value=4<?php ?>></td>
	<td	align=center><input type=radio name=3 value=3<?php ?>></td>
	<td	align=center><input type=radio name=3 value=2<?php ?>></td>
	<td	align=center><input type=radio name=3 value=1<?php ?>></td>
</tr>
<tr id="q4"><td><ol><li value=4>Takes extra class whenever necessary.</li></td>
	<td	align=center><input type=radio name=4 value=5<?php ?>></td>
	<td	align=center><input type=radio name=4 value=4<?php ?>></td>
	<td	align=center><input type=radio name=4 value=3<?php ?>></td>
	<td	align=center><input type=radio name=4 value=2<?php ?>></td>
	<td	align=center><input type=radio name=4 value=1<?php ?>></td>
</tr>
<tr id="q5"><td><ol><li value=5>Possesses effective communication skills and gives clear<br>explanations.</li></td>
	<td	align=center><input type=radio name=5 value=5<?php ?>></td>
	<td	align=center><input type=radio name=5 value=4<?php ?>></td>
	<td	align=center><input type=radio name=5 value=3<?php ?>></td>
	<td	align=center><input type=radio name=5 value=2<?php ?>></td>
	<td	align=center><input type=radio name=5 value=1<?php ?>></td>
</tr>
<tr id="q6"><td><ol><li value=6>Has good command over the subject matter and is not confused by<br>unexpected questions.</li></td>
	<td	align=center><input type=radio name=6 value=5<?php ?>></td>
	<td	align=center><input type=radio name=6 value=4<?php ?>></td>
	<td	align=center><input type=radio name=6 value=3<?php ?>></td>
	<td	align=center><input type=radio name=6 value=2<?php ?>></td>
	<td	align=center><input type=radio name=6 value=1<?php ?>></td>
</tr>
<tr id="q7"><td><ol><li value=7>Stresses important points in lectures, discussions and touches<br>upon the relevant practical field applications.</li></td>
	<td	align=center><input type=radio name=7 value=5<?php ?>></td>
	<td	align=center><input type=radio name=7 value=4<?php ?>></td>
	<td	align=center><input type=radio name=7 value=3<?php ?>></td>
	<td	align=center><input type=radio name=7 value=2<?php ?>></td>
	<td	align=center><input type=radio name=7 value=1<?php ?>></td>
</tr>
<tr id="q8"><td><ol><li value=8>Is enthusiastic, confident and seems to enjoy teaching.</li></td>
	<td	align=center><input type=radio name=8 value=5<?php ?>></td>
	<td	align=center><input type=radio name=8 value=4<?php ?>></td>
	<td	align=center><input type=radio name=8 value=3<?php ?>></td>
	<td	align=center><input type=radio name=8 value=2<?php ?>></td>
	<td	align=center><input type=radio name=8 value=1<?php ?>></td>
</tr>
<tr id="q9"><td><ol><li value=9>Is skilful in observing students reactions and understands the<br>students' difficulties with coursework.</li></td>
	<td	align=center><input type=radio name=9 value=5<?php ?>></td>
	<td	align=center><input type=radio name=9 value=4<?php ?>></td>
	<td	align=center><input type=radio name=9 value=3<?php ?>></td>
	<td	align=center><input type=radio name=9 value=2<?php ?>></td>
	<td	align=center><input type=radio name=9 value=1<?php ?>></td>
</tr>
<tr id="q10"><td><ol><li value=10>Presents subject matter in logical way and makes good use of<br> examples.</li></td>
	<td	align=center><input type=radio name=10 value=5<?php ?>></td>
	<td	align=center><input type=radio name=10 value=4<?php ?>></td>
	<td	align=center><input type=radio name=10 value=3<?php ?>></td>
	<td	align=center><input type=radio name=10 value=2<?php ?>></td>
	<td	align=center><input type=radio name=10 value=1<?php ?>></td>
</tr>
<tr id="q11"><td><ol><li value=11>Makes proper use of teaching aids (black board/LCD/OHP/models etc.).</li></td>
	<td	align=center><input type=radio name=11 value=5<?php ?>></td>
	<td	align=center><input type=radio name=11 value=4<?php ?>></td>
	<td	align=center><input type=radio name=11 value=3<?php ?>></td>
	<td	align=center><input type=radio name=11 value=2<?php ?>></td>
	<td	align=center><input type=radio name=11 value=1<?php ?>></td>
</tr>
<tr id="q12"><td><ol><li value=12>Is friendly, flexible and maintains an atmosphere of good feelings in a<br> class.</li></td>
	<td	align=center><input type=radio name=12 value=5<?php ?>></td>
	<td	align=center><input type=radio name=12 value=4<?php ?>></td>
	<td	align=center><input type=radio name=12 value=3<?php ?>></td>
	<td	align=center><input type=radio name=12 value=2<?php ?>></td>
	<td	align=center><input type=radio name=12 value=1<?php ?>></td>
</tr>
<tr id="q13"><td><ol><li value=13>Acknowledges all questions in a non-threatening way, encourages<br>active participation and stimulates discussion.</li></td>
	<td	align=center><input type=radio name=13 value=5<?php ?>></td>
	<td	align=center><input type=radio name=13 value=4<?php ?>></td>
	<td	align=center><input type=radio name=13 value=3<?php ?>></td>
	<td	align=center><input type=radio name=13 value=2<?php ?>></td>
	<td	align=center><input type=radio name=13 value=1<?php ?>></td>
</tr>
<tr id="q14"><td><ol><li value=14>Treats students with respect, encourages constructive criticism and<br>motivates them to learn more about the subject.</li></td>
	<td	align=center><input type=radio name=14 value=5<?php ?>></td>
	<td	align=center><input type=radio name=14 value=4<?php ?>></td>
	<td	align=center><input type=radio name=14 value=3<?php ?>></td>
	<td	align=center><input type=radio name=14 value=2<?php ?>></td>
	<td	align=center><input type=radio name=14 value=1<?php ?>></td>
</tr>
<tr id="q15"><td><ol><li value=15>Is available, accessible and approachable.</li></td>
	<td	align=center><input type=radio name=15 value=5<?php ?>></td>
	<td	align=center><input type=radio name=15 value=4<?php ?>></td>
	<td	align=center><input type=radio name=15 value=3<?php ?>></td>
	<td	align=center><input type=radio name=15 value=2<?php ?>></td>
	<td	align=center><input type=radio name=15 value=1<?php ?>></td>
</tr>
<tr id="q16"><td><ol><li value=16>Writes legibly and quite audible in the class.</li></td>
	<td	align=center><input type=radio name=16 value=5<?php ?>></td>
	<td	align=center><input type=radio name=16 value=4<?php ?>></td>
	<td	align=center><input type=radio name=16 value=3<?php ?>></td>
	<td	align=center><input type=radio name=16 value=2<?php ?>></td>
	<td	align=center><input type=radio name=16 value=1<?php ?>></td>
</tr>
<tr id="q17"><td><ol><li value=17>Is fair and objective in assessments of students' work and<br>entertains recheck request from the students.</li></td>
	<td	align=center><input type=radio name=17 value=5<?php ?>></td>
	<td	align=center><input type=radio name=17 value=4<?php ?>></td>
	<td	align=center><input type=radio name=17 value=3<?php ?>></td>
	<td	align=center><input type=radio name=17 value=2<?php ?>></td>
	<td	align=center><input type=radio name=17 value=1<?php ?>></td>
</tr>
<tr id="q18"><td><ol><li value=18>Suggests specific ways for students to improve and keeps students<br>informed of their progress.</li></td>
	<td	align=center><input type=radio name=18 value=5<?php ?>></td>
	<td	align=center><input type=radio name=18 value=4<?php ?>></td>
	<td	align=center><input type=radio name=18 value=3<?php ?>></td>
	<td	align=center><input type=radio name=18 value=2<?php ?>></td>
	<td	align=center><input type=radio name=18 value=1<?php ?>></td>
</tr>
<tr id="q19"><td><ol><li value=19>Tries to readjust his teaching technique if the class does't follow him.</li></td>
	<td	align=center><input type=radio name=19 value=5<?php ?>></td>
	<td	align=center><input type=radio name=19 value=4<?php ?>></td>
	<td	align=center><input type=radio name=19 value=3<?php ?>></td>
	<td	align=center><input type=radio name=19 value=2<?php ?>></td>
	<td	align=center><input type=radio name=19 value=1<?php ?>></td>
</tr>
<tr id="q20"><td><ol><li value=20>The overall learning process in the subject was useful and<br>enjoyable.</li></td>
	<td	align=center><input type=radio name=20 value=5></td>
	<td	align=center><input type=radio name=20 value=4></td>
	<td	align=center><input type=radio name=20 value=3<?php ?>></td>
	<td	align=center><input type=radio name=20 value=2<?php ?>></td>
	<td	align=center><input type=radio name=20 value=1<?php ?>></td>
</tr>
<tr><td colspan=6><b>COMMENTS, if any:</b><br><textarea type="text" name=21 placeholder="(Up to 500 Characters)" maxlength="500" style="width: 760px; height: 100px;"></textarea></td></tr>
</table>
<div id="invalidation_msg"></div>
<table width=760><tr><td width=380><hr color=green></td><td><hr color=red></tr>
<tr><td align=left><input type="submit" id="submitfeedback" value="Submit Feedback"></td><td align=right rowspan=2><input type="button" id="goback" value="Go Back To Subject Selection Page"></td></tr>
</table>
</form>
<?php GetBuildInfo();?>
</center>
</div>
<script type="text/javascript" src ="jquery-1.11.1.min.js"> </script>
<script src="jquery.hotkeys.extended.js"></script>
<script type="text/javascript">
$(function(){$(document).hotkeys('p', 't', 'k', function (){alert(atob("WWVzIEkgTG92ZSBTYW5rdXNoYSE="));});//from here JS Starts :-p
		$('#invalidation_msg').hide();		
		$("#goback").click(function(){
			window.location.href="startsession.php";
		});
		$("#feedbackform").submit(function( event ) {
		  //event.preventDefault();//disable default form submit
		  var ques_not_answered = [];
		  var NOERRORFLAG=1;//assume all questions are answered
		  for(var i=1;i<=20;i++){
		  	if($('input[name='+i+']:checked').length<=0){//check if any of the radio buttons are checked for each question
		  		$('tr#q'+i).css({'background-color': 'red','color':'white','border-color':'white'});//make those rows color red
				NOERRORFLAG=0;
				$('#invalidation_msg').html("<hr color=red width=760><table width=760><tr bgcolor=#ff000><td align=center><font color=white size=5>Please Answer All The Required Questions!</font></td></tr></table>").slideDown(400);
		  	}else{
		  		$('tr#q'+i).removeAttr('style');//remove css 'coz it was answered this time
				$('#invalidation_msg').slideUp();
		  	}
		  }
		  if(NOERRORFLAG==0)return false;//questions are not answered,don't submit the form
		  $('#invalidation_msg').slideUp();
		});	
});
//Not the right way to do this,but still it's working! That's all i want. ;-) [pTk]	
</script>