<?php
//date_default_timezone_set('America/Santiago');
//usar la funcion header habiendo mandado código al navegador
ob_start(); 
//end para header
//header('Content-Type: text/html; charset=utf-8');

$id_cama		= $_REQUEST['id_cama'];
$ctaCte			= $_REQUEST['ctaCte']; 
$id_paciente	= $_REQUEST['id_paciente'];
$idServicio		= $_REQUEST['idServicio'];
$prev_paciente	= $_REQUEST['prev_paciente']; 
$cod_prev		= $_REQUEST['cod_prev'];
$ing_paciente	= $_REQUEST['ing_paciente'];
$multiRes		= $_REQUEST['multiRes'];
$hospitaliza	= $_REQUEST['hospitaliza'];
$cama_sn		= $_REQUEST['cama_sn'];

$graba= $_GET['graba'];
$idEpicrisis= $_GET['idEpicrisis']; 

$desde= $_GET['desde']; 

if (!isset($_SESSION)) {
	session_start();
}
$permisos = $_SESSION['permiso'];
if ( $_SESSION['MM_Username'] == null ) {
	$GoTo = "../../acceso/index.php";
	header(sprintf("Location: %s", $GoTo));
}
include "../funciones/epicrisis_funciones.php";
mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');
mysql_select_db('paciente') or die('Cannot select database');

