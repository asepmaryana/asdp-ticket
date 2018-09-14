<?php
$serverName = "ENGINEER-PC\SQLEXPRESS"; 
$connInfo = array("Database"=>"asdp_ticket_db", "UID"=>"sa", "PWD"=>"dbadmin");
$conn = sqlsrv_connect($serverName, $connInfo);
if($conn){
 echo "Database connection established.<br />";
}else{
 echo "Connection could not be established.<br />";
 die( print_r(sqlsrv_errors(), true));
}
sqlsrv_close($conn);
?>