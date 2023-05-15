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

if(isset($_POST['btnSearch']))  $subno=$_POST['subno']; else $subno= $_POST['subno'];

if(!empty($subno))
{
	$conn_mdb=odbc_connect('bdr','ccdmis','ccdmis');
	$contQry="select * from BDR_output where SUBNO='$subno'";
	$conResult=odbc_exec($conn_mdb,$contQry); 
	$conCount=odbc_num_rows($conResult);
	
	$CONTRNO=odbc_result($conResult,'CONTRNO');	
	$CATEGORY=odbc_result($conResult,'CATEGORY');
	$EQUIPID=odbc_result($conResult,'EQUIPID');
	$CUSTNAME=odbc_result($conResult,'CUSTNAME');	
	$STREET=odbc_result($conResult,'STREET');
	$ADDRESS2=odbc_result($conResult,'ADDRESS2');	
	$Add=addslashes($STREET.','.$ADDRESS2);
	$STATUS_DATE=odbc_result($conResult,'STATUS_DATE');
	$PAST_DUE=odbc_result($conResult,'PAST_DUE');
	$UNBILLED=odbc_result($conResult,'UNBILLED');
	$TOTAL=odbc_result($conResult,'TOTAL'); 
	$DEPOSIT=odbc_result($conResult,'DEPOSIT');
	$LIMIT=odbc_result($conResult,'LIMIT');
	$CREDIT_LIMIT=odbc_result($conResult,'CREDIT_LIMIT');
	$PERCENTAGE_ON_LIMIT=odbc_result($conResult,'PERCENTAGE_ON_LIMIT');
	
	
	$conn_mdb_cum=odbc_connect('cum','cumdata','cumdata');	
	$cumQry="select * from CORP_UPDATE where SUBNO='$subno'";
	$cumResult=odbc_exec($conn_mdb_cum,$cumQry); 
	$cumCount=odbc_num_rows($cumResult);
	
	$MSISDN=odbc_result($cumResult,'SUBNO');
	$Virtual_Contr=odbc_result($cumResult,'Virtual_Contr');
	//$CONTRNO=odbc_result($cumResult,'CONTRNO');
	$NAME=odbc_result($cumResult,'NAME');
	$EQUIPID=odbc_result($cumResult,'EQUIPID');
	
	if($CONTRNO != "") { $flagContrView=true; } 
	else { $flagContrView=false; $errMsg1="<font color='#FF0000'><p><h4>No Records Found for the selected CONTR No.!! Please try again</h4></p></font>"; }	
		
	
	$fdbkQry="SELECT
	f.entryDate AS `Call Date`,
	f.userId AS `Agent Id`,
	c.campName AS Campaign,
	f1.fdbkName AS `Feedback-1`,
	f2.fdbkName AS `Feedback-2`,
	f.flwupDate AS `Follow-Up Date`,
	f.entryDate AS `Entry Date`,
	f.entryTime AS `Entry Time`,
	f.remarks AS Remarks
	FROM
	feedbackdata AS f
	left Join campaign AS c ON f.campId = c.campId
	left Join feedback1 AS f1 ON f.fdbk1Id = f1.fdbk1Id
	left Join feedback2 AS f2 ON f.fdbk2Id = f2.fdbk2Id
	WHERE
	f.contrNo =  '$contrNo'";
	//$fdbkResult = mysql_query($fdbkQry) or die('Query failed: ' . mysql_error()); 
	//if(mysql_num_rows($fdbkResult)!=0) { $flagFdbkView=true; } 
	/*else { $flagFdbkView=false; $errMsg2="<font color='#FF0000'><p><h4>Feedback Data no Found for the selected CONTR No.!!</h4></p></font>"; }*/	

}	

