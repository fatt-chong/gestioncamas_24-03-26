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



$tipodocumento= $_GET['tipodocumento'];
$id_paciente= $_GET['id_paciente'];
$rut_paciente= $_GET['rut_paciente'];
$ficha_paciente= $_GET['ficha_paciente'];
$nom_paciente= $_GET['nom_paciente']; 
$edad_paciente= $_GET['edad_paciente'];
$sexo_paciente= $_GET['sexo_paciente'];
$cod_prevision= $_GET['cod_prevision'];
$direc_paciente= $_GET['direc_paciente'];
$cod_comuna= $_GET['cod_comuna'];
$fono1_paciente= $_GET['fono1_paciente'];
$fono2_paciente= $_GET['fono2_paciente'];
$hospitalizado= $_GET['hospitalizado'];
$conveniopago= $_GET['conveniopago'];
$prevision= $_GET['prevision']; 
$comuna= $_GET['comuna'];
$prevision= $_GET['prevision']; 
$comuna= $_GET['comuna'];
$cod_auge= $_GET['cod_auge'];
$cod_medico= $_GET['cod_medico'];
$cod_procedencia= $_GET['cod_procedencia'];
$diagnostico1= $_GET['diagnostico1']; 
$diagnostico2= $_GET['diagnostico2']; 
$fecha_ingreso= $_GET['fecha_ingreso'];
$hora_ingreso= $_GET['hora_ingreso'];
$movil_m= $_GET['movil_m'];
$movil_t= $_GET['movil_t'];
$movil_n= $_GET['movil_n'];
$movil_ma= $_GET['movil_ma'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Gestion de Camas Hospital Dr. Juan No&eacute C.</title>
<link type="text/css" rel="stylesheet" href="css/estilo.css" />
</head>
<body background="../../estandar/img/fdo.jpg" topmargin="5" style="font-family:Arial, Helvetica, sans-serif; font-size:12px">
	<table width="850px" align="center" border="2" bordercolor="#000000" bordercolorlight="#FFFFFF" bordercolordark="#666666" cellspacing="0" cellpadding="0">
    	<th height="20px" align="left" bgcolor="#006699" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; color:#FFF">&nbsp; Hospitalizaci&oacute;n de Paciente.</th>

        <tr>
            <td background="img/fondo.jpg">
            	<fieldset>


<div class="titulo" align="center">

<?
include "../funciones/funciones.php";

$servicio = "106";
$desc_servicio = "HOSP. DOMICILIARIA";

$quehora = $_SESSION['MM_Quehora'];



if ($ficha_paciente == '') { $ficha_paciente = 0; }
if ($rut_paciente == '') { $rut_paciente = 0; }
if ($edad_paciente < 0) {$edad_paciente = 0;}

$fecha_hospitalizacion = cambiarFormatoFecha2($fecha_ingreso);

mysql_connect ('10.6.21.29','usuario','hospital');
$sql = "SELECT * FROM sscc where id = '".$servicio."'";
mysql_select_db('camas') or die('Cannot select database');

$query = mysql_query($sql) or die(mysql_error());

$l_servicios = mysql_fetch_array($query);
$id_rau = $l_servicios['id_rau'];


$sql = "SELECT * FROM sscc where id = '".$cod_procedencia."'";
mysql_select_db('camas') or die('Cannot select database');

$query = mysql_query($sql) or die(mysql_error());

$l_servicios = mysql_fetch_array($query);
$procedencia = $l_servicios['servicio'];
$cod_sscc_desde = $l_servicios['id_rau'];

$hospitalizado = $fecha_hospitalizacion." ".$hora_ingreso;

if ($rut_paciente == '') { $rut_paciente = 0; }


$fecha = date('Y/m/d H:i');


mysql_select_db('paciente') or die('Cannot select database');
// Se recupera la ultima cuenta corriente del paciente para mostrarla
$query_rs_pac = "select max(idctacte) as id from ctacte";
print_r("<pre>"); print_r("insert ctacte"); print_r("</pre>");
print_r("<pre>"); print_r($query_rs_pac); print_r("</pre>");

$rs_pac = mysql_query($query_rs_pac) or die(mysql_error());
$row_rs_pac = mysql_fetch_assoc($rs_pac);
$totalRowsrspac = mysql_num_rows($rs_pac);

if ( $row_rs_pac['id'] != null )  {
	$nroctacte = $row_rs_pac['id']+1;
}
// Se procede a insertar la nueva cuenta corriente del paciente
$query_rs_pac = "INSERT INTO ctacte (idctacte, paciente_id, fechaapertura, unidadorigen, fechacierre, idpaciente, conveniopago)
						VALUES ( $nroctacte, $rut_paciente, '$fecha', 10366, '1900/01/01', $id_paciente, $conveniopago )";

print_r("<pre>"); print_r("insert ctacte"); print_r("</pre>");
print_r("<pre>"); print_r($query_rs_pac); print_r("</pre>");

// comentado 25-03-26
// $rs_pac = mysql_query($query_rs_pac) or die(mysql_error()."<br>".$query_rs_pac);


$cta_cte = $nroctacte;

$sql = "SELECT * FROM pauge where id = '".$cod_auge."'";
mysql_select_db('camas') or die('Cannot select database');
$query = mysql_query($sql) or die(mysql_error());

$l_pauge = mysql_fetch_array($query);
$auge = $l_pauge['pauge'];

$sql = "SELECT * FROM medicos where id = '".$cod_medico."'";
mysql_select_db('camas') or die('Cannot select database');
$query = mysql_query($sql) or die(mysql_error());

$l_medicos = mysql_fetch_array($query);
$medico = $l_medicos['medico'];


if ($d_acctransito == 'on') {
	$acctransito = 1;
}
else {
	$acctransito = 0;
}

echo "<table width='70%' align='center' border='0' cellspacing='0' cellpadding='0'>";
echo "<tr align='left'>";
echo "<td>";
echo "<fieldset style='padding:20px'>";
echo "<legend> Informacion de Hospitalizaci&oacute;n Domiciliaria</legend></br>";

echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>";

echo "<tr>";
echo "<td>Servicio</td>";
echo "<td>:".$desc_servicio."</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Hospitalizacion</td>";
echo "<td>:".substr($hospitalizado, 8, 2)."-".substr($hospitalizado, 5, 2)."-".substr($hospitalizado, 0, 4)." / ".substr($hospitalizado, 11, 5)."  Hrs.</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Ingreso</td>";
echo "<td>:".$fecha_ingreso." / ".$hora_ingreso." Hrs.</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Procedencia</td>";
echo "<td>:".$procedencia."</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Medico</td>";
echo "<td>:".medico."</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Pre-Diagnostico</td>";
echo "<td>:".$diagnostico1."</td>";
echo "</tr>";

echo "</table>";

echo "</fieldset>";
echo "</td>";
echo "</tr>";
echo "</table>";

	$sql = "INSERT INTO altaprecoz (
	cod_servicio,
	servicio,
	sala,
	cama,
	movil_m,
	movil_t,
	movil_n,
	movil_ma,
	cta_cte,
	cod_procedencia,
	procedencia,
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
	estado,
	hospitalizado,
	hora_ingreso,
	fecha_ingreso )
	VALUES (
	$servicio,
	'$desc_servicio',
	'SIN MOVIL',
	0,
	$movil_m,
	$movil_t,
	$movil_n,
	$movil_ma,
	$cta_cte,
	$cod_procedencia, 
	'$procedencia',
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
	'$cod_comuna', 
	'$comuna', 
	'$fono1_paciente', 
	'$fono2_paciente', 
	'$fono3_paciente', 
	2,
	'$hospitalizado',
	'$hora_ingreso',
	'$fecha_hospitalizacion' ) ";
	
