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

<?
$permisos = $_SESSION['permiso'];

include "../funciones/funciones.php";

$_SESSION['MM_pro_id_cama'] = $id_cama;
$_SESSION['MM_pro_cama'] = $cama;
$_SESSION['MM_pro_sala'] = $sala;
$_SESSION['MM_pro_servicio'] = $cod_servicio;
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
<body background="../../estandar/img/fdo.jpg" topmargin="5" style="font-family:Arial, Helvetica, sans-serif; font-size:12px">
	<table width="850px" align="center" border="2" bordercolor="#000000" bordercolorlight="#FFFFFF" bordercolordark="#666666" cellspacing="0" cellpadding="0">
    	<th height="20px" align="left" bgcolor="#006699" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; color:#FFF">&nbsp; Historico de Ocupaci&oacute;n de Cama.</th>

        <tr>
            <td background="img/fondo.jpg">
            	<fieldset>


	<div align="center" >

        <fieldset class="fieldset_det2"><legend>Historial Ocupaci�n de Cama</legend>
            <table width="780px" border="0" cellspacing="1" cellpadding="1">
                <tr>
                    <td width="10px">&nbsp;</td>
					<td>Servicio Clinico</td>
                	<td><input size="25" type="text" name="pservicio" value="<?php echo $hospitalizacion['servicio']; ?>" readonly="readonly"/> Sala <input size="10" type="text" name="pcama" value="<?php echo $hospitalizacion['sala']; ?>" readonly="readonly" /> Cama N&deg; <input size="3" type="text" name="pcama" value="<?php echo $hospitalizacion['cama']; ?>" readonly="readonly" /> 
                  Fecha Ingreso 
                    <input size="9" type="text" name="pfecha" value="<?php echo cambiarFormatoFecha($hospitalizacion['fecha_ingreso']); ?>" readonly="readonly" /></td>
                </tr>
                <tr>
                    <td width="10px"></td>                
                    <td>Medico Tratante</td>
					<td><input size="55" type="text" name="pmedico" value="<?php echo $hospitalizacion['medico']; ?>" readonly="readonly" /> Procedencia <input size="25" type="text" name="pprocedencia" value="<?php echo $hospitalizacion['procedencia']; ?>" readonly="readonly" /> </td>
                </tr>
                <tr>
                    <td></td>
                    <td>Pre-Diagnostico</td>
                    <td><input size="101" type="text" name="pdiagnostico1" value="<?php echo $hospitalizacion['diagnostico1']; ?>" readonly="readonly" /></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Diagnostico</td>
                    <td><input size="101" type="text" name="pdiagnostico2" value="<?php echo $hospitalizacion['diagnostico2']; ?>" readonly="readonly" /></td>
				
                </tr>

				<tr>
                	<td></td>
                	<td colspan="2">
                	<?

					if($hospitalizacion['cod_auge'] <> 0){
	                	echo"<input size='25' type='checkbox' checked name='pauge' value=".$hospitalizacion['cod_auge']." disabled='disabled' />Patologia Auge";
						?>
						 <input size="74" type="text" name="pdesauge" value="<?php echo $hospitalizacion['auge']; ?>" readonly='readonly' />
						 <?
					}
					else {
	            	    echo "<input size='25' type='checkbox' name='pauge' value=".$hospitalizacion['cod_auge']." disabled='disabled' />Patologia Auge";
						echo "<input size='74' type='text' name='pdesauge' value='' readonly='readonly'/>";
					}
				

					if($hospitalizacion['acctransito'] == 1){
	                	echo "<input type='checkbox' checked name='pacctransito' disabled='disabled' />Accidente de Transito.";
    	            }
					else {
            	    	echo "<input type='checkbox' name='pacctransito' disabled='disabled' />Accidente de Transito.";
					}

				?>
                </td>
                </tr>
            </table>
     
        </fieldset>
        
		<fieldset class="fieldset_det2">


        <table width="780px" border="0" cellspacing="1" cellpadding="1">
            <tr>
                <td width="10px">&nbsp;</td>
                <td width="67px">Rut</td>
                <td> 
                  <input size="9" type="text" name="prut" value="<?php echo $hospitalizacion['rut_paciente']; ?>" readonly="readonly" />
                <input size="1" type="text" name="pdv" value="<?php echo ValidaDVRut($hospitalizacion['rut_paciente']); ?>" readonly="readonly" /> 
                N&deg; Ficha 
                <input size="10" type="text" name="pficha" value="<?php echo $hospitalizacion['ficha_paciente']; ?>" readonly="readonly" /> Prevision <input size="20" type="text" name="pprevision" value="<?php echo $hospitalizacion['prevision']; ?>" readonly="readonly" />
              	</td>
		            <td width="45px">Fono1</td>
                    <td width="100px">
                    <input size="12" type="text" name="pfono1" value="<?php echo $hospitalizacion['fono1_paciente']; ?>" readonly="readonly" />
				</td>
                <td width="10px">&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>        
                <td>Nombre</td>
                <td>
                    <input size="81" type="text" name="pnombre" value="<?php echo $hospitalizacion['nom_paciente']; ?>" readonly="readonly"  />
                </td>
		            <td width="45px">Fono2</td>
                    <td>
                    <input size="12" type="text" name="pfono2" value="<?php echo $hospitalizacion['fono2_paciente']; ?>" readonly="readonly" />
                </td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>Direcci&oacute;n</td>
                <td>
                <input size="81" type="text" name="pdireccion" value="<?php echo $hospitalizacion['direc_paciente']; ?>" readonly="readonly"/>
                </td>
		            <td width="45px">Fono3</td>
                    <td>
            		<input size="12" type="text" name="pfono3" value="<?php echo $hospitalizacion['fono3_paciente']; ?>" readonly="readonly" />
                </td>
                <td>&nbsp;</td>
            </tr>
            <tr>
            </tr>
		</table>
	</fieldset>
        




