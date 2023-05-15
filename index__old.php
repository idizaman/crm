<?php

session_start();
include("dbconnection.php");
$userId=$_SERVER['REMOTE_USER'];
		$userId=explode('\\',$userId);
		$userId=$userId[1];
		$_SESSION['crm_userId']=$userId;
		//$userId=$_SESSION['crm_userId'];
		
		echo $query="SELECT * from users where userid='$userId'";
		$result=mysql_query($query);
	
	$count=mysql_num_rows($result);

	if($count==1)
	{
		$row=mysql_fetch_array($result);
		$user=$row["userid"];
		$name=$row["aname"];
		$level=$row["level"];
		
		$_SESSION['crm_uid']=$user;
		$_SESSION['crm_level']=$level;
		$_SESSION['crm_name']=$name;

		
		if($level==1 || $level==2 || $level==3 || $level==4)
		{
	
			header("location:main.php");
		}
			
	}
	else 
	{
		echo '<h1 align="center" style="font:Verdana, Arial, Helvetica, sans-serif">You are not authorised to use this module, Please contact concern People. Thank you.</h1>';
	}
		
		
		
		
		
?>
