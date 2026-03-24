<?

if(!isset($_SESSION)) 
	session_start(); 
if( $_SESSION['MM_Username'] == null ) {
	$GoTo = "../../cma/renovarSession.php?urlOrigen=camaSuperNum.php";
	header(sprintf("Location: %s", $GoTo));
}
$HOSid= $_GET['HOSid'];
$PACid= $_GET['PACid'];
//date_default_timezone_set('America/Santiago');

require_once("include/funciones/funciones.php");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="css/estilo.css" />

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
</head>
<?

$permisos = $_SESSION['permiso'];
$dbhost = $_SESSION['BD_SERVER'];
mysql_connect ($dbhost,'gestioncamas','123gestioncamas');
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
$cta_cte = $arrayCamaSN['ctaCteSN'];
$estado_ctacte = $arrayCamaSN['estadoctacteSN'];
$prevision = $arrayCamaSN['nomPrevisionSN'];
$fono1_paciente = $arrayCamaSN['fono1SN'];
$fono2_paciente = $arrayCamaSN['fono2SN'];
$serv_paciente = $arrayCamaSN['desde_nomServSN'];
$serv_cama = $arrayCamaSN['que_nomServSN'];
$cod_serv_paciente = $arrayCamaSN['desde_codServSN'];
$cod_medico = $arrayCamaSN['codMedicoSN'];
$procedencia = $arrayCamaSN['nomProcedenciaSN'];
$diagnostico1 = $arrayCamaSN['diagnostico1SN'];
$diagnostico2 = $arrayCamaSN['diagnostico2SN'];
$cod_auge = $arrayCamaSN['codAugeSN'];
$accTransito = $arrayCamaSN['accTranSN'];
$multiRes = $arrayCamaSN['multiresSN'];
$fecha_ingreso = cambiarFormatoFecha($arrayCamaSN['fechaIngresoSN']);


$permisos = $_SESSION['permiso'];

//MEDICOS
$sqlMedicos = "SELECT * FROM medicos order by medico";
	$queryMedicos = mysql_query($sqlMedicos) or die(mysql_error());

	$i = 0;
	while($l_medicos = mysql_fetch_array($queryMedicos)){
		$id_medicos[$i] = $l_medicos['id'];
		$medicos[$i] = $l_medicos['medico'];
		$i++;
	}
//PATOLOGIAS AUGE
$sqlAuge = "SELECT * FROM pauge";
	
	$queryAuge = mysql_query($sqlAuge) or die(mysql_error());
	$i = 0;
	while($l_pauge = mysql_fetch_array($queryAuge)){
		$id_pauge[$i] = $l_pauge['id'];
		$pauge[$i] = $l_pauge['pauge'];
		$i++;
	}

//SERVICIOS A LOS QUE PUEDE CORRESPONDER
$sqlServicios = "SELECT
				sscc.id,
				sscc.id_rau,
				sscc.servicio
				FROM `sscc`
				WHERE
				sscc.id < 46
				ORDER BY ID ASC";
$queryServicios = mysql_query($sqlServicios) or die($sqlServicios." ERROR AL SELECCIONAR SERVICIOS " .mysql_error());	
?>

<body>

<table align="center" width="850px" border="0" cellpadding="4" cellspacing="4" >

<tr>
<td >
<fieldset class="fondoF"><legend class="estilo1"> Modificar Ingreso Paciente</legend>

<div >

