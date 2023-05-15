<?php
/*******SESSION MAINTENANCE***********/
session_start();
if(!isset($_SESSION['crm_uid'])&&!isset($_SESSION['access']))
{die('<p><b>Session Time out. Please Click <a href="index.php" target="_top">here</a> for new Session</b></p>');}
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
	//echo '$conn_mdb:'.$conn_mdb=odbc_connect('bdr','ccdmis','ccdmis');
	$mdbFilename = 'E:\CRM_Data\BDR_output.mdb';
	$user = 'ccdmis';
	$password = 'ccdmis';

	$conn_mdb = odbc_connect("Driver={Microsoft Access Driver (*.mdb)};Dbq=$mdbFilename", $user, $password);

	$contQry="select * from BDR_output where SUBNO='$contrNo'";
	$conResult=odbc_exec($conn_mdb,$contQry);
	
	$conCount=odbc_num_rows($conResult);
	
	$CONTRNO=odbc_result($conResult,'CONTRNO');
	$SUBNO=odbc_result($conResult,'SUBNO');
	$NO_OF_LINES=odbc_result($conResult,'NO_OF_LINES'); 
	$CATEGORY=odbc_result($conResult,'CATEGORY');
	$EQUIPID=odbc_result($conResult,'EQUIPID');
	$CUSTNAME=odbc_result($conResult,'CUSTNAME');
	$STATUS=odbc_result($conResult,'STATUS');
	$STATUS_DATE=odbc_result($conResult,'STATUS_DATE');
	$PAST_DUE=odbc_result($conResult,'PAST_DUE');
	$UNBILLED=odbc_result($conResult,'UNBILLED');
	$TOTAL=odbc_result($conResult,'TOTAL'); 
	$DEPOSIT=odbc_result($conResult,'DEPOSIT');
	$LIMIT=odbc_result($conResult,'LIMIT');
	$CREDIT_LIMIT=odbc_result($conResult,'CREDIT_LIMIT');
	$PERCENTAGE_ON_LIMIT=odbc_result($conResult,'PERCENTAGE_ON_LIMIT');
	
	//odbc_close($conn_mdb);
	
	
	/*$contQry="select * from BDR_output where CONTRNO='$contrNo'";
	$conResult=mysql_query($contQry);
	$conCount=mysql_num_rows($conResult);*/
	
	if($CONTRNO != "") 
	{ 
		$flagContrView=true; 
	} 
	else 
	{ 
		$flagContrView=false; 
		$errMsg1="<font color='#FF0000'><p><h4>No Records Found for the selected CONTR No.!! Please try again</h4></p></font>"; 
	}	
		
	
	$fdbkQry="SELECT
	f.entryDate AS `Call Date`,
	f.userId AS `Agent Id`,
	c.campName AS Campaign,
	f1.fdbkName AS `Feedback-1`,
	f2.fdbkName AS `Feedback-2`,
	f3.fdbkName AS `Feedback-3`,
	f.flwupDate AS `Follow-Up Date`,
	f.entryDate AS `Entry Date`,
	f.entryTime AS `Entry Time`,
	f.remarks AS Remarks
	FROM
	feedbackdata AS f
	left Join campaign AS c ON f.campId = c.campId
	left Join feedback1 AS f1 ON f.fdbk1Id = f1.fdbk1Id
	left Join feedback2 AS f2 ON f.fdbk2Id = f2.fdbk2Id
	left Join feedback3 AS f3 ON f.fdbk3Id = f3.fdbk3Id
	Left Join bdrdata as bd on bd.contrNo = f.contrno
	WHERE bd.subno = '$contrNo' "
        . "order by f.entryDate DESC";
        //WHERE
	//f.contrNo =  '$contrNo'";
	
	$fdbkResult = mysql_query($fdbkQry) or die('Query failed: ' . mysql_error()); 
	if(mysql_num_rows($fdbkResult)!=0) { $flagFdbkView=true; } 
	else { $flagFdbkView=false; $errMsg2="<font color='#FF0000'><p><h4>Feedback Data not found for the selected MSISDN.!!</h4></p></font>"; }	

}	

