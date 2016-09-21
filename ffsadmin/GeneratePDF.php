<?php
require_once '../CoreLib.php';
// Include the main TCPDF library (search for installation path).
require_once('tcpdf/tcpdf.php');

session_start();
date_default_timezone_set('Asia/Kolkata');
$Timestamp=date('d-m-Y h:i:s A');

//Main Logic Starts here
if(($_SESSION['LoginStatus']==0)||($_SESSION['LoginStatus']==NULL)){
header("location: index.php");
exit();
}

if(!($_REQUEST['facID'] || $_REQUEST['classID'])){
header("location: ../error.php");
exit();
}
$FacID=strtolower($_POST['facID']);
$empCode = strtoupper($_POST['facID']);
$FacName=GetFacName($_POST['facID']);
$Class=$_POST['classID'];
$ClassName=GetClassName($Class);

//******************************************************************Generation of PDF Starts Here*******************************************************
//******************************************************************************************************************************************************
					$BUILDInfo=GetBUILD();
					//set the name of the file generated;
					$Filename=$FacName."-".$ClassName." (Feedback Report).pdf";
					//$Filename=rawurlencode($Filename);
					
					
					$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
					mysql_select_db($mysql_database, $bd) or die("Could not select database");
					
					
					//check for the feedbacks in the database if none found return back
					$qry="SELECT * FROM $FacID WHERE Class='".$Class."'";
					$result=mysql_query($qry);
					$num=mysql_num_rows($result);
					if($num==0){
						//echo "No reports";
						header("location: home.php?select=reportsTab&reports=no");
						exit();
					}
					
					
			/**		-----------COMMENTS HAVE BEEN DISCONTINUED -------------
                    //get the comments and write to the pdf
					
					// Get all fields names in table from the database.
					$fields = mysql_list_fields($mysql_database,$FacID);
					
					// Count the table fields and put the value into $columns.
					$columns = mysql_num_fields($fields);
					$numstud=0;//Number of students
					$comIndex = 1;//comment serial no
					
					//Get the comments of the faculty and class selected from the database and store it in a variable
					while ($l = mysql_fetch_array($result)) {
						$numstud++;
						if($l['Q21'] == NULL) continue;
						$commentsHTML .="<tr><td><small><font color=\"blue\">".$comIndex++.")</font> ".htmlentities($l['Q21'])."</small></td></tr>";
					}
					//echo $commentsHTML;  **/
					
//Find out the frequency of 1,2,3,4,5 for each questions.
                    //initialize variables to 0
                    for($i=1;$i<=20;$i++){
                        for($j=1;$j<=5;$j++){
                             ${"Q".$i."_".$j."count"} = 0; 
                        }              
                    }
                    
                    $studCount =0;
					$result=mysql_query("SELECT * FROM $FacID WHERE Class='".$Class."'");
				    while($row=mysql_fetch_assoc($result)){
                            $studCount++;
							for($i=1;$i<=20;$i++){
						          $c="Q".$i;
                                    switch($row[$c]){
                                        case '1' :  ${"Q".$i."_1count"}++;
                                                break;
                                        case '2' :  ${"Q".$i."_2count"}++;
                                                break;
                                        case '3' :  ${"Q".$i."_3count"}++; 
                                                break;
                                        case '4' :  ${"Q".$i."_4count"}++; 
                                                break;
                                        case '5' :  ${"Q".$i."_5count"}++; 
                                                break;                                            
                                    }
                            }
				    }	
					
					//Calculate the average marks and store it in a variable to show the total percentage
					$TotalMarks=0;
					for($i=1;$i<=20;$i++){
						$c="Q".$i;
						$result=mysql_query("SELECT SUM($c) AS colsum FROM $FacID WHERE Class='".$Class."'");//finding the column total
						while($row=mysql_fetch_assoc($result)){
							$TotalMarks+=$row['colsum'];//adding the column total to get total marks
						}	
					}	

					$Totalpercent=$TotalMarks/$studCount;
					$Totalpercent=round($Totalpercent,2);
					
                    //Print count variables
                /*    for($i=1;$i<=20;$i++){
                        for($j=1;$j<=5;$j++){
                             echo ${"Q".$i."_".$j."count"};
                        }     
                        echo "<br>";
                    } 
                    echo $studCount;   */
                    
                    //Print count percentage
                   for($i=1;$i<=20;$i++){
                        for($j=1;$j<=5;$j++){
                            ${"Q".$i."_".$j."percent"} = round((${"Q".$i."_".$j."count"}/$studCount)*100,2);
                          //  echo  ${"Q".$i."_".$j."percent"};
                        }     
                       // echo "<br>";
                    } 
                   // echo $studCount;   

