<?php

if (!isset($_SESSION)) {
  session_start();
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Detalle de Cama</title>
<link type="text/css" rel="stylesheet" href="css/estilo.css" />

<script language="JavaScript" src="../tablas/tigra_tables.js"></script>

</head>

<body style="font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif" background="img/fondo.jpg" bgcolor="#EAF5FF">

	<?

	include "../funciones/funciones.php";

	$_SESSION['MM_pro_id_cama'] = $id_cama;
echo $es_ap;
	if ($es_ap == 1) { $sql = "SELECT * FROM altaprecoz where id = '".$id_cama."'"; } else
	{ $sql = "SELECT * FROM camas where id = '".$id_cama."'"; }
	
	mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');
	mysql_select_db('camas') or die('Cannot select database');
	$query = mysql_query($sql) or die(mysql_error());

    $paciente = mysql_fetch_array($query);
	
	$cod_servicio = $paciente['cod_servicio'];
	$desc_servicio = $paciente['servicio'];
	$sala = $paciente['sala'];
	$cama = $paciente['cama'];
	$nom_paciente = $paciente['nom_paciente'];
	$id_paciente = $paciente['id_paciente'];
	$diagnostico2 = $paciente['diagnostico2'];
	$categorizacion_riesgo = $paciente['categorizacion_riesgo'];
	$categorizacion_dependencia = $paciente['categorizacion_dependencia'];
	$categorizacion = $categorizacion_riesgo.''.$categorizacion_dependencia;

	?>

	<div align="center" >
	
    <fieldset>
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
        <td>
        <?
		echo"<a class='titulo'>Informaci�n de Paciente Hospitalizado. </a>";
		echo "</td>";
		echo "<td>";
		
// recarga web afuera		echo "<a><img src='img/close.gif' width='21px' border='0' style='padding-left:5px' title='Salir a Menu Principal' onclick='top.window.location.href=\"camas.php\"; parent.GB_hide(); ' /></a>";

		echo"<a><img src='img/close.gif' width='21px' border='0' style='padding-left:5px' title='Salir a Menu Principal' onclick='parent.parent.GB_hide();' /></a>";


		echo"</td>";
		echo"</tr>";
		echo"</table>";
		echo "</fieldset>";
	
		?>

        <fieldset class="fieldset_det2">
            <table width="100%" border="0" cellspacing="1" cellpadding="1">
                <tr height="10px">
                </tr>
                <tr>
                    <td width="20px">&nbsp;</td>
					<td>Servicio Clinico : <input size="25" type="text" name="pservicio" value="<?php echo $paciente['servicio']; ?>" readonly="readonly"/> Sala : <input size="15" type="text" name="pcama" value="<?php echo $paciente['sala']; ?>" readonly="readonly" /> Cama N� : <input size="3" type="text" name="pcama" value="<?php echo $paciente['cama']; ?>" readonly="readonly" /> Categorizaci�n : <input size="2" type="text" name="categorizacion" value="<?php echo $categorizacion ?>" readonly="readonly" /></td>
                </tr>
            </table>
        </fieldset>






		<fieldset class="fieldset_det2"><legend>Paciente</legend>
            <table width="100%" border="0" cellspacing="1" cellpadding="1">
                <tr height="10px">
                </tr>
                <tr>
                    <td width="20px">&nbsp;</td>
                    <td>Rut</td>
                    <td> 
                      <input size="9" type="text" name="prut" value="<?php echo $paciente['rut_paciente']; ?>" readonly="readonly" />
                    <input size="1" type="text" name="pdv" value="<?php echo ValidaDVRut($paciente['rut_paciente']); ?>" readonly="readonly" /> 
                    N&deg; Ficha 
                    <input size="10" type="text" name="pficha" value="<?php echo $paciente['ficha_paciente']; ?>" readonly="readonly" /> Prevision <input size="25" type="text" name="pprevision" value="<?php echo $paciente['prevision']; ?>" readonly="readonly" />
                    </td>
                    <td>
                        Fono1 <input size="12" type="text" name="pfono1" value="<?php echo $paciente['fono1_paciente']; ?>" readonly="readonly" />
                    </td>
                    <td width="20px">&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>        
                    <td>Nombre</td>
                    <td>
                        <input size="79" type="text" name="pnombre" value="<?php echo $paciente['nom_paciente']; ?>" readonly="readonly"  />
                    </td>
                    <td>
                        Fono2 <input size="12" type="text" name="pfono2" value="<?php echo $paciente['fono2_paciente']; ?>" readonly="readonly" />
                    </td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>Direcci�n</td>
                    <td>
                    <input size="79" type="text" name="pdireccion" value="<?php echo $paciente['direc_paciente']; ?>" readonly="readonly"/>
                    </td>
                    <td>
                        Fono3 <input size="12" type="text" name="pfono3" value="<?php echo $paciente['fono3_paciente']; ?>" readonly="readonly" />
                    </td>
                    <td>&nbsp;</td>
                </tr>
                <tr height="10px">
                </tr>
            </table>
        </fieldset>

    
        <fieldset class="fieldset_det2"><legend>Hospitalizaci&oacute;n</A></legend>
        
            <table width="100%" border="0" cellspacing="1" cellpadding="1">
                <tr height="10px">
                    <td width="20px"></td>
                	<td>Fecha de Ingreso</td>
                    <td><input size="9" type="text" name="pfecha" value="<?php echo cambiarFormatoFecha($paciente['fecha_ingreso']); ?>" readonly="readonly" /> </td>
                </tr>
                <tr>
                    <td></td>                
                    <td>Medico Tratante</td>
					<td><input size="59" type="text" name="pmedico" value="<?php echo $paciente['medico']; ?>" readonly="readonly" /> Procedencia <input size="25" type="text" name="pprocedencia" value="<?php echo $paciente['procedencia']; ?>" readonly="readonly" /> </td>
                </tr>
                <tr>
                    <td></td>
                    <td>Pre-Diagn
                    ostico</td>
                    <td><input size="103" type="text" name="pdiagnostico1" value="<?php echo $paciente['diagnostico1']; ?>" readonly="readonly" /></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Diagnostico</td>
                    <td><input size="103" type="text" name="pdiagnostico2" value="<?php echo $paciente['diagnostico2']; ?>" readonly="readonly" /></td>
                </tr>
                <tr>
                    <td></td>

						<?
						if($paciente['cod_auge'] <> 0){
							echo"<td><input size='25' type='checkbox' checked name='pauge' value=".$paciente['cod_auge']." disabled='disabled' />Patologia Auge </td>";
							?>
							 <td><input size="74" type="text" name="pdesauge" value="<?php echo $paciente['auge']; ?>" readonly='readonly' />
							 <?
							
						}
						else {
							echo "<td><input size='25' type='checkbox' name='pauge' value=".$paciente['cod_auge']." disabled='disabled' />Patologia Auge </td>";
							echo "<td><input size='74' type='text' name='pdesauge' value='' readonly='readonly'/>";
						}
						
						
						if($paciente['acctransito'] == 1){
							echo "<input type='checkbox' checked name='pacctransito' disabled='disabled' />Accidente de Transito.</td>";
						}
						else {
							echo "<input type='checkbox' name='pacctransito' disabled='disabled' />Accidente de Transito.</td>";				
						}
						?>

                </tr>
              <tr height="10px"> </tr>                
            </table>

        </fieldset>

</div>

	<fieldset><legend>Historial Hospitalizaciones</legend>
	
		<div align="center" style="width:823px;height:140px;overflow:auto">
	
			<table id="table_detallecama" border="2px" cellpadding="1px" cellspacing="0px">
				<tr>
					<td width="70px">Desde</td>
					<td width="70px">Hasta</td>
					<td width="120px">Servicio</td>
					<td width="120px">Sala</td>
					<td width="40px">Cama</td>
					<td width="370px">Diagnostico</td>
				</tr>
	
	
				<?php

				if ($id_paciente <> 0)
					{
		
					$rut_paciente = $paciente['rut_paciente'];
					$sql = "SELECT * FROM hospitalizaciones where id_paciente = '".$id_paciente."'";
					//$sql = "SELECT * FROM hospitalizaciones where rut_paciente = '".$rut_paciente."'";
					mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');
					mysql_select_db('camas') or die('Cannot select database');
					$query2 = mysql_query($sql) or die(mysql_error());


					while($list_paciente = mysql_fetch_array($query2)){
						 ?>
			
						<tr align="left" style="font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif">
		
						<td><? echo cambiarFormatoFecha($list_paciente['fecha_ingreso']); ?>				</td>
						<td><? echo cambiarFormatoFecha($list_paciente['fecha_egreso']); ?>				</td>
						<td><? echo $list_paciente['servicio']; ?></td>
						<td><? echo $list_paciente['sala']; ?></td>
						<td><? echo $list_paciente['cama']; ?></td>
						<td><? echo $list_paciente['diagnostico2']; ?></td>
						<?
		
						echo"</tr>";
					}
				}
				?>
	
			</table>
	
			<script language="JavaScript">
			<!--
				tigra_tables('table_detallecama', 1, 0, '#ffffff', '#ffffcc', '#ffcc66', '#cccccc');
			// -->
			</script>
	
		</div>
	
	</fieldset>
	
</body>
</html>