<form method="get" name="form1" id="form1" action="sql_modifica_ingresoSN.php">

    <input type="hidden" name="id_cama" value="<? echo $idCamaSN ?>" />


        <fieldset>
            <table width="100%" border="0" cellspacing="1" cellpadding="1">
                <tr height="10px">
                </tr>
                <tr>
                    <td width="10px">&nbsp;</td>
					<td>Paciente Corresponde a:</td>
                     <td>
                     	<select name="pac_corresponde_serv" id="pac_corresponde_serv">
                     		<? while($rsServicio = mysql_fetch_assoc($queryServicios)){ ?>
                            <option value="<?= $rsServicio['id']; ?>" <? if($cod_serv_paciente==$rsServicio['id']){ ?>selected="selected" <? } ?>><?= $rsServicio['servicio']; ?></option>
                            <? } ?>
                        </select>
                     </td>
                     <td>
                     Cta.Cte : <input disabled="disabled" size="8" type="text" name="cta_cte" value="<? echo $cta_cte; ?>"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                     Cama Corresponde a: 
					  <input size="20" type="text" name="pservicio" value="<?php echo $serv_cama; ?>" readonly="readonly"/>
                     </td>
                     
                </tr>
            </table>
        </fieldset>



	<fieldset><legend class="titulos">Paciente</legend>
		  <table width="830px" border="0" cellspacing="1" cellpadding="1">
        	<tr height="10px">
            </tr>
            <tr>
                <td width="10px">&nbsp;</td>
	            <td width="67px">Rut</td>
                <td> 
                  <input size="9" type="text" name="rut_paciente" value="<?php echo $rut_paciente; ?>" disabled="disabled" />
                <input size="1" type="text" name="dv_rut" value="<?php echo $digito ?>" disabled="disabled" /> 
                N&deg; Ficha 
                <input size="10" type="text" name="ficha_paciente" value="<?php echo $ficha_paciente; ?>" disabled="disabled" /> Prevision <input size="20" type="text" name="prevision" value="<?php echo $prevision; ?>" disabled="disabled" /></td>
		        <td width="45px">Fono1</td>
                <td width="100px">
                	<input size="12" type="text" name="fono1_paciente" value="<?php echo $fono1_paciente; ?>" disabled="disabled" />
				</td>
                <td width="10px">&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>        
                <td>Nombre</td>
                <td>
	           		<input size="81" type="text" name="nom_paciente" value="<?php echo $nom_paciente; ?>" disabled="disabled" />
                </td>
	            <td>Fono2 </td>
                <td>
                	<input size="12" type="text" name="fono2_paciente" value="<?php echo $fono2_paciente; ?>" disabled="disabled" />
                </td>
                <td>&nbsp;</td>
            </tr>
            
            <tr height="10px">
            </tr>
		</table>
	</fieldset>

    <fieldset><legend  class="titulos">Hospitalización</legend>
        <table width="830px" border="0" cellspacing="1" cellpadding="1">
			<tr>
                	<td>&nbsp;</td>
                    <td>I. Barthel: </td>
                    <td><input type="text" name="barthel" id="barthel" size="2px" value="<?= $arrayCamaSN['barthelSN']; ?>" />&nbsp;<input type="text" name="valorBart" id="valorBart" readonly="readonly" /></td>
                </tr>
            <tr>
                <td width="10px"></td>                
                <td>Medico Tratante</td>
	            <td><select name="cod_medico">
              	<?php
                for($i=0; $i<count($medicos); $i++)
                {
                     ?>
                       <option value=<? echo $id_medicos[$i];?> <? if($id_medicos[$i]==$cod_medico)
                    { echo 'selected'; } ?> > <? echo $medicos[$i]; ?></option>
              <? } ?>
				</select>
            	Procedencia
                <input size="20" type="text" name="nom_procedencia" value="<? echo $procedencia; ?>" readonly="readonly" /> 
                
                
            	</td>

            </tr>
            <tr>
                <td></td>
                <td>Pre-Diagn
                ostico</td>
                <td><input size="103" type="text" name="diagnostico1" value="<?php echo $diagnostico1; ?>" /></td>
            </tr>
            <tr>
                <td></td>
                <td>Diagnostico</td>
                <td><input size="103" type="text" name="diagnostico2" value="<?php echo $diagnostico2; ?>" /></td>
            
            </tr>
            <tr>
                <td></td>
                 <td>Patologia Auge </td>
                 <td>
    	    	    <select name="cod_auge">
					<option value=0 selected="selected">NO AUGE</option>
  	        	 	<?
    	    	    for($i=0; $i<count($pauge); $i++)
					{
					?>	
	        	    <option value=<? echo $id_pauge[$i]; ?> <? if($id_pauge[$i]==$cod_auge){ echo 'selected';} ?>><? echo substr($pauge[$i], 0, 70); ?></option>
					<? } ?>
					</select>
                    
                    <input type='checkbox' <? if($accTransito == 1){ ?> checked="checked" <? } ?> name='d_acctransito' />
                    Acc. de Transito
                    <input type='checkbox' <? if($multiRes == 1){ ?> checked="checked" <? } ?> name='d_multires' />
                    Multiresistente</td>
                    
            </tr>
            <tr>
            
            
            
                            <td></td>
                <td>Fecha Ingreso</td>
                <td><input size="9" disabled="disabled"  id="f_date1" type="text" name="fecha_ingreso"  value="<? echo $fecha_ingreso; ?>" />
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	
			  </td>            
        </tr>
          <tr>
                    <td></td>
                    <td>Visitas permitidas:</td>
                    <td><input type="number" name="visitas_max" id="visitas_max" class="casilla_50" min="0" max="20" value="<?=$arrayCamaSN['visitas_max'];?>"></td>
                </tr>
          <tr height="10px"> </tr>                
        </table>
 
    </fieldset>
	<div align="center">
    <br />
	<input type="submit" class="buttonGeneral" value=" Aceptar " >
		<input type="Button" class="buttonGeneral" value=    " Cancelar " onclick="window.location.href='<? echo"detalleCamaSN.php?HOSid=$HOSid&PACid=$PACid"; ?>'" /><br />
	
	</div>

</form>

</div>

</fieldset>
</td>
</tr>
</table>

</body>
</html>
