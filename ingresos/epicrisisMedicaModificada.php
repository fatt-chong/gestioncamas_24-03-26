<? session_start();

$idPaciente = $_REQUEST['id_paciente'];
$idCama = $_REQUEST['id_cama'];
$posicion = $_REQUEST['posicion'];
$usuario = $_SESSION['MM_Username'];
$ctaCte_epicrisis = $_REQUEST['ctaCte'];
$idServicio = $_GET['idServicio'];


$id_cama = $_GET['id_cama'];
//$ctaCte = $_GET['ctaCte'];
//$id_paciente = $_GET['id_paciente'];
//$idServicio = $_GET['idServicio'];
$prev_paciente = $_GET['prev_paciente'];
$cod_prev =$_GET['cod_prev'];
$ing_paciente =$_GET['ing_paciente'];
$multiRes =$_GET['multiRes'];
$hospitaliza =$_GET['hospitaliza'];
$medicoGC =$_GET['medicoGC'];
$cama_sn =$_GET['cama_sn'];

$graba=$_GET['graba'];
$idEpicrisis=$_GET['idEpicrisis'];
$id_cama=$_GET['id_cama'];
$ctaCte=$_GET['ctaCte'];
$id_paciente=$_GET['id_paciente'];
$idServicio=$_GET['idServicio'];
$prev_paciente=$_GET['prev_paciente'];
$cod_prev=$_GET['cod_prev'];
$ing_paciente=$_GET['ing_paciente'];
$cama_sn=$_GET['cama_sn'];
$hospitaliza=$_GET['hospitaliza'];



require_once('clases/Conectar.inc'); 
$objConectar = new Conectar; 
$link = $objConectar->db_connect();

require_once('clases/Camas.inc'); 
$objCamas = new Camas;

include "../funciones/epicrisis_funciones.php";

/*
echo "<br>";
echo "idCama".$idCama;
echo "<br>";
echo "idServicio".$idServicio;
echo "<br>";
echo "idPaciente".$idPaciente;
*/
$sqlCamas = $objCamas->infoCama($link,$ctaCte_epicrisis);
$RSCamas = mysql_fetch_assoc($sqlCamas);
$multiRes = $RSCamas['multiresSN'];
$fechaHosp = substr($RSCamas['hospitalizadoSN'], 0,10);

require_once('clases/Servicios.inc'); 
$objServicios = new Servicios;
$RScr = $objServicios->nombreCR($link,$idServicio); 
$nomCR = $RScr['nombre'];
$serv_paciente = $RScr['servicio'];

require_once('clases/Epicrisis.inc'); 
$objEpicrisis = new Epicrisis; 

require_once('clases/Util.inc'); 
$objUtil = new Util;

require_once("clases/Paciente.inc"); 
$objPaciente = new Paciente;

require_once("clases/Pabellon.inc"); 
$objPabellon = new Pabellon;

require_once("../../agenda/clases/Especialidad.inc"); 
$objEspecialidad = new Especialidad;

$RSEspecialidad = $objEspecialidad->listarTodasLasEspecialidades($link);
$RSPaciente = $objPaciente->obtenerPaciente($link,$idPaciente);
//$ctaCte_epicrisis = $RSPaciente['cta_cte'];
$anioPac = $objUtil->soloanios($RSPaciente['fechanac']);

$sqlTraslado = $objEpicrisis->traslados($link);
$sqlHogares = $objEpicrisis->hogares($link,$idServicio);
$sqlEduca = $objEpicrisis->educaciones($link,$idServicio);
$sqlGes = $objEpicrisis->gesPrograma($link);
$sqlControles = $objEpicrisis->controles($link);
$sqlFavoritos = $objEpicrisis->listaFavorito($link,$usuario);
$RSEpicrisis = $objEpicrisis->buscaEpicrisisMedica($link,$ctaCte_epicrisis);
$idEpicrisis = $RSEpicrisis['epimedId'];
$favoritoSelect = $RSEpicrisis['idFav'];


if(($idServicio==7) && ($idEpicrisis)){
  $rsControles = $objEpicrisis->buscaControles($link,$idEpicrisis);
  $a=1;
  while($arrayControles = mysql_fetch_assoc($rsControles)){
    $controlfecha[$a] = $objUtil->fechaNormal($arrayControles['controlFecha']);
    $controltipo[$a] = $arrayControles['controlTipo'];
    $a++;
  }
}


