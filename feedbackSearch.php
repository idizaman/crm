<?php
/*******SESSION MAINTENANCE***********/
session_start();
if(!isset($_SESSION['crm_uid'])&&!isset($_SESSION['access']))
{die('<p><b>Session Time out. Plesae Click <a href="index.php" target="_top">here</a> for new Session</b></p>');}
$access=$_SESSION['access'];
$name=$_SESSION['crm_name'];
$userId=$_SESSION['crm_uid'];

/*************************************/
include("dbconnection.php");
include("info.php");

if(isset($_POST['btnSearch']))
{
 		$contrNo=$_POST['contrno'];

		if(!empty($contrNo))
		{
			
				
			//$fdbkQry="select * from feedbackData where contrNo='$contrNo'";
			$fdbkQry="SELECT
			f.entryDate AS `Call Date`,
			f.userId AS `Agent Id`,
			c.campName AS Campaign,
			f1.fdbkName AS `Feedback-1`,
			f2.fdbkName AS `Feedback-2`,
			f3.fdbkName AS `Feedback-3`,
			f.flwupDate AS `Follow-Up Date`,
			f.remarks AS Remarks
			FROM
			feedbackdata AS f
			Left Join campaign AS c ON f.campId = c.campId
			Left Join feedback1 AS f1 ON f.fdbk1Id = f1.fdbk1Id
			Left Join feedback2 AS f2 ON f.fdbk2Id = f2.fdbk2Id
			Left Join feedback3 AS f3 ON f.fdbk3Id = f3.fdbk3Id
                        left Join bdrdata as bd on bd.contrNo = f.contrno
			WHERE
			bd.subno = '$contrNo'
                        group by f.entryDate, f.entryTime
			order by f.entryDate DESC";
			$fdbkResult = mysql_query($fdbkQry) or die('Query failed: ' . mysql_error()); 
			if(mysql_num_rows($fdbkResult)!=0) { $flagFdbkView=true; } 
			else { $flagFdbkView=false; $errMsg2="<font color='#FF0000'><p><h4>Feedback Data no Found for the selected CONTR No.!!</h4></p></font>"; }	
		
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
function chkContrno(form)
	{
		var contrno= document.getElementById('contrno');
					
			if(contrno.value=="")
			{
				window.alert('Contrno Required');
				form.contrno.focus();
				return false;
			}
			else
			{
				return true;
			}
}
</script>
</head>

<body bgcolor="#f3f3f3">

<form name="cotrnoSearch" method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>" >
<table align="center" cellpadding="1" cellspacing="1"bgcolor="#d9effd">
	<tr>
      <td class="label" align="right">SUBNO:</td>
      <td class="td"><input name="contrno" type="text" id="contrno" value="<?php if($_POST['contrno']) echo $_POST['contrno'];?>"></td>
  
        <td align="center">
		
		<input name="btnSearch" type="Submit" class="loginButton" id="btnSearch" value="  Search  "  onclick="return(chkContrno(this.form));"> 
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
		$out .= '<table width="90%" align="center" class="table"><tr bgcolor="#D7D7FF"><td class="label2" align="center" colspan="'.$columns.'">Feedback History</td></tr><tr>';
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
