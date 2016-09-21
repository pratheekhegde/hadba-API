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
	
	
$Subject=getSubName(stripSubCode($Allocation));
$FacName=getFacName(stripFacEmpCode($Allocation));
$FacCode=strtolower(stripFacEmpCode($Allocation));
$ClientIP=HashString($_SERVER['REMOTE_ADDR']);
//echo $_SERVER['REMOTE_ADDR'];echo "<br>";
//echo $ClientIP;
//echo $Subject;
//echo $FacName;echo "<br>";
//echo $FacCode;

//Create a new table if the table doesn't exists
$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
	mysql_select_db($mysql_database, $bd) or die("Could not select database");
	if(mysql_num_rows(mysql_query("SHOW TABLES LIKE '".$FacCode."'"))==0){
		$query="CREATE TABLE $FacCode LIKE `table_dummyfac`";
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
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
<title>Feedback Form</title>
				<script src="pace/pace.js"></script>
				<link href="pace/pace-flash.css" rel="stylesheet" />
				<script type="text/javascript" src ="jquery-1.11.1.min.js"> </script>
				<!-- Latest compiled and minified CSS -->
				<link rel="stylesheet" href="bootstrap-3.3.2-dist/css/bootstrap.min.css">
				<!-- Customized CSS -->
				<!--<link rel="stylesheet" href="bootstrap-3.3.2-dist/css/custom.css">-->
				<!-- Optional theme -->
				<link rel="stylesheet" href="bootstrap-3.3.2-dist/css/bootstrap-theme.min.css">
				<!-- Latest compiled and minified JavaScript -->
				<script src="bootstrap-3.3.2-dist/js/bootstrap.min.js"></script>
	 <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="bootstrapForIE9/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="bootstrapForIE9/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	<!-- Favicons -->
	<link rel="icon" href="http://getbootstrap.com/favicon.ico">
	<link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">	
		<script type="text/javascript">
		$(function(){
				$("a").click(function(e) {
						e.preventDefault();
						var target = $(this).attr('href');   
						$('html, body').animate({ scrollTop : $(target).offset().top + "px"});    
					});
				
				//$("#comments").popover({'title':'Secret!','content': "Write what's is in your mind. Your identity will never be revealed. Promise.",'placement':'right','container': 'body','trigger': "focus"});

				 $('#submitFeedbackBtn').on('click', function () {
						var $btn = $(this).button('loading');
						// Submission Begins
						 var ques_not_answered = [];
						var NOERRORFLAG=1;//assume all questions are answered
							for(var i=1;i<=20;i++){
								if($('input[name='+i+']:checked').length<=0){//check if any of the radio buttons are checked for each question
									$('tr#q'+i).attr('class','bg-danger');//make those rows color red
									NOERRORFLAG=0;
									$('#quesNotAns').modal({backdrop: 'static',keyboard: false},'show');
								}else{
									$('tr#q'+i).removeAttr('class');//remove css 'coz it was answered this time
								}
							}
							if(NOERRORFLAG==1){
									//all answered submit feedback
									console.log('Now Submitting Form Data..');//questions are not answered,don't submit the form
									 $.ajax({
											url: 'submitfeedback.php',
											type: 'post',
											data: $('form#feedbackform').serialize(),
											success: function(data) {
													  // ... do something with the data...
													  $('#serverResponse').html(data);
													  $('#feedbackStatus').modal({backdrop: 'static',keyboard: false},'show');
													 }
										});
									
							}
							$btn.button('reset');
					})
		
		});
		//Not the right way to do this,but still it's working! That's all i want. ;-) [pTk]	
		</script>
	<style>
        body{
            padding-bottom: 70px;
        }
	.bs-docs-example {
		position: relative;
		padding: 15px;
		background-color: white;
		border: 1px solid #DDD;
		-webkit-border-radius: 4px;
		-moz-border-radius: 4px;
		border-radius: 4px;
		width: 768px;
	}
	textarea{
		resize:none;
		border:0;
		outline: none;
	}
</style>
</head>
<body>
<!-- Modals -->


<div id="quesNotAns" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
		<h4 class=\"modal-title \" id=\"myModalLabel2\">Feedback Submission Status</h4>      </div>
      <div class="modal-body text-center">
          <h3><b>You have to answer all the questions before submitting!</b></h3>
		<h1 style="color:red"><span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span></h1>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Okay, I Get It.</button>
      </div>
    </div>
  </div>
</div>
<div id="serverResponse"></div>
<!-- Container starts -->
<div class="container" id="top">
	<div class="row"> 
		<div class="col-md-12">
			<img src="assets/coll_header.jpg" class="center-block">
		</div>
	</div>
	<div class="bs-docs-example center-block">
	<div class="row"> 
		<div class="col-md-12 text-center">
		<u><b>Online Student Evaluation of Faculty</b></u>	
		</div>
	</div>
	<div class="row"> 
		<div class="col-md-12 center-block">
			<table class="" border="0" width="735">
			<tr>
				<td align=right width=100><big><span class="label label-primary">Faculty Name:</span></big></td><td width=400>&nbsp;<b><?php echo $FacName;?></b></td><td align=left><big><span class="label label-primary">Date:</span></big> <b><?php echo $date;?></td>
			</tr>
			<tr>
				<td align=right><big><span class="label label-primary">Subject:</span></big></td><td>&nbsp;<b><?php echo $Subject;?></b></td><td align=left><big><span class="label label-primary">Class:</span></big> <b><?php echo GetClassName($_SESSION['Class']);?></b></td>
			</tr>
			<tr><td colspan=3><hr color=black></td></tr>
			<tr><td colspan=3><b>Grading Marks:</b></td></tr>
			</table>
			<table width="735" border="1">
			<tr align=center><td>Strongly Disagree</td><td>Disagree</td><td>Neither Agree or Disagree</td><td>Agree</td><td>Strongly Agree</td></tr>
			<tr align=center><td>1</td><td>2</td><td>3</td><td>4</td><td>5</td></tr>
			</table>
		</div>
	</div>
	</div>
	<div class="row"> 
		<div class="col-md-6 col-md-offset-2">
		<table width="750">
			<tr><td><b><u>Note:</u></b><ul><li> Click on the appropriate circles to mark your answers.</li><li>All Questions are compulsory.</li>
			
			</ul></td>
			<td align="right"><a href="#bottom" class="btn btn-info" role="button">Go Down <span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span></a></td></tr>
		</table>
		</div>
	</div>
	<div class="row">
	<div class="col-md-2">
	<table height=""><tr><td valign="bottom">
	<div class="alert alert-info alert-dismissible" role="alert">
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					  <strong>Check all your marks before Submitting!</strong>
	</div>
	<div class="alert alert-danger alert-dismissible" role="alert">
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					  <strong>We're sorry, Comments are discontinued :(</strong>
	</div>
		<hr>
	  <p><h2><span class="glyphicon glyphicon-cog"></span> FFS<small><sup>v3</sup></small></h2><?php GetBuildInfo();?>
	  </p> </td></tr></table>
	  </div>
	 
	<div class="col-md-8" style="padding-left:5px;">
	<div class="bs-docs-example center-block">
						<form action="submitfeedback.php" method=post name="feedback" id="feedbackform">
					<input type=hidden name=FacID value="<?php echo $FacCode;?>">
					<table border=1 width="735" class="table-bordered table-hover"><tr><th align=left>Assessment about Teacher</th><th>5</th><th>4</th><th>3</th><th>2</th><th>1</th></tr>
					<tr id="q1"><td><ol><li>Is enthusiastic and seems to enjoy teaching.</td>
						<td	align=center><input type=radio name=1 value=5<?php ?>></td>
						<td	align=center><input type=radio name=1 value=4<?php ?>></td>
						<td	align=center><input type=radio name=1 value=3<?php ?>></td>
						<td	align=center><input type=radio name=1 value=2<?php ?>></td>
						<td	align=center><input type=radio name=1 value=1<?php ?>></td>
					</tr>
					<tr id="q2"><td><ol><li value=2>Objectives and plan of the course were specified clearly.</li></td>
						<td	align=center><input type=radio name=2 value=5<?php ?>></td>
						<td	align=center><input type=radio name=2 value=4<?php ?>></td>
						<td	align=center><input type=radio name=2 value=3<?php ?>></td>
						<td	align=center><input type=radio name=2 value=2<?php ?>></td>
						<td	align=center><input type=radio name=2 value=1<?php ?>></td>
					</tr>
					<tr id="q3"><td><ol><li value=3>Possesses good teaching skills and gives clear explanations.</li></td>
						<td	align=center><input type=radio name=3 value=5<?php ?>></td>
						<td	align=center><input type=radio name=3 value=4<?php ?>></td>
						<td	align=center><input type=radio name=3 value=3<?php ?>></td>
						<td	align=center><input type=radio name=3 value=2<?php ?>></td>
						<td	align=center><input type=radio name=3 value=1<?php ?>></td>
					</tr>
					<tr id="q4"><td><ol><li value=4>Possesses good communication skills.</li></td>
						<td	align=center><input type=radio name=4 value=5<?php ?>></td>
						<td	align=center><input type=radio name=4 value=4<?php ?>></td>
						<td	align=center><input type=radio name=4 value=3<?php ?>></td>
						<td	align=center><input type=radio name=4 value=2<?php ?>></td>
						<td	align=center><input type=radio name=4 value=1<?php ?>></td>
					</tr>
					<tr id="q5"><td><ol><li value=5>Has good knowledge of the subject and answers any questions.</li></td>
						<td	align=center><input type=radio name=5 value=5<?php ?>></td>
						<td	align=center><input type=radio name=5 value=4<?php ?>></td>
						<td	align=center><input type=radio name=5 value=3<?php ?>></td>
						<td	align=center><input type=radio name=5 value=2<?php ?>></td>
						<td	align=center><input type=radio name=5 value=1<?php ?>></td>
					</tr>
					<tr id="q6"><td><ol><li value=6>Comes prepared for the class and doesn’t get upset by questions.</li></td>
						<td	align=center><input type=radio name=6 value=5<?php ?>></td>
						<td	align=center><input type=radio name=6 value=4<?php ?>></td>
						<td	align=center><input type=radio name=6 value=3<?php ?>></td>
						<td	align=center><input type=radio name=6 value=2<?php ?>></td>
						<td	align=center><input type=radio name=6 value=1<?php ?>></td>
					</tr>
					<tr id="q7"><td><ol><li value=7>Motivates the students to learn more about the subject.</li></td>
						<td	align=center><input type=radio name=7 value=5<?php ?>></td>
						<td	align=center><input type=radio name=7 value=4<?php ?>></td>
						<td	align=center><input type=radio name=7 value=3<?php ?>></td>
						<td	align=center><input type=radio name=7 value=2<?php ?>></td>
						<td	align=center><input type=radio name=7 value=1<?php ?>></td>
					</tr>
					<tr id="q8"><td><ol><li value=8>Is quite audible in the class till the last row.</li></td>
						<td	align=center><input type=radio name=8 value=5<?php ?>></td>
						<td	align=center><input type=radio name=8 value=4<?php ?>></td>
						<td	align=center><input type=radio name=8 value=3<?php ?>></td>
						<td	align=center><input type=radio name=8 value=2<?php ?>></td>
						<td	align=center><input type=radio name=8 value=1<?php ?>></td>
					</tr>
					<tr id="q9"><td><ol><li value=9>Writes legibly on the board and it is visible till the last row.</li></td>
						<td	align=center><input type=radio name=9 value=5<?php ?>></td>
						<td	align=center><input type=radio name=9 value=4<?php ?>></td>
						<td	align=center><input type=radio name=9 value=3<?php ?>></td>
						<td	align=center><input type=radio name=9 value=2<?php ?>></td>
						<td	align=center><input type=radio name=9 value=1<?php ?>></td>
					</tr>
					<tr id="q10"><td><ol><li value=10>Has good control over the students during the class.</li></td>
						<td	align=center><input type=radio name=10 value=5<?php ?>></td>
						<td	align=center><input type=radio name=10 value=4<?php ?>></td>
						<td	align=center><input type=radio name=10 value=3<?php ?>></td>
						<td	align=center><input type=radio name=10 value=2<?php ?>></td>
						<td	align=center><input type=radio name=10 value=1<?php ?>></td>
					</tr>
					<tr id="q11"><td><ol><li value=11>Takes classes regularly and punctual to the classes.</li></td>
						<td	align=center><input type=radio name=11 value=5<?php ?>></td>
						<td	align=center><input type=radio name=11 value=4<?php ?>></td>
						<td	align=center><input type=radio name=11 value=3<?php ?>></td>
						<td	align=center><input type=radio name=11 value=2<?php ?>></td>
						<td	align=center><input type=radio name=11 value=1<?php ?>></td>
					</tr>
					<tr id="q12"><td><ol><li value=12>Makes proper use of teaching aids.</li></td>
						<td	align=center><input type=radio name=12 value=5<?php ?>></td>
						<td	align=center><input type=radio name=12 value=4<?php ?>></td>
						<td	align=center><input type=radio name=12 value=3<?php ?>></td>
						<td	align=center><input type=radio name=12 value=2<?php ?>></td>
						<td	align=center><input type=radio name=12 value=1<?php ?>></td>
					</tr>
					<tr id="q13"><td><ol><li value=13>Takes special care of weaker students and helps<br> them understand better.</li></td>
						<td	align=center><input type=radio name=13 value=5<?php ?>></td>
						<td	align=center><input type=radio name=13 value=4<?php ?>></td>
						<td	align=center><input type=radio name=13 value=3<?php ?>></td>
						<td	align=center><input type=radio name=13 value=2<?php ?>></td>
						<td	align=center><input type=radio name=13 value=1<?php ?>></td>
					</tr>
					<tr id="q14"><td><ol><li value=14>The coverage of the syllabus and depth of the course plan was excellent.</li></td>
						<td	align=center><input type=radio name=14 value=5<?php ?>></td>
						<td	align=center><input type=radio name=14 value=4<?php ?>></td>
						<td	align=center><input type=radio name=14 value=3<?php ?>></td>
						<td	align=center><input type=radio name=14 value=2<?php ?>></td>
						<td	align=center><input type=radio name=14 value=1<?php ?>></td>
					</tr>
					<tr id="q15"><td><ol><li value=15>Gives adequate assignments and discusses solutions in the class.</li></td>
						<td	align=center><input type=radio name=15 value=5<?php ?>></td>
						<td	align=center><input type=radio name=15 value=4<?php ?>></td>
						<td	align=center><input type=radio name=15 value=3<?php ?>></td>
						<td	align=center><input type=radio name=15 value=2<?php ?>></td>
						<td	align=center><input type=radio name=15 value=1<?php ?>></td>
					</tr>
					<tr id="q16"><td><ol><li value=16>Is fair and transparent in students evaluation<br>and provides effective feedback on test/examination performance.</li></td>
						<td	align=center><input type=radio name=16 value=5<?php ?>></td>
						<td	align=center><input type=radio name=16 value=4<?php ?>></td>
						<td	align=center><input type=radio name=16 value=3<?php ?>></td>
						<td	align=center><input type=radio name=16 value=2<?php ?>></td>
						<td	align=center><input type=radio name=16 value=1<?php ?>></td>
					</tr>
					<tr id="q17"><td><ol><li value=17>Provides notes or hand-outs to supplement the teaching.</li></td>
						<td	align=center><input type=radio name=17 value=5<?php ?>></td>
						<td	align=center><input type=radio name=17 value=4<?php ?>></td>
						<td	align=center><input type=radio name=17 value=3<?php ?>></td>
						<td	align=center><input type=radio name=17 value=2<?php ?>></td>
						<td	align=center><input type=radio name=17 value=1<?php ?>></td>
					</tr>
					<tr id="q18"><td><ol><li value=18>Is available and approachable after the class hours.</li></td>
						<td	align=center><input type=radio name=18 value=5<?php ?>></td>
						<td	align=center><input type=radio name=18 value=4<?php ?>></td>
						<td	align=center><input type=radio name=18 value=3<?php ?>></td>
						<td	align=center><input type=radio name=18 value=2<?php ?>></td>
						<td	align=center><input type=radio name=18 value=1<?php ?>></td>
					</tr>
					<tr id="q19"><td><ol><li value=19>Encourages students’ participation and interaction in the class.</li></td>
						<td	align=center><input type=radio name=19 value=5<?php ?>></td>
						<td	align=center><input type=radio name=19 value=4<?php ?>></td>
						<td	align=center><input type=radio name=19 value=3<?php ?>></td>
						<td	align=center><input type=radio name=19 value=2<?php ?>></td>
						<td	align=center><input type=radio name=19 value=1<?php ?>></td>
					</tr>
					<tr id="q20"><td><ol><li value=20>Overall , the learning process was enjoyable.</li></td>
						<td	align=center><input type=radio name=20 value=5></td>
						<td	align=center><input type=radio name=20 value=4></td>
						<td	align=center><input type=radio name=20 value=3<?php ?>></td>
						<td	align=center><input type=radio name=20 value=2<?php ?>></td>
						<td	align=center><input type=radio name=20 value=1<?php ?>></td>
					</tr>
					<!-- comments are discontinued //
					<tr><td colspan=6><b>COMMENTS, if any:</b><br><textarea id="comments" type="text" name=21 placeholder="(Up to 500 Characters)" maxlength="500" style="width: 735px; height: 100px;"></textarea></td></tr>
					-->
					</table><br>
					<table width="735">
					<tr><td align="left"><button class="btn btn-success" type="button" data-loading-text="Submitting..<i class='icon-spin icon-refresh icon-large'></i>" id="submitFeedbackBtn" autocomplete="off">Submit Feedback</button></td>
					<td align="right"><button type="button" data-toggle="tooltip" data-placement="right" title="Goto Subjects List Page" onclick="location.href='startsession.php'" class="btn btn-warning">Go Back</button>&nbsp;<a href="#top" class="btn btn-info" role="button">Go Up <span class="glyphicon glyphicon-menu-up" aria-hidden="true"></span></a></td></tr>
					</table>
					</form>					
		</div>
		<br>
		</div>
	</div>
	
</div>

<div id="bottom"></div>

 </body>
 </html>