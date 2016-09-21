<?php 
/* All the core functions and configurations are listed here.
author:pTk
All the mapings were done manually.
The next revision would include automated mapping.
==========================================
*/
//Database connections.
$mysql_hostname = "localhost"; //hostname of the machine
$mysql_user = "root";		//sql login user name
$mysql_password = "";		//sql login password
$mysql_database = "ffs";		//name of the main sql database

// TO HASH string with the crypt function
function HashString($str){
		return(md5($str));
}
//Function to get class name
function GetClassName($classcode){
	switch($classcode){
		case "Class1A": return("1st Year A Section");
				break;
		case "Class1B": return("1st Year B Section");
				break;
		case "Class1C": return("1st Year C Section");
				break;
		case "Class1D": return("1st Year D Section");
				break;
		case "Class1E": return("1st Year E Section");
				break;
		case "Class1F": return("1st Year F Section");
				break;
		case "Class1G": return("1st Year G Section");
				break;		
		case "Class2A": return("2nd Year C.S.E A Section");
				break;
		case "Class2B": return("2nd Year C.S.E B Section");
				break;
		case "Class2C": return("2nd Year E.C.E A Section");
				break;
		case "Class2D": return("2nd Year E.C.E B Section");
				break;
		case "Class2E": return("2nd Year M.E A Section");
				break;
		case "Class2F": return("2nd Year M.E B Section");
				break;
		case "Class2G": return("2nd Year Civ.E A Section");
				break;
		case "Class3A": return("3rd Year C.S.E A Section");
				break;
		case "Class3B": return("3rd Year C.S.E B Section");
				break;
		case "Class3C": return("3rd Year E.C.E A Section");
				break;
		case "Class3D": return("3rd Year E.C.E B Section");
				break;
		case "Class3E": return("3rd Year M.E A Section");
				break;
		case "Class3F": return("3rd Year M.E B Section");
				break;
		case "Class3G": return("3rd Year Civ.E A Section");
				break;
		case "Class4A": return("4th Year C.S.E A Section");
				break;
		case "Class4B": return("4th Year C.S.E B Section");
				break;
		case "Class4C": return("4th Year E.C.E A Section");
				break;
		case "Class4D": return("4th Year E.C.E B Section");
				break;
		case "Class4E": return("4th Year M.E A Section");
				break;
		case "Class4F": return("4th Year M.E B Section");
				break;
		case "Class4G": return("4th Year Civ.E A Section");
				break;
		default:return("Class Code not defined");
	}
}
		
 
//Function to Return faculty name from the faculty code.
function GetFacName($FacCode){
	global $mysql_hostname,$mysql_user,$mysql_password,$mysql_database;
	 //connect to database
	$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
	mysql_select_db($mysql_database, $bd) or die("Could not select database");
	//Request Allocation data from the table.
	$query="SELECT * FROM `table_data` WHERE ID='$FacCode'";
	$QueryResult=mysql_query($query);
	$Array = mysql_fetch_assoc($QueryResult);
	return $Array['Data1'];
}

