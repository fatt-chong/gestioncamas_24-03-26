<?php

if (!isset($_SESSION)) {
  session_start();
}

include "../funciones/funciones.php";

$fecha_bloqueo = cambiarFormatoFecha2($fecha_ingreso);

$id_cama = $_SESSION['MM_pro_id_cama'];
$cama = $_SESSION['MM_pro_cama'];
$sala = $_SESSION['MM_pro_sala'];
$servicio = $_SESSION['MM_pro_servicio'];
$desc_servicio = $_SESSION['MM_pro_desc_servicio'];
$estado = $_SESSION['MM_pro_estado'];



	mysql_connect ('10.6.21.29','usuario','hospital');
	mysql_select_db('camas') or die('Cannot select database');
	
	$sqlVerifica = "SELECT * FROM camas where id = '".$id_cama."'";
	$queryVerifica = mysql_query($sqlVerifica) or die(mysql_error());
	$arrayVerifica = mysql_fetch_array($queryVerifica);
	
	$estadoCama = $arrayVerifica['estado'];

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
    	<th height="20px" align="left" bgcolor="#006699" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; color:#FFF">&nbsp; Bloqueo de Cama.</th>

        <tr>
            <td background="img/fondo.jpg">
            	<fieldset>
				<? if($estadoCama != 5){ ?>

			<div class="titulo" align="center">

<?


	$resultado = mysql_query( "UPDATE camas SET 	
	cod_procedencia = 0, 
	procedencia     = '',
	cod_medico      = 0,
	medico          = '',
	cod_auge        = 0, 
	auge            = '', 
	acctransito     = 0, 
	diagnostico1    = '$diagnostico1',
	diagnostico2    = '',
	id_paciente     = 0, 
	rut_paciente    = 0, 
	ficha_paciente  = 0, 
	esta_ficha		= 0, 
	nom_paciente    = '', 
	edad_paciente   = 0, 
	cod_prevision   = 0, 
	prevision       = '', 
	direc_paciente  = '', 
	cod_comuna      = 0, 
	comuna          = '', 
	fono1_paciente  = '', 
	fono2_paciente  = '', 
	fono3_paciente  = '', 
	estado          = 3, 
	fecha_ingreso   = '$fecha_bloqueo'
	WHERE id = $id_cama "  ) or die(mysql_error());
?>

<table width="70%" align="center" border="0" cellspacing="0" cellpadding="0">
<tr align="left">
<td>
<fieldset>
<legend>Informacion de Cama</legend>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td width="20px" height="20px"></td><td width="160px"></td></tr>
<tr><td></td><td>Cama N�mero</td><td>: <? echo $cama ?> </td></tr>
<tr><td></td><td>Sala</td><td>: <? echo $sala ?> </td></tr>
<tr><td></td><td>Servicio Cl�nico</td><td>: <? echo $desc_servicio ?> </td></tr>
<tr><td></td><td>Fecha de Bloqueo</td><td>: <? echo $fecha_ingreso ?> </td></tr>
<tr><td></td><td>Motivo de Bloqueo</td><td>: <? echo $diagnostico1 ?> </td></tr>
<tr><td width="20px" height="20px"></td><td width="160px"></td></tr>

</table>

</fieldset>
</td>
</tr>
</table>



<?










	echo "<form>";

	echo "</br>";
	echo "<table width='70%' align='center' border='0' cellspacing='0' cellpadding='0'>";
	echo "<tr align='center'>";
	echo "<td>";
	echo "<fieldset style='padding:30px'>";

	if ($resultado)
		{
		echo "El Bloqueo se Realiz� con Exito </br></br>";
		?>
		<input type="button" value="               Volver               " onClick="top.mainFrame.location.href='<? echo"sscc.php"; ?>';
        parent.parent.GB_hide(); " >
		<?
		}
	else
		{
		echo "El Boqueo Fall�, Intentelo Nuevamente";
		?>
		<input type="button" value=" Volver " onclick="window.location.href='<? echo"ingresopaciente.php?id_cama=$id_cama&cama=$cama&sala=$sala&servicio=$servicio&desc_servicio=$desc_servicio&estado=$estado"; ?>'; parent.GB_hide();" />
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
				<? } else {?>
                <fieldset class="fieldset_det2"><legend>Error</legend>
                <table style="font-size:18px; color: #F00;" align="center" border="0" cellspacing="0" cellpadding="0">
                        <tr height="25px">
                        </tr>
                        <tr>
                            <td align="center">La cama ha cambiado de estado,</td>
                        </tr>
                        <tr>
                            <td align="center"> y ya no se encuentra libre,</td>
                        </tr>
                        <tr>
                            <td align="center">recargue pagina de informacion de Servicio.</td>
                        </tr>
                        <tr height="25px">
                        </tr>
                    </table>
                
            </fieldset> 
            <fieldset class="fieldset_det2"><legend>Opciones</legend>
              <div align="center">
              <input type="button" value="               Volver               " onClick="window.location.href='<? echo"sscc.php"; ?>'" >
              </div>
            </fieldset>
        <? } ?>

                </fieldset>
            </td>
       </tr>
    </table>



</body>
</html>