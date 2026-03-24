<?php  
$conexion = mysql_pconnect("localhost", "gestioncamas", "123gestioncamas") or trigger_error(mysql_error(),E_USER_ERROR);   
$q = strtoupper($_GET["q"]);  
if (!$q) return;  

mysql_select_db("cie10", $conexion);
$sql = "SELECT
		cie10.nomcompletoCIE
		FROM
		cie10
		WHERE
		cie10.nomcompletoCIE LIKE '%$q%'";
		
$rsd = mysql_query($sql);
while($rs = mysql_fetch_array($rsd)) {  
     
	$ciename = $rs['nomcompletoCIE'];  
	
    echo "$ciename\n";  
}  
  
 
?>