if(isset($_POST['btnSave']))
{
	$campId=$_POST['campaign'];
	$fdbk1Id=addslashes($_POST['fdbk1']);
	$fdbk2Id=addslashes($_POST['fdbk2']);
	$fdbk3Id=addslashes($_POST['fdbk3']);
	$flwupDate=$_POST['flwupDate'];
	$remarks=addslashes($_POST['remarks']);
	
	
	$datequery="select curdate()+0 as date";
	$dateresult=mysql_query($datequery);
	$date=mysql_result($dateresult,0,'date');
	$dt_fdbkId=$date.$userId;
		
	$fdbkIdquery="select count(fdbkId) sl from feedbackdata where fdbkId like '$dt_fdbkId%'";
	$fdbkIdresult=mysql_query($fdbkIdquery);
	
		if($fdbkIdresult !=null)
		  {
			$maxid=mysql_result($fdbkIdresult,0,'sl');
		  }
		else
		  {
			$maxid=0;
		  }
				 
		$fdbkId=$dt_fdbkId.($maxid+1);
	
	//echo '<br/>'.
 	$query="INSERT INTO feedbackdata (fdbkId,userId,contrNo,campId,fdbk1Id,fdbk2Id,fdbk3Id,flwupDate,remarks,entryDate,entryTime) values('$fdbkId','$userId','$CONTRNO','$campId','$fdbk1Id','$fdbk2Id','$fdbk3Id','$flwupDate','$remarks',curdate(),curtime())";

	$result1 = mysql_query($query);

	//exit;
	
	if($result1)
	 {
                //echo '<br/>'.
		$query2="INSERT INTO bdrdata (`fdbkId`,`contrNo`,`SUBNO`,`NO_OF_LINES`,`CATEGORY`,`EQUIPID`,`CUSTNAME`,`STATUS`,`STATUS_DATE`,`PAST_DUE`,`UNBILLED`,`TOTAL`,`DEPOSIT`,`LIMIT`,`CREDIT_LIMIT`,`PERCENTAGE_ON_LIMIT`) values('$fdbkId','$CONTRNO','$SUBNO','$NO_OF_LINES','$CATEGORY','$EQUIPID','$CUSTNAME','$STATUS','$STATUS_DATE','$PAST_DUE','$UNBILLED','$TOTAL','$DEPOSIT','$LIMIT','$CREDIT_LIMIT','$PERCENTAGE_ON_LIMIT')";

		//exit;

		$result2 = mysql_query($query2); 
                
                //fexit;
	}	
		if($result2)
		{	
			echo "<script language='javascript'>\n";
   			echo "alert('Saved sucessfully')";
  			echo "</script>";
			
		}
		else 
		 {
				//$err=addslashes(mysql_error());
				echo "<script language='javascript'>\n";
				echo "alert('Not Saved')";
				echo "</script>";
				
		 }
		 
			echo "<script language='javascript'>\n";
   			echo "window.location='feedbackEntry.php';";
  			echo "</script>";
} 

