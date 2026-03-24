<?php

if (!isset($_SESSION)) {
  session_start();
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
    	<th height="20px" align="left" bgcolor="#006699" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; color:#FFF">&nbsp; Modificar Informaci&oacute;n de Paciente Hospitalizado.</th>

        <tr>
            <td background="img/fondo.jpg">
            	<fieldset>

<div class="titulo" align="center">

<?
include "../funciones/funciones.php";

	if ($ficha_paciente == '') { $ficha_paciente = 0; }
	if ($rut_paciente == '') { $rut_paciente = 0; }
	if ($edad_paciente < 0) {$edad_paciente = 0;}


	mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');
	mysql_select_db('camas') or die('Cannot select database');

	$resultado = mysql_query( "UPDATE altaprecoz SET 	
	id_paciente     = $id_paciente, 
	rut_paciente    = $rut_paciente, 
	ficha_paciente  = $ficha_paciente, 
	nom_paciente    = '$nom_paciente', 
	sexo_paciente   = '$sexo_paciente', 
	edad_paciente   = $edad_paciente, 
	cod_prevision   = $cod_prevision, 
	prevision       = '$prevision', 
	direc_paciente  = '$direc_paciente', 
	cod_comuna      = $cod_comuna, 
	comuna          = '$comuna', 
	fono1_paciente  = '$fono1_paciente', 
	fono2_paciente  = '$fono2_paciente', 
	fono3_paciente  = '$fono3_paciente'
	WHERE id = $id_cama "  );



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
		echo "Cambio de Paciente se Realiz� con Exito </br></br>";
		?>
        <input type="Button" value=    "       OK       " onclick="window.location.href='<? echo"altapaciente.php?id_cama=$id_cama"; ?>'; parent.GB_hide(); " />

		<?
		}
	else
		{
		echo "El Cambio de Paciente Fall�, Intentelo Nuevamente";
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