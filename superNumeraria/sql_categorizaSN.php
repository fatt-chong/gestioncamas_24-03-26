<?php
 
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



include "../funciones/funciones.php";

$permisos = $_SESSION['permiso'];
$dbhost = '10.6.21.29';

$cod_servicio = $_GET['cod_servicio']; 
$desc_servicio = $_GET['desc_servicio']; 
	$sala = $_GET['sala'];  
	$cama = $_GET['cama']; 
	$nom_paciente = $_GET['nom_paciente']; 
	$nom_paciente = $_GET['nom_paciente']; 
	$cod_usuario = $_GET['cod_usuario']; 
	$usuario = $_GET['usuario']; 
	$fecha_categorizacion = $_GET['fecha_categorizacion']; 
	$tipo_1 = $_GET['tipo_1']; 
	$d_tipo_1 = $_GET['d_tipo_1']; 
	$tipo_2 = $_GET['tipo_2']; 
	$d_tipo_2 = $_GET['d_tipo_2']; 
	$estado_1 = $_GET['estado_1']; 
	$estado_2 = $_GET['estado_2']; 
	$glicemia = $_GET['glicemia']; 
	$smpt = $_GET['smpt']; 
	$kinesiologicos = $_GET['kinesiologicos']; 
	$ev_1 = $_GET['ev_1']; 
	$ev_2 = $_GET['ev_2']; 
	$ev_3 = $_GET['ev_3']; 
	$ev_4 = $_GET['ev_4']; 
	$ev_5 = $_GET['ev_5']; 
	$ev_6 = $_GET['ev_6']; 
	$ev_7 = $_GET['ev_7']; 
	$ev_8 = $_GET['ev_8']; 
	$ev_9 = $_GET['ev_9']; 
	$ev_10 = $_GET['ev_10']; 
	$ev_11 = $_GET['ev_11']; 
	$ev_12 = $_GET['ev_12']; 
	$ev_13 = $_GET['ev_13']; 
	$ev_14 = $_GET['ev_14']; 
	$observacion = $_GET['observacion']; 
	$categorizacion_riesgo = $_GET['categorizacion_riesgo']; 
	$categorizacion_dependencia = $_GET['categorizacion_dependencia']; 
	$ctacte = $_GET['ctacte']; 
	
	$id_paciente = $_GET['id_paciente'];
$id_cama = $_GET['id_cama'];

mysql_connect ($dbhost,'gestioncamas','123gestioncamas');
mysql_select_db('camas') or die('Cannot select database');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Gestion de Camas Hospital Dr. Juan No� C.</title>
<link type="text/css" rel="stylesheet" href="css/estilo.css" />
</head>
<body>
<table width="629" align="center" >
<tr>
<td >
<fieldset class="fondoF"><legend class="estilo1">Categorizacion</legend>


<div align="center">

<?

if ($tipo_1 == '') { $tipo_1 = 0; }
if ($tipo_2 == '') { $tipo_2 = 0; }

if ($d_smpt == 'on') {
	$smpt = 1;
}
else {
	$smpt = 0;
}

$fecha = date('d-m-Y');

$fecha_categorizacion = cambiarFormatoFecha($fecha);

$sql = "SELECT * FROM categorizacion where id_paciente = '$id_paciente' AND fecha = '$fecha_categorizacion'";

mysql_connect ($dbhost,'gestioncamas','123gestioncamas');
mysql_select_db('camas') or die('Cannot select database');
$query = mysql_query($sql) or die(mysql_error());

$categoriza = mysql_fetch_array($query);

