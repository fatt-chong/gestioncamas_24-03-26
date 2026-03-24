<? if(!isset($_SESSION)) 
	session_start(); 
if( $_SESSION['MM_Username'] == null ) {
	$GoTo = "../../cma/renovarSession.php?urlOrigen=../../rau/listaEspera_rau/lista_rau.php";
	header(sprintf("Location: %s", $GoTo));
}
//date_default_timezone_set('America/Santiago');
header("Refresh: 300; URL='lista_rau.php'"); 
require_once('../../acceso/cargarpermiso.php');

$permisos = $_SESSION['permiso']; 


include ('funciones/funciones.php');
mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');
mysql_select_db('rau') or die('Cannot select database');
mysql_query("SET NAMES 'utf8'");


//SELECCIONA LAS DIFERENTES SALAS DE URGENCIAS

$sqlSala = mysql_query("SELECT DISTINCT
						camas_urgencia.sala
						FROM
						camas_urgencia
						ORDER BY id_camaUrg") or die ("ERROR AL SELECCIONAR SALAS ".mysql_error());
//SELECCIONA A LOS PACIENTES QUE SE ENCUENTRAN EN ESPERA

$sqlEspera = mysql_query("SELECT *
						FROM lista_salaespera WHERE tipo_atencion = 'A' or tipo_atencion = 'P' ORDER BY cat_EspRau ") or die ("ERROR AL SELECCIONAR LA LISTA DE ESPERA ".mysql_error());
								
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="css/estiloMapa.css" />

<script src="../../estandar/src/calendario/src/js/jscal2.js"></script>
<script src="../../estandar/src/calendario/src/js/lang/es.js"></script>
<link rel="stylesheet" type="text/css" href="../../estandar/src/calendario/src/css/jscal2.css"/>
<link rel="stylesheet" type="text/css" href="../../estandar/src/calendario/src/css/border-radius.css"/>
<link rel="stylesheet" type="text/css" href="../../estandar/src/calendario/src/css/steel/steel.css"/>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />

<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>

<title>Listado Pacientes</title>
<script language="JavaScript" src="tablas/tigra_tables.js"></script>
<script language="JavaScript" src="tablas/tigra_hints.js"></script>

</head>

<script>

window.onload=function(){
	setInterval('disableCombos()',10);
	setInterval('disableBoton2()',10);
}
</script>

<body>
<form name="urgencia" id="urgencia" method="get" action="lista_rau.php">

<table align="center" border="2" bordercolor="#000000" bordercolorlight="#FFFFFF" bordercolordark="#666666" cellspacing="0" cellpadding="0" background="img/fondo.jpg">
  <th height="20px" align="left" bgcolor="#006699" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; color:#FFF">
  	<table width="1024">
    <tr>
        <td width="797" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; color:#FFF";><strong>&nbsp;Mapa de Piso Unidad de Urgencias.</strong></td>
        <td width="24" align="right"><a href="lista_rau.php" title="Mapa de Piso Unidad de Urgencia" ><img src="img/i_rau.gif" width="25" height="25" /></a></td>
        <td width="24" align="right"><a href="altaPrecoz.php" title="Hospitalización Domiciliaria" ><img src="img/i_aprecoz.gif" width="25" height="25" /></a></td>
    	<td width="24" align="right"><a href="../../pabellon/sscc.php" title="Mapa Pabellon" ><img src="img/i_pabellon.gif" width="25" height="25" /></a></td>
    	<td width="24" align="right"><a href="ListadoPacientes.php" title="Cirugia Mayor Ambulatoria" ><img src="img/i_cma.gif" width="25" height="25" /></a></td>
        
    </tr>
    </table>
   </th>
	
    <tr>
    	<td width="209" valign="top">
		<? include('emergencia_adulto.php'); ?>    
        </td>
	</tr>
             
</table>
</form>
<? if (count($arreglo_camas) > 0 ) {
	$detalleCama = "'".implode("','",$arreglo_camas)."'";
}?>
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

var HINTS_ITEMS = [ <? echo $detalleCama; ?> ];

var myHint = new THints (HINTS_ITEMS, HINTS_CFG);

<!--
var spry_hora_ingreso = new Spry.Widget.ValidationTextField("spry_hora_ingreso", "time", {validateOn:["change"], useCharacterMasking:true});
var spry_hora_cat = new Spry.Widget.ValidationTextField("spry_hora_cat", "time", {validateOn:["change"], useCharacterMasking:true});
var spry_hora_ind = new Spry.Widget.ValidationTextField("spry_hora_ind", "time", {validateOn:["change"], useCharacterMasking:true});

//-->

</script>
</body>
</html>