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

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Gestion de Camas Hospital Dr. Juan No&eacute C.</title>
<link type="text/css" rel="stylesheet" href="../gestion/css/estilo.css" />

	<script language="JavaScript" src="../tablas/tigra_hints.js"></script>
	<style>
		.hintsClass {
			font-family: tahoma, verdana, arial;
			font-size: 12px;
			background-color: #f0f0f0;
			color: #000000;
			border: 1px solid #808080;
			padding: 5px;
		}
	</style>

</head>
<body background="../../estandar/img/fdo.jpg" topmargin="5" style="font-family:Arial, Helvetica, sans-serif; font-size:12px">
	<table width="850px" align="center" border="2" bordercolor="#000000" bordercolorlight="#FFFFFF" bordercolordark="#666666" cellspacing="0" cellpadding="0">
    	<th height="20px" align="left" bgcolor="#006699" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; color:#FFF">&nbsp; Asignacion de Moviles.</th>

        <tr>
            <td background="img/fondo.jpg">
            	<fieldset>


<div class="titulo" align="center">

<?
include "../funciones/funciones.php";

$fecha_hoy = date('Y-m-d');

$servicio = "106";
$desc_servicio = "HOSP. DOMICILIARIA";

$queorden = "movil_m";

if ($ficha_paciente == '') { $ficha_paciente = 0; }

$fecha_hospitalizacion = cambiarFormatoFecha2($fecha_ingreso);

mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');

$sql = "DELETE FROM at_altaprecoz where fecha = '".$fecha_hoy."'";


mysql_select_db('camas') or die('Cannot select database');
$query = mysql_query( $sql ) or die(mysql_error());


mysql_select_db('camas') or die('Cannot select database');

$query = mysql_query("SELECT * FROM altaprecoz") or die(mysql_error());


while($altaprecoz = mysql_fetch_array($query))
{
	$id_cama = $altaprecoz['id'];
	$id_paciente = $altaprecoz['id_paciente'];
	$manana = $altaprecoz['movil_m'];
	$tarde  = $altaprecoz['movil_t'];
	$noche  = $altaprecoz['movil_n'];
	$madrugada  = $altaprecoz['movil_ma'];

	$sql = "INSERT INTO at_altaprecoz ( 
	fecha,
	id_paciente,
	movil_m,
	movil_t,
	movil_n,
	movil_ma )
	VALUES (
	'$fecha_hoy',
	$id_paciente,
	$manana,
	$tarde,
	$noche,
	$madrugada )";
	
	mysql_select_db('camas') or die('Cannot select database');
	$resultado_1 = mysql_query( $sql ) or die(mysql_error());



}






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
			
		echo "La Asignacion de Moviles se Realiz� con Exito </br></br>";
		?>
		<input type="button" class="boton" onclick="window.location.href='aprecoz.php'" value="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Volver &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;">		<?
		}
	else
		{
		echo "El Ingreso de Hospitalizaci�n Fall�, Intentelo Nuevamente";
		?>
		<input type="button" class="boton" onclick="window.location.href='aprecoz.php'" value="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Volver &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;">		<?
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

<SCRIPT LANGUAGE="javascript"> 
//alert('ya!'); 
if(!document.layers) 
midiv.style.visibility='hidden'; 
else 
document.midiv.visibility='hide'; 
</SCRIPT>


<script language="JavaScript">
// configuration variable for the hint object, these setting will be shared among all hints created by this object
var HINTS_CFG = {
	'wise'       : true, // don't go off screen, don't overlap the object in the document
	'margin'     : 10, // minimum allowed distance between the hint and the window edge (negative values accepted)
	'gap'        : 20, // minimum allowed distance between the hint and the origin (negative values accepted)
	'align'      : 'bctl', // align of the hint and the origin (by first letters origin's top|middle|bottom left|center|right to hint's top|middle|bottom left|center|right)
	'css'        : 'hintsClass', // a style class name for all hints, applied to DIV element (see style section in the header of the document)
	'show_delay' : 0, // a delay between initiating event (mouseover for example) and hint appearing
	'hide_delay' : 200, // a delay between closing event (mouseout for example) and hint disappearing
	'follow'     : true, // hint follows the mouse as it moves
	'z-index'    : 100, // a z-index for all hint layers
	'IEfix'      : false, // fix IE problem with windowed controls visible through hints (activate if select boxes are visible through the hints)
	'IEtrans'    : ['blendTrans(DURATION=.3)', null], // [show transition, hide transition] - nice transition effects, only work in IE5+
	'opacity'    : 95 // opacity of the hint in %%
};
// text/HTML of the hints

var HINTS_ITEMS = [ <? echo $mens_todos; ?> ];

var myHint = new THints (HINTS_ITEMS, HINTS_CFG);
</script>



</body>
</html>


<?php
//usar la funcion header habiendo mandado c�digo al navegador
ob_end_flush();
//end header
?>