if(isset($_POST['btnSave']))
{
 	
	
	$NEWEQUIPID	=	$_POST['NEWEQUIPID'];
	$NEWLIMIT	=	$_POST['NEWLIMIT'];
	$LOOPREQUEST	=$_POST['LOOPREQUEST'];
	$REQUESTTYPE	=$_POST['REQUESTTYPE'];
	$remarks	=	addslashes($_POST['remarks']);
	$DESCRIPTION	=	addslashes($_POST['DESCRIPTION']);
	$new_add	=	addslashes($_POST['hidaddress']);
	$MSISDN		=	$_POST['msisdn'];
	$CONTRNO	=	$_POST['hidcontrno'];
	$Virtual_Contr	=	$_POST['vircontrno'];
	$subno			=	$_POST['subno'];
	$NAME		=	$_POST['comp_name'];
	$EQUIPID	=	$_POST['equipid'];
	$CUSTNAME	=	$_POST['cust_name'];
	
	$CATEGORY	=	$_POST['category'];
	$LIMIT		=	$_POST['limit'];
	
	
		$query2="INSERT INTO  request_data (MSISDN,CONTRNO,Virtual_Contr,subno,EQUIPID,NEWEQUIPID,CUSTNAME,COMPNAME,CATEGORY,`LIMIT`,NEWLIMIT,Address,LOOPREQUEST,DESCRIPTION,REMARKS,REQUESTTYPE,REQUESTSTATUS,REQDATE,REQTIME,REQUESTBY) 
values('$MSISDN','$CONTRNO','$Virtual_Contr','$subno','$EQUIPID','$NEWEQUIPID','$CUSTNAME','$NAME','$CATEGORY','$LIMIT','$NEWLIMIT','$new_add','$LOOPREQUEST','$DESCRIPTION','$remarks','$REQUESTTYPE','Open',curdate(),curtime(),'$userId')";


		$result2 = mysql_query($query2);
		
			
	
		if($result2)
		{
			$last_req_id	=	mysql_insert_id();
			
			$sql	=	"INSERT INTO req_history VALUES";
			$sql	.=	"('$last_req_id','Open',"; 	
			$sql	.=	"curdate(),curtime(),'$userId')";
			
			//echo $sql; 
			$result3	=	mysql_query($sql) or die(mysql_error());
			
			//echo $last_req_id; exit;
		
			echo "<script language='javascript'>\n";
   			echo "alert('Saved sucessfully')";
  			echo "</script>";
			
		}
		
		else 
		 {
				
				echo "<script language='javascript'>\n";
				echo "alert('Not Saved')";
				echo "</script>";
				
		 }
		 
		 
			echo "<script language='javascript'>\n";
   			echo "window.location='addrequest.php';";
  			echo "</script>";
} 



