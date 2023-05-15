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



if(isset($_POST['btnSubmit']))
{
 	 require 'Classes/PHPExcel.php';
	 require_once 'Classes/PHPExcel/IOFactory.php';
	// $objPHPExcel = new PHPExcel();
	
	//Check valid spreadsheet has been uploaded
	move_uploaded_file($_FILES["spreadsheet"]["tmp_name"],"up/" . $_FILES["spreadsheet"]["name"]);
				$objReader = PHPExcel_IOFactory::createReader('Excel2007');
			$objReader->setReadDataOnly(true);
			$objPHPExcel = new PHPExcel();
			$objPHPExcel = PHPExcel_IOFactory::load("up/".$_FILES["spreadsheet"]["name"]);;
        
			$objWorksheet = $objPHPExcel->getActiveSheet();
			
			$highestRow = $objWorksheet->getHighestRow(); // e.g. 10
			$highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'
			
			$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5
			
	for($row = 2; $row <= $highestRow; ++$row) 
	{
		for($col = 0; $col < $highestColumnIndex; ++$col) 
		{     
			$rows[$col] = $objWorksheet->getCellByColumnAndRow($col, $row);
		}
	
		$query = "INSERT INTO  request_data (MSISDN,CONTRNO,Virtual_Contr,subno,EQUIPID,NEWEQUIPID,CUSTNAME,COMPNAME,CATEGORY,`LIMIT`,NEWLIMIT,Address,LOOPREQUEST,DESCRIPTION,REMARKS,REQUESTTYPE,REQUESTSTATUS,REQDATE,REQTIME,REQUESTBY) 
values('".$rows[0]."','".$rows[1]."','".$rows[2]."','".$rows[3]."','".$rows[4]."','".$rows[5]."','".$rows[6]."','".$rows[7]."','".$rows[8]."','".$rows[9]."','".$rows[10]."','".$rows[11]."','".$rows[12]."','".$rows[13]."','".$rows[14]."','".$rows[15]."','Open',curdate(),curtime(),'$userId')";

$exex = mysql_query($query) or die(mysql_error());
	
	
	if($exex)
		{
			$last_req_id	=	mysql_insert_id();
			
			$sql	=	"INSERT INTO req_history VALUES";
			$sql	.=	"('$last_req_id','Open',"; 	
			$sql	.=	"curdate(),curtime(),'$userId')";
			
			//echo $sql; 
			$result3	=	mysql_query($sql) or die(mysql_error());
		}
	}
	
			//echo $last_req_id; exit;
		
			echo "<script language='javascript'>\n";
   			echo "alert('Saved sucessfully')";
  			echo "</script>";
			
			echo "<script language='javascript'>\n";
   			echo "window.location='bulk_request.php';";
  			echo "</script>";
		
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

</script>
</head>

<body bgcolor="#f3f3f3">
<?php echo $access; ?>
<form name="bulkupload" method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
<table align="center" cellpadding="1" cellspacing="1"bgcolor="#d9effd">
	<tr>
      <td class="label" align="right">Upload File:</td>
      <td class="td">
      <input name="spreadsheet" type="file"></td>
  
        <td align="center">
		
		<input name="btnSubmit" type="Submit" class="loginButton" id="btnSubmit" value="  Upload   "> 
	  </td>
	</tr>
</table>		
</form>
<?php 

if(!empty($errMsg1)) echo $errMsg1;

//echo $flagContrView;
if($flagContrView) { ?>
<form name="agentEntry" method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>" >
</form>

<?php }?>
</body>
</html>
