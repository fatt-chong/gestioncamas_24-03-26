<?php

if (!isset($_SESSION)) {
  session_start();
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Gestion de Camas Hospital Dr. Juan No&eacute C.</title>
<link type="text/css" rel="stylesheet" href="css/estilo.css" />

<script language="JavaScript" src="../tablas/tigra_tables.js"></script>

</head>
<body style="font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif" background="img/fondo.jpg" bgcolor="#EAF5FF">

<?

include "../funciones/funciones.php";

$_SESSION['MM_pro_id_cama'] = $id_cama;
$_SESSION['MM_pro_cama'] = $cama;
$_SESSION['MM_pro_sala'] = $sala;
$_SESSION['MM_pro_servicio'] = $servicio;
$_SESSION['MM_pro_desc_servicio'] = $desc_servicio;
$_SESSION['MM_pro_estado'] = $estado;

/*
echo $_SESSION['MM_pro_id_cama'];
echo $_SESSION['MM_pro_cama'];
echo $_SESSION['MM_pro_sala'];
echo $_SESSION['MM_pro_servicio'];
echo $_SESSION['MM_pro_desc_servicio'];
echo $_SESSION['MM_pro_estado'];
*/


$sql = "SELECT * FROM hospitalizaciones where id = '".$id_hosp."'";
mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');
mysql_select_db('camas') or die('Cannot select database');
$query = mysql_query($sql) or die(mysql_error());

$hospitalizacion = mysql_fetch_array($query);

?>

<div align="center" >
	<fieldset>
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
        <td>
        <?
		if ($estado == 1){
			echo"<a class='titulo'>En el Servicio De ".$desc_servicio." Sala ".$sala." La Cama N�".$cama." Se Encuentra SIN Paciente. </a>";
		}
		if ($estado == 3){
			echo"<a class='titulo'>En el Servicio De ".$desc_servicio." Sala ".$sala." La Cama N�".$cama." Se Encuentra Bloqueada. </a>";
		}
		echo "</td>";
		echo "<td>";
		
// recarga web afuera		echo "<a><img src='img/close.gif' width='21px' border='0' style='padding-left:5px' title='Salir a Menu Principal' onclick='top.window.location.href=\"camas.php\"; parent.GB_hide(); ' /></a>";

		echo"<a><img src='img/close.gif' width='21px' border='0' style='padding-left:5px' title='Salir a Menu Principal' onclick='parent.parent.GB_hide();' /></a>";


echo"</td>";
		echo"</tr>";
		echo"</table>";
		echo "</fieldset>";
	
	?>
	<fieldset class="fieldset_det2"><legend>Paciente</legend>
        <table width="100%" border="0" cellspacing="1" cellpadding="1">
        	<tr height="10px">
            </tr>
            <tr>
                <td width="20px">&nbsp;</td>
                <td>Rut</td>
                <td> 
                  <input size="9" type="text" name="prut" value="<?php echo $hospitalizacion['rut_paciente']; ?>" readonly="readonly" />
                <input size="1" type="text" name="pdv" value="<?php echo ValidaDVRut($hospitalizacion['rut_paciente']); ?>" readonly="readonly" /> 
                N&deg; Ficha 
                <input size="10" type="text" name="pficha" value="<?php echo $hospitalizacion['ficha_paciente']; ?>" readonly="readonly" /> Prevision <input size="25" type="text" name="pprevision" value="<?php echo $hospitalizacion['prevision']; ?>" readonly="readonly" />
              	</td>
                <td>
                    Fono1 <input size="12" type="text" name="pfono1" value="<?php echo $hospitalizacion['fono1_paciente']; ?>" readonly="readonly" />
				</td>
                <td width="20px">&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>        
                <td>Nombre</td>
                <td>
                    <input size="79" type="text" name="pnombre" value="<?php echo $hospitalizacion['nom_paciente']; ?>" readonly="readonly"  />
                </td>
                <td>
                    Fono2 <input size="12" type="text" name="pfono2" value="<?php echo $hospitalizacion['fono2_paciente']; ?>" readonly="readonly" />
                </td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>Direcci&oacute;n</td>
                <td>
                <input size="79" type="text" name="pdireccion" value="<?php echo $hospitalizacion['direc_paciente']; ?>" readonly="readonly"/>
                </td>
                <td>
            		Fono3 <input size="12" type="text" name="pfono3" value="<?php echo $hospitalizacion['fono3_paciente']; ?>" readonly="readonly" />
                </td>
                <td>&nbsp;</td>
            </tr>
            <tr height="10px">
            </tr>
		</table>
	</fieldset>

        <fieldset class="fieldset_det2"><legend>Hospitalizaci&oacute;n</legend>
            <table width="100%" border="0" cellspacing="1" cellpadding="1">
                <tr height="10px">            </tr>
                <tr>
                    <td width="20px">&nbsp;</td>
					<td>Servicio Clinico</td>
                  <td><input size="25" type="text" name="pservicio" value="<?php echo $hospitalizacion['servicio']; ?>" readonly="readonly"/> Sala <input size="15" type="text" name="pcama" value="<?php echo $hospitalizacion['sala']; ?>" readonly="readonly" /> Cama N&deg; <input size="3" type="text" name="pcama" value="<?php echo $hospitalizacion['cama']; ?>" readonly="readonly" /> Fecha de Ingreso <input size="9" type="text" name="pfecha" value="<?php echo cambiarFormatoFecha($hospitalizacion['fecha_ingreso']); ?>" readonly="readonly" /></td>
                </tr>
                    <td></td>                
                    <td>Medico Tratante</td>
				<td><input size="59" type="text" name="pmedico" value="<?php echo $hospitalizacion['medico']; ?>" readonly="readonly" /> Procedencia <input size="25" type="text" name="pprocedencia" value="<?php echo $hospitalizacion['procedencia']; ?>" readonly="readonly" /> </td>
                </tr>
                <tr>
                    <td></td>
                    <td>Pre-Diagn
                    ostico</td>
                    <td><input size="103" type="text" name="pdiagnostico1" value="<?php echo $hospitalizacion['diagnostico1']; ?>" readonly="readonly" /></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Diagnostico</td>
                    <td><input size="103" type="text" name="pdiagnostico2" value="<?php echo $hospitalizacion['diagnostico2']; ?>" readonly="readonly" /></td>
				
                </tr>

				<tr>
                	<td></td>
                	<td>Patologia Auge
                	<?

					if($hospitalizacion['cod_auge'] <> 0){
	                	echo"<input size='25' type='checkbox' checked name='pauge' disabled='disabled' value=".$hospitalizacion['cod_auge']." disabled='disabled' />";
						echo"</td><td>";
						?>
						 <input size="74" type="text" name="pdesauge" value="<?php echo $hospitalizacion['auge']; ?>" readonly='readonly' />
						 <?
					}
					else {
	            	    echo "<input size='25' type='checkbox' name='pauge' disabled='disabled' value=".$hospitalizacion['cod_auge']." disabled='disabled' />";
						echo"</td><td>";
						echo "<input size='74' type='text' name='pdesauge' value='' readonly='readonly'/>";
					}
				

					if($hospitalizacion['acctransito'] == 1){
	                	echo "<input type='checkbox' checked name='pacctransito' disabled='disabled' />Accidente de Transito.";
    	            }
					else {
            	    	echo "<input type='checkbox' name='pacctransito' disabled='disabled' />Accidente de Transito.";
					}

				?>
                
                </tr>
            </table>
     
        </fieldset>

</div>

<?
$sql = "SELECT * FROM hospitalizaciones where cod_servicio = '".$servicio."' and sala = '".$sala."' and cama = '".$cama."'";
mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');
mysql_select_db('camas') or die('Cannot select database');
$query = mysql_query($sql) or die(mysql_error());
?>

<fieldset><legend>Historial Ocupaci�n de Cama</legend>

	<div align="center" style="width:823px;height:180px;overflow:auto">

        <table width="95%" id="table_detallecama" border="2px" cellpadding="1px" cellspacing="0px">
			<tr>
            	<td width="10%">Desde</td>
            	<td width="10%">Hasta</td>
                <td width="35%">Paciente</td>
            	<td width="45%">Diagnostico</td>
        	</tr>

			<?php
			while($paciente = mysql_fetch_array($query)){
				$id_hosp = $paciente['id'];
				?>

                <tr align="left" style="font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif"
                onClick="window.location.href='<? echo"detallecama.php?id_cama=$id_cama&id_hosp=$id_hosp&cama=$cama&sala=$sala&servicio=$servicio&desc_servicio=$desc_servicio&estado=$estado"; ?>'; parent.GB_hide(); ">

                <td><? echo cambiarFormatoFecha($paciente['fecha_ingreso']); ?>
                </td>
                <td><? echo cambiarFormatoFecha($paciente['fecha_egreso']); ?>
                </td>
                <td><? echo $paciente['nom_paciente']; ?>
                </td>
                <td><? echo $paciente['diagnostico2']; ?></td>
				<?

				echo"</tr>";
		 
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


