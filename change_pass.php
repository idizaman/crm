<?php
session_start();
if(!isset($_SESSION['crm_uid'])&&!isset($_SESSION['crm_level']))
{die("<p>Access Restricted!!</p>");}
$level=$_SESSION['crm_level'];
$uid=$_SESSION['crm_uid'];

?>
<html>
<head>
<title>Corporate Visit</title>
</head>

<script language="javascript">
function validate(frm)
{
	if(frm.userid.value == "")
	{
		alert("Username Empty");
		return false;
	}
	if(frm.password.value == "")
	{
		alert("Current Password Empty");
		return false;
	}
	if(frm.password1.value == "")
	{
		alert("Change Password Empty");
		return false;
	}
	if(frm.password2.value == "")
	{
		alert("Verify Password Empty");
		return false;
	}

	if(frm.password1.value != frm.password2.value)
	{
		alert("Password does not match");
		return false;
	}

	return true;
}
</script>

<?php 
include 'dbconnection.php';

	if(isset($_POST['btn_pass']))
	{
		$password = $_POST['password'];
		$password1 = $_POST['password1'];
		$password2 = $_POST['password2'];
		
		$sql = "select userid,pass from users where userid = '$uid' and pass = '$password'";

		$result = mysql_query($sql);		
		
		if(mysql_num_rows($result) == 1 && $password1==$password2)
		{
				$sql = "update users set pass = '$password1' where userid = '$uid' and pass='$password'";

				$result12 = mysql_query($sql);
				if($result12)
				{
					echo "<br><center><font color=\"#006633\"><b>Password Succesfully Changed</b></font></center>";
					echo '<br><center><a href="logout.php" target="_top">Please Login Again</a></center>';
					exit;
				}
		}
		else
		{
		
			echo "<br><center><font color=\"#FF0000\"><b>Invalid Password</b></font></center>";
			exit;
			
		}
	}


?>


<body>
 <script type="text/javascript" src="popcalendar.js"></script>

 <div align="center"><font color="#CC99CC"></font></div>
<form name="form1" method="post" action="change_pass.php">
  <table border="0" align="center" cellpadding="1" cellspacing="1" bordercolor="#FFFFFF" bgcolor="#FFFFFF">
<tr bgcolor='#FF6600'>
  <td colspan=2 align=center><font face='Verdana' size='2' ><b>Change Password </b></td>
</tr>
<tr bgcolor="#d9effd" >
  <td width="132" ><font face='Verdana' size='2' >User ID </font></td>
  <td width="165" ><input type=text name="userid" value="<?php echo $uid;?>" readonly></td></tr>

<tr bgcolor='#d9effd'>
  <td ><font face='Verdana' size='2' >Current Password</font></td><td ><input type="password" name="password" id ="password"></td></tr>
<tr bgcolor="#d9effd" >
  <td ><font face='Verdana' size='2' >New Password</font></td>
  <td ><font face='Verdana' size='2'>
    <input name="password1" type="password" id="password1">
  </font></td>
</tr>
<tr bgcolor="#d9effd" >
  <td ><font face='Verdana' size='2' >Verify Password</font></td><td ><input type="password" name="password2" id="password2"></td></tr>

    <tr bgcolor="#d9effd"> 
      <td colspan="2"> <div align="center">
          <input type="submit" name ="btn_pass" value="Change" onClick="return validate(this.form);"> 
      </div></td>
    </tr>
  </table>
</form>
</body>
</html>