//Function to Return Subject name from the Sub code.
function GetSubName($SubCode){
	$BaseCode=$SubCode[0].$SubCode[1];
	$Sem=$SubCode[2];
	if($BaseCode=='MA'){
		if($SubCode==MAT1){
			return("Engineering Mathematics 1");
		}else if($SubCode==MAT2){
			return("Engineering Mathematics 2");
		}else if($SubCode==MAT3){
			return("Engineering Mathematics 3");
		}else if($SubCode==MAT4){
			return("Engineering Mathematics 4");
		}else{
			return("Subject Code Not set!");
		}
	}
	if($BaseCode=='CS'){
		if($Sem==2){
			if($SubCode==CS22){
				return("Engineering Chemistry");
			}else if($SubCode==CS23){
				return("Computer Concepts and C Programming");
			}else if($SubCode==CS24){
				return("Computer Aided Engineering Drawing");
			}else if($SubCode==CS25){
				return("Basic Electronics");
			}else if($SubCode==CS28){
				return("Environmental Studies");
			}else{
				return("Subject Code not set!");
			}
		}elseif($Sem==4){
			if($SubCode==CS42){
				return("Graph Theory And Combinatorics");
			}else if($SubCode==CS43){
				return("Design and Analysis of Algorithms");
			}else if($SubCode==CS44){
				return("Unix and Shell Programming");
			}else if($SubCode==CS45){
				return("Microprocessors");
			}else if($SubCode==CS46){
				return("Computer Organizations");
			}else{
				return("Subject Code not set!");
			}
		}elseif($Sem==6){
			if($SubCode==CS61){
				return("Management & Enterpreneurship");
			}else if($SubCode==CS62){
				return("Unix System Programming");
			}else if($SubCode==CS63){
				return("Compiler Design");
			}else if($SubCode==CS64){
				return("Computer Network II");
			}else if($SubCode==CS65){
				return("Computer Graphics & Visualization");
			}else if($SubCode==CS66){
				return("Operations Research");
			}else if($SubCode==CS67){
				return("Programming Languages");	
			}else{
				return("Subject Code not set!");
			}
		}else if($Sem==8){
			if($SubCode==CS81){
				return("Software Architecture");
			}else if($SubCode==CS82){
				return("System Modeling Simulations");
			}else if($SubCode==CS83){
				return("Wireless Networks & Mobile Computing");
			}else if($SubCode==CS84){
				return("Multi-Core Architectural & Programming");
			}else{
				return("Subject Code not set!");
			}
		}
	}else if($BaseCode=='EC'){
		if($Sem==2){
			if($SubCode==EC22){
				return("Engineering Chemistry");
			}else if($SubCode==EC23){
				return("Computer Concepts and C Programming");
			}else if($SubCode==EC24){
				return("Computer Aided Engineering Drawing");
			}else if($SubCode==EC25){
				return("Basic Electronics");
			}else if($SubCode==EC28){
				return("Environmental Studies");
			}else{
				return("Subject Code not set!");
			}
		}else if($Sem==4){
			if($SubCode==EC42){
				return("Microcontrollers");
			}else if($SubCode==EC43){
				return("Control Systems");
			}else if($SubCode==EC44){
				return("Signals and Systems");
			}else if($SubCode==EC45){
				return("Fundamentals of HDL");
			}else if($SubCode==EC46){
				return("Linear ICs & Applications");
			}else{
				return("Subject Code not set!");
			}
		}else if($Sem==6){
			if($SubCode==EC61){
				return("Digital Communications");
			}else if($SubCode==EC62){
				return("Microprocessors");
			}else if($SubCode==EC63){
				return("Microelectronics Circuits");
			}else if($SubCode==EC64){
				return("Antennas & Propogations");
			}else if($SubCode==EC65){
				return("Operating Systems");
			}else if($SubCode==EC66){
				return("Satellite Communications");
			}else if($SubCode==EC67){
				return("Programming Using C++");	
			}else{
				return("Subject Code not set!");
			}
		}else if($Sem==8){
			if($SubCode==EC81){
				return("Wireless Communications");
			}else if($SubCode==EC82){
				return("Digital Switching Systems");
			}else if($SubCode==EC83){
				return("Network Security");
			}else if($SubCode==EC84){
				return("Multimedia Communications");
			}else{
				return("Subject Code not set!");
			}
		}
	}else if($BaseCode=='ME'){
		if($Sem==2){
			if($SubCode==ME22){
				return("Engineering Physics");
			}else if($SubCode==ME23){
				return("Elements of Civil Engineering");
			}else if($SubCode==ME24){
				return("Elements of Mechanical Engineering");
			}else if($SubCode==ME25){
				return("Basic Electrical Engineering");
			}else if($SubCode==ME28){
				return("C.I.P");
			}else{
				return("Subject Code not set!");
			}
		}else if($Sem==4){
			if($SubCode==ME42){
				return("Mechanical Measurement and Metrology");
			}else if($SubCode==ME43){
				return("Applied Thermodynamics");
			}else if($SubCode==ME44){
				return("Kinematics of Machines");
			}else if($SubCode==ME45){
				return("Manufacturing Process II");
			}else if($SubCode==ME46){
				return("Fluid Mechanics");
			}else{
				return("Subject Code not set!");
			}
		}else if($Sem==6){
			if($SubCode==ME61){
				return("Computer Integrated Manufacturing");
			}else if($SubCode==ME62){
				return("Design Of Machine Elements II");
			}else if($SubCode==ME63){
				return("Heat & Mass Transfer");
			}else if($SubCode==ME64){
				return("Finite Element Methods");
			}else if($SubCode==ME65){
				return("Mechatronics & Microprocessors");
			}else if($SubCode==ME66){
				return("Non Traditional Machining");
			}else if($SubCode==ME67){
				return("Statistical Quality Control");	
			}else{
				return("Subject Code not set!");
			}
		}else if($Sem==8){
			if($SubCode==ME81){
				return("Operations Management");
			}else if($SubCode==ME82){
				return("Control Engineering");
			}else if($SubCode==ME83){
				return("Power Plant Engineering");
			}else if($SubCode==ME84){
				return("Automotive Engineering");
			}else{
				return("Subject Code not set!");
			}
		}
	}else if($BaseCode=='CV'){
		if($Sem==2){
			if($SubCode==CV22){
				return("Engineering Physics");
			}else if($SubCode==CV23){
				return("Elements of Civil Engineering");
			}else if($SubCode==CV24){
				return("Elements of Mechanical Engineering");
			}else if($SubCode==CV25){
				return("Basic Electrical Engineering");
			}else if($SubCode==CV28){
				return("C.I.P");
			}else{
				return("Subject Code not set!");
			}
		}else if($Sem==4){
			if($SubCode==CV42){
				return("Concrete Technology");
			}else if($SubCode==CV43){
				return("Structural Analysis I");
			}else if($SubCode==CV44){
				return("Surveying II");
			}else if($SubCode==CV45){
				return("Hydrolics and Hydrolic Machines");
			}else if($SubCode==CV46){
				return("Building Planning and Drawing");
			}else{
				return("Subject Code not set!");
			}
		}else if($Sem==6){
			if($SubCode==CV61){
				return("Environmental Engineering 1");
			}else if($SubCode==CV62){
				return("Design and drawing of RCC Structures");
			}else if($SubCode==CV63){
				return("Transportation Engineering 2");
			}else if($SubCode==CV64){
				return("GeoTechnical Engineering 2");
			}else if($SubCode==CV65){
				return("Hydralic Structure and Irrigation Design");
			}else if($SubCode==CV66){
				return("Alternative Building Material and Technology");
			}else{
				return("Subject Code not set!");
			}
		}else if($Sem==8){
			if($SubCode==CV81){
				return("Advanced Concrete Technology");
			}else if($SubCode==CV82){
				return("Design & Drawing Of Steel Structures");
			}else if($SubCode==CV83){
				return("Pavement Design");
			}else if($SubCode==CV84){
				return("Environmental Impact Assesment");
			}else{
				return("Subject Code not set!");
			}
		}
	}
		
	echo "Something Went Wrong!";
}

//Function to get Faculty Subject allocation of a class.
function GetFacSubAlloc($Class){
	global $mysql_hostname,$mysql_user,$mysql_password,$mysql_database;
	 //connect to database
	$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
	mysql_select_db($mysql_database, $bd) or die("Could not select database");
	//Request Allocation data from the table.
	$query="SELECT * FROM `table_data` WHERE ID='$Class'";
	$QueryResult=mysql_query($query);
	$Allocations = mysql_fetch_assoc($QueryResult);
	return $Allocations;
}

//Function to strip Faculty Code from allocation code and return it.
function StripFacCode($Alloc){
	$FacCode= $Alloc[0].$Alloc[1].$Alloc[2].$Alloc[3];
	return $FacCode;
}

//Function to strip Subject Code from allocation code and return it.
function StripSubCode($Alloc){
	$SubCode=$Alloc[4].$Alloc[5].$Alloc[6].$Alloc[7];
	return $SubCode;
}
?>