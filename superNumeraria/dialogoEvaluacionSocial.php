<?php 
//date_default_timezone_set('America/Santiago');
ob_start(); 
if (!isset($_SESSION)) { session_start(); }
if ( $_SESSION['MM_Username'] == null ) { $GoTo = "../../acceso/index.php"; header(sprintf("Location: %s", $GoTo)); }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!--<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />-->
<title>Gestion de Camas Hospital Dr. Juan Noé C.</title>
<link type="text/css" rel="stylesheet" href="css/estilo.css" />
</head>
<?
include "../funciones/funciones.php";
$permisos = $_SESSION['permiso'];
$fecha_hoy = date('d-m-Y');
$fecha_categoriza = cambiarFormatoFecha($fecha_hoy);
$cod_usuario = 1;
$usuario = $_SESSION['MM_Username'];
mysql_connect ('10.6.21.29','usuario','hospital');
mysql_select_db('camas') or die('Cannot select database');
$sqlLista = "SELECT *
			FROM listasn
			INNER JOIN camassn ON listasn.idCamaSN = camassn.codCamaSN
			WHERE idListaSN  = '$id_cama'";
$queryLista = mysql_query($sqlLista);
$arrayLista =mysql_fetch_array($queryLista);
$cod_servicio = $arrayLista['que_codServSN'];
$desc_servicio = $arrayLista['que_nomServSN'];
$sala = $arrayLista['que_salaSN'];
$tipo_1 = $arrayLista['tipo1SN'];
$d_tipo_1 = $arrayLista['d_tipo1SN'];
$tipo2 = $arrayLista['tipo2SN'];
$d_tipo_2 = $arrayLista['d_tipo2SN'];
$nom_paciente = $arrayLista['nomPacienteSN'];
$cama = $arrayLista['que_camaSN'];
$sala_sn = $arrayLista['salaCamaSN'];
$ctacteCama = $arrayLista['ctaCteSN'];
$categorizaRiesgoSN = $arrayLista['categorizaRiesgoSN'];

require_once('../../gestionCamas2/clases/Conectar.inc'); $objConectar = new Conectar; $link = $objConectar->db_connect();
require_once("../../gestionCamas2/clases/Evaluacionsocial.inc"); $objEvaluacionsocial = new Evaluacionsocial;
$validaEvaluacionsocial= $objEvaluacionsocial->buscarEvaluacionsocial($link,$ctacteCama);
?>
<script src="../../estandar/jquery/js/jquery-1.9.1.js"></script>
<script src="../../estandar/jquery/js/jquery-ui-1.10.3.custom.js"></script>
<script>
     $(document).ready(function(){
        $('.change').click(function() {
               var uno = $("#ED_recidencia").val();
               var dos = $("#ED_economica").val();
               var tres = $("#ED_mental").val();
               var cuatro = $("#ED_familiar").val();
               var cinco = $("#ED_cuidador").val();
               $("#resultado").val(parseInt(uno)+parseInt(dos)+parseInt(tres)+parseInt(cuatro)+parseInt(cinco));
        });
     });