$sqlPaciente = mysql_query("SELECT * 
							FROM paciente 
							WHERE id = '$id_paciente'") or die("Error al seleccionar datos del pacientes ".mysql_error());
mysql_query("SET NAMES utf8");							

							
$arrayPaciente = mysql_fetch_array($sqlPaciente);
$nombreCompleto = utf8_encode($arrayPaciente['nombres'].' '.$arrayPaciente['apellidopat'].' '.$arrayPaciente['apellidomat']);
$rutPac = $arrayPaciente['rut'];
$fonoCont = $arrayPaciente['fono1'];
$direccionPac = $arrayPaciente['direccion'];
$fechaNac = cambiarFormatoFecha($arrayPaciente['fechanac']);

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

//SELECCIONA EL NOMBRE DE LA PERSONA QUE HARA LA EPICRISIS
$usuario = $_SESSION['MM_Username'];
$sqlUsuario = mysql_query("SELECT
				usuario.nombreusuario
				FROM usuario
				WHERE idusuario = '$usuario'") or die ("Error al seleccionar nombre del usuario ". mysql_error());
				
$arrayUsuario = mysql_fetch_array($sqlUsuario);
$nombreUsuario = $arrayUsuario['nombreusuario'];

//SELECCIONA LOS TIPOS DE TRASLADOS
$sqlTraslado = mysql_query("SELECT 
				idcentro,
				nombre
				FROM centro
				ORDER BY nombre ASC") or die("Error al seleccionar traslados ".mysql_error());

//SELECCIONA LOS EXAMENES DE RAYOS REALIZADOS
mysql_select_db('rayos') or die('Cannot select database');

$fecha_sep = substr($hospitaliza, 0,10);

$sqlRayos = "SELECT DISTINCT
			rayos.examen.EXAcorrelativo,
			rayos.atencion.ATEfecha,
			paciente.prestacion.preNombre,
			rayos.examen.EXAinforme_estado,
			rayos.examen.EXTIcod,
			serv.nombre AS servicio,
			esp.nombre AS especialidad
			FROM rayos.atencion
			Left Join rayos.examen ON rayos.examen.ATEcorrelativo = rayos.atencion.ATEcorrelativo
			Left Join paciente.prestacion ON paciente.prestacion.preCod = rayos.examen.PREcod
			Inner Join acceso.servicio AS serv ON rayos.atencion.ATEservicio = serv.idservicio
			Inner Join acceso.servicio AS esp ON rayos.atencion.ATEespecialidad = esp.idservicio
			WHERE rayos.atencion.PACid = '$id_paciente' and ATEfecha >= '$fecha_sep'
			order by ATEfecha DESC";
			
$queryRayos = mysql_query($sqlRayos) or die("Error al seleccionar examenes de rayos ". mysql_error());

//OBTIENE INFORMACION DE LOS EXAMENES DE AP
mysql_select_db('anatomia') or die('Cannot select database');

$sqlAnato = "SELECT
			anatomia.controlanatomiadetalle.regAOrganos,
			anatomia.controlanatomiadetalle.preCod2,
			paciente.prestacion.preCod,
			paciente.prestacion.preNombre,
			paciente.organos.orgdescripcion
			FROM
			anatomia.controlanatomiadetalle
			INNER JOIN anatomia.controlanatomia ON anatomia.controlanatomia.regAId = anatomia.controlanatomiadetalle.regAId
			INNER JOIN paciente.prestacion ON anatomia.controlanatomiadetalle.preCod2 = paciente.prestacion.preCod
			INNER JOIN paciente.organos ON anatomia.controlanatomiadetalle.regAOrganos = paciente.organos.orgId
			WHERE
			anatomia.controlanatomia.regAtipoExamen = 'B' AND
			anatomia.controlanatomia.pacId = $id_paciente AND
			anatomia.controlanatomia.regAFechaRecepcion >= '$fecha_sep'";
			
$queryAnato = mysql_query($sqlAnato) or die ("ERROR AL SELECCIONAR EXAMENES DE ANATOMIA ".mysql_error());

mysql_select_db('epicrisis') or die('Cannot select database');	
//OBTIENE INFORMACION DE UNA EPICRISIS YA CREADA


$sqlEpicrisis = mysql_query("SELECT *, camas.listasn.barthelegreso 
				FROM epicrisisenf
				INNER JOIN camas.listasn ON epicrisis.epicrisisenf.epienfCtacte = camas.listasn.ctaCteSN AND epicrisis.epicrisisenf.epienfCtacte <> ''
				WHERE epienfctaCte = '$ctaCte'") or die("Error al seleccionar la epicrisis ".mysql_error());
				//mysql_query("SET NAMES utf8");		
$arrayEpicrisis = mysql_fetch_array($sqlEpicrisis);

$idEpicrisis = $arrayEpicrisis['epienfId'];
$idCie10 = $arrayEpicrisis['epienfCie10'];
$epiEstado = $arrayEpicrisis['epienfEstado'];

if($idEpicrisis > 0){
$existeEpi = 1;
}else{
	$existeEpi = 0;
	}

//OBTIENE LOS TIPOS DE HOGARES
if(($idServicio == 7) or ($idServicio == 6)){
	$conTipo = " WHERE hogarTipo = 'P'";
	}else{
		$conTipo = " WHERE hogarTipo = 'A'";
		}		
$sqlHogares = mysql_query("SELECT * FROM hogares".$conTipo) or die("Error al seleccionar Hogares ".mysql_error());

//OBTIENE LOS TIPOS DE EDUCACIONES 
if($idServicio == 6){
	$conEduc = " WHERE educaTipo = 'N' or educaTipo = 'AN'";
	}else if($idServicio == 7){
		$conEduc = " WHERE educaTipo = 'A' or educaTipo = 'AN' or educaTipo = 'P' ";
		}else{
			$conEduc = " WHERE educaTipo = 'A' or educaTipo = 'AN' ";
			}
	
$sqlEduca = "SELECT *
			FROM
			educapac".$conEduc;
$queryEduca = mysql_query($sqlEduca) or die($sqlEduca." ERROR AL SELECCIONAR EDUCACIONES ".mysql_error());

//OBTIENE LOS TIPOS DE EDUCACIONES QUE SE LE HAN DADO A UN PACIENTES

//OBTIENE LOS TIPOS DE YESO 

$sqlYeso = mysql_query("SELECT *
			FROM
			tipoyeso");
			

//OBTIENE LA DESCRIPCION COMPLETA DEL CIE 10
mysql_select_db('paciente') or die('Cannot select database');

//REEMPLAZA LOS PUNTOS POR DECIMALES DE LOS PESOS QUE SE EXTRAEN DE LA TABLA EPICRISIS

$peso1 = str_replace('.',',',$pesoIngreso);
$peso2 = str_replace('.',',',$pesoAlta);

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

//busca destinos para centros clinicos

	$sql = "SELECT establecimiento.ESTAabreviado FROM parametros_clinicos.establecimiento WHERE establecimiento.ESTAabreviado NOT IN ('HJNC')";
	mysql_query("SET NAMES utf8");
	$queryderivadoa = mysql_query($sql) or die($sql." <br>ERROR AL OBTENER listarderivacionesa<br>".mysql_error());

	$sqlderivada = "SELECT der_descripcion from camas.derivada where der_ctacte = '$ctaCte'";
	mysql_query("SET NAMES utf8");
	$query = mysql_query($sqlderivada) or die($sql." <br>ERROR AL OBTENER traederivacionesa<br>".mysql_error());
	$resultadoderivadoa = mysql_fetch_array($query);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gestion de Camas Hospital Dr. Juan No&eacute; C.</title>

<link type="text/css" rel="stylesheet" href="css/estilo.css" />
<link type="text/css" rel="stylesheet" href="../../estandar/css/estiloBoton.css" />

<script src="../../estandar/src/calendario/src/js/jscal2.js"></script>
<script src="../../estandar/src/calendario/src/js/lang/es.js"></script>
<link rel="stylesheet" type="text/css" href="../../estandar/src/calendario/src/css/jscal2.css"/>
<link rel="stylesheet" type="text/css" href="../../estandar/src/calendario/src/css/border-radius.css"/>
<link rel="stylesheet" type="text/css" href="../../estandar/src/calendario/src/css/steel/steel.css"/>
<link rel="stylesheet" type="text/css" href="epicrisisDoc/autocompleta/jquery.autocomplete.css" />
<script type="text/javascript" src="epicrisisDoc/autocompleta/jquery.js"></script>
<script type="text/javascript" src="epicrisisDoc/autocompleta/jquery.autocomplete.js"></script>
<script type="text/javascript" src="epicrisisDoc/tinymce/jscripts/tiny_mce/tiny_mce.js" ></script>
<script type="text/javascript">
	tinyMCE.init({
			mode : "textareas",
			theme : "advanced",
			plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
			theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "cut,copy,pastetext,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,cleanup,removeformat,hr,|,insertdate,inserttime,preview,|,forecolor,backcolor,|,spellchecker",
			theme_advanced_buttons3 : "tablecontrols",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			forced_root_block : false,
			force_p_newlines : false,
			force_br_newlines : true,
			table_inline_editing : true,
			height : "350"
			
	});
</script>

<script type="text/javascript">
$().ready(function() {
	
	$("#enfermeras").autocomplete("epicrisisDoc/autocompleta/sqlEnfermeras.php", {
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
	setInterval('disableCombos()',10);
	setInterval('disableCombos2()',10);
	setInterval('barthel(epiMedica)',10);
	setInterval('barthele(epiMedica)',10);
	setInterval('disableRadio()',10);
	
}
</script>

<body>
<?
$direccionPac = str_replace("ñ","n",$direccionPac);
$direccionPac = str_replace("Ñ","N",$direccionPac);

//$nombreCompleto = str_replace("ñ","n",$nombreCompleto);
//$nombreCompleto = str_replace("Ñ","N",$nombreCompleto);

//$serv_paciente = ereg_replace("[íìî]","i",$serv_paciente);
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
	//para ampliar los caracteres a reemplazar agregar lineas de este tipo:
	//$s = str_replace("caracter-que-queremos-cambiar","caracter-por-el-cual-lo-vamos-a-cambiar",$s);
	return $s;
}

?>
<form name="epiMedica" id="epiMedica" method="post">
<input type="hidden" name="id_cama" value="<? echo $id_cama; ?>" />
<input type="hidden" name="nombrePaciente" value="<? echo $nombreCompleto; ?>" />
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
<input type="hidden" name="nacimiento" value="<? echo $fechaNac; ?>" />
<input type="hidden" name="desde" value="<? echo $desde; ?>" />

<table align="center">
	<tr>
		<td>
        <table >
        <tr>
            <td width="50"><img src="img/logo.jpg" width="226" height="99" /></td>
            <td width="561" align="left" class="titulocampo" >&nbsp;Servicio de Salud de Arica<br />&nbsp;Hospital en Red &quot;Dr. Juan No&eacute; C.&quot;</td>
            <td width="153" align="right" class="titulocampo" ><?php echo date('d-m-Y'); ?></td>
        </tr>
        <tr>
            <td colspan="3" align="center" class="titulo"><strong>EPICRISIS DE ENFERMERIA <? if($cama_sn == 1){ ?><br /> CAMAS INDIFERENCIADAS <? }else{ ?> CENTRO DE RESPONSABILIDAD<br /><? echo $nomCR; }?></strong>
            <div align="right"></div>
            </td>
         
              <td colspan="3">
              <hr />
              </td>
          </tr>
          <tr>
              <td colspan="3">
              <fieldset><legend class="titulocampo">Antecedentes Personales</legend>
              <table width="776">
              	<tr>
                    <td width="80" class="titulocampo">
                    Nombre:
                    </td>
                    <td width="337" class="titulosSec" >&nbsp;<? echo $nombreCompleto; ?></td>
                    <td width="69" class="titulocampo">Rut:</td>
                    <td width="270" class="titulosSec"><? echo $rutPac; ?>-<? echo ValidaDVRut($rutPac); ?>
                    <input type="hidden" name="epiRut" id="epiRut" value="<? echo $rutPac; ?>" />
                    </td>
                </tr>
                <tr>
                    <td class="titulocampo">N&deg; Ficha</td>
                    <td class="titulosSec"><? echo $arrayPaciente['nroficha']; ?></td>
                    <td class="titulocampo">Prevision:</td>
                    
                    <td class="titulosSec"><? echo limpiar_caracteres_especiales($prev_paciente); ?></td>
                </tr>
                <tr>
                    <td class="titulocampo">Direccion:
                    </td>
                    <td class="titulosSec"><? echo limpiar_caracteres_especiales($arrayPaciente['direccion']); ?></td>
                    <input type="hidden" name="direccion" id="direccion" value="<? echo limpiar_caracteres_especiales($direccionPac); ?>" />
                    <td class="titulocampo">Genero:</td>
                    
                    <td class="titulosSec"><? echo $sexoPaciente; ?></td>
                </tr>
                 <tr>
                    <td class="titulocampo">Edad:
                    </td>
                    <td class="titulosSec"><? echo calculoAMD($arrayPaciente['fechanac'])?></td>
                    <td class="titulocampo">Servicio:</td>
                    
                    <td class="titulosSec"><? if($cama_sn == 1){ echo "Camas Indiferenciadas"; }else{ echo limpiar_caracteres_especiales($serv_paciente); } ?></td>
                </tr>
                <tr>
                	<td class="titulocampo">Fecha Nac.: </td>
                    <td class="titulosSec"><? echo $fechaNac; ?></td>
                    <td class="titulocampo">Fono :
                    </td>
                    <td colspan="3" class="titulosSec"><input size="10" type="text" name="fonoCont" value="<? if($arrayEpicrisis['epienfFono'] == ''){ echo $fonoCont; }else{ echo $arrayEpicrisis['epienfFono']; } ?>" /></td>
                   
                </tr>
              </table>
              </fieldset>
              </td>
          </tr>
          <tr>
          	<td colspan="3">&nbsp;
            
            </td>
          </tr>
          
          <tr>
          	<td colspan="3">
            <fieldset>
            	<legend class="titulocampo">Antecedentes de Hospitalizacion
            	</legend><table >
                  <tr>
                    <td width="120" class="titulocampo">Fecha Ingreso:</td>
                    <? if($existeEpi == 0){ $fechaI = cambiarFormatoFecha($ing_paciente); }else{ $fechaI = cambiarFormatoFecha($arrayEpicrisis['epienfFechaIng']); }?>
                    <td width="128"><input style="width:75px" id="f_date" name="ingFecha" value="<? echo $fechaI; ?>" readonly="readonly"/><input type="Button" id="f_btn" value="&nbsp;" class="botonimagen"/></td>
                    <td width="104" class="titulocampo">Fecha Egreso:</td>
                    <? if($existeEpi == 0){ $fechaA = date('d-m-Y'); }else{ $fechaA = cambiarFormatoFecha($arrayEpicrisis['epienfFechaEgr']); }?>
                    <td width="123"><input style="width:75px" id="f_date1" name="altFecha" value="<? echo $fechaA; ?>" readonly="readonly"/><input type="Button" id="f_btn1" value="&nbsp;" class="botonimagen"/></td>
                    <td width="91" class="titulocampo">Dias Estadia:</td>
                    <td colspan="2" width="98" class="titulocampo"><span class="titulosSec">
                      <input style="width:35px" id="difDias" name="difDias" readonly="readonly" />
dias</span></td>
                 
                  </tr>
                  <? if($idServicio == 6){ ?>
                  
                  <tr>
                  	<td class="titulocampo">Peso al Nacer: </td>
                    <td><input onKeyPress="return validaNumeros2(event)" size="10" type="text" name="pesoNac" value="<? echo $arrayEpicrisis['epienfPesoNac']; ?>" id="pesoNac" /></td>
                    <td class="titulocampo">Peso al Alta: </td>
                    <td><input onKeyPress="return validaNumeros2(event)" size="10" type="text" name="pesoAlta" value="<? echo $arrayEpicrisis['epienfPesoAlta']; ?>" id="pesoAlta" /></td>
                  </tr>
                  
				  <? } ?>
                  <tr>
                    <td class="titulocampo">Destino:</td>
                    <td>
                    
                    <select name="destinoPaciente" id="destinoPaciente" onchange="disableCombos()">
                    	<option value="">Seleccione</option>
                    	<option value="1" <? if($arrayEpicrisis['epienfDestino'] == 1){ echo "selected"; } ?> >Domicilio</option>
                        <option value="2" <? if($arrayEpicrisis['epienfDestino'] == 2){ echo "selected"; } ?>>Traslado</option>
                        <option value="3" <? if($arrayEpicrisis['epienfDestino'] == 3){ echo "selected"; } ?>>CONIN</option>
                        <option value="5" <? if($arrayEpicrisis['epienfDestino'] == 5){ echo "selected"; } ?>>Anatomia Patologica</option>
                        <option value="6" <? if($arrayEpicrisis['epienfDestino'] == 6){ echo "selected"; } ?>>Servicio Medico Legal</option>
                        <option value="4" <? if($arrayEpicrisis['epienfDestino'] == 4){ echo "selected"; } ?>>Otros</option>
                        
                    </select>
                    </td>
                    <td class="titulocampo">Traslado:</td>
                    <td colspan="4">
                    <select name="trasladoPaciente" id="trasladoPaciente">
                    	<option value="">Seleccione...</option>	
                        <? 
							
						while($arrayTraslado = mysql_fetch_array($sqlTraslado)){
							$idTraslado = $arrayTraslado['idcentro'];
							$nomTraslado = $arrayTraslado['nombre'];
							?>	
                        <option value="<? echo $idTraslado; ?>" <? if($idTraslado == $arrayEpicrisis['epienfTraslado']){ echo "selected"; } ?>><? echo $nomTraslado?></option>	
                        <? } ?>
                    </select><br />
                    <select name="hogarPaciente" id="hogarPaciente">
                    	<option value="">Seleccione...</option>	
                        <? 
							
						while($arrayHogares = mysql_fetch_array($sqlHogares)){
							$idHogar = $arrayHogares['hogarId'];
							$nomHogar = $arrayHogares['hogarNom'];
							?>	
                        <option value="<? echo $idHogar; ?>" <? if($idHogar == $arrayEpicrisis['epienfHogar']){ echo "selected"; } ?>><? echo $nomHogar?></option>	
                        <? } ?>
                    </select>
                    </td>
                  </tr>
                  <tr>
            <td colspan="5" class="titulocampo">Derivado a:
              <select name="derivadoa" id="derivadoa">
                <option value="0">.......</option>
                <?while($arrayderivadoa = mysql_fetch_array($queryderivadoa)){?>
                 <option value="<?=$arrayderivadoa['ESTAabreviado']?>" <? if($arrayderivadoa['ESTAabreviado']==$resultadoderivadoa['der_descripcion']){ ?> selected="selected" <? } ?>><?=$arrayderivadoa['ESTAabreviado']?></option>
                <?}?>
              </select>
            </td>
          </tr>
                  <tr >
                  	<? if($idServicio != 6){ ?>
                    <td class="titulocampo">Val. Herida:</td>
                    <td ><input name="herida" id="herida" style="width:35px" maxlength="1" onkeypress="return isNumberKey(event)" value="<? echo $arrayEpicrisis['epienfHerida']; ?>" /></td>
                    <?
					}
					 if(($idServicio != 7) and ($idServicio != 6)){ ?>
                    <td class="titulocampo">Val.<br /> Pie Diabetico:</td>
                    <td ><input name="pieDiab" id="pieDiab" style="width:35px" maxlength="1" onkeypress="return isNumberKey(event)" value="<? echo $arrayEpicrisis['epienfPie']; ?>" /></td>
                    <? } ?>
                    <td class="titulocampo">Condicion <br />Egreso:</td>
                    <td class="titulosSec" >
                    <p>
                    <label>
                      <input type="radio" name="condEgreso" value="V" <? if ($arrayEpicrisis['epienfCond'] == 'V') { echo "checked='checked'" ; } ?> id="condEgreso" />
                      Vivo</label>
                    <br />
                    <label>
                      <input type="radio" name="condEgreso" value="F" <? if ($arrayEpicrisis['epienfCond'] == 'F') { echo "checked='checked'" ; } ?> id="condEgreso" />
                      Fallecido</label>
                    <br />
                  </p>
                    </td>
                  </tr>
                  <tr>
                  <td class="titulocampo">Multi Resistente:</td>
                    <td class="titulosSec">
                    <? if($multiRes == 1){ ?>
                    Si
                    <? }else{ ?>
                    No
					<? } ?>
                    </td>
                    
                    
                  <td class="titulocampo">Escaras:</td>
                    <td class="titulosSec">
                    <p>
                    <label>
                      <input type="radio" name="escaras" value="SI" <? if ($arrayEpicrisis['epienfEscara'] == 'SI') { echo "checked='checked'" ; } ?> id="escaras" />
                      Si
                    </label>
                    <br />
                    <label>
                      <input type="radio" name="escaras" value="NO" <? if ($arrayEpicrisis['epienfEscara'] == 'NO') { echo "checked='checked'" ; } ?> id="escaras" />
                      No
                    </label>
                    <br />
                  </p></td>
                  <? if($idServicio != 6){ ?>
                  <td class="titulocampo">
                    Hosp. <br />Domiciliaria:
                    </td>
                    <td class="titulosSec">
                    <p>
                    <label>
                      <input type="radio" name="hospDom" value="SI" <? if ($arrayEpicrisis['epienfHosdom'] == 'SI') { echo "checked='checked'" ; } ?> id="hospDom" />
                      Si
                    </label>
                    <br />
                    <label>
                      <input type="radio" name="hospDom" value="NO" <? if ($arrayEpicrisis['epienfHosdom'] == 'NO') { echo "checked='checked'" ; } ?> id="hospDom" />
                      No
                    </label>
                    <br />
                  </p></td>
                  
                  </tr>
                  <? if((soloanios($arrayPaciente['fechanac'])) >= 60){ ?>
                    <tr>
                    	<td class="titulocampo">Barthel Ingreso: </td>
                      	<td class="titulosSec" colspan="5">
                        <input  name="barthel" type="text" onkeypress="return isNumberKey(event)" id="barthel" style="width:35px" maxlength="3" value="<? echo $arrayEpicrisis['epienfBarthel']; ?>" /> 
                        <input type="text" readonly="readonly" id="valorBart" name="valorBart" />
                      	Barthel Egreso:
                        <input  name="barthele" type="text" id="barthele" style="width:35px" maxlength="3" value="<? echo $arrayEpicrisis['barthelegreso']; ?>" /> 
                        <input type="text" readonly="readonly" id="valorBartele" name="valorBartele" />
                      </td>                   
                    </tr>
                    <? } ?>
                  <tr>
                  	
                    
                  <td class="titulocampo">Tipo de Yeso:
                    </td>
                    <td colspan="3">
                    <select name="tipoYeso" id="tipoYeso">
                    	<option value="">Seleccione...</option>	
							<? while($arrayYeso = mysql_fetch_array($sqlYeso)){
								$idYeso = $arrayYeso['yesoId'];
								$nombreYeso = $arrayYeso['yesoNombre'];
								?>
                            <option value="<? echo $idYeso; ?>" <? if($idYeso == $arrayEpicrisis['epienfYeso']){ echo "selected"; } ?>><? echo $nombreYeso; ?></option>	
                            <? } ?>
                    </select>
                    </td>
                  	
                  </tr>
                  <? } ?>
                  <tr>
                    <td class="titulocampo">Diagnostico:</td>
                    <td colspan="6"><input name="diagnosticos" id="diagnosticos" type="text" size="80" value="<? echo limpiar_caracteres_especiales($idCie10); ?>"/></td>
                  </tr>
                  <tr class="titulocampo">
                    <td >Enfermera(o):</td>
                    <td colspan="6">
                    <input name="enfermeras" id="enfermeras" type="text" size="80" value="<? echo $arrayEpicrisis['epienfEnfermera']; ?>"/>
                    <input name="idUsuario" id="idUsuario" type="hidden" size="80" value="<? echo $usuario; ?>"/></td>
                  </tr>
				</table>
				</fieldset>
            </td>
          </tr>
        </table>
   	  </td>
  </tr>
  <tr>
  	<td>&nbsp;
    
    </td>
  </tr>
  <tr>
    <td>
    	<table width="855">
        	
            <tr valign="top">
            
                <td width="432" >
                <fieldset><legend class="titulocampo">EDUCACIONES</legend>
                    <table>
                      <tr>
                      <td class="titulocampo">
                      <? 
					  
                      while($arrayEduca = mysql_fetch_array($queryEduca)){ 
                                
								$idEduca = $arrayEduca['educaId'];
                                $nomEduca = $arrayEduca['educaNom'];
								
								if($idEpicrisis > 0){
									mysql_select_db('epicrisis') or die('Cannot select database');	
									$sqlepiEduca = mysql_query("SELECT *
																FROM
																epienf_has_educapac
																WHERE epienf_has_educapac.epienfId = $idEpicrisis
																AND educaId = $idEduca") or die("ERROR AL SELECCIONAR EDUCACIONES DEL PACIENTE ". mysql_error());

									$arrayepiEduca = mysql_fetch_array($sqlepiEduca);
									$educaSelec = $arrayepiEduca['educaId'];
									
										if($educaSelec == $idEduca){
											 
											$flagEduc = 1;
											}else{
												$flagEduc = 0;
												}
									
								}
                      ?>
                        <input type="checkbox" <? if($flagEduc == 1){ ?> checked="checked" <? } ?> name="educaArray[<? echo $idEduca; ?>]"  value="<? echo $idEduca; ?>" /><? echo $nomEduca; ?><br />
                      <?  } ?>
                        </td>
                        </tr>
                      </table>
                </fieldset>
                </td>
            </tr>
        </table>
    </td>
  </tr>
  <tr>
  	<td>&nbsp;
    
    </td>
  </tr>
  <tr>
    <td>
      <fieldset>
        <legend class="titulocampo">INDICACIONES AL ALTA</legend>
        <?
      $textoFormato = "<p ><strong>1.<u>Regimen </u></strong></p><p><br /><hr></p><p ><strong>2.<u>Reposo </u></strong></p><p><br /><hr><strong>3.<u>Evolucion Enfermeria al Alta</u></strong></p><p><br /></p>";
	  if(($idServicio == 7) or ($idServicio == 6)){
		  
	  $textoFormato.= "<hr><p ><strong>4.<u>Indicacion Tratamiento </u></strong></p>
	  <table border='1'>
	  <tr>
		<td>Medicamento</td>
		<td>Dosis</td>
		<td>Horario</td>
		<td>Observacion</td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	</table>
	<br/>
	<hr><p ><strong>4.<u>Controles </u></strong></p>
	  <table border='1'>
	  <tr>
		<td>Citaciones</td>
		<td>Medico</td>
		<td>Fecha</td>
		<td>Observacion</td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	</table>
	<br/>
	<hr><p ><strong>5.<u>Entrega de Examen </u></strong></p><br/>";
	
	  }
	  
	  ?>
        </legend><table>
          <tr>
            <td>
              <textarea name="detalleEpi" id="detalleEpi" cols="90" rows="4"><? if($arrayEpicrisis['epienfIndica']){ echo $arrayEpicrisis['epienfIndica']; }else{ echo $textoFormato; } ?></textarea>
              </td>
            </tr>
          </table>
        </fieldset>
        
      </td>
  </tr>
  
  <tr>
  	<td class="titulocampo">
    
    <? if(mysql_num_rows($queryRayos) > 0){ ?> 
    
	<fieldset>
        <legend class="titulocampo">EXAMENES RAYOS</legend>
		
        <ul><br />
			<?
			
			mysql_data_seek($queryRayos, 0);
			
			while ($arrayRayos = mysql_fetch_array($queryRayos)){ 
                    $nombreRayos = $arrayRayos['preNombre'];
					$idRayos = $arrayRayos['EXAcorrelativo'];
            ?>	
               <li><? echo limpiar_caracteres_especiales($nombreRayos); ?><br /></li>
            
			<? } ?> 
    	</ul>
    </fieldset>
    <? }?>
    </td>
  </tr>
  <tr>
  	<td width="500" class="titulocampo">
    
    <? if(mysql_num_rows($queryAnato) > 0){ ?> 
    
	<fieldset>
        <legend class="titulocampo">EXAMENES ANATOMIA</legend>
		
        <ul><br />
			<?
			mysql_data_seek($queryAnato, 0);
			
			while ($arrayAnato = mysql_fetch_array($queryAnato)){ 
                    $preNom = $arrayAnato['preNombre'];	
					$orgNom = $arrayAnato['orgdescripcion'];	
            ?>	
               <li><? echo limpiar_caracteres_especiales($preNom)."(".$orgNom.")"; ?><br /></li>
            
			<? } ?> 
    	</ul>
    </fieldset>
    <? }?>
    </td>
  </tr>
  
  <? if(($idServicio == 7) or ($idServicio == 6)){ ?>
  
  <tr><td>&nbsp;</td></tr>
  <tr>
  	<td>
    <fieldset><legend class="titulocampo">RESPONSABLE RECEPCION INDICACIONES</legend>
    <table width="494">
    	<tr>
    		<td class="titulosSec" colspan="2">
            
                <p>
                <label>
                  <input type="radio" onClick="disableRadio()" name="responsable" value="Padre" <? if ($arrayEpicrisis['epienfResp'] == 'Padre') { echo "checked='checked'" ; } ?> id="responsable" />
                  Padre
                </label>
                <label>
                  <input type="radio" onclick="disableRadio()" name="responsable" value="Madre" <? if ($arrayEpicrisis['epienfResp'] == 'Madre') { echo "checked='checked'" ; } ?> id="responsable" />
                  Madre
                </label>
                <label>
                  <input type="radio" onclick="disableRadio()" name="responsable" value="Tutor" <? if ($arrayEpicrisis['epienfResp'] == 'Tutor') { echo "checked='checked'" ; } ?> id="responsable" />
                  Tutor
                </label>
                <label>
                  <input type="radio" onclick="disableRadio()" name="responsable" value="Otro" <? if ($arrayEpicrisis['epienfResp'] == 'Otro') { echo "checked='checked'" ; } ?> id="responsable" />
                  Otro
                </label>
                
                <input type="text" name="otroResponsable" id="otroResponsable" />
                <br />
                </p>
                </td>
          </tr>
          <tr>
          <td width="239" class="titulocampo">
        	Nombre: <input type="text" name="nomResp" value="<? echo $arrayEpicrisis['epienfRespNom'];//echo limpiar_caracteres_especiales($arrayEpicrisis['epienfRespNom']); ?>" id="nomResp" size="30" />
          </td>
          <td width="186" class="titulocampo">
          Rut: <input type="text" name="rutResp" maxlength="10" value="<? echo $arrayEpicrisis['epienfRespRut']; ?>" id="rutResp" size="20" />
          </td>
          </tr>
   	</table>
    </fieldset>
    </td>
  </tr> 
  <? } ?> 
  <tr>
  	<td>
    	
        	<table align="center">
        	<tr>
            	<td>
                <input type="hidden" name="cama_sn" id="cama_sn" value=<? echo $cama_sn; ?> >
                <? if($cama_sn==1){ ?>
                
                <input type="button" name="salir" value="Salir" onclick="window.location.href='<? echo "../superNumeraria/camaSuperNum.php?"; ?>'" />
                <? }else if($desde=='Pensionado'){ ?>
                <input type="button" name="salir" value="Salir" onclick="window.location.href='<? echo "../../pensionado/detalle_pensionado.php?idPensio=$id_cama"; ?>'" />
                <? }else{ ?>
                <input type="button" name="salir" value="Salir" onclick="window.location.href='<? echo "altapaciente.php?id_cama=$id_cama"; ?>'" />
                <? } ?>
                </td>
                <td><input type="button" id="btn_grabar3" name="btn_grabar3" value="Grabar" onclick="document.epiMedica.btn_grabar3.disabled=true; document.epiMedica.action='grabaEpicrisis.php';document.epiMedica.submit();" /></td>
                <td><input type="button" id="btn_imprimir" name="btn_imprimir" value="Cerrar Epicrisis" onclick="document.epiMedica.btn_imprimir.disabled=true;validar_formulario();"  /></td>
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