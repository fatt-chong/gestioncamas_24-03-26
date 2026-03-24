<?php
//date_default_timezone_set('America/Santiago');
//usar la funcion header habiendo mandado código al navegador
ob_start(); 
//end para header

if(!isset($_SESSION)) 
	session_start(); 
if( $_SESSION['MM_Username'] == null ) {
	$GoTo = "../../cma/renovarSession.php?urlOrigen=../gestioncamas/superNumeraria/camaSuperNum.php";
	header(sprintf("Location: %s", $GoTo));
}
$dbhost = $_SESSION['BD_SERVER'];
$permisos = $_SESSION['permiso'];

$id_cama = $_REQUEST['id_cama'];
$egreso = $_REQUEST['egreso'];
$desde = $_REQUEST['desde'];

require_once("include/funciones/funciones.php");

$permisos = $_SESSION['permiso'];

$fecha_egreso = date('d-m-Y');

$hora_egreso = date('H:i');

$sql = "SELECT *
		FROM
		listasn
		LEFT JOIN camassn ON listasn.idCamaSN = camassn.codCamaSN
		WHERE
		listasn.idListaSN = '$id_cama'";
		
mysql_connect ($dbhost,'gestioncamas','123gestioncamas');
mysql_select_db('camas') or die('Cannot select database');
$query = mysql_query($sql) or die(mysql_error());

$paciente = mysql_fetch_array($query);

if($paciente){ // VERIFICA QUE EXISTA EL REGISTRO

$para_desbloq = $paciente['que_idcamaSN'];
$codCamaSN = $paciente['idCamaSN'];
$nomSalaSN = $paciente['salaCamaSN'];
$nomCamaSN = $paciente['nomCamaSN'];
$tipo_traslado = $paciente['tipoTrasladoSN'];
$edad_paciente = edad($paciente['nacPacienteSN']);

//PACIENTE IBA HACIA ESTE SERVICIO
$a_codServSN = $paciente['desde_codServSN'];
$a_nomServSN = $paciente['desde_nomServSN'];

//PACIENTE UTILIZO CAMA DE ESTE SERVICIO
$cod_servicio = $paciente['que_codServSN'];
$desc_servicio = $paciente['que_nomServSN'];
$sala = $paciente['que_salaSN'];
$cama = $paciente['que_camaSN'];

//DESDE DONDE TRASLADARON AL PACIENTE
$cod_procedencia = $paciente['codProcedenciaSN'];
if($cod_procedencia > 1000){
	
	$sqlServicio = mysql_query("SELECT * FROM sscc WHERE id_rau = $cod_procedencia ");
	$arrayServicio = mysql_fetch_array($sqlServicio);
	$cod_procedencia = $arrayServicio['id'];
	}
$procedencia = $paciente['nomProcedenciaSN'];

$tipo_1 = $paciente['tipo1SN'];
$d_tipo_1 = $paciente['d_tipo1SN'];
$tipo_2 = $paciente['tipo2'];
$d_tipo_2 = $paciente['d_tipo2SN'];

$cta_cte = $paciente['ctaCteSN'];

$cod_medico = $paciente['codMedicoSN'];
$medico = $paciente['nomMedicoSN'];
$cod_auge = $paciente['codAugeSN'];
$auge = $paciente['nomAugeSN'];
$acctransito = $paciente['accTranSN'];
$multires = $paciente['multiresSN'];
$diagnostico1 = $paciente['diagnostico1SN'];
$diagnostico2 = $paciente['diagnostico2SN'];
$id_paciente = $paciente['idPacienteSN'];
$rut_paciente = $paciente['rutPacienteSN'];
$ficha_paciente = $paciente['fichaPacienteSN'];
$esta_ficha = $paciente['esta_fichaSN'];
$nom_paciente = $paciente['nomPacienteSN'];
$sexo_paciente = $paciente['sexoPacienteSN'];
$cod_prevision = $paciente['codPrevisionSN'];
$prevision = $paciente['nomPrevisionSN'];
$direc_paciente = $paciente['direcPacienteSN'];
$cod_comuna = $paciente['codComunaSN'];
$comuna = $paciente['nomComunaSN'];
$fono1_paciente = $paciente['fono1SN'];
$fono2_paciente = $paciente['fono2SN'];
$fono3_paciente = $paciente['fono3SN'];
$categorizacion_riesgo = $paciente['categorizaRiesgoSN'];
$categorizacion_dependencia = $paciente['categorizaDepSN'];
$hospitalizado = $paciente['hospitalizadoSN'];
$fecha_ingreso = $paciente['fechaIngresoSN'];
$hora_ingreso = $paciente['horaIngresoSN'];

$fecha_hospitalizacion = cambiarFormatoFecha2($fecha_ingreso);

$estadoAnt = $paciente['estadoAnteriorSN'];
$causaAnt = $paciente['causaAnteriorSN'];

if($egreso == "traslado")
{
	$sql = "SELECT * FROM sscc WHERE id < 46 AND ver = 1";
}
if($egreso == "alta")
{
	$cod_destino = "101";
	$sql = "SELECT * FROM sscc WHERE id IN (101, 102) or (id >=110 and id <= 115)";

}
mysql_connect ($dbhost,'gestioncamas','123gestioncamas');
mysql_select_db('camas') or die('Cannot select database');
$query = mysql_query($sql) or die(mysql_error());

$i = 0;

while($l_servicios = mysql_fetch_array($query))
{
	if (($l_servicios['id'] <> 51))
	{
		$id_servicios[$i] = $l_servicios['id'];
		$servicios[$i] = $l_servicios['servicio'];
		$i++;
	}
	
}

}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Gestion de Camas Hospital Dr. Juan Noé C.</title>