if($kinesiologicos==1){

	$fechaHoy 	= date('d-m-Y');
	$sqlCabecera = "SELECT *
					FROM cabecera_kine
					WHERE
					cabecera_kine.CKIctacte = '$ctacte' 
					AND
					DATE_FORMAT(cabecera_kine.CKIfecha_registro,'%d-%m-%Y') = '$fechaHoy'";
	$queryCabecera 	= mysql_query($sqlCabecera);
	$arrayCabecera 	= mysql_fetch_array($queryCabecera);
	$idCategoriza 	= $arrayCabecera['CKIid'];
	if($idCategoriza == ''){
		$sqlinsertaCategorizaCabecera = mysql_query( "INSERT INTO camas.cabecera_kine
				( 
				CKIctacte,
				CKIorigen,
				CKIfecha_registro)
				VALUES
				( '$ctacte',
				'E',
				NOW() ) ") or die("ERROR AL insertaCategorizaCabecera ".mysql_error());
	}
}

if ($categoriza)
{
	$id_categoriza = $categoriza['id'];

	$resultado1 = mysql_query( "UPDATE categorizacion SET
	camaSN = 'S',
	nom_paciente = '$nom_paciente',
	id_paciente = '$id_paciente',
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
	kinesiologicos = $kinesiologicos,
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
	WHERE id = $id_categoriza "  ) or die("ERROR AL CATEGORIZAR ". mysql_error());
	
}
else
{

	$resultado1 = mysql_query( "INSERT INTO categorizacion
	( 
	cod_servicio,
	camaSN,
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
	kinesiologicos,
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
	categorizacion_dependencia,
	ctacte_paciente
	)
	VALUES
	( 
	'$cod_servicio', 
	'S',
	'$desc_servicio', 
	'$sala', 
	'$cama', 
	'$nom_paciente',
	'$id_paciente',
	'$cod_usuario',
	'$usuario', 
	'$fecha_categorizacion',
	'$tipo_1',
	'$d_tipo_1',
	'$tipo_2',
	'$d_tipo_2',
	'$estado_1',
	'$estado_2',
	'$glicemia',
	'$smpt',
	'$kinesiologicos',
	'$ev_1',
	'$ev_2',
	'$ev_3',
	'$ev_4',
	'$ev_5',
	'$ev_6',
	'$ev_7',
	'$ev_8',
	'$ev_9',
	'$ev_10',
	'$ev_11',
	'$ev_12',
	'$ev_13',
	'$ev_14',
	'$observacion',
	'$categorizacion_riesgo',
	'$categorizacion_dependencia',
	'$ctacte'
	) ") or die("ERROR AL CATEGORIZAR 2 ".mysql_error());

}
	
	mysql_connect ($dbhost,'gestioncamas','123gestioncamas');
	mysql_select_db('camas') or die('Cannot select database');

	$sqlUpdate = "UPDATE listasn SET
	fechaCatSN =  '$fecha_categorizacion',
	categorizaRiesgoSN  = '$categorizacion_riesgo',
	categorizaDepSN = '$categorizacion_dependencia'
	WHERE idListaSN = $id_cama ";
	
	$resultado2 = mysql_query($sqlUpdate);

?>

<table width='70%' align='center' border='0' cellspacing='0' cellpadding='0' >
<tr align='left'>
<td>

    <table width='100%' border='0' cellspacing='0' cellpadding='0'>
    
    <tr>
        <td width='170px'>Codigo de Servicio:</td>
        <td><? echo $cod_servicio; ?></td>
    </tr>
    
    <tr>
        <td>Servicio:</td>
        <td><? echo $desc_servicio; ?></td>
    </tr>
    
    <tr>
        <td>Sala:</td>
        <td><? echo $sala; ?></td>
    </tr>
    
    <tr>
    <td>Cama</td>
    <td><? echo $cama; ?></td>
    </tr>
    
    <tr>
    <td>Codigo Usuario</td>
    <td><? echo $cod_usuario; ?></td>
    </tr>
    
    <tr>
    <td>Usuario</td>
    <td><? echo $usuario; ?></td>
    </tr>
    
    
    <tr>
    <td>Fecha Categorizaci�n</td>
    <td><? echo $fecha_categorizacion; ?></td>
    </tr>
    
    <tr>
    <td>Observacion</td>
    <td><? echo $observacion; ?></td>
    </tr>
    
    <tr>
    <td>Categorizacion Riesgo</td>
    <td><? echo $categorizacion_riesgo; ?></td>
    </tr>
    
    <tr>
    <td>Categorizacion Dependencia</td>
    <td><? echo $categorizacion_dependencia; ?></td>
    </tr>
    
    <tr><td colspan="2">&nbsp;</td></tr>
    
    <tr align='center'>
<td colspan="2">
<?
if ($resultado1)
	{
	if ($resultado2)
		{
			if($desde == 'sscc'){
				$enlace =  "../ingresos/sscc.php";
				}else{
					$enlace = "camaSuperNum.php";
					}
			echo "El Proceso de Categorizacion se Realiz� con Exito </br></br>";
			?>
        <input class="buttonGeneral" type="button" value=" Volver " onclick="window.location.href='<? echo $enlace; ?>'" />
		<?
		}
		else
		{
			echo "El Cambio de Estado Fall� Pero el registro historico OK, comuniquesde con el administrador </br></br>";
			?>
		<input type="Button" value=" Volver " onClick="window.location.href='<? echo"detalleCamaSN.php?HOSid=$id_cama&PACid=$id_paciente"; ?>'" class="buttonGeneral" >
			<?
		}

	}
else
	{
	echo "El Proceso de Categorizaci�n Fall�, Intentelo Nuevamente </br></br>";
	?>
	<input type="Button" value=" Volver " onClick="window.location.href='<? echo"detalleCamaSN.php?HOSid=$id_cama&PACid=$id_paciente"; ?>'" class="buttonGeneral" >
	<?
	}
	?>

	</td>
	</tr>
    </table>

</td>
</tr>
</table>

</div>

</fieldset>
</td>
</tr>
</table>


</body>
</html>
