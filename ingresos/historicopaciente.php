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

<body topmargin="5" >

	<table width="853" border="0" align="center" cellspacing="" cellpadding="0">
        <tr>
            <td width="853">
            <fieldset class="fondoF"><legend class="estilo1">Datos Pacientes</legend>	

            <table width="780px" border="0" cellspacing="5" cellpadding="1">
                <tr>
                    <td width="155">Servicio Clinico</td>
                	<td width="606"><input size="25" type="text" name="pservicio" value="<?php echo $hospitalizacion['servicio']; ?>" readonly="readonly"/> Sala <input size="10" type="text" name="pcama" value="<?php echo $hospitalizacion['sala']; ?>" readonly="readonly" /> Cama N&deg; <input size="3" type="text" name="pcama" value="<?php echo $hospitalizacion['cama']; ?>" readonly="readonly" /> 
                  Fecha Ingreso 
                    <input size="9" type="text" name="pfecha" value="<?php echo cambiarFormatoFecha($hospitalizacion['fecha_ingreso']); ?>" readonly="readonly" /></td>
                </tr>
                <tr>
                                  
                    <td>Medico Tratante</td>
					<td><input size="55" type="text" name="pmedico" value="<?php echo $hospitalizacion['medico']; ?>" readonly="readonly" /> Procedencia <input size="20" type="text" name="pprocedencia" value="<?php echo $hospitalizacion['procedencia']; ?>" readonly="readonly" /> </td>
                </tr>
                <tr>
                    
                    <td>Pre-Diagn ostico</td>
                    <td><input size="91" type="text" name="pdiagnostico1" value="<?= $hospitalizacion['diagnostico1']; ?>" readonly="readonly" /></td>
                </tr>
                <tr>
                    
                    <td>Diagnostico</td>
                    <td><input size="91" type="text" name="pdiagnostico2" value="<?= $hospitalizacion['diagnostico2']; ?>" readonly="readonly" /></td>
				
                </tr>

				<tr>
                	
                	<td colspan="2">
					
	                	<input size='25' type='checkbox' <? if($hospitalizacion['cod_auge'] <> 0){ ?> checked="checked" <? } ?> name='pauge' value="<?= $hospitalizacion['cod_auge'] ?>" disabled='disabled' />P.Auge
						
						 <input size="74" type="text" name="pdesauge" value="<?= $hospitalizacion['auge']; ?>" readonly='readonly' />
				
	                	<br /><input type='checkbox' <? if($hospitalizacion['acctransito'] == 1){ ?> checked="checked" <? } ?> name='pacctransito' disabled='disabled' />Acc.Transito
                        <input type='checkbox' <? if($hospitalizacion['multires'] == 1){ ?> checked="checked" <? } ?> name='pacctransito' disabled='disabled' />Multires.
    	            
                </td>
                </tr>
            </table>


        <table width="780px" border="0" cellspacing="5" cellpadding="1">
            <tr>
               
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
                
            </tr>
            <tr>
                 
                <td>Nombre</td>
                <td>
                    <input size="81" type="text" name="pnombre" value="<?php echo $hospitalizacion['nom_paciente']; ?>" readonly="readonly"  />
                </td>
		            <td width="45px">Fono2</td>
                    <td>
                    <input size="12" type="text" name="pfono2" value="<?php echo $hospitalizacion['fono2_paciente']; ?>" readonly="readonly" />
                </td>
               
            </tr>
            <tr>
                
                <td>Direcci&oacute;n</td>
                <td>
                <input size="81" type="text" name="pdireccion" value="<?php echo $hospitalizacion['direc_paciente']; ?>" readonly="readonly"/>
                </td>
		            <td width="45px">Fono3</td>
                    <td>
            		<input size="12" type="text" name="pfono3" value="<?php echo $hospitalizacion['fono3_paciente']; ?>" readonly="readonly" />
                </td>
                
            </tr>
            <tr>
            </tr>
		</table>

        <table width="770px" height="170px" border="0" cellspacing="1" cellpadding="1">
        	<tr>
            <td>
	
                <div align="center" style="width:100%;height:165px;overflow:auto">
        
                <table width="97%" class="listado" border="2px" cellpadding="1px" cellspacing="0px">
                    <tr>
                        <td width="10%">Desde</td>
                        <td width="10%">Hasta</td>
                        <td width="15%">Servicio</td>
                        <td width="10%">Sala</td>
                        <td width="10%">Cama</td>
                        <td width="45%">Diagnostico</td>
                    </tr>
        
        
                    <?php
    
                    if ($id_paciente <> 0)
                        {
            
                        $sql = "SELECT * FROM hospitalizaciones where id_paciente = '".$id_paciente."' order by fecha_ingreso DESC";
                        //$sql = "SELECT * FROM hospitalizaciones where rut_paciente = '".$rut_paciente."'";
                        mysql_connect ('10.6.21.12','gestioncamas','123gestioncamas');
                        mysql_select_db('camas') or die('Cannot select database');
                        $query2 = mysql_query($sql) or die(mysql_error());
    
    
                        while($list_paciente = mysql_fetch_array($query2)){
							$id_hosp = $list_paciente['id'];

							?>
                
                            <tr align="left" style="font-size:10px; font-family:Verdana, Arial, Helvetica, sans-serif"
                onClick="window.location.href='<? echo"historicopaciente.php?id_cama=$id_cama&id_hosp=$id_hosp&nom_paciente=$nom_paciente&id_paciente=$id_paciente&camaSN=$camaSN"; ?>'; parent.GB_hide(); ">
                            <td><? echo cambiarFormatoFecha($list_paciente['fecha_ingreso']); ?> </td>
                            <td><? echo cambiarFormatoFecha($list_paciente['fecha_egreso']); ?>	</td>
                            <td><? echo $list_paciente['servicio']; ?> </td>
                            <td><? echo $list_paciente['sala']; ?> </td>
                            <td><? echo $list_paciente['cama']; ?> </td>
                            <td><? echo $list_paciente['diagnostico2']; ?>&nbsp;</td>
                            <?
            
                            echo"</tr>";
                        }
                    }
                    ?>
        
                </table>
        
            </div>
	
            </td>
            </tr>
        </table>


            <table align="center" border="0" cellspacing="0" cellpadding="0">
                <tr>
                	<? if($camaSN != 1){ ?>
                    <td>
						<input  type="button" class="buttonGeneral"
                        	onclick="window.location.href='<? echo"altapaciente.php?id_cama=$id_cama"; ?>'; parent.GB_hide(); " value=" &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Salir &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
						/>
                    </td>
                    <? }
						else{ ?>
                    <td>
						<input type="button" class="buttonGeneral"
                        	onclick="window.location.href='<? echo"../superNumeraria/camaSuperNum.php"; ?>'; parent.GB_hide(); " value=" &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Salir &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
						/>
                    </td>
                    <? } ?>
                </tr>
            </table>

</fieldset>
</td>
</tr>
</table>

</body>
</html>

