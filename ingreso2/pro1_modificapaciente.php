<?php

if (!isset($_SESSION)) {
  session_start();
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Gestion de Camas Hospital Dr. Juan No� C.</title>
<link type="text/css" rel="stylesheet" href="css/estilo.css" />

<script type="text/javascript">
    onload = focusIt;
    function focusIt()
    {
      document.ingresa_doc.doc_paciente.focus();
    }
</script>

</head>


	<?

	include "../funciones/funciones.php";
	  
	$sql = "SELECT * FROM altaprecoz where id = '".$id_cama."'";
	mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');
	mysql_select_db('camas') or die('Cannot select database');
	$query = mysql_query($sql) or die(mysql_error());

    $paciente = mysql_fetch_array($query);
	$categorizacion_riesgo = $paciente['categorizacion_riesgo'];
	$categorizacion_dependencia = $paciente['categorizacion_dependencia'];
	$categorizacion = $categorizacion_riesgo.''.$categorizacion_dependencia;

	?>



<body background="../../estandar/img/fdo.jpg" topmargin="5" style="font-family:Arial, Helvetica, sans-serif; font-size:12px">
	<table width="850px" align="center" border="2" bordercolor="#000000" bordercolorlight="#FFFFFF" bordercolordark="#666666" cellspacing="0" cellpadding="0">
    	<th height="20px" align="left" bgcolor="#006699" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; color:#FFF">&nbsp; Modificar Informaci&oacute;n de Paciente Hospitalizado.</th>

        <tr>
            <td background="img/fondo.jpg">
            	<fieldset>


<div align="center">

	<form name="ingresa_doc" method="post" action="pro2_modificapaciente.php">
	    <input type="hidden" name="id_cama" value="<? echo $id_cama ?>" />
        <input type="hidden" name="servicio"  value="<? echo $paciente['cod_servicio'] ?>" />
   		<input type="hidden" name="id_paciente" value="<? echo $paciente['id'] ?>" />
 		<input type="hidden" name="rut_paciente" value="<? echo $paciente['rut_paciente'] ?>" />
   		<input type="hidden" name="ficha_paciente" value="<? echo $paciente['ficha_paciente'] ?>" /> 
 		<input type="hidden" name="nom_paciente" value="<? echo $paciente['nom_paciente'] ?>" />
 		<input type="hidden" name="sexo_paciente" value="<? echo $paciente['sexo_paciente'] ?>" />
 		<input type="hidden" name="edad_paciente" value="<? echo $paciente['edad_paciente'] ?>" />
   		<input type="hidden" name="cod_prevision" value="<? echo $paciente['cod_prevision'] ?>" />

   		<input type="hidden" name="cod_comuna" value="<? echo $paciente['cod_comuna'] ?>" />
   		<input type="hidden" name="comuna" value="<? echo $paciente['comuna'] ?>" />


        <fieldset class="fieldset_det2">
            <table width="780px" border="0" cellspacing="1" cellpadding="1">
                <tr height="10px">
                </tr>
                <tr>
                    <td width="10px">&nbsp;</td>
					<td>Servicio Clinico : <input size="25" type="text" name="pservicio" value="<?php echo $paciente['servicio']; ?>" readonly="readonly"/> Sala : <input size="15" type="text" name="pcama" value="<?php echo $paciente['sala']; ?>" readonly="readonly" /> Cama N� : <input size="3" type="text" name="pcama" value="<?php echo $paciente['cama']; ?>" readonly="readonly" /> Categorizaci�n : <input size="2" type="text" name="categorizacion" value="<?php echo $categorizacion ?>" readonly="readonly" /></td>
                </tr>
            </table>
        </fieldset>


    <fieldset class="fieldset_det2"><legend>Paciente</legend>
        <table width="780px" border="0" cellspacing="1" cellpadding="1">
            <tr height="10px">
            </tr>
            <tr>
                <td width="10px">&nbsp;</td>
                <td width="67px">
					<select name="tipodocumento">
			        <option value=1 selected="selected">Rut
                    <option value=2>Ficha
                    </select>		                
                </td>
                <td>
					<input size="9" type="text" name="doc_paciente" value=<? echo $rut ?> >
					<input size="1" type="text" name="pdv" />
					<input type="submit" value="Acceptar" >
					<input type="Button" value="Buscar" onclick="window.location.href='<? echo"../busquedapacientes/busquedapacientes4.php?id_cama=$id_cama&cama"; ?>'; parent.GB_hide(); " >
					Prevision <input size="20" type="text" name="prevision" value="<? echo $paciente['prevision'] ?>" disabled="disabled" >
                </td>
		        <td width="45px">Fono1</td>
                <td width="100px">
                	<input size="12" type="text" name="fono1_paciente" value="<? echo $paciente['fono1_paciente'] ?>" disabled="disabled" >
                </td>
                <td width="10px">&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>        
                <td>Nombre</td>
                <td>
                    <input size="81" type="text" name="nom_paciente" value="<? echo $paciente['nom_paciente'] ?>" disabled="disabled"  />
                </td>
	            <td>Fono2 </td>
				<td>
                	<input size="12" type="text" name="fono2_paciente" value="<? echo $paciente['fono2_paciente'] ?>" disabled="disabled" />
                </td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>Direcci�n</td>
                <td>
                <input size="81" type="text" name="direc_paciente" value="<? echo $paciente['direc_paciente'] ?>" disabled="disabled"/>
                </td>
	            <td>Fono3 </td>
                <td>
                	<input size="12" type="text" name="fono3_paciente" value="<? echo $paciente['fono3_paciente'] ?>" disabled="disabled" />
                </td>
                <td>&nbsp;</td>
            </tr>
            <tr height="10px">
            </tr>
        </table>
    </fieldset>

    <fieldset class="fieldset_det2"><legend>Hospitalizaci�n</legend>
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
    <input type="Button" value=    "       Cancelar       " onclick="window.location.href='<? echo"altapaciente.php?id_cama=$id_cama"; ?>'; parent.GB_hide(); " />

	</fieldset>



</form>

</div>

</fieldset>
</td>
</tr>
</table>

</body>
</html>
