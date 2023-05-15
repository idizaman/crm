<?php
/*This must be included into every page except starting page (index.php)*/
	session_start();
	if(!isset($_SESSION['crm_uid'])&&!isset($_SESSION['access']))
{die("<p>Access Restricted!!</p>");}
	session_unset();
	session_destroy();
	header("Location: index.php");

?>