</script>
<body topmargin="5" style="font-family:Arial, Helvetica, sans-serif; font-size:12px">
<form method="post" name="frm_Evaluacionsocial" id="frm_Evaluacionsocial" action="control_evaluacionsocial.php">
	<table width="850px" align="center" cellspacing="0" cellpadding="0">
        <tr>
            <td >
            	<fieldset class="fondoF"><legend class="estilo1">Categorizacion del Paciente</legend>
					<div style="text-align:center" align="center">
						    <input type="hidden" name="id_cama" value="<? echo $id_cama ?>" />
						    <input type="hidden" name="cod_servicio"  value="<? echo $cod_servicio ?>" />
						    <input type="hidden" name="desc_servicio" value="<? echo $desc_servicio ?>" />
						    <input type="hidden" name="sala" value="<? echo $sala_sn ?>" />
						    <input type="hidden" name="tipo_1" value="<? echo $tipo_1 ?>" />
						    <input type="hidden" name="d_tipo_1" value="<? echo $d_tipo_1 ?>" />
						    <input type="hidden" name="tipo_2" value="<? echo $tipo_2 ?>" />
						    <input type="hidden" name="d_tipo_2" value="<? echo $d_tipo_2 ?>" />
						    <input type="hidden" name="nom_paciente" value="<? echo $nom_paciente ?>" />
						    <input type="hidden" name="idPaciente" value="<? echo $id_paciente ?>" />
						    <input type="hidden" name="cama" value="<? echo $cama ?>" />
						    <input type="hidden" name="cod_usuario" value="<? echo $cod_usuario ?>" />
						    <input type="hidden" name="usuario" value="<? echo $usuario ?>" />
						    <input type="hidden" name="desde" value="<? echo $desde ?>" />
						    <input type="hidden" name="ctacte" value="<? echo $ctacteCama ?>" />
						    <table width="95%" align="center" border="0" cellspacing="0" cellpadding="0">
						        <tr align="left">
						            <td colspan="3">
						                <fieldset>
						                <legend style="font-size:14px">Informacion de Paciente</legend>
						                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
						                        <tr><td width="20px" height="5px"></td><td width="160px"></td></tr>
						                        <tr><td></td><td style="font-size:14px">Serv.Clínico <? echo $desc_servicio ?>  --  Sala <? echo $sala ?>  --  Cama N° <? echo $cama ?> -- <strong> <? echo $d_tipo_1." ".$d_tipo_2; ?> </strong></td></tr>
						                        <tr><td></td><td style="font-size:14px">Paciente    : <? echo $nom_paciente ?> </td></tr>
						                        <tr><td></td><td style="font-size:14px">Diagnostico : <? echo $diagnostico2 ?> </td></tr>
						                    </table>
						                </fieldset>
						            </td>
						        </tr>
						    </table>
					</div>
				</fieldset>
			</td>
		</tr>
		<tr>
		<td valign="top">
			<fieldset class="fondoF"><legend class="estilo1">SCORE RIESGO SOCIAL</legend>
				<table width="100%">
                         <tr>
                              <td> <? if($categorizaRiesgoSN != ""){?>
                                   <table>
               					<tr>
                                   	<td>
                                   		<select style="width: 427px !important;" id="ED_recidencia" name="ED_recidencia" class="change" <? if($validaEvaluacionsocial['ED_fecha']==""){}else{if($validaEvaluacionsocial['ED_fecha']!=date('Y-m-d')){?> disabled="disabled"<?}}?>>
                                   			<option value="0"<?if($validaEvaluacionsocial['ED_recidencia']==0){?>selected="select"<?}?>>Seleccione...</option>
                                   			<option value="3"<?if($validaEvaluacionsocial['ED_recidencia']==3){?>selected="select"<?}?>>Situación de calle o personas que viven solas - 3</option>
                                   			<option value="2"<?if($validaEvaluacionsocial['ED_recidencia']==2){?>selected="select"<?}?>>Residencia en condición inadecuada de habitabilidad - 2</option>
                                   			<option value="1"<?if($validaEvaluacionsocial['ED_recidencia']==1){?>selected="select"<?}?>>Residencia en condiciones adecuadas - 1</option>
                                   		</select>
                                   	</td>		
               					</tr>
               					<tr>
                                   	<td>
                                   		<select style="width: 427px !important;" id="ED_economica" name="ED_economica" class="change"<? if($validaEvaluacionsocial['ED_fecha']==""){}else{if($validaEvaluacionsocial['ED_fecha']!=date('Y-m-d')){?> disabled="disabled"<?}}?>>
                                   			<option value="0"<?if($validaEvaluacionsocial['ED_economica']==0){?>selected="select"<?}?>>Seleccione...</option>
                                   			<option value="3"<?if($validaEvaluacionsocial['ED_economica']==3){?>selected="select"<?}?>>Condición económica de extrema pobreza - 3</option>
                                   			<option value="2"<?if($validaEvaluacionsocial['ED_economica']==2){?>selected="select"<?}?>>Condición económica de pobreza - 2</option>
                                   			<option value="1"<?if($validaEvaluacionsocial['ED_economica']==1){?>selected="select"<?}?>>Condición económica permite satisfacer necesidades básicas - 1</option>
                                   		</select>
                                   	</td>		
               					</tr>
               					<tr>
                                   	<td>
                                   		<select style="width: 427px !important;" id="ED_mental" name="ED_mental" class="change"<? if($validaEvaluacionsocial['ED_fecha']==""){}else{if($validaEvaluacionsocial['ED_fecha']!=date('Y-m-d')){?> disabled="disabled"<?}}?>>
                                   			<option value="0"<?if($validaEvaluacionsocial['ED_mental']==0){?>selected="select"<?}?>>Seleccione...</option>
                                   			<option value="3"<?if($validaEvaluacionsocial['ED_mental']==3){?>selected="select"<?}?>>Presencia de patología psiquiátrica y/o adicciones, sin tratamiento - 3</option>
                                   			<option value="2"<?if($validaEvaluacionsocial['ED_mental']==2){?>selected="select"<?}?>>Presencia de patología psiquiátrica y/o adicciones, con tratamiento - 2</option>
                                   			<option value="1"<?if($validaEvaluacionsocial['ED_mental']==1){?>selected="select"<?}?>>Ausencia de patología psiquiátrica y/o adicciones - 1</option>
                                   		</select>
                                   	</td>		
               					</tr>
               					<tr>
                                   	<td>
                                   		<select style="width: 427px !important;" id="ED_familiar" name="ED_familiar" class="change"<? if($validaEvaluacionsocial['ED_fecha']==""){}else{if($validaEvaluacionsocial['ED_fecha']!=date('Y-m-d')){?> disabled="disabled"<?}}?>>
                                   			<option value="0"<?if($validaEvaluacionsocial['ED_familiar']==0){?>selected="select"<?}?>>Seleccione...</option>
                                   			<option value="3"<?if($validaEvaluacionsocial['ED_familiar']==3){?>selected="select"<?}?>>No cuenta con redes familiares o sociales suficientes - 3</option>
                                   			<option value="2"<?if($validaEvaluacionsocial['ED_familiar']==2){?>selected="select"<?}?>>Cuenta con redes familiares o sociales insuficientes - 2</option>
                                   			<option value="1"<?if($validaEvaluacionsocial['ED_familiar']==1){?>selected="select"<?}?>>Cuenta con redes familiares o sociales suficientes - 1</option>
                                   		</select>
                                   	</td>		
               					</tr>
               					<tr>
                                   	<td>
                                   		<select style="width: 427px !important;" id="ED_cuidador" name="ED_cuidador" class="change"<? if($validaEvaluacionsocial['ED_fecha']==""){}else{if($validaEvaluacionsocial['ED_fecha']!=date('Y-m-d')){?> disabled="disabled"<?}}?>>
                                   			<option value="0"<?if($validaEvaluacionsocial['ED_cuidador']==0){?>selected="select"<?}?>>Seleccione...</option>
                                   			<option value="3"<?if($validaEvaluacionsocial['ED_cuidador']==3){?>selected="select"<?}?>>No hay cuidador disponible - 3</option>
                                   			<option value="2"<?if($validaEvaluacionsocial['ED_cuidador']==2){?>selected="select"<?}?>>Cuidador con insuficiente capacidad de cuidado - 2</option>
                                   			<option value="1"<?if($validaEvaluacionsocial['ED_cuidador']==1){?>selected="select"<?}?>>Disponibilidad de cuidador con capacidad de hacerse cargo - 1</option>
                                   		</select>
                                   	</td>		
               					</tr>
                                   </table>
                              </td>
                              <td>
                                   <table>
                                        <tr>
                                             <td>Resultado</td>
                                             <td><input type="text" name="resultado" id="resultado" value="<?=$validaEvaluacionsocial['total'];?>" readonly="readonly"></td>
                                             <?if($validaEvaluacionsocial['ED_fecha']!=""){?>
                                             <td>Fecha:<?=date("d-m-Y",strtotime($validaEvaluacionsocial['ED_fecha']))?></td>
                                             <?}?>
                                        </tr>
                                   </table>
                                   <? }else{echo "<H2><center>Paciente sin categorización, categorice al paciente antes de realizar score social</center></H2>";}?>
                              </td>
                         </tr>
					</table>  
				</fieldset> 
			</td>
		</tr>
		<tr>
			<td>
				<fieldset class="fondoF"><legend class="estilo1">Criterios de clasificacion</legend>
                    <table width="100%">
                         <tr>
                              <td><b>Tipo de dependencia Social</b></td>
                              <td><b>Rango de clasificacion</b></td>
                              <td><b>Grado de proteccion social a entregar por el Estado</b></td>
                         </tr>
                         <tr>
                              <td>Alta Dependencia Social – Riesgo Severo</td>
                              <td>15 a 11 Ptos.</td>
                              <td>ALTA</td>
                         </tr>
                         <tr>
                              <td>Mediana Dependencia Social – Riesgo Moderado</td>
                              <td>10 a 6 Ptos.</td>
                              <td>MEDIANA</td>
                         </tr>
                         <tr>
                              <td>Baja o Nula Dependencia Social – Riesgo Leve</td>
                              <td>5 a 1 Ptos.</td>
                              <td>BAJA</td>
                         </tr>
                    </table>  
               </fieldset>
			</td>
		</tr>
		<tr>
	     	<td>
	     	<? if($categorizaRiesgoSN != ""){?>
	     		<? 	if($validaEvaluacionsocial['ED_fecha']==""){
	     				if($categorizaRiesgoSN != ""){?>
							<input class="buttonGeneral" type="submit" name="btn_aceptar" value="Grabar" <?php if ( array_search(25, $permisos) != null ) { echo "enabled='enabled'"; }else{ echo "disabled='disabled'"; }  ?>  />
<?	     				}
					}else{
	     				if($validaEvaluacionsocial['ED_fecha']!=date('Y-m-d')){

	     				}else{ ?>
	     				<input class="buttonGeneral" type="submit" name="btn_aceptar" value="Grabar" <?php if ( array_search(25, $permisos) != null ) { echo "enabled='enabled'"; }else{ echo "disabled='disabled'"; }  ?>  />
	     		<? 		}
	     			}
	     		}?>
	        <input class="buttonGeneral" type="Button" value="Cancelar" onClick="window.location.href='<? echo"detalleCamaSN.php?HOSid=$id_cama&PACid=$id_paciente&desde=$desde"; ?>'; parent.GB_hide(); " >
	        </td>
		</tr>
	</table>
</form>
</body>
</html>
<?php ob_end_flush(); ?>