if($RSEpicrisis['epimedIndica']){
  $textoFormato = $RSEpicrisis['epimedIndica'];
}else{
    $textoFormato = '<p ><strong>1.Evolucion y Resultado :</strong> &nbsp; </p><p><br /><hr></p><p ><strong>2.Indicaciones :</strong> &nbsp; </p><br /><br /><hr><p ><strong>3.Observaciones :</strong> &nbsp; </p><br /><br />';
}


if($idEpicrisis>0){
  $fechaIngreso = $objUtil->fechaNormal($RSEpicrisis['epimedFechaIng']);
  $fechaEgreso = $objUtil->fechaNormal($RSEpicrisis['epimedFechaEgr']);
  $RSeducaciones = $objEpicrisis->educacionesSelect($link,$idEpicrisis);
  $indicaciones = $RSEpicrisis['epienfIndica'];
}else{
  $fechaIngreso = $objUtil->fechaNormal($fechaHosp);
  $fechaEgreso = date("d-m-Y");
}

  
$RSPabellon = $objPabellon->buscaIntervencion($link,$idPaciente,$fechaHosp);

function limpiar_caracteres_especiales($s) {
  $s = ereg_replace("[áàâãª]","a",$s);
  $s = ereg_replace("[ÁÀÂÃ]","A",$s);
  $s = ereg_replace("[éèê]","e",$s);
  $s = ereg_replace("[ÉÈÊ]","E",$s);
  $s = ereg_replace("[íìî]","i",$s);
  $s = ereg_replace("[ÍÌÎ]","I",$s);
  $s = ereg_replace("[óòôõ]","o",$s);
  $s = ereg_replace("[ÓÒÔÕ]","O",$s);
  $s = ereg_replace("[úùû]","u",$s);
  $s = ereg_replace("[ÚÙÛ]","U",$s);
  $s = str_replace("ñ","n",$s);
  $s = str_replace("Ñ","N",$s);
  $s = str_replace(
        array("\\", "¨", "º", "°", "-", "~",
             "#", "@", "|", "!", "\"",
             "·", "$", "%", "&", "/",
             "(", ")", "?", "'", "¡",
             "¿", "[", "^", "`", "]",
             "+", "}", "{", "¨", "´",
             ">", "<", ";", ":"),
        '',
        $s);
  return $s;
}
?>
<link href="../../gestionCamas2/include/maestro.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../../gestionCamas2/include/jquery/css/custom/jquery-ui-1.10.3.custom.css">
<link rel="stylesheet" href="../../gestionCamas2/include/jquery.timeEntry/jquery.timeentry.css">
<link rel="stylesheet" href="../../gestionCamas2/include/jquery.combogrid-1.6.3/resources/css/smoothness/jquery.ui.combogrid.css">

<script src="../../estandar/jquery/js/jquery-1.9.1.js"></script>
<script src="../../estandar/jquery/js/jquery-ui-1.10.3.custom.js"></script>
<script src="../../estandar/jquery/development-bundle/ui/i18n/jquery.ui.datepicker-es.js"></script>
<script type="text/javascript" src="../../gestionCamas2/controlador/controlador_maestro.js?v=1.0.7"></script>

<script type="text/javascript" src="../../gestionCamas2/include/funciones.js?v=1.0.8"></script>
<script src="../../gestionCamas2/include/jquery.combogrid-1.6.3/resources/plugin/jquery.ui.combogrid-1.6.3.js"></script>
<script type="text/javascript" src="../../gestionCamas2/include/tinymce/jscripts/tiny_mce/tiny_mce.js" ></script>
<script type="text/javascript" src="../../gestionCamas2/include/jquery/jquery-ui-1.10.1.custom.min.js"></script> <!-- .min.js Agregado por EGS -->
<script type="text/javascript" src="eventos/eventos_epicrisis_medica.js?v=1.0.7"></script>

<script type="text/javascript">

$("#nuevodiagnostico").button();
$("#Agregargrilla").button();
$("#agr_fav").button();
$("#act_fav").button();

