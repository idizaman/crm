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

if(isset($_POST['btnSearch']))  $contrNo=$_POST['contrno']; else $contrNo= $_POST['hidcontrno'];

if(!empty($contrNo))
{
//	echo 'here';
	
	$conn_mdb=odbc_connect('bdr','ccdmis','ccdmis');
	$contQry="select * from BDR_output where CONTRNO='$contrNo'";
	$conResult=odbc_exec($conn_mdb,$contQry); 
	$conCount=odbc_num_rows($conResult);
	
	$CONTRNO=odbc_result($conResult,'CONTRNO');
	
	
	$CATEGORY=odbc_result($conResult,'CATEGORY');
	$EQUIPID=odbc_result($conResult,'EQUIPID');
	$CUSTNAME=odbc_result($conResult,'CUSTNAME');
	
	$STREET=odbc_result($conResult,'STREET');
	$ADDRESS2=odbc_result($conResult,'ADDRESS2');
	
	$Add=$STREET.','.$ADDRESS2;
	$STATUS_DATE=odbc_result($conResult,'STATUS_DATE');
	$PAST_DUE=odbc_result($conResult,'PAST_DUE');
	$UNBILLED=odbc_result($conResult,'UNBILLED');
	$TOTAL=odbc_result($conResult,'TOTAL'); 
	$DEPOSIT=odbc_result($conResult,'DEPOSIT');
	$LIMIT=odbc_result($conResult,'LIMIT');
	$CREDIT_LIMIT=odbc_result($conResult,'CREDIT_LIMIT');
	$PERCENTAGE_ON_LIMIT=odbc_result($conResult,'PERCENTAGE_ON_LIMIT');
	
	
	$conn_mdb_cum=odbc_connect('cum','cumdata','cumdata');	
	$cumQry="select * from CORP_UPDATE where CONTRNO='$contrNo'";
	$cumResult=odbc_exec($conn_mdb_cum,$cumQry); 
	$cumCount=odbc_num_rows($cumResult);
	
	$MSISDN=odbc_result($cumResult,'SUBNO');
	$Virtual_Contr=odbc_result($cumResult,'Virtual_Contr');
	//$CONTRNO=odbc_result($cumResult,'CONTRNO');
	$NAME=odbc_result($cumResult,'NAME');
	$EQUIPID=odbc_result($cumResult,'EQUIPID');
	
	
	

	
	if($CONTRNO != "") { $flagContrView=true; } 
	else { $flagContrView=false; $errMsg1="<font color='#FF0000'><p><h4>No Records Found for the selected CONTR No.!! Please try again</h4></p></font>"; }	
		
	
	

}	


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="main.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="popcalendar.js"></script>
</head>

<body bgcolor="#f3f3f3">
<form name="cotrnoSearch" method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>" >
<table align="center" cellpadding="1" cellspacing="1"bgcolor="#d9effd">
	<tr>
      <td class="label" align="right">CONTRNO:</td>
      <td class="td"><input name="contrno" type="text" id="contrno" value="<?php echo $contrNo;?>"></td>
  
        <td align="center">
		
		<input name="btnSearch" type="Submit" class="loginButton" id="btnSearch" value="  Search   " onclick="return(chkContrno(this.form));"> <!-- -->
		</td>
	</tr>
</table>		
</form>

<!--<form name="addrequest" method="POST" action="<?php // echo $_SERVER['PHP_SELF'];?>" >
<table align="center" cellpadding="1" cellspacing="1"bgcolor="#d9effd">
	<tr>
      <td class="label" align="right">MSISDN:</td>
      <td class="td"><input name="msisdn" type="text" id="msisdn" value=""></td>
 	</tr>
    <tr>
      <td class="label" align="right">Virtual Contract No:</td>
      <td class="td"><input name="vconno" type="text" id="vconno" value=""></td>
 	</tr>
    <tr>
      <td class="label" align="right">Contract No:</td>
      <td class="td"><input name="conno" type="text" id="conno" value=""></td>
 	</tr>
     <tr>
      <td class="label" align="right">Customer Name:</td>
      <td class="td"><input name="cust_name" type="text" id="cust_name" value=""></td>
 	</tr>
    
    <tr>
      <td class="label" align="right">Address:</td>
      <td class="td"><input name="address" type="text" id="address" value=""></td>
 	</tr>
    <tr>
      <td class="label" align="right">Category:</td>
      <td class="td"><input name="category" type="text" id="category" value=""></td>
 	</tr>
     <tr>
      <td class="label" align="right">Limit:</td>
      <td class="td"><input name="limit" type="text" id="limit" value=""></td>
 	</tr>
     <tr>
      <td class="label" align="right">New Limit:</td>
      <td class="td"><input name="new_limit" type="text" id="new_limit" value=""></td>
 	</tr>
     <tr>
      <td class="label" align="right">EQUIPID:</td>
      <td class="td"><input name="equipid" type="text" id="equipid" value=""></td>
 	</tr>
     <tr>
      <td class="label" align="right">New EQUIPID:</td>
      <td class="td"><input name="new_equipid" type="text" id="new_equipid" value=""></td>
 	</tr>
     <tr>
      <td class="label" align="right">Loop Request:</td>
      <td class="td"><input name="loop_request" type="text" id="loop_request" value=""></td>
 	</tr>
    <tr>
      <td class="label" align="right">Description:</td>
      <td class="td"><input name="description" type="text" id="description" value=""></td>
 	</tr>
     <tr>
      <td class="label" align="right">Remarks :</td>
      <td class="td"><textarea name="remarks" rows="8" cols="30"></textarea></td>
 	</tr>
     <tr>
      <td class="label" align="right">Request Type:</td>
      <td class="td"><input name="request_type" type="text" id="request_type" value=""></td>
    
 	</tr>
     <tr>
      <td class="label" align="right">&nbsp;</td>
      <td class="td">  <input name="btnSearch" type="Submit" class="loginButton" id="btnSearch" value="  Search   " onclick="return(chkContrno(this.form));"></td>
 	</tr>
</table>		
</form>-->
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
	   <td class="td1"><?php echo $Add; ?></td>
  </tr>
    <!-- <tr>
      <td align="right" class="label2">UNBILLED:</td>
	  <td class="td1"><?php echo $UNBILLED; ?></td>
	  <td align="right" class="label2">TOTAL:</td>
	  <td class="td1"><?php echo $TOTAL; ?></td>
	  <td align="right" class="label2">DEPOSIT:</td>
	  <td class="td1"><?php echo $DEPOSIT; ?></td>
	 </tr>
	 	 <tr>
      <td align="right" class="label2">LIMIT:</td>
	  <td class="td1"><?php echo $LIMIT; ?></td>
	  <td align="right" class="label2">CREDIT_LIMIT:</td>
	  <td class="td1"><?php echo $CREDIT_LIMIT;?></td>
	  <td align="right" class="label2">PERCENTAGE_ON_LIMIT:</td>
	  <td class="td1"><?php echo $PERCENTAGE_ON_LIMIT; ?></td>
	 </tr> -->
</table>
</body>
</html>