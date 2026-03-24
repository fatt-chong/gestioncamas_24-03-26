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

<title>Gestion de Camas Hospital Dr. Juan No� C.</title>

<link type="text/css" rel="stylesheet" href="css/estilo.css" />

</head>

<body background="../../estandar/img/fdo.jpg" topmargin="5" style="font-family:Arial, Helvetica, sans-serif; font-size:12px">

	<table width="850px" align="center" border="2" bordercolor="#000000" bordercolorlight="#FFFFFF" bordercolordark="#666666" cellspacing="0" cellpadding="0">
    	<th height="20px" align="left" bgcolor="#006699" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; color:#FFF">&nbsp; Regreso de Paciente desde Pabellon.</th>

        <tr>
            <td background="img/fondo.jpg">
            	<fieldset>

<div class="titulo" align="center">

<?
include "../funciones/funciones.php";


$fecha_hospitalizacion = cambiarFormatoFecha2($fecha_ingreso);
$fecha_alta = $fecha_egreso;

$fecha_ingreso = cambiarFormatoFecha($fecha_hospitalizacion);
$fecha_egreso = cambiarFormatoFecha($fecha_alta);

mysql_connect ('10.6.21.29','usuario','hospital');

mysql_select_db('camas') or die('Cannot select database');
$query = mysql_query("SELECT * FROM sscc where id = $cod_servicio") or die(mysql_error());
$query_servicio = mysql_fetch_array($query);

$cod_servicio_hasta = $query_servicio['id_rau'];
$desc_servicio_hasta = $query_servicio['servicio'];


echo "<table width='70%' align='center' border='0' cellspacing='0' cellpadding='0'>";
echo "<tr align='left'>";
echo "<td>";
echo "<fieldset style='padding:30px'>";
echo "<legend> Informacion de Egreso de Paciente a Pabell�n </legend></br>";

echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>";

echo "<tr>";
echo "<td width='100px'>Cama</td>";
echo "<td width='400px'>: Cama Nro ".$cama.", Sala ".$sala." ( ".$desc_servicio." )</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Hospitalizacion</td>";
echo "<td>: ".substr($hospitalizado, 8, 2)."-".substr($hospitalizado, 5, 2)."-".substr($hospitalizado, 0, 4)." / ".substr($hospitalizado, 11, 5)."  Hrs.</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Ingreso</td>";
echo "<td>: ".$fecha_hospitalizacion." / ".substr($hora_ingreso,0,5)." Hrs.</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Egreso</td>";
echo "<td>: ".$fecha_alta." / ".$hora_egreso." Hrs.</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Medico</td>";
echo "<td>: ".$medico."</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Diagnostico</td>";
echo "<td>: ".$diagnostico2."</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Destino</td>";
echo "<td>: ".$desc_servicio_hasta."</td>";
echo "</tr>";

echo "</table>";

echo "</fieldset>";
echo "</td>";
echo "</tr>";
echo "</table>";


mysql_select_db('camas') or die('Cannot select database');

$resultado1 = mysql_query( "UPDATE camas SET pabellon = 0 WHERE id = $id_cama "  ) or die(mysql_error());

$fecha_linea = date('mdYHis');
	
mysql_select_db('camas') or die('Cannot select database');

if (ftp_connect('10.6.18.95', 21, 1)) {
	
	$nombre_archivo = "adm_".$rut_paciente."_".$fecha_linea.".txt";
	$fp = fopen("ftp://pyxis:b4uleave!2@10.6.18.95/".$nombre_archivo, "a");
	fwrite($fp, "EPA|".$fecha_linea."|".$nom_paciente."|".$cta_cte."|".$id_paciente."||".$cod_servicio_hasta."|||X||".$rut_paciente."|||||||||||||||||||||||||||||||||||||||");

	fclose($fp); 
	
}
else
{
	echo "<a style='font-size:16px; color: #F00;' align='center' colspan='3'> ��� El paciente no fue transferido a pyxis, pero puede realizar este proceso de forma manual...!!! </a>";
}



echo "<form>";
echo "</br>";
echo "<table width='70%' align='center' border='0' cellspacing='0' cellpadding='0'>";
echo "<tr align='center'>";
echo "<td>";
echo "<fieldset style='padding:30px'>";

if ($resultado1)
	{
		echo "La Proceso de Egreso se Realiz� con Exito </br></br>";
		?>
<input type="button" class="boton" value="               Volver               " onclick="top.mainFrame.location.href='<? echo"sscc.php"; ?>';
		parent.parent.GB_hide(); " />
		<?
	}
else
	{
	echo "El Proceso de Egreso Fall�, Intentelo Nuevamente </br></br>";
	?>
<input type="Button" class="boton" value=" Volver " onClick="window.location.href='<? echo"altapaciente.php?id_cama=$id_cama"; ?>'; parent.GB_hide(); " >
	<?
	}


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