function nuevosdiagnosticos(){
  var diagnostic = String($('#diagnosticos').val());
  diagnostic = diagnostic.replace('\53', "más");
  diagnostic = diagnostic.replace('\46', "y");
  if(diagnostic!="0"){
    cargarContenido('dialog/masdiagnosticosmedicos.php','accion=1&diagnosticolisto='+diagnostic+'&ctaCte_epicrisis=<?=$ctaCte_epicrisis?>','#masdiagnosticos');
    $('#diagnosticos').val('');
  }else{
    cargarContenido('dialog/masdiagnosticosmedicos.php','accion=0&ctaCte_epicrisis=<?=$ctaCte_epicrisis?>','#masdiagnosticos');
  }
}
function nuevagrilla(){
  var especialidad = String($('#especialidad').val());
  var semanas = String($('#periodo').val());
  if(especialidad!="0"){
    if(semanas!="0"){
      cargarContenido('dialog/mascontroles.php',$('#frm_epicrisis_medica').serialize()+'&accion=1&ctaCte_epicrisis=<?=$ctaCte_epicrisis?>','#masgrilla');
    }else{
      mensajeUsuario('warning','Egreso','Falta de información,<br/>Debe ingresar el periodo.');
      cargarContenido('dialog/mascontroles.php','accion=0&ctaCte_epicrisis=<?=$ctaCte_epicrisis?>','#masgrilla');
    }
  }else{
    mensajeUsuario('warning','Egreso','Falta de información,<br/>Debe ingresar la especialidad.');
    cargarContenido('dialog/mascontroles.php','accion=0&ctaCte_epicrisis=<?=$ctaCte_epicrisis?>','#masgrilla');
  }
  $('#periodo option:eq(0)').prop('selected', true);
   $("#periodo").attr('disabled', 'disabled');
   $('#especialidad option:eq(0)').prop('selected', true);
}
</script>
<script>
 $(document).ready(function(){
  cargarContenido('dialog/masdiagnosticosmedicos.php','accion=0&ctaCte_epicrisis=<?=$ctaCte_epicrisis?>','#masdiagnosticos');
  cargarContenido('dialog/mascontroles.php','accion=0&ctaCte_epicrisis=<?=$ctaCte_epicrisis?>','#masgrilla');
})
</script>

<form name="frm_epicrisis_medica" id="frm_epicrisis_medica" method="POST">
<input type="hidden" name="id_cama" id="id_cama" value="<? echo $id_cama; ?>" />
<input type="hidden" name="idPaciente" id="idPaciente" value="<?= $idPaciente; ?>" />
<input type="hidden" name="cod_prevision" id="cod_prevision" value="<?= $RSPaciente['prevision'];?>" />
<input type="hidden" name="idCama" id="idCama" value="<?= $idCama; ?>" />
<input type="hidden" name="ctaCte" id="ctaCte" value="<?= $ctaCte_epicrisis; ?>" />
<input type="hidden" name="idServicio" id="idServicio" value="<?= $idServicio; ?>" />
<input type="hidden" name="idEpicrisis" id="idEpicrisis" value="<?= $idEpicrisis; ?>" />
<input type="hidden" name="posicionX" id="posicionX" value="<?= $posicion; ?>" />
<input type="hidden" name="nomCR" id="nomCR" value="<?= $nomCR; ?>" />
<input type="hidden" name="fechaHosp" id="fechaHosp" value="<?= $fechaHosp; ?>" />
<input type="hidden" name="edadPac" id="edadPac" value="<?= $anioPac; ?>" />
<input type="hidden" name="nombrePaciente" id="nombrePaciente" value="<? echo limpiar_caracteres_especiales($RSPaciente[nombre_completo]); ?>" />
<input type="hidden" name="fichaPaciente" id="fichaPaciente" value="<?=$RSPaciente[nroficha]; ?>"  />
<input type="hidden" name="generoPaciente" id="generoPaciente" value="<?=$RSPaciente[sexo]; ?>" />
<input type="hidden" name="serv_paciente" value="<?=$serv_paciente; ?>" />
<input type="hidden" name="multiRes" value="<?=$multiRes; ?>" />
<input type="hidden" name="epimedica" value="<?=$epimedica; ?>" />

