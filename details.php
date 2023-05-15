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

$rid	=	$_GET['id'];

$sql	=	"SELECT MSISDN,REQDATE,REQUESTTYPE,REQUESTBY,REQUESTSTATUS,DESCRIPTION,REMARKS,CUSTNAME";
$sql	.=	" FROM ";
$sql	.=	"request_data WHERE REQID='".$rid."'";

//echo $sql; exit;
$exec	=	mysql_query($sql) or die(mysql_error());

$row	=	mysql_fetch_array($exec);

$msisdn		=	$row['MSISDN'];
$reqtype	=	$row['REQUESTTYPE'];
$rdate		=	$row['REQDATE'];
$cname		=	$row['CUSTNAME'];
$rby		=	$row['REQUESTBY'];
$rmks		=	$row['REMARKS'];
$rstatus	=	$row['REQUESTSTATUS'];
$desc		=	$row['DESCRIPTION'];



if(!empty($msisdn))
{
	$conn_mdb=odbc_connect('bdr','ccdmis','ccdmis');
	$contQry="select * from BDR_output where SUBNO='$msisdn'";
	$conResult=odbc_exec($conn_mdb,$contQry); 
	$conCount=odbc_num_rows($conResult);
	
	$status			=	odbc_result($conResult,'STATUS');	
	$category		=	odbc_result($conResult,'CATEGORY');
	$activation		=	odbc_result($conResult,'ACTIVATION_DATE');
	$pastdue		=	odbc_result($conResult,'PAST_DUE');	
	$unbilled		=	odbc_result($conResult,'UNBILLED');
	$total			=	odbc_result($conResult,'TOTAL');	
	$creditlimit	=	odbc_result($conResult,'CREDIT_LIMIT');
	$open_inv		=	odbc_result($conResult,'OPEN_INVOICE');
	$avg_pmt		=	odbc_result($conResult,'AVERAGE_PAYMENT');
	$last_pay_date	=	odbc_result($conResult,'LAST_PAY_DATE');
	$last_pay_amnt	=	odbc_result($conResult,'LAST_PAID_AMOUNT');
	$avg_inv		=	odbc_result($conResult,'AVG_LIFETIME_INVOICE');
	
	
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


</head>

<body bgcolor="#f3f3f3">

 <form name="aprreject" id="aprreject" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">   
<table width="90%" align="center" class="table"><tr bgcolor="#D7D7FF">
<td class="label2" align="center" colspan="13">Details</td></tr>
<tr>
    <th class="th1">Request Type</th>
    <th class="th1">Request Date</th> 
    <th class="th1">MSISDN</th> 
    <th class="th1">Customer Name</th> 
    <th class="th1">Requested By</th> 
    <th class="th1">Remarks</th> 
    <th class="th1">Request Status</th> 
    <th class="th1">Details</th> 
    <th class="th1">Activation Date</th>
    <th class="th1">Category</th>
    <th class="th1">Status</th>
    <th class="th1">Past Due</th>
    <th class="th1">Unbilled</th>
    <th class="th1">Total</th>
    <th class="th1">Credit Limit</th>
    <th class="th1">Open Invoice</th>
    
    <th class="th1">Average Invoice</th>
    <th class="th1">Average Payment</th>
    <th class="th1">Last Payment Date</th>
    <th class="th1">Last Payment Amount</th>
   
</tr> 

<?php  
//while ($r = mysql_fetch_array($exec)) 
	//{
           
		   //print_r($r); exit;  
			?>
          <tr>
            <td class="td1"><?php echo $reqtype;?></td>
            <td class="td1"><?php echo $rdate;?></td>
            <td class="td1"><?php echo $msisdn;?></td>
            <td class="td1"><?php echo $cname;?></td>
            <td class="td1"><?php echo $rby;?></td>
            <td class="td1"><?php echo $rmks;?></td>
            <td class="td1"><?php echo $rstatus;?></td>
            <td class="td1"><?php echo $desc;?></td>
            <td class="td1"><?php echo $activation;?></td>
            <td class="td1"><?php echo $category;?></td>
            <td class="td1"><?php echo $status;?></td>
            <td class="td1"><?php echo $pastdue;?></td>
            <td class="td1"><?php echo $unbilled;?></td>
            <td class="td1"><?php echo $total;?></td>
            <td class="td1"><?php echo $creditlimit;?></td>
            <td class="td1"><?php echo $open_inv;?></td>            
            <td class="td1"><?php echo $avg_inv;?></td>
            <td class="td1"><?php echo $avg_pmt;?></td>
            <td class="td1"><?php echo $last_pay_date;?></td>
            <td class="td1"><?php echo $last_pay_amnt;?></td>
            
            </tr>
            
<?php //}//end while?> 

          </table>
          </form>
      

</body>
</html>
