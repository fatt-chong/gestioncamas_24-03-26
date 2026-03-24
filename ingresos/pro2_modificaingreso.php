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
    	<th height="20px" align="left" bgcolor="#006699" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; color:#FFF">&nbsp; Modificar Datos de Hospitalizaci&oacute;n.</th>

        <tr>
            <td background="img/fondo.jpg">
            	<fieldset>

<div class="titulo" align="center">

<?
include "../funciones/funciones.php";

$fecha_hospitalizacion = cambiarFormatoFecha2($fecha_ingreso);

$sql = "SELECT * FROM pauge where id = '".$cod_auge."'";
mysql_connect ($dbhost,'gestioncamas','123gestioncamas');
mysql_select_db('camas') or die('Cannot select database');
$query = mysql_query($sql) or die(mysql_error());

$l_pauge = mysql_fetch_array($query);
$auge = $l_pauge['pauge'];

$sql = "SELECT * FROM medicos where id = '".$cod_medico."'";
mysql_connect ($dbhost,'gestioncamas','123gestioncamas');
mysql_select_db('camas') or die('Cannot select database');
$query = mysql_query($sql) or die(mysql_error());

$l_medicos = mysql_fetch_array($query);
$medico = $l_medicos['medico'];

$sqlTipo = "SELECT * FROM camas WHERE id = $id_cama";
$queryTipo = mysql_query($sqlTipo) or die (mysql_error());
$arrayTipo = mysql_fetch_array($queryTipo);

$id_paciente = $arrayTipo['id_paciente'];
$rut_paciente = $arrayTipo['rut_paciente'];
$ficha_paciente = $arrayTipo['ficha_paciente'];
$prevision = $arrayTipo['prevision'];
$nom_paciente = $arrayTipo['nom_paciente'];
$direc_paciente = $arrayTipo['direc_paciente'];
$fono1 = $arrayTipo['fono1_paciente'];
$fono2 = $arrayTipo['fono2_paciente'];
$fono3 = $arrayTipo['fono3_paciente'];

$horaIngreso = $arrayTipo['hora_ingreso'];
$tipoCama1 = $arrayTipo['tipo_1'];
$tipoCama2 = $arrayTipo['tipo_2'];
$e_ficha = $arrayTipo['esta_ficha'];
$sexo_pac = $arrayTipo['sexo_paciente'];
$edad_paciente = $arrayTipo['edad_paciente'];
$cod_prevision = $arrayTipo['cod_prevision'];
$cod_comuna = $arrayTipo['cod_comuna'];
$comuna = $arrayTipo['comuna'];
$epiId = $arrayTipo['epiId'];
$hospitalizado = $arrayTipo['hospitalizado'];
$categorizacion_riesgo = $arrayTipo['categorizacion_riesgo'];
$categorizacion_dependencia = $arrayTipo['categorizacion_dependencia'];
$tipo1 = $arrayTipo['tipo_1'];
$dtipo1 = $arrayTipo['d_tipo_1'];
$tipo2 = $arrayTipo['tipo_2'];
$dtipo2 = $arrayTipo['d_tipo_2'];


if ($cod_procedencia == 0){

	$procedencia = 'URGENCIA';
}
else {

	$sql = "SELECT * FROM sscc where id = '".$cod_procedencia."'";
	mysql_connect ($dbhost,'gestioncamas','123gestioncamas');
	mysql_select_db('camas') or die('Cannot select database');
	$query = mysql_query($sql) or die(mysql_error());
	
	$l_servicios = mysql_fetch_array($query);
	$procedencia = $l_servicios['servicio'];

}

	$sql = "SELECT * FROM sscc where id = '".$que_cod_servicio."'";
	mysql_select_db('camas') or die('Cannot select database');
	
	$query = mysql_query($sql) or die(mysql_error());
	
	$l_servicios = mysql_fetch_array($query);
	$que_servicio = $l_servicios['servicio'];


if ($d_acctransito == 'on') {
	$acctransito = 1;
}
else {
	$acctransito = 0;
}

if ($d_multires == 'on') {
	$multires = 1;
}
else {
	$multires = 0;
}



