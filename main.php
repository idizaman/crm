<?php
//foreach($_COOKIE as $key => $value)
//echo $value;
session_start();

	/*echo '<pre>';
	print_r($_SESSION);
	echo '</pre>';*/

if(!isset($_SESSION['crm_uid'])&&!isset($_SESSION['access']))
{die("<p>Access Restricted!!</p>");}
$level=$_SESSION['crm_level'];
$name=$_SESSION['crm_name'];
$userId=$_SESSION['crm_uid'];
//$phone=$_SESSION['phone'];
/*************************************/
$access=$_SESSION['access'];
$name=$_SESSION['crm_name'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>CRM Feedback Module Home page</title>
<!--<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="author" content="Tom@Lwis (http://www.lwis.net/free-css-drop-down-menu/)" />
<meta name="keywords" content=" css, dropdowns, dropdown menu, drop-down, menu, navigation, nav, horizontal, vertical left-to-right, vertical right-to-left, horizontal linear, horizontal upwards, cross browser, internet explorer, ie, firefox, safari, opera, browser, lwis" />
<meta name="description" content="Clean, standards-friendly, modular framework for dropdown menus" />-->
<link href="css/helper.css" media="screen" rel="stylesheet" type="text/css" />

<!-- Beginning of compulsory code below -->

<link href="css/dropdown.css" media="screen" rel="stylesheet" type="text/css" />
<link href="css/default.ultimate.css" media="screen" rel="stylesheet" type="text/css" />

<!--[if lt IE 7]>
<script type="text/javascript" src="js/jquery/jquery.js"></script>
<script type="text/javascript" src="js/jquery/jquery.dropdown.js"></script>
<![endif]-->

<!-- / END -->

</head>
<body>

<table width="100%"><tr class="header"><td class="header" width="40%">CRM Feedback Module Home page</td><td class="header2" width="60%" align="right"><?php echo 'Welcome : '.$name;?></td></tr></table>

<!-- Beginning of compulsory code below -->

<ul id="nav" class="dropdown dropdown-horizontal">
	
	<li><a href="feedbackEntry.php" target="main">Feedback Entry</a></li>
	
	<li><a href="feedbackSearch.php" target="main">Search Feedback</a></li>
	<?php if($level==4 || $level==3){ ?>
	<li><a href="feedbackReport.php" target="main">Feedback Report</a></li>
	<?php  } ?>    
    <?php if($level==4){ ?>
    <!--<li><a href="addrequest.php" target="main">Request</a></li>
    <li><a href="view_request.php" target="main">View Request</a></li>
    <li><a href="bulk_request.php" target="main">Bulk Request</a></li>-->
	<?php  } ?>
    <li><a href="logout.php">Logout</a></li>
    
   
	<!--<li><a href="change_pass.php" target="main">Change Password</a></li>
	<li><a href="logout.php">Logout</a></li>
	<li><span class="dir">Complain Entry</span>
		<ul>
			<li><a href="compEdit.php" target="main">View Complain</a></li>
		</ul>
	</li>
	<li><span class="dir">Reports</span>
		<ul>
			<li><a href="complain_report.php" target="main">View Complain</a></li>
			<li><a href="./">View Feedback</a></li>
			<li><a href="./">View History</a></li>
			<li class="divider"><a href="./">View All</a></li>
		</ul>
	</li>   -->
</ul>

<!-- / END -->
<iframe width="100%" name="main" height="700"></iframe>
<div class="footer" id="footerDiv">Copyright @ CCD MIS &amp; Reporting, Planning &amp; Development, CCD</div>
</body>
</html>