//	echo $sql;
	mysql_select_db('camas') or die('Cannot select database');

	// comentado 25-03-26
	// $resultado_1 = mysql_query( $sql ) or die(mysql_error());
	print_r("<pre>"); print_r("insert altaprecoz"); print_r("</pre>");
	print_r("<pre>"); print_r($sql); print_r("</pre>");

	mysql_select_db('paciente') or die('Cannot select database');

	//comentado 25-03-26
	// $resultado_2 = mysql_query( "UPDATE paciente SET
	// hospitalizado   = '$hospitalizado'
	// WHERE id = $id_paciente "  ) or die(mysql_error());
	print_r("<pre>"); print_r("update paciente"); print_r("</pre>");
	print_r("<pre>"); print_r("UPDATE paciente SET hospitalizado   = '$hospitalizado'"); print_r("</pre>");
/*
	echo "<p>servicio : ".$servicio."</p>";
	echo "<p>desc_servicio : ".$desc_servicio."</p>";
	echo "<p>tipo_traslado : ".$tipo_traslado."</p>";
	echo "<p>tipo_1 :  ".$tipo_1."</p>";
	echo "<p>d_tipo_1 :".$d_tipo_1."</p>";
	echo "<p>tipo_2 :  ".$tipo_2."</p>";
	echo "<p>d_tipo_2 :".$d_tipo_2."</p>";
	echo "<p>cta_cte : ".$cta_cte."</p>";
	echo "<p>cod_procedencia : ".$cod_procedencia."</p>";
	echo "<p>procedencia : ".$procedencia    ."</p>";
	echo "<p>cod_medico : ".$cod_medico     ."</p>";
	echo "<p>medico : ".$medico         ."</p>";
	echo "<p>cod_auge : ".$cod_auge       ."</p>";
	echo "<p>auge : ".$auge           ."</p>";
	echo "<p>acctransito : ".$d_acctransito    ."</p>";
	echo "<p>diagnostico1 : ".$diagnostico1."</p>";
	echo "<p>diagnostico2 : ".$diagnostico2   ."</p>";
	echo "<p>id_paciente : ".$id_paciente    ."</p>";
	echo "<p>rut_paciente : ".$rut_paciente   ."</p>";
	echo "<p>ficha_paciente : ".$ficha_paciente ."</p>";
	echo "<p>nom_paciente : ".$nom_paciente   ."</p>";
	echo "<p>sexo_paciente : ".$sexo_paciente  ."</p>";
	echo "<p>edad_paciente : ".$edad_paciente  ."</p>";
	echo "<p>cod_prevision : ".$cod_prevision  ."</p>";
	echo "<p>prevision : ".$prevision      ."</p>";
	echo "<p>direc_paciente : ".$direc_paciente ."</p>";
	echo "<p>cod_comuna : ".$cod_comuna     ."</p>";
	echo "<p>comuna : ".$comuna         ."</p>";
	echo "<p>fono1_paciente : ".$fono1_paciente ."</p>";
	echo "<p>fono2_paciente : ".$fono2_paciente ."</p>";
	echo "<p>fono3_paciente : ".$fono3_paciente ."</p>";
	echo "<p>estado : ".$estado         ."</p>";
	echo "<p>fecha_ingreso : ".$fecha_ingreso     ."</p>";
*/

	echo "<form>";

	echo "</br>";
	echo "<table width='70%' align='center' border='0' cellspacing='0' cellpadding='0'>";
	echo "<tr align='center'>";
	echo "<td>";
	echo "<fieldset style='padding:20px'>";
	
	if ($resultado_1)
		{

/*echo $tipodocumento;
echo "<br>";
echo $id_traslado;
*/
			
		echo "La Ingreso a Hospitalizaci�n Domiciliaria se Realiz� con Exito </br></br>";
		?>
		 <input type="Button" value=" Volver " onClick="window.location.href='<? echo"aprecoz.php"; ?>'; parent.GB_hide();" >
		<!-- <input type="button" value="               Volver               " onClick="top.mainFrame.location.href='<? echo"aprecoz.php"; ?>';
parent.parent.GB_hide(); " >	 -->	
<?


		}
	else
		{
		echo "El Ingreso de Hospitalizaci�n Fall�, Intentelo Nuevamente";
		?>
   	    <input type="Button" value=" Volver " onClick="window.location.href='<? echo"ingresopaciente.php?tipodocumento=$tipodocumento"; ?>'; parent.GB_hide();" >
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
