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

<title>Gestion de Camas Hospital Dr. Juan No&eacute C.</title>
<link type="text/css" rel="stylesheet" href="css/estilo.css" />
</head>
<body background="../../estandar/img/fdo.jpg" topmargin="5" style="font-family:Arial, Helvetica, sans-serif; font-size:12px">
	<table width="850px" align="center" border="2" bordercolor="#000000" bordercolorlight="#FFFFFF" bordercolordark="#666666" cellspacing="0" cellpadding="0">
    	<th height="20px" align="left" bgcolor="#006699" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; color:#FFF">&nbsp; Hospitalizaci&oacute;n de Paciente.</th>

        <tr>
            <td background="img/fondo.jpg">
            	<fieldset>
<?
mysql_connect ('10.6.21.29','usuario','hospital');
mysql_select_db('camas') or die('Cannot select database');

$id_cama = $_SESSION['MM_pro_id_cama'];
$cama = $_SESSION['MM_pro_cama'];
$sala = $_SESSION['MM_pro_sala'];
$servicio = $_SESSION['MM_pro_servicio'];
$desc_servicio = $_SESSION['MM_pro_desc_servicio'];
$estado = $_SESSION['MM_pro_estado'];

//VERIFICA SI LA CAMA SELECCIONA NO SE ENCUENTRA UTILIZADA COMO SN
$sqlVerifica = mysql_query("SELECT * FROM camas where id = $id_cama") or die("ERROR AL SELECCIONAR CAMA ".mysql_error());
$arrayVerifica = mysql_fetch_array($sqlVerifica);
$estadoCama = $arrayVerifica['estado'];

