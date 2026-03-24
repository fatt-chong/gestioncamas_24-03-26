<?php  
$conexion = mysql_pconnect("localhost", "gestioncamas", "123gestioncamas") or trigger_error(mysql_error(),E_USER_ERROR);   
$q = strtoupper($_GET["q"]);  
if (!$q) return;  
mysql_query("SET NAMES 'utf8'");
mysql_select_db("camas", $conexion);
$sql = "SELECT
		CONCAT_WS(' - ',medicos.id,medicos.medico) as nombreMed
		FROM
		medicos
		WHERE
		CONCAT_WS(' - ',medicos.id,medicos.medico) LIKE '%$q%'";
		
$rsd = mysql_query($sql) or die ($sql. " Error al seleccionar medicos ". mysql_error);
while($rs = mysql_fetch_array($rsd)) {
     
	$medicoName = $rs['nombreMed'];
	
	
    echo "$medicoName\n";  
}  
?> 