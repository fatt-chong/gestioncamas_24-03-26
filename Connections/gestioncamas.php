<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_rau = "10.6.21.29";
$database_rau = "rau";
$username_rau = "gestioncamas";
$password_rau = "123gestioncamas";

$rau = mysql_pconnect($hostname_rau, $username_rau, $password_rau) or trigger_error(mysql_error(),E_USER_ERROR); 
?>
