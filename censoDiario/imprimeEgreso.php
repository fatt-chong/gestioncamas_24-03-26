<? session_start();
//CONFIRMA QUE LA SESSION NO HAYA EXPIRADO
if ( $_SESSION['MM_Username'] == null ) {
	$GoTo = "../acceso/index.php";
	header(sprintf("Location: %s", $GoTo));
}
$correlativo = $_GET['correlativo'];
$id_paciente = $_GET['id_paciente'];
$hospitalizado = $_GET['hospitalizado'];
//INCLUYE LAS FUNCIONES PHP
require_once("include/funciones/funciones.php");
//CONEXIONES A BD
require_once("clases/Conectar.inc");
$bd = new Conectar;
$link = $bd->db_connect();
//CARGAR DATOS DEL PACIENTE
$bd->db_select("paciente",$link);
require_once("clases/Paciente.inc");
$objPaciente = new Paciente;
$rowPaciente = $objPaciente->getPaciente($link, $id_paciente);
$digito = $objPaciente->generaDigito($rowPaciente['rut']);
$fecha_nac = $objPaciente->invierteFecha($rowPaciente['fechanac']);
$edad = calculaEdad($rowPaciente['fechanac']);
//CARGA LOS DIAGNOSTICOS
$bd->db_select("camas",$link);
$rowDiagnostico = $objPaciente->getUltimoDiagnostico($link, $id_paciente, $hospitalizado);
$digito_doc = $objPaciente->generaDigito($rowDiagnostico['rut']);
//CARGA EN PANTALLA SOLO LOS MOVIMIENTOS DE HOSPITALIZACION QUE HAYAN SIDO MARCADO PARA INCLUIR EN CORRELATIVO
require_once("clases/Censo.inc");
$objCenso = new Censo;
$lista = $objCenso->cargaSoloMarcados();
//OBTIENE EL RANGO DE FECHAS DE LA HOSPITALIZACION
$rango_fechas = $objCenso->getRangoFechasCenso($link, $correlativo, $hospitalizado);
//OBTIENE INTERVENCIONES ENTRE LAS FECHAS DE HOSPITALIZACION
$bd->db_select("pabellon",$link);
$rowIntervenciones = $objPaciente->getIntervenciones($link, $id_paciente, $rango_fechas);
//OBTIENE INTERVENCIONES ENTRE LAS FECHAS DE HOSPITALIZACION
$bd->db_select("partos",$link);
$rowPartos = $objPaciente->getPartos($link, $id_paciente, $rango_fechas);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style type="text/css">
.print{
display: none;
}
@media print {
.noprint {
display: none;
}
}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>INFORME ESTADISTICO DE EGRESO HOSPITALARIO</title>
<link href="include/estilo/egreso.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table width="893" border="0" align="center" cellpadding="5">
    <tr>
        <td width="120" height="79" align="center"><img src="include/img/logo.jpg" width="105" height="95" alt="logo" /></td>
        <td width="623" align="center" class="titulos">INFORME ESTADÍSTICO DE EGRESO HOSPITALARIO</td>
        <td width="142" align="center"><img src="../../estandar/img/deis.gif" width="80" height="49" alt="logo2" /></td>
    </tr>
    <tr>
    	<td height="38" colspan="3">
            <table width="100%" border="0" cellpadding="0">
                <tr>
                    <td width="14%" height="22" class="titulocampo">EGRESO N°</td>
                    <td width="17%" class="titulocampo">N° FICHA CLÍNICA</td>
                    <td width="69%" class="titulocampo">NOMBRE ESTABLECIMIENTO</td>
                </tr>
                <tr>
                    <td class="titulocampo"><input name="correlativo" type="text" class="casilla_larga" id="correlativo" readonly="readonly" value="<? echo $correlativo; ?>" /></td>
                    <td class="titulocampo"><input name="ficha" type="text" class="casilla_larga" id="ficha" readonly="readonly" value="<? echo $rowPaciente['nroficha'];?>" /></td>
                    <td><input name="establecimiento" type="text" class="casilla_Giga" id="establecimiento" value="Hospital Regional de Arica Doctor Juan Noé Crevani" /></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <fieldset>
            <legend class="titulos_sesion">Datos identificaciÓn del paciente</legend>
            <table width="100%" border="0" bordercolor="#999999" cellpadding="5" cellspacing="0">
                <tr>
                	<td height="60">
                    	<fieldset>
                        <table width="100%" border="0" cellpadding="3">
                            <tr>
                                <td height="27" colspan="5" class="titulocampo"><table width="100%" border="0" cellpadding="0">
                                  <tr>
                                    <td width="8%" align="left">Apellido Paterno</td>
                                    <td width="19%"><input name="PACpaterno" type="text" class="casilla_ultra" id="PACpaterno" readonly="readonly" value="<? echo $rowPaciente['apellidopat'];?>" /></td>
                                    <td width="9%" align="left">Apellido Materno</td>
                                    <td width="17%"><input name="PACmatero" type="text" class="casilla_ultra" id="PACpaterno2" readonly="readonly" value="<? echo $rowPaciente['apellidomat'];?>" /></td>
                                    <td width="9%" align="left">Nombres</td>
                                    <td width="38%"><input name="PACnombres" type="text" class="casilla_Ubber" id="PACpaterno3" readonly="readonly" value="<? echo $rowPaciente['nombres'];?>" /></td>
                                  </tr>
                                </table></td>
                            </tr>
                            <tr>
                                <td width="9%" height="30" valign="middle" class="titulocampo">run</td>
                                <td width="16%" valign="middle"><input name="PACrut" type="text" class="casilla_mega" id="PACrut" readonly="readonly" value="<? echo $rowPaciente['rut'];?>" />-<input name="digito" type="text" class="casilla_chica" id="digito" readonly="readonly" value="<? echo $digito; ?>" /></td>
                                <td width="16%" valign="middle" class="titulocampo">sexo <input name="PACsexo" type="text" class="casilla_mega" id="PACsexo" readonly="readonly" value="<? if($rowPaciente['sexo'] == 'M') echo "MASCULINO"; else if($rowPaciente['sexo'] == 'F') echo "FEMENINO"; ?>" /></td>
                                <td width="29%" valign="middle" class="titulocampo">fecha de nacimiento <input name="PACnac" type="text" class="casilla_mega" id="PACnac" readonly="readonly" value="<? echo $fecha_nac;?>" /></td>
                                <td width="30%" valign="middle" class="titulocampo">edad <input name="PACedad" type="text" class="casilla_media" id="PACedad" readonly="readonly" value="<? echo $edad;?>" /></td>
                            </tr>
                        </table>
                        </fieldset>
        			</td>
    			</tr>
    			<tr>
    				<td height="20">
                    	<fieldset>
                    	<table width="100%" height="100%" border="0" cellpadding="3">
    						<tr>
    							<td height="23" class="titulocampo">previsiÓn en salud <input name="PACciudad2" type="text" class="casilla_Ubber" id="PACciudad2" readonly="readonly" value="<? echo $rowPaciente['nom_prev'];?>" /></td>
                            </tr>
                        </table>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                	<td height="20">
                    	<fieldset>
                    	<table width="100%" border="0" cellpadding="3">
                            <tr>
                                <td colspan="4" class="titulocampo">domicilio <input name="PACdireccion" type="text" class="casilla_Giga" id="PACdireccion" value="<? echo $rowPaciente['direccion'];?>"/></td>
                            </tr>
                            <tr>
                                <td width="33%" height="22" valign="middle" class="titulocampo">comuna residencia <input name="PACciudad" type="text" class="casilla_ultra" id="PACciudad" readonly="readonly" value="<? echo $rowPaciente['comuna'];?>" /></td>
                                <td width="20%" class="titulocampo">Fono 1 <input name="PACfono" type="text" class="casilla_mega" id="PACfono" readonly="readonly" value="<? echo $rowPaciente['fono1'];?>" /></td>
                                <td width="18%" class="titulocampo">fono 2
                                <input name="PACfono2" type="text" class="casilla_mega" id="PACfono2" readonly="readonly" value="<? echo $rowPaciente['fono2'];?>" /></td>
                                <td width="29%" class="titulocampo">fono 3
                                <input name="PACfono3" type="text" class="casilla_mega" id="PACfono3" readonly="readonly" value="<? echo $rowPaciente['fono3'];?>" /></td>
                            </tr>
    					</table>
                        </fieldset>
					</td>
				</tr>
			</table>
			</fieldset>
		</td>
	</tr>
    <tr>
    	<td height="95" colspan="3">
          	<fieldset>
            <legend class="titulos_sesion">Datos de la hospitalizaciÓn</legend>
            <table width="100%" height="100%" border="0" cellpadding="5">
                <tr>
                    <td>
                    	<fieldset>
                        <legend class="titulos_sesion">Traslados</legend>
                    	<table width="100%" border="1" cellpadding="0" cellspacing="0">
                            <tr style="color:#FFF">
                                <th width="4%" height="30" rowspan="2" align="center" valign="middle"><span class="titulocampo">N°</span></th>
                                <th width="19%" rowspan="2" align="center" valign="middle"><span class="titulocampo">SERVICIO ClÍnico</span></th>
                                <th height="15" colspan="2" align="center" valign="middle"><span class="titulocampo">INGRESO</span></th>
                                <th height="15" colspan="2" align="center" valign="middle"><span class="titulocampo">EGRESO</span></th>
                          </tr>
                            <tr style="color:#FFF">
                              <th width="14%" height="15" align="center" valign="middle"><span class="titulocampo">Fecha</span></th>
                                <th width="14%" height="15" align="center" valign="middle"><span class="titulocampo">Procedencia</span></th>
                                <th width="14%" height="15" align="center" valign="middle"><span class="titulocampo">Fecha</span></th>
                                <th width="14%" height="15" align="center" valign="middle"><span class="titulocampo">Destino</span></th>
                            </tr>
                            <? 	$i=1;
                                foreach($lista as $k => $v){ 
                                    $fecha_ingreso = $objPaciente->invierteFecha($v['fecha_ingreso']);
                                    $fecha_egreso = $objPaciente->invierteFecha($v['fecha_egreso']); ?>
                                    <tr class="titulocampo">
                                      <td width="4%" height="29" align="center" valign="middle"><? echo $i;?></td>
                                      <td width="19%" align="center" valign="middle"><? echo $v['servicio'];?></td>
                                      <td width="14%" align="center" valign="middle"><? echo $fecha_ingreso."<br>".$v['hora_ingreso'];?></td>
                                      <td width="14%" align="center" valign="middle"><? echo $v['procedencia'];?></td>
                                      <td width="14%" align="center" valign="middle"><? echo $fecha_egreso."<br>".$v['hora_egreso'];?></td>
                                      <td width="14%" align="center" valign="middle"><? echo $v['destino'];?></td>
                                    </tr>
                                <? $i++; 
                                }
                               ?>
                        </table>
                        </fieldset>
                	</td>
                </tr>
                <tr>
                  	<td>
                    	<legend class="titulos_sesion">DiagnÓsticos (Referenciales)</legend>
                    	<fieldset>
                    	<table width="100%" height="100%" border="0" cellpadding="3">
    						<tr>
    							<td width="17%" height="10" class="titulocampo">Pre-diagnÓstico</td>
    							<td width="57%" class="titulocampo"><input name="diagnostico1" type="text" class="casilla_Giga" id="diagnostico1" value="<? echo $rowDiagnostico['diagnostico1'];?>" /></td>
    							<td width="26%" class="titulocampo">&nbsp;</td>
                            </tr>
    						<tr>
    						  <td height="11" class="titulocampo">diagnÓstico</td>
    						  <td height="11" class="titulocampo"><input name="diagnostico2" type="text" class="casilla_Giga" id="diagnostico2" value="<? echo $rowDiagnostico['diagnostico2'];?>" /></td>
    						  <td height="11" class="titulocampo">&nbsp;</td>
					      </tr>
                        </table>
                        </fieldset>
                  	</td>
                </tr>
                <tr>
                  	<td>
                    	<legend class="titulos_sesion">Datos del reciÉn nacido</legend>
						<fieldset>
                    	<table width="100%" height="100%" border="1" cellpadding="3" cellspacing="0">
    						<tr height="15" class="titulocampo">
                            	<th width="16%">Orden Nacimiento</th>
                            	<th width="16%">Fecha parto</th>
                                <th width="18%">CondiciÓn al Nacer</th>
                                <th width="13%">Sexo</th>
                                <th width="19%">Peso en gramos</th>
                                <th width="18%">Apgar 5 Minutos</th>
                            </tr>
                       <? if(@mysql_num_rows($rowPartos)){
							   $i=1;
                            	while($arrayPartos = mysql_fetch_array($rowPartos)){?>
                                    <tr class="titulocampo">
                                      <td height="20" align="center" valign="middle"><? echo $i;?></td>
                                      <td align="center" valign="middle"><? echo cambiarFormatoFecha($arrayPartos['RNfecha']);?></td>
                                      <td align="center" valign="middle"><? echo $arrayPartos['RNestado'];?></td>
                                      <td align="center" valign="middle"><? echo $arrayPartos['RNsexo'];?></td>
                                      <td align="center" valign="middle"><? echo $arrayPartos['RNpeso'];?></td>
                                      <td align="center" valign="middle"><? echo $arrayPartos['RNapgar5'];?></td>
                          </tr>
                              	<? $i++; 
								}
						   }else{?>
                           			<tr class="titulocampo">
                                      <td height="20" align="center" valign="middle">&nbsp;</td>
                                      <td align="center" valign="middle">&nbsp;</td>
                                      <td align="center" valign="middle">&nbsp;</td>
                                      <td align="center" valign="middle">&nbsp;</td>
                                      <td align="center" valign="middle">&nbsp;</td>
                                      <td align="center" valign="middle">&nbsp;</td>
                                    </tr>
                          <? }?>
                        </table>
                      </fieldset>                    
                    </td>
                </tr>
                <tr>
                  <td>
                  <legend class="titulos_sesion">Intervenciones realizadas</legend>                    
                        <fieldset>
                        <table width="100%" height="100%" border="1" cellpadding="3" cellspacing="0">
                            <tr class="titulocampo">
                                <th width="10%">Fecha</th>
                                <th width="12%">CÓdigo</th>
                                <th>Intervencion</th>
                            </tr>
                            <? if(@mysql_num_rows($rowIntervenciones)){?>
                            <? while($arrayIntervencion = mysql_fetch_array($rowIntervenciones)){?>
                                    <tr>
                                        <td height="20" align="center" class="titulocampo"><? echo cambiarFormatoFecha($arrayIntervencion['ciruFecha']);?></td>
                                        <td align="center" class="titulocampo"><? echo $arrayIntervencion['ciruInter1Cod'];?></td>
                                        <td align="center" class="titulocampo"><? echo $arrayIntervencion['preNombre'];?></td>
                                    </tr>
                            <? }
							}else{?>
									<tr>
                                        <td height="20" align="center" class="titulocampo">&nbsp;</td>
                                      	<td align="center" class="titulocampo">&nbsp;</td>
                                        <td align="center" class="titulocampo">&nbsp;</td>
                                	</tr>
							<? }?>
                        </table>
                      </fieldset>
                  </td>
                </tr>
            </table>
            </fieldset>
        </td>
    </tr>
    <tr>
    	<td height="48" colspan="3">
       	  <fieldset>
        	<legend class="titulos_sesion">datos del mÉdico o profesional</legend>
            <table width="100%" height="100%" border="0" cellpadding="0">
                <tr>
                    <td width="9%" height="27" class="titulocampo">Nombre</td>
                    <td colspan="2"><input name="PROnombre" type="text" class="casilla_Giga" id="PROnombre" value="<? echo $rowDiagnostico['medico']; ?>" /></td>
                </tr>
                <tr>
                    <td height="30" valign="middle" class="titulocampo">run</td>
                    <td width="16%" valign="middle"><input name="PACrut" type="text" class="casilla_mega" id="PACrut" readonly="readonly" value="<? echo $rowDiagnostico['rut']; ?>"/>-<input name="digito" type="text" class="casilla_chica" id="digito" readonly="readonly" value="<? echo $digito_doc; ?>"  /></td>
                    <td valign="middle" class="titulocampo">&nbsp;</td>
                </tr>
            </table>
            </fieldset>
		</td>
    </tr>
</table>
<table width="100%" border="0" cellpadding="0" class="noprint">
    <tr>
        <td align="center">
			<SCRIPT LANGUAGE="JavaScript">
                if (window.print) {
                    document.write('<form><input type=button name=print value="   Imprimir Reporte   " onClick="javascript: window.print();"></form>');
                }
            </script>
        </td>
    </tr>
</table>
</body>
</html>