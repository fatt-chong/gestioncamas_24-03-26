<? if(!isset($_SESSION)) 
	session_start(); 
if( $_SESSION['MM_Username'] == null ) {
	$GoTo = "../../cma/renovarSession.php?urlOrigen=../gestioncamas/superNumeraria/camaSuperNum.php";
	header(sprintf("Location: %s", $GoTo));
}
 
$idPaciente= $_GET['idPaciente'];
$idTransito= $_GET['idTransito'];
$SALcod= $_GET['SALcod']; 
$CAMcod= $_GET['CAMcod'];
$CAMnom= $_GET['CAMnom'];
$idServicio= $_GET['idServicio'];
$que_sala= $_GET['que_sala'];
$que_cama= $_GET['que_cama'];
$que_idcama= $_GET['que_idcama'];

require_once("include/funciones/funciones.php");

mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');
mysql_select_db('camas') or die('Cannot select database');
mysql_query("SET NAMES 'utf8'");

//VERIFICA SI LA CAMA AUN SE ENCUENTRA DESOCUPADA
//if(($SALcod != 'Pensionado') and ($SALcod != 'CMI 3')){
$sqlVerifica = mysql_query("SELECT * FROM camas WHERE id = $que_idcama") or die(" ERROR AL VERIFICAR CAMA ".mysql_error());
$arrayVerifica = mysql_fetch_array($sqlVerifica);
$verifica_estado = $arrayVerifica['estado'];
//}else{
////VERIFICA SI LA CAMA DE PENSIONADO AUN SE ENCUENTRA BLOQUEADA
//mysql_select_db('camas') or die('Cannot select database');
//
//$sqlVerifica = "SELECT * FROM camas WHERE id = $que_idcama";
//$queryVerifica = mysql_query($sqlVerifica) or die($sqlVerifica. " ERROR AL VERIFICAR CAMA ".mysql_error());
//$arrayVerifica = mysql_fetch_array($queryVerifica);
//$verifica_estado = $arrayVerifica['estado'];
//}
mysql_select_db('camas') or die('Cannot select database');
if(($verifica_estado == 1) or ($verifica_estado == 3)){

	//SELECCIONA DATOS DE TRANSITO PACIENTES
	$sqlTransito = mysql_query("SELECT * 
								FROM transito_paciente
								WHERE id = '$idTransito'") or die ("ERROR AL SELECCIONAR INFORMACION DE TRANSITO PACIENTE ".mysql_error());
								
	$arrayTransito = mysql_fetch_array($sqlTransito);
	$medico = $arrayTransito['cod_medico'];
	$codHasta1 = $arrayTransito['cod_sscc_hasta'];
	$nomServicio = $arrayTransito['desc_sscc_hasta'];
	$fecha_hospitalizacion = $arrayTransito['hospitalizado'];
	$tipo_traslado = $arrayTransito['tipo_traslado'];
	$id_solicitud = $arrayTransito['id_solicitud'];
	$barthel = $arrayTransito['barthel'];
	
	//BUSCA EL NOMBRE DEL SERVICIOS
	/*nombre del servicio que utilizara la cama*/
	$sqlServicio = "SELECT * FROM sscc WHERE id_rau = $codHasta1 ";
	$queryServicio = mysql_query($sqlServicio) or die($sqlServicio." ERROR AL SELECCIONAR LOS NOMBRES DE LOS SERVICIO ".mysql_error());
	$arrayServicio = mysql_fetch_array($queryServicio);
	$codHasta2 = $arrayServicio['id'];
  $visitas_max = $arrayServicio['visitas_max'];
	
	/*nombre del servicio al cual se le bloq. la cama*/
	$sqlServicio2 = mysql_query("SELECT * FROM sscc WHERE id = $idServicio ") or die("ERROR AL SELECCIONAR LOS NOMBRES DE LOS SERVICIO ".mysql_error());
	$arrayServicio2 = mysql_fetch_array($sqlServicio2);
	$que_nomServicio = $arrayServicio2['servicio'];
	
	//SELECCIONA LOS MEDICOS
	
	$sqlMedico = mysql_query("SELECT * FROM medicos order by medico") or die("ERROR AL SELECCIONAR LOS MEDICOS ". mysql_error());
	
	//SELECCIONA LAS PAT. AUGE
	
	$sqlAuge = mysql_query("SELECT * FROM pauge") or die(mysql_error());
	
	mysql_select_db('paciente') or die('Cannot select database');
	
	
	//SELECCIONA DATOS DEL PACIENTE
	$sqlPaciente= mysql_query("SELECT *
								FROM paciente
								WHERE id = '$idPaciente'") or die("ERROR AL SELECCIONAR DATOS DEL PACIENTE ".mysql_error());
								
	$arrayPaciente = mysql_fetch_array($sqlPaciente);
	$cod_prevision = $arrayPaciente['prevision'];
	$sexo = $arrayPaciente['sexo'];
	$direccion = $arrayPaciente['direccion'];
	$fechaNac = cambiarFormatoFecha($arrayPaciente['fechanac']);
	$codComuna = $arrayPaciente['idcomuna'];
	
	//SELECCIONA NOMBRE DE LA COMUNA
	if($codComuna){
	$sqlComuna = mysql_query("SELECT * FROM comuna WHERE id = $codComuna") or die("ERROR AL SELECCIONAR NOMBRE DE LA COMUNA ".mysql_error());
	$arrayComuna = mysql_fetch_array($sqlComuna);
	$nomComuna = $arrayComuna['comuna'];
	}
	//SELECCIONA CODIGO DE LA PREVISION
	
	$sqlPrev = mysql_query("SELECT * FROM prevision where id = '".$cod_prevision."' ") or die("ERROR AL SELECCIONAR PREVISION ". mysql_error());
	$arrayPrev = mysql_fetch_array($sqlPrev);
	$prevision = $arrayPrev['prevision'];
	
	$digito = generaDigito($arrayTransito['rut_paciente']);

}else{
	$mensajeError = "ERROR AL TRATAR DE INGRESAR PACIENTE,<br/> YA QUE LA CAMA ACABA DE SER UTILIZADA".$verifica_estado.','.$que_idcama;
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="css/estilo.css" />
<script type="text/javascript" src="include/funciones/funcionesJavaScript.js"></script>
<script src="../../estandar/src/calendario/src/js/jscal2.js"></script>
<script src="../../estandar/src/calendario/src/js/lang/es.js"></script>
<link rel="stylesheet" type="text/css" href="../../estandar/src/calendario/src/css/jscal2.css" />
<link rel="stylesheet" type="text/css" href="../../estandar/src/calendario/src/css/border-radius.css" />
<link rel="stylesheet" type="text/css" href="../../estandar/src/calendario/src/css/steel/steel.css" />
<title>Listado Pacientes</title>
</head>
<script>

function barthel(formulario){
	
	  var valorBarthel = formulario.barthel.value;
	  	if(valorBarthel == ""){
			var variable = "";
		}else if((valorBarthel >= 0) & (valorBarthel < 20)){
			var variable = "Dependiente";
		}else if((valorBarthel >= 20) & (valorBarthel <= 35)){
			var variable = "Grave";
			}else if((valorBarthel >= 40) & (valorBarthel <= 55)){
				var variable = "Moderado";
				}else if((valorBarthel >= 60) & (valorBarthel < 100)){
					var variable = "Leve";
					}else if(valorBarthel == 100){
						var variable = "Independiente";
						}else{
							var variable = "Valor invalido";
							}
		document.getElementById('valorBart').value = variable;
}

function h(){
	document.form1.registrar.disabled=(document.form1.hora_ingreso.value.length>0 && document.form1.minuto_ingreso.value.length>0 )?0:1;
}
window.onload=function(){
	setInterval('h()',10);
	setInterval('barthel(form1)',10);	
}
</script>

<body>
<? if($idServicio==46){ 
$que_estado = 3;
 } ?>
<form id="form1" name="form1" method="post" action="">
<input type="hidden" name="idPaciente" id="idPaciente" value="<? echo $idPaciente; ?>"/>
<input type="hidden" name="idTransito" id="idTransito" value="<? echo $idTransito; ?>"/>
<input type="hidden" name="SALcod" id="SALcod" value="<? echo $SALcod; ?>"/>
<input type="hidden" name="codigoCAM" id="codigoCAM" value="<? echo $CAMcod; ?>"/>
<input type="hidden" name="cod_pacprevision" id="cod_pacprevision" value="<? echo $cod_prevision; ?>"/>
<input type="hidden" name="que_sala" id="que_sala" value="<? echo $que_sala; ?>" />
<input type="hidden" name="que_cama" id="que_cama" value="<? echo $que_cama; ?>" />
<input type="hidden" name="que_idcama" id="que_idcama" value="<? echo $que_idcama; ?>" />
<input type="hidden" name="idServicio" id="idServicio" value="<? echo $idServicio; ?>" />
<input type="hidden" name="cod_procedencia" id="cod_procedencia" value="<? echo $arrayTransito['cod_sscc_desde']; ?>" />
<input type="hidden" name="codComuna" id="codComuna" value="<? echo $codComuna; ?>" />
<input type="hidden" name="nomComuna" id="nomComuna" value="<? echo $nomComuna; ?>" />
<input type="hidden" name="fecha_hospitalizacion" id="fecha_hospitalizacion" value="<? echo $fecha_hospitalizacion; ?>" />
<input type="hidden" name="desde_codServ" id="desde_codServ" value="<? echo $codHasta2; ?>" />
<input type="hidden" name="tipo_traslado" id="tipo_traslado" value="<? echo $tipo_traslado; ?>" />
<input type="hidden" name="que_causa" id="que_causa" value="<? echo $que_causa; ?>" />
<input type="hidden" name="que_estado" id="que_estado" value="<? echo $que_estado; ?>" />
<input type="hidden" name="que_fechaBloq" id="que_fechaBloq" value="<? echo $que_fechaBloq; ?>" />
<input type="hidden" name="id_solicitud" id="id_solicitud" value="<? echo $id_solicitud; ?>" />



<table width="855" border="0" style="border:1px solid #000000;" align="center" cellpadding="2" cellspacing="2" background="../ingresos/img/fondo.jpg">
    <tr>
        <th height="25" align="left" bgcolor="#006699" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; color:#FFF">Ingresar Paciente</th>
    </tr>
    <tr>
        <td>
        <? if(($verifica_estado == 1) or ($verifica_estado == 3)){ ?>
        	<table width="100%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
    				<td>
                    <fieldset class="titulocampo">
                    <legend class="titulos_menu">paciente</legend>
                    <table width="100%">
                    <tr>
                        <td width="105" align="left" valign="middle">Rut:</td>
                        <td width="521" align="left" valign="middle"><input name="rut_paciente" type="text" id="rut_paciente" value="<? echo $arrayTransito['rut_paciente'];?>" size="8" readonly="readonly"/>
                          -
                            <input name="digito" type="text" class="casilla_chica" id="digito" value="<? echo $digito;?>" size="1" readonly="readonly" />
                            Ficha:
                            <input name="ficha_paciente" type="text" id="ficha_paciente" value="<? echo $arrayTransito['ficha_paciente']; ?>" style="width:50px"readonly="readonly" />
                            Cta Cte:
                            <input name="cta_cte" type="text" id="cta_cte" value="<? echo $arrayTransito['cta_cte']; ?>" style="width:50px" readonly="readonly" />
                            Previsión:
                            <input name="pacPrevision" type="text" id="pacPrevision" value="<? echo $prevision; ?>" style="width:100px" readonly="readonly" /></td>
                        <td width="52">Fono 1:</td>
	            		<td width="145"><input style="width:60px" type="text" name="fono1_paciente" value="<? echo $arrayPaciente['fono1']; ?>" readonly="readonly" /></td>
                    </tr>
                    <tr>
                        <td>Nombre:</td>
                        <td>
                            <input name="nom_paciente" type="text" id="nom_paciente" value="<? echo $arrayTransito['nom_paciente']; ?>" size="50" readonly="readonly" />
                            Sexo:
                            <input name="pacSexo" type="text" class="casilla_media" id="pacSexo" value="<? echo $sexo; ?>" size="2" readonly="readonly"/></td>
                        <td width="52">Fono 2:</td>
	            		<td width="145"><input style="width:60px" type="text" name="fono2_paciente" value="<? echo $arrayPaciente['fono2']; ?>" readonly="readonly" /></td>
                    </tr>
                    <tr>
                        <td>Dirección:</td>
                        <td><input name="pacDireccion" type="text" id="pacDireccion" value="<? echo $direccion; ?>" size="50" readonly="readonly" />
Fecha Nac:
  <input name="fecha_nac" type="text" id="fecha_nac" value="<? echo $fechaNac; ?>" size="6" readonly="readonly"/></td>
                        <td width="52">Fono 3:</td>
	            		<td width="145"><input style="width:60px" type="text" name="fono3_paciente" value="<? echo $arrayPaciente['fono3']; ?>" readonly="readonly" /></td>
                    </tr>
                    </table>
                    </fieldset>
            	</td>
            </tr>
            <tr>
            	<td>
                  	<fieldset class="titulocampo">
                    <legend class="titulos_menu">Ingreso</legend>
                    <table width="100%">
                        <tr>
                          <td width="11%">Servicio:</td>
                          <td width="23%"><input name="pacServicio" type="text" id="pacServicio" value="<? echo $nomServicio; ?>" style="width:150px" readonly="readonly" /></td>
                          <td width="15%">Sala:
                            <input name="pacSala" type="text" id="pacSala" value="<? echo $SALcod; ?>" size="4" readonly="readonly" /></td>
                          <td width="51%">Cama:&nbsp;
                          <input name="pacCama" type="text" id="pacCama" value="<? echo $CAMnom; ?>" size="4" readonly="readonly" />&nbsp;</td>
                        </tr>
                        <tr>
                          <td width="11%">Corresponde a:</td>
                          <td width="23%"><input name="bloqServicio" type="text" id="bloqServicio" value="<? echo $que_nomServicio; ?>" style="width:150px" readonly="readonly" /></td>
                          <td width="15%">Sala:
                            <input name="bloqSala" type="text" id="bloqSala" value="<? echo $que_sala; ?>" size="4" readonly="readonly" />                          </td>
                          <td width="51%">Cama:&nbsp;
                          <input name="bloqCama" type="text" id="bloqCama" value="<? echo $que_cama; ?>" size="4" readonly="readonly" />                            &nbsp;</td>
                        </tr>
                        <tr>
                        	<td>I. Barthel: </td>
                    		<td colspan="3"><input type="text" name="barthel" id="barthel" size="2px" value="<?= $barthel; ?>" />&nbsp;<input type="text" name="valorBart" id="valorBart" readonly="readonly" /></td>
                        </tr>
                        <tr>
                          <td>Medico:</td>
                          <td colspan="3">
                          <select name="medico" id="medico">
                            <? while($RSmedicos = mysql_fetch_array($sqlMedico)){?>
                            <option value="<? echo $RSmedicos['id'];?>" <? if($RSmedicos['id'] == $medico) echo "selected='selected'";?>>
                              <? echo $RSmedicos['medico'];?>
                            </option>
                            <? }?>
                          </select> 
                          &nbsp;
                          Procedencia:
                          <input type="text" readonly="readonly" name="descProcedencia" id="descProcedencia" value="<? echo $arrayTransito['desc_sscc_desde']; ?>" /></td>
                        </tr>
                        <tr>
                          <td>Fecha Ingreso:</td>
                          <td colspan="3"><input name="fecha" type="text" id="fecha" value="<? if($arrayTransito['fecha']) echo cambiarFormatoFecha($arrayTransito['fecha']); else echo date('d-m-Y'); ?>" size="8" readonly="readonly" />
                          <a id="ver" style="cursor:pointer;" title="Abrir Calendario"><img src="img/calendar.jpg" alt="" /></a></td>
                        </tr>
                        <tr>
                          <td>Hora Ingreso:</td>
                          <td colspan="3">
                          <input name="hora_ingreso" type="text" id="hora_ingreso" style="width:18px" onblur="return formatoHoraIngreso(document.getElementById('hora_ingreso'));" onkeypress="return validaNumeros(event);" value="<? if($hora_ingreso != '') echo $hora_ingreso; else echo soloHora();?>" maxlength="2" />
:
  <input name="minuto_ingreso" type="text" id="minuto_ingreso" style="width:18px" value="<? if($minuto_ingreso != '') echo $minuto_ingreso; else echo soloMinuto();?>" onkeypress="return validaNumeros(event);" onblur="return formatoMinutoIngreso(document.getElementById('minuto_ingreso'));" maxlength="2" /></td>
                        </tr>
                        <tr>
                          <td>Pre-Diagnóstico:</td>
                          <td colspan="3"><input name="PACdiagnostico1" type="text" id="PACdiagnostico1" value="<? echo $arrayTransito['diagnostico1']; ?>" size="100" /></td>
                        </tr>
                        <tr>
                          <td>Diagnóstico:</td>
                          <td colspan="3"><input name="PACdiagnostico2" type="text" id="PACdiagnostico2" value="<? echo $arrayTransito['diagnostico2']; ?>" size="100" /></td>
                        </tr>
                        <tr>
                          <td>Patología Auge:</td>
                          <td colspan="3">
                          <select name="auge" id="auge">
                          	<option value="">No Auge...</option>
                            <? while($RSpauge = mysql_fetch_array($sqlAuge)){?>
                            <option value="<? echo $RSpauge['id'];?>" <? if($RSpauge['id'] == $auge) echo "selected='selected'";?>>
                              <? echo $RSpauge['pauge']; ?>
                            </option>
                            <? }?>
                          </select></td>
                        </tr>
                        <tr>
                          <td>Multiresistente:</td>
                          <td colspan="3"><input type="checkbox" name="multires" id="multires" <? if($arrayTransito['acctransito']){ ?> checked="checked" <? } ?> />
                            &nbsp;Acc. transito:
                          <input type="checkbox" name="accidente" id="accidente" <? if($arrayTransito['multires']){ ?> checked="checked" <? } ?> /></td>
                        </tr>
                        <tr>
                          <td>Visitas permitidas:</td>
                          <td><input type="number" name="visitas_max" id="visitas_max" class="casilla_50" min="0" max="20" value="<? echo $visitas_max;?>"></td>
                        </tr>    
                    </table>
                    </fieldset>
                </td>
            </tr>
            <tr>
                <td>
                        <fieldset class="titulocampo">
						<legend class="titulos_menu">OpERACIONES</legend>
						<table width="100%">
							<tr>
                                <td align="center"><input type="button" name="registrar" id="registrar" value="   Aceptar   " onclick="document.form1.action='pacienteAgregadoSN.php'; document.form1.submit();"/>
                                <? if(($SALcod != 'Pensionado') and ($SALcod != 'CMI 3')){ ?>
                                <input type="button" name="atras" id="atras" value="   Cancelar   " onclick="javascript: document.location.href='elegirCamaSN.php<? echo "?SALcod=$SALcod&CAMcod=$CAMcod&CAMnom=$CAMnom&idTransito=$idTransito&idPaciente=$idPaciente";?>'" />
                                <? }else{ ?>
                                <input type="button" name="atras" id="atras" value="   Cancelar   " onclick="javascript: document.location.href='camaSuperNum.php'" />
                                <? } ?>
                                </td>
                            </tr>
                        </table>
						</fieldset>
					</td>
				</tr>
			</table>
        <? }else{ ?>
        	<fieldset class="titulos_menu"><legend>Mensaje</legend>
        	<div align="center" class="folio"><? echo $mensajeError; ?>
            <br />
            <? if(($SALcod != 'Pensionado') and ($SALcod != 'CMI 3')){ ?>
            <input type="button" name="atras" id="atras" value="   Volver   " onclick="javascript: document.location.href='elegirCamaSN.php<? echo "?SALcod=$SALcod&CAMcod=$CAMcod&CAMnom=$CAMnom&idTransito=$idTransito&idPaciente=$idPaciente";?>'" />
            <? }else{ ?>
            <input type="button" name="atras" id="atras" value="   Volver   " onclick="javascript: document.location.href='camaSuperNum.php'" />
            <? } ?>
            </div>
            </fieldset>
        <? } ?>
		</td>
	</tr>
</table>


</form>
</body>
<script type="text/javascript">
      var cal = Calendar.setup({
          onSelect: function(cal) { cal.hide() }
      });
      cal.manageFields("ver", "fecha", "%d-%m-%Y");

</script>
</html>