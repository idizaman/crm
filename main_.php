
<?php
session_start();
if(!isset($_SESSION['crm_uid'])&&!isset($_SESSION['access']))
{die("<p>Access Restricted!!</p>");}
/*************************************/
$access=$_SESSION['access'];
$name=$_SESSION['crm_name'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Technical Complain Module Home page</title>
<link href="css/helper.css" media="screen" rel="stylesheet" type="text/css" />

<!-- Beginning of compulsory code below -->

<link href="css/dropdown.css" media="screen" rel="stylesheet" type="text/css" />
<link href="css/default.ultimate.css" media="screen" rel="stylesheet" type="text/css" />



<!--link rel="stylesheet" type="text/css" href="report/sddm.css"
<script type="text/javascript">var dmWorkPath="deluxe-menu.files/";</script>
<script type="text/javascript" src="deluxe-menu.files/dmenu.js"></script>-->
</head>

<body>
<!--<div class="header" align="center">Technical Complain Module Main Page</div>-->
<ul id="nav" class="dropdown dropdown-horizontal">
	<li><a href="./">Home</a></li>
	<li><span class="dir">Complain Entry</span>
		<ul>
			<li><a href="./">Complain Edit</a></li>
		</ul>
	</li>
	<li><span class="dir">Reports</span>
		<ul>
			<li><a href="./">View Complain</a></li>
			<li><a href="./">View Feedback</a></li>
			<li><a href="./">View History</a></li>
			<li class="divider"><a href="./">View All</a></li>
		</ul>
	</li>
</ul>

<iframe width="100%" name="main" height="540"></iframe>
<div class="footer" id="footerDiv">Copyright © CCD MIS, Planning &amp; Development, CCD</div>
</body>
</html>
