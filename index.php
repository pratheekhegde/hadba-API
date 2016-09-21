<head><style>

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
	border: 1px solid black;
	color:blue;
	
}
button:hover{
	background-color:#06D206;
	border: 2px solid;
	color: white;
}
</style>
 <script src="pace/pace.js"></script>
 <link href="pace/pace-flash.css" rel="stylesheet" />
<title>Online Student Faculty Feedback</title></head>
<?php
$end=0;
if($_GET['e']!=NULL)$end=$_GET['e'];
?>
<script type="text/javascript" src ="jquery-1.11.1.min.js"> </script>
<script type="text/javascript">
	 setInterval(CheckStartup,5000);
	 function CheckStartup(){
		 $.get("phpAJAXHandler.php",{ "ID":"startup" },function(data){
															var startup=data;
															console.log(data.Data1);
															if(data.Data1==1){	
																$("#status").fadeOut("slow");
																$("#status").html("<table height=450 border=0><tr height=290><td></td></tr><tr><td><center><img src=assets/index_ready.png><br><br><a href=startsession.php><button>Start Feedback</button></a></center>").fadeIn();
															}
															
														});
	}
	
</script></head>
<body>
<center>
<?php 
	if($end==0){
		echo "<div id=status><table height=450 border=0><tr height=250><td></td></tr><tr height=150>";
		echo "<td><center><img src=assets/index_wait.png height=80><img src=assets/progress.gif height=85><center></div>";
		//echo "<div id=status></div>";
	}else{
			echo "<table height=450 border=0><tr height=250><td></td></tr><tr><td>";
			echo "<br><br><br><center><img src=assets/sessend.png>";
	}
	?>
	</td></tr></table></center>
<center><img src=assets/footer.png><br>
</center>
</body>