<table  align="center" class="titulocampo" width="100%">
  <tr>
    <td>
      <table  width="100%" class="titulocampo">
        <tr>
          <td width="30%" ><img src="img/logo.jpg" width="250" height="125" /></td>
          <td width="40%" align="center"><strong>EPICRISIS MEDICA Y CARNE DE ALTA <br />CENTRO DE RESPONSABILIDAD <br /><?= $nomCR; ?><br /></strong></td>
          <td width="30%" align="right">Hoy:<?php echo date('d-m-Y'); ?></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<fieldset>
  <legend class="estilo1">Antecedentes Personales</legend>
    <table  class="titulocampo">
      <tr>
        <td width="80">Nombre:</td>
        <td width="337" ><?= $RSPaciente['nombre_completo']; ?></td>
        <td width="69" >Rut:</td>
        <td width="270" ><?= $RSPaciente['rut']."-".$objUtil->generaDigito($RSPaciente['rut']); ?><input type="hidden" name="rutPac" id="rutPac" value="<?= $RSPaciente['rut']; ?>"></td>
      </tr>
      <tr>
        <td >N&deg; Ficha</td>
        <td ><?= $RSPaciente['nroficha']; ?></td>
        <td >Prevision:</td>
        <td ><?= $RSPaciente['nom_prevision']; ?><input type="hidden" name="nomPrevision" id="nomPrevision" value="<?= $RSPaciente['nom_prevision']; ?>" /></td>
      </tr>
      <tr>
        <td >Direccion:            </td>
        <td ><?= $RSPaciente['direccion']; ?><input type="hidden" name="direccion" id="direccion" value="<? echo limpiar_caracteres_especiales($RSPaciente[direccion]); ?>" /></td>
        <td >Genero:</td>
        <td ><?= $RSPaciente['sexo']; ?></td>
      </tr>
      <tr>
        <td >Edad:            </td>
        <td ><?= $anioPac; ?></td>
        <td >Servicio:</td>
        <td ><?= $RSPaciente['servicio']; ?><input type="hidden" name="nomServicio" id="nomServicio" value="<?= $RSPaciente['servicio']; ?>" /></td>
      </tr>
      <tr>
        <td >Fecha Nac.: </td>
        <td ><?= $RSPaciente['fechanac']; ?><input type="hidden" name="fechaNac" id="fechaNac" value="<?= $RSPaciente['fechanac']; ?>" /></td>
        <td >Fono :            </td>
        <td colspan="3" ><input size="10" type="text" id="fonoCont" name="fonoCont" value="<?= $RSPaciente['fono1']; ?>" /></td>
      </tr>
    </table>
</fieldset>
<fieldset>
  <legend class="estilo1">Antecedentes de Hospitalizacion</legend>
    <table  class="titulocampo">
      <tr>
        <td width="120" >Fecha Ingreso:</td>
        <td width="128"><input style="width:75px" id="ingFecha" name="ingFecha" value="<?= $fechaIngreso; ?>"/></td>
        <td width="104" >Fecha Egreso:</td>
        <td width="123"><input style="width:75px" id="altFecha" name="altFecha" value="<?= $fechaEgreso; ?>" /></td>
        <td width="91" >Dias Estada:</td>
        <td colspan="2" width="98" ><span ><input style="width:35px" id="difDias" name="difDias" readonly="readonly"/>dias</span></td>
      </tr>
<? if($idServicio == 7){ ?>
      <tr>
        <td >Peso Ingreso: </td>
        <td><input size="10" type="text" name="pesoNac" value="<?= $RSEpicrisis['epimedPesoIn']?>" id="pesoNac" /></td>
        <td >Peso Egreso: </td>
        <td><input size="10" type="text" name="pesoAlta" value="<?= $RSEpicrisis['epimedPesoEg']?>" id="pesoAlta" /></td>
      </tr>
<? } ?>
      <tr>
        <td >Destino:</td>
        <td>
          <select name="destinoPaciente" id="destinoPaciente" >
            <option value="">Seleccione</option>
            <option value="1" <? if($RSEpicrisis['epimedDestino']==1){ ?> selected="selected" <? } ?>>Domicilio</option>
            <option value="2" <? if($RSEpicrisis['epimedDestino']==2){ ?> selected="selected" <? } ?>>Traslado</option>
            <option value="3" <? if($RSEpicrisis['epimedDestino']==3){ ?> selected="selected" <? } ?>>CONIN</option>
            <option value="5" <? if($RSEpicrisis['epimedDestino']==5){ ?> selected="selected" <? } ?>>Anatomia Patologica</option>
            <option value="6" <? if($RSEpicrisis['epimedDestino']==6){ ?> selected="selected" <? } ?>>Servicio Medico Legal</option>
            <option value="4" <? if($RSEpicrisis['epimedDestino']==4){ ?> selected="selected" <? } ?>>Otros</option>
          </select>
        </td>
        <td >Traslado:</td>
        <td colspan="4">
          <select name="trasladoPaciente" id="trasladoPaciente" disabled="disabled">
            <option value="">Seleccione...</option> 
