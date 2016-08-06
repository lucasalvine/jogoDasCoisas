<?php 
error_reporting (E_ALL & ~ E_NOTICE & ~ E_DEPRECATED);
$db_host = "127.0.0.1";
$db_username = "root"; 
$db_pass = "123456"; 
$db_name = "teste";

mysql_connect("$db_host","$db_username","$db_pass") or die (mysql_error());
mysql_select_db("$db_name") or die ("no database");

?>