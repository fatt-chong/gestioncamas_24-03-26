<? session_start();
if ( $_SESSION['MM_Username'] == null ) {
	$GoTo = "../../acceso/index.php";
	header(sprintf("Location: %s", $GoTo));
}
//RECEPCION DE VARIABLES
if($_GET['id_paciente'])
	$id_paciente = $_GET['id_paciente'];
if($_POST['id_paciente'])
	$id_paciente = $_POST['id_paciente'];
if($_GET['correlativo'])
	$correlativo = $_GET['correlativo'];
if($_POST['correlativo'])
	$correlativo = $_POST['correlativo'];
	
$tipo_doc	= $_REQUEST['tipo_doc'];
$busca		= $_REQUEST['busca'];
$HOSid		= $_REQUEST['HOSid'];
$act		= $_REQUEST['act'];
$hospitalizado = $_REQUEST['hospitalizado'];
$desde		= $_REQUEST['desde'];
$totalreg 	= $_REQUEST['desde'];
$que_cod_servicio = $_REQUEST['desde'];
// $HOSid =
$cod_servicio  = $_REQUEST['cod_servicio'];
$servicio  = $_REQUEST['servicio'];
$tipo_cama  = $_REQUEST['tipo_cama'];
$cod_procedencia  = $_REQUEST['cod_procedencia'];
$procedencia  = $_REQUEST['procedencia'];
$cod_destino  = $_REQUEST['cod_destino'];
$destino  = $_REQUEST['destino'];
$fecha_ingreso  = $_REQUEST['fecha_ingreso'];
$hora_ingreso  = $_REQUEST['hora_ingreso'];
$minuto_ingreso  = $_REQUEST['minuto_ingreso'];
$fecha_egreso  = $_REQUEST['fecha_egreso'];
$hora_egreso  = $_REQUEST['hora_egreso'];
$minuto_egreso  = $_REQUEST['minuto_egreso']; 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="include/funciones/funcionesJavaScript.js"></script>
<script src="../../estandar/src/calendario/src/js/jscal2.js"></script>
<script src="../../estandar/src/calendario/src/js/lang/es.js"></script>
<link rel="stylesheet" type="text/css" href="../../estandar/src/calendario/src/css/jscal2.css" />
<link rel="stylesheet" type="text/css" href="../../estandar/src/calendario/src/css/border-radius.css" />
<link rel="stylesheet" type="text/css" href="../../estandar/src/calendario/src/css/steel/steel.css" />
<title>Asociar componente sanguineo</title>
<link type="text/css" rel="stylesheet" href="../../estandar/css/estilo.css" />
</head>
<? //:::CARGA DE DATOS DEL FORMULARIO::://
//CONEXIONES A BD
require_once("clases/Conectar.inc");
$bd = new Conectar;
$link = $bd->db_connect();
//OBTENER DATOS PACIENTE
$bd->db_select("paciente",$link);
require_once("clases/Paciente.inc");
$objPaciente = new Paciente;
$rowPaciente = $objPaciente->getPaciente($link, $id_paciente);
$digito = $objPaciente->generaDigito($rowPaciente['rut']);
$fecha_nac = $objPaciente->invierteFecha($rowPaciente['fechanac']);

//CARGA LOS SERVICIOS
require_once("clases/Servicio.inc");
$objServicio = new Servicio;
$bd->db_select("camas",$link);
$rowIngreso = $objServicio->getServicioSSCC($link, 1);
$rowEgreso = $objServicio->getServicioSSCC($link, 0);
//LEER REGISTRO EN VARIABLE DE SESSION
$rowHospitalizacion = $objPaciente->getDetalleEspecifico($link, $HOSid);
require_once("clases/Censo.inc");
$objCenso = new Censo;
$rowCenso = $objCenso->cargaDatosSession($HOSid);
list($hora_1, $minuto_1)=explode(':', $rowCenso['hora_ingreso']);
list($hora_2, $minuto_2)=explode(':', $rowCenso['hora_egreso']);
//CARGA LOS TIPOS DE CAMAS
require_once("clases/Cama.inc");
$objCama = new Cama;
$rowTipoCama = $objCama->getTipoCama($link);