<? while($arrayTraslado = mysql_fetch_assoc($sqlTraslado)){
    $idTraslado = $arrayTraslado['idcentro'];
    $nomTraslado = $arrayTraslado['nombre'];
?>  
            <option value="<? echo $idTraslado; ?>" <? if($RSEpicrisis['epimedDestinodet']==$idTraslado){ ?> selected="selected" <? } ?>><? echo $nomTraslado?></option>  
<? } ?>
          </select><br />
          <select name="hogarPaciente" id="hogarPaciente" disabled="disabled">
            <option value="">Seleccione...</option> 
<? while($arrayHogares = mysql_fetch_assoc($sqlHogares)){
    $idHogar = $arrayHogares['hogarId'];
    $nomHogar = $arrayHogares['hogarNom'];
?>  
            <option value="<? echo $idHogar; ?>" <? if($RSEpicrisis['epimedDestinodet2']==$idHogar){ ?> selected="selected" <? } ?>><? echo $nomHogar?></option>  
<? } ?>
          </select>
        </td>
      </tr>
<? if($idServicio == 7){ ?>
      <tr>
        <td>Clasificacion Nutricional:</td>
        <td>
          <select name="tipoNutri">
            <option value="0">Seleccione...</option>
            <option value="2" <? if($RSEpicrisis['epimedNutricion'] == 2){ echo "selected"; } ?>>Obeso</option>
            <option value="5" <? if($RSEpicrisis['epimedNutricion'] == 5){ echo "selected"; } ?>>Sobrepeso</option>
            <option value="1" <? if($RSEpicrisis['epimedNutricion'] == 1){ echo "selected"; } ?>>Eutrofico</option>
            <option value="3" <? if($RSEpicrisis['epimedNutricion'] == 3){ echo "selected"; } ?>>Riesgo</option>
            <option value="4" <? if($RSEpicrisis['epimedNutricion'] == 4){ echo "selected"; } ?>>Desnutrido</option>
          </select>
        </td>
      </tr>
<? } ?>
      <tr>
        <td>Condicion Egreso:</td>
        <td>
          <p>
            <label>
              <input type="radio" name="condEgreso" value="V" <? if ($RSEpicrisis['epimedCond'] == 'V') { echo "checked='checked'" ; } ?> id="condEgreso" />Vivo
            </label>
            <br />
            <label>
              <input type="radio" name="condEgreso" value="F" <? if ($RSEpicrisis['epimedCond'] == 'F') { echo "checked='checked'" ; } ?> id="condEgreso" />Fallecido
            </label>
            <br />
          </p>
        </td>
      </tr>
<? if($idServicio == 7){ ?>
      <tr>
        <td>GES:</td>
        <td colspan="5">
          <label>
            <input type="radio" name="opcionGes" value="si" id="opcionGes"  <? if ($RSEpicrisis['epimedGes'] == 'si') { echo "checked='checked'" ; } ?> />Si
          </label>
          <label>
            <input type="radio" name="opcionGes" value="no" id="opcionGes" <? if ($RSEpicrisis['epimedGes'] == 'no') { echo "checked='checked'" ; } ?>  />No
          </label>
          <br />
          <select name="tiposGes" id="tiposGes">
            <option value="0">Seleccione...</option>
<? while($rsGes = mysql_fetch_assoc($sqlGes)){ 
    $idGes = $rsGes['subprogCod'];
    $nomGes = $rsGes['subprogNombre'];
?>
            <option value="<?= $idGes; ?>" <? if($RSEpicrisis['epimedGesNom']==$idGes){ ?> selected="selected" <? } ?>><?= $nomGes; ?></option>
<? } ?>
          </select>
        </td>
      </tr>
<? } ?>
  </table>
