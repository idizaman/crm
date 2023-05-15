<?php	

$conn_mdb=odbc_connect('oraapp2','WMSP2','WMSP2');
	echo $contQry="select count(*) from conf_employee t";
	echo $conResult=odbc_exec($conn_mdb,$contQry); 
	echo $conCount=odbc_num_rows($conResult);
	//odbc_close($conn_mdb);
?>