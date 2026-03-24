<? if(!isset($_SESSION)) 
	session_start(); 
if( $_SESSION['MM_Username'] == null ) {
	$GoTo = "../../cma/renovarSession.php?urlOrigen=../gestioncamas/superNumeraria/camaSuperNum.php";
	header(sprintf("Location: %s", $GoTo));
}

header("Refresh: 60; URL='camaSuperNum.php'"); 
//date_default_timezone_set('America/Santiago');

require_once('../../acceso/cargarpermiso.php');
include "../funciones/funciones.php";	
mysql_connect ('10.6.21.29','usuario','hospital');
mysql_select_db('camas') or die('Cannot select database');
mysql_query("SET NAMES 'utf8'");

$sqlSalasSN = mysql_query("SELECT DISTINCT
				camassn.salaCamaSN
				FROM camassn
				WHERE 
				camassn.tipoCamaSN = 'P'
				AND camassn.estadoCamaSN = 2
				ORDER BY
				camassn.salaCamaSN ASC") or die("ERROR AL SELECCIONAR SALA ". mysql_error());
				
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="css/estilo.css" />
<link type="text/css" rel="stylesheet" href="../ingresos/css/estilo.css" />

<title>Listado Pacientes</title>
<script language="JavaScript" src="../tablas/tigra_tables.js"></script>
<script language="JavaScript" src="../tablas/tigra_hints.js"></script>
</head>
<body>
<table width="750px" border="0" align="center" cellpadding="4" cellspacing="4">
<tr>
   <td><fieldset class="fondoF"><legend class="estilo1">Datos Pacientes</legend>	
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
        	<tr valign="top">
            	<td valign="top">
                	<!--COLUMNA DE LA TABLA DATOS PACIENTE-->
                	
                    <table width="50%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                        
                            <? 
							$i_detalleCama = 0;
							while($arraySalasSN = mysql_fetch_array($sqlSalasSN)){
								$codSalaSN = $arraySalasSN['salaCamaSN'];
								?>
                            <tr valign="top">
                            <td>
                            <!--TABLA QUE REPRESENTAN LAS SALAS-->
                            <fieldset>
                            <legend ><?= $codSalaSN;?> PISO</legend>
                            <table align="center" >
                            	<tr valign="top" >
                            	<? 
								if($codSalaSN == 'CMI 3'){
								$sqlCamasSN ="SELECT *
												FROM
												camassn
												LEFT JOIN listasn ON camassn.codCamaSN = listasn.idCamaSN
												WHERE
												camassn.salaCamaSN = '$codSalaSN'
												AND camassn.tipoCamaSN = 'P'
												AND  camassn.estadoCamaSN = 2
												ORDER BY nomCamaSN ASC";
												
								$queryCamasSN = mysql_query($sqlCamasSN) or die("ERROR AL SELECCIONAR CAMAS ". mysql_error());
								}
								$cont = 1;
								while($arrayCamas = mysql_fetch_array($queryCamasSN)){
									$codCama = $arrayCamas['codCamaSN'];
									$idSN = $arrayCamas['idListaSN'];
									$idPensio = $arrayCamas['idPensio'];
									$idPAc = $arrayCamas['idPacienteSN'];
									$catRiesgo = $arrayCamas['categorizaRiesgoSN'];
									$catDep = $arrayCamas['categorizaDepSN'];
									$categorizacion = $catRiesgo.$catDep;
									
									$hoy = date("Y-m-d").' '.date("H:i:s");

									$ingreso = $arrayCamas['fechaIngresoSN'].' '.$arrayCamas['horaIngresoSN'];
									$ingreso_hosp = $arrayCamas['hospitalizadoSN'];
									$egreso = $hoy;
									
									$tiempo_espera = intval((strtotime($egreso)-strtotime($ingreso))/3600);
									
									$dias_espera = ($tiempo_espera / 24);
									$decimales = explode(".",$dias_espera);
									$dias_espera = $decimales[0];
									$horas_espera = ($tiempo_espera - ($dias_espera*24));
									
									$tiempo_espera_hosp = intval((strtotime($egreso)-strtotime($ingreso_hosp))/3600);
							
									$dias_espera_hosp = ($tiempo_espera_hosp / 24);
									$decimales = explode(".",$dias_espera_hosp);
									$dias_espera_hosp = $decimales[0];
									$horas_espera_hosp = ($tiempo_espera_hosp - ($dias_espera_hosp*24));
									
									//SE DEFINE QUE ENLACE E IMAGEN MOSTRAR EN LA CAMA
									if($arrayCamas['idListaSN']){
										if($arrayCamas['estadoctacteSN'] == 4){
											$class = " class ='td_sscc_dealta' ";
											}else{
												$class = " class='td_sscc'";
												}
										//llamar funcion que calcule el tiempo
										$time = 0;
										//SE LLENA EL ARRAY CON LOS DATOS DE PACIENTES EN HINTS 
										
										$infPaciente = "<b>- Paciente</b> : ".$arrayCamas['nomPacienteSN']."<br/><b>- Ingreso Hospital</b> : ".cambiarFormatoFecha2(substr(($arrayCamas['hospitalizadoSN']),0,10))." - ".substr($arrayCamas['hospitalizadoSN'],11,15)." Hrs."."<br/><b>- Dias Hospitalizado </b> : ".$dias_espera_hosp." dias y ".$horas_espera_hosp." horas <br /><b>- Ingreso al Servicio</b> : ".cambiarFormatoFecha2($arrayCamas['fechaIngresoSN'])." - ".$arrayCamas['horaIngresoSN']." Hrs."."<br/><b>- Dias en el Servicio </b> : ".$dias_espera." dias y ".$horas_espera." horas <br /><b>- Médico</b> : ".$arrayCamas['nomMedicoSN']."<br/><b>- Pre Diagnóstico</b> : ".$arrayCamas['diagnostico1SN']."<br/><b>- Diagnóstico</b> : ".$arrayCamas['diagnostico2SN']."<br/><b>- Categorizacion</b> : ".$categorizacion." ( ".cambiarFormatoFecha2($arrayCamas['fechaCatSN'])." )<br /><b>- Servicio</b> : ".$arrayCamas['desde_nomServSN']."<br/>";
										
										
										switch($catRiesgo){
											
											case 'A';
											$bgImagen = "cama-a";
											break;
											
											case 'B';
											$bgImagen = "cama-b";
											break;
											
											case 'C';
											$bgImagen = "cama-c";
											break;
											
											case 'D';
											$bgImagen = "cama-d";
											break;
											
											case '';
											$bgImagen = "cama-sc";
											break;
											}
										
										if($arrayCamas['sexoPacienteSN'] == 'M'){
											$imgSex = "-h";
										}else{
											$imgSex = "-m";
											}
										if($arrayCamas['esta_fichaSN'] == 1){
											$imgFicha = "-f";
											}else{
												$imgFicha = "";
												}
										if($arrayCamas['multiresSN'] == 1){
											$class = " class='td_sscc_multires'";
											}
									$imagenFinal = $bgImagen.$imgSex.$imgFicha;									
									$enlace = "href='detalleCamaSN.php?HOSid=$idSN&PACid=$idPAc'";
									}else{
										$class = " class='td_sscc'";
										$infPaciente = "<b>- Cama ".$arrayCamas['nomCamaSN']." :</b> Vacia<br>- Haga clic para ingresar nuevo Paciente";
										$imagenFinal = "cama-vacia";
										$enlace = "href='ingresarPacienteSN.php?CAMcod=$codCama&SALcod=$arrayCamas[salaCamaSN]&CAMnom=$arrayCamas[nomCamaSN]&idPensio=$idPensio'";
									}
									//FIN DEFINICION
									if($cont < 3){
										if($cont == 1){?>
                                            <td valign="top">
                                            <table>
                                    	<? }?>
                                        <tr >
                                            <td align="center" <?= $class;?>  style="font-size:12px; font-family:Arial, Helvetica, sans-serif; cursor:pointer;"><a style="text-decoration:none; color:#000;" onmouseover="myHint.show(<? echo $i_detalleCama; ?>)" onmouseout="myHint.hide()" <?= $enlace;?>><img style="border:none;" src="../ingresos/img/<?= $imagenFinal; ?>.gif" width="45" height="45" onmouseover="" onmouseout="" /><br>C-<? echo $arrayCamas['nomCamaSN']; ?></a></td>
                                        </tr>
                                    <? 
									$cont++; 
									}else{?>
										<tr >
                                            <td align="center" <?= $class;?> style="font-size:12px; font-family:Arial, Helvetica, sans-serif; cursor:pointer;"><a style="text-decoration:none; color:#000;" onmouseover="myHint.show(<? echo $i_detalleCama; ?>)" onmouseout="myHint.hide()" <?= $enlace;?>><img style="border:none;" src="../ingresos/img/<?= $imagenFinal; ?>.gif" width="45" height="45" onmouseover="" onmouseout ="" /><br>C-<? echo $arrayCamas['nomCamaSN']; ?></a></td>
                                        </tr>
                                        </table>
                                        </td>
									<? $cont = 1;
									}
								//CREA ARREGLO CON LAS VARIABLES DE LOS HINTS
							   	$infPaciente = str_replace("\"", " ", $infPaciente);
								$infPaciente = str_replace("'", " ", $infPaciente);
								$arreglo_camas[$i_detalleCama] = $infPaciente;
								$i_detalleCama++;
                               }//FIN WHILE
							   if($cont==3) { echo "</table></td>";}
							   if($cont==2) { echo "<tr><td>&nbsp;</td></tr></table></td>"; }
							   ?>
                                </tr>
                            </table>
                            </fieldset>
                            <!--FIN TABLA QUE REPRESENTAN LAS SALAS-->
                            </td>
                            </tr>
                            <? }?>  
                        
                    </table>
                    
                     
                    <!--FIN COLUMNA DE LA TABLA DATOS PACIENTE-->
                </td>
            </tr>
		</table>
</fieldset>
</td>
</tr>
</table>    


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