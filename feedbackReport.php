<?php
/*******SESSION MAINTENANCE***********/
session_start();
if(!isset($_SESSION['crm_uid'])&&!isset($_SESSION['access']))
{die('<p><b>Session Time out. Plesae Click <a href="index.php" target="_top">here</a> for new Session</b></p>');}
$access=$_SESSION['access'];
$name=$_SESSION['crm_name'];
$userId=$_SESSION['crm_uid'];
$level=$_SESSION['crm_level'];

/*************************************/
include("dbconnection.php");
include("info.php");

if(isset($_POST['btnView']))
{
 		$from=$_POST['startDate'];
		$to=$_POST['endDate'];
		$c=$_POST['campaign'];
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
			
			//echo $fdbkQry;
			
			$fdbkResult = mysql_query($fdbkQry) or die('Query failed: ' . mysql_error()); 
			if(mysql_num_rows($fdbkResult)!=0) { $flagFdbkView=true; } 
			else { $flagFdbkView=false; $errMsg2="<font color='#FF0000'><p><h4>Feedback Data no Found!!</h4></p></font>"; }	
		
		}
}	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Complain Entry Form</title>
<link href="main.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="popcalendar.js"></script>

<style type="text/css">
<!--
.style1 {
	font-family: verdana;
	font-weight: bold;
	font-size: 10px;
}
.style5 {color: #FFFFFF}
.style8 {font-size: 10px; font-family:Verdana, Arial, Helvetica, sans-serif;
 border:1px solid #999999;
}
.style4 {	font-family: Verdana;
	font-weight: bold;
}
.style10 {font-family: verdana; font-weight: bold; font-size: 10px; color: #FFFFFF; }
-->
</style>


<script language="javascript">
function chkForm(form)
{
		var campaign= document.getElementById('campaign');
		
					
			if(campaign.value=="")
			{
				window.alert('Please select Campaign');
				form.campaign.focus();
				return false;
			}
	return true;		
}
function Btn_submit()
		{
			document.fdbkReport.action='feedbackReport.php';
				
		}
function Btn_exp()
		{
			document.fdbkReport.action='exp_excel.php';
				
		}
</script>
</head>

<body bgcolor="#f3f3f3">

<form name="fdbkReport" method="POST" >
<table align="center" cellpadding="1" cellspacing="1"bgcolor="#d9effd">
	<tr>
      <td class="td">
	<span class="label">Start Date:</span></td>
	<td class="td"><input name="startDate" type="text" value="<?php if($_POST['startDate']) echo $_POST['startDate']; else echo date('Y-m-d');?>" size="10" class="select" />
          <img src="images/cal.gif" alt="Pick a Date" align="absmiddle" style="cursor:pointer;cursor:hand;" onClick=    	"popUpCalendar(this,document.fdbkReport.startDate,'yyyy-mm-dd');return false;">
	</td>
	<td class="td">
	<span class="label">End Date:</span></td>
	<td class="td"><input name="endDate" type="text" value="<?php if($_POST['endDate']) echo $_POST['endDate']; else echo date('Y-m-d');?>" size="10" class="select" />
          <img src="images/cal.gif" alt="Pick a Date" align="absmiddle" style="cursor:pointer;cursor:hand;" onClick=    	"popUpCalendar(this,document.fdbkReport.endDate,'yyyy-mm-dd');return false;">
	</td>
	<td class="td" align="right"><span class="label">Campaign :</span></td>
	  <td class="td">
       <select  name="campaign" id="campaign">
            <option value="">--Choose Campaign--</option>
            
              <?php
		 
        if($level==3){ ?>
        <option value="8" <?php if($_POST['campaign'] == '8') echo "selected";?>>Telesales Welcome</option>
   <?php
   					}
		else {
   
        $camp_query="select * FROM campaign";
	    $camp_result=mysql_query($camp_query);
	    $camp_num=mysql_num_rows($camp_result);
		
		$i=0;
        while($i < $camp_num)
        {
        ?>
          <option value="<?php echo mysql_result($camp_result,$i,"campId");?>" <?php if($_POST['campaign'] == mysql_result($camp_result,$i,"campId")) echo "selected";?>>
          <?php
        echo mysql_result($camp_result,$i,"campName");
        $i++;
        }}
        ?>
           </option>
         </select>		 </td>
  
        <td>
		
		<input name="btnView" type="Submit" class="loginButton" id="btnView" value="View Report"  onclick="return(chkForm(this.form)) && Btn_submit();"> 
		<input name="btn_Exp_Fdbk_Report" type="Submit" class="loginButton" id="btn_Exp_Fdbk_Report" value="Export Data"  onclick="return(chkForm(this.form)) && Btn_exp();"> 
		</td>
	</tr>
</table>		
</form>
<?php 

if(!empty($errMsg2)) echo $errMsg2;

if($flagFdbkView)
	{
		$out .='';
		$columns = mysql_num_fields($fdbkResult);
		$out .= '<table width="90%" align="center" class="table"><tr bgcolor="#D7D7FF"><td class="label2" align="center" colspan="'.$columns.'">Customer Feedback Report</td></tr><tr>';
		for ($i = 0; $i < $columns; $i++) 
		{	
			$col=mysql_field_name($fdbkResult, $i);
			$out .= '<th class="th1">'.$col.'</th>';	
		}
		$out .= '</tr>';	
		while($row=mysql_fetch_array($fdbkResult))
		{
			$out .= '<tr>';
			for ($i = 0; $i < $columns; $i++) 
				{					
					
					$out.='<td class="td1">'.$row["$i"].'</td>';
					
				}
			$out .= '</tr>';
		}
			$out .= '</table>';
		echo $out;
	}				

 ?>
</body>
</html>
