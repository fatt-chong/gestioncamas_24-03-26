<?php  
$conexion = mysql_pconnect("10.6.21.29", "gestioncamas", "123gestioncamas") or trigger_error(mysql_error(),E_USER_ERROR);   
$q = strtoupper($_GET["q"]);  
if (!$q) return;  
mysql_query("SET NAMES 'utf8'");
mysql_select_db("epicrisis", $conexion);
$sql = "SELECT
		enfermeras.enfermeraNombre
		FROM
		enfermeras
		WHERE
		enfermeras.enfermeraNombre LIKE '%$q%'";
		
$rsd = mysql_query($sql) or die ($sql. " Error al seleccionar enfermeras ". mysql_error);
while($rs = mysql_fetch_array($rsd)) {
     
	$enferName = $rs['enfermeraNombre'];
	
    echo "$enferName\n";  
}  
?> 