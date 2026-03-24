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

$fecha_actual = date("Y-m-d H:i:s");
$usuario_salida = $_SESSION['MM_Username'];

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
    	<th height="20px" align="left" bgcolor="#006699" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; color:#FFF">&nbsp; Egreso de Paciente (Alta, Traslado).</th>

        <tr>
            <td background="img/fondo.jpg">
            	<fieldset>

<div class="titulo" align="center">

<?
include "../funciones/funciones.php";

mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');
mysql_select_db('camas') or die('Cannot select database');

$sqlVerifica = "SELECT * FROM camas WHERE id = $id_cama";
$queryVerifica = mysql_query($sqlVerifica) or die(mysql_error());

$paciente = mysql_fetch_array($queryVerifica);

$id_paciente = $paciente['id_paciente'];

if($id_paciente <> 0){ //VERIFICA QUE EL PACIENTE NO HAYA SIDO DADO DE ALTA ANTES

$fecha_hospitalizacion = cambiarFormatoFecha2($fecha_ingreso);
$fecha_alta = $fecha_egreso;

$fecha_ingreso = cambiarFormatoFecha($fecha_hospitalizacion);
$fecha_egreso = cambiarFormatoFecha($fecha_alta);

if ($que_cod_servicio == '') { $que_cod_servicio = $cod_servicio; }

if ($cod_destino > 100)
{
	$tipo_traslado = $cod_destino;
    $desc_servicio_hasta = 'Externo';
}
	

$query = mysql_query("SELECT * FROM sscc where id = $cod_destino") or die(mysql_error());
$query_servicio = mysql_fetch_array($query);

$cod_servicio_hasta = $query_servicio['id_rau'];
$desc_servicio_hasta = $query_servicio['servicio'];
$destino = $query_servicio['servicio'];

mysql_select_db('camas') or die('Cannot select database');
$query = mysql_query("SELECT * FROM sscc where id = $cod_servicio") or die(mysql_error());
$query_servicio = mysql_fetch_array($query);

$cod_servicio_desde = $query_servicio['id_rau'];
$desc_servicio_desde = $query_servicio['servicio'];

if($info_pac == 0){
	$informacion = 'Si';
	}else if($info_pac == 1){
		$informacion = 'No';
		}

echo "<table width='70%' align='center' border='0' cellspacing='0' cellpadding='0'>";
echo "<tr align='left'>";
echo "<td>";
echo "<fieldset style='padding:30px'>";
echo "<legend> Informacion de Egreso de Paciente </legend></br>";

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

echo "<tr>";
echo "<td>Info. al Paciente</td>";
echo "<td>: ".$informacion."</td>";
echo "</tr>";

echo "</table>";

echo "</fieldset>";
echo "</td>";
echo "</tr>";
echo "</table>";

	$anio_actual = date('Y');
	$a_egreso= explode("-", $fecha_egreso);
	$anio_egreso = $a_egreso[0];
	
	if($barthel != ''){
		$sqlBarthel = ", barthel";
		$sqlBarthel2 = ", $barthel";
		}
		
	$sql = "INSERT INTO hospitalizaciones
	(
	tipo_traslado,
	que_cod_servicio,
	que_servicio,
	cod_servicio, 
	servicio, 
	sala, 
	cama,
	id_cama,
	tipo_1,
	d_tipo_1,
	tipo_2,
	d_tipo_2,
	cta_cte,
	cod_procedencia, 
	procedencia, 
	cod_destino, 
	destino, 
	cod_medico, 
	medico, 
	cod_auge, 
	auge, 
	acctransito, 
	multires,
	epiId,
	diagnostico1, 
	diagnostico2, 
	id_paciente, 
	rut_paciente, 
	ficha_paciente, 
	esta_ficha, 
	nom_paciente, 
	sexo_paciente, 
	edad_paciente, 
	cod_prevision, 
	prevision, 
	direc_paciente, 
	cod_comuna, 
	comuna, 
	fono1_paciente, 
	fono2_paciente, 
	fono3_paciente,
	categorizacion_riesgo,
	categorizacion_dependencia,
	hospitalizado,
	fecha_ingreso,
	hora_ingreso,
	fecha_egreso,
	hora_egreso,
	censo_anio,
	censo_correlativo,
	info_egreso,
	id_parto,
	usuario_que_ingresa,
	fecha_usuario_ingreso,
	usuario_que_egresa,
	fecha_usuario_egreso ".$sqlBarthel."
	)
	VALUES
	(
	$tipo_traslado,
	$que_cod_servicio,
	'$que_servicio',
	$cod_servicio, 
	'$desc_servicio', 
	'$sala', 
	$cama,
	$id_cama,
	$tipo_1,
	'$d_tipo_1',
	$tipo_2,
	'$d_tipo_2',
	$cta_cte,
	$cod_procedencia, 
	'$procedencia',
	$cod_destino, 
	'$destino',
	$cod_medico,
	'$medico',
	$cod_auge, 
	'$auge', 
	$acctransito, 
	$multires,
	$epiId,
	'$diagnostico1',
	'$diagnostico2',
	$id_paciente, 
	$rut_paciente, 
	$ficha_paciente, 
	$esta_ficha, 
	'$nom_paciente',
	'$sexo_paciente', 
	$edad_paciente, 
	$cod_prevision, 
	'$prevision', 
	'$direc_paciente', 
	$cod_comuna, 
	'$comuna', 
	'$fono1_paciente', 
	'$fono2_paciente', 
	'$fono3_paciente',
	'$categorizacion_riesgo',
	'$categorizacion_dependencia',
	'$hospitalizado',
	'$fecha_ingreso',
	'$hora_ingreso',
	'$fecha_egreso',
	'$hora_egreso',
	'$anio_egreso',
	0,
	'$info_pac',
	'$id_parto',
	'$usuario_que_ingresa',
	'$fecha_usuario_ingresa',
	'$usuario_salida',
	'$fecha_actual'".$sqlBarthel2."
	) ";
	
//	echo $sql;

	mysql_select_db('camas') or die('Cannot select database');
	
	$resultado1 = mysql_query( $sql ) or die($sql."Error al grabar hospitalizacion ".mysql_error());

/*	echo "<p>tipo_traslado   : ".$tipo_traslado."</p>";
	echo "<p>cod_servicio    : ".$cod_servicio."</p>";
	echo "<p>desc_servicio   : ".$desc_servicio."</p>";
	echo "<p>sala            : ".$sala."</p>";
	echo "<p>cama            : ".$cama."</p>";
	echo "<p>cta_cte         : ".$cta_cte."</p>";
	echo "<p>cod_procedencia : ".$cod_procedencia."</p>"; 
	echo "<p>procedencia     : ".$procedencia."</p>";
	echo "<p>cod_medico      : ".$cod_medico."</p>";
	echo "<p>medico          : ".$medico."</p>";
	echo "<p>cod_auge        : ".$cod_auge."</p>";
	echo "<p>auge            : ".$auge."</p>";
	echo "<p>acctransito     : ".$acctransito."</p>"; 
	echo "<p>diagnostico1    : ".$diagnostico1."</p>";
	echo "<p>diagnostico2    : ".$diagnostico2."</p>";
	echo "<p>id_paciente     : ".$id_paciente."</p>";
	echo "<p>rut_paciente    : ".$rut_paciente."</p>";
	echo "<p>ficha_paciente  : ".$ficha_paciente."</p>";
	echo "<p>esta_ficha		 : ".$esta_ficha."</p>";
	echo "<p>nom_paciente    : ".$nom_paciente."</p>";
	echo "<p>sexo_paciente   : ".$sexo_paciente."</p>";
	echo "<p>cod_prevision   : ".$cod_prevision."</p>";
	echo "<p>prevision       : ".$prevision."</p>";
	echo "<p>direc_paciente  : ".$direc_paciente."</p>";
	echo "<p>cod_comuna      : ".$cod_comuna."</p>";
	echo "<p>comuna          : ".$comuna."</p>";
	echo "<p>fono1_paciente  : ".$fono1_paciente."</p>";
	echo "<p>fono2_paciente  : ".$fono2_paciente."</p>";
	echo "<p>fono3_paciente  : ".$fono3_paciente."</p>";
	echo "<p>categorizacion_riesgo : ".$categorizacion_riesgo."</p>";
	echo "<p>categorizacion_dependencia : ".$categorizacion_dependencia."</p>";
	echo "<p>fecha_ingreso   : ".$fecha_ingreso."</p>";
	echo "<p>fecha_egreso    : ".$fecha_egreso."</p>";
	echo "<p>hora_egreso    : ".$hora_egreso."</p>";
*/


mysql_select_db('camas') or die('Cannot select database');

$resultado2 = mysql_query( "UPDATE camas SET
tipo_traslado   = 0,
cta_cte         = 0,
cod_procedencia = 0, 
procedencia     = '',
cod_medico      = 0,
medico          = '',
cod_auge        = 0, 
auge            = '', 
acctransito     = 0, 
multires        = 0,
epiId           = 0,
diagnostico1    = '',
diagnostico2    = '',
id_paciente     = 0, 
rut_paciente    = 0, 
ficha_paciente  = 0, 
esta_ficha      = 0, 
nom_paciente    = '', 
sexo_paciente   = '', 
edad_paciente   = 0, 
cod_prevision   = 0, 
prevision       = '', 
direc_paciente  = '', 
cod_comuna      = 0, 
comuna          = '', 
fono1_paciente  = '0', 
fono2_paciente  = '0', 
fono3_paciente  = '0',
fecha_categorizacion = '0000-00-00',
categorizacion_riesgo  = '',
categorizacion_dependencia  = '',
pabellon        = 0,
estado          = 1,
hospitalizado   = '0000-00-00 00:00:00',
fecha_ingreso   = '0000-00-00',
hora_ingreso    = '00:00:00',
id_parto = '0',
usuario_que_ingresa = '',
fecha_usuario_ingresa = '0000-00-00 00:00:00',
barthel = NULL
WHERE id = $id_cama "  ) or die(mysql_error());

$fecha_linea = date('mdYHis');

//SACA A LOS PACIENTE DE PIXYS CUANDO EL PACIENTE SE VAYA DE UCI O SAI HACIA ALGUN SERVICIO O ALTA

if(($cod_destino <> 8) and ($cod_destino <> 9)){
	if (ftp_connect('10.6.18.95', 21, 1)) { // real pyxis .95
			
			$nombre_archivo = "alta_".$rut_paciente."_".$fecha_linea.".txt";
			$fp = fopen("ftp://pyxis:b4uleave!2@10.6.18.95/".$nombre_archivo, "a");
			//$fp = fopen("ftp://viviana:viviana@10.6.18.150/".$nombre_archivo, "a");
			
			fwrite($fp, "EPD|".$fecha_linea."|".$cta_cte."|".$id_paciente."|X|".$rut_paciente."||||");
			fclose($fp); 	
	}
	else
	{
        echo "<a style='font-size:16px; color: #F00;' align='center' colspan='3'> ��� El paciente no fue Eliminado de pyxis, pero puede realizar este proceso de forma manual...!!! </a>";
	}
}
// echo $cod_destino. "   -     ".$mensaje;

if ($cod_destino < 100 and $mensaje == "") {
	
	mysql_select_db('camas') or die('Cannot select database');
	
	$sql = "INSERT INTO transito_paciente
	(
	cta_cte,
	cod_sscc_desde,
	desc_sscc_desde,
	cod_sscc_hasta,
	desc_sscc_hasta,
	id_paciente,
	rut_paciente,
	ficha_paciente,
	nom_paciente,
	tipo_traslado,
	hospitalizado,
	fecha,
	hora,
	cod_medico, 
	cod_auge, 
	acctransito, 
	multires, 
	diagnostico1, 
	diagnostico2,
	id_parto ".$sqlBarthel."
	)
	VALUES
	(
	$cta_cte,
	$cod_servicio_desde, 
	'$desc_servicio_desde', 
	$cod_servicio_hasta, 
	'$desc_servicio_hasta', 
	$id_paciente, 
	$rut_paciente, 
	$ficha_paciente, 
	'$nom_paciente',
	2,
	'$hospitalizado',
	'$fecha_egreso',
	'$hora_egreso',
	$cod_medico,
	$cod_auge, 
	$acctransito, 
	$multires,
	'$diagnostico1',
	'$diagnostico2',
	'$id_parto'".$sqlBarthel2."
	) ";
	
	$resultado3 = mysql_query( $sql ) or die(mysql_error());
	

// echo $sql;


/*
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
*/

}

if ($cod_destino > 99)
{
	
	mysql_select_db('paciente') or die('Cannot select database');

	$resultado_5 = mysql_query( "UPDATE ctacte SET
	fechacierre  = '$fecha_egreso',
	estado       = 'C'
	WHERE idctacte = $cta_cte "  ) or die(mysql_error());

	mysql_select_db('camas') or die('Cannot select database');

	$resultado_6 = mysql_query( "UPDATE transito_fichas SET
	fecha_alta  = '$fecha_egreso',
	estado       = 3
	WHERE id_paciente = $id_paciente and estado = 2"  ) or die(mysql_error());


	//if (ftp_connect('10.6.18.95', 21, 1)) {
//		
//		$nombre_archivo = "alta_".$rut_paciente."_".$fecha_linea.".txt";
//		$fp = fopen("ftp://pyxis:b4uleave!2@10.6.18.95/".$nombre_archivo, "a");
//		
//		fwrite($fp, "EPD|".$fecha_linea."|".$cta_cte."|".$id_paciente."|X|".$rut_paciente."||||");
//		fclose($fp); 		
//
///*		echo "rut : ".$rut_paciente;
//		echo "</br>";
//		echo "id paciente : ".$id_paciente;
//		echo "</br>";
//		echo "Cta-Cte : ".$cta_cte;
//		echo "</br>";
//*/
//
//
//	}
//	else
//	{
//        echo "<a style='font-size:16px; color: #F00;' align='center' colspan='3'> ��� El paciente no fue Eliminado de pyxis, pero puede realizar este proceso de forma manual...!!! </a>";
//	}
	
}


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
			echo "EL Proceso de Egreso se Realiz� con Exito </br></br>";
			?>
<input type="button" class="boton" value="               Volver               " onclick="top.mainFrame.location.href='<? echo"sscc.php"; ?>';
			parent.parent.GB_hide(); " />
<?
		}
	else
		{
			echo "El Egreso Fall� Pero el registro historico OK, comuniquesde con el administrador </br></br>";
			?>
			<input type="Button" class="boton" value=" Volver " onclick="window.location.href='<? echo"altapaciente.php?id_cama=$id_cama"; ?>'; parent.GB_hide(); " />
			<?
		}

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
<? } else{?>

<table width='70%' align='center' border='0' cellspacing='0' cellpadding='0'>
<tr align='center'>
<td>

<fieldset style='padding:30px'>
�El paciente seleccionado ya ha sido dado de alta!<br /><br />
<input type="Button" class="boton" value=" Volver " onClick="window.location.href='<? echo"sscc.php"; ?>'; parent.GB_hide(); " >
</fieldset>
</table>
<? } ?>

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
