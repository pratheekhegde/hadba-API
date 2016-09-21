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
	border-radius:1px;
	text-decoration:none;
	color:blue;
	border-color:black;
	background-color:white;
}
</style>
<title>Online Student Faculty Feedback</title>
<script type="text/javascript" src ="jquery-1.11.1.min.js"> </script>
<script type="text/javascript">
	 setInterval(CheckStartup,5000);
	 function CheckStartup(){
		 $.get("phpAJAXHandler.php",{ "ID":"startup" },function(data){
														var startup=data;
														console.log(data.Data1);
														$("#status").html(data.Data1);
														alert(data.Data1);
														});
	}
	
</script></head>
<body>
<div id="status"><img src=assets/progress.gif></div>