//PDF Building Starts here........................................
					// create new PDF document
					$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

					// set document information
					$pdf->SetCreator(FFS_PDF_CREATOR);
					$pdf->SetAuthor('FFSv3');
					$pdf->SetTitle($FacName."-".$ClassName."- Feedback Report");
					$pdf->SetSubject('SMVITM Faculty Feedback Report');

										
					// set default monospaced font
					$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
					
									
					// remove default header/footer
					$pdf->setPrintHeader(false);
					//$pdf->setPrintFooter(false);
					
					// set margins
					$pdf->SetFooterMargin(8);


					// set auto page breaks
					$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

					// set image scale factor
					$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

					// set some language-dependent strings (optional)
					if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
						require_once(dirname(__FILE__).'/lang/eng.php');
						$pdf->setLanguageArray($l);
					}

					// ---------------------------------------------------------

					// set default font subsetting mode
					$pdf->setFontSubsetting(true);

					// Set font
					// dejavusans is a UTF-8 Unicode font, if you only need to
					// print standard ASCII chars, you can use core fonts like
					// helvetica or times to reduce file size.
					$pdf->SetFont('dejavusans', '', 14, '', true);

					// Add a page
					// This method has several options, check the source code documentation for more information.
					$pdf->AddPage();
				
				    
					// to print
					$html = <<<EOD

					<div style="text-align:center"><img src="../assets/coll_header.jpg" alt="SMVITM" width="760" height="95" border="0" /><br />
					<u><b>Faculty Feedback Report</b></u></div><br>
					<font size="10"><table border="0">
									<tr><td align="left">
										<b>Faculty Name</b>: $FacName<br>
										<b>Employee Code</b>: $empCode<br>
										<b>Class</b>: $ClassName
										</td>
										<td align="right"><font color="green"><b>Generated On</b>: $Timestamp<br>
														<b>Generated By</b>:</font>$BUILDInfo
										</td>
									</tr>
									<tr><td colspan="2"></td></tr>
									<tr><td colspan="2"><table border="1">
															<tr><td align="left"><b>Total Percentage:</b> $Totalpercent%<br><b>Total Students:</b> $studCount</td></tr></table></td>
									</tr>
									<tr><td colspan="2"></td></tr>
									</table></font>
					<!-- Print the Percentage along with the question -->
                    
                    
                    <font size="10"><b>
                    Q1) Is enthusiastic and seems to enjoy teaching.</b>
                        <br><br>
                        <table border="1" align="center">
                            <tr>
                                <th>Strongly Disagree</th>
                                <th>Disagree</th>
                                <th>Neither Agree or Disagree</th>
                                <th>Agree</th>
								<th>Strongly Agree</th>
                            </tr>
                            <tr>
                                <td>$Q1_1percent%</td>
                                <td>$Q1_2percent%</td>
                                <td>$Q1_3percent%</td>
                                <td>$Q1_4percent%</td>
                                <td>$Q1_5percent%</td>
                            </tr>
                        </table>
                    </font>
                    <br>
                    <font size="10"><b>
                    Q2) Objectives and plan of the course were specified clearly.</b>
                        <br><br>
                        <table border="1" align="center">
                            <tr>
                                <th>Strongly Disagree</th>
                                <th>Disagree</th>
                                <th>Neither Agree or Disagree</th>
                                <th>Agree</th>
								<th>Strongly Agree</th>
                            </tr>
                            <tr>
                                <td>$Q2_1percent%</td>
                                <td>$Q2_2percent%</td>
                                <td>$Q2_3percent%</td>
                                <td>$Q2_4percent%</td>
                                <td>$Q2_5percent%</td>
                            </tr>
                        </table>
                    </font>
                    <br>
                    <font size="10"><b>
                    Q3) Possesses good teaching skills and gives clear explanations.</b>
                        <br><br>
                        <table border="1" align="center">
                           <tr>
                                <th>Strongly Disagree</th>
                                <th>Disagree</th>
                                <th>Neither Agree or Disagree</th>
                                <th>Agree</th>
								<th>Strongly Agree</th>
                            </tr>
                            <tr>
                                <td>$Q3_1percent%</td>
                                <td>$Q3_2percent%</td>
                                <td>$Q3_3percent%</td>
                                <td>$Q3_4percent%</td>
                                <td>$Q3_5percent%</td>
                            </tr>
                        </table>
                    </font><br>
                    <font size="10"><b>
                    Q4) Possesses good communication skills.</b>
                        <br><br>
                        <table border="1" align="center">
                           <tr>
                                <th>Strongly Disagree</th>
                                <th>Disagree</th>
                                <th>Neither Agree or Disagree</th>
                                <th>Agree</th>
								<th>Strongly Agree</th>
                            </tr>
                            <tr>
                                <td>$Q4_1percent%</td>
                                <td>$Q4_2percent%</td>
                                <td>$Q4_3percent%</td>
                                <td>$Q4_4percent%</td>
                                <td>$Q4_5percent%</td>
                            </tr>
                        </table>
                    </font><br>
                    <font size="10"><b>
                    Q5) Has good knowledge of the subject and answers any questions.</b>
                        <br><br>
                        <table border="1" align="center">
                           <tr>
                                <th>Strongly Disagree</th>
                                <th>Disagree</th>
                                <th>Neither Agree or Disagree</th>
                                <th>Agree</th>
								<th>Strongly Agree</th>
                            </tr>
                            <tr>
                                <td>$Q5_1percent%</td>
                                <td>$Q5_2percent%</td>
                                <td>$Q5_3percent%</td>
                                <td>$Q5_4percent%</td>
                                <td>$Q5_5percent%</td>
                            </tr>
                        </table>
                    </font><br>
                    <br><br>
 <!-- New Page -->
                    <font size="10"><b>
                    Q6) Comes prepared for the class and doesn’t get upset by questions.</b>
                        <br><br>
                        <table border="1" align="center">
                            <tr>
                                <th>Strongly Disagree</th>
                                <th>Disagree</th>
                                <th>Neither Agree or Disagree</th>
                                <th>Agree</th>
								<th>Strongly Agree</th>
                            </tr>
                            <tr>
                                <td>$Q6_1percent%</td>
                                <td>$Q6_2percent%</td>
                                <td>$Q6_3percent%</td>
                                <td>$Q6_4percent%</td>
                                <td>$Q6_5percent%</td>
                            </tr>
                        </table>
                    </font><br>
                    <font size="10"><b>
                    Q7) Motivates the students to learn more about the subject.</b>
                        <br><br>
                        <table border="1" align="center">
                           <tr>
                                <th>Strongly Disagree</th>
                                <th>Disagree</th>
                                <th>Neither Agree or Disagree</th>
                                <th>Agree</th>
								<th>Strongly Agree</th>
                            </tr>
                            <tr>
                                <td>$Q7_1percent%</td>
                                <td>$Q7_2percent%</td>
                                <td>$Q7_3percent%</td>
                                <td>$Q7_4percent%</td>
                                <td>$Q7_5percent%</td>
                            </tr>
                        </table>
                    </font><br>
                    <font size="10"><b>
                    Q8) Is quite audible in the class till the last row.</b>
                        <br><br>
                        <table border="1" align="center">
                           <tr>
                                <th>Strongly Disagree</th>
                                <th>Disagree</th>
                                <th>Neither Agree or Disagree</th>
                                <th>Agree</th>
								<th>Strongly Agree</th>
                            </tr>
                            <tr>
                                <td>$Q8_1percent%</td>
                                <td>$Q8_2percent%</td>
                                <td>$Q8_3percent%</td>
                                <td>$Q8_4percent%</td>
                                <td>$Q8_5percent%</td>
                            </tr>
                        </table>
                    </font><br>
                    <font size="10"><b>
                    Q9) Writes legibly on the board and it is visible till the last row.</b>
                        <br><br>
                        <table border="1" align="center">
                            <tr>
                                <th>Strongly Disagree</th>
                                <th>Disagree</th>
                                <th>Neither Agree or Disagree</th>
                                <th>Agree</th>
								<th>Strongly Agree</th>
                            </tr>
                            <tr>
                                <td>$Q9_1percent%</td>
                                <td>$Q9_2percent%</td>
                                <td>$Q9_3percent%</td>
                                <td>$Q9_4percent%</td>
                                <td>$Q9_5percent%</td>
                            </tr>
                        </table>
                    </font>
                    <br>
                    <font size="10"><b>
                    Q10) Has good control over the students during the class.</b>
                        <br><br>
                        <table border="1" align="center">
                           <tr>
                                <th>Strongly Disagree</th>
                                <th>Disagree</th>
                                <th>Neither Agree or Disagree</th>
                                <th>Agree</th>
								<th>Strongly Agree</th>
                            </tr>
                            <tr>
                                <td>$Q10_1percent%</td>
                                <td>$Q10_2percent%</td>
                                <td>$Q10_3percent%</td>
                                <td>$Q10_4percent%</td>
                                <td>$Q10_5percent%</td>
                            </tr>
                        </table>
                    </font>
                    <br>
                    <font size="10"><b>
                    Q11) Takes classes regularly and punctual to the classes.</b>
                        <br><br>
                        <table border="1" align="center">
                            <tr>
                                <th>Strongly Disagree</th>
                                <th>Disagree</th>
                                <th>Neither Agree or Disagree</th>
                                <th>Agree</th>
								<th>Strongly Agree</th>
                            </tr>
                            <tr>
                                <td>$Q11_1percent%</td>
                                <td>$Q11_2percent%</td>
                                <td>$Q11_3percent%</td>
                                <td>$Q11_4percent%</td>
                                <td>$Q11_5percent%</td>
                            </tr>
                        </table>
                    </font>
                    <br>
                    <font size="10"><b>
                    Q12) Makes proper use of teaching aids.</b>
                        <br><br>
                        <table border="1" align="center">
                            <tr>
                                <th>Strongly Disagree</th>
                                <th>Disagree</th>
                                <th>Neither Agree or Disagree</th>
                                <th>Agree</th>
								<th>Strongly Agree</th>
                            </tr>
                            <tr>
                                <td>$Q12_1percent%</td>
                                <td>$Q12_2percent%</td>
                                <td>$Q12_3percent%</td>
                                <td>$Q12_4percent%</td>
                                <td>$Q12_5percent%</td>
                            </tr>
                        </table>
                    </font>
                    <br>
                    <font size="10"><b>
                    Q13) Takes special care of weaker students and helps them understand better.</b>
                        <br><br>
                        <table border="1" align="center">
                            <tr>
                                <th>Strongly Disagree</th>
                                <th>Disagree</th>
                                <th>Neither Agree or Disagree</th>
                                <th>Agree</th>
								<th>Strongly Agree</th>
                            </tr>
                            <tr>
                                <td>$Q13_1percent%</td>
                                <td>$Q13_2percent%</td>
                                <td>$Q13_3percent%</td>
                                <td>$Q13_4percent%</td>
                                <td>$Q13_5percent%</td>
                            </tr>
                        </table>
                    </font>
                    <br>
                    <font size="10"><b>
                    Q14) The coverage of the syllabus and depth of the course plan was excellent.</b>
                        <br><br>
                        <table border="1" align="center">
                            <tr>
                                <th>Strongly Disagree</th>
                                <th>Disagree</th>
                                <th>Neither Agree or Disagree</th>
                                <th>Agree</th>
								<th>Strongly Agree</th>
                            </tr>
                            <tr>
                                <td>$Q14_1percent%</td>
                                <td>$Q14_2percent%</td>
                                <td>$Q14_3percent%</td>
                                <td>$Q14_4percent%</td>
                                <td>$Q14_5percent%</td>
                            </tr>
                        </table>
                    </font>
                    <br>
                    <font size="10"><b>
                    Q15) Gives adequate assignments and discusses solutions in the class.</b>
                        <br><br>
                        <table border="1" align="center">
                            <tr>
                                <th>Strongly Disagree</th>
                                <th>Disagree</th>
                                <th>Neither Agree or Disagree</th>
                                <th>Agree</th>
								<th>Strongly Agree</th>
                            </tr>
                            <tr>
                                <td>$Q15_1percent%</td>
                                <td>$Q15_2percent%</td>
                                <td>$Q15_3percent%</td>
                                <td>$Q15_4percent%</td>
                                <td>$Q15_5percent%</td>
                            </tr>
                        </table>
                    </font>
                     <br>
                    <font size="10"><b>
                    Q16) Is fair and transparent in students’ evaluation and provides effective feedback on test/examination performance.</b>
                        <br><br>
                        <table border="1" align="center">
                            <tr>
                                <th>Strongly Disagree</th>
                                <th>Disagree</th>
                                <th>Neither Agree or Disagree</th>
                                <th>Agree</th>
								<th>Strongly Agree</th>
                            </tr>
                            <tr>
                                <td>$Q16_1percent%</td>
                                <td>$Q16_2percent%</td>
                                <td>$Q16_3percent%</td>
                                <td>$Q16_4percent%</td>
                                <td>$Q16_5percent%</td>
                            </tr>
                        </table>
                    </font>
                     <br>
                    <font size="10"><b>
                    Q17) Provides notes or hand-outs to supplement the teaching.</b>
                        <br><br>
                        <table border="1" align="center">
                            <tr>
                                <th>Strongly Disagree</th>
                                <th>Disagree</th>
                                <th>Neither Agree or Disagree</th>
                                <th>Agree</th>
								<th>Strongly Agree</th>
                            </tr>
                            <tr>
                                <td>$Q17_1percent%</td>
                                <td>$Q17_2percent%</td>
                                <td>$Q17_3percent%</td>
                                <td>$Q17_4percent%</td>
                                <td>$Q17_5percent%</td>
                            </tr>
                        </table>
                    </font>
                     <br>
                    <font size="10"><b>
                    Q18)Is available and approachable after the class hours.</b>
                        <br><br>
                        <table border="1" align="center">
                            <tr>
                                <th>Strongly Disagree</th>
                                <th>Disagree</th>
                                <th>Neither Agree or Disagree</th>
                                <th>Agree</th>
								<th>Strongly Agree</th>
                            </tr>
                            <tr>
                                <td>$Q18_1percent%</td>
                                <td>$Q18_2percent%</td>
                                <td>$Q18_3percent%</td>
                                <td>$Q18_4percent%</td>
                                <td>$Q18_5percent%</td>
                            </tr>
                        </table>
                    </font>
                     <br>
                    <font size="10"><b>
                    Q19) Encourages students’ participation and interaction in the class.</b>
                        <br><br>
                        <table border="1" align="center">
                            <tr>
                                <th>Strongly Disagree</th>
                                <th>Disagree</th>
                                <th>Neither Agree or Disagree</th>
                                <th>Agree</th>
								<th>Strongly Agree</th>
                            </tr>
                            <tr>
                                <td>$Q19_1percent%</td>
                                <td>$Q19_2percent%</td>
                                <td>$Q19_3percent%</td>
                                <td>$Q19_4percent%</td>
                                <td>$Q19_5percent%</td>
                            </tr>
                        </table>
                    </font>
                     <br>
                    <font size="10"><b>
                    Q20) Overall , the learning process was enjoyable.</b>
                        <br><br>
                        <table border="1" align="center">
                            <tr>
                                <th>Strongly Disagree</th>
                                <th>Disagree</th>
                                <th>Neither Agree or Disagree</th>
                                <th>Agree</th>
								<th>Strongly Agree</th>
                            </tr>
                            <tr>
                                <td>$Q20_1percent%</td>
                                <td>$Q20_2percent%</td>
                                <td>$Q20_3percent%</td>
                                <td>$Q20_4percent%</td>
                                <td>$Q20_5percent%</td>
                            </tr>
                        </table>
                    </font>
                    
                    
                    
					<br><br><br><br><br>
					<table border="0">
					<tr><td align="right">___________________</td></tr>
					<tr height="30"><td align="right"><small>Principal/Dean (Acaedemics)</small></td></tr>
					</table>
					
EOD;

					// output the HTML content
					$pdf->writeHTML($html, true, false, true, false, '');


					// ---------------------------------------------------------

					// Close and output PDF document
					// This method has several options, check the source code documentation for more information.
					$pdf->Output($Filename, 'D');
				
	
	
exit;    
?>