if(!empty($contrNo))
{
	$fdbkQry="SELECT
	f.entryDate AS `Call Date`,
	f.userId AS `Agent Id`,
	c.campName AS Campaign,
	f1.fdbkName AS `Feedback-1`,
	f2.fdbkName AS `Feedback-2`,
	f3.fdbkName AS `Feedback-3`,
	f.flwupDate AS `Follow-Up Date`,
	f.entryDate AS `Entry Date`,
	f.entryTime AS `Entry Time`,
	f.remarks AS Remarks
	FROM
	feedbackdata AS f
	left Join campaign AS c ON f.campId = c.campId
	left Join feedback1 AS f1 ON f.fdbk1Id = f1.fdbk1Id
	left Join feedback2 AS f2 ON f.fdbk2Id = f2.fdbk2Id
	left Join feedback3 AS f3 ON f.fdbk3Id = f3.fdbk3Id
    Left Join bdrdata as bd on bd.contrNo = f.contrno
	WHERE bd.subno = '$contrNo' "
            . "group by f.entryDate, f.entryTime"
        . " order by f.entryDate DESC";
            
        //. "order by `Call Date` desc";
	$fdbkResult = mysql_query($fdbkQry) or die('Query failed: ' . mysql_error()); 
	if(mysql_num_rows($fdbkResult)!=0) { $flagFdbkView=true; } 
	else { $flagFdbkView=false; $errMsg2="<font color='#FF0000'><p><h4>Feedback Data not found for the selected MSISDN!!</h4></p></font>"; }	

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
.style5 {
	color: #FFFFFF
}
.style8 {
	font-size: 10px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	border: 1px solid #999999;
}
.style4 {
	font-family: Verdana;
	font-weight: bold;
}
.style10 {
	font-family: verdana;
	font-weight: bold;
	font-size: 10px;
	color: #FFFFFF;
}
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
		//var fdbk3= document.getElementById('fdbk3');
		
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
			
			//alert(fdbk3.value);
			
			/*if(fdbk3.value=="")
			{
				window.alert('Please select Feedback-3');
				form.fdbk3.focus();
				return false;
			}*/
			
			
			return true;
			
}
</script>
</head>

<body bgcolor="#f3f3f3">
<?php //echo $access; ?>
<form name="cotrnoSearch" method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>" >
  <table align="center" cellpadding="1" cellspacing="1"bgcolor="#d9effd">
    <tr>
      <td class="label" align="right">SUBNO:</td>
      <td class="td"><input name="contrno" type="text" id="contrno" value="<?php echo $contrNo;?>"></td>
      <td align="center"><input name="btnSearch" type="Submit" class="loginButton" id="btnSearch" value="  Search   " onclick="return(chkContrno(this.form));">
        <!-- --></td>
    </tr>
  </table>
</form>
<?php 

if(!empty($errMsg1)) echo $errMsg1;