</fieldset>
<fieldset>
  <legend class="estilo1">Diagnosticos</legend>
    <table  width="100%" class="titulocampo">
      <tr>
        <td >Diagnostico:</td>
        <td>
          <input name="diagnosticos" id="diagnosticos" type="text" size="80" value="<?= $RSEpicrisis['epimedDiag']; ?>"/>
          <input type="button" id="nuevodiagnostico" name="nuevodiagnostico" onclick="nuevosdiagnosticos();" value="+">
        </td>
      </tr>
      <tr>
        <td colspan="2"><div id="masdiagnosticos" name="masdiagnosticos"></div></td>
      </tr>
      <tr>
        <td>Fundamento:</td>
        <td colspan="5"><input name="fundamentos" id="fundamentos" type="text" size="80" value="<? if($RSEpicrisis['epimedFund']){ echo $RSEpicrisis['epimedFund'];} else{ echo $fundamentos; } ?>"/></td>
      </tr>
      <tr>
        <td >Medico que da Alta:</td>
        <td colspan="5">
          <input name="medico_nom" id="medico_nom" type="text" size="80" value="<?= $RSEpicrisis['epimedMedico']; ?>"/>
          <input name="medico_id" id="medico_id" type="hidden" size="80" value="<?=$RSEpicrisis['epimedIdMedico'];?>" />
          <input name="idUsuario" id="idUsuario" type="hidden" size="80" value="<? echo $usuario; ?>"/>
        </td>
      </tr>
    </table>
  </fieldset>
<div id="divcontrolesespecialidad" <? if ($RSEpicrisis['epimedCond'] == 'F'){?> hidden <?}?>>
<fieldset>
  <legend class="estilo1">Controles con Especialistas</legend>
    <table class="titulocampo" width="100%">
      <tr>
        <td><input type="checkbox" name="controlEspecialidad" id="controlEspecialidad" <? if($RSEpicrisis['epimedControlEspecialista']=="1"){echo "checked='checked'" ;}?>>Control con especialista</td>
      </tr>
    </table>
    <table  id="grilla" hidden="true" class="titulocampo" width="100%">
      <tr>
        <td>Especialidad</td>
        <td>
          <select name="especialidad" id="especialidad" onchange="activatiempo()">
            <option value="0">Seleccione...</option>
<? while($arrayEspecialidad = mysql_fetch_assoc($RSEspecialidad)){?>
            <option value="<?=$arrayEspecialidad['ESPcodigo']?>"><?=$arrayEspecialidad["ESPdescripcion"]?></option>
<? }?>
          </select>
        </td>
        <td>Periodo de control:</td>
        <td>
          <select name="periodo" id="periodo" class="casilla_100" disabled="disabled" onchange="nuevagrilla();">
            <option value="0">Seleccione...</option>
            <option value="1" <? if($RScita['CITperiodo'] == 1){ echo "selected";}?>>1 Semana</option>
            <option value="2" <? if($RScita['CITperiodo'] == 2){ echo "selected";}?>>2 Semanas</option>
            <option value="3" <? if($RScita['CITperiodo'] == 3){ echo "selected";}?>>3 Semanas</option>
            <option value="4" <? if($RScita['CITperiodo'] == 4){ echo "selected";}?>>1 Mes</option>
            <option value="8" <? if($RScita['CITperiodo'] == 8){ echo "selected";}?>>2 Meses</option>
            <option value="12" <? if($RScita['CITperiodo'] == 12){ echo "selected";}?>>3 Meses</option>
            <option value="16" <? if($RScita['CITperiodo'] == 16){ echo "selected";}?>>4 Meses</option>
            <option value="20" <? if($RScita['CITperiodo'] == 20){ echo "selected";}?>>5 Meses</option>
            <option value="24" <? if($RScita['CITperiodo'] == 24){ echo "selected";}?>>6 Meses</option>
          </select>
        </td>
        <!-- <td><input type="button" name="Agregargrilla" id="Agregargrilla" onclick="nuevagrilla();" value="+"></td> -->
      </tr>
      <tr>
        <td colspan="5"><div id="masgrilla" name="masgrilla"></div></td>
      </tr>
    </table>
