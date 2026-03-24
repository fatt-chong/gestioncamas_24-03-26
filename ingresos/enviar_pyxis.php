<?php
//date_default_timezone_set('America/Santiago');
//usar la funcion header habiendo mandado c�digo al navegador
ob_start(); 
//end para header

if (!isset($_SESSION)) {
	session_start();
}

if ( $_SESSION['MM_Username'] == null ) {
	$GoTo = "../../acceso/index.php";
	header(sprintf("Location: %s", $GoTo));
}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Env�o de Paciente a Dispensador de Farmacos.</title>
<link type="text/css" rel="stylesheet" href="css/estilo.css" />
</head>
<body background="../../estandar/img/fdo.jpg" topmargin="5" style="font-family:Arial, Helvetica, sans-serif; font-size:12px">
	<table width="800px" align="center" border="2" bordercolor="#000000" bordercolorlight="#FFFFFF" bordercolordark="#666666" cellspacing="0" cellpadding="0">
    	<th height="20px" align="left" bgcolor="#006699" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; color:#FFF">&nbsp; Hospitalizaci&oacute;n de Paciente.</th>

        <tr>
            <td background="img/fondo.jpg">
            	<fieldset>


<div class="titulo" align="center">

<?
include "../funciones/funciones.php";

		
	mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');
	mysql_select_db('camas') or die('Cannot select database');
	$query = mysql_query("SELECT * FROM sscc where id = $servicio") or die(mysql_error());
	$query_servicio = mysql_fetch_array($query);
	$id_rau = $query_servicio['id_rau'];



	$fecha_linea = date('mdYHis');


	if (ftp_connect('10.6.18.95', 21, 1)) {
		$nombre_archivo = "adm_".$rut_paciente."_".$fecha_linea.".txt";
		$fp = fopen("ftp://pyxis:b4uleave!2@10.6.18.95/".$nombre_archivo, "a");
		fwrite($fp, "EPA|".$fecha_linea."|".$nom_paciente."|".$cta_cte."|".$id_paciente."||".$id_rau."|||X||".$rut_paciente."|||||||||||||||||||||||||||||||||||||||");
		
		fclose($fp); 
		
        echo "<a style='font-size:16px; color: #F00;' align='center' colspan='3'> El paciente fue transferido a pyxis </a>";
		
	}
	else
	{
        echo "<a style='font-size:16px; color: #F00;' align='center' colspan='3'> ��� El paciente no fue transferido a pyxis, pero puede realizar este proceso de forma manual...!!! </a>";
	}

			
	echo "</br>";
	echo "<table width='70%' align='center' border='0' cellspacing='0' cellpadding='0'>";
	echo "<tr align='center'>";
	echo "<td>";
	echo "<fieldset style='padding:20px'>";
	echo "</br>";
	
			?>
			<input class="boton" type="button" value="               Volver               " onclick="window.parent.close()" >		<?

	echo "</fieldset>";
	echo "</td>";
	echo "</tr>";
	echo "</table>";
	echo "</br>";

?>

</form>

</div>

</fieldset>
</td>
</tr>
</table>

</body>
</html>


<?php
//usar la funcion header habiendo mandado c�digo al navegador
ob_end_flush();
//end header
?>