if(($estadoCama != 5) and ($estadoCama != 2)){
?>

<div class="titulo" align="center">

<?
include "../funciones/funciones.php";


	$tipo_2=0;
	$d_tipo_2="";
	
	if ($ficha_paciente == '') { $ficha_paciente = 0; }
	if ($rut_paciente == '') { $rut_paciente = 0; }


if ($servicio == 6 or $servicio == 7 or$servicio == 10 or $servicio == 11 or $servicio == 14)
{

	switch ($tipo_1) {
		case 4:
			$d_tipo_1="PEDIATRIA UTI";
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
		case 8:
			$d_tipo_1="GINECOLOGIA";
			break;
		case 9:
			$d_tipo_1="OBSTETRICIA";
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
	}
}
else
{
	$tipo_1 = $_SESSION['MM_pro_tipo_1'];
	$d_tipo_1 = $_SESSION['MM_pro_d_tipo_1'];
}

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

		$sql = "SELECT * FROM sscc where id = '".$que_cod_servicio."'";
		mysql_select_db('camas') or die('Cannot select database');
		
		$query = mysql_query($sql) or die(mysql_error());
		
		$l_servicios = mysql_fetch_array($query);
		$que_servicio = $l_servicios['servicio'];



		if ($tipo_traslado == 1)
		{
		
			if ($ficha_paciente <> 0)
			{
	
				$solicitudcabecera = sprintf("INSERT INTO solicitudespecial (solFechaSol, solHoraSol, serviCod, centrCod, solObservacion, solUsuarCod, solFunSolicita, solProfeCod, solServiCod, solCentrCod) VALUES ('$fecha_hospitalizacion', '$hora_ingreso', $id_rau, 103, 'Solicitud de Ficha para Paciente Hospitalizado', '%s', '%s', 0, 0, 0)", $_SESSION['MM_Username'], $_SESSION['MM_Username']); 
	
				mysql_select_db('paciente') or die('Cannot select database');
	
				$Result1 = mysql_query($solicitudcabecera) or die(mysql_error());
				
				//Recupera el ID utilizado en la cabecera de Solicitud Especial de Ficha
				$query_max = "SELECT MAX(solId) AS solNum FROM solicitudespecial";
				$rs_query_max = mysql_query($query_max) or die(mysql_error());
				$row_rs_query_max = mysql_fetch_assoc($rs_query_max);
	
				//Inserta registro en detalle de Solicitud Especial de Ficha
				$solicituddetalle = sprintf("INSERT INTO solicitudespecialdetalle (solId, fichaNroFicha, solEstadoFicha) 
								 VALUES (%s, $ficha_paciente, 'P')", $row_rs_query_max['solNum']);
				mysql_select_db('paciente') or die('Cannot select database');
				$Result1 = mysql_query($solicituddetalle) or die(mysql_error());
				
			
			}

		}
		else
		{
//echo " entre a else de 0 0 90 ";		
			$tipo_traslado = 2;

		}
		
		if ($ficha_paciente == 0) { $estado_ficha = 0; } else { $estado_ficha = 1; }

		$sql = "SELECT * FROM transito_fichas where id_paciente = $id_paciente";
		mysql_select_db('camas') or die('Cannot select database');
		
		$query = mysql_query($sql) or die(mysql_error());
		$query_estado = mysql_fetch_array($query);
		
		if ($query_estado)
		{
			$estado_ficha = $query_estado['estado'];
			
			if ($estado_ficha == 3) { $estado_ficha = 2; }
			if ($ficha_paciente == 0) { $estado_ficha = 0;}
			
			$transitofichas = "UPDATE transito_fichas SET cod_sscc_desde = $cod_procedencia, desc_sscc_desde = '$procedencia', cod_sscc = $id_rau, desc_sscc = '$desc_servicio', estado = $estado_ficha WHERE id_paciente = $id_paciente";
			
		}
		else
		{
			$transitofichas = "INSERT INTO transito_fichas (nro_ficha, id_paciente, rut_paciente, nom_paciente, cod_sscc_desde, desc_sscc_desde, cod_sscc, desc_sscc, fecha_solicitud, estado) VALUES ($ficha_paciente, $id_paciente, $rut_paciente, '$nom_paciente', $cod_procedencia, '$procedencia', $id_rau, '$desc_servicio', '$fecha_hospitalizacion', $estado_ficha)";
		
		}

		mysql_select_db('camas') or die('Cannot select database');
		$Result1 = mysql_query($transitofichas) or die(mysql_error());			





if ($rut_paciente == '') { $rut_paciente = 0; }

if ($cta_cte == '') { $cta_cte = 0; }

if ($estado_ficha == 2) { $esta_ficha = 1; } else { $esta_ficha = 0; }


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

if ($d_multires == 'on') {
	$multires = 1;
}
else {
	$multires = 0;
}


echo "<table width='70%' align='center' border='0' cellspacing='0' cellpadding='0'>";
echo "<tr align='left'>";
echo "<td>";
echo "<fieldset style='padding:20px'>";
echo "<legend> Informacion de Hospitalizaci�n </legend></br>";

echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>";

echo "<tr width='100px'>";
echo "<td width='170px'>Cama Nro</td>";
echo "<td>:".$cama."</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Sala Nro</td>";
echo "<td>:".$sala."</td>";
echo "</tr>";

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

	if($barthel != ''){
		$sqlBarthel = ",barthel = '$barthel'";
		}
if($id_parto==''){$id_parto =0;}
	$sql = "UPDATE camas SET
	tipo_traslado   = $tipo_traslado,
	que_cod_servicio = $que_cod_servicio,
	que_servicio    = '$que_servicio',
	tipo_1          = $tipo_1,
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
	id_paciente     = $id_paciente, 
	rut_paciente    = $rut_paciente, 
	ficha_paciente  = $ficha_paciente,
	esta_ficha  	= $esta_ficha,
	nom_paciente    = '$nom_paciente', 
	sexo_paciente   = '$sexo_paciente', 
	edad_paciente   = $edad_paciente, 
	cod_prevision   = '$cod_prevision', 
	prevision       = '$prevision', 
	direc_paciente  = '$direc_paciente', 
	cod_comuna      = '$cod_comuna', 
	comuna          = '$comuna', 
	fono1_paciente  = '$fono1_paciente', 
	fono2_paciente  = '$fono2_paciente', 
	fono3_paciente  = '$fono3_paciente', 
	pabellon        = 0,
	estado          = 2,
	hospitalizado   = '$hospitalizado',
	hora_ingreso    = '$hora_ingreso',
	fecha_ingreso   = '$fecha_hospitalizacion',
	id_parto		= '$id_parto',
	usuario_que_ingresa = '$usuario_salida',
	fecha_usuario_ingresa = '$fecha_actual'".$sqlBarthel."
	WHERE id = $id_cama "; //echo $sql;


	mysql_select_db('camas') or die('Cannot select database');

	$resultado_1 = mysql_query( $sql ) or die(mysql_error());
	
	
	mysql_select_db('camas') or die('Cannot select database');
			
	$resultado_2 = mysql_query( "DELETE FROM transito_paciente WHERE id = $id_traslado"  ) or die(mysql_error());
	
	if($id_solicitud != ''){
		$resultado_3 = "UPDATE solicitud_hosp 
						SET
						estadoSol = 3
						WHERE idSol = '$id_solicitud'
						AND idpacSol = '$id_paciente'";
		$query_resultado3 = mysql_query($resultado_3) or die($resultado_3." <br/>Error al actualizar el estado de la solicitud <br/>".mysql_error());
	}


/*
	echo "<p>cama : ".$cama."</p>";
	echo "<p>sala : ".$sala."</p>";
	echo "<p>servicio : ".$servicio."</p>";
	echo "<p>desc_servicio : ".$desc_servicio."</p>";
	echo "<p>id_cama : ".$id_cama."</p>";
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
		
/*		echo "Nombre archivo : ".$nombre_archivo;
		echo "</br>";
		echo "FP : ".$fp;
		echo "</br>";
		echo "Linea : ".$c_linea;
		
		echo "</br>";
		echo "rut : ".$rut_paciente;
		echo "</br>";
		echo "nombre : ".$nom_paciente;
		echo "</br>";
		echo "id paciente : ".$id_paciente;
		echo "</br>";
		echo "serviocio : ".$id_rau;
		echo "</br>";
		echo "Cta-Cte : ".$cta_cte;
		echo "</br>";
*/
		
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
	echo "<fieldset style='padding:20px'>";
	
	if ($resultado_1 and $resultado_2)
		{
			echo "La Hospitalizaci�n se Realiz� con Exito </br></br>";
			?>
			<input class="boton" type="button" value="               Volver               " onClick="top.mainFrame.location.href='<? echo"sscc.php"; ?>';
			parent.parent.GB_hide(); " >		<?
		}
	else
		{
			if ($resultado_1 == "")
			{
			echo "El Ingreso de Hospitalizaci�n Fall�, Intentelo Nuevamente";
			}
			if ($resultado_2 == "")
			{
			echo "El Ingreso en Traslados Fall�, Intentelo Nuevamente";
			}
		
			?>
   		    <input class="boton" type="Button" value=" Volver " onClick="window.location.href='<? echo"ingresopaciente.php?id_cama=$id_cama"; ?>'; parent.GB_hide();" >
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
<? } else{?>

<fieldset class="fieldset_det2"><legend>Error</legend>
    	<table style="font-size:18px; color: #F00;" align="center" border="0" cellspacing="0" cellpadding="0">
	            <tr height="25px">
    	        </tr>
        	    <tr>
            	    <td align="center">La cama ha cambiado de estado,</td>
	            </tr>
    	        <tr>
        	        <td align="center"> y ya no se encuentra disponible,</td>
            	</tr>
	            <tr>
    	            <td align="center">recargue pagina de informacion de Servicio.</td>
        	    </tr>
            	<tr height="25px">
	            </tr>
    	    </table>
        
    </fieldset> 
    <fieldset class="fieldset_det2"><legend>Opciones</legend>
      <div align="center"><input type="button" value="               Volver               " onClick="window.location.href='<? echo "sscc.php"; ?>'" ></div>
</fieldset>

<? } ?>
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
