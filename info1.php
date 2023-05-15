<?php		
		
		$sql="select * from comptype";
		$result=mysql_query($sql) or die(mysql_error());		
		
		$compStatus_query="select distinct (compStatus) FROM complain_log ";
	    $compStatus_result=mysql_query($compStatus_query);
	    $compStatus_num=mysql_num_rows($compStatus_result);
		
		$dis_query="select distinct (district) FROM complain_log ";
	    $dis_result=mysql_query($dis_query);
	    $dis_num=mysql_num_rows($dis_result);
		
		$th_query="SELECT DISTINCT(thana),district FROM complain_log GROUP BY thana";
		$th_result=mysql_query($th_query);
		$th_num=mysql_num_rows($th_result);
	
		$th=array();
		$dis=array();
				for($i=0;$i<$th_num;$i++)
				{
					$th[$i]=mysql_result($th_result,$i,'thana');
					$dis[$i]=mysql_result($th_result,$i,'district');
				}	
				
		echo "<script language='javascript'>\n";
		echo "arrThana=new Array();\n";
	
		for($i=0;$i<$th_num;$i++)
		{
			echo "arrThana[$i]=['$th[$i]','$dis[$i]']\n";
		}
		
		echo "</script>";




/******populate unionName*****/


		$dis_query2="select distinct (thana) FROM complain_log ";
	    $dis_result2=mysql_query($dis_query2);
	    $dis_num2=mysql_num_rows($dis_result2);
		
		$th_query2="SELECT DISTINCT(`unionName`),thana FROM complain_log GROUP BY `unionName`";
		$th_result2=mysql_query($th_query2);
		$th_num2=mysql_num_rows($th_result2);
	
		$th2=array();
		$dis2=array();
				for($i=0;$i<$th_num2;$i++)
				{
					$th2[$i]=mysql_result($th_result2,$i,'unionName');
					$dis2[$i]=mysql_result($th_result2,$i,'thana');
				}	
				
		echo "<script language='javascript'>\n";
		echo "arrUnion=new Array();\n";
	
		for($i=0;$i<$th_num2;$i++)
		{
			echo "arrUnion[$i]=['$th2[$i]','$dis2[$i]']\n";
		}
		
		echo "</script>";
?>