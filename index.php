<html>
<head>
<title>CRM Feedback Module</title>
<style type="text/css">
<!--
.style1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: 25px;
	color: #660066;
}
.style5{ font-family:Verdana, Arial, Helvetica, sans-serif; color:#FF0000;}
.style7 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }
.style9 {
	color: #660066;
	font-weight: bold;
}
.style11 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; color: #FC6F1A; }
.style12 {color: #FC6F1A}
.style16 {
	font-weight: bold;
	color: #000000;
}
.style18 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }
.style20 {color: #000000}
.style23 {font-family: "Courier New", Courier, monospace}
.style24 {color: #000000; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }
.style26 {
	color: #000000;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 14;
}
.style29 {color: #FC6F1A; font-family: Verdana, Arial, Helvetica, sans-serif;}
-->
</style>
</head>
<a href="login.php"></a>
<!--body bgcolor="#FF8000"-->
<body bgcolor="#999999">
<form id="frmindex" name="frmindex" method="post" action="login.php">
  <table width="100%" height="567" border="1" bgcolor="#CCCCCC" cellpadding="0" cellspacing="0">

    <tr>
      <td width="950"><table width="40%" height="80" align="center" border="1" cellpadding="0" cellspacing="0">
        <tr>
          <td height="40" colspan="2" align="center"><span class="style1">CRM Feedback Module<br>
              </span></td>
        </tr>
        <tr>
          <td bgcolor="#FF7700" height="50%" colspan="2" align="center"><table width="50%" height="50%" border="0" bgcolor="#FF7700" class="loginbox style9">
              <tr>
                <td nowrap width="50%" align="left" class="style24">User Name</td>
                <td width="50%" colspan="3" align="left"><input name="usr_name" type="text" class="style18" id="usr_name" size="22" />
                </td>
              </tr>
              <tr>
                <td align="left" class="style24">Password</td>
                <td colspan="3" align="left"><input name="usr_Pwd" type="password" class="style18" id="usr_Pwd" size="22"/>
                </td>
              </tr>
             
              <tr>
                <td align="right">&nbsp;</td>
                <td width="16%" align="left"><input name="Cancel" type="reset" class='style18' id="Cancel" value="Reset" /></td>
                <td width="14%" align="left"><input name="Submit" type="submit"  class='style18' onClick="javascript: if(usr_name.value=='' || usr_Pwd.value==''){alert('Please insert user id & password');return false;}" value="Login"></td>
                <td width="23%" align="left">&nbsp;</td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td colspan="2"><span class="style5">
            <?php
	/*if ($errorMessage != '') {
	print '<div align="center"><strong><font color="red">'.$errorMessage.'</font></strong></div>';
	}*/
	
	if(isset($_GET['login']) && $_GET['login']=='success')
	{
	echo "<p>Correct User Id and Password</p>"; 
	}
	else if(isset($_GET['login']) && $_GET['login']=='failure')
	{
	echo "<p>Wrong User Id and Password</p>"; 
	}
	
	
	
?>
          </span></td>
        </tr>
      </table></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="23"><div align="center" class="style18">Copyright © 2009 | Developed by CCD MIS & Reporting, Planning & Development, CCD | Banglalink</div></td>
    </tr>
  </table>
</form>
</body>
</html>