<?php
//date_default_timezone_set('America/Santiago');
//usar la funcion header habiendo mandado código al navegador
ob_start(); 
//end para header

if (!isset($_SESSION)) {
	session_start();
}
$dbhost = $_SESSION['BD_SERVER'];
if ( $_SESSION['MM_Username'] == null ) {
	$GoTo = "../../acceso/index.php";
	header(sprintf("Location: %s", $GoTo));
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

<body background="../../estandar/img/fdo.jpg" topmargin="5" style="font-family:Arial, Helvetica, sans-serif; font-size:12px">

<?
include "../funciones/funciones.php";

$permisos = $_SESSION['permiso'];

$fecha_egreso = date('d-m-Y');

$hora_egreso = date('H:i');

$id_cama = $_SESSION['MM_pro_id_cama'];



$sql = "SELECT * FROM camas where id = '".$id_cama."'";
mysql_connect ($dbhost,'gestioncamas','123gestioncamas');
mysql_select_db('camas') or die('Cannot select database');
$query = mysql_query($sql) or die(mysql_error());

$paciente = mysql_fetch_array($query);

$tipo_traslado = $paciente['tipo_traslado'];
$cod_servicio = $paciente['cod_servicio'];
$desc_servicio = $paciente['servicio'];
$sala = $paciente['sala'];
$cama = $paciente['cama'];
$tipo_1 = $paciente['tipo_1'];
$d_tipo_1 = $paciente['d_tipo_1'];
$tipo_2 = $paciente['tipo_2'];
$d_tipo_2 = $paciente['d_tipo_2'];
$cta_cte = $paciente['cta_cte'];
$cod_procedencia = $paciente['cod_procedencia'];
$procedencia = $paciente['procedencia'];
$cod_medico = $paciente['cod_medico'];
$medico = $paciente['medico'];
$cod_auge = $paciente['cod_auge'];
$auge = $paciente['auge'];
$acctransito = $paciente['acctransito'];
$multires = $paciente['multires'];
$epiId = $paciente['epiId'];
$diagnostico1 = $paciente['diagnostico1'];
$diagnostico2 = $paciente['diagnostico2'];
$id_paciente = $paciente['id_paciente'];
$rut_paciente = $paciente['rut_paciente'];
$ficha_paciente = $paciente['ficha_paciente'];
$esta_ficha = $paciente['esta_ficha'];
$nom_paciente = $paciente['nom_paciente'];
$sexo_paciente = $paciente['sexo_paciente'];
$edad_paciente = $paciente['edad_paciente'];
$cod_prevision = $paciente['cod_prevision'];
$prevision = $paciente['prevision'];
$direc_paciente = $paciente['direc_paciente'];
$cod_comuna = $paciente['cod_comuna'];
$comuna = $paciente['comuna'];
$fono1_paciente = $paciente['fono1_paciente'];
$fono2_paciente = $paciente['fono2_paciente'];
$fono3_paciente = $paciente['fono3_paciente'];
$categorizacion_riesgo = $paciente['categorizacion_riesgo'];
$categorizacion_dependencia = $paciente['categorizacion_dependencia'];
$estado = $paciente['estado'];
$hospitalizado = $paciente['hospitalizado'];
$fecha_ingreso = $paciente['fecha_ingreso'];
$hora_ingreso = $paciente['hora_ingreso'];
$id_parto = $paciente['id_parto'];
$barthel = $paciente['barthel'];

$fecha_usuario_ingresa = $paciente['fecha_usuario_ingresa'];
$usuario_que_ingresa = $paciente['usuario_que_ingresa'];

$fecha_hospitalizacion = cambiarFormatoFecha2($fecha_ingreso);



if($estado == 2)
{
	$sql = "SELECT * FROM sscc WHERE id < 46";
}
if($estado == 4)
{
	$cod_destino = "101";
	$sql = "SELECT * FROM sscc WHERE id > 100";

}
mysql_connect ($dbhost,'gestioncamas','123gestioncamas');
mysql_select_db('camas') or die('Cannot select database');
$query = mysql_query($sql) or die(mysql_error());

$i = 0;

while($l_servicios = mysql_fetch_array($query))
{
	if ( $l_servicios['id'] <> 51)
	{
		$id_servicios[$i] = $l_servicios['id'];
		$servicios[$i] = $l_servicios['servicio'];
		$i++;
	}
	
}


$sql = "SELECT * FROM camas where id_paciente = '".$id_paciente."' and id <> '".$id_cama."'";
//echo $sql;
mysql_connect ($dbhost,'gestioncamas','123gestioncamas');
mysql_select_db('camas') or die('Cannot select database');
$query_mensaje = mysql_query($sql) or die(mysql_error());

$pacienteencama = mysql_fetch_array($query_mensaje);

$mensaje = "";

if ($pacienteencama and $id_paciente<>0)
{
	$cod_destino = $pacienteencama['cod_servicio'];
	$fecha_egreso = cambiarFormatoFecha2($pacienteencama['fecha_ingreso']);
	$hora_egreso = substr($pacienteencama['hora_ingreso'],0,5);

	
	$mensaje = "Paciente ya fue ingresado al Servicio de ".$pacienteencama['servicio'].", el dia ".$fecha_egreso." a las ".$hora_egreso." Hrs.";
}


?>

	<table width="850px" align="center" border="2" bordercolor="#000000" bordercolorlight="#FFFFFF" bordercolordark="#666666" cellspacing="0" cellpadding="0">
    	<th height="20px" align="left" bgcolor="#006699" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; color:#FFF">&nbsp; Egreso de Paciente (Alta, Traslado).</th>

        <tr>
            <td background="img/fondo.jpg">
            	<fieldset>



<div class="titulo" align="center">
<form method="get" action="pro2_generaalta.php">
<table width="70%" align="center" border="0" cellspacing="0" cellpadding="0">
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
	            <tr><td style="font-size:16px; color: #F00;" align="center" colspan="3"><? echo $mensaje ?> </td></tr>
	            <tr><td height="20px"></td><td></td></tr>
			</table>
			</fieldset>
		</td>
	</tr>

		

		<input type="hidden" name="id_cama" value="<? echo $id_cama ?>" />
        <input type="hidden" name="tipo_traslado" value="<? echo $tipo_traslado ?>" />
		<input type="hidden" name="que_cod_servicio"  value="<? echo $que_cod_servicio ?>" />
		<input type="hidden" name="que_servicio"  value="<? echo $que_servicio ?>" />
		<input type="hidden" name="cod_servicio"  value="<? echo $cod_servicio ?>" />
		<input type="hidden" name="desc_servicio" value="<? echo $desc_servicio ?>" />
		<input type="hidden" name="sala" value="<? echo $sala ?>" />
   		<input type="hidden" name="cama" value="<? echo $cama ?>" />
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
        
		<input type="hidden" name="mensaje" value="<? echo $mensaje ?>" />
        <input type="hidden" name="id_parto" value="<? echo $id_parto; ?>" />
        <input type="hidden" name="barthel" value="<? echo $barthel; ?>" />
        
        <input type="hidden" name="usuario_que_ingresa" value="<? echo $usuario_que_ingresa; ?>" />
        <input type="hidden" name="fecha_usuario_ingresa" value="<? echo $fecha_usuario_ingresa; ?>" />

	<? if($id_paciente <> 0){ ?>
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
	<tr align="left">
		<td>
			<fieldset>
			<legend>¿ Esta Seguro de Realizar el Egreso de Paciente ?</legend>

            <table width="100%" border="0" cellspacing="0" cellpadding="0">

                <tr><td width="20px" height="20px"></td><td width="120px"></td></tr>
                <tr><td></td><td> 
                <input class="boton" type="submit" name="Submit" value="       Aceptar       " onchange="javascript:this.disabled= true;this.form.submit();" onclick="javascript:this.disabled= true;this.form.submit();" />
                    </td><td> <input class="boton" type="Button" value=    "       Cancelar       " onClick="window.location.href='<? echo"altapaciente.php?id_cama=$id_cama"; ?>'; parent.GB_hide(); " >
                    </td></tr>
                    <tr><td width="20px" height="20px"></td><td width="120px"></td></tr>        
			</table>
			</fieldset>
		</td>
	</tr>
	<? } else{ ?>
    <tr>
    	<td>
			<fieldset>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">

                <tr>
                  <td height="20px" colspan="2">&iexcl; El paciente que usted selecciono, ya ha sido dado de alta!</td></tr>
                <tr><td colspan="2">&nbsp;</td></tr>
                <tr><td colspan="2" align="center">
                    <input class="boton" type="Button" value=    "       Volver       " onClick="window.location.href='<? echo"sscc.php"; ?>'; parent.GB_hide(); " >
                    </td></tr>
                <tr><td width="22" height="20px"></td></tr>        
			</table>
			</fieldset>
		</td>
    </tr>
    <? } ?>
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

