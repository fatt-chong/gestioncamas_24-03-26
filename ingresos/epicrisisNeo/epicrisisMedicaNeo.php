<?php

if (!isset($_SESSION)) {
	session_start();
}
$permisos = $_SESSION['permiso'];
if ( $_SESSION['MM_Username'] == null ) {
	$GoTo = "../../acceso/index.php";
	header(sprintf("Location: %s", $GoTo));
}

$usuario = $_SESSION['MM_Username'];
include "../../funciones/epicrisis_funciones.php";
if($medicoGC == '172 -   - SIN ASIGNAR -'){
	$medicoGC = '';
	}
mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');
mysql_select_db('paciente') or die('Cannot select database');

$sqlPaciente = mysql_query("SELECT * 
							FROM paciente 
							WHERE id = '$id_paciente'") or die("Error al seleccionar datos del pacientes ".mysql_error());
							
$arrayPaciente = mysql_fetch_array($sqlPaciente);
$nombreCompleto = $arrayPaciente['nombres']." ".$arrayPaciente['apellidopat']." ".$arrayPaciente['apellidomat'];
$rutPac = $arrayPaciente['rut'];
$fonoCont = $arrayPaciente['fono1'];
$direccionPac = $arrayPaciente['direccion'];
$diaFecha = cambiarFormatoFecha($arrayPaciente['fechanac']);

if($arrayPaciente['sexo'] == 'F'){
	$sexoPaciente = "Femenino";
	}else if($arrayPaciente['sexo'] == 'M'){
		$sexoPaciente = "Masculino";
		}else{
			$sexoPaciente = "Indeterminado";
			}

$inicio = $ing_paciente;
$termino = date('Y-m-d');

$cant_dias =intval((strtotime($termino) - strtotime($inicio))/86400) + 1;

mysql_select_db('acceso') or die('Cannot select database');

//ACTUALIZA ESTADO DE LA EPICRISIS
mysql_select_db('epicrisis') or die('Cannot select database');	

if(($abre == 1) and ($idEpicrisis)){
	$sqlAbre = "UPDATE epicrisismedica 
				SET epimedEstado = 0
				WHERE epimedId = $idEpicrisis";
	$queryAbre = mysql_query($sqlAbre) or die("ERROR AL ABRIR EPICRISIS ".mysql_error());
	}

//OBTIENE INFORMACION DE UNA EPICRISIS YA CREADA

$sqlEpicrisis = mysql_query("SELECT *
				FROM epicrisismedica
				WHERE epimedctaCte = '$ctaCte'");

$arrayEpicrisis = mysql_fetch_array($sqlEpicrisis);

$idEpicrisis = $arrayEpicrisis['epimedId'];
$diagEpicrisis = $arrayEpicrisis['epimedDiag'];
$epiEstado = $arrayEpicrisis['epimedEstado'];
$descFav = $arrayEpicrisis['descFav'];
$descIndica = $arrayEpicrisis['epimedIndica'];
$pesoIngreso = explode('.',$arrayEpicrisis['epimedPesoIn']);
$pesoEgreso = explode('.',$arrayEpicrisis['epimedPesoEg']);

if($idEpicrisis > 0){
	$existeEpi = 1;
	}else{
		$existeEpi = 0;
		}
						
//BUSCA EL CR DEL SERVICIO DONDE SE ENCUENTRA EL PACIENTE

$sqlCR = "SELECT
		camas.sscc.id,
		camas.sscc.servicio,
		acceso.cr.nombre
		FROM
		camas.sscc
		INNER JOIN acceso.cr ON camas.sscc.id_cr = acceso.cr.idcr
		WHERE 
		camas.sscc.id = $idServicio";
$queryCR = mysql_query($sqlCR) or die("Error al seleccionar los CR ".mysql_error());
$arrayCR = mysql_fetch_array($queryCR);

$nomCR = $arrayCR['nombre'];
$serv_paciente = $arrayCR['servicio'];		

//MUESTRA LAS OPCIONES DE CONTROLES

$sql_controles = mysql_query("SELECT * FROM control") or die("ERROR AL CARGAR LISTA DE CONTROLES". mysql_error());

//SELECCIONA LOS CONTROLES DE PEDIATRIA
if($idEpicrisis){
	$sqlControles = mysql_query("SELECT
					epimed_has_control.controlFecha,
					epimed_has_control.controlTipo
					FROM
					epimed_has_control
					WHERE
					epimed_has_control.epimedId = $idEpicrisis
					ORDER BY
					epimed_has_control.controlFecha ASC") or die("Error al seleccionar controles ingresados ".mysql_error());
					
	$a=1;
	while($arrayControles = mysql_fetch_assoc($sqlControles)){
		$controlfecha[$a] = $arrayControles['controlFecha'];
		$controltipo[$a] = $arrayControles['controlTipo'];
	$a++;
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Gestion de Camas Hospital Dr. Juan No&eacute; C.</title>

<link type="text/css" rel="stylesheet" href="../css/estilo.css" />
<link type="text/css" rel="stylesheet" href="../../../estandar/css/estiloBoton.css" />

<script src="../../../estandar/src/calendario/src/js/jscal2.js"></script>
<script src="../../../estandar/src/calendario/src/js/lang/es.js"></script>
<link rel="stylesheet" type="text/css" href="../../../estandar/src/calendario/src/css/jscal2.css"/>
<link rel="stylesheet" type="text/css" href="../../../estandar/src/calendario/src/css/border-radius.css"/>
<link rel="stylesheet" type="text/css" href="../../../estandar/src/calendario/src/css/steel/steel.css"/>
<link rel="stylesheet" type="text/css" href="../epicrisisDoc/autocompleta/jquery.autocomplete.css" />
<script type="text/javascript" src="../epicrisisDoc/autocompleta/jquery.js"></script>
<script type="text/javascript" src="../epicrisisDoc/autocompleta/jquery.autocomplete.js"></script>

<script src="../../../estandar/tinymce.v4/js/tinymce/tinymce.min.js"></script>
<script src="../../../estandar/tinymce.v4/js/tinymce/plugins/table/plugin.min.js"></script>
<script src="../../../estandar/tinymce.v4/js/tinymce/plugins/paste/plugin.min.js"></script>
<script src="../../../estandar/tinymce.v4/js/tinymce/plugins/spellchecker/plugin.min.js"></script>
<script>
	tinymce.init({selector:'textarea'});
	
</script>

<script type="text/javascript">
$().ready(function() {
	
	$("#medico").autocomplete("../epicrisisDoc/autocompleta/sqlMedicos.php", {
      width: 500,
      matchContains: true,
      selectFirst: false
    });
  });
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}

</script>
</head>
<script>
window.onload=function(){
	setInterval('getNumeroDeNits()',10);
	setInterval('verificaMedico()',10);
	
}
</script>

<body>
<?
$nombreCompleto = str_replace("�","n",$nombreCompleto);
$nombreCompleto = str_replace("�","N",$nombreCompleto);

//$serv_paciente = ereg_replace("[���]","i",$serv_paciente);


function limpiar_caracteres_especiales($s) {
	$s = ereg_replace("[����]","a",$s);
	$s = ereg_replace("[����]","A",$s);
	$s = ereg_replace("[���]","e",$s);
	$s = ereg_replace("[���]","E",$s);
	$s = ereg_replace("[���]","i",$s);
	$s = ereg_replace("[���]","I",$s);
	$s = ereg_replace("[����]","o",$s);
	$s = ereg_replace("[����]","O",$s);
	$s = ereg_replace("[���]","u",$s);
	$s = ereg_replace("[���]","U",$s);
	$s = str_replace("�","n",$s);
	$s = str_replace("�","N",$s);
	$s = str_replace(
        array("\\", "�", "�", "�", "-", "~",
             "#", "@", "|", "!", "\"",
             "�", "$", "%", "&", "/",
             "(", ")", "?", "'", "�",
             "�", "[", "^", "`", "]",
             "+", "}", "{", "�", "�",
             ">", "<", ";", ":"),
        '',
        $s);
	//para ampliar los caracteres a reemplazar agregar lineas de este tipo:
	//$s = str_replace("caracter-que-queremos-cambiar","caracter-por-el-cual-lo-vamos-a-cambiar",$s);
	return $s;
}

?>
<form name="epiMedica" id="epiMedica" method="post">
<input type="hidden" name="id_cama" value="<? echo $id_cama; ?>" />
<input type="hidden" name="nombrePaciente" value="<? echo limpiar_caracteres_especiales($nombreCompleto); ?>" />
<input type="hidden" name="id_paciente" value="<? echo $id_paciente; ?>" />
<input type="hidden" name="idServicio" value="<? echo $idServicio; ?>" />
<input type="hidden" name="ctaCte" value="<? echo $ctaCte; ?>" />
<input type="hidden" name="idEpicrisis" value="<? echo $idEpicrisis; ?>" />
<input type="hidden" name="prev_paciente" value="<? echo limpiar_caracteres_especiales($prev_paciente); ?>" />
<input type="hidden" name="serv_paciente" value="<? echo limpiar_caracteres_especiales($serv_paciente); ?>" />
<input type="hidden" name="rutPaciente" value="<? echo $arrayPaciente['rut']; ?>"  />
<input type="hidden" name="fichaPaciente" value="<? echo $arrayPaciente['nroficha']; ?>"  />
<input type="hidden" name="ing_paciente" value="<? echo $ing_paciente; ?>" />
<input type="hidden" name="fechaNac" value="<? echo htmlentities(calculoAMD($arrayPaciente['fechanac'])); ?>" />
<input type="hidden" name="cod_prev" value="<? echo $cod_prev; ?>"  />
<input type="hidden" name="generoPaciente" value="<? echo $sexoPaciente; ?>" />
<input type="hidden" name="multiRes" value="<? echo $multiRes; ?>" />
<input type="hidden" name="hospitaliza" value="<? echo $hospitaliza; ?>" />
<input type="hidden" name="nomCR" value="<? echo $nomCR; ?>" />
<input type="hidden" name="fecha_sep" value="<? echo $fecha_sep; ?>" />
<input type="hidden" name="epimedica" value="<? echo $epimedica; ?>" />

<table align="center">
	<tr>
		<td width="100%">
        <table >
        <tr>
            <td width="50"><img src="../../../equipos/Reportes/img/logo.jpg" width="126" height="99" /></td>
            <td width="561" align="left" class="titulocampo" >&nbsp;Servicio de Salud de Arica<br />&nbsp;Hospital en Red &quot;Dr. Juan No&eacute; C.&quot;</td>
            <td width="153" align="right" class="titulocampo" ><?php echo date('d-m-Y'); ?></td>
        </tr>
        <tr>
            <td colspan="3" align="center" class="titulo"><strong>EPICRISIS MEDICA<br />
              CENTRO DE RESPONSABILIDAD <? echo $nomCR; ?></strong>
            <div align="right"></div>
            </td>
          </tr>
                   
          <tr>
              <td colspan="3">
              <hr />
              </td>
          </tr>
          <tr>
              <td colspan="3">
              <fieldset><legend class="titulocampo">Antecedentes Personales</legend>
              <table width="890px">
              	<tr>
                    <td width="80" class="titulocampo">
                    
                
                    Nombre:
                    </td>
                    <td width="255" class="titulosSec" ><strong>&nbsp;<? echo $nombreCompleto; ?></strong></td>
                    <td class="titulocampo">N&deg; Ficha:</td>
                    <td class="titulosSec"><? echo $arrayPaciente['nroficha']; ?></td>
                    <td width="83">&nbsp;</td>
                    <td width="205">&nbsp;</td>
                    
                </tr>
                <tr>
                    <td class="titulocampo">Edad:
                    </td>
                    <td class="titulosSec"><? echo calculoAMD($arrayPaciente['fechanac'])?></td>
                    <td width="75" class="titulocampo">Rut:</td>
                    <td width="164" class="titulosSec"><? echo $rutPac; ?>-<? echo ValidaDVRut($rutPac); ?>
                    <input type="hidden" name="epiRut" id="epiRut" value="<? echo $rutPac; ?>" />
                    </td>
                    <td class="titulocampo">Fecha Nac:</td>
                    
                    <td class="titulosSec"><?= $diaFecha; ?></td>
                </tr>
                <tr>
                    
                    <input type="hidden" name="direccion" id="direccion" value="<? echo limpiar_caracteres_especiales($direccionPac); ?>" />
                    <td class="titulocampo">Genero:</td>
                    
                    <td class="titulosSec"><? echo $sexoPaciente; ?></td>
                </tr>
                 <tr>
                   <td class="titulocampo" >Madre:</td>
                   <td ><input type="text" name="madreNom" id="madreNom" value="<?= $arrayEpicrisis['epimedMadre']; ?>" /></td>
                   <td class="titulocampo" >Rut Madre:</td>   
                   <td colspan="3"><input type="text" name="madreRut" id="madreRut" maxlength="10" value="<?= $arrayEpicrisis['epimedRutMadre']; ?>" /></td>                                      
                </tr>
              </table>
              </fieldset>
              </td>
          </tr>
          
          <tr>
          	<td colspan="3">
            <fieldset>
            	<table width="100%">
                  <tr>
                    <td width="168" class="titulocampo">Fecha Ingreso:</td>
                    <? if($existeEpi == 0){ $fecha_real = substr($hospitaliza,0,10); $fechaI = cambiarFormatoFecha($fecha_real); }else{ $fechaI = cambiarFormatoFecha($arrayEpicrisis['epimedFechaIng']); }?>
                    <td width="162"><input style="width:75px" id="f_date" name="ingFecha" value="<? echo $fechaI; ?>" readonly="readonly"/><input type="Button" id="f_btn" value="&nbsp;" class="botonimagen"/></td>
                    <td width="118" class="titulocampo">Fecha Egreso:</td>
                    <? if($existeEpi == 0){ $fechaA = date('d-m-Y'); }else{ $fechaA = cambiarFormatoFecha($arrayEpicrisis['epimedFechaEgr']); }?>
                    <td width="158"><input style="width:75px" id="f_date1" name="altFecha" value="<? echo $fechaA; ?>" readonly="readonly"/><input type="Button" id="f_btn1" value="&nbsp;" class="botonimagen"/></td>
                    <td width="91" class="titulocampo">Dias Estadia:</td>
                    <td width="165" class="titulocampo"><span class="titulosSec">
                      <input style="width:35px" id="difDias" name="difDias" readonly="readonly" />
dias</span></td>
                 
                  </tr>
                  <tr>
                    <td width="168" class="titulocampo">Peso Ingreso:</td>
                    <? if($existeEpi == 0){ $fecha_real = substr($hospitaliza,0,10); $fechaI = cambiarFormatoFecha($fecha_real); }else{ $fechaI = cambiarFormatoFecha($arrayEpicrisis['epimedFechaIng']); }?>
                    <td width="162"><input type="text" name="pesoIngreso" id="pesoIngreso" size="10px" value="<?= $pesoIngreso[0]; ?>" maxlength="5" onKeyPress="return validaNumeros(event)" /></td>
                    <td width="118" class="titulocampo">Peso Egreso:</td>
                    <? if($existeEpi == 0){ $fechaA = date('d-m-Y'); }else{ $fechaA = cambiarFormatoFecha($arrayEpicrisis['epimedFechaEgr']); }?>
                    <td width="158"><input type="text" name="pesoEgreso" id="pesoEgreso" size="10px" value="<?= $pesoEgreso[0]; ?>" maxlength="5" onKeyPress="return validaNumeros(event)" /></td>
                                     
                  </tr>
                           
                  <tr>
                  	<td class="titulocampo">Condicion Egreso:</td>
                    <td >
                    <table width="86" border="0" class="titulosSec">
                      <tr>
                        <td><label>
                      <input type="radio" name="condEgreso" value="V" <? if ($arrayEpicrisis['epimedCond'] == 'V') { echo "checked='checked'" ; } ?> id="condEgreso" />
                      Vivo</label>
                      	</td>
                      </tr>
                      <tr>
                        <td><label>
                      <input type="radio" name="condEgreso" value="F" <? if ($arrayEpicrisis['epimedCond'] == 'F') { echo "checked='checked'" ; } ?> id="condEgreso" />
                      Fallecido</label>
                      	</td>
                      </tr>
                    </table>

                    </td>
                    
                    <td class="titulocampo">Vent. Mecanica:</td>
                    <td>
                    <table width="112" border="0" class="titulosSec">
                      <tr>
                        <td>
                        <label>
                      <input type="radio" name="ventMec" value="si" id="ventMec" <? if($arrayEpicrisis['epimedVent'] == 'si') { echo "checked='checked'" ; } ?> />
                      Si </label>
                      	<input type="text" size="2px" name="diasVentmec" id="diasVentmec" onKeyPress="return validaNumeros(event)" value="<?= $arrayEpicrisis['epimedVentDias']; ?>" />dias</td>
                      </tr>
                      <tr>
                        <td>
                        <label>
                      <input type="radio" name="ventMec" value="no" id="ventMec" <? if($arrayEpicrisis['epimedVent'] == 'no') { echo "checked='checked'" ; } ?> />
                      No</label>
                      	</td>
                      </tr>
                    </table>
                    </td>
                  </tr>
                  <tr>
                  	<td class="titulocampo">APGAR 1'</td>
                    <td><input type="text" name="apgar1" size="2px" onKeyPress="return validaNumeros(event)" maxlength="2" value="<?= $arrayEpicrisis['epimedApgar1']; ?>" /></td>
                    <td class="titulocampo">APGAR 5'</td>
                    <td><input type="text" name="apgar5" size="2px" onKeyPress="return validaNumeros(event)" maxlength="2" value="<?= $arrayEpicrisis['epimedApgar5']; ?>" /></td>
                  </tr>
                  
  				</table>
				</fieldset>
            </td>
          </tr>        
        </table>
   	  </td>
  </tr>
  <tr>
    <td>
      <fieldset>
        <legend class="titulocampo">EVOLUCION
        </legend>
        <table width="100%" >
          
          <tr>
            <td >
              <textarea name="evolucionEpi" id="evolucionEpi" cols="90" rows="4"><?= $arrayEpicrisis['epimedEvolucion']; ?></textarea>
              </td>
            </tr>
            
        </table>
        </fieldset>
        
      </td>
  </tr>
  <tr>
    <td>
      <fieldset>
        <legend class="titulocampo">DIAGNOSTICO</legend>
        
        <table width="100%" >
          
          <tr>
            <td >
            <select name="tipoRN" id="tipoRN">
            	<option value="RN PRE TERMINO" <? if($arrayEpicrisis['epimedRNtipo'] == 'RN PRE TERMINO'){ ?> selected="selected" <? } ?> >RN PRE TERMINO</option>
                <option value="RN TERMINO" <? if($arrayEpicrisis['epimedRNtipo'] == 'RN TERMINO'){ ?> selected="selected" <? } ?>>RN TERMINO</option>
                <option value="RN PORT TERMINO" <? if($arrayEpicrisis['epimedRNtipo'] == 'RN PORT TERMINO'){ ?> selected="selected" <? } ?>>RN PORT TERMINO</option>
            </select>
            <input type="text" size="3px" name="semanaRN" value="<?= $arrayEpicrisis['epimedRNsem']; ?>" maxlength="2" onKeyPress="return validaNumeros(event)" />
            <select name="edadGes" id="edadGes">
            	<option value="aeg" <? if($arrayEpicrisis['epimedRNEG'] == 'aeg'){ ?> selected="selected" <? } ?>>AEG</option>
                <option value="peg" <? if($arrayEpicrisis['epimedRNEG'] == 'peg'){ ?> selected="selected" <? } ?>>PEG</option>
                <option value="geg" <? if($arrayEpicrisis['epimedRNEG'] == 'geg'){ ?> selected="selected" <? } ?>>GEG</option>
            </select>
            </td>
            
          </tr>
          <tr>
            <td>
            	<table width="100%">
                	<tr>
                    	<td>
                        <input type="text" size="90px" name="diagnosticoEpi" id="diagnosticoEpi" value="<?= $arrayEpicrisis['epimedDiag'];?>" />
                        </td>
                    </tr>
                    <tr>
                    	<td>
                        <textarea name="otrodiagnosticoEpi" id="otrodiagnosticoEpi" cols="90" rows="4"><?= $arrayEpicrisis['epimedODiagn'];?></textarea></td>
                    </tr>
                    
                </table>
            </td>
            
          </tr>
                      
        </table>
        </fieldset>
        
      </td>
  </tr>
  <tr>
    <td>
      <fieldset>
        <legend class="titulocampo">INDICACIONES</legend>
        <table width="100%" >
          <tr>
            <td class="titulocampo">
            <textarea name="indicaEpi" id="indicaEpi" cols="90" rows="4"><?= $arrayEpicrisis['epimedIndica'];?></textarea>
            </td>
          </tr>
        </table>
        </fieldset>
      </td>
  </tr>
  <tr>
    <td colspan="3">
    <fieldset><legend class="titulocampo">Controles</legend>
    	<table>
                	<tr class="titulocampo">
                    	<td>Control 1</td>
                        <td>
                        <select name="control[1]">
                        	<option value="0">Seleccione...</option>
                            <? while($rsControles = mysql_fetch_assoc($sql_controles)){ 
								$idControl1 = $rsControles['id_control'];
								$nameControl1 = $rsControles['nom_control'];
							?>
                            <option value="<?= $idControl1; ?>" <? if($controltipo[1] == $idControl1){ ?> selected="selected" <? } ?> ><?= $nameControl1; ?></option>
                            <? } ?>
                        </select>
                        </td>
                        
                        <td><input style="width:75px" id="f_date2" name="fechacontrol[1]" value="<? if($controlfecha[1]){ echo cambiarFormatoFecha($controlfecha[1]); }?>" /><input type="Button" id="f_btn2" value="&nbsp;" class="botonimagen"/></td>
                    </tr>
                    <tr class="titulocampo">
                    	<td>Control 2</td>
                        <td>
                        <select name="control[2]">
                        	<option value="0">Seleccione...</option>
                            <? 
							mysql_data_seek($sql_controles,0);
							while($rsControles = mysql_fetch_assoc($sql_controles)){ 
								$idControl2 = $rsControles['id_control'];
								$nameControl2 = $rsControles['nom_control'];
							?>
                            <option value="<?= $idControl2; ?>" <? if($controltipo[2] == $idControl2){ ?> selected="selected" <? } ?>><?= $nameControl2; ?></option>
                            <? } ?>
                        </select>
                        </td>
                        
                        <td><input style="width:75px" id="f_date3" name="fechacontrol[2]" value="<? if($controlfecha[2]){ echo cambiarFormatoFecha($controlfecha[2]); }?>" /><input type="Button" id="f_btn3" value="&nbsp;" class="botonimagen"/></td>
                    </tr>
                    <tr class="titulocampo">
                    	<td>Control 3</td>
                        <td>
                        <select name="control[3]">
                        	<option value="0">Seleccione...</option>
                            <? 
							mysql_data_seek($sql_controles,0);
							while($rsControles = mysql_fetch_assoc($sql_controles)){ 
								$idControl3 = $rsControles['id_control'];
								$nameControl3 = $rsControles['nom_control'];
							?>
                            <option value="<?= $idControl3; ?>" <? if($controltipo[3] == $idControl3){ ?> selected="selected" <? } ?>><?= $nameControl3; ?></option>
                            <? } ?>
                        </select>
                        </td>
                        
                        <td><input style="width:75px" id="f_date4" name="fechacontrol[3]" value="<? if($controlfecha[3]){ echo cambiarFormatoFecha($controlfecha[3]); }?>" /><input type="Button" id="f_btn4" value="&nbsp;" class="botonimagen"/></td>
                    </tr>
                    <tr class="titulocampo">
                    	<td>Control 4</td>
                        <td>
                        <select name="control[4]">
                        	<option value="0">Seleccione...</option>
                            <? 
							mysql_data_seek($sql_controles,0);
							while($rsControles = mysql_fetch_assoc($sql_controles)){ 
								$idControl4 = $rsControles['id_control'];
								$nameControl4 = $rsControles['nom_control'];
							?>
                            <option value="<?= $idControl4; ?>" <? if($controltipo[4] == $idControl4){ ?> selected="selected" <? } ?>><?= $nameControl4; ?></option>
                            <? } ?>
                        </select>
                        </td>
                        
                        <td><input style="width:75px" id="f_date5" name="fechacontrol[4]" value="<? if($controlfecha[4]){ echo cambiarFormatoFecha($controlfecha[4]); }?>" /><input type="Button" id="f_btn5" value="&nbsp;" class="botonimagen"/></td>
                    </tr>
                </table>
                </fieldset>
    </td>
  </tr>
  <tr>
  	<td>
    	<table>
        	<tr class="titulocampo">
                    <td >Medico que da Alta:</td>
                    <td colspan="5">
                    <input name="medico" id="medico" type="text" size="80" value="<? if($arrayEpicrisis['epimedMedico']){ echo $arrayEpicrisis['epimedMedico']; }else if($medico != ""){ echo $medico; }else{ echo $medicoGC; } ?>" />
                    <input name="idmedico" id="idmedico" type="hidden" size="80" value=""/>
                    <input name="idUsuario" id="idUsuario" type="hidden" size="80" value="<? echo $usuario; ?>"/></td>
                  </tr>
        </table>
    </td>
  </tr>
  <tr>
  	<td>
    	<table align="center">
        	<tr>
            	<td>
                                
                <input type="button" name="salir" value="Salir" onclick="window.location.href='<? echo "../altapaciente.php?id_cama=$id_cama"; ?>'" />
               
                </td>
                <td><input type="button" name="btn_grabar3" value="Grabar" onclick="document.epiMedica.action='grabaEpicrisisMedNeo.php';document.epiMedica.submit();" /></td>
                
                <td><input type="button" name="btn_imprimir" value="Cerrar Epicrisis" onclick="validar_medico_neo();" /></td>
                
            </tr>
        </table>
    </td>
  </tr>
</table>
</form>


</body>
<script type="text/javascript">
//<![CDATA[
        
          var cal = Calendar.setup({
              onSelect: function(cal) { cal.hide() }
          });
          
		  cal.manageFields("f_btn", "f_date", "%d-%m-%Y");
		  cal.manageFields("f_btn1", "f_date1", "%d-%m-%Y");
		  cal.manageFields("f_btn2", "f_date2", "%d-%m-%Y");
		  cal.manageFields("f_btn3", "f_date3", "%d-%m-%Y");
		  cal.manageFields("f_btn4", "f_date4", "%d-%m-%Y");
		  cal.manageFields("f_btn5", "f_date5", "%d-%m-%Y");
		 
      
        //]]>
</script>
</html>