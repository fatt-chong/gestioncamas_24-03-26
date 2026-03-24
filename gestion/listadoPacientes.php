<? if(!isset($_SESSION)) 
	session_start(); 
if( $_SESSION['MM_Username'] == null ) {
	$GoTo = "renovarSession.php?urlOrigen=listadoPacientes.php";
	header(sprintf("Location: %s", $GoTo));
}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="css/estilocma.css" />
<link type="text/css" rel="stylesheet" href="css/estilo.css" />
<link type="text/css" rel="stylesheet" href="css/estiloMapa.css" />
<title>Listado Pacientes</title>
<script language="JavaScript" src="tablas/tigra_hints.js"></script>
</head>



<? 
require_once("include/funciones/funciones.php");
require_once("clases/Conectar.inc");
$bd = new Conectar; $link = $bd->db_connect(); 
$bd->db_select("cma",$link);
require_once("clases/Cama.inc");
$objCama = new Cama;
$rowSalas = $objCama->getSalas($link);
require_once("clases/Cupo.inc");
$objCupo = new Cupo;
$rowResumen = $objCupo->getResumen(10371, $link);
?>
<body>


<table align="center" border="2" bordercolor="#000000" bordercolorlight="#FFFFFF" bordercolordark="#666666" cellspacing="0" cellpadding="0" background="img/fondo.jpg">

  <th height="20px" align="left" bgcolor="#006699" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; color:#FFF">
  	<table width="1024">
    <tr>
        <td width="797">&nbsp;Cirugia Mayor Ambulatoria.</td>

        <td width="24" align="right"><a href="lista_rau.php" title="Mapa de Piso Unidad de Urgencia" ><img src="img/i_rau.gif" width="25" height="25" /></a></td>
        <td width="24" align="right"><a href="altaPrecoz.php" title="Hospitalización Domiciliaria" ><img src="img/i_aprecoz.gif" width="25" height="25" /></a></td>
    	<td width="24" align="right"><a href="../../pabellon/sscc.php" title="Mapa Pabellon" ><img src="img/i_pabellon.gif" width="25" height="25" /></a></td>
    	<td width="24" align="right"><a href="ListadoPacientes.php" title="Cirugia Mayor Ambulatoria" ><img src="img/i_cma.gif" width="25" height="25" /></a></td>
        
    </tr>
    </table>
   </th>
    <tr>
        <td>
        <table width="100%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0">
        	<tr>
            	<td>
                	<!--COLUMNA DE LA TABLA DATOS PACIENTE-->
                	<fieldset>
                    <legend class="titulos_menu">Listado de Pacientes</legend>
                    <table width="50%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                            <? 
							$i_detalleCama = 0;
							while($RSsalas = mysql_fetch_array($rowSalas)){?>
                            <td>
                            <!--TABLA QUE REPRESENTAN LAS SALAS-->
                            <fieldset>
                            <legend class="titulos_sesion"><?= $RSsalas['SALnombre'];?></legend>
                            <table align="center" border="0">
                            	<tr>
                            	<? $rowCamas = $objCama->getMapaCamas($link,$RSsalas['SALcod']);
								$cont = 1;
								while($RScamas = mysql_fetch_array($rowCamas)){
									//SE DEFINE QUE ENLACE E IMAGEN MOSTRAR EN LA CAMA
									if($RScamas['HOSid']){
										$class = " class='td_sscc'";
										$time = $objCama->calculaTiempo($RScamas['HOSingreso'],HrSistem());
										//SE LLENA EL ARRAY CON LOS DATOS DE PACIENTES EN HINTS 
										$infPaciente = "<b>- Paciente</b> : ".$RScamas['nom_pac']."<br/><b>- Ingreso al Servicio</b> : ".$RScamas['fecha_ing']." - ".$RScamas['hora_ing']." Hrs."."<br/><b>- Días en el Servicio</b> : ".$time['dias']." días, ".$time['horas']." horas y ".$time['minutos']." minutos"."<br/><b>- Médico</b> : ".$RScamas['medico']."<br/><b>- Pre Diagnóstico</b> : ".$RScamas['HOSdiagnostico1']."<br/><b>- Diagnóstico</b> : ".$RScamas['HOSdiagnostico2']."<br/><b>- Servicio</b> : CMA <br/>";
										if($RScamas['sexo'] == 'M')
											$imagen = "cama-sc-h-f";
										else
											$imagen = "cama-sc-m-f";
										if($RScamas['HOSpabellon'] == 'S')
											$imagen = "pabe-sc";
										if($RScamas['HOSmultires'] == 1)
											$class = " class='td_sscc_multires'";
										if($RScamas['HOSestado'] == 4){
											$class = " class='td_sscc_dealta'";
											$infPaciente .="<b>- Estado</b> : Alta administrativa";
										}
										$enlace = "href='detalleAtencion.php?HOSid=$RScamas[HOSid]&PACid=$RScamas[id_paciente]'";
									}else{
										$class = " class='td_sscc'";
										$infPaciente = "<b>- ".$RScamas['CAMnombre']." :</b> Vacia<br>- Haga clic para ingresar nuevo Paciente";
										$imagen = "cama-vacia";
										$enlace = "";
									}
									//FIN DEFINICION
									if($cont < 3){
										if($cont == 1){?>
                                            <td valign="top">
                                            <table border="0">
                                    	<? }?>
                                        <tr>
                                            <td height="70" width="60" align="center" <?= $class;?> style="font-size:12px; font-family:Arial, Helvetica, sans-serif; cursor:pointer;"><a style="text-decoration:none; color:#000;" onmouseover="myHint.show(<? echo $i_detalleCama; ?>)" onmouseout="myHint.hide()" <?= $enlace;?>><img style="border:none;" src="../../gestioncamas/ingresos/img/<?= $imagen;?>.gif" width="52" height="51" onmouseover="" onmouseout ="" /><br><? echo $RScamas['CAMnombre'];?></a></td>
                                        </tr>
                                    <? $cont++;
									}else{?>
										<tr>
                                            <td height="70" width="60" align="center" <?= $class;?> style="font-size:12px; font-family:Arial, Helvetica, sans-serif; cursor:pointer;"><a style="text-decoration:none; color:#000;" onmouseover="myHint.show(<? echo $i_detalleCama; ?>)" onmouseout="myHint.hide()" <?= $enlace;?>><img style="border:none;" src="../../gestioncamas/ingresos/img/<?= $imagen;?>.gif" width="52" height="51" onmouseover="" onmouseout ="" /><br><? echo $RScamas['CAMnombre'];?></a></td>
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
							   if($cont==3) echo "</table></td>";
							   if($cont==2) echo "<tr><td>ppp</td></tr></table></td>";?>
                                </tr>
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
            <tr>
                <td>
                    <fieldset>
                    <legend class="titulos_menu">Resumen</legend>
                    <table width="100%" cellspacing="5">
                        <tr>
                            <td>
                            <table width="50%" border="1" cellpadding="3" bordercolor="#999999" style="font-size:10px; font-family:Arial, Helvetica, sans-serif;">
                                <tr>
                                    <th width="54%" scope="col">Resumen de atención</th>
                                    <th width="23%" scope="col">Cantidad</th>
                                    <th width="23%" scope="col">Porcentaje</th>
                                </tr>
                                <tr>
                                    <td>Capacidad Atención</td>
                                    <td align="center"><?= $rowResumen['CANtotal'];?></td>
                                    <td align="center"><?= redondear_dos_decimal($rowResumen['PCTtotal'])."%";?></td>
                                </tr>
                                <tr>
                                    <td>Camas Ocupadas</td>
                                    <td align="center"><?= $rowResumen['CANocupado'];?></td>
                                    <td align="center"><?= redondear_dos_decimal($rowResumen['PCTocupado'])."%";?></td>
                                </tr>
                                <tr>
                                    <td>Camas  Libres</td>
                                    <td align="center"><?= $rowResumen['CANlibre'];?></td>
                                    <td align="center"><?= redondear_dos_decimal($rowResumen['PCTlibre'])."%";?></td>
                                </tr>
                            </table>
                            </td>
                        </tr>
                    </table>
                    </fieldset>
                </td>
            </tr>
		</table>
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