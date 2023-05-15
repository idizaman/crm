<?php
 	session_start();
 	ob_start();
 	ini_set("display_errors", "On");
	include "dbconnection.php";
	if (isset($_POST['usr_name']) && isset($_POST['usr_Pwd'])) 
	{
		$pass=$_POST['usr_Pwd'];
		$user=$_POST['usr_name'];
		
		$query="select * from users where userid='$user' and pass='$pass'";
		//exit;
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

			
			if($level==1 || $level==2 || $level==3 || $level==4 || $level==5)
			{
				header("Location:main.php");
				exit;
			}
		}
		else 
		{
			header("Location:index.php?login=failure");
			exit;
		}
 }
 ob_end_flush();