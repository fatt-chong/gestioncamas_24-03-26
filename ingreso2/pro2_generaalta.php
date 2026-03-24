<?php 
//usar la funcion header habiendo mandado c�digo al navegador
ob_start(); 
//end para header

if (!isset($_SESSION)) {
	session_start();
}

$id_cama= $_GET['id_cama']; 
$cod_servicio= $_GET['cod_servicio']; 
$desc_servicio= $_GET['desc_servicio']; 
$sala= $_GET['sala'];  
$cama= $_GET['cama']; 
$cta_cte= $_GET['cta_cte']; 
$cod_procedencia= $_GET['cod_procedencia']; 
$procedencia= $_GET['procedencia']; 
$cod_medico= $_GET['cod_medico']; 
$medico= $_GET['medico']; 
$cod_auge= $_GET['cod_auge']; 
$auge= $_GET['auge']; 
$acctransito= $_GET['acctransito']; 
$diagnostico1= $_GET['diagnostico1']; 
$diagnostico2= $_GET['diagnostico2']; 
$id_paciente= $_GET['id_paciente']; 
$rut_paciente= $_GET['rut_paciente']; 
$ficha_paciente= $_GET['ficha_paciente']; 
$nom_paciente= $_GET['nom_paciente'];
$sexo_paciente= $_GET['sexo_paciente']; 
$edad_paciente= $_GET['edad_paciente']; 
$cod_prevision= $_GET['cod_prevision']; 
$prevision= $_GET['prevision'];
$direc_paciente= $_GET['direc_paciente']; 
$cod_comuna= $_GET['cod_comuna']; 
$comuna= $_GET['comuna']; 
$fono1_paciente= $_GET['fono1_paciente']; 
$fono2_paciente= $_GET['fono2_paciente']; 
$fono3_paciente= $_GET['fono3_paciente']; 
$categorizacion_riesgo= $_GET['categorizacion_riesgo']; 
$categorizacion_dependencia= $_GET['categorizacion_dependencia']; 
$hospitalizado= $_GET['hospitalizado']; 
$fecha_ingreso= $_GET['fecha_ingreso']; 
$hora_ingreso= $_GET['hora_ingreso']; 
$cod_destino= $_GET['cod_destino']; 
$fecha_egreso= $_GET['fecha_egreso']; 
$hora_egreso= $_GET['hora_egreso']; 

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
    	<th height="20px" align="left" bgcolor="#006699" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; color:#FFF">&nbsp; Egreso de Paciente (Alta, Traslado).</th>

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


if ($cod_destino > 100)
{
	$tipo_traslado = $cod_destino;
    $desc_servicio_hasta = 'Externo';
}
	
mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');
mysql_select_db('camas') or die('Cannot select database');
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

echo "</table>";

echo "</fieldset>";
echo "</td>";
echo "</tr>";
echo "</table>";

	$sql = "INSERT INTO hosp_aprecoz
	(
	cod_servicio, 
	servicio, 
	sala, 
	cama,
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
	diagnostico1, 
	diagnostico2, 
	id_paciente, 
	rut_paciente, 
	ficha_paciente, 
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
	hora_egreso
	)
	VALUES
	(
	$cod_servicio, 
	'$desc_servicio', 
	'$sala', 
	$cama,
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
	'$diagnostico1',
	'$diagnostico2',
	$id_paciente, 
	$rut_paciente, 
	$ficha_paciente, 
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
	'$hora_egreso'
	) ";


	mysql_select_db('camas') or die('Cannot select database');
	
	$resultado1 = mysql_query( $sql ) or die(mysql_error());



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

$resultado2 = mysql_query( "DELETE FROM altaprecoz WHERE id = $id_cama "  ) or die(mysql_error());


	mysql_select_db('paciente') or die('Cannot select database');

	$resultado_4 = mysql_query( "UPDATE paciente SET
	hospitalizado   = !null
	WHERE id = $id_paciente "  ) or die(mysql_error());

	mysql_select_db('paciente') or die('Cannot select database');

	$resultado_5 = mysql_query( "UPDATE ctacte SET
	fechacierre  = '$fecha_egreso',
	estado       = 'C'
	WHERE idctacte = $cta_cte "  ) or die(mysql_error());


	
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
			echo "La Proceso de Egreso se Realiz� con Exito </br></br>";
			?>
<input type="Button" value=" Volver " onClick="window.location.href='<? echo"aprecoz.php"; ?>'; parent.GB_hide();" >
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