</fieldset>
</div>
<? if(mysql_num_rows($RSPabellon) > 0){ ?>
<fieldset>
  <legend class="estilo1">Intervenciones</legend>
    <table  width="717" class="titulocampo">
<? while($arrayPabellon = mysql_fetch_array($RSPabellon)){ 
    $ciruCod = $arrayPabellon['ciruCod']; 
    if($arrayPabellon['ciruEpicrisis'] <> ''){
      $operacion = $arrayPabellon['ciruEpicrisis'];
    }else{
      $operacion = $arrayPabellon['ciruInter1Glosa'];
    } 
?>
      <tr class="titulocampo">
        <td width="53">Fecha: </td>
        <td width="228" class="titulosSec">&nbsp; <? echo $arrayPabellon['ciruFecha']." ".$arrayPabellon['ciruHora']; ?></td>
        <td width="66">Cirujano: </td>
        <td width="350" class="titulosSec">&nbsp; <? echo $arrayPabellon['mpNombre']; ?></td>
      </tr>
      <tr>
        <td width="53">Op: </td>
        <td colspan="3" width="228" class="titulosSec">&nbsp;<input name="operacion[<? echo $ciruCod; ?>]" value="<?= $operacion; ?>" size="100" /></td>
      </tr>
<? } ?>
    </table>
</fieldset>
<? } 
if($idServicio == 7){  ?>
<fieldset><legend class="estilo1">Controles</legend>
  <table  class="titulocampo">
    <tr class="titulocampo">
      <td>Control 1</td>
      <td>
        <select name="control[1]" id="control[1]">
          <option value="0">Seleccione...</option>
<? while($rsControles = mysql_fetch_assoc($sqlControles)){ 
    $idControl1 = $rsControles['id_control'];
    $nameControl1 = $rsControles['nom_control'];
?>
          <option value="<?= $idControl1; ?>" <? if($controltipo[1] == $idControl1){ ?> selected="selected" <? } ?> ><?= $nameControl1; ?></option>
<? } ?>
        </select>
      </td>
      <td><input style="width:75px" id="fechacontrol[1]" name="fechacontrol[1]" value="<? if($controlfecha[1]){ echo $controlfecha[1]; }?>" class="fechaControl1" /></td>
    </tr>
    <tr class="titulocampo">
      <td>Control 2</td>
      <td>
        <select name="control[2]" id="control[2]">
          <option value="0">Seleccione...</option>
<? mysql_data_seek($sqlControles,0);
  while($rsControles = mysql_fetch_assoc($sqlControles)){ 
    $idControl2 = $rsControles['id_control'];
    $nameControl2 = $rsControles['nom_control'];
?>
          <option value="<?= $idControl2; ?>" <? if($controltipo[2] == $idControl2){ ?> selected="selected" <? } ?>><?= $nameControl2; ?></option>
<? } ?>
        </select>
      </td>
      <td><input style="width:75px" id="fechacontrol[2]" name="fechacontrol[2]" value="<? if($controlfecha[2]){ echo $controlfecha[2]; }?>" class="fechaControl2"/></td>
    </tr>
    <tr class="titulocampo">
      <td>Control 3</td>
      <td>
        <select name="control[3]" id="control[3]">
          <option value="0">Seleccione...</option>
<? mysql_data_seek($sqlControles,0);
  while($rsControles = mysql_fetch_assoc($sqlControles)){ 
    $idControl3 = $rsControles['id_control'];
    $nameControl3 = $rsControles['nom_control'];
?>
          <option value="<?= $idControl3; ?>" <? if($controltipo[3] == $idControl3){ ?> selected="selected" <? } ?>><?= $nameControl3; ?></option>
<? } ?>
        </select>
      </td>
      <td><input style="width:75px" id="fechacontrol[3]" name="fechacontrol[3]" value="<? if($controlfecha[3]){ echo $controlfecha[3]; }?>" class="fechaControl3" /></td>
    </tr>
    <tr class="titulocampo">
      <td>Control 4</td>
      <td>
        <select name="control[4]" id="control[4]">
          <option value="0">Seleccione...</option>
<? mysql_data_seek($sqlControles,0);
  while($rsControles = mysql_fetch_assoc($sqlControles)){ 
    $idControl4 = $rsControles['id_control'];
    $nameControl4 = $rsControles['nom_control'];
?>
          <option value="<?= $idControl4; ?>" <? if($controltipo[4] == $idControl4){ ?> selected="selected" <? } ?>><?= $nameControl4; ?></option>
<? } ?>
        </select>
      </td>
      <td><input style="width:75px" id="fechacontrol[4]" name="fechacontrol[4]" value="<? if($controlfecha[4]){ echo $controlfecha[4]; }?>" class="fechaControl4" /></td>
    </tr>
  </table>
</fieldset>
<? }?>
<fieldset>
  <legend class="estilo1">Indicaciones medicas</legend>
    <table class="titulocampo" >
