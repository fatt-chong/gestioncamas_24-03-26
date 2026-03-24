<?php 
//usar la funcion header habiendo mandado c�digo al navegador
ob_start(); 
//end para header
$tipodocumento= $_GET['tipodocumento'];
$doc_paciente= $_GET['doc_paciente'];
$id_traslado= $_GET['id_traslado'];
$id_paciente= $_GET['id_paciente'];

if (!isset($_SESSION)) {
	session_start();
}

if ( $_SESSION['MM_Username'] == null ) {
	$GoTo = "../../acceso/index.php";
	header(sprintf("Location: %s", $GoTo));
}
$permisos = $_SESSION['permiso'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Gestion de Camas Hospital Dr. Juan No&eacute C.</title>
<link type="text/css" rel="stylesheet" href="css/estilo.css" />
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />

	<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>

    <script src="../calendario/src/js/jscal2.js"></script>
    <script src="../calendario/src/js/lang/es.js"></script>
    <link rel="stylesheet" type="text/css" href="../calendario/src/css/jscal2.css" />
    <link rel="stylesheet" type="text/css" href="../calendario/src/css/border-radius.css" />
    <link rel="stylesheet" type="text/css" href="../calendario/src/css/steel/steel.css" />


	<script type="text/javascript">
    	onload = focusIt;
	    function focusIt()
    	{
	      document.ingresa_pac_n.nom_paciente.focus();
    	}
	</script>

</head>


<?
include "../funciones/funciones.php";

	$atenc[0] = "SIN ATENCION";
	$atenc[1] = "M-1";
	$atenc[2] = "M-2";
	$atenc[3] = "E-1";
	$atenc[4] = "E-2";
	$atenc[5] = "TP-1";
	$atenc[6] = "TP-2";
	$atenc[7] = "TP-3";
	$atenc[8] = "TP-4";
	$atenc[9] = "TP-ADICIONAL";
	$atenc[10] = "OTRO";
	$atenc[11] = "ATENCION BOX";
	
	$arr_movil_m[0] = "SIN ASIGNAR";
	$arr_movil_m[1] = "MOVIL 1";
	$arr_movil_m[2] = "";
	$arr_movil_m[3] = "MOVIL 2";
	$arr_movil_m[4] = "";
	$arr_movil_m[5] = "MOVIL 3";
	$arr_movil_m[6] = "MOVIL 4";
	$arr_movil_m[7] = "";
	$arr_movil_m[8] = "";
	$arr_movil_m[9] = "MOVIL ADICIONAL";
	$arr_movil_m[10] = "OTROS";
	$arr_movil_m[11] = "CONSULTA BOX";
	
	$arr_movil_t[0] = "SIN ASIGNAR";
	$arr_movil_t[1] = "MOVIL 1";
	$arr_movil_t[2] = "";
	$arr_movil_t[3] = "MOVIL 2";
	$arr_movil_t[4] = "";
	$arr_movil_t[5] = "MOVIL 3";
	$arr_movil_t[6] = "MOVIL 4";
	$arr_movil_t[7] = "";
	$arr_movil_t[8] = "";
	$arr_movil_t[9] = "MOVIL ADICIONAL";
	$arr_movil_t[10] = "OTROS";
	$arr_movil_t[11] = "CONSULTA BOX";

	$arr_movil_n[0] = "SIN ASIGNAR";
	$arr_movil_n[1] = "";
	$arr_movil_n[2] = "";
	$arr_movil_n[3] = "";
	$arr_movil_n[4] = "";
	$arr_movil_n[5] = "MOVIL 1";
	$arr_movil_n[6] = "MOVIL 2";
	$arr_movil_n[7] = "MOVIL 3";
	$arr_movil_n[8] = "MOVIL 4";
	$arr_movil_n[9] = "MOVIL ADICIONAL";
	$arr_movil_n[10] = "OTROS";
	$arr_movil_n[11] = "CONSULTA BOX";

	$arr_movil_ma[0] = "SIN ASIGNAR";
	$arr_movil_ma[1] = "";
	$arr_movil_ma[2] = "";
	$arr_movil_ma[3] = "";
	$arr_movil_ma[4] = "";
	$arr_movil_ma[5] = "MOVIL 1";
	$arr_movil_ma[6] = "MOVIL 2";
	$arr_movil_ma[7] = "MOVIL 3";
	$arr_movil_ma[8] = "MOVIL 4";
	$arr_movil_ma[9] = "MOVIL ADICIONAL";
	$arr_movil_ma[10] = "OTROS";
	$arr_movil_ma[11] = "CONSULTA BOX";

$fecha_hoy = date('d-m-Y');
$fecha = $fecha_hoy;

$hora_ingreso = date('H:i');

$cod_procedencia = 50;

$sql = "SELECT * FROM pauge";
mysql_connect ('10.6.21.29','usuario','hospital');


mysql_select_db('camas') or die('Cannot select database');
$query = mysql_query($sql) or die(mysql_error());

$i = 0;
while($l_pauge = mysql_fetch_array($query)){
	$id_pauge[$i] = $l_pauge['id'];
	$pauge[$i] = $l_pauge['pauge'];
	$i++;
}

print_r("<pre>"); print_r("*** auge ***"); print_r("</pre>");
print_r("<pre>"); print_r($pauge); print_r("</pre>");

$sql = "SELECT * FROM medicos order by medico";
mysql_select_db('camas') or die('Cannot select database');
$query = mysql_query($sql) or die(mysql_error());

$i = 0;
while($l_medicos = mysql_fetch_array($query)){
	$id_medicos[$i] = $l_medicos['id'];
	$medicos[$i] = $l_medicos['medico'];
	$i++;
}

print_r("<pre>"); print_r("*** medicos ***"); print_r("</pre>");
print_r("<pre>"); print_r($medicos); print_r("</pre>");

$sql = "SELECT * FROM sscc WHERE id < 100";
mysql_select_db('camas') or die('Cannot select database');
$query = mysql_query($sql) or die(mysql_error());

$i = 0;
while($l_servicios = mysql_fetch_array($query)){
	$id_servicios[$i] = $l_servicios['id'];
	$servicios[$i] = $l_servicios['servicio'];
	$i++;
}

print_r("<pre>"); print_r("*** procedencia ***"); print_r("</pre>");
// print_r("<pre>"); print_r($id_servicios); print_r("</pre>");
print_r("<pre>"); print_r($servicios); print_r("</pre>");

$sql = "SELECT * FROM paciente where id = '".$doc_paciente."'";

if ($tipodocumento == 2) { $sql = "SELECT * FROM paciente where rut = '".$doc_paciente."'"; }
if ($tipodocumento == 3) { $sql = "SELECT * FROM paciente where nroficha = '".$doc_paciente."'"; }
if ($tipodocumento == 4) { $sql = "SELECT paciente.* FROM paciente.paciente INNER JOIN camas.transito_paciente ON paciente.paciente.id = camas.transito_paciente.id_paciente WHERE camas.transito_paciente.cta_cte = '".$doc_paciente."'"; }


mysql_select_db('paciente') or die('Cannot select database');
$query = mysql_query($sql) or die(mysql_error());

$paciente = mysql_fetch_array($query);

print_r("<pre>"); print_r("*** paciente ***"); print_r("</pre>");
print_r("<pre>"); print_r($paciente); print_r("</pre>");

?>
<body background="../../estandar/img/fdo.jpg" topmargin="5" style="font-family:Arial, Helvetica, sans-serif; font-size:12px">
    <table width="850px" align="center" border="2" bordercolor="#000000" bordercolorlight="#FFFFFF" bordercolordark="#666666" cellspacing="0" cellpadding="0">
        <th height="20px" align="left" bgcolor="#006699" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; color:#FFF">&nbsp; Hospitalizaci&oacute;n de Paciente.</th>
        <tr>
            <td background="img/fondo.jpg">
                <fieldset>
                    <div align="center">

<?

if ($paciente)
{
	$id_paciente = $paciente['id'];
	$rut_paciente = $paciente['rut'];
	$ficha_paciente = $paciente['nroficha'];
	$nom_paciente = $paciente['nombres']." ".$paciente['apellidopat']." ".$paciente['apellidomat'];
	$fechanac = $paciente['fechanac'];
	$sexo_paciente = $paciente['sexo'];
	$cod_prevision = $paciente['prevision'];
	$direc_paciente = $paciente['direccion'];
	$cod_comuna = $paciente['idcomuna'];
	$fono1_paciente = $paciente['fono1'];
	$fono2_paciente = $paciente['fono2'];
	$fono3_paciente = $paciente['fono3'];
	$hospitalizado = $paciente['hospitalizado'];
	$conveniopago =  $paciente['conveniopago'];

	
	$sql = "SELECT * FROM altaprecoz where id_paciente = $id_paciente";
	
	mysql_select_db('camas') or die('Cannot select database');
	$query = mysql_query($sql) or die(mysql_error());
	
	$estaencama = mysql_fetch_array($query);
	if ($estaencama)
	{

		?>
		<fieldset class="fieldset_det2"><legend>Paciente</legend>
			<table width="780px" border="0" cellspacing="1" cellpadding="1">
				<tr height="100px">
					<td height="100%" align="center" style="font-size:16px; color: #F00;">��� El Paciente ya se encuentra ingresado !!!</td>
				</tr>
			</table>
		</fieldset>
		<fieldset><legend>Opciones</legend>
			<input type="Button" value="      Volver      " onClick="window.location.href='<? echo"ingresopaciente.php?tipodocumento=$tipodocumento"; ?>'; parent.GB_hide(); " >
		</fieldset>
		<?

	}
	else
	{
		
		$dia=substr($fecha, 0, 2); 
		$mes=substr($fecha, 3, 2); 
		$anno=substr($fecha, 6, 4); 
		
		//descomponer fecha de nacimiento 
		$dia_nac=substr($fechanac, 8, 2); 
		$mes_nac=substr($fechanac, 5, 2); 
		$anno_nac=substr($fechanac, 0, 4); 
		
		if($mes_nac>$mes){$edad_paciente= $anno-$anno_nac-1;}else{if($mes==$mes_nac AND $dia_nac>$dia){$edad_paciente= $anno-$anno_nac-1;}
		else{$edad_paciente= $anno-$anno_nac;}} 
		
		$sql = "SELECT * FROM prevision where id = '".$cod_prevision."'";
		mysql_select_db('paciente') or die('Cannot select database');
		$query = mysql_query($sql) or die(mysql_error());
		
		$l_prevision = mysql_fetch_array($query);
		
		$prevision = $l_prevision['prevision'];
		
		$sql = "SELECT * FROM comuna where id = '".$cod_comuna."'";
		mysql_select_db('paciente') or die('Cannot select database');
		$query = mysql_query($sql) or die(mysql_error());
		
		$l_comuna = mysql_fetch_array($query);
		
		$comuna = $l_comuna['comuna'];
	
		$sql = "SELECT * FROM transito_paciente where id_paciente = id_paciente";
	
		if ($hora_ingreso == "") { $hora_ingreso = date('H:i'); }
	
		?>
	
		<form name="ingresa_pac_n" method="get" action="pro2_ingresopaciente.php">
		
			<input type="hidden" name="tipodocumento" value="<? echo $tipodocumento ?>" />
		
			<input type="hidden" name="id_paciente" value="<? echo $id_paciente ?>" />
			<input type="hidden" name="rut_paciente" value="<? echo $rut_paciente ?>" />
			<input type="hidden" name="ficha_paciente" value="<? echo $ficha_paciente ?>" />
			<input type="hidden" name="nom_paciente" value="<? echo $nom_paciente ?>" />
			<input type="hidden" name="edad_paciente" value="<? echo $edad_paciente ?>" />
			<input type="hidden" name="sexo_paciente" value="<? echo $sexo_paciente ?>" />
			<input type="hidden" name="cod_prevision" value="<? echo $cod_prevision ?>" />
			<input type="hidden" name="direc_paciente" value="<? echo $direc_paciente ?>" />
			<input type="hidden" name="cod_comuna" value="<? echo $cod_comuna ?>" />
			<input type="hidden" name="fono1_paciente" value="<? echo $fono1_paciente ?>" />
			<input type="hidden" name="fono2_paciente" value="<? echo $fono2_paciente ?>" />
			<input type="hidden" name="hospitalizado" value="<? echo $hospitalizado ?>" />
			<input type="hidden" name="conveniopago" value="<? echo $conveniopago ?>" />
		
			<input type="hidden" name="prevision" value="<? echo $prevision ?>" />
			<input type="hidden" name="comuna" value="<? echo $comuna ?>" />
			
			<input type="hidden" name="prevision" value="<? echo $prevision ?>" />
			<input type="hidden" name="comuna" value="<? echo $comuna ?>" /> 
		
			<fieldset class="fieldset_det2"><legend>Paciente</legend>
				<table width="780px" border="0" cellspacing="1" cellpadding="1">
					<tr height="5px">
					</tr>
					<tr>
						<td width="10px">&nbsp;</td>
						<td>Rut</td>
						<td> 
						  <input size="9" type="text" name="rut_paciente" value="<?php echo $rut_paciente; ?>" disabled="disabled" />
						<input size="1" type="text" name="dv_rut" value="<?php echo ValidaDVRut($rut_paciente); ?>" disabled="disabled" /> 
						N&deg; Ficha 
						<input size="10" type="text" name="ficha_paciente" value="<?php echo $ficha_paciente; ?>" disabled="disabled" /> Prevision <input size="20" type="text" name="prevision" value="<?php echo $prevision; ?>" disabled="disabled" />
						
						</td>
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
							<input size="66" type="text" name="nom_paciente" value="<?php echo $nom_paciente; ?>" <? if ($tipodocumento <> 4) { echo "disabled='disabled'"; }  ?> />
							Edad <input size="2" type="text" name="edad_paciente" value="<?php echo $edad_paciente; ?>"<? if ($tipodocumento <> 4) { echo "disabled='disabled'"; }  ?> />
						</td>
						<td width="45px">Fono2</td>
						<td>
							<input size="12" type="text" name="fono2_paciente" value="<?php echo $fono2_paciente; ?>" disabled="disabled" />
						</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>Direcci�n</td>
						<td>
						<input size="79" type="text" name="direc_paciente" value="<?php echo $direc_paciente; ?>" disabled="disabled"/>
						</td>
						<td width="45px">Fono3</td>
						<td>
							<input size="12" type="text" name="fono3_paciente" value="<?php echo $fono3_paciente; ?>" disabled="disabled" />
						</td>
						<td>&nbsp;</td>
					</tr>
					<tr height="5px">
					</tr>
				</table>
			</fieldset>
		
			<fieldset class="fieldset_det2"><legend>Hospitalizaci�n</legend>
		
				<table width="100%" border="0" cellspacing="1" cellpadding="1">
					<tr height="5px"></tr>
					<tr>
						<td width="5px"></td>
						<td><input type="checkbox" name="d_acctransito" /> Accidente de Transito.</td>
						 
						 <td> - Patologia Auge
							<select name="cod_auge">
							<option value=0 selected="selected">NO AUGE</option>
							<?php
							$selccionado = 1;
							for($i=0; $i<count($pauge); $i++)
								{ echo "<option value='".$id_pauge[$i]."'>".substr($pauge[$i], 0, 70)."</option>"; }
							?>
							</select>
						</td>
					</tr>
				</table>
			
				<table width="780px" border="0" cellspacing="1" cellpadding="1">
					<tr height="10px"></tr>
				  	<tr>
						<td></td>                
						<td>Medico Tratante</td>
						<td><select name="cod_medico">
						<?php
						
						for($i=0; $i<count($medicos); $i++)
						{
							if($id_medicos[$i] == 171)
							{
							   echo "<option value='".$id_medicos[$i]."' selected>".$medicos[$i]."</option>";
							}
							else
							{
							   echo "<option value='".$id_medicos[$i]."'>".$medicos[$i]."</option>";
							}
						}
			  
						?>
						</select>
						&nbsp;&nbsp;&nbsp;&nbsp; Procedencia 
						<select name="cod_procedencia">
						<?php
						for($i=0; $i<count($servicios); $i++)
						{
							if($id_servicios[$i]==$cod_procedencia)
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
					<tr>
						<td></td>
						<td>Pre-Diagnostico</td>
						<td><input size="101" type="text" name="diagnostico1" /></td>
					</tr>
					<tr>
						<td></td>
						<td>Diagnostico</td>
						<td><input size="101" type="text" name="diagnostico2" /></td>
					</tr>
					
					<tr>
						<td></td>
						<td>Fecha Ingreso</td>
						<td>
						<span id="spry_fecha_ingreso">
						<input size="9"  id="f_date1" type="text" name="fecha_ingreso"  value="<? echo $fecha ?>" />
						<input type="Button" id="f_btn1" value="....." />
						<span class="textfieldRequiredMsg">Ingrese Fecha!</span>
						<span class="textfieldInvalidFormatMsg">Fecha Inv�lida</span>
						</span>
						
		
					</td>
					</tr>
					
					<tr>
						<td></td>
						<td>Hora Ingreso</td>
						<td>					
						<span id="spry_hora_ingreso">
						<input size="4"  id="hora_ingreso" type="text" name="hora_ingreso"  value="<? echo $hora_ingreso ?>" />
						<span class="textfieldRequiredMsg">Ingrese Hora!</span>
						<span class="textfieldInvalidFormatMsg">Hora Inv�lida</span>
						</span>
                    	&nbsp;&nbsp;&nbsp;&nbsp; Ma�ana 

                        <select name="movil_m" <?php if ( array_search(19, $permisos) != null ) { echo "enabled='enabled'"; } else { echo "disabled='disabled'"; }  ?> >
						<?
                        for($i=0; $i<count($atenc); $i++)
                        {
                            if ( $arr_movil_m[$i] <> '') {
                                echo "<option value='".$i."'>".$atenc[$i]."</option>";
                            }
                        }
						?>

                        </select>
                                                                 
                    	&nbsp;&nbsp;&nbsp;&nbsp; Tarde 
                        <select name="movil_t" <?php if ( array_search(19, $permisos) != null ) { echo "enabled='enabled'"; } else { echo "disabled='disabled'"; }  ?> >
						<?
                        for($i=0; $i<count($atenc); $i++)
                        {
                            if ( $arr_movil_t[$i] <> '') {
                                echo "<option value='".$i."'>".$atenc[$i]."</option>";
                            }
                        }
						?>

                        </select>
                       	&nbsp;&nbsp;&nbsp;&nbsp; Noche 
                        <select name="movil_n" <?php if ( array_search(19, $permisos) != null ) { echo "enabled='enabled'"; } else { echo "disabled='disabled'"; }  ?> >
						<?
                        for($i=0; $i<count($atenc); $i++)
                        {
                            if ( $arr_movil_n[$i] <> '') {
                                echo "<option value='".$i."'>".$atenc[$i]."</option>";
                            }
                        }
						?>
                    
                        </select>
                        &nbsp;&nbsp;&nbsp;&nbsp; Madrugada 
                        <select name="movil_ma" <?php if ( array_search(19, $permisos) != null ) { echo "enabled='enabled'"; } else { echo "disabled='disabled'"; }  ?> >
						<?
                        for($i=0; $i<count($atenc); $i++)
                        {
                            if ( $arr_movil_ma[$i] <> '') {
                                echo "<option value='".$i."'>".$atenc[$i]."</option>";
                            }
                        }
						?>
                    
                        </select>                                            
                    
						</td>            
					<tr height="5px"> </tr>
				</table>
		 
			</fieldset>
		
			<fieldset><legend>Opciones</legend>
				<input type="submit" value="          Acceptar          " >
				<input type="Button" value="      Cancelar      " onClick="window.location.href='<? echo"ingresopaciente.php?tipodocumento=$tipodocumento"; ?>'; parent.GB_hide(); " >
					
			</fieldset>
		
		</form>
		
		<script type="text/javascript">
		<!--
		var spry_fecha_ingreso = new Spry.Widget.ValidationTextField("spry_fecha_ingreso", "date", {validateOn:["change"], useCharacterMasking:true, format:"dd-mm-yyyy"});
		var spry_hora_ingreso = new Spry.Widget.ValidationTextField("spry_hora_ingreso", "time", {validateOn:["change"], useCharacterMasking:true});
		//-->
		</script>
		
		<script type="text/javascript">//<![CDATA[
			var cal = Calendar.setup({ onSelect: function(cal) { cal.hide() } });
			cal.manageFields("f_btn1", "f_date1", "%d-%m-%Y");
		//]]></script>

		<?
		
	}

}
else
{

	?>
	<fieldset class="fieldset_det2"><legend>Paciente</legend>
		<table width="780px" border="0" cellspacing="1" cellpadding="1">
			<tr height="100px">
				<td height="100%" align="center" style="font-size:16px; color: #F00;">��� El Paciente No se encuentra Registrado !!!</td>
			</tr>
		</table>
	</fieldset>
	<fieldset><legend>Opciones</legend>
		<input type="Button" value="      Volver      " onClick="window.location.href='<? echo"ingresopaciente.php?tipodocumento=$tipodocumento"; ?>'; parent.GB_hide(); " >
	</fieldset>
	<?

}

	
	

?>

    </div>
    
    </fieldset>
    </td>
    </tr>
    </table>



</body>
</html>


<?php
//usar la funcion header habiendo mandado c�digo al navegador
ob_end_flush();
//end header
?>

