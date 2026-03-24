<?php

if (!isset($_SESSION)) {
  session_start();
}
$dbhost = $_SESSION['BD_SERVER'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Gestion de Camas Hospital Dr. Juan Noé C.</title>
<link type="text/css" rel="stylesheet" href="css/estilo.css" />

    <script src="../calendario/src/js/jscal2.js"></script>
    <script src="../calendario/src/js/lang/es.js"></script>
    <link rel="stylesheet" type="text/css" href="../calendario/src/css/jscal2.css" />
    <link rel="stylesheet" type="text/css" href="../calendario/src/css/border-radius.css" />
    <link rel="stylesheet" type="text/css" href="../calendario/src/css/steel/steel.css" />

</head>

<?
include "../funciones/funciones.php";

$fecha_hoy = date('d-m-Y');
$fecha = $fecha_hoy;

$sql = "SELECT * FROM paciente where id = '".$doc_paciente."'";

if ($tipodocumento == 1) { $sql = "SELECT * FROM paciente where rut = '".$doc_paciente."'"; }
if ($tipodocumento == 2) { $sql = "SELECT * FROM paciente where nroficha = '".$doc_paciente."'"; }



	mysql_connect ($dbhost,'gestioncamas','123gestioncamas');
	mysql_select_db('paciente') or die('Cannot select database');
	$query = mysql_query($sql) or die(mysql_error());
	
	$paciente = mysql_fetch_array($query);
	
	$id_paciente = $paciente['id'];
	$rut_paciente = $paciente['rut'];
	$ficha_paciente  = $paciente['nroficha'];
	$nom_paciente    = $paciente['nombres']." ".$paciente['apellidopat']." ".$paciente['apellidomat'];
	$fechanac        = $paciente['fechanac'];
	$sexo_paciente   = $paciente['sexo'];
	$cod_prevision   = $paciente['prevision'];
	$direc_paciente  = $paciente['direccion'];
	$cod_comuna      = $paciente['idcomuna'];
	$fono1_paciente  = $paciente['fono1'];
	$fono2_paciente  = $paciente['fono2'];
	$fono3_paciente  = $paciente['fono3'];


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
	mysql_connect ($dbhost,'gestioncamas','123gestioncamas');
	mysql_select_db('paciente') or die('Cannot select database');
	$query = mysql_query($sql) or die(mysql_error());
	
	$l_prevision = mysql_fetch_array($query);
	
	$prevision = $l_prevision['prevision'];
	
	$sql = "SELECT * FROM comuna where id = '".$cod_comuna."'";
	mysql_connect ($dbhost,'gestioncamas','123gestioncamas');
	mysql_select_db('paciente') or die('Cannot select database');
	$query = mysql_query($sql) or die(mysql_error());
	
	$l_comuna = mysql_fetch_array($query);
	
	$comuna = $l_comuna['comuna'];




$sql = "SELECT * FROM pauge";
mysql_connect ($dbhost,'gestioncamas','123gestioncamas');
mysql_select_db('camas') or die('Cannot select database');
$query = mysql_query($sql) or die(mysql_error());

$i = 0;
while($l_pauge = mysql_fetch_array($query)){
	$id_pauge[$i] = $l_pauge['id'];
	$pauge[$i] = $l_pauge['pauge'];
	$i++;
}

$sql = "SELECT * FROM medicos";
mysql_connect ($dbhost,'gestioncamas','123gestioncamas');
mysql_select_db('camas') or die('Cannot select database');
$query = mysql_query($sql) or die(mysql_error());

$i = 0;
while($l_medicos = mysql_fetch_array($query)){
	$id_medicos[$i] = $l_medicos['id'];
	$medicos[$i] = $l_medicos['medico'];
	$i++;
}

$sql = "SELECT * FROM sscc";
mysql_connect ($dbhost,'gestioncamas','123gestioncamas');
mysql_select_db('camas') or die('Cannot select database');
$query = mysql_query($sql) or die(mysql_error());

$i = 0;
while($l_servicios = mysql_fetch_array($query)){
	$id_servicios[$i] = $l_servicios['id'];
	$servicios[$i] = $l_servicios['servicio'];
	$i++;
}


	
?>
<body background="../../estandar/img/fdo.jpg" topmargin="5" style="font-family:Arial, Helvetica, sans-serif; font-size:12px">
	<table width="850px" align="center" border="2" bordercolor="#000000" bordercolorlight="#FFFFFF" bordercolordark="#666666" cellspacing="0" cellpadding="0">
    	<th height="20px" align="left" bgcolor="#006699" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; color:#FFF">&nbsp; Modificar Informaci&oacute;n de Paciente Hospitalizado.</th>

        <tr>
            <td background="img/fondo.jpg">
            	<fieldset>


<div align="center">

<form method="post" action="pro3_modificapaciente.php">


    <input type="hidden" name="id_cama" value="<? echo $id_cama ?>" />
    <input type="hidden" name="cama" value="<? echo $cama ?>" />
    <input type="hidden" name="sala" value="<? echo $sala ?>" />
    <input type="hidden" name="servicio"  value="<? echo $servicio ?>" />
    <input type="hidden" name="desc_servicio" value="<? echo $desc_servicio ?>" />

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
    <input type="hidden" name="fono3_paciente" value="<? echo $fono3_paciente ?>" />

    <input type="hidden" name="prevision" value="<? echo $prevision ?>" />
    <input type="hidden" name="comuna" value="<? echo $comuna ?>" />
    
   
    
   	<?

	$sql = "SELECT * FROM camas where id = '".$id_cama."'";
	mysql_connect ($dbhost,'gestioncamas','123gestioncamas');
	mysql_select_db('camas') or die('Cannot select database');
	$query = mysql_query($sql) or die(mysql_error());

    $paciente = mysql_fetch_array($query);

	?>

    
    
 
     <fieldset class="fieldset_det2">
        <table width="780px" border="0" cellspacing="1" cellpadding="1">
            <tr height="10px">
            </tr>
            <tr>
                <td width="10px">&nbsp;</td>
                <td>Servicio Clinico : <input size="25" type="text" name="pservicio" value="<?php echo $paciente['servicio']; ?>" readonly="readonly"/> Sala : <input size="15" type="text" name="pcama" value="<?php echo $paciente['sala']; ?>" readonly="readonly" /> Cama N° : <input size="3" type="text" name="pcama" value="<?php echo $paciente['cama']; ?>" readonly="readonly" /> Categorización : <input size="2" type="text" name="categorizacion" value="<?php echo $categorizacion ?>" readonly="readonly" /></td>
            </tr>
        </table>
    </fieldset>

 

	<fieldset class="fieldset_det2"><legend>Paciente</legend>
        <table width="780px" border="0" cellspacing="1" cellpadding="1">
        	<tr height="10px">
            </tr>
            <tr>
                <td width="10px">&nbsp;</td>
                <td width="67px">Rut</td>
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
                <td width="20px">&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>        
                <td>Nombre</td>
                <td>
	           		<input size="81" type="text" name="nom_paciente" value="<?php echo $nom_paciente; ?>" <? if ($tipodocumento <> 3) { echo "disabled='disabled'"; }  ?> />
                </td>
	            <td>Fono2 </td>
                <td>
                	<input size="12" type="text" name="fono2_paciente" value="<?php echo $fono2_paciente; ?>" disabled="disabled" />
                </td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>Dirección</td>
                <td>
                <input size="81" type="text" name="direc_paciente" value="<?php echo $direc_paciente; ?>" disabled="disabled"/>
                </td>
	            <td>Fono3 </td>
                <td>
            		<input size="12" type="text" name="fono3_paciente" value="<?php echo $fono3_paciente; ?>" disabled="disabled" />
                </td>
                <td>&nbsp;</td>
            </tr>
            <tr height="10px">
            </tr>
		</table>
	</fieldset>



    <fieldset class="fieldset_det2"><legend>Hospitalización</legend>
            <table width="780px" border="0" cellspacing="1" cellpadding="1">
                <tr height="10px">
                    <td width="10px"></td>
                	<td width="112px">Fecha Ingreso</td>
                    <td><input size="9" type="text" name="pfecha" value="<?php echo cambiarFormatoFecha($paciente['fecha_ingreso']); ?>" readonly="readonly" /> </td>
                </tr>
                <tr>
                    <td width="10px"></td>                
                    <td>Medico Tratante</td>
					<td><input size="55" type="text" name="pmedico" value="<?php echo $paciente['medico']; ?>" readonly="readonly" /> Procedencia <input size="25" type="text" name="pprocedencia" value="<?php echo $paciente['procedencia']; ?>" readonly="readonly" /> </td>
                </tr>
                <tr>
                    <td></td>
                    <td>Pre-Diagnostico</td>
                    <td><input size="101" type="text" name="pdiagnostico1" value="<?php echo $paciente['diagnostico1']; ?>" readonly="readonly" /></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Diagnostico</td>
                    <td><input size="101" type="text" name="pdiagnostico2" value="<?php echo $paciente['diagnostico2']; ?>" readonly="readonly" /></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="2">

						<?
						if($paciente['cod_auge'] <> 0){
							echo"<input size='25' type='checkbox' checked name='pauge' value=".$paciente['cod_auge']." disabled='disabled' />Patologia Auge";
							?>
							 <input size="74" type="text" name="pdesauge" value="<?php echo $paciente['auge']; ?>" readonly='readonly' />
							 <?
							
						}
						else {
							echo "<input size='25' type='checkbox' name='pauge' value=".$paciente['cod_auge']." disabled='disabled' />Patologia Auge";
							echo "<input size='74' type='text' name='pdesauge' value='' readonly='readonly'/>";
						}
						
						
						if($paciente['acctransito'] == 1){
							echo "<input type='checkbox' checked name='pacctransito' disabled='disabled' />Accidente de Transito.";
						}
						else {
							echo "<input type='checkbox' name='pacctransito' disabled='disabled' />Accidente de Transito.";				
						}
						?>
                        
                    </td>

                </tr>
              <tr height="10px"> </tr>                
            </table>
 
    </fieldset>

	<fieldset><legend>Opciones</legend>
		<input type="submit" value="          Acceptar          " >
        <input type="Button" value="       Volver       " onClick="window.location.href='<? echo"pro1_modificapaciente.php?id_cama=$id_cama"; ?>'; parent.GB_hide(); " >
		<input type="Button" value=    "       Cancelar       " onclick="window.location.href='<? echo"altapaciente.php?id_cama=$id_cama"; ?>'; parent.GB_hide(); " />
            
    </fieldset>


</form>

<script type="text/javascript">//<![CDATA[
	var cal = Calendar.setup({ onSelect: function(cal) { cal.hide() } });
  	cal.manageFields("f_btn1", "f_date1", "%d-%m-%Y");
//]]></script>


</div>

</fieldset>
</td>
</tr>
</table>


</body>
</html>
