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

if(isset($_POST['Approve']))
{
	$stat	=	$_POST['checkbox_test'];
	//print_r($stat); exit;
	
	 $sql 	 = "UPDATE request_data SET REQUESTSTATUS='Approved' WHERE REQID in ";
	 $sql	.= "('".implode("','",array_values($_POST['checkbox_test']))."')";
	  
	  $result	=	mysql_query($sql);
	  
	  
	  for($i=0;$i<count($stat);$i++)
	  {
		//  echo $stat[$i]; exit;
	  $sqlins	=	"INSERT INTO req_history Values";
	  $sqlins	.=	"('".$stat[$i]."','Approved',curdate(),curtime(),'$userId')";
	  //echo $sqlins; exit;
	  
	  $resultins	=	mysql_query($sqlins) or die(mysql_error());
	  }
}

if(isset($_POST['FollowUp']))
{
	$stat	=	$_POST['checkbox_test'];
	//print_r($stat); exit;
	
	 $sql 	 = "UPDATE request_data SET REQUESTSTATUS='FollowUp' WHERE REQID in ";
	 $sql	.= "('".implode("','",array_values($_POST['checkbox_test']))."')";
	  
	  $result	=	mysql_query($sql);
	  
	  
	  for($i=0;$i<count($stat);$i++)
	  {
		//  echo $stat[$i]; exit;
	  $sqlins	=	"INSERT INTO req_history Values";
	  $sqlins	.=	"('".$stat[$i]."','FollowUp',curdate(),curtime(),'$userId')";
	  //echo $sqlins; exit;
	  
	  $resultins	=	mysql_query($sqlins) or die(mysql_error());
	  }
}

if(isset($_POST['Reject']))
{
	$stat	=	$_POST['checkbox_test'];
	//print_r($stat); exit;
	
	 $sql 	 = "UPDATE request_data SET REQUESTSTATUS='Reject' WHERE REQID in ";
	 $sql	.= "('".implode("','",array_values($_POST['checkbox_test']))."')";
	  
	  $result	=	mysql_query($sql);
	  
	  
	  for($i=0;$i<count($stat);$i++)
	  {
		//  echo $stat[$i]; exit;
	  $sqlins	=	"INSERT INTO req_history Values";
	  $sqlins	.=	"('".$stat[$i]."','Reject',curdate(),curtime(),'$userId')";
	  //echo $sqlins; exit;
	  
	  $resultins	=	mysql_query($sqlins) or die(mysql_error());
	  }
}


if(isset($_POST['btnView']))
{
 		$from=$_POST['startDate'];
		$to=$_POST['endDate'];
		//$c=$_POST['campaign'];
		//if($c!="") $campaign=" and f.campId='".$c."'"; else $campaign="";
		if(!empty($from) && !empty($to))
		{
			
				
			//$fdbkQry="select * from feedbackData where contrNo='$contrNo'";
			$fdbkQry="SELECT
				REQID,
				MSISDN,
				CONTRNO,
				NEWEQUIPID ,
				CUSTNAME,
				NEWLIMIT ,
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
			REQDATE between  '$from' and '$to' order by `REQDATE` desc";
			//echo $fdbkQry;
			$fdbkResult = mysql_query($fdbkQry) or die('Query failed: ' . mysql_error()); 
			if(mysql_num_rows($fdbkResult)!=0) { $flagFdbkView=true; } 
			else { $flagFdbkView=false; $errMsg2="<font color='#FF0000'><p><h4>No Request Found!!</h4></p></font>"; }	
		
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

function Btn_submit()
		{
			document.fdbkReport.action='view_request.php';
				
		}
function Btn_exp()
		{
			document.fdbkReport.action='exp_excel_request.php';
				
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
	<!--<td class="td" align="right"><span class="label">Campaign :</span></td>
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
         </select>		 </td>-->
  
        <td>
		
		<input name="btnView" type="Submit" class="loginButton" id="btnView" value="View Report"  onclick="Btn_submit();"> 
		<input name="btn_Exp_Req_Report" type="Submit" class="loginButton" id="btn_Exp_Req_Report" value="Export Data"  onclick=" Btn_exp();"> 
		</td>
	</tr>
</table>		
</form>
<?php 

if(!empty($errMsg2)) echo $errMsg2;

if($flagFdbkView)
	{ ?>
 <form name="aprreject" id="aprreject" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">   
<table width="90%" align="center" class="table"><tr bgcolor="#D7D7FF">
<td class="label2" align="center" colspan="13">New Request</td></tr>
<tr>
	<th class="th1">&nbsp;</th>   
    <th class="th1">MSISDN</th>
    <th class="th1">CONTRNO</th> 
    <th class="th1">Req EQUIPID</th> 
    <th class="th1">Sub No.</th>
    <th class="th1">CUSTNAME</th> 
    <th class="th1">Req Limit</th> 
    <th class="th1">LOOPREQUEST</th> 
    <th class="th1">DESCRIPTION</th> 
    <th class="th1">REMARKS</th> 
    <th class="th1">REQUESTTYPE</th> 
    <th class="th1">REQUESTSTATUS</th> 
    <th class="th1">REQDATE</th> 
    <th class="th1">REQUESTBY</th>
    <th class="th1">Action</th> 
</tr> 

<?php  
while ($r = mysql_fetch_array($fdbkResult)) 
			{
             
			?>
          <tr>
          
    
            <td class="td1"><input type="checkbox" name="checkbox_test[]" value="<?php echo $r['REQID'];?>" /></td>
            <td class="td1"><?php echo $r['MSISDN'];?></td>
            <td class="td1"><?php echo $r['CONTRNO'];?></td>
            <td class="td1"><?php echo $r['NEWEQUIPID'];?></td>
            <td class="td1"><?php echo $r['MSISDN'];?></td>
            <td class="td1"><?php echo $r['CUSTNAME'];?></td>
            <td class="td1"><?php echo $r['NEWLIMIT'];?></td>
            <td class="td1"><?php echo $r['LOOPREQUEST'];?></td>
            <td class="td1"><?php echo $r['DESCRIPTION'];?></td>
            <td class="td1"><?php echo $r['REMARKS'];?></td>
            <td class="td1"><?php echo $r['REQUESTTYPE'];?></td>
            <td class="td1"><?php echo $r['REQUESTSTATUS'];?></td>
            <td class="td1"><?php echo $r['REQDATE'];?></td>
            <td class="td1"><?php echo $r['REQUESTBY'];?></td>
            <td class="td1"><a href="details.php?id=<?php echo $r['REQID'];?>">Details</a></td>
            </tr>
            
<?php }//end while?> 
<tr>
            <td class="td1" colspan="13">
                <input type="submit" value="Approve" name="Approve" class="subbtn" title="Approve"/>
                <input type="submit" value="FollowUp" name="FollowUp" class="subbtn" title="FollowUp"/>
                <input type="submit" value="Reject" name="Reject" class="subbtn" title="Reject"/>
              </td>
          </tr>
          </table>
          </form>
      
<?php		
	}				

 ?>
</body>
</html>
