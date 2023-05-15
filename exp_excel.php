<?php 

include("dbconnection.php");

if(isset($_REQUEST['btn_Exp_Fdbk_Report']))
		 {
							
			$from=$_POST['startDate'];
			$to=$_POST['endDate'];
			$c=$_POST['campaign'];
			
			$fname = "Master_Report_".$from."_".$to.".xls";
			
			if($c!="") $campaign=" and f.campId='".$c."'"; else $campaign="";
		if(!empty($from) && !empty($to))
		{
			//$fdbkQry="select * from feedbackData where contrNo='$contrNo'";
			$fdbkQry="SELECT
			f.entryDate AS `Call Date`, f.userId AS `Agent Id`, f.contrNo, `SUBNO`, `NO_OF_LINES`, `CATEGORY`, `EQUIPID`, `CUSTNAME`, `STATUS`, `STATUS_DATE`, `PAST_DUE`, `UNBILLED`, `TOTAL`, `DEPOSIT`, `LIMIT`, `CREDIT_LIMIT`, `PERCENTAGE_ON_LIMIT`, c.campName AS Campaign, f1.fdbkName AS `Feedback-1`, f2.fdbkName AS `Feedback-2`, f3.fdbkName AS `Feedback-3`, f.flwupDate AS `Follow-Up Date`, f.remarks AS Remarks
			FROM
			feedbackdata AS f
			Inner Join bdrdata AS b ON f.fdbkId=b.fdbkId		
			Left Join campaign AS c ON f.campId = c.campId
			Left Join feedback1 AS f1 ON f.fdbk1Id = f1.fdbk1Id
			Left Join feedback2 AS f2 ON f.fdbk2Id = f2.fdbk2Id
			Left Join feedback3 AS f3 ON f.fdbk3Id = f3.fdbk3Id
			WHERE
			f.entryDate between  '$from' and '$to' $campaign";
			
			/*$fdbkResult = mysql_query($fdbkQry) or die('Query failed: ' . mysql_error()); 
			if(mysql_num_rows($fdbkResult)!=0) { $flagFdbkView=true; } 
			else { $flagFdbkView=false; $errMsg2="<font color='#FF0000'><p><h4>Feedback Data no Found!!</h4></p></font>"; }	*/
		}
 }
$result = mysql_query($fdbkQry);

if (!$result) {
    die('Query failed: ' . mysql_error());
}

$i = 0;
while ($i < mysql_num_fields($result)) {
    
    $meta = mysql_fetch_field($result, $i);
    if (!$meta) {
        echo "No information available<br />\n";
    }

 $column[$i] = strtoupper($meta->name);
    $i++;
}
 
function xlsBOF() { 
	echo pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0);  
return; 
} 
function xlsEOF() { 
	echo pack("ss", 0x0A, 0x00); 
	return; 
} 
function xlsWriteNumber($Row, $Col, $Value) { 
	echo pack("sssss", 0x203, 14, $Row, $Col, 0x0); 
	echo pack("d", $Value); 
	return; 
} 
function xlsWriteLabel($Row, $Col, $Value ) { 
	$L = strlen($Value); 
	echo pack("ssssss", 0x204, 8 + $L, $Row, $Col, 0x0, $L); 
	echo $Value; 
return; 
} 

header("Pragma: public");
header("Expires: 0");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");;
//header("Content-Disposition: attachment;filename=Master_Report.xls"); 
header("Content-Disposition: attachment;filename=".$fname); 

header("Content-Transfer-Encoding: binary ");
header('Pragma: public');
header('Expires: 0');
header('Content-Type: application/octet-stream');
header('Content-Transfer-Encoding: binary ');

xlsBOF(); 

//xlsWriteLabel(0,0,"Exported Data");

for($j = 0;$j < $i;$j++)
{
	xlsWriteLabel(0,$j,$column[$j]);
}

$xlsRow = 1;

for($j = 0;$j < mysql_num_rows($result);$j++)
{
	for($k = 0;$k < $i;$k++)
	{
		$val = mysql_result($result,$j,$column[$k]);
		
		xlsWriteLabel($xlsRow,$k,$val);
	}
	$xlsRow++;	
}

xlsEOF();
exit();

?>