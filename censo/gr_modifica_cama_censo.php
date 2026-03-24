<?php 
//usar la funcion header habiendo mandado código al navegador
ob_start(); 
//end para header

if (!isset($_SESSION)) {
	session_start();
}
$dbhost = $_SESSION['BD_SERVER'];
if ( $_SESSION['MM_Username'] == null ) {
	$GoTo = "../../acceso/index.php";
	header(sprintf("Location: %s", $GoTo));
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Gestion de Camas Hospital Dr. Juan Noé C.</title>
<link type="text/css" rel="stylesheet" href="css/estilo.css" />
</head>
<body background="../../estandar/img/fdo.jpg" topmargin="5" style="font-family:Arial, Helvetica, sans-serif; font-size:14px">


	<table width="800px" align="center" border="2" bordercolor="#000000" bordercolorlight="#FFFFFF" bordercolordark="#666666" cellspacing="0" cellpadding="0">
    	<th height="20px" align="left" bgcolor="#006699" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; color:#FFF">&nbsp; Mantención Censo Diario.</th>

        <tr>
            <td background="img/fondo.jpg">


<?
include "../funciones/funciones.php";

$fecha_hospitalizacion = cambiarFormatoFecha2($fecha_ingreso);


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
		case 50:
			$d_tipo_1="URGENCIA";
			break;

	}


	mysql_connect ($dbhost,'gestioncamas','123gestioncamas');
	mysql_select_db('camas') or die('Cannot select database');

	$resultado = mysql_query( "UPDATE camas SET
	tipo_1          = $tipo_1,
	d_tipo_1        = '$d_tipo_1',
	tipo_2          = $tipo_2,
	d_tipo_2        = '$d_tipo_2',
	cta_cte         = $cta_cte,
	cod_procedencia = $cod_procedencia, 
	procedencia     = '$procedencia',
	fecha_ingreso   = '$fecha_hospitalizacion'
	WHERE id = $id_cama "  );
	echo "<form>";

	echo "<table width='70%' align='center' border='0' cellspacing='0' cellpadding='0'>";
	echo "<tr align='center'>";
	echo "<td>";
	echo "<fieldset style='padding:20px'>";

	if ($resultado)
		{
		$GoTo = "mantencion_censo.php".$pag_ant ;
		header(sprintf("Location: %s", $GoTo));
		}
	else
		{
		echo "El Cambio de Datos de Hospitalización Falló, Intentelo Nuevamente";
		?>
        <input type="Button" value=    "       Volver       " onclick="window.location.href='mantencion_censo.php<? echo $pag_ant ?>'; parent.GB_hide(); " />
		<?
		}

	echo "</fieldset>";
	echo "</td>";
	echo "</tr>";
	echo "</table>";

?>

</form>

			</td>
        </tr>
	    
	</table>


</body>
</html>


<?php
//usar la funcion header habiendo mandado código al navegador
ob_end_flush();
//end header
?>
