<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Gestion de Camas Hospital Dr. Juan No� C.</title>
<link type="text/css" rel="stylesheet" href="css/estilo.css" />
</head>

<body bgcolor="#FFFFFF">


<?
include "../funciones/funciones.php";

$fecha_hoy = date('d-m-Y');

$fecha_categorizacion = cambiarFormatoFecha($fecha_hoy);

$sql = "SELECT * FROM categorizacion where cod_servicio = '".$cod_servicio."' and sala = '".$sala."' and cama = '".$cama."' and fecha = '".$fecha_categorizacion."'";
mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');
mysql_select_db('camas') or die('Cannot select database');
$query = mysql_query($sql) or die(mysql_error());

$categoriza = mysql_fetch_array($query);


if ($categoriza)
{

	$id_categoriza = $categoriza['id'];

	mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');
	mysql_select_db('camas') or die('Cannot select database');

	$resultado1 = mysql_query( "UPDATE categorizacion SET
	nom_paciente = '$nom_paciente',
	id_paciente = $id_paciente,
	cod_usuario = $cod_usuario,
	usuario = '$usuario',
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

	mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');
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


	mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');
	mysql_select_db('camas') or die('Cannot select database');

	$resultado2 = mysql_query( "UPDATE camas SET
	fecha_categorizacion =  '$fecha_categorizacion',
	categorizacion_riesgo  = '$categorizacion_riesgo',
	categorizacion_dependencia = '$categorizacion_dependencia'
	WHERE id = $id_cama "  );



?>
	<table bgcolor="#F6F6F6" width="225px" border="1" cellspacing="0" cellpadding="0">
    	<tr><td colspan="2" bgcolor="#99CCFF" style="font-size:14px"><strong>Categorizacion de Paciente</strong></td></tr>    
    	<tr><td align="center">
<?

if ($resultado1)
	{
	if ($resultado2)
		{
			echo "El Proceso de Categorizacion se Realiz� con Exito </br></br>";
			?>
			<input type="button" value="               Volver               " onClick="top.window.location.href='<? echo"sscc.php?servicio=$cod_servicio&desc_servicio=$desc_servicio"; ?>';
			parent.parent.GB_hide(); " >
			<?
		}
	else
		{
			echo "El Cambio de Estado Fall� Pero el registro historico OK, comuniquesde con el administrador </br></br>";
			?>
			<input type="Button" value=" Volver " onClick="window.location.href='<? echo"altapaciente.php?id_cama=$id_cama"; ?>'; parent.GB_hide(); " >
			<?
		}

	}
else
	{
	echo "El Proceso de Categorizaci�n Fall�, Intentelo Nuevamente </br></br>";
	?>
	<input type="Button" value=" Volver " onClick="window.location.href='<? echo"altapaciente.php?id_cama=$id_cama"; ?>'; parent.GB_hide(); " >
	<?
	}


	echo "</td>";
	echo "</tr>";
	echo "</table>";

?>
    <br>
	<table bgcolor="#F6F6F6" width="225px" border="1" cellspacing="0" cellpadding="0">
		<tr><td> Codigo Servicio </td><td><? echo $cod_servicio ?></td></tr>
		<tr><td> Servicio </td><td><? echo $desc_servicio ?></td></tr>
		<tr><td> Sala </td><td><? echo $sala ?></td></tr>
		<tr><td> Cama </td><td><? echo $cama ?></td></tr>
		<tr><td> Codigo Ususrio </td><td><? echo $cod_usuario ?></td></tr>
		<tr><td> Usuario </td><td><? echo $usuario ?></td></tr>
		<tr><td> Observaci�n </td><td><? echo $observacion ?></td></tr>
		<tr><td> Categorizacion Riesgo </td><td><? echo $categorizacion_riesgo ?></td></tr>
		<tr><td> Categorizacion Dependencia </td><td><? echo $categorizacion_dependencia ?></td></tr>
	</table>



</form>

</body>
</html>
