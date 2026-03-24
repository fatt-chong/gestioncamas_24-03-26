<?php
//usar la funcion header habiendo mandado c�digo al navegador
ob_start(); 
//end para header

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

mysql_query("SET NAMES 'utf8'");							
$arrayPaciente = mysql_fetch_array($sqlPaciente);
$nombreCompleto = $arrayPaciente['nombres']." ".$arrayPaciente['apellidopat']." ".$arrayPaciente['apellidomat'];
$rutPac = $arrayPaciente['rut'];
$fonoCont = $arrayPaciente['fono1'];

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

mysql_select_db('partos') or die('Cannot select database');

$sqlParto = "SELECT *
			FROM
			libro_partos
			INNER JOIN rn_datos ON libro_partos.PAidparto = rn_datos.PAidparto
			WHERE
			libro_partos.idPaciente = '$id_paciente' 
			AND libro_partos.PActacte = '$ctaCte'";
$queryParto = mysql_query($sqlParto) or die($sqlParto. " Error al seleccionar partos ".mysql_error());
$arrayParto = mysql_fetch_array($queryParto);

$idParto = $arrayParto['PAidparto'];

mysql_select_db('acceso') or die('Cannot select database');

//SELECCIONA EL NOMBRE DE LA PERSONA QUE HARA LA EPICRISIS
$usuario = $_SESSION['MM_Username'];
$sqlUsuario = mysql_query("SELECT
				usuario.nombreusuario
				FROM usuario
				WHERE idusuario = '$usuario'") or die ("Error al seleccionar nombre del usuario ". mysql_error());
				
$arrayUsuario = mysql_fetch_array($sqlUsuario);
$nombreUsuario = $arrayUsuario['nombreusuario'];

//OBTIENE INFORMACION DE UNA EPICRISIS YA CREADA
mysql_select_db('epicrisis') or die('Cannot select database');

$sqlEpicrisis = mysql_query("SELECT * 
				FROM epicrisismatrona
				WHERE epimatctaCte = '$ctaCte'") or die("Error al seleccionar la epicrisis ".mysql_error());
				
$arrayEpicrisis = mysql_fetch_array($sqlEpicrisis);

$idEpicrisis = $arrayEpicrisis['epimatId'];
$epiEstado = $arrayEpicrisis['epimatEstado'];

if($idEpicrisis > 0){
$existeEpi = 1;
}else{
	$existeEpi = 0;
	}

//OBTIENE LOS TIPOS DE EDUCACIONES 
	
$sqlEduca = "SELECT *
			FROM
			educapac WHERE educaTipo = 'MA'";
$queryEduca = mysql_query($sqlEduca) or die($sqlEduca." ERROR AL SELECCIONAR EDUCACIONES ".mysql_error());

//OBTIENE LOS TIPOS DE CONSEJERIAS
	
$sqlConsejo = "SELECT *
				FROM
				consejerias";
$queryConsejo = mysql_query($sqlConsejo) or die($sqlConsejo." ERROR AL SELECCIONAR consejerias ".mysql_error());

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

//mysql_select_db('paciente') or die('Cannot select database');

$queryCR = mysql_query($sqlCR) or die("Error al seleccionar los CR ".mysql_error());
$arrayCR = mysql_fetch_array($queryCR);

$nomCR = $arrayCR['nombre'];
$serv_paciente = $arrayCR['servicio'];		

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

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
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

$().ready(function() {
	
	$("#matronas").autocomplete("epicrisisDoc/autocompleta/sqlMatronas.php", {
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
	setInterval('mostrarOcultarTablas()',10);
	//setInterval('disableResponsable()',10);
	
}
</script>

<body>
<?
$nombreCompleto = str_replace("�","n",$nombreCompleto);
$nombreCompleto = str_replace("�","N",$nombreCompleto)
?>
<form name="epiMedica" id="epiMedica" method="post">
<input type="hidden" name="id_cama" value="<? echo $id_cama; ?>" />
<input type="hidden" name="nombrePaciente" value="<? echo $nombreCompleto; ?>" />
<input type="hidden" name="id_paciente" value="<? echo $id_paciente; ?>" />
<input type="hidden" name="idServicio" value="<? echo $idServicio; ?>" />
<input type="hidden" name="ctaCte" value="<? echo $ctaCte; ?>" />
<input type="hidden" name="idEpicrisis" value="<? echo $idEpicrisis; ?>" />
<input type="hidden" name="prev_paciente" value="<? echo $prev_paciente; ?>" />
<input type="hidden" name="serv_paciente" value="<? echo sanear_string($serv_paciente); ?>" />
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
<input type="hidden" name="idParto" id="idParto" value="<? echo $idParto; ?>" />
<input type="hidden" name="tablaOculta" id="tablaOculta"  />
<input type="hidden" name="desde" id="desde" value="<? echo $desde; ?>" />

<table align="center">
	<tr>
		<td colspan="2">
        <table >
        <tr>
            <td width="50"><img src="../../equipos/Reportes/img/logo.jpg" width="126" height="99" /></td>
            <td width="561" align="left" class="titulocampo" >&nbsp;Servicio de Salud de Arica<br />&nbsp;Hospital en Red &quot;Dr. Juan No&eacute; C.&quot;</td>
            <td width="153" align="right" class="titulocampo" ><?php echo date('d-m-Y'); ?></td>
        </tr>
        <tr>
            <td colspan="3" align="center" class="titulo"><strong>EPICRISIS DE MATRONERIA CENTRO DE RESPONSABILIDAD<br /><? echo $nomCR; ?></strong></td>
          </tr>
                    
          <tr>
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
                    <td width="302" class="titulosSec" >&nbsp;<? echo $nombreCompleto; ?></td>
                    <td width="103" class="titulocampo">Rut:</td>
                    <td width="271" class="titulosSec"><? echo $rutPac; ?>-<? echo ValidaDVRut($rutPac); ?>
                    <input type="hidden" name="epiRut" id="epiRut" value="<? echo $rutPac; ?>" />
                    </td>
                </tr>
                <tr>
                    <td class="titulocampo">N&deg; Ficha</td>
                    <td class="titulosSec"><? echo $arrayPaciente['nroficha']; ?></td>
                    <td class="titulocampo">Prevision:</td>
                    
                    <td class="titulosSec"><? echo $prev_paciente; ?></td>
                </tr>
                <tr>
                    <td class="titulocampo">Direccion:
                    </td>
                    <td class="titulosSec"><? echo sanear_string($arrayPaciente['direccion']); ?></td>
                    <input type="hidden" name="direccion" id="direccion" value="<? echo sanear_string($arrayPaciente['direccion']); ?>" />
                    <td class="titulocampo">Genero:</td>
                    
                    <td class="titulosSec"><? echo $sexoPaciente; ?></td>
                </tr>
                 <tr>
                    <td class="titulocampo">Edad:
                    </td>
                    <td class="titulosSec"><? echo calculoAMD($arrayPaciente['fechanac'])?></td>
                    <td class="titulocampo">Servicio:</td>
                    
                    <td class="titulosSec"><? echo sanear_string($serv_paciente); ?></td>
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
              <table width="748" >
                  <tr>
                    <td width="157" class="titulocampo">Fecha Ingreso:</td>
                    <? if($existeEpi == 0){ $fechaI = cambiarFormatoFecha($ing_paciente); }else{ $fechaI = cambiarFormatoFecha(substr($hospitaliza,0,10)); }?>
                    <td width="161"><input style="width:75px" id="f_date" name="ingFecha" value="<? echo $fechaI; ?>" readonly="readonly"/><input type="Button" id="f_btn" value="&nbsp;" class="botonimagen"/></td>
                    <td width="106" class="titulocampo">Fecha Egreso:</td>
                    <? if($existeEpi == 0){ $fechaA = date('d-m-Y'); }else{ $fechaA = cambiarFormatoFecha($arrayEpicrisis['epimatFechaEgr']); }?>
                    <td width="103"><input style="width:75px" id="f_date1" name="altFecha" value="<? echo date("d-m-Y"); ?>" readonly="readonly"/><input type="Button" id="f_btn1" value="&nbsp;" class="botonimagen"/></td>
                    <td width="92" class="titulocampo">Dias Estadia:</td>
                    <td colspan="2" width="101" class="titulocampo"><span class="titulosSec">
                      <input style="width:35px" id="difDias" name="difDias" readonly="readonly" />
dias</span></td>
                 
                  </tr>
                  <tr>
                  	<td class="titulocampo">Diagnostico de Egreso:</td>
                    <td colspan="5"><input name="matronaDiag" onkeypress="return soloLetrasSinCaracteresEespeciales(event)" type="text" id="matronaDiag" size="90" value="<? echo $arrayEpicrisis['epimatDiagn']; ?>" /></td>
                  </tr>
                  
                  
                  <tr>
                  	<td class="titulocampo">Intervencion:</td>
                    <td colspan="5"><input name="matronaInter" onkeypress="return soloLetrasSinCaracteresEespeciales(event)" type="text" id="matronaInter" value="<? echo $arrayEpicrisis['epimatInterv']; ?>" size="90" /></td>
                  </tr>
                  <? if($idParto > 0){ ?>
                  <tr>
                  	<td class="titulocampo">Tipo de Parto:</td>
                    <td>
                    <select name="tipoParto" id="tipoParto" >
                    	<? if($arrayEpicrisis['epimatTipoParto']){ $tipoParto = $arrayEpicrisis['epimatTipoParto']; } else{ $tipoParto = $arrayParto['TIid']; }?>
                        <option value="0" <? if($tipoParto == ''){ echo "selected"; } ?> >No Corresponde</option>
                    	<option value="1" <? if($tipoParto == 1){ echo "selected"; } ?> >Cesarea</option>
                        <option value="2" <? if($tipoParto == 2){ echo "selected"; } ?>>Forcep</option>
                        <option value="3" <? if($tipoParto == 3){ echo "selected"; } ?>>Normal</option>
                    </select>
                    </td>
                    <td class="titulocampo">Episiotomia:</td>
                    <td class="titulosSec"><label>
                    <? if($arrayEpicrisis['epimatEpisio']){ $in_episio = $arrayEpicrisis['epimatEpisio']; }else{ $in_episio = $arrayParto['PAepisiotomia']; }?>
                          <input type="radio" name="episio" value="SI" <? if($in_episio == 'SI'){ ?> checked="checked" <? } ?> id="episio" />
                          Si</label>
                        
                        <label>
                          <input type="radio" name="episio" <? if($in_episio == 'NO'){ ?> checked="checked" <? } ?> value="NO" id="episio" />
                          No</label>
                    </td>
                    <td class="titulocampo">Desgarros:</td>
                    <td class="titulosSec"><label>
                    <? if($arrayEpicrisis['epimatDesg']){ $in_desgarro = $arrayEpicrisis['epimatDesg']; }else{ $in_desgarro = $arrayParto['PAdesgarro'];}?>
                          <input type="radio" name="desgarro" <? if($in_desgarro == 'SI'){ ?> checked="checked" <? } ?> value="SI" id="desgarro" />
                          Si</label>
                        
                        <label>
                          <input type="radio" name="desgarro" <? if($in_desgarro == 'NO'){ ?> checked="checked" <? } ?> value="NO" id="desgarro" />
                    No</label></td>
                  </tr>
                  <tr>
                  	<td class="titulocampo">Recien Nacido:</td>
                    <td>
                    <select name="estadoRN" id="estadoRN">
                    <? if($arrayEpicrisis['epimatEstadorn']){ $estadoRN = $arrayEpicrisis['epimatEstadorn']; }else{ $estadoRN = $arrayParto['RNestado']; } ?>
                    	<option value="" <? if ($estadoRN == '') { echo "selected"; } ?> >No Corresponde</option>
                        <option value="V" <? if ($estadoRN == 'V') { echo "selected"; } ?> >Vivo</option>
                        <option value="M" <? if ($estadoRN == 'M'){ echo "selected"; } ?> >Mortinato</option>
                        <option value="N" <? if ($estadoRN == 'N'){ echo "selected"; } ?> >Neomortinato</option>
                    </select>
                    </td>
                    <td class="titulocampo">Hospitalizacion:</td>
                    <td class="titulosSec"><label>
                          <? if($arrayEpicrisis['epimatHosprn']){ $in_hosprn = $arrayEpicrisis['epimatHosprn']; }else{ if($arrayParto['DESid'] == 2){ $in_hosprn = 'SI'; }else{ $in_hosprn = 'NO'; } }?>
                          <input type="radio" <? if($in_hosprn == 'SI'){ ?> checked="checked" <? } ?> name="hospita" value="SI" id="hospita" />
                          Si</label>
                        
                        <label>
                          <input type="radio" <? if($in_hosprn == 'NO'){ ?> checked="checked" <? } ?> name="hospita" value="NO" id="hospita" />
                    No</label></td>
                    
                  </tr>
                  <tr>
                  	<td class="titulocampo">Malformacion:</td>
                    <td class="titulosSec"><label>
                    	<? if($arrayEpicrisis['epimatMalrn']){ $in_malforma = $arrayEpicrisis['epimatMalrn']; }else{ $in_malforma = $arrayParto['RNmalforma']; }?>
                          <input type="radio" <? if($in_malforma == 'si'){ ?> checked="checked" <? } ?> name="malforma" value="SI" id="malforma" />
                          Si</label>
                        
                        <label>
                          <input type="radio" <? if($in_malforma == 'no'){ ?> checked="checked" <? } ?> name="malforma" value="NO" id="malforma" />
                    No</label></td>
                    <td class="titulocampo">Detalle:</td>
                    <? if($arrayEpicrisis['epimatMalrncausa']){ $in_causamalrn = $arrayEpicrisis['epimatMalrncausa']; }else{ $in_causamalrn = $arrayParto['RNmalcausa']; }?>
                    <td colspan="3"><input onkeypress="return soloLetrasSinCaracteresEespeciales(event)" name="detalleMalfoma" type="text" size="44" value="<? echo $in_causamalrn; ?>" ></textarea></td>
                  </tr>
				  <? } ?>
                  
                  
                  <tr>
                  	<td class="titulocampo">Infeccion:</td>
                    <td class="titulosSec"><label>
                          <input type="radio" name="infeccion" <? if($arrayEpicrisis['epimatInfec'] == 'SI'){ ?> checked="checked" <? } ?>  value="SI" id="infeccion" />
                          Si</label>
                        
                        <label>
                          <input type="radio" name="infeccion" <? if($arrayEpicrisis['epimatInfec'] == 'NO'){ ?> checked="checked" <? } ?> value="NO" id="infeccion" />
                    No</label></td>
                    <td class="titulocampo">Multiresistente: </td>
                    <td colspan="3" class="titulosSec"><label>
                          <input type="radio" <? if($multiRes == 1){ ?> checked="checked" <? } ?> name="multires" value="SI" id="multires" />
                          Si</label>
                        
                        <label>
                          <input type="radio" <? if($multiRes == 0){ ?> checked="checked" <? } ?> name="multires" value="NO" id="multires" />
                          No</label></td>
                  </tr>
                                   
				  
                  <tr>
                    <td class="titulocampo">Destino:</td>
                    <td colspan="5">
                    
                    <select name="destinoPaciente" id="destinoPaciente" onchange="disableCombos()">
                    	<option value="0">Seleccione</option>
                    	<option value="1" <? if($arrayEpicrisis['epimatDestino'] == 1){ echo "selected"; } ?> >Domicilio</option>
                        <option value="2" <? if($arrayEpicrisis['epimatDestino'] == 2){ echo "selected"; } ?>>Traslado</option>
                        <option value="5" <? if($arrayEpicrisis['epimatDestino'] == 5){ echo "selected"; } ?>>Anatomia Patologica</option>
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
                  
                  
				</table>
				</fieldset>
            </td>
          </tr>
          
	  		<?
            	$textoFormato2 = "<strong>- <u>Otros Examenes</u></strong> &nbsp;<br/>
								<table border='1'>
								  <tr>
									<td width='180'>Examen</td>
									<td width='100'>Fecha</td>
									<td width='100'>Resultados</td>
								  </tr>
								  <tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								  </tr>
								  <tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>		
								  </tr>
								</table>
								<br/>";
				$textoFormato3 = "<strong>- <u>Examenes Pendientes</u></strong> &nbsp;<br/>
								<table border='1'>
								  <tr>
									<td width='180'>Examen</td>
									<td width='100'>Fecha</td>
									<td width='100'>Lugar</td>
								  </tr>
								  <tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								  </tr>
								  <tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>		
								  </tr>
								</table>
								<br/>
								<strong>Existencia de ex�menes con resultado pendiente se�alando claramente de cuales se trata, cu�ndo y d�nde deben retirarse y/o informarse. </strong>";
			?>
          <tr>
          	<td colspan="3">
            <fieldset><legend class="titulocampo">EXAMENES</legend>
              <table width="835" >
                  <tr>
                    <td width="119" class="titulocampo">VDRL:</td>
                    
                    <td width="77"><input name="vdrl" type="text" id="vdrl" value="<? echo $arrayEpicrisis['epimatVdrl']; ?>" size="10" onkeypress="return soloLetrasSinCaracteresEespeciales(event)"  /></td>
                    <td width="103" class="titulocampo">Hematocrito</td>
                    
                    <td width="80"><input name="hemato" type="text" id="hemato" value="<? echo $arrayEpicrisis['epimatHema']; ?>" onkeypress="return soloLetrasSinCaracteresEespeciales(event)"  size="10" /></td>
                    <td width="87" class="titulocampo">Urocultivo:</td>
                    <td width="89" class="titulocampo"><input name="urocu" value="<? echo $arrayEpicrisis['epimatUro']; ?>" type="text" id="urocu" size="10" onkeypress="return soloLetrasSinCaracteresEespeciales(event)" /></td>
                 
                  </tr>
                  <tr>
                    <td width="119" class="titulocampo">C. Endocervical:</td>
                    
                    <td width="77"><input name="endocer" type="text" id="endocer" value="<? echo $arrayEpicrisis['epimatEndo']; ?>" size="10" onkeypress="return soloLetrasSinCaracteresEespeciales(event)" /></td>
                    <td width="103" class="titulocampo">Loquiocultivo:</td>
                    
                    <td><input name="loquio" type="text" id="loquio" value="<? echo $arrayEpicrisis['epimatLoqui']; ?>" size="10" onkeypress="return soloLetrasSinCaracteresEespeciales(event)" /></td>
                    <td class="titulocampo">Otro:</td>
                    <td class="titulosSec"><label>
                  <input type="radio" name="otroExamen" <? if($arrayEpicrisis['epimatOtroexam'] == 'SI'){ ?> checked="checked" <? } ?> value="SI" id="otroExamen" />
                  Si</label>
                
                <label>
                  <input type="radio" name="otroExamen" <? if($arrayEpicrisis['epimatOtroexam'] == 'NO'){ ?> checked="checked" <? } ?> value="NO" id="otroExamen" />
                  No</label></td>
                  <td width="90" class="titulocampo">Exam. Pendientes:</td>
                  <td width="154" class="titulosSec"><label>
                  <input type="radio" name="pendExamen" <? if($arrayEpicrisis['epimatPend'] == 'SI'){ ?> checked="checked" <? } ?> value="SI" id="pendExamen" />
                  Si</label>
                
                <label>
                  <input type="radio" name="pendExamen" <? if($arrayEpicrisis['epimatPend'] == 'NO'){ ?> checked="checked" <? } ?> value="NO" id="pendExamen" />
                  No</label></td>
                  </tr>
                  <tr>
                  	<td colspan="6"><div id="tablaExamen" style=" display:none;"><textarea name="examenes" id="examenes" ><? if($arrayEpicrisis['epimatExamen']){ echo $arrayEpicrisis['epimatExamen']; }else{ echo $textoFormato2; } ?></textarea></div></td>
                  </tr>
                  <tr>
                  	<td colspan="6"><div id="tablaExamen2" style=" display:none;"><textarea name="examenPend" id="examenPend" ><? if($arrayEpicrisis['epimatPendexam']){ echo $arrayEpicrisis['epimatPendexam']; }else{ echo $textoFormato3; } ?></textarea></div></td>
                  </tr>
				</table>
              
                
                
				</fieldset>
            </td>
          </tr>
        </table>
   	  </td>
  </tr>
  
  <tr>
    <td colspan="2">
      <fieldset>
        <legend class="titulocampo">INDICACIONES AL ALTA</legend>
        <?	  		  
	  $textoFormato.= "<p><strong>1.<u>Regimen</u></strong> &nbsp; </p>
	  <table border='1'>
	  <tr>
		<td width='180'>Medicamento</td>
		<td width='100'>Dosis</td>
		<td width='50'>Horario</td>
		<td width='180'>Observacion</td>
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
	<p ><strong>2.<u>Controles </u></strong></p>
	  <table border='1'>
	  <tr>
		<td width='180'>Control en: </td>
		<td width='100'>Fecha </td>
		<td width='50'>Hora </td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	</table>
	<br/>";

	  ?>
        <table>
          <tr>
            <td>
              <textarea name="detalleEpi" id="detalleEpi" cols="90" rows="4"><? if($arrayEpicrisis['epimatIndica']){ echo $arrayEpicrisis['epimatIndica']; }else{ echo $textoFormato; } ?></textarea>
              </td>
            </tr>
          </table>
        </fieldset>
      
      </td>
  </tr>
  <tr>
  	<td colspan="3">
    <fieldset><legend class="titulocampo">EDUACIONES</legend>
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
																epimat_has_educa
																WHERE epimat_has_educa.epimatId = $idEpicrisis
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
  <tr>
  	<td colspan="3">
    <fieldset><legend class="titulocampo">CONSEJERIAS</legend>
    	<table>
        	<tr>
            	<td class="titulocampo">
                      <? 
					  
                      while($arrayConsejo = mysql_fetch_array($queryConsejo)){ 
                                
								$idConsejo = $arrayConsejo['consejoId'];
                                $nomConsejo = $arrayConsejo['consejoDesc'];
								
								if($idEpicrisis > 0){
									mysql_select_db('epicrisis') or die('Cannot select database');	
									$sqlepiConsejo = mysql_query("SELECT *
																FROM
																epimat_has_consejo
																WHERE epimat_has_consejo.epimatId = $idEpicrisis
																AND consejoId = $idConsejo") or die("ERROR AL SELECCIONAR EDUCACIONES DEL PACIENTE ". mysql_error());

									$arrayepiConsejo = mysql_fetch_array($sqlepiConsejo);
									$consejoSelec = $arrayepiConsejo['consejoId'];
									
										if($consejoSelec == $idConsejo){
											 
											$flagConsj = 1;
											}else{
												$flagConsj = 0;
												}
									
								}
                      ?>
                        <input type="checkbox" <? if($flagConsj == 1){ ?> checked="checked" <? } ?> name="consejoArray[<? echo $idConsejo; ?>]" value="<? echo $idConsejo; ?>" /><? echo $nomConsejo; ?><br />
                      <?  } ?>
                        </td>
            </tr>
        </table>
    </fieldset>
    </td>
  </tr>
  <tr><td colspan="2">&nbsp;</td></tr> 
  <tr>
  	<td colspan="2">
      <fieldset><legend class="titulocampo">RESPONSABLE RECEPCION INDICACIONES</legend>
        <table>
        	<tr>
            	<td class="titulosSec">
                  <p>
                    <label>
                      <input onclick="disableResponsable()" type="radio" name="responsable" value="paciente" id="responsable" <? if(($arrayEpicrisis['epimatResp'] == 'paciente') or ($arrayEpicrisis['epimatResp'] == '')){ ?> checked="checked" <? } ?> />
                      Paciente</label>
                    
                    <label>
                      <input onclick="disableResponsable()" type="radio" name="responsable" value="tutor" id="responsable" <? if($arrayEpicrisis['epimatResp'] == 'tutor'){ ?> checked="checked" <? } ?> />
                      Tutor</label>
                    
                    <label>
                      <input onclick="disableResponsable()" type="radio" name="responsable" value="legal" id="responsable" <? if($arrayEpicrisis['epimatResp'] == 'legal'){ ?> checked="checked" <? } ?> />
                      Representante Legal</label>
                </p>
                </td>
            </tr>
            <tr>
            	<td class="titulocampo">Nombre:<input type="text" onkeypress="return soloLetrasSinCaracteresEespeciales(event)" name="nomResp" value="<? echo $arrayEpicrisis['epimatRespNom']; ?>" id="nomResp" size="30" /></td>
            </tr>
        </table>
      </fieldset>
  	</td>
  </tr>
  <tr class="titulocampo">
    <td >Matrona(o):<input name="matronas" id="matronas" type="text" size="80" value="<? echo $arrayEpicrisis['epimatMatrona'];?>"/>
    <input name="idUsuario" id="idUsuario" type="hidden" size="80" value="<? echo $usuario; ?>"/>
    </td>
  </tr>
  <tr>
  	<td colspan="2">
    	<table align="center">
        	<tr>
            	<td>
                <? if($desde=='Pensionado'){?>
                <input type="button" name="salir" value="Salir" onclick="window.location.href='<? echo "../../pensionado/mapa_camas.php"; ?>'" />
                <? }else{ ?>
                <input type="button" name="salir" value="Salir" onclick="window.location.href='<? echo "altapaciente.php?id_cama=$id_cama"; ?>'" />
                <? } ?>
                </td>
                <td><input type="button" name="btn_grabar3" value="Grabar" onclick="document.epiMedica.action='grabaEpicrisisMat.php';document.epiMedica.submit();"/></td>
                <td><input type="button" name="btn_imprimir" value="Cerrar Epicrisis" onclick="validar_formulario_matrona();"  /></td>
               			
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
        //]]>
</script>
</html>