<? $cantidadFav = mysql_num_rows($sqlFavoritos);
  if($idServicio <> 7){
  if($cantidadFav > 0){ ?>
      <tr class="titulocampo">
        <td width="82">Favoritos:</td>
        <td width="472" colspan="2">
          <select name="listaFavoritos" id="listaFavoritos" >
            <option value="0" >Seleccione...</option>
<? while($arrayFavoritos = mysql_fetch_array($sqlFavoritos)){ 
    $idFavorito = $arrayFavoritos['idFav'];
    $nomFavorito = $arrayFavoritos['nombreFav'];      
?>
            <option value="<? echo $idFavorito; ?>" <? if($favoritoSelect==$idFavorito){ ?> selected="selected" <? } ?>><? echo $nomFavorito; ?></option>
<? } ?>
          </select>
          <input type="button" value="Actualizar Favorito" name="act_fav" id="act_fav" onclick="actualizaFavorito()" />
        </td>
      </tr>
<? }
   } ?>
      <tr align="center" >
        <td colspan="2" align="left">
          <textarea name="detalleEpi" id="detalleEpi" class="editor_fav" cols="90" rows="4"><?= $textoFormato; ?></textarea>
        </td>
      </tr>
<? if($idServicio <> 7){ ?>
      <tr class="titulocampo">
        <td colspan="2">
          <input type="text" name="nombreFav" id="nombreFav" />
          <input type="button" value="Nuevo Favorito" name="agr_fav" id="agr_fav" onclick="insertaFavorito()" />
        </td>
      </tr>
<? } ?>
    </table>
</fieldset>
</form>
<table align="center">
  <tr>
    <td>

      <input type="hidden" name="cama_sn" value=<? echo $cama_sn; ?> >
      <input type="button" name="salir" value="Salir" onclick="window.location.href='<? echo "../superNumeraria/camaSuperNum.php?"; ?>'" />
    </td>
    <td><input type="button" name="btn_grabar3" value="Grabar" onclick="guardarepimedica();" /></td>
    <td><input type="button" name="btn_imprimir" value="Cerrar Epicrisis" onclick="guardarepimedicaimprimir();" /></td>
  </tr>
</table>
<script type="text/javascript">
  function guardarepimedica(){
    var controlEspecialidadagenda = $('#controlEspecialidad').prop('checked');
    if(controlEspecialidadagenda== true){
      var validacontrol = $('#validacontrolagenda').val();
      if(validacontrol==1){
        document.frm_epicrisis_medica.action='grabaEpicrisisMed.php';document.frm_epicrisis_medica.submit();
      }else{
        alert("no se ha ingresado especialidad y periodo para el control");
      }
    }else{
      document.frm_epicrisis_medica.action='grabaEpicrisisMed.php';document.frm_epicrisis_medica.submit();
    }
  }
  function guardarepimedicaimprimir(){
    var controlEspecialidadagenda = $('#controlEspecialidad').prop('checked');
    if(controlEspecialidadagenda== true){
      var validacontrol = $('#validacontrolagenda').val();
      if(validacontrol==1){
        validar_medico();
      }else{
        alert("no se ha ingresado especialidad y periodo para el control");
      }
    }else{
      validar_medico();
    }
  }
</script>
<script type="text/javascript">
  function activatiempo(){
    $("#periodo").removeAttr("disabled");
  }
</script>