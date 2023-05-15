<?php		
		
		/*$sql="select * from comptype";
		$result=mysql_query($sql) or die(mysql_error());	*/	
		
		
		$camp_query="select * FROM campaign";
	    $camp_result=mysql_query($camp_query);
	    $camp_num=mysql_num_rows($camp_result);
	
	/******populate Feedback1*****/
		
		if(isset($_POST['campaign']) && $_POST['campaign']!='')
 			{
			$f1_post_qry="SELECT * FROM feedback1 where campId='".$_POST['campaign']."'";
			$f1_post_result=mysql_query($f1_post_qry);
			$f1_post_num=mysql_num_rows($f1_post_result);
			}
		
		
		$f1_query="SELECT * FROM feedback1";
		$f1_result=mysql_query($f1_query);
		$f1_num=mysql_num_rows($f1_result);
	
		$fdbk1Id=array();
		$campId=array();
		$fdbkName=array();		
		for($i=0;$i<$f1_num;$i++)
				{
					$fdbk1Id[$i]=mysql_result($f1_result,$i,'fdbk1Id');
					$campId[$i]=mysql_result($f1_result,$i,'campId');
					$fdbkName[$i]=mysql_result($f1_result,$i,'fdbkName');
				}	
				
		echo "<script language='javascript'>\n";
		echo "arrfdbk1=new Array();\n";
	
		for($i=0;$i<$f1_num;$i++)
		{
			echo "arrfdbk1[$i]=['$fdbk1Id[$i]','$campId[$i]','$fdbkName[$i]']\n";
		}
		
		echo "</script>";




/******populate Feedback2*****/
		
		if(isset($_POST['fdbk1']) && $_POST['fdbk1']!='')
 			{
			$f2_post_qry="SELECT * FROM feedback2 where fdbk1Id='".$_POST['fdbk1']."'";
			$f2_post_result=mysql_query($f2_post_qry);
			$f2_post_num=mysql_num_rows($f2_post_result);
			}
		
		
		$f2_query="SELECT * FROM feedback2";
		$f2_result=mysql_query($f2_query);
		$f2_num=mysql_num_rows($f2_result);
	
		$fdbk2Id=array();
		$fdbk1Id=array();
		$fdbkName=array();		
		for($i=0;$i<$f2_num;$i++)
				{
					$fdbk2Id[$i]=mysql_result($f2_result,$i,'fdbk2Id');
					$fdbk1Id[$i]=mysql_result($f2_result,$i,'fdbk1Id');
					$fdbkName[$i]=mysql_result($f2_result,$i,'fdbkName');
				}	
				
		echo "<script language='javascript'>\n";
		echo "arrfdbk2=new Array();\n";
	
		for($i=0;$i<$f2_num;$i++)
		{
			echo "arrfdbk2[$i]=['$fdbk2Id[$i]','$fdbk1Id[$i]','$fdbkName[$i]']\n";
		}
		
		echo "</script>";
		
		$f3_query = "SELECT * FROM feedback3";
		$f3_result = mysql_query($f3_query);
		$f3_num = mysql_num_rows($f3_result);
?>