//$estado = 2;


	switch ($tipo_1) {
		case 1:
			$d_tipo_1="CIRUGIA";
			break;
		case 2:
			$d_tipo_1="MEDICINA";
			break;
		case 3:
			$d_tipo_1="ONCOLOGIA";
			break;
		case 4:
			$d_tipo_1="PEDIATRIA UTI";
			$tipo_2=0;
			$d_tipo_2="";
			break;
		case 51:
			$tipo_1=5;
			$d_tipo_1="PEDIATRIA INDIFERENCIADA";
			$tipo_2=1;
			$d_tipo_2="MINIMO";
			break;
		case 52:
			$tipo_1=5;
			$d_tipo_1="PEDIATRIA INDIFERENCIADA";
			$tipo_2=2;
			$d_tipo_2="INTERMEDIO";
			break;
		case 61:
			$tipo_1=6;
			$d_tipo_1="PEDIATRIA LACTANTES";
			$tipo_2=1;
			$d_tipo_2="MINIMO";
			break;
		case 62:
			$tipo_1=6;
			$d_tipo_1="PEDIATRIA LACTANTES";
			$tipo_2=2;
			$d_tipo_2="INTERMEDIO";
			break;
		case 7:
			$d_tipo_1="TRAUMATOLOGIA";
			break;
		case 8:
			$d_tipo_1="GINECOLOGIA";
			break;
		case 9:
			$d_tipo_1="OBSTETRICIA";
			break;
		case 10:
			$d_tipo_1="PSIQUIATRIA";
			break;
		case 11:
			$d_tipo_1="UCI";
			break;
		case 12:
			$d_tipo_1="SAI";
			break;
		case 13:
			$d_tipo_1="NEONATOLOGIA UCI";
			break;
		case 14:
			$d_tipo_1="NEONATOLOGIA INTERMEDIO (INCUBADORA)";
			break;
		case 15:
			$d_tipo_1="NEONATOLOGIA CUNA BASICA";
			break;
		case 45:
			$d_tipo_1="PARTOS";
			break;
		case 46:
			$d_tipo_1="ALTA PRECOZ";
			break;
		case 50:
			$d_tipo_1="URGENCIA";
			break;

	}



	mysql_connect ($dbhost,'gestioncamas','123gestioncamas');
	mysql_select_db('camas') or die('Cannot select database');

	if($barthel != ''){
		$sqlBarthel = ",barthel = '$barthel'";
		$sqlBarthel1 = ", barthel";
		$sqlBarthel2 = ", $barthel";
		}else{
			$sqlBarthel = ",barthel = NULL";
			$sqlBarthel1 = ", barthel";
			$sqlBarthel2 = ", NULL";
			}
		
	$resultado = mysql_query( "UPDATE camas SET
	tipo_1          = $tipo_1,
	que_cod_servicio = $que_cod_servicio,
	que_servicio    = '$que_servicio',
	d_tipo_1        = '$d_tipo_1',
	tipo_2          = $tipo_2,
	d_tipo_2        = '$d_tipo_2',
	cta_cte         = $cta_cte,
	cod_procedencia = $cod_procedencia, 
	procedencia     = '$procedencia',
	cod_medico      = $cod_medico,
	medico          = '$medico',
	cod_auge        = $cod_auge, 
	auge            = '$auge', 
	acctransito     = $acctransito, 
	multires        = $multires, 
	diagnostico1    = '$diagnostico1',
	diagnostico2    = '$diagnostico2',
	fecha_ingreso   = '$fecha_hospitalizacion'".$sqlBarthel."
	WHERE id = $id_cama "  );
	
	?> 
    <!--VERIFICA SI EL TIPO DE CAMA CAMBIO, SI ES ASI, CREA UN MOVIMIENTO EN TABLA HOSPITALIZACION
    desde aqui --> <?
	
	
	if($tipoCama2 == 0){	
		if($tipoCama1 != $tipo_1){
			$insertarHosp = 1;
			}else{
				$insertarHosp = 0;
				}
	}else{
		if($tipoCama1 == $tipo_1){
			$insertarHosp = 0;
			/*if($tipoCama2 != $tipo_2){
				$insertarHosp = 1;
				echo "2.2";	
			}*/
		}else{
			$insertarHosp = 1;
		}
				
	}
	if($insertarHosp == 1){
	$fecha_actual = date('Y-m-d');
	$hora_actual = date("H:i:s");
	$anio_actual = date('Y');
	$sqlHospitaliza = "INSERT INTO hospitalizaciones
	(
	tipo_traslado,
	que_cod_servicio,
	que_servicio,
	cod_servicio, 
	servicio, 
	sala, 
	cama,
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
	censo_correlativo".$sqlBarthel1.")
	VALUES
	(
	'2',
	'$que_cod_servicio',
	'$que_servicio',
	'$que_cod_servicio',
	'$que_servicio', 
	'$psala', 
	'$pcama',
	'$tipo1',
	'$dtipo1',
	'$tipo2',
	'$dtipo2',
	'$cta_cte',
	'$cod_procedencia', 
	'$procedencia',
	'$que_cod_servicio',
	'$que_servicio',
	'$cod_medico',
	'$medico',
	'$cod_auge', 
	'$auge', 
	'$acctransito', 
	'$multires',
	'$epiId',
	'$diagnostico1',
	'$diagnostico2',
	'$id_paciente', 
	'$rut_paciente', 
	'$ficha_paciente', 
	'$esta_ficha', 
	'$nom_paciente',
	'$sexo_pac', 
	'$edad_paciente', 
	'$cod_prevision', 
	'$prevision', 
	'$direc_paciente', 
	'$cod_comuna', 
	'$comuna', 
	'$fono1', 
	'$fono2', 
	'$fono3',
	'$categorizacion_riesgo',
	'$categorizacion_dependencia',
	'$hospitalizado',
	'$fecha_hospitalizacion',
	'$horaIngreso',
	'$fecha_actual',
	'$hora_actual',
	'$anio_actual',
	'0'".$sqlBarthel2.")";
	
	$queryHospitaliza = mysql_query($sqlHospitaliza) or die("ERROR EN INSERTAR DATOS EN HOSPITALIZACION <br> $insertRN <br>".mysql_error());
	
$sqlactCama = mysql_query("UPDATE camas SET
	fecha_ingreso = '$fecha_actual',
	hora_ingreso = '$hora_actual'
	WHERE id = '$id_cama' " ) or die("ERROR AL ACTUALIZAR CAMAS <br> $sqlactCama <br>".mysql_error());

	}
	
	?><!--hasta aqui--><?



/*
	echo "<p>id_cama : ".$id_cama."</p>";

	echo "<p>cama : ".$cama."</p>";
	echo "<p>sala : ".$sala."</p>";
	echo "<p>servicio : ".$servicio."</p>";
	echo "<p>desc_servicio : ".$desc_servicio."</p>";
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
	echo "<p>edad_paciente : ".$edad_paciente  ."</p>";
	echo "<p>cod_prevision : ".$cod_prevision  ."</p>";
	echo "<p>prevision : ".$prevision      ."</p>";
	echo "<p>direc_paciente : ".$direc_paciente ."</p>";
	echo "<p>cod_comuna : ".$cod_comuna     ."</p>";
	echo "<p>comuna : ".$comuna         ."</p>";
	echo "<p>fono1_paciente : ".$fono1_paciente ."</p>";
	echo "<p>fono1_paciente : ".$fono2_paciente ."</p>";
	echo "<p>fono1_paciente : ".$fono3_paciente ."</p>";
	echo "<p>estado : ".$estado         ."</p>";
	echo "<p>fecha_ingreso : ".$fecha_ingreso     ."</p>";
*/


	echo "<form>";

	echo "<table width='70%' align='center' border='0' cellspacing='0' cellpadding='0'>";
	echo "<tr align='center'>";
	echo "<td>";
	echo "<fieldset style='padding:20px'>";

	if ($resultado)
		{
		echo "Cambio de Datos de Hospitalización se Realizó con Exito </br></br> ";
		?>
        <input type="Button" value=    "       OK       " onclick="window.location.href='<? echo"altapaciente.php?id_cama=$id_cama"; ?>'; parent.GB_hide(); " />

		<?
		}
	else
		{
		echo "El Cambio de Datos de Hospitalización Falló, Intentelo Nuevamente";
		?>
        <input type="Button" value=    "       Volver       " onclick="window.location.href='<? echo"altapaciente.php?id_cama=$id_cama"; ?>'; parent.GB_hide(); " />

		<?
		}

	echo "</fieldset>";
	echo "</td>";
	echo "</tr>";
	echo "</table>";

?>

</form>

</div>
</fieldset>
</td>
</tr>
</table>

</body>
</html>