<link type="text/css" rel="stylesheet" href="css/estilo.css" />
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />

	<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>

    <script src="../calendario/src/js/jscal2.js"></script>
    <script src="../calendario/src/js/lang/es.js"></script>
    <link rel="stylesheet" type="text/css" href="../calendario/src/css/jscal2.css" />
    <link rel="stylesheet" type="text/css" href="../calendario/src/css/border-radius.css" />
    <link rel="stylesheet" type="text/css" href="../calendario/src/css/steel/steel.css" />

</head>

<body topmargin="5" style="font-family:Arial, Helvetica, sans-serif; font-size:12px">

<table  width="650px" align="center" cellspacing="0" cellpadding="0">
    	
        <tr>
            <td>
            	<fieldset class="fondoF"><legend class="estilo1">Egreso de Paciente (Alta, Traslado)</legend>
				<? if($paciente){ //VERIFICA QUE LE ARRAY TENGA INFORMACION ?>
                
				<div class="titulo" align="center">
<form method="get" action="sql_generaaltaSN.php">
<table width="70%" align="center" border="0" cellspacing="0" cellpadding="0" >
	<tr align="left">
		<td>
			<fieldset>
			<legend>Informacion de Egreso</legend>

            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr><td width="20px" height="20px"></td><td width="150px"></td><td></td></tr>
                <tr><td></td><td>Cama</td><td>: <? echo " Cama Nro ".$cama.", Sala ".$sala." ( ".$desc_servicio." )" ?> </td></tr>
                <tr><td></td><td>Paciente</td><td>: <? echo $nom_paciente ?> </td></tr>
                <tr><td></td><td>Nro Ficha</td><td>: <? echo $ficha_paciente ?> </td></tr>
                <tr><td></td><td>Cta-Cte</td><td>: <? echo $cta_cte ?> </td></tr>
                <tr><td></td><td>Medico</td><td>: <? echo $medico ?> </td></tr>
                <tr><td></td><td>Diagnostico</td><td>: <? echo $diagnostico2 ?> </td></tr>
                <tr><td></td><td>Hospitalizacion</td><td>: <? echo substr($hospitalizado, 8, 2)."-".substr($hospitalizado, 5, 2)."-".substr($hospitalizado, 0, 4)." / ".substr($hospitalizado, 11, 5)."  Hrs."; ?> </td></tr>
                <tr><td></td><td>Ingreso</td><td>: <? echo $fecha_hospitalizacion." / ".substr($hora_ingreso,0,5)." Hrs." ?> </td></tr>
	            <tr><td height="20px"></td><td></td></tr>
	                        
			</table>
			</fieldset>
		</td>
	</tr>
    	<input type="hidden" name="egreso" value="<? echo $egreso; ?>" />
    	<input type="hidden" name="para_desbloq" value="<? echo $para_desbloq; ?>" />
    	<input type="hidden" name="codServSN" value="<? echo $codServSN; ?>" />
		<input type="hidden" name="nomSalaSN" value="<? echo $nomSalaSN; ?>" />
        <input type="hidden" name="nomCamaSN" value="<? echo $nomCamaSN; ?>" /> 
		<input type="hidden" name="id_cama" value="<? echo $id_cama ?>" /> 
        <input type="hidden" name="tipo_traslado" value="<? echo $tipo_traslado ?>" />
        
		<input type="hidden" name="cod_servicio"  value="<? echo $cod_servicio ?>" />
		<input type="hidden" name="desc_servicio" value="<? echo $desc_servicio ?>" />
		<input type="hidden" name="sala" value="<? echo $sala ?>" />
   		<input type="hidden" name="cama" value="<? echo $cama ?>" />
        
        <input type="hidden" name="a_codServSN" value="<? echo $a_codServSN ?>" />
        <input type="hidden" name="a_nomServSN" value="<? echo $a_nomServSN ?>" />
        
        <input type="hidden" name="tipo_1" value="<? echo $tipo_1 ?>" />
        <input type="hidden" name="d_tipo_1" value="<? echo $d_tipo_1 ?>" />
        <input type="hidden" name="tipo_2" value="<? echo $tipo_2 ?>" />
        <input type="hidden" name="d_tipo_2" value="<? echo $d_tipo_2 ?>" />
        <input type="hidden" name="cta_cte" value="<? echo $cta_cte ?>" />
   		<input type="hidden" name="cod_procedencia" value="<? echo $cod_procedencia ?>" />
   		<input type="hidden" name="procedencia" value="<? echo $procedencia ?>" />
   		<input type="hidden" name="cod_medico" value="<? echo $cod_medico ?>" />
   		<input type="hidden" name="medico" value="<? echo $medico ?>" />
   		<input type="hidden" name="cod_auge" value="<? echo $cod_auge ?>" />
   		<input type="hidden" name="auge" value="<? echo $auge ?>" />
   		<input type="hidden" name="acctransito" value="<? echo $acctransito ?>" />
   		<input type="hidden" name="multires" value="<? echo $multires ?>" />
   		<input type="hidden" name="epiId" value="<? echo $epiId ?>" />
   		<input type="hidden" name="diagnostico1" value="<? echo $diagnostico1 ?>" />
   		<input type="hidden" name="diagnostico2" value="<? echo $diagnostico2 ?>" />
        
   		<input type="hidden" name="id_paciente" value="<? echo $id_paciente ?>" />
 		<input type="hidden" name="rut_paciente" value="<? echo $rut_paciente ?>" />
   		<input type="hidden" name="ficha_paciente" value="<? echo $ficha_paciente ?>" /> 
   		<input type="hidden" name="esta_ficha" value="<? echo $esta_ficha ?>" /> 
 		<input type="hidden" name="nom_paciente" value="<? echo $nom_paciente ?>" />
 		<input type="hidden" name="sexo_paciente" value="<? echo $sexo_paciente ?>" />
 		<input type="hidden" name="edad_paciente" value="<? echo $edad_paciente ?>" />
   		<input type="hidden" name="cod_prevision" value="<? echo $cod_prevision ?>" />
   		<input type="hidden" name="prevision" value="<? echo $prevision ?>" />
 		<input type="hidden" name="direc_paciente" value="<? echo $direc_paciente ?>" />
   		<input type="hidden" name="cod_comuna" value="<? echo $cod_comuna ?>" />
   		<input type="hidden" name="comuna" value="<? echo $comuna ?>" />
 		<input type="hidden" name="fono1_paciente" value="<? echo $fono1_paciente ?>" />
 		<input type="hidden" name="fono2_paciente" value="<? echo $fono2_paciente ?>" />
 		<input type="hidden" name="fono3_paciente" value="<? echo $fono3_paciente ?>" />
 		<input type="hidden" name="categorizacion_riesgo" value="<? echo $categorizacion_riesgo ?>" />
        <input type="hidden" name="categorizacion_dependencia" value="<? echo $categorizacion_dependencia ?>" />
		<input type="hidden" name="hospitalizado" value="<? echo $hospitalizado ?>" />
		<input type="hidden" name="fecha_ingreso" value="<? echo $fecha_ingreso ?>" />
		<input type="hidden" name="hora_ingreso" value="<? echo $hora_ingreso ?>" />
        <input type="hidden" name="estadoAnt" value="<? echo $estadoAnt ?>" />
        <input type="hidden" name="causaAnt" value="<? echo $causaAnt ?>" />
        <input type="hidden" name="desde" value="<? echo $desde ?>" />
        <input type="hidden" name="codCamaSN" value="<? echo $codCamaSN ?>" />
        <input type="hidden" name="barthelSN" value="<? echo $paciente['barthelSN']; ?>" />

	<tr align="left">
		<td>
			<fieldset>
			<legend>Informacion de Egreso</legend>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
		        <tr><td width="1" height="20px"></td><td width="162"></td><td width="424"></td></tr>
		        <tr><td></td><td> Destino</td>
                    <td>
                    <select name="cod_destino">
                    <?php
                        for($i=0; $i<count($servicios); $i++)
                        {
							if($id_servicios[$i] == $cod_destino)
							{
								echo "<option value='".$id_servicios[$i]."' selected>".$servicios[$i]."</option>";
							}
							else
							{
								echo "<option value='".$id_servicios[$i]."'>".$servicios[$i]."</option>";
							}
						}
                    ?>
                    </select>
                    </td>
	            </tr>
            
                <tr><td></td><td> Fecha </td>
                <td>
	                <span id="spry_fecha_egreso">
                    <input size="12" id="f_date4" name="fecha_egreso" value="<? echo $fecha_egreso ?>" 
					<?php if ( array_search(248, $permisos) != null ) { echo "enabled='enabled'"; } else { echo "readonly='readonly'"; }  ?> />
                    <input type="Button" id="f_btn4" value="....." 
					<?php if ( array_search(248, $permisos) != null ) { echo "enabled='enabled'"; } else { echo "disabled='disabled'"; }  ?> />
                    <span class="textfieldRequiredMsg">Ingrese Fecha!</span>
	                <span class="textfieldInvalidFormatMsg">Fecha Inválida</span>
    	            </span>
					
                    &nbsp;&nbsp;&nbsp;&nbsp; Hora
	                <span id="spry_hora_egreso">
    	            <input size="4"  id="hora_egreso" type="text" name="hora_egreso"  value="<? echo $hora_egreso ?>" />
        	        <span class="textfieldRequiredMsg">Ingrese Hora!</span>
            	    <span class="textfieldInvalidFormatMsg">Hora Inválida</span>
                	</span>
                </td></tr>

		        <tr><td width="1" height="20px"></td>
		        <td width="162">Info. al Paciente</td><td width="424">
                <select name="info_pac">
                	<option value="0" selected="selected">Si</option>
                    <option value="1">No</option>
                </select>
                </td></tr>
			</table>
			</fieldset>
		</td>
	</tr>
	<tr align="center">
		<td>
			<fieldset>
			<legend>¿ Esta Seguro de Realizar el Egreso de Paciente ?</legend>

            <table width="100%" border="0" cellspacing="0" cellpadding="10">
                
                <tr align="center">
                	<td> 
               			<input class="buttonGeneral" type="submit" name="Submit" value=" Aceptar " onchange="javascript:this.disabled= true;this.form.submit();" onclick="javascript:this.disabled= true;this.form.submit();" />
                    </td>
                    <td> 
                    	<input class="buttonGeneral" type="Button" value=" Cancelar " onClick="window.location.href='<? echo"detalleCamaSN.php?HOSid=$id_cama&PACid=$id_paciente&desde=$desde"; ?>'; parent.GB_hide(); " >
                    </td>
                </tr>
                    
			</table>
			</fieldset>
		</td>
	</tr>

</table>

</form>

<script type="text/javascript">
<!--
var spry_fecha_egreso = new Spry.Widget.ValidationTextField("spry_fecha_egreso", "date", {validateOn:["change"], useCharacterMasking:true, format:"dd-mm-yyyy"});
var spry_hora_egreso = new Spry.Widget.ValidationTextField("spry_hora_egreso", "time", {validateOn:["change"], useCharacterMasking:true});
//-->
</script>


      <script type="text/javascript">//<![CDATA[

      var cal = Calendar.setup({
          onSelect: function(cal) { cal.hide() }
      });
      cal.manageFields("f_btn4", "f_date4", "%d-%m-%Y");

    //]]></script>

 
</div>
				<? } else{ ?>
                	<div align="center">
                    <table width="359" style="font:Verdana, Geneva, sans-serif; font-size:12px;">
                    	<tr>
                        	<td width="306" height="39" align="center">¡El paciente selecciona ya ha sido dado de alta!</td>
                        </tr>
                        <tr>
                        	<td align="center"><input class="buttonGeneral" type="Button" value=" Volver " onClick="window.location.href='<? echo "camaSuperNum.php"; ?>'; parent.GB_hide(); " ></td>
                        </tr>
                    </table>
                  </div>	
				<? } ?>
              </fieldset>
			</td>
		</tr>
	</table>

</body>
</html>


<?php
//usar la funcion header habiendo mandado código al navegador
ob_end_flush();
//end header
?>

