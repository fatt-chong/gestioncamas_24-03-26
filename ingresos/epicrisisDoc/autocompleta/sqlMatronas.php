<?php  
$conexion = mysql_pconnect("localhost", "gestioncamas", "123gestioncamas") or trigger_error(mysql_error(),E_USER_ERROR);   
$q = strtoupper($_GET["q"]);  
if (!$q) return;  
mysql_query("SET NAMES 'utf8'");
mysql_select_db("partos", $conexion);

$sql = "SELECT
		matronas.MATnombre
		FROM
		matronas
		WHERE
		matronas.MATnombre LIKE '%$q%'";
		
$rsd = mysql_query($sql) or die ($sql. " Error al seleccionar matronas ". mysql_error);
while($rs = mysql_fetch_array($rsd)) {
     
	$matronaName = $rs['MATnombre'];
	
    echo "$matronaName\n";  
}  
?> 