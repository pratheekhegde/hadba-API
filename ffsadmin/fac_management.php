<head><title>AP - Faculty Management</title>
<style>
fieldset{
	border-color:black;
}
button#depbutton,#startFB,#Logout,#normal{
	font-family: "Lucida Sans";
		border: 1 solid;
}
button#depbutton:hover{
	 background-color: white;
		color:#FC8505;
		font-size: 14;
		border: 2 solid;
}
button#startFB:hover{
	 background: #06D206;
	 color: white;
}
#Logout:hover{
	 background: red;
	 color: white;
}
</style>
<script type="text/javascript" src ="jquery-1.11.1.min.js"> </script>
<script type="text/javascript">
	
	$(function(){
		//On Key Down Event for Validating the typed Faculty Code
		$("#FacCode").keyup(function (){
							var Fac_Code=$("#FacCode").val();
							if($("#FacCode").val().length == 4){Check_FacCode();}
		});		
		

		function Check_FacCode(){
				var Fac_Code=$("#FacCode").val().toUpperCase();
			if($("#FacName").val().length>=6){
					 $.get("AJAX/AJ_Check_FacCode.php",{ "FacCode":Fac_Code},function(data){
					 										data = JSON.parse(data);
					 										console.info("FacCode Check-Status = "+data.Status);
					 										if(data.Status =="No"){
					 											$("#FacCode_Status").fadeOut();
					 											$("#FacCode_Status").css({"border-color":"red"});
					 											var str = "<b><font color=red>Sorry,</font><small> "+ data.FacCode + " </b>is Not Available!";
					 											str+= "<br>It's Already assigned to <br><b>"+data.FacName+"</b>.</small><br> <img src=\"../assets/not.png\" width=25>";
					 											$("#FacCode_Status").html(str).fadeIn();
					 											$("#add_fac").attr('disabled','disabled');
					 										}else if(data.Status == "Yes"){
					 											var new_Fac = $("#FacName").val();
					 											$("#FacCode_Status").fadeOut();
					 											$("#FacCode_Status").css({"border-color":"#06D206"});
					 											var str = "<b>"+Fac_Code+ " </b><small>is Available!<br>for <b>"+new_Fac+"</b></small><br><img src=\"../assets/done.png\" width=25>";
					 											$("#FacCode_Status").html(str).fadeIn();
					 											$("#add_fac").removeAttr('disabled');
															}
														});
					}

		}

		//Adding a new Faculty
		$("#add_fac_form").submit(function( event ) {
		  if($("#FacName").val().length==0 || $("#FacCode").val().length==0) return false;
		  else{
		  		var Dep = $("#Dep").val();
		  		var FacName = $("#FacName").val();
		  		var FacCode = $("#FacCode").val().toUpperCase();
		  		 $.ajax({
						type:"POST",
						url:"AJAX/AJ_Add_Fac_DB.php",
						data:{"FacName":FacName,"FacCode":FacCode,"Dep":Dep},
						success:function(data,textStatus){
							alert("done");
							$("#Add_Status").html(data).slideDown();
						}
					});
		  		 return true;
		  }
		});	
	});
</script>
</head><body><center>
<DIV STYLE="font-family: 'Lucida Sans';">
<center><img src="../assets/coll_header.jpg">
<a href="home.php"><h1>ADMIN PANEL</h1></a>
<form action="adminlogout.php" method="post">
<input type=hidden name=val value="logout">
<input type=submit value=Logout id="Logout"></form>
</center>
<table border="0" rules="cols" width=800><tr><td><fieldset><legend>Add a Faculty</legend><form id="add_fac_form">
	<center><table border="1">
		<tr><td align="right" width="200"><label><strong>Faculty Name:</strong></label></td><td align="left"><input type="text" id="FacName" name="FacName" maxlength="30"><br><small><strong><font color="red">(Full Name With Designation)</font></strong></small></td>
						<td rowspan="3" valign="top"><strong><label>Faculty Code: </label></strong><input type="text" size="3" maxlength="4" id="FacCode" name="FacCode"><small><strong><font color="green"> (Unique Faculty Code)</font></strong></small>
																					<hr color=black style="height:1px;border:0"><div id="FacCode_Status" align="center" style="border:1px solid;display:none"></div></td></tr>
					 <tr><td align="right"><label><strong>Department:</strong></label></td><td align="left"><select name="Dep" id="Dep">
					 																				<option value="BS">Basic Science</option>
					 																				<option value="CS">C.S.E</option>
																									<option value="EC">E.C.E</option>
																									<option value="ME">M.E</option>
																									<option Value="CV">Civ.E</option>
																									</select></td></tr>
					<tr><td colspan="2" align="right"><input type="submit" value="Add Faculty" id="add_fac" disabled></td></tr>
					<tr><td colspan="3" align="center"></td><div id="Add_Status" style="display:none"></div></tr>
</table></center></form>
</fieldset>
</td></tr></table>
</body>
<?php 
	require_once '../CoreLib.php';
	$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
	mysql_select_db($mysql_database, $bd) or die("Could not select database");
	$query="select * from `table_data` limit 29,999999999999999999";
	$result=mysql_query($query);
	if(!mysql_query($query,$bd)){
		die ("<h3>Looks like something went wrong while saving, Please Try again!</h3>");
	}
	while($row=mysql_fetch_assoc($result)){
		echo $row['ID'];
		echo $row['Data1'];
		echo $row['Data2'];
		echo $row['Data3'];echo "<br>";
	}


?>