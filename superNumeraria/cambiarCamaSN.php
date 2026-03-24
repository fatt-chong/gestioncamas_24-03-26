<? if(!isset($_SESSION)) 
	session_start(); 
if( $_SESSION['MM_Username'] == null ) {
	$GoTo = "../../cma/renovarSession.php?urlOrigen=camaSuperNum.php";
	header(sprintf("Location: %s", $GoTo));
}
//date_default_timezone_set('America/Santiago');

mysql_connect ('10.6.21.29','usuario','hospital');
mysql_select_db('camas') or die('Cannot select database');
mysql_query("SET NAMES 'utf8'");

$sqlServicios = mysql_query("SELECT DISTINCT
							camas.camas.cod_servicio,
							camas.camas.servicio
							FROM
							camas.camas
							INNER JOIN acceso.servicio ON camas.camas.cod_servicio = acceso.servicio.id
							WHERE
							(camas.camas.estado = 1 OR
							camas.camas.estado = 3) AND
							acceso.servicio.camaSN <> 'N' ") or die ("ERROR AL SELECCIONAR INFORMACION DE TRANSITO PACIENTE ".mysql_error());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="css/estilo.css" />
<script language="JavaScript" src="../tablas/tigra_tables.js"></script>
<script language="JavaScript" src="../tablas/tigra_hints.js"></script>
<title>Elegir Cama</title>
</head>

<body>
<form name="cambiarCama" id="cambiarCama">
<input type="hidden" name="idCamaSN" id="idCamaSN" value="<? echo $id_cama; ?>" />
	<fieldset class="fondoF"><legend class="estilo1">Seleccionar Cama</legend>
    <table  border="0" align="center" cellpadding="4" cellspacing="2">
    	
        <tr>
        	<td>
            	<table width="100%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr valign="top">
                    <td valign="top">
                	
                	<fieldset>
                    <legend class="titulos_menu">Camas Disponibles</legend>
                    <table width="50%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr valign="top">
                            <? 
							$i_detalleCama = 0;
							while($arrayServicios = mysql_fetch_array($sqlServicios)){
								$codServicio = $arrayServicios['cod_servicio'];
								if($codServicio == 4){
									$nomServicio = "Cirug.Aisla.";
									}else{
									$nomServicio = $arrayServicios['servicio'];
									}
								?>
                            <td>
                            <!--TABLA QUE REPRESENTAN LAS SALAS-->
                            <fieldset>
                            <legend class="tituloServicio"><? echo $nomServicio; ?></legend>
                            <table align="center">
                            	<tr valign="top" >
                            	<? $sqlCamasDisp = "SELECT *
												  FROM camas
												  WHERE cod_servicio = $codServicio 
												  AND (estado = 1 OR
												  estado = 3)"; 
												
								$queryCamasDisp = mysql_query($sqlCamasDisp) or die("ERROR AL SELECCIONAR CAMAS ". mysql_error());
								
								$cont = 1;
								while($arrayCamasDisp = mysql_fetch_array($queryCamasDisp)){
									$que_sala = $arrayCamasDisp['sala'];
									$que_cama = $arrayCamasDisp['cama'];
									$que_idcama = $arrayCamasDisp['id'];
									$que_estado = $arrayCamasDisp['estado'];
									$que_causa = $arrayCamasDisp['diagnostico1'];
									$que_codServ = $arrayCamasDisp['cod_servicio'];
									$que_nomServ = $arrayCamasDisp['servicio'];
									$que_fechaBloq = $arrayCamasDisp['fecha_ingreso'];
								
								
								//SE LLENA EL ARRAY CON LOS DATOS DE PACIENTES EN HINTS 
								$infPaciente = "<b>- Sala</b> : ".$que_sala."<br/><b>- Cama</b> : ".$que_cama."<br/>";
								$enlace = "href='sql_cambiacamaSN.php?idCamaSN=$id_cama&idPaciente=$idPaciente&que_sala=$que_sala&que_cama=$que_cama&que_idcama=$que_idcama&que_causa=$que_causa&que_estado=$que_estado&que_codServ=$que_codServ&que_nomServ=$que_nomServ&que_fechaBloq=$que_fechaBloq'";

								
								//FIN DEFINICION
								if($cont < 3){ ?>
								<td valign="top" height="40" width="40" align="center" class='td_sscc' style="font-size:12px; font-family:Arial, Helvetica, sans-serif; cursor:pointer;">
                                <a style="text-decoration:none; color:#000;" onmouseover="myHint.show(<? echo $i_detalleCama; ?>)" onmouseout="myHint.hide()" <?= $enlace;?>><img style="border:none;" src="../ingresos/img/cama-vacia.gif" width="30" height="30" onmouseover="" onmouseout ="" /><br>C-<? echo $arrayCamasDisp['cama']; ?></a>
                                </td>
                                <? $cont++; 
								}else{?>
                                    <td valign="top" height="40" width="40" align="center" class='td_sscc' style="font-size:12px; font-family:Arial, Helvetica, sans-serif; cursor:pointer;">
                                    <a style="text-decoration:none; color:#000;" onmouseover="myHint.show(<? echo $i_detalleCama; ?>)" onmouseout="myHint.hide()" <?= $enlace;?>><img style="border:none;" src="../ingresos/img/cama-vacia.gif" width="30" height="30" onmouseover="" onmouseout ="" /><br>C-<? echo $arrayCamasDisp['cama']; ?></a>
                                    </td>
                                    
                                    <?	echo "</tr>";
                                        echo "<tr>";
                                        $cont = 1;
									}
								//CREA ARREGLO CON LAS VARIABLES DE LOS HINTS
							   	$infPaciente = str_replace("\"", " ", $infPaciente);
								$infPaciente = str_replace("'", " ", $infPaciente);
								$arreglo_camas[$i_detalleCama] = $infPaciente;
								$i_detalleCama++;
                               }//FIN WHILE
							   ?>
                               
                            </table>
                            </fieldset>
                            <!--FIN TABLA QUE REPRESENTAN LAS SALAS-->
                            </td>
                            <? }?>  
                        </tr>
                    </table>
                    </fieldset>
                    <!--FIN COLUMNA DE LA TABLA DATOS PACIENTE-->
                </td>
            </tr>
            </table>
            </td>
        </tr>
        <tr>
        	<td>
            
            <table width="100%">
                <tr>
                    <td align="right"><input type="button" class="buttonGeneral" name="atras" id="atras" value="   Atras   " onclick="javascript: document.location.href='camaSuperNum.php'" /></td>
                </tr>
            </table>
            
            </td>
        </tr>
   
    </table>
    </fieldset>
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
</script>

</body>
</html>