if(!empty($subno))
{
	$fdbkQry="SELECT
				MSISDN,
				CONTRNO,
				NEWEQUIPID as `Req EQUIPID`,
				CUSTNAME,
				NEWLIMIT as `Req Limit`,
				LOOPREQUEST,
				DESCRIPTION,
				REMARKS,
				REQUESTTYPE,
				REQUESTSTATUS,
				REQDATE,
				REQTIME,
				REQUESTBY
	FROM
	request_data
	WHERE
	MSISDN =  '$subno' order by `REQDATE` desc";
	$fdbkResult = mysql_query($fdbkQry) or die('Query failed: ' . mysql_error()); 
	if(mysql_num_rows($fdbkResult)!=0) { $flagFdbkView=true; } 
	else { $flagFdbkView=false; $errMsg2="<font color='#FF0000'><p><h4>Feedback Data no Found for the selected CONTR No.!!</h4></p></font>"; }	

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
<script type="text/javascript" src="entry_frm.js"></script>
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
function frmChk(form)
	{
		var campaign= document.getElementById('campaign');
		var fdbk1= document.getElementById('fdbk1');
					
			if(campaign.value=="")
			{
				window.alert('Please select campaign');
				form.campaign.focus();
				return false;
			}
			if(fdbk1.value=="")
			{
				window.alert('Please select Feedback-1');
				form.fdbk1.focus();
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
<?php echo $access; ?>
<form name="cotrnoSearch" method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>" >
<table align="center" cellpadding="1" cellspacing="1"bgcolor="#d9effd">
	<tr>
      <td class="label" align="right">SUBNO:</td>
      <td class="td"><input name="subno" type="text" id="subno" value="<?php echo $subno;?>"></td>
  
        <td align="center">
		
		<input name="btnSearch" type="Submit" class="loginButton" id="btnSearch" value="  Search   " onclick="return(chkContrno(this.form));"> <!-- -->
		</td>
	</tr>
</table>		
</form>
<?php 

if(!empty($errMsg1)) echo $errMsg1;

//echo $flagContrView;
if($flagContrView) { ?>



<table width="90%" align="center" cellspacing="0" class="table">
    <tr bgcolor="#D7D7FF">
      <td colspan="6" class="label2"><div align="center">CONTRNO Details</div></td>
    </tr>
	<tr>
      <td align="right" class="label2">CONTRNO:</td>
	  <td class="td1"><?php echo $CONTRNO; ?></td>
	  <td align="right" class="label2">MSISDN:</td>
	  <td class="td1"><?php echo $MSISDN; ?></td>
	  <td align="right" class="label2">COMPANY NAME:</td>
	  <td class="td1"><?php echo $NAME; ?></td>
  </tr> 
	 <tr>
      <td align="right" class="label2">Virtual CONTRNO:</td>
	  <td class="td1"><?php echo $Virtual_Contr; ?></td>
	  <td align="right" class="label2">EQUIPID:</td>
	  <td class="td1"><?php echo $EQUIPID; ?></td>
	  <td align="right" class="label2">CUSTNAME:</td>
	  <td class="td1"><?php echo $CUSTNAME; ?></td>
	 </tr> 
	 <tr>
	   <td align="right" class="label2">CATEGORY:</td>
	   <td class="td1"><?php echo $CATEGORY; ?></td>
	   <td align="right" class="label2">LIMIT:</td>
	   <td class="td1"><?php echo $LIMIT; ?></td>
	   <td align="right" class="label2">Address:</td>
	   <td class="td1"><?php echo $Add; ?>
       
       </td>
  </tr>
    
</table>

<form name="agentEntry" method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>" >
<table width="80%" align="center" cellspacing="0" bgcolor="#d9effd">
    <tr class="table_header">
      <td colspan="6"><div align="center">Request Entry Form </div></td>
    </tr>
    <tr>
      <td align="right" class="td"><span class="label">NEW EQUIPID :</span></td>
      <td class="td"><input type="text" id="NEWEQUIPID" name="NEWEQUIPID" /></td>
      <td class="td" align="right"><span class="label">New Limit :</span></td>
          
     <td class="td"><input type="text" id="NEWLIMIT" name="NEWLIMIT" /></td>
     <td align="right" class="td"><span class="label">Request Loop :</span></td>
     <td class="td"><input type="text" id="LOOPREQUEST" name="LOOPREQUEST" /></td>
    </tr>
    
	<tr>
      <td class="td" align="right"><span class="label">Request Type :</span></td>
	  <td class="td">
       <select  name="REQUESTTYPE" id="REQUESTTYPE" >
            <option value="">--Choose Req Type--</option>
            <option value="Credit Limit Change">Credit Limit Change</option>
            <option value="OPLOOP">OPLOOP</option>
            <option value="TDP2PLOOP">TDP2PLOOP</option>         
           
         </select>		 </td>
		 <td class="td" align="right"><span class="label">Description:</span></td>
          
          <td class="td"><textarea name="DESCRIPTION" cols="40" id="DESCRIPTION" ></textarea></td>
	  <td class="td" align="right"><span class="label">Remarks: </span></td>
      <td class="td"><textarea name="remarks" cols="40" id="remarks" ></textarea></td>
    </tr>
	
	<tr>
	<td colspan="6" class="td" align="center">
    
    <input name="msisdn" type="hidden" id="msisdn" value="<?php echo $MSISDN; ?>" />
    
    <input name="hidcontrno" type="hidden" id="hidcontrno" value="<?php echo $CONTRNO;?>" />
     <input name="vircontrno" type="hidden" id="vircontrno" value="<?php echo $Virtual_Contr; ?>" />    
    <input name="hidaddress" type="hidden" id="hidaddress" value="<?php echo $Add;?>" />
     <input name="comp_name" type="hidden" id="comp_name" value="<?php echo $NAME;?>" />
      <input name="equipid" type="hidden" id="equipid" value="<?php echo $EQUIPID;?>" />
        <input name="cust_name" type="hidden" id="cust_name" value="<?php echo $CUSTNAME;?>" />
         <input name="category" type="hidden" id="category" value="<?php echo $CATEGORY;?>" />
       <input name="limit" type="hidden" id="limit" value="<?php echo $LIMIT;?>" />
     <input name="subno" type="hidden" id="subno" value="<?php echo $subno;?>" />	
     
	  <input name="btnSave" type="submit" class="loginButton" id="btnSave" value="     Save     " onclick="return(frmChk(this.form));" />
	  <input name="btnCancel" type="reset" class="loginButton" id="btnCancel" value="  reset  " />	  <div align="center" ></div></td>
	</tr>
	
    
  </table>
</form>

<?php odbc_close($conn_mdb); }


if(!empty($errMsg2)) echo $errMsg2;

if($flagFdbkView)
	{
		$out .='';
		$columns = mysql_num_fields($fdbkResult);
		$out .= '<table width="90%" align="center" class="table"><tr bgcolor="#D7D7FF"><td class="label2" align="center" colspan="'.$columns.'">request History</td></tr><tr>';
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
