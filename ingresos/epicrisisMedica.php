<?php

if (!isset($_SESSION)) {
	session_start();
}
$permisos = $_SESSION['permiso'];
if ( $_SESSION['MM_Username'] == null ) {
	$GoTo = "../acceso/index.php";
	header(sprintf("Location: %s", $GoTo));
}
include "../funciones/epicrisis_funciones.php";
if($medicoGC == '172 -   - SIN ASIGNAR -'){ $medicoGC = '';	}
$dbhost = '10.6.21.12';
mysql_connect ($dbhost,'gestioncamas','123gestioncamas');
mysql_select_db('paciente') or die('Cannot select database');

$sqlPaciente = mysql_query("SELECT * 
							FROM paciente 
							WHERE id = '$id_paciente'") or die("Error al seleccionar datos del pacientes ".mysql_error());
mysql_query("SET NAMES utf8");							
$arrayPaciente = mysql_fetch_array($sqlPaciente);
$nombreCompleto = $arrayPaciente['nombres']." ".$arrayPaciente['apellidopat']." ".$arrayPaciente['apellidomat'];
$rutPac = $arrayPaciente['rut'];
$fonoCont = $arrayPaciente['fono1'];
$direccionPac = $arrayPaciente['direccion'];

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

//BUSCA LOS SUBPROGRAMAS (GES)

$consGes = "SELECT *
			FROM ppvsubprogramas
			WHERE
			ppvsubprogramas.subprogPediatrica = 1
			ORDER BY
			ppvsubprogramas.subprogNombre ASC";
			
$sqlGes = mysql_query($consGes) or die("ERROR AL SELECCIONAR SUBPROGRAMAS ".mysql_error());


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

//ACTUALIZA ESTADO DE LA EPICRISIS
mysql_select_db('epicrisis') or die('Cannot select database');	

if(($abre == 1) and ($idEpicrisis)){
	$sqlAbre = "UPDATE epicrisismedica 
				SET epimedEstado = 0
				WHERE epimedId = $idEpicrisis";
	$queryAbre = mysql_query($sqlAbre) or die("ERROR AL ABRIR EPICRISIS ".mysql_error());
	}

//OBTIENE INFORMACION DE UNA EPICRISIS YA CREADA
if($idServicio == 7){
mysql_query("SET NAMES utf8");
$sqlEpicrisis = mysql_query("SELECT *
				FROM epicrisismedica
				WHERE epimedctaCte = '$ctaCte'");
}else{
mysql_query("SET NAMES utf8");
$sqlEpicrisis = mysql_query("SELECT * 
				FROM epicrisismedica
				LEFT JOIN favoritos ON epicrisismedica.idFav = favoritos.idFav
				WHERE epimedctaCte = '$ctaCte'") or die("Error al seleccionar la epicrisis ".mysql_error());
}
$arrayEpicrisis = mysql_fetch_array($sqlEpicrisis);

$idEpicrisis = $arrayEpicrisis['epimedId'];
$diagEpicrisis = $arrayEpicrisis['epimedDiag'];
$epiEstado = $arrayEpicrisis['epimedEstado'];
$epiFav = $arrayEpicrisis['idFav'];
$descFav = $arrayEpicrisis['descFav'];
$descIndica = $arrayEpicrisis['epimedIndica'];
$nombreFav = $arrayEpicrisis['nombreFav'];
$medFav = $arrayEpicrisis['idMedico'];

//SELECCIONA LOS CONTROLES DE PEDIATRIA
if(($idServicio == 7) && ($idEpicrisis)){
	mysql_query("SET NAMES utf8");
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

if($idEpicrisis > 0){
	$existeEpi = 1;
	}else{
		$existeEpi = 0;
		}

//OBTIENE LOS TIPOS DE HOGARES	
$sqlHogares = mysql_query("SELECT * FROM hogares WHERE hogarTipo = 'P'") or die("Error al seleccionar Hogares ".mysql_error());

// BUSCA LOS DIAGNOSTICO FAVORITOS DE LOS MEDICOS

$sqlFavoritos = "SELECT * 
				FROM favoritos
				WHERE
				favoritos.idMedico = '$usuario'";
$queryFavoritos = mysql_query($sqlFavoritos) or die ($sqlFavoritos. " ERROR AL SELECCIONAR FAVORITOS ".mysql_error());
$cantidadFav = mysql_num_rows($queryFavoritos);


//MUESTRA LA INDICACION FAVORITA SELECCIONADA
if($listaFavoritos){
$sqlSFav = "SELECT * FROM favoritos WHERE favoritos.idFav = $listaFavoritos";
$querySFav = mysql_query($sqlSFav) or die($sqlSFav." ERROR AL SELECCIONAR DESCRIPCION ".mysql_error());
$arraySFav = mysql_fetch_array($querySFav);
$descFav = $arraySFav['descFav'];
$nombreFav = $arraySFav['nombreFav'];
}

//MUESTRA LAS OPCIONES DE CONTROLES

$sql_controles = mysql_query("SELECT * FROM control") or die("ERROR AL CARGAR LISTA DE CONTROLES". mysql_error());

//MUESTRA LAS CLASIFICACIONES NUTRICIONALES

$sql_nutricion = mysql_query("SELECT
							nutricion.id_nutricion,
							nutricion.nom_nutricion
							FROM
							nutricion") or die("ERROR AL CARGAR LISTA DE CLASIFICACION NUTRICIONAL ".mysql_error());
							
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

//BUSCA LAS OPERACIONES REALIZADAS AL PACIENTE

$sqlPabellon = "SELECT
				cirugia.ciruCod,
				cirugia.ciruHora,
				cirugia.ciruFecha,
				cirugia.ciruInter1Glosa,
				medicospab.mpNombre
				FROM
				cirugia,
				medicospab
				WHERE
				cirugia.ciruCirujano1 = medicospab.mpCod AND
				cirugia.pacieCod = $id_paciente AND
				cirugia.ciruFecha >= '$fecha_sep' AND
				(cirugia.ciruEstado = 'REALIZADA' OR cirugia.ciruEstado = 'EN PROCESO')";
mysql_query("SET NAMES utf8");				
mysql_select_db('pabellon') or die('Cannot select database');
$queryPabellon = mysql_query($sqlPabellon) or die($sqlPabellon. " ERROR AL SELECCIONAR LAS CIRUGIAS ".mysql_error());

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
	
	$("#medico").autocomplete("epicrisisDoc/autocompleta/sqlMedicos.php", {
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
	setInterval('verificaMedico()',10);
	setInterval('seleccionaGes()',10);
	
}
</script>

<body>
<?
$direccionPac = str_replace("ñ","n",$direccionPac);
$direccionPac = str_replace("Ñ","N",$direccionPac);
$nombreCompleto = str_replace("ñ","n",$nombreCompleto);
$nombreCompleto = str_replace("Ñ","N",$nombreCompleto);

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
		<td width="950px">
        <table >
        <tr>
            <td width="50"><img src="../../equipos/Reportes/img/logo.jpg" width="126" height="99" /></td>
            <td width="561" align="left" class="titulocampo" >&nbsp;Servicio de Salud de Arica<br />&nbsp;Hospital en Red &quot;Dr. Juan No&eacute; C.&quot;</td>
            <td width="153" align="right" class="titulocampo" ><?php echo date('d-m-Y'); ?></td>
        </tr>
        <tr>
            <td colspan="3" align="center" class="titulo"><strong>EPICRISIS MEDICA Y CARNE DE ALTA<br />CENTRO DE RESPONSABILIDAD <? echo $nomCR; ?></strong>
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
                    <td width="337" class="titulosSec" ><strong>&nbsp;<? echo $nombreCompleto; ?></strong></td>
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
                    
                    <td class="titulosSec"><? echo limpiar_caracteres_especiales($serv_paciente); ?></td>
                </tr>
                <tr>
                    <td class="titulocampo">Fono :
                    </td>
                    <td colspan="3" class="titulosSec"><input size="10" type="text" name="fonoCont" value="<? if($arrayEpicrisis['epienfFono'] == ''){ echo $fonoCont; }else{ echo $arrayEpicrisis['epienfFono']; } ?>" /></td>
                   
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
                    <td width="205"><input style="width:75px" id="f_date" name="ingFecha" value="<? echo $fechaI; ?>" readonly="readonly"/><input type="Button" id="f_btn" value="&nbsp;" class="botonimagen"/></td>
                    <td width="139" class="titulocampo">Fecha Egreso:</td>
                    <? if($existeEpi == 0){ $fechaA = date('d-m-Y'); }else{ $fechaA = cambiarFormatoFecha($arrayEpicrisis['epimedFechaEgr']); }?>
                    <td width="148"><input style="width:75px" id="f_date1" name="altFecha" value="<? echo $fechaA; ?>" readonly="readonly"/><input type="Button" id="f_btn1" value="&nbsp;" class="botonimagen"/></td>
                    <td width="111" class="titulocampo">Dias Estadia:</td>
                    <td width="91" class="titulocampo"><span class="titulosSec">
                      <input style="width:35px" id="difDias" name="difDias" readonly="readonly" />
dias</span></td>
                 
                  </tr>
                  <? if($idServicio == 7){ ?>
                  <tr>
                    <td class="titulocampo">Destino:</td>
                    <td>
                    
                    <select name="destinoPaciente" id="destinoPaciente" onchange="disableCombos()">
                    	<option value="">Seleccione</option>
                    	<option value="1" <? if($arrayEpicrisis['epimedDestino'] == 1){ echo "selected"; } ?> >Domicilio</option>
                        <option value="2" <? if($arrayEpicrisis['epimedDestino'] == 2){ echo "selected"; } ?>>Traslado</option>
                        <option value="3" <? if($arrayEpicrisis['epimedDestino'] == 3){ echo "selected"; } ?>>CONIN</option>
                        <option value="5" <? if($arrayEpicrisis['epimedDestino'] == 5){ echo "selected"; } ?>>Anatomia Patologica</option>
                        <option value="6" <? if($arrayEpicrisis['epimedDestino'] == 6){ echo "selected"; } ?>>Servicio Medico Legal</option>
                        <option value="4" <? if($arrayEpicrisis['epimedDestino'] == 4){ echo "selected"; } ?>>Otros</option>
                        
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
                        <option value="<? echo $idTraslado; ?>" <? if($idTraslado == $arrayEpicrisis['epimedDestinodet']){ echo "selected"; } ?>><? echo $nomTraslado?></option>	
                        <? } ?>
                    </select><br />
                    <select name="hogarPaciente" id="hogarPaciente">
                    	<option value="">Seleccione...</option>	
                        <? 
							
						while($arrayHogares = mysql_fetch_array($sqlHogares)){
							$idHogar = $arrayHogares['hogarId'];
							$nomHogar = $arrayHogares['hogarNom'];
							?>	
                        <option value="<? echo $idHogar; ?>" <? if($idHogar == $arrayEpicrisis['epimedDestinodet2']){ echo "selected"; } ?>><? echo $nomHogar?></option>	
                        <? } ?>
                    </select>
                    </td>
                  </tr>
                  <tr>
                  	<td class="titulocampo">Peso Ingreso</td>
                    <td ><input type="text" name="pesoIngreso" size="10px" onkeypress="return NumCheck(event, this);" value="<?= $arrayEpicrisis['epimedPesoIn']; ?>" /></td>
                    <td class="titulocampo">Peso Alta: </td>
                    <td><input type="text" name="pesoEgreso" size="10px" onkeypress="return NumCheck(event, this);" value="<?= $arrayEpicrisis['epimedPesoEg']; ?>"/></td>
                    
                  </tr>  
                  <tr>
                  	<td height="42" class="titulocampo">Clasificacion  nutricional: </td>
                    <td >
                    <select name="tipoNutri">
                    	<option value="0">Seleccione...</option>
						<option value="1" <? if($arrayEpicrisis['epimedNutricion'] == 1){ echo "selected"; } ?> >Eutrofico</option>
                        <option value="2" <? if($arrayEpicrisis['epimedNutricion'] == 2){ echo "selected"; } ?>>Obeso</option>
                        <option value="3" <? if($arrayEpicrisis['epimedNutricion'] == 3){ echo "selected"; } ?>>Riesgo</option>
                        <option value="4" <? if($arrayEpicrisis['epimedNutricion'] == 4){ echo "selected"; } ?>>Desnutrido</option>
                    </select>
                    </td>
                    <td class="titulocampo">Condicion Egreso:</td>
                    <td class="titulosSec" >
                    <p>
                    <label>
                      <input type="radio" name="condEgreso" value="V" <? if ($arrayEpicrisis['epimedCond'] == 'V') { echo "checked='checked'" ; } ?> id="condEgreso" />
                      Vivo</label>
                    <br />
                    <label>
                      <input type="radio" name="condEgreso" value="F" <? if ($arrayEpicrisis['epimedCond'] == 'F') { echo "checked='checked'" ; } ?> id="condEgreso" />
                      Fallecido</label>
                    <br />
                  </p>
                    </td> 
                  </tr>
                  <tr>
                    <td class="titulocampo">GES</td>
                    <td class="titulosSec" colspan="5">
                      <label>
                            <input type="radio" onclick="seleccionaGes()" name="opcionGes" value="si" id="opcionGes"  <? if ($arrayEpicrisis['epimedGes'] == 'si') { echo "checked='checked'" ; } ?> />
                            Si</label><label>
                            <br />
                            <input type="radio" onclick="seleccionaGes()" name="opcionGes" value="no" id="opcionGes" <? if ($arrayEpicrisis['epimedGes'] == 'no') { echo "checked='checked'" ; }else if($arrayEpicrisis['epimedGes'] == ''){ echo "checked='checked'" ; } ?>  />
                            No</label><br />
                    
                    <select name="tiposGes" id="tiposGes">
                    	<option value="0">Seleccione...</option>
                        <? while($rsGes = mysql_fetch_assoc($sqlGes)){ 
								$idGes = $rsGes['subprogCod'];
								$nomGes = $rsGes['subprogNombre'];
						?>
                        	<option value="<?= $idGes; ?>" <? if($arrayEpicrisis['epimedGesNom']==$idGes){ ?> selected="selected" <? } ?>><?= $nomGes; ?></option>
                        <? } ?>
                    </select>
                    </td>
                  </tr>
                  <? } ?>            
                  <tr>
                    <td class="titulocampo">Diagnostico de Egreso:</td>
                    <td colspan="5"><input name="diagnosticos" id="diagnosticos" type="text" size="80" value="<? if($arrayEpicrisis['epimedDiag']){ echo $arrayEpicrisis['epimedDiag']; } else{ echo $diagnosticos; } ?>"/></td>
                  </tr>
                  <? if($idServicio <> 7){ ?>
                  <tr>
                    <td class="titulocampo">Fundamento:</td>
                    <td colspan="5"><input name="fundamentos" id="fundamentos" type="text" size="80" value="<? if($arrayEpicrisis['epimedFund']){ echo $arrayEpicrisis['epimedFund'];} else{ echo $fundamentos; } ?>"/></td>
                  </tr>
                  <? } ?>
                  <tr class="titulocampo">
                    <td >Medico que da Alta:</td>
                    <td colspan="5">
                    <input name="medico" id="medico" type="text" size="80" value="<? if($arrayEpicrisis['epimedMedico']){ echo $arrayEpicrisis['epimedMedico']; }else if($medico != ""){ echo $medico; }else{ echo $medicoGC; } ?>" />
                    <input name="idmedico" id="idmedico" type="hidden" size="80" value=""/>
                    <input name="idUsuario" id="idUsuario" type="hidden" size="80" value="<? echo $usuario; ?>"/></td>
                  </tr>
                 
                  
				</table>
				</fieldset>
            </td>
          </tr>
          <? if(mysql_num_rows($queryPabellon) > 0){ ?>
          <tr>
          <td colspan="3">
              <fieldset><legend class="titulocampo">Intervenciones</legend>
              <table width="717">
              
                  <? 
				  $i = 0;
				  while($arrayPabellon = mysql_fetch_array($queryPabellon)){ 
				  		$ciruCod = $arrayPabellon['ciruCod'];

						if($idEpicrisis){
						$sqlOpera = "SELECT * FROM epimed_has_operacion WHERE opCod = $ciruCod AND epimedId = $idEpicrisis";
						
						mysql_select_db('epicrisis') or die('Cannot select database');
						$queryOpera = mysql_query($sqlOpera) or die($sqlOpera." ERROR AL BUSCAR OPERACIONES ". mysql_error());
						
						$arrayOpera = mysql_fetch_array($queryOpera);
						$editOpera = $arrayOpera['opCod'];
						$editGlosa = $arrayOpera['opNombre'];
						}
				  ?>
                  	<tr class="titulocampo">
                        <td width="53">Fecha: </td>
                        <td width="228" class="titulosSec">&nbsp; <? echo $arrayPabellon['ciruFecha']." ".$arrayPabellon['ciruHora']; ?></td>
                        <td width="66">Cirujano: </td>
                        <td width="350" class="titulosSec">&nbsp; <? echo $arrayPabellon['mpNombre']; ?></td>
                    </tr>
                    <tr class="titulocampo"><?php /*?>if($operacion[$ciruCod]){ echo $operacion[$ciruCod]; }else{ echo strtoupper($arrayPabellon['ciruInter1Glosa']); }<?php */?>
                        <td width="53">Op: </td>
                        <?	
							if($operacion){
							$operacionCod = array_keys($operacion);
							$rldCod = $operacionCod[$i];
							
							}
						?>
                        <td colspan="3" width="228" class="titulosSec">&nbsp;<input name="operacion[<? echo $ciruCod; ?>]" value="<? if($operacion[$rldCod]){echo $operacion[$rldCod]; } else if($editGlosa){ echo strtoupper($editGlosa); }else { echo strtoupper($arrayPabellon['ciruInter1Glosa']); }  ?>" size="100" /></td>
                    </tr>
                  <? $i++;} ?>
                  
              </table>
              </fieldset>
          </td>
          </tr>
          <? } 
		  
		  if($idServicio == 7){
		  ?>
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
        <? } ?>
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
        <legend class="titulocampo">INDICACIONES MEDICAS
<?
		  $textoFormato = "<p ><strong>1.Evolucion y Resultado :</strong> &nbsp; </p><p><br /><hr></p><p ><strong>2.Indicaciones :</strong> &nbsp; </p><br /><br /><hr><p ><strong>3.Observaciones :</strong> &nbsp; </p><br /><br />";
		?>
        </legend>
        <table width="694">
          <? 
		  if($idServicio <> 7){
		  if($cantidadFav > 0){ ?>
          <tr class="titulocampo">
          <td>Favoritos:</td>
          	<td colspan="2">
            
            <select name="listaFavoritos" id="listaFavoritos" onchange="document.epiMedica.submit()">
            	<option value="0">Seleccione</option>
            	<? while($arrayFavoritos = mysql_fetch_array($queryFavoritos)){ 
						$idFavorito = $arrayFavoritos['idFav'];
						$nomFavorito = $arrayFavoritos['nombreFav'];
					
					$band = 0;
					if($epiFav == $idFavorito){ 
						$band = 1;
						}else if($listaFavoritos == $idFavorito){ 
						$band = 1;
						 }
				
				?>
                <option value="<? echo $idFavorito; ?>" <? if($band == 1){?> selected="selected" <? } ?> ><? echo $nomFavorito; ?></option>
                <? } ?>
            </select>
            
            </td>
          </tr>
		  <? 
		  }
		  } ?>
          <tr align="center" >
            <td colspan="3">
              <textarea name="detalleEpi" id="detalleEpi" cols="90" rows="4"><? if($descFav){ echo $descFav; }else if($descIndica){echo $descIndica; }else{ echo $textoFormato; } ?></textarea>
              </td>
            </tr>
            <? if($idServicio <> 7){ ?>
            <tr class="titulocampo">
            	<td width="73">Nombre Favorito:</td>
                <td width="299">
                <input type="text" id="nomFav" name="nomFav" size="30" value="<? echo $nombreFav; ?>" /></td>
                <td width="306" align="right">
                <? if(($listaFavoritos != 0) or (($epiFav != 0) and ($medFav == $usuario))){ ?><input type="button" name="actualizarFav" value="Actualizar Favoritos" onclick="validar_favorito('actualiza');" /><? } ?>
                <input type="button" name="favorito" value="Agregar a Favoritos" onclick="validar_favorito('agrega');" />
                
                </td>
            </tr>
            <? } ?>
        </table>
        </fieldset>
        
      </td>
  </tr>
 
  <tr>
  	<td>
    	<table align="center">
        	<tr>
            	<td>
                <? if($cama_sn==1){ ?>
                <input type="hidden" name="cama_sn" value=<? echo $cama_sn; ?> >
                <input type="button" name="salir" value="Salir" onclick="window.location.href='<? echo "../superNumeraria/camaSuperNum.php?"; ?>'" />
                <? }else if($epimedica==1) { ?>
                <input type="button" name="salir" value="Salir" onclick="window.location.href='<? echo "../../pensionado/detalle_pensionado.php?idPensio=$id_cama"; ?>'" />
                <? }else { ?>
                <input type="button" name="salir" value="Salir" onclick="window.location.href='<? echo "altapaciente.php?id_cama=$id_cama"; ?>'" />
                <? } ?>
                </td>
                <td><input type="button" name="btn_grabar3" value="Grabar" onclick="document.epiMedica.action='grabaEpicrisisMed.php';document.epiMedica.submit();" /></td>
                
                <td><input type="button" name="btn_imprimir" value="Cerrar Epicrisis" onclick="validar_medico();" /></td>
                
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
		  <? if($idServicio == 7){ ?>
		  cal.manageFields("f_btn2", "f_date2", "%d-%m-%Y");
		  cal.manageFields("f_btn3", "f_date3", "%d-%m-%Y");
		  cal.manageFields("f_btn4", "f_date4", "%d-%m-%Y");
		  cal.manageFields("f_btn5", "f_date5", "%d-%m-%Y");
		  <? } ?>
      
        //]]>
</script>
</html>