<?
$sql = "SELECT * FROM hospitalizaciones where cod_servicio = '".$cod_servicio."' and sala = '".$sala."' and cama = '".$cama."'order by fecha_ingreso DESC";
mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');
mysql_select_db('camas') or die('Cannot select database');
$query = mysql_query($sql) or die(mysql_error());

?>

<fieldset>
    <table width="770px" height="170px" border="0" cellspacing="1" cellpadding="1">
    	<tr>
            <td>

            <div align="center" style="width:100%;height:165px;overflow:auto">
        
                <table width="97%" id="table_desbloqueocama" border="2px" cellpadding="1px" cellspacing="0px">
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
                        onClick="window.location.href='<? echo"historicocama.php?id_cama=$id_cama&id_hosp=$id_hosp&cama=$cama&sala=$sala&cod_servicio=$cod_servicio&desc_servicio=$desc_servicio&estado=$estado"; ?>'; parent.GB_hide(); ">
        
                        <td><? echo cambiarFormatoFecha($paciente['fecha_ingreso']); ?>
                        </td>
                        <td><? echo cambiarFormatoFecha($paciente['fecha_egreso']); ?>
                        </td>
                        <td><? echo $paciente['nom_paciente']; ?>
                        </td>
                        <td><? echo $paciente['diagnostico2']; ?>&nbsp;</td>
                        <?
        
                        echo"</tr>";
                 
                    }
                    ?>
        
        
                </table>
        
                <script language="JavaScript">
                <!--
                    tigra_tables('table_desbloqueocama', 1, 0, '#ffffff', '#ffffcc', '#ffcc66', '#cccccc');
                // -->
                </script>
        
            </div>
            </td>
            </tr>
        </table>
</fieldset>





        <fieldset class="fieldset_det2">
            <table align="center" border="0" cellspacing="0" cellpadding="0">
                <tr>
                	<td>
						<input type="button" class="boton"  
                        	onclick="window.location.href='<? echo"altapaciente.php?id_cama=$id_cama"; ?>'; parent.GB_hide(); " value=" &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Salir &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
						/>
                    </td>
                </tr>
            </table>
		</fieldset>


</div>

</fieldset>
</td>
</tr>
</table>

</body>
</html>