//ACCION DE AGREGAR UN HEMODERIVADO A LA LISTA DE TRANSFUSION
if($act=='modifica'){
	$objCenso->actualizaDatosSession($link, $HOSid, $cod_servicio, $servicio, $tipo_cama, $cod_procedencia, $procedencia, $cod_destino, $destino, $fecha_ingreso, $hora_ingreso, $minuto_ingreso, $fecha_egreso, $hora_egreso, $minuto_egreso);
	?>
	<script><!--FUNCION JAVASCRIPT PARA RETORNAR A LA PAGINA PADRE-->
         document.location.href='<? echo "listadoCensoDiario.php?id_paciente=$id_paciente&act=pac&que_pag=det&tipo_doc=$tipo_doc&busca=$busca&hospitalizado=$hospitalizado&que_cod_servicio=$que_cod_servicio"; ?>'
    </script>
	<?
}
?>
<body>
<form id="form1" name="form1" method="post" action="">
<input type="hidden" name="act" id="act" />
<input type="hidden" name="id_paciente" id="id_paciente" value="<? echo $id_paciente;?>"/>
<input type="hidden" name="hospitalizado" id="hospitalizado" value="<? echo $hospitalizado;?>"/>
<input type="hidden" name="que_cod_servicio" id="que_cod_servicio" value="<? echo $que_cod_servicio;?>"/>
<table width="726" border="1" align="center" cellpadding="5" cellspacing="0" bgcolor="#F0F0F0">
    <tr>
      <th width="712" align="left" bgcolor="#006699" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; color:#FFF">Modificar Hospitalización</th>
    </tr>
    <tr>
		<td>
			<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr valign="top">
					<td>
						<fieldset class="titulocampo">
                        <legend class="titulos_menu">Datos Hospitalización</legend>
                        <table width="100%">
                            <tr>
                                <td height="10" colspan="2" align="left">
                                    <fieldset class="titulocampo">
                                    <legend class="titulos_menu">PACIENTE HOSPITALIZADO</legend>
                                    <table width="100%">
                                        <tr>
                                            <td>Servicio Clínico:</td>
                                            <td>Sala:</td>
                                            <td>Cama:</td>
                                            <td>Categorización:</td>
                                        </tr>
                                        <tr>
                                            <td width="186" height="11">
                                            <input type="hidden" name="cod_servicio" id="cod_servicio" value="<? echo $rowHospitalizacion['cod_servicio'];?>"/>
                                            <input name="pservicio" type="text" disabled="disabled" value="<? echo $rowHospitalizacion['servicio']; ?>" readonly="readonly" /></td>
                                        <td width="127"><input name="pcama2" type="text" disabled="disabled" value="<? echo $rowHospitalizacion['sala']; ?>" size="15" readonly="readonly" /></td>
                                            <td width="82"><input name="pcama" type="text" disabled="disabled" value="<? echo $rowHospitalizacion['cama']; ?>" size="5" readonly="readonly" /></td>
                                            <td width="285"><input name="categorizacion" type="text" disabled="disabled" value="<? echo $rowHospitalizacion['categorizacion_riesgo'].$rowHospitalizacion['categorizacion_dependencia']; ?>" size="5" readonly="readonly" /></td>
                                        </tr>
                                        <tr>
											<td height="11" colspan="4">    
                                          		<table width="100%">
                                                    <tr>
                                                        <td width="9%" align="left" valign="middle">Rut</td>
                                                        <td width="91%" align="left" valign="middle"><input name="pacRut" type="text" disabled="disabled" id="pacRut" value="<? echo $rowPaciente['rut'];?>" size="8" readonly="readonly"/>
                                                          -
                                                            <input name="digito" type="text" id="digito" value="<? echo $digito;?>" style="width:15px;" readonly="readonly" disabled="disabled"/>
                                                            Ficha
                                                            <input name="ficha" type="text" disabled="disabled" id="ficha" style="width:55px;" value="<? echo $rowPaciente['nroficha']; ?>" size="10" readonly="readonly" />
                                                            Previsión
                                                            <input name="pacPrevision" type="text" disabled="disabled" id="pacPrevision" value="<? echo $rowPaciente['nom_prev']; ?>" size="20" readonly="readonly" /></td>
                                                    </tr>
                                                    <tr>
                                                      <td>
                                                      Nombre</td>
                                                      <td>
                                                        <input name="pacNombre" type="text" disabled="disabled" id="pacNombre" value="<? echo $rowPaciente['nombres']." ".$rowPaciente['apellidopat']." ".$rowPaciente['apellidomat']; ?>" size="40" readonly="readonly" />
                                                        
                                                        Sexo
                                                        <input name="pacSexo" type="text" disabled="disabled" class="casilla_media" id="pacSexo" style="width:15px;" value="<? echo $rowPaciente['sexo']; ?>" size="2" readonly="readonly"/>
                                                        
                                                        Nac
                                                       <input name="fecha_nac" type="text" disabled="disabled" id="fecha_nac" value="<? echo $fecha_nac; ?>" size="6" readonly="readonly"/>
                                                        
                                                      </td>
                                                      </tr>
                                            	</table>
                                            </td>
                                        </tr>
                                    </table>
                                    </fieldset>
                                </td>
							</tr>
                            <tr>
                                <td width="50%" height="10" align="left">
                               	  <fieldset class="titulocampo">
                                    <legend class="titulos_menu">Ingreso</legend>
                                    <table width="100%">
                                        <tr>
                                            <td>Procedencia:</td>
                                            <td><select name="cod_procedencia" id="a">
                                              <? while($arrServicio = mysql_fetch_array($rowIngreso)){
                                                    $idServicio = $arrServicio['id'];
                                                    $nomServicio = $arrServicio['servicio'];?>
                                              <option value="<? echo $idServicio; ?>" <? if ($idServicio == $rowCenso['cod_procedencia']) { echo "selected"; }?>><? echo $nomServicio; ?></option>
                                              <? }?>
                                            </select></td>
                                        </tr>
                                        <tr>
                                            <td width="118" height="11">Fecha Ingreso:</td>
                                        <td width="217"><input name="fecha_ingreso" type="text" id="fecha_ingreso" size="8" value="<? if($fecha_ingreso != '') echo $fecha_ingreso; else  echo cambiarFormatoFecha($rowCenso['fecha_ingreso']);?>" readonly="readonly" />
                                          <input type="button" name="ver" id="ver" value="..." /> <input name="hora_ingreso" type="text" id="hora_ingreso" style="width:18px" onblur="return formatoHoraIngreso(document.getElementById('hora_ingreso'));" onkeypress="return validaNumeros(event);" value="<? if($hora_ingreso != '') echo $hora_ingreso; else echo $hora_1;?>" maxlength="2" />
