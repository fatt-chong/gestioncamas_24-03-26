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
    	<th height="20px" align="left" bgcolor="#006699" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; color:#FFF">&nbsp; Informaci&oacute;n de Paciente Hospitalizado.</th>

        <tr>
            <td background="img/fondo.jpg">
            	<fieldset>

<div class="titulo" align="center">

<?
include "../funciones/funciones.php";
include "../funciones/funcionesNEW.php";


$fecha_bloqueo = cambiarFormatoFecha2($fecha_ingreso);
$fecha_desbloqueo = $fecha_egreso;

$fecha_ingreso = cambiarFormatoFecha($fecha_bloqueo);
$fecha_egreso = cambiarFormatoFecha($fecha_desbloqueo);

$id_cama = $_SESSION['MM_pro_id_cama'];
$cama = $_SESSION['MM_pro_cama'];
$sala = $_SESSION['MM_pro_sala'];
$servicio = $_SESSION['MM_pro_servicio'];
$desc_servicio = $_SESSION['MM_pro_desc_servicio'];
$estado = $_SESSION['MM_pro_estado'];


echo "<table width='70%' align='center' border='0' cellspacing='0' cellpadding='0'>";
echo "<tr align='left'>";
echo "<td>";
echo "<fieldset style='padding:30px'>";
echo "<legend> Informacion de Camma Habilitada </legend></br>";

echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>";

echo "<tr>";
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
echo "<td>Fecha Bloqueo</td>";
echo "<td>:".$fecha_bloqueo."</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Fecha Desbloqueo</td>";
echo "<td>:".$fecha_desbloqueo."</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Motivo</td>";
echo "<td>:".$diagnostico1."</td>";
echo "</tr>";

echo "<tr>";
echo "<td>Comentario</td>";
echo "<td>:".$diagnostico2."</td>";
echo "</tr>";

echo "</table>";

echo "</fieldset>";
echo "</td>";
echo "</tr>";
echo "</table>";

mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');
mysql_select_db('camas') or die('Cannot select database');

$resultado1 = mysql_query( "UPDATE camas SET 	
diagnostico1    = '', 
estado          = 1, 
fecha_ingreso   = ''
WHERE id = $id_cama "  ) or die(mysql_error());

$tipo_traslado = 3;

mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');
mysql_select_db('camas') or die('Cannot select database');

$llama_tipo1 = cual_tipo($servicio);
$array_tipo1 = explode(" ", $llama_tipo1);
$cod_tipo_1 = $array_tipo1[0];
$desc_tipo_1 = $array_tipo1[1];

$resultado2 = mysql_query( "INSERT INTO hospitalizaciones
( tipo_traslado, cod_servicio, servicio, sala, tipo_1, d_tipo_1, cama, diagnostico1, diagnostico2, nom_paciente, fecha_ingreso, fecha_egreso )
VALUES
( 3, $servicio, '$desc_servicio', '$sala',$cod_tipo_1, '$desc_tipo_1', $cama, '$diagnostico1', '$diagnostico2', 'CAMA BLOQUEADA', '$fecha_ingreso', '$fecha_egreso' ) ") or die(mysql_error());

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
			echo "La Habilitacion de Cama se Realiz� con Exito </br></br>";
			?>
			<input type="button" value="               Volver               " onClick="top.mainFrame.location.href='<? echo"sscc.php"; ?>';
			parent.parent.GB_hide(); " >
			<?
		}
	else
		{
			echo "La Habilitaci�n Se realiz�, Pero no se registro historico, consulte que la informacion est� registrada";
			?>
			<input type="button" value=" Volver " onclick="window.location.href='<? echo"desbloqueocama.php?id_cama=$id_cama&cama=$cama&sala=$sala&servicio=$servicio&desc_servicio=$desc_servicio&estado=$estado"; ?>'; parent.GB_hide();" />
			<?
		}

	}
else
	{
	echo "La Habilitaci�n Fall�, Intentelo Nuevamente";
	?>
	<input type="button" value=" Volver " onclick="window.location.href='<? echo"desbloqueocama.php?id_cama=$id_cama&cama=$cama&sala=$sala&servicio=$servicio&desc_servicio=$desc_servicio&estado=$estado"; ?>'; parent.GB_hide();" />
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
