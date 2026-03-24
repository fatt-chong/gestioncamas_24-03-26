<? 
if(!isset($_SESSION)) 
	session_start(); 
if( $_SESSION['MM_Username'] == null ) {
	$GoTo = "../../cma/renovarSession.php?urlOrigen=../gestioncamas/superNumeraria/camaSuperNum.php";
	header(sprintf("Location: %s", $GoTo));
}
//date_default_timezone_set('America/Santiago');
$runusuario = $_SESSION['MM_RUNUSU'];
require_once("include/funciones/funciones.php");

//PARAMETROS
if($_GET['HOSid'])
	$HOSid = $_GET['HOSid'];
if($_POST['HOSid'])
	$HOSid = $_POST['HOSid'];
if($_GET['PACid'])
	$PACid = $_GET['PACid'];
if($_POST['PACid'])
	$PACid = $_POST['PACid'];
	
mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');
mysql_select_db('camas') or die('Cannot select database');
$sqlCamaSN = mysql_query("SELECT *
						FROM
						camassn
						LEFT JOIN listasn ON listasn.idCamaSN = camassn.codCamaSN WHERE idListaSN = '$HOSid'") or die ("ERROR AL SELECCIONAR DATOS DE CAMA SN ". mysql_error());

$arrayCamaSN = mysql_fetch_array($sqlCamaSN);
$idCamaSN = $arrayCamaSN['idListaSN'];
$digito = generaDigito($arrayCamaSN['rutPacienteSN']);
$idPaciente = $arrayCamaSN['idPacienteSN'];
$nom_paciente = $arrayCamaSN['nomPacienteSN'];
$rut_paciente = $arrayCamaSN['rutPacienteSN'];
$ficha_paciente = $arrayCamaSN['fichaPacienteSN'];
$prevision_paciente = $arrayCamaSN['nomPrevisionSN'];
$cta_cte = $arrayCamaSN['ctaCteSN'];
$estado_ctacte = $arrayCamaSN['estadoctacteSN'];
$cod_prevision = $arrayCamaSN['codPrevisionSN'];
$fecha_ingresoSN = $arrayCamaSN['fechaIngresoSN'];
$multiRes = $arrayCamaSN['multiresSN'];
$fecha_hosp = $arrayCamaSN['hospitalizadoSN'];
$que_id_cama = $arrayCamaSN['que_idcamaSN'];
$id_servicio = $arrayCamaSN['que_codServSN'];
$codMedico =  $arrayCamaSN['codMedicoSN'];
$nomMedico =  $arrayCamaSN['nomMedicoSN'];
$pert_servicio = $arrayCamaSN['desde_codServSN'];
$permisos = $_SESSION['permiso'];

function homologaServicio2($idServicio){
		mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');
		mysql_select_db('camas') or die('Cannot select database');
		$sql = mysql_query("SELECT
				sscc.id,
				sscc.id_rau,
				sscc.servicio
				FROM sscc
				WHERE id = '$idServicio'") or die ("ERROR AL SELECCIONAR DATOS DE CAMA SN ". mysql_error());

		$RSquery = mysql_fetch_array($sql);
		return ($RSquery);
		}


$arrayServicio=homologaServicio2($pert_servicio);
$codigoServicio=$arrayServicio['id_rau'];

require_once('../../gestionCamas2/clases/Conectar.inc'); $objConectar = new Conectar; $link = $objConectar->db_connect();
require_once("../../gestionCamas2/clases/Evaluacionsocial.inc"); $objEvaluacionsocial = new Evaluacionsocial;
$validaEvaluacionsocial= $objEvaluacionsocial->buscarEvaluacionsocial($link,$cta_cte);

$categorizacion = $arrayCamaSN['categorizaRiesgoSN'].$arrayCamaSN['categorizaDepSN'];

switch($arrayCamaSN['categorizaRiesgoSN']){
	case('A'):
		$estiloInp = 'style="background:#77C96E"';
	break;
	case('B'):
		$estiloInp = 'style="background:#EEDC19"';
	break;
	case('C'):
		$estiloInp = 'style="background:#EF9C3F"';
	break;
	case('D'):
		$estiloInp = 'style="background:#F74D43"';
	break;
	case(''):
		$estiloInp = 'style="background:#A9A9A9"';
	break;
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!--<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />-->
<link type="text/css" rel="stylesheet" href="css/estilo.css" />


<link href="../../gestionCamas2/include/maestro.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../../gestionCamas2/include/jquery/css/custom/jquery-ui-1.10.3.custom.css">
<script src="../../estandar/jquery/js/jquery-1.9.1.js"></script>
<script src="../../estandar/jquery/js/jquery-ui-1.10.3.custom.js"></script>
<script type="text/javascript" src="include/funciones/funcionesJavaScript.js"></script>
<title>Detalle Atencion</title>
<script type="text/javascript">

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

window.onload=function(){
	setInterval('barthel(form1)',10);	
}

</script>
<script type="text/javascript">
	function validaalta(){
		 var respuesta = validarProcesos('../../gestionCamas2/interfaz/dialog/dialogoSolicitudAlta.php','&cta_cte=<?=$cta_cte;?>&runusuario=<?=$runusuario;?>&accion=1');
		 mensajeUsuario("warning","resultado de solicitud",respuesta)
	}
	function ventanaModalIFrame(url,parametros,alto,ancho,titulo,div){
	  
	  var tag = $("<div id='"+div+"'></div>");
		   mensaje="<div><iframe src='"+url+'?'+parametros+"' width='"+ancho+"' height='"+alto+"' border='0'></iframe></div>";
		tag.html(mensaje).dialog({
		title: titulo, 
		width: 'auto', 
		height: 'auto',
		modal: true, 
		draggable: true,
		resizable: false,
		//dialogClass: 'dlg-no-title',
		buttons: [ 
		
		{ 
		text: "Salir", 
		id: "btnCerrar", 
		click: function() { 
		tag.dialog('destroy');
		} 
		}
		],
		close: function(event, ui) { 
		tag.dialog('destroy'); 
		}
		  }).dialog('open');
	  
	}
	function dialogoRegistroKit(url,parametros,titulo){
		ventanaModalIFrame(url,parametros,'850px','1100px',titulo,'reg_prod')	
	}
	function dialogoRegistroProd(url,parametros,titulo){
		ventanaModalIFrame(url,parametros,'850px','1100px',titulo,'reg_prod')	
	}
	function dialogoRegistroPres(url,parametros,titulo){
		ventanaModalIFrame(url,parametros,'850px','1100px',titulo,'reg_pres')	
	}

</script>
</head>

<body>
<?
if($desde=='sscc'){
	$enlace =  "../ingresos/sscc.php";
	}else{ 
		$enlace = "camaSuperNum.php";
} 
?>
<form id="form1" name="form1" method="post" action="">
<input type="hidden" name="PACid" id="PACid" value="<? echo $PACid; ?>"/>  
  <fieldset class="fondoF"><legend class="estilo1">Detalle Paciente</legend>
  <table align="center" cellpadding="4" cellspacing="4">
	<tr>
    <td>
    	<div class="menu_simple">
            <ul>
                <li onclick="window.location.href='<?= "modifica_ingresoSN.php?HOSid=$HOSid&PACid=$PACid"; ?>'"><a href="#" >Modificar Ingreso</a>
                    </li>
				<?
				 if( array_search(277, $permisos) != NULL ){ 
				 	if($desde != 'sscc'){ 
						if($id_servicio != 46){ ?>
                    <li onclick="window.location.href='<?= "cambiarCamaSN.php?id_cama=$idCamaSN"; ?>'"><a href="#" >Cambiar Cama</a>
                    </li>
                    <? } } 
					if(($estado_ctacte != 4) and (array_search(23, $permisos) != NULL )){
					?>
                    <li onclick="window.location.href='<?= "generaaltaSN.php?id_cama=$idCamaSN&egreso=traslado&desde=$desde"; ?>'"><a href="#" >Traslado otro Servicio</a></li>
					<? } 
					if($estado_ctacte == 4){ ?>
                    <li onclick="window.location.href='<?= "generaaltaSN.php?id_cama=$idCamaSN&egreso=alta&desde=$desde"; ?>'"><a href="#" >Alta o Egreso</a></li>
                    <? } 
                    
					 if($fecha_ingresoSN < date('Y-m-d')){
					 if ( array_search(24, $permisos) != null ) {?>
                    <li onclick="window.location.href='<?= "categorizaSN.php?id_cama=$idCamaSN&id_paciente=$idPaciente&desde=$desde"; ?>'"><a href="#" >Categorizacion</a></li>
                    <li onclick="window.location.href='<?= "dialogoEvaluacionsocial.php?id_cama=$idCamaSN&id_paciente=$idPaciente&desde=$desde"; ?>'"><a href="#" >SCORE RIESGO SOCIAL</a></li>
                	<? }} if ( array_search(24, $permisos) != null ) {?>
                    <li onclick="window.location.href='<?=  "../../historialclinico/Interfaz/resumenHistorial.php?id_cama=$HOSid&pacId=$idPaciente&rut=$rut_paciente&act=sn"; ?>'"><a href="#" >Historial Clinico</a></li>
                    
                    <li onclick="window.location.href='<?= "../ingresos/historicopaciente.php?id_cama=$id_cama&nom_paciente=$nom_paciente&id_paciente=$idPaciente&camaSN=1"; ?>'"><a href="#" >Historico Paciente</a></li>
                    <? } 
					if ( array_search(243, $permisos) != null ) {
						if(($pert_servicio == 2 ) or ($pert_servicio == 3) or ($pert_servicio == 4) or ($pert_servicio == 1 ) or ($pert_servicio == 5 ) or ($pert_servicio == 8 ) or ($pert_servicio == 9 )){{
					?>                   
                    <li onclick="window.location.href='<?= "../ingresos/epicrisisMedicaModificada.php?id_cama=$que_id_cama&ctaCte=$cta_cte&id_paciente=$idPaciente&idServicio=$pert_servicio&prev_paciente=$prevision_paciente&cod_prev=$cod_prevision&ing_paciente=$fecha_ingresoSN&multiRes=$multiRes&hospitaliza=$fecha_hosp&medicoGC=".$codMedico." - ".$nomMedico."&cama_sn=1"; ?>'"><a href="#" >Epicrisis Medica</a></li>
                    <? }
					}}
					?>
					<!-- ingreso de insumo prestaciones y kit -->
					<li onclick="dialogoRegistroKit('../../pensionado/reg_producto/ing_kits.php','cta=<?= $cta_cte; ?>&id_cama=<?= $HOSid;?>&servicio=<?= $codigoServicio?>&rut=<?=$rut_paciente?>','Ingreso Kit')"><a href="#">Ingreso Kit</a></li>
            
		            <li onclick="dialogoRegistroProd('../../pensionado/reg_producto/ing_pro_pac.php','cta=<?= $cta_cte; ?>&id_cama=<?= $HOSid;?>&servicio=<?= $codigoServicio?>','Ingreso Insumo')"><a href="#">Ingreso Insumo</a></li>
		            
		            <li onclick="dialogoRegistroPres('../../pensionado/reg_prestaciones/ing_pre_pac.php','cta=<?= $cta_cte; ?>&id_cama=<?= $HOSid;?>&servicio=<?= $codigoServicio?>','Ingreso Prestaciones')"><a href="#">Ingreso Prestaciones</a></li>
		            <!-- fin del ingreso de insumo prestaciones y kit -->

					<?
					if (($pert_servicio != 10 ) and ($pert_servicio != 45 ) and ($pert_servicio != 14 ) or ($pert_servicio == 11)){
					if ( array_search(245, $permisos) != null ){ ?>
                    <li onclick="window.location.href='<?= "../ingresos/epicrisisEnfermera.php?id_cama=$que_id_cama&ctaCte=$cta_cte&id_paciente=$idPaciente&idServicio=$id_servicio&prev_paciente=$prevision_paciente&cod_prev=$cod_prevision&ing_paciente=$fecha_ingresoSN&multiRes=$multiRes&hospitaliza=$fecha_hosp&cama_sn=1"; ?>'"><a href="#" >Epicrisis Enfermeria</a></li>
                    
                    <? }
					 } 
					if ( array_search(362, $permisos) != null )
					?>
                    <li onclick=""><a href="#" >Epicrisis Matroneria</a></li>
                    <? } ?>
                 <? if (array_search(362, $permisos) != null or array_search(245, $permisos) != null) {?>   
                <li onclick="validaalta();"><a href="#">Solicitud de Alta</a></li>
                <? }?>
                <li onclick="window.location.href='<? echo $enlace; ?>'"><a href="#" >Salir</a>
                </li>
            </ul>
        </div>
    </td>
    <td valign="top">
	
	<div align="center" >
    	<fieldset >
        	<table  border="0" cellspacing="1" cellpadding="1">
            	<tr height="10px">
	            </tr>

    	        <tr>
        	        <td width="10px">&nbsp;</td>
            	    <td>Servicio Clinico : <input size="20" type="text" name="pservicio" value="<?php echo $arrayCamaSN['desde_nomServSN']; ?>" readonly="readonly"/> Sala : <input size="10" type="text" name="pcama" value="<?php echo $arrayCamaSN['salaCamaSN']; ?>" readonly="readonly" /> Cama N° : <input size="3" type="text" name="pcama" value="<?php echo $arrayCamaSN['nomCamaSN']; ?>" readonly="readonly" /> Cama Correspondie a... <input size="15" type="text" name="pcama" value="<?php echo $arrayCamaSN['que_nomServSN']; ?>" readonly="readonly" />
					</td>
	            </tr>
    	    </table>
	    </fieldset>

	</div>
    
	<div  >

		<fieldset><legend>Datos Paciente</legend>
        
		  	<table  border="0" cellspacing="1" cellpadding="1">
		    	<tr height="10px"></tr>
		        <tr>
		            <td width="10px">&nbsp;</td>
		            <td width="67px">Rut</td>
		            <td><input size="9" type="text" name="prut" value="<? echo $rut_paciente; ?>" readonly="readonly" />
		              <input style="width:10px" type="text" name="pdv" value="<? echo $digito; ?>" readonly="readonly" />
		              N&deg; Ficha
		              <input size="10" type="text" name="pficha" value="<?php echo $ficha_paciente; ?>" readonly="readonly" />
		              Prevision
		              <input size="20" type="text" name="pprevision" value="<?php echo $arrayCamaSN['nomPrevisionSN']; ?>" readonly="readonly" />
                      <input size="2" type="text" name="categorizacion" value="<?php echo $categorizacion ?>" readonly="readonly" /></td>
		            <td width="45px">Fono1</td>
                    <td width="100px">
		              <input size="12" type="text" name="pfono1" value="<?php echo $arrayCamaSN['fono1SN']; ?>" readonly="readonly" /></td>
		            <td width="10px">&nbsp;</td>
	            </tr>
		        <tr>
		            <td>&nbsp;</td>
		            <td>Nombre</td>
		            <td><input size="81" type="text" name="pnombre" value="<?php echo $nom_paciente; ?>" readonly="readonly"  /></td>
		            <td>Fono2 </td>
                    <td>
		              <input size="12" type="text" name="pfono2" value="<?php echo $arrayCamaSN['fono2SN']; ?>" readonly="readonly" /></td>
		            <td>&nbsp;</td>
	          	</tr>
		      	<tr>
		            <td>&nbsp;</td>
		            <td>Dirección</td>
		            <td><input size="81" type="text" name="pdireccion" value="<?php echo $arrayCamaSN['direcPacienteSN']; ?>" readonly="readonly"/></td>
                </tr>
		      	<tr height="10px"></tr>
		  	</table>
		</fieldset>

        <fieldset><legend>Modifica Ingreso</legend>
                
        <?php /*?><IMG NAME="m4" SRC="../ingresos/img/p_bt_modihosp.gif" <? if( array_search(307, $permisos) != null ) { ?> onclick="window.location.href='<? echo "modifica_ingresoSN.php?HOSid=$HOSid&PACid=$PACid"; ?>'" <? } ?> BORDER="0" vspace="0" hspace="0"><?php */?>

            <table border="0" cellspacing="1" cellpadding="1">
                <tr height="10px">
                    <td width="10px"></td>
                	<td width="110px">Fecha Ingreso </td>
                    <td> <input size="9" type="text" name="pfecha" value="<? echo cambiarFormatoFecha($arrayCamaSN['fechaIngresoSN']); ?>" readonly="readonly" />
&nbsp;&nbsp; Hora <input size="4" type="text" name="hora_ingreso" value="<? echo substr($arrayCamaSN['horaIngresoSN'],0,5); ?>" readonly="readonly" />
&nbsp;&nbsp; Cta-Cte <input size="8" type="text" name="cta_cte" value="<? echo $arrayCamaSN['ctaCteSN']; ?>" readonly="readonly" />
&nbsp;&nbsp; <?php if ($servicio == 6 or $servicio == 7 or $servicio == 10 or $servicio == 11 or $servicio == 14) { ?>
Tipo Cama <input size="33" type="text" name="tipo_cama" value="<? echo $d_tipo_1." ".$d_tipo_2; ?>" readonly="readonly" /> <? } ?> 
                     </td>
                </tr>
                <tr>
                	<td colspan="3">
                		<table>
                			<tr>
			                    <td>&nbsp;&nbsp;&nbsp;I. Barthel: </td>
			                    <td>
				                    <input type="text" name="barthel" id="barthel" size="2px" value="<?= $arrayCamaSN['barthelSN']?>" readonly="readonly" />
				                    <input type="text" name="valorBart" id="valorBart" readonly="readonly" />
				                &nbsp;&nbsp;Cat: <input type="text" size="8px" value="<?= $categorizacion; ?>" readonly="readonly" <?= $estiloInp; ?> /></td>
				            </tr>
				            <tr>
				                <td>&nbsp;&nbsp;&nbsp;SCORE RIESGO SOCIAL</td>
				                <td><input type="text" name="EV" id="EV" class="casilla_50" value="<?=$validaEvaluacionsocial['total']?>" readonly="readonly">
	                                <? 
	                                    if($validaEvaluacionsocial['total']>=11){
	                                        echo "Alta Dependencia Social – Riesgo Severo";
	                                    }elseif($validaEvaluacionsocial['total']>=6 and $validaEvaluacionsocial['total']<=10){
	                                        echo "Mediana Dependencia Social – Riesgo Moderado";
	                                    }elseif($validaEvaluacionsocial['total']>=5 and $validaEvaluacionsocial['total']<=1){
	                                        echo "Baja o Nula Dependencia Social – Riesgo Leve";
	                                    }else{echo "";}?>
	                            </td>
			                </tr>
                    	</table>
                    </td>
                </tr>
                <tr>
                    <td width="10px"></td>                
                    <td>Medico Tratante</td>
					<td><input size="55" type="text" name="pmedico" value="<?php echo $arrayCamaSN['nomMedicoSN']; ?>" readonly="readonly" /> 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Procedencia <input size="25" type="text" name="pprocedencia" value="<?php echo $arrayCamaSN['nomProcedenciaSN']; ?>" readonly="readonly" /> </td>
                </tr>
                <tr>
                    <td></td>
                    <td>Pre-Diagnostico</td>
                    <td ><input size="91" type="text" name="pdiagnostico1" value="<?php echo $arrayCamaSN['diagnostico1SN']; ?>" readonly="readonly" /></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Diagnostico</td>
                    <td><input size="91" type="text" name="pdiagnostico2" value="<?php echo $arrayCamaSN['diagnostico2SN']; ?>" readonly="readonly" /></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="2">
					
						<input size='25' type='checkbox' name='pauge' value="<? echo $arrayCamaSN['codAugeSN']; ?>" <? if($arrayCamaSN['codAugeSN']){ ?> checked="checked" <? } ?> disabled="disabled" />Patologia Auge
						<input size="74" type="text" name="pdesauge" value="<?php echo $arrayCamaSN['nomAugeSN']; ?>" readonly='readonly' />
						<br/>										
					  	<input type='checkbox' <? if($arrayCamaSN['accTranSN']){ ?> checked="checked" <? } ?> name='pacctransito' disabled="disabled" />Acc. Transito
												
						<input type='checkbox' <? if($arrayCamaSN['multiresSN']){ ?> checked="checked" <? } ?> name='multires' disabled="disabled" />Multiresistente
					
                  </td>

                </tr>
                <tr>
                    <td>Visitas permitidas:</td>
                    <td><input type="number" name="visitas_max" id="visitas_max" class="casilla_50" min="0" max="20" value="<?=$arrayCamaSN['visitas_max'];?>"></td>
				</tr>
              <tr height="10px"> </tr>                
            </table>

        </fieldset>

	</div>

</td>
</table>
</fieldset>
</form>

<!--<div id="modal-hora"></div>-->
</body>
</html>