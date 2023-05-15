<?php
set_time_limit(-30);

/*$server = 'blmis002'; 
$user="ccdmis";
$password="ccdmis";
$database="crmfeedback";
*/

$server = '172.16.11.209'; 
$user = 'ccdmis_app';
$password = 'ccdmis@019014';
$database = "crmfeedback";//crmfeedback-uat

$conn = mysql_connect($server,$user,$password) or die("Unable to connect $server");//mis002

mysql_select_db($database)or die("Unable to select database in $server");