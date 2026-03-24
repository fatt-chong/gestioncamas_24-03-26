<?php
//date_default_timezone_set('America/Santiago');
if (!isset($_SESSION)) {
  session_start();
}
$dbhost = $_SESSION['BD_SERVER'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Gestion de Camas Hospital Dr. Juan Noé C.</title>
<link type="text/css" rel="stylesheet" href="css/estilo.css" />
</head>
<body background="../../estandar/img/fdo.jpg" topmargin="5" style="font-family:Arial, Helvetica, sans-serif; font-size:12px">

	<table width="850px" align="center" border="2" bordercolor="#000000" bordercolorlight="#FFFFFF" bordercolordark="#666666" cellspacing="0" cellpadding="0">
    	<th height="20px" align="left" bgcolor="#006699" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; color:#FFF">&nbsp; Categorizaci&oacute;n de Pacientes.</th>

        <tr>
            <td background="img/fondo.jpg">
            	<fieldset>
<div class="titulo" align="center">

<?
include "../funciones/funciones.php";

$fecha_hoy = date('d-m-Y');

$fecha_categorizacion = cambiarFormatoFecha($fecha_hoy);

if ($tipo_1 == '') { $tipo_1 = 0; }
if ($tipo_2 == '') { $tipo_2 = 0; }

if ($d_smpt == 'on') {
	$smpt = 1;
}
else {
	$smpt = 0;
}

$sql = "SELECT * FROM categorizacion where cod_servicio = '".$cod_servicio."' and sala = '".$sala."' and cama = '".$cama."' and fecha = '".$fecha_categorizacion."'";
mysql_connect ($dbhost,'gestioncamas','123gestioncamas');
mysql_select_db('camas') or die('Cannot select database');
$query = mysql_query($sql) or die(mysql_error());

$categoriza = mysql_fetch_array($query);

if ($categoriza)
{
	$id_categoriza = $categoriza['id'];

	mysql_connect ($dbhost,'gestioncamas','123gestioncamas');
	mysql_select_db('camas') or die('Cannot select database');

	$resultado1 = mysql_query( "UPDATE categorizacion SET
	nom_paciente = '$nom_paciente',
	id_paciente = $id_paciente,
	cod_usuario = $cod_usuario,
	usuario = '$usuario',
	tipo_1   = $tipo_1,
	d_tipo_1 = '$d_tipo_1',
	tipo_2   = $tipo_2,
	d_tipo_2 = '$d_tipo_2',
	estado_1 = $estado_1,
	estado_2 = $estado_2,
	glicemia = $glicemia,
	smpt = $smpt,
	ev_1 = $ev_1,
	ev_2 = $ev_2,
	ev_3 = $ev_3,
	ev_4 = $ev_4,
	ev_5 = $ev_5,
	ev_6 = $ev_6,
	ev_7 = $ev_7,
	ev_8 = $ev_8,
	ev_9 = $ev_9,
	ev_10 = $ev_10,
	ev_11 = $ev_11,
	ev_12 = $ev_12,
	ev_13 = $ev_13,
	ev_14 = $ev_14,
	observacion = '$observacion',
	categorizacion_riesgo = '$categorizacion_riesgo',
	categorizacion_dependencia = '$categorizacion_dependencia'
	WHERE id = $id_categoriza "  );
	
}
else
{

	mysql_connect ($dbhost,'gestioncamas','123gestioncamas');
	mysql_select_db('camas') or die('Cannot select database');

	$resultado1 = mysql_query( "INSERT INTO categorizacion
	( 
	cod_servicio,
	servicio, 
	sala, 
	cama,
	nom_paciente,
	id_paciente,
	cod_usuario,
	usuario,
	fecha,
	tipo_1,
	d_tipo_1,
	tipo_2,
	d_tipo_2,
	estado_1,
	estado_2,
	glicemia,
	smpt,
	ev_1, 
	ev_2,
	ev_3,
	ev_4,
	ev_5,
	ev_6,
	ev_7,
	ev_8,
	ev_9,
	ev_10,
	ev_11,
	ev_12,
	ev_13,
	ev_14,
	observacion,
	categorizacion_riesgo,
	categorizacion_dependencia
	)
	VALUES
	( 
	$cod_servicio, 
	'$desc_servicio', 
	'$sala', 
	$cama, 
	'$nom_paciente',
	$id_paciente,
	$cod_usuario,
	'$usuario', 
	'$fecha_categorizacion',
	$tipo_1,
	'$d_tipo_1',
	$tipo_2,
	'$d_tipo_2',
	$estado_1,
	$estado_2,
	$glicemia,
	$smpt,
	$ev_1,
	$ev_2,
	$ev_3,
	$ev_4,
	$ev_5,
	$ev_6,
	$ev_7,
	$ev_8,
	$ev_9,
	$ev_10,
	$ev_11,
	$ev_12,
	$ev_13,
	$ev_14,
	'$observacion',
	'$categorizacion_riesgo',
	'$categorizacion_dependencia'
	) ");

}





	mysql_connect ($dbhost,'gestioncamas','123gestioncamas');
	mysql_select_db('camas') or die('Cannot select database');

	$resultado2 = mysql_query( "UPDATE camas SET
	fecha_categorizacion =  '$fecha_categorizacion',
	categorizacion_riesgo  = '$categorizacion_riesgo',
	categorizacion_dependencia = '$categorizacion_dependencia'
	WHERE id = $id_cama "  );




echo "<table width='70%' align='center' border='0' cellspacing='0' cellpadding='0'>";
echo "<tr align='left'>";
echo "<td>";
echo "<fieldset style='padding:30px'>";
echo "<legend> Categorizacion de Paciente </legend></br>";

echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>";

echo "<tr>";
echo "<td width='170px'>Codigo de Servicio</td>";
echo "<td>:".$cod_servicio."</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Servicio</td>";
echo "<td>:".$desc_servicio."</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Sala</td>";
echo "<td>:".$sala."</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Cama</td>";
echo "<td>:".$cama."</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Codigo Usuario</td>";
echo "<td>:".$cod_usuario."</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Usuario</td>";
echo "<td>:".$usuario."</td>";
echo "</tr>";


echo "<tr>";
echo "<td>Fecha Categorización</td>";
echo "<td>:".$fecha_categorizacion."</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Observacion</td>";
echo "<td>:".$observacion."</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Categorizacion Riesgo</td>";
echo "<td>:".$categorizacion_riesgo."</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Categorizacion Dependencia</td>";
echo "<td>:".$categorizacion_dependencia."</td>";
echo "</tr>";


echo "</table>";

echo "</fieldset>";
echo "</td>";
echo "</tr>";
echo "</table>";



echo "<form>";
echo "</br>";
echo "<table width='70%' align='center' border='0' cellspacing='0' cellpadding='0'>";
echo "<tr align='center'>";
echo "<td>";
echo "<fieldset style='padding:30px'>";

if ($resultado1)
	{
	if ($resultado2)
		{
			echo "El Proceso de Categorizacion se Realizó con Exito </br></br>";
			?>
<input type="button" value="               Volver               " onclick="top.mainFrame.location.href='<? echo"sscc.php"; ?>';
			parent.parent.GB_hide(); " />
<?
		}
	else
		{
			echo "El Cambio de Estado Falló Pero el registro historico OK, comuniquesde con el administrador </br></br>";
			?>
<input type="Button" value=" Volver " onClick="window.location.href='<? echo"altapaciente.php?id_cama=$id_cama"; ?>'; parent.GB_hide(); " >
			<?
		}

	}
else
	{
	echo "El Proceso de Categorización Falló, Intentelo Nuevamente </br></br>";
	?>
	<input type="Button" value=" Volver " onClick="window.location.href='<? echo"altapaciente.php?id_cama=$id_cama"; ?>'; parent.GB_hide(); " >
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