:
<input name="minuto_ingreso" type="text" id="minuto_ingreso" style="width:18px" value="<? if($minuto_ingreso != '') echo $minuto_ingreso; else echo $minuto_1;?>" onkeypress="return validaNumeros(event);" onblur="return formatoMinutoIngreso(document.getElementById('minuto_ingreso'));" maxlength="2" /></td>
                                        </tr>
                                    </table>
                                    </fieldset>
								</td>
                                <td width="50%" align="left">
                               	  	<fieldset class="titulocampo">
                                    <legend class="titulos_menu">Egreso</legend>
                                    <table width="100%">
                                        <tr>
                                            <td>Destino:</td>
                                            <td><select name="cod_destino" id="servicio">
                                              <? while($arrServicio = mysql_fetch_array($rowEgreso)){
                                                    $idServicio = $arrServicio['id'];
                                                    $nomServicio = $arrServicio['servicio'];?>
                                              <option value="<? echo $idServicio; ?>" <? if ($idServicio == $rowCenso['cod_destino']) { echo "selected"; }?>><? echo $nomServicio; ?></option>
                                              <? }?>
                                            </select></td>
                                        </tr>
                                        <tr>
                                            <td width="118" height="10">Fecha Egreso:</td>
                                        <td width="217"><input name="fecha_egreso" type="text" id="fecha_egreso" size="8" value="<? if($fecha_egreso != '') echo $fecha_egreso; else  echo cambiarFormatoFecha($rowCenso['fecha_egreso']);?>" readonly="readonly" />
                                          <input type="button" name="ver2" id="ver2" value="..." /> <input name="hora_egreso" type="text" id="hora_egreso" style="width:18px" value="<? if($hora_egreso != '') echo $hora_egreso; else echo $hora_2;?>" onkeypress="return validaNumeros(event);" onblur="return formatoHoraEgreso(document.getElementById('hora_egreso'));" maxlength="2" />
                                          :
                                          <input name="minuto_egreso" type="text" id="minuto_egreso" style="width:18px" value="<? if($minuto_egreso != '') echo $minuto_egreso; else echo $minuto_2;?>" onkeypress="return validaNumeros(event);" onblur="return formatoMinutoEgreso(document.getElementById('minuto_egreso'));" maxlength="2" /></td>
                                        </tr>
                                    </table>
                                    </fieldset>                                
                                </td>
                            </tr>
                            <? //SI EL SERVICIO DE LA HOSPITALIZACION ES GINECOLOGIA-PUERPERIO HABILITA EL CAMBIO DE TIPO DE CAMA
							if($rowHospitalizacion['cod_servicio'] == 10 || $rowHospitalizacion['cod_servicio'] == 11){?>
                            <tr>
                            	<td colspan="2">
                                	<fieldset class="titulocampo">
                                    <legend class="titulos_menu">Tipo de CAMA
                                    </legend><table width="100%">
                                        <tr>
                                            <td width="136">Tipo de cama</td>
                                            <td width="552"><select name="tipo_cama" id="tipo_cama">
                                              <? while($arrTipo = mysql_fetch_array($rowTipoCama)){
                                                    $idTipo = $arrTipo['TIPCid'];
                                                    $nomTipo = $arrTipo['TIPCnombre'];?>
                                              <option value="<? echo $idTipo; ?>" <? if ($idTipo == $rowCenso['tipo_1']) { echo "selected"; }?>><? echo $nomTipo; ?></option>
                                              <? }?>
                                            </select></td>
                                        </tr>
                                    </table>
                                    </fieldset>
                                </td>
                            </tr>
                            <? //CASO CONTRARIO SI EL SERVICIO NO ES NINGUNO DE LOS ANTERIORES SE PASA EL TIPO DE CAMA SIN ALTERACIONES EN INPUT HIDDEN
							}else{?>
								<input type="hidden" name="tipo_cama" id="tipo_cama" value="<? echo $rowCenso['tipo_1'];?>" />
						<? }?>
                        </table>
                        </fieldset>
                        <fieldset class="titulocampo">
                        <legend class="titulos_menu">Opciones</legend>
                        <table width="100%">
                        	<tr>
                                <td align="center" colspan="2"><input type="button" name="agregar" id="agregar" value="   Modificar Registro   " onclick="javascript: document.form1.act.value='modifica'; document.form1.submit();" />
                                <input type="button" name="volver" id="volver" value="   Volver   " onclick="javascript:document.location.href='listadoCensoDiario.php?act=pac&que_pag=det&id_paciente=<? echo $id_paciente;?>&tipo_doc=<? echo $tipo_doc;?>&busca=<? echo $busca;?>&hospitalizado=<? echo $hospitalizado; ?>&que_cod_servicio=<? echo $que_cod_servicio; ?>';" /></td>
                            </tr>
						</table>
                        </fieldset>
                    </td>
                </tr>
			</table>
		</td>
	</tr>
</table>
</form>
<? if($foco=='cantidad'){?>
<script type="text/javascript">
	window.onload= function(){
		document.form1.traCantidad.focus();
	}
</script>
<? }?>
</body>
<script type="text/javascript">
      var cal = Calendar.setup({
          onSelect: function(cal) { cal.hide() }
      });
      cal.manageFields("ver", "fecha_ingreso", "%d-%m-%Y");
	  cal.manageFields("ver2", "fecha_egreso", "%d-%m-%Y");

</script>
</html>