//echo $flagContrView;
if($flagContrView) { ?>
<form name="agentEntry" method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>" >
  <table width="100%" align="center" cellspacing="0" bgcolor="#d9effd">
    <tr class="table_header">
      <td colspan="8"><div align="center">Feedback Entry Form </div></td>
    </tr>
    <tr style="width:auto">
      <td class="td" align="right"><span class="label">Campaign:</span></td>
      <td class="td"><select  name="campaign" id="campaign"  onchange="populateFeedback1(this.form);">
          <option value="">--Choose Campaign--</option>
          <?php
		 
        if($level==2 || $level==3){ ?>
          <option value="8" <?php if($_POST['campaign'] == '8') echo "selected";?>>Telesales Welcome</option>
          <?php
		}
		else {
		
        $i=0;
        while($i < $camp_num)
        {
        ?>
          <option value="<?php echo mysql_result($camp_result,$i,"campId");?>" <?php if($_POST['campaign'] == mysql_result($camp_result,$i,"campId")) echo "selected";?>>
          <?php
        echo mysql_result($camp_result,$i,"campName");
        $i++;
        }
		 }
        ?>
          </option>
        </select></td>
      <td class="td" align="right"><span class="label" style="margin-left:5px;"> Feedback1:</span></td>
      <td class="td"><select name="fdbk1" id="fdbk1" onchange="populateFeedback2(this.form);">
          <option value="" >--Choose Feedback1--</option>
          <?php
        $j=0;
        while($j < $f1_post_num)
        {
        ?>
          <option value="<?php echo mysql_result($f1_post_result,$j,"fdbk1Id");?>" <?php //if($_POST['fdbk1'] == mysql_result($f1_post_result,$j,"fdbk1Id")) echo "selected";?>>
          <?php
        echo mysql_result($f1_post_result,$j,"fdbkName");
        $j++;
        }
        ?>
          </option>
        </select></td>
      <td class="td" align="right"><span class="label">Feedback2:</span></td>
      <td class="td"><select name="fdbk2" id="fdbk2">
          <option value="">--Choose Feedback2--</option>
          <?php
       /* $k=0;
        while($k < $f2_post_num)
        {*/
        ?>
          <!-- <option value="<?php //echo mysql_result($f2_post_result,$k,"fdbk2Id");?>" <?php //if($_POST['fdbk2'] == mysql_result($f2_post_result,$k,"fdbk2Id")) echo "selected";?>>
        <?php
        /*echo mysql_result($f2_post_result,$k,"fdbkName");
        $k++;
        }*/
        ?>
        </option> -->
        </select></td>
      <td class="td" align="right"><span class="label" style="margin-left:5px;">Feedback3:</span></td>
      <td class="td"><select name="fdbk3" id="fdbk3">
          <option value="">--Choose Feedback3--</option>
          <?php 
			$q = 0;
			while($q < $f3_num)
			{
			?>
          <option value="<?php echo mysql_result($f3_result,$q,"fdbk3Id")?>"><?php echo mysql_result($f3_result,$q,"fdbkName") ?></option>
          <?php 
			$q++;
			} 
			?>
        </select></td>
    </tr>
    <tr>
      <td class="td"><span class="label">Follow Up Date:</span></td>
      <td class="td" colspan=""><input name="flwupDate" type="text" value="<?php if($_POST['fdate']) echo $_POST['fdate']; else echo date('Y-m-d');?>" size="10" class="select" />
        <img src="images/cal.gif" alt="Pick a Date" align="absmiddle" style="cursor:pointer;cursor:hand;" onClick=    	"popUpCalendar(this,document.agentEntry.flwupDate,'yyyy-mm-dd');return false;"></td>
      <td class="td" colspan=""><span class="label">Remarks: </span></td>
      <td><textarea name="remarks" cols="40" id="remarks" ></textarea></td>
      <td colspan="4" style="vertical-align:center;"><div align="center" >
          <input name="hidcontrno" type="hidden" id="hidcontrno" value="<?php echo $contrNo;?>">
          <input name="btnSave" type="Submit" class="loginButton" id="btnSave" value="     Save     " onClick="return(frmChk(this.form));" >
          <input name="btnCancel" type="reset" class="loginButton" id="btnCancel" value="  Reset  ">
        </div></td>
    </tr>
  </table>
</form>
<table width="90%" align="center" cellspacing="0" class="table">
  <tr bgcolor="#D7D7FF">
    <td colspan="6" class="label2"><div align="center">CONTRNO Details</div></td>
  </tr>
  <tr>
    <td align="right" class="label2">CONTRNO:</td>
    <td class="td1"><?php echo $CONTRNO; ?></td>
    <td align="right" class="label2">SUBNO:</td>
    <td class="td1"><?php echo $SUBNO; ?></td>
    <td align="right" class="label2">NO_OF_LINES:</td>
    <td class="td1"><?php echo $NO_OF_LINES; ?></td>
  </tr>
  <tr>
    <td align="right" class="label2">CATEGORY:</td>
    <td class="td1"><?php echo $CATEGORY; ?></td>
    <td align="right" class="label2">EQUIPID:</td>
    <td class="td1"><?php echo $EQUIPID; ?></td>
    <td align="right" class="label2">CUSTNAME:</td>
    <td class="td1"><?php echo $CUSTNAME; ?></td>
  </tr>
  <tr>
    <td align="right" class="label2">STATUS:</td>
    <td class="td1"><?php echo $STATUS; ?></td>
    <td align="right" class="label2">STATUS_DATE:</td>
    <td class="td1"><?php echo $STATUS_DATE; ?></td>
    <td align="right" class="label2">PAST_DUE:</td>
    <td class="td1"><?php echo $PAST_DUE; ?></td>
  </tr>
  <tr>
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
  </tr>
</table>
<?php odbc_close($conn_mdb); }


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
