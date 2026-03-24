<?php 
//usar la funcion header habiendo mandado c�digo al navegador
ob_start(); 
//end para header

if (!isset($_SESSION)) {
	session_start();
}

if ( $_SESSION['MM_Username'] == null ) {
	$GoTo = "../../acceso/index.php";
	header(sprintf("Location: %s", $GoTo));
}

$id_cama 		= $_GET['id_cama'];
$tipo_atencion 	= $_GET['tipo_atencion'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Detalle de Cama</title>
<link type="text/css" rel="stylesheet" href="css/estilo.css" />

</head>

<body background="../../estandar/img/fdo.jpg" topmargin="5" style="font-family:Arial, Helvetica, sans-serif; font-size:12px">


<SCRIPT LANGUAGE="JavaScript"><!--
imgsrc=new Array();

<?
$permisos = $_SESSION['permiso'];
?>

<?php if ( array_search(21, $permisos) != null ) { ?>  
	imgsrc[5]="img/a_bt_modipac.gif";
<? } else {?>
	imgsrc[5]="img/p_bt_modipac.gif";
<? } ?>
imgsrc[6]="img/p_bt_modipac.gif";

<?php if ( array_search(22, $permisos) != null ) { ?>  
	imgsrc[7]="img/a_bt_modihosp.gif";
<? } else {?>
	imgsrc[7]="img/p_bt_modihosp.gif";
<? } ?>
imgsrc[8]="img/p_bt_modihosp.gif";


img =new Array();
for (i=0; i< imgsrc.length; i++) {
  img[i]=new Image();
  img[i].src=imgsrc[i];
}
function change(number, picture) {
  {
    document[picture].src=img[number].src;
  }
}
// -->
</SCRIPT>

	<?

	include "../funciones/funciones.php";

	$quehora = $_SESSION['MM_Quehora'];

	$queorden = "movil_m";
	$atenc[0] = "SIN ATENCION";
	$atenc[1] = "M-1";
	$atenc[2] = "M-2";
	$atenc[3] = "E-1";
	$atenc[4] = "E-2";
	$atenc[5] = "TP-1";
	$atenc[6] = "TP-2";
	$atenc[7] = "TP-3";
	$atenc[8] = "TP-4";
	$atenc[12] = "TP-5";
	$atenc[13] = "TP-6";
	$atenc[14] = "TP-7";
	$atenc[9] = "TP-ADICIONAL";
	$atenc[10] = "OTRO";
	$atenc[11] = "ATENCION BOX";
	
	
	switch ($quehora)
	{
		case 1:
			$horario = "MA�ANA";
			$queorden = "movil_m";
			$movil[0] = "SIN ASIGNAR";
			$movil[1] = "MOVIL 1";
			$movil[2] = "";
			$movil[3] = "MOVIL 2";
			$movil[4] = "";
			$movil[5] = "MOVIL 3";
			$movil[6] = "MOVIL 4";
			$movil[7] = "";
			$movil[8] = "";
			$movil[9] = "MOVIL ADICIONAL";
			$movil[10] = "OTROS";
			$movil[11] = "CONSULTA BOX";
			$movil[12] = "MOVIL 5";
			$movil[13] = "MOVIL 6";
			$movil[14] = "MOVIL 7";
			break;
		case 2:
			$horario = "TARDE";
			$queorden = "movil_t";
			$movil[0] = "SIN ASIGNAR";
			$movil[1] = "MOVIL 1";
			$movil[2] = "";
			$movil[3] = "MOVIL 2";
			$movil[4] = "";
			$movil[5] = "MOVIL 3";
			$movil[6] = "MOVIL 4";
			$movil[7] = "";
			$movil[8] = "";
			$movil[9] = "MOVIL ADICIONAL";
			$movil[10] = "OTROS";
			$movil[11] = "CONSULTA BOX";
			$movil[12] = "MOVIL 5";
			$movil[13] = "MOVIL 6";
			$movil[14] = "MOVIL 7";
			break;
		case 3:
			$horario = "NOCHE";
			$queorden = "movil_n";
			$movil[0] = "SIN ASIGNAR";
			$movil[1] = "";
			$movil[2] = "";
			$movil[3] = "";
			$movil[4] = "";
			$movil[5] = "MOVIL 1";
			$movil[6] = "MOVIL 2";
			$movil[7] = "MOVIL 3";
			$movil[8] = "MOVIL 4";
			$movil[9] = "MOVIL ADICIONAL";
			$movil[10] = "OTROS";
			$movil[11] = "CONSULTA BOX";
			$movil[12] = "MOVIL 5";
			$movil[13] = "MOVIL 6";
			$movil[14] = "MOVIL 7";
			break;
		case 4:
			$horario = "MADRUGADA";
			$queorden = "movil_ma";
			$movil[0] = "SIN ASIGNAR";
			$movil[1] = "";
			$movil[2] = "";
			$movil[3] = "";
			$movil[4] = "";
			$movil[5] = "MOVIL 1";
			$movil[6] = "MOVIL 2";
			$movil[7] = "MOVIL 3";
			$movil[8] = "MOVIL 4";
			$movil[9] = "MOVIL ADICIONAL";
			$movil[10] = "OTROS";
			$movil[11] = "CONSULTA BOX";
			$movil[12] = "MOVIL 5";
			$movil[13] = "MOVIL 6";
			$movil[14] = "MOVIL 7";
			break;
	}

	
	mysql_connect ('10.6.21.29','usuario','hospital');

	if ($tipo_atencion <> 'XXX' && $tipo_atencion !="")
	{
		$sql = "UPDATE altaprecoz SET
		".$queorden."  = $tipo_atencion
		WHERE id = $id_cama ";
	
	
		mysql_select_db('camas') or die('Cannot select database');
		$resultado_1 = mysql_query( $sql ) or die(mysql_error());
	}

	$sql = "SELECT
camas.altaprecoz.id,
camas.altaprecoz.cod_servicio,
camas.altaprecoz.servicio,
camas.altaprecoz.sala,
camas.altaprecoz.cama,
camas.altaprecoz.movil_m,
camas.altaprecoz.movil_t,
camas.altaprecoz.movil_n,
camas.altaprecoz.movil_ma,
camas.altaprecoz.movil_b,
camas.altaprecoz.cta_cte,
camas.altaprecoz.cod_procedencia,
camas.altaprecoz.procedencia,
camas.altaprecoz.cod_medico,
camas.altaprecoz.medico,
camas.altaprecoz.cod_auge,
camas.altaprecoz.auge,
camas.altaprecoz.acctransito,
camas.altaprecoz.diagnostico1,
camas.altaprecoz.diagnostico2,
camas.altaprecoz.id_paciente,
camas.altaprecoz.rut_paciente,
camas.altaprecoz.ficha_paciente,
camas.altaprecoz.nom_paciente,
camas.altaprecoz.sexo_paciente,
camas.altaprecoz.edad_paciente,
camas.altaprecoz.cod_prevision,
camas.altaprecoz.prevision,
camas.altaprecoz.direc_paciente,
camas.altaprecoz.cod_comuna,
camas.altaprecoz.comuna,
camas.altaprecoz.fono1_paciente,
camas.altaprecoz.fono2_paciente,
camas.altaprecoz.fono3_paciente,
camas.altaprecoz.fecha_categorizacion,
camas.altaprecoz.categorizacion_riesgo,
camas.altaprecoz.categorizacion_dependencia,
camas.altaprecoz.estado,
camas.altaprecoz.hospitalizado,
camas.altaprecoz.fecha_ingreso,
camas.altaprecoz.hora_ingreso,
camas.altaprecoz.fecha_egreso,
camas.altaprecoz.hora_egreso,
paciente.paciente.direccion
FROM
camas.altaprecoz
INNER JOIN paciente.paciente ON camas.altaprecoz.id_paciente = paciente.paciente.id
WHERE
camas.altaprecoz.id = $id_cama";

//echo $sql;
	
	mysql_select_db('camas') or die('Cannot select database');
	$query = mysql_query($sql) or die(mysql_error());

    $paciente = mysql_fetch_array($query);

?>

	<table width="850px" align="center" border="2" bordercolor="#000000" bordercolorlight="#FFFFFF" bordercolordark="#666666" cellspacing="0" cellpadding="0">
    	<th height="20px" align="left" bgcolor="#006699" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; color:#FFF">&nbsp; Informaci&oacute;n de Paciente Hospitalizado.</th>

        <tr>
            <td background="img/fondo.jpg">
            	<fieldset>
<?

if ($paciente)

{

	$cama = $paciente['cama'];
	$sala = $paciente['sala'];
	$servicio = $paciente['cod_servicio'];
	$desc_servicio = $paciente['servicio'];
	$quemovil = $paciente[$queorden];
	
	$_SESSION['MM_pro_id_cama'] = $id_cama;

	$cod_servicio = $paciente['cod_servicio'];
	$nom_paciente = $paciente['nom_paciente'];
	$id_paciente = $paciente['id_paciente'];
	$rut_paciente = $paciente['rut_paciente'];
	$cta_cte = $paciente['cta_cte'];
	$diagnostico2 = $paciente['diagnostico2'];
	$categorizacion_riesgo = $paciente['categorizacion_riesgo'];
	$categorizacion_dependencia = $paciente['categorizacion_dependencia'];
	$categorizacion = $categorizacion_riesgo.''.$categorizacion_dependencia;

//echo "Que movil ".$quemovil;
//echo "</br>Que orden ".$queorden;

	?>

	<div align="center" >
        <form method="get" action="altapaciente.php" name="frm_altapaciente" id="frm_altapaciente">
	    <input type="hidden" name="queorden" value="<? echo $queorden ?>" />
	    <input type="hidden" name="id_cama" value="<? echo $id_cama ?>" />

    	<fieldset class="fieldset_det2">
        	<table width="780px" border="0" cellspacing="1" cellpadding="1">
            	<tr height="10px">
	            </tr>
    	        <tr>
        	        <td width="10px">&nbsp;</td>

            	    <td>Serv.Cinico<input size="25" type="text" name="pservicio" value="<?php echo $paciente['servicio']; ?>" readonly="readonly"/>
                    &nbsp;&nbsp;&nbsp;Horario <input size="10" type="text" name="horario" value="<?php echo $horario; ?>" readonly="readonly"/>
                    &nbsp;&nbsp;&nbsp;Atencion <select name="tipo_atencion" onchange="document.frm_altapaciente.submit()" <?php if ( array_search(19, $permisos) != null ) { echo "enabled='enabled'"; } else { echo "disabled='disabled'"; }  ?> >
						<?
                        for($i=0; $i<count($atenc); $i++)
                        {
                            if ( $movil[$i] <> '') {
                                if( $i == $quemovil )
                                {
                                    echo "<option value='".$i."' selected>".$atenc[$i]."</option>";
                                }
                                else
                                {
                                    echo "<option value='".$i."'>".$atenc[$i]."</option>";
                                }
                            }
                        }
						?>
                    
                        </select>                                            
                    	&nbsp;&nbsp;&nbsp;
						<input type="button" class="boton"  
                        onClick="window.location.href='<? echo"aprecoz.php"; ?>'" value="Actualizar Atencion"
                        <?php if ( array_search(23, $permisos) == null ) { ?>
                        	disabled="disabled"
                    	<? } ?>
						/>                    </td>
	            </tr>
    	    </table>
	    </fieldset>
		</form>
	</div>
    
	<div align="center" >

		<fieldset class="fieldset_det2"><legend><A ID="<#AWBID>" ONMOUSEOVER="change('5','m3')" ONMOUSEOUT= "change('6','m3')" name="m3"><IMG NAME="m3" SRC="img/p_bt_modipac.gif"
        <?php if ( array_search(21, $permisos) != null ) { ?>  
	        onclick="window.location.href='<? echo"pro1_modificapaciente.php?id_cama=$id_cama"; ?>'; parent.GB_hide(); "
		<? } ?>
        BORDER="0" vspace="0" hspace="0"></A>
        </legend>
		  	<table width="780px" border="0" cellspacing="1" cellpadding="1">
		    	<tr height="10px"></tr>
		        <tr>
		            <td width="10px">&nbsp;</td>
		            <td width="67px">Rut</td>
		            <td><input size="9" type="text" name="prut" value="<?php echo $paciente['rut_paciente']; ?>" readonly="readonly" />
		              <input size="1" type="text" name="pdv" value="<?php echo ValidaDVRut($paciente['rut_paciente']); ?>" readonly="readonly" />
		              N&deg; Ficha
		              <input size="10" type="text" name="pficha" value="<?php echo $paciente['ficha_paciente']; ?>" readonly="readonly" />
		              Prevision
		              <input size="20" type="text" name="pprevision" value="<?php echo $paciente['prevision']; ?>" readonly="readonly" /></td>
		            <td width="45px">Fono1</td>
                    <td width="100px">
		              <input size="12" type="text" name="pfono1" value="<?php echo $paciente['fono1_paciente']; ?>" readonly="readonly" /></td>
		            <td width="10px">&nbsp;</td>
	            </tr>
		        <tr>
		            <td>&nbsp;</td>
		            <td>Nombre</td>
		            <td><input size="81" type="text" name="pnombre" value="<?php echo $paciente['nom_paciente']; ?>" readonly="readonly"  /></td>
		            <td>Fono2 </td>
                    <td>
		              <input size="12" type="text" name="pfono2" value="<?php echo $paciente['fono2_paciente']; ?>" readonly="readonly" /></td>
		            <td>&nbsp;</td>
	          	</tr>
		      	<tr>
		            <td>&nbsp;</td>
		            <td>Direccion</td>
		            <td><input size="81" type="text" name="pdireccion" value="<?php echo $paciente['direccion']; ?>" readonly="readonly"/></td>
		            <td>Fono3</td>
                    <td>
		              <input size="12" type="text" name="pfono3" value="<?php echo $paciente['fono3_paciente']; ?>" readonly="readonly" /></td>
		            <td>&nbsp;</td>
	          	</tr>
		      	<tr height="10px"></tr>
		  	</table>
		</fieldset>

        <fieldset class="fieldset_det2"><legend>
        <A ID="<#AWBID>" ONMOUSEOVER="change('7','m4')" ONMOUSEOUT= "change('8','m4')" name="m4"><IMG NAME="m4" SRC="img/p_bt_modihosp.gif"
        <?php if ( array_search(22, $permisos) != null ) { ?>  
            onclick="window.location.href='<? echo"pro1_modificaingreso.php?id_cama=$id_cama"; ?>'; parent.GB_hide(); "
        <? } ?>
        BORDER="0" vspace="0" hspace="0"></A>
        </legend>
        
            <table width="780px" border="0" cellspacing="1" cellpadding="1">
                <tr height="10px">
                    <td width="10px"></td>
                	<td width="110px">Fecha Ingreso </td>
                    <td style="font-size:14px"> <input size="9" type="text" name="pfecha" value="<?php echo cambiarFormatoFecha($paciente['fecha_ingreso']); ?>" readonly="readonly" />
&nbsp;&nbsp; Hora <input size="4" type="text" name="hora_ingreso" value="<?php echo substr($paciente['hora_ingreso'],0,5); ?>" readonly="readonly" />
&nbsp;&nbsp; Cta-Cte <input size="8" type="text" name="cta_cte" value="<?php echo $cta_cte; ?>" readonly="readonly" />
&nbsp;&nbsp; <?php if ($servicio == 6 or $servicio == 7 or $servicio == 10 or $servicio == 11) { ?>
Tipo Cama <input size="33" type="text" name="tipo_cama" value="<? echo $d_tipo_1." ".$d_tipo_2; ?>" readonly="readonly" /> <? } ?> 
                     </td>
                </tr>
                <tr>
                    <td width="10px"></td>                
                    <td>Medico Tratante</td>
					<td><input size="55" type="text" name="pmedico" value="<?php echo $paciente['medico']; ?>" readonly="readonly" /> 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Procedencia <input size="25" type="text" name="pprocedencia" value="<?php echo $paciente['procedencia']; ?>" readonly="readonly" /> </td>
                </tr>
                <tr>
                    <td></td>
                    <td>Pre-Diagnostico</td>
                    <td ><input size="101" type="text" name="pdiagnostico1" value="<?php echo $paciente['diagnostico1']; ?>" readonly="readonly" /></td>
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
							echo "<input type='checkbox' checked name='pacctransito' disabled='disabled' />Accidente Transito.";
						}
						else {
							echo "<input type='checkbox' name='pacctransito' disabled='disabled' />Accidente Transito.";				
						}
						?>
                        
                    </td>

                </tr>
              <tr height="10px"> </tr>                
            </table>

        </fieldset>


        <fieldset class="fieldset_det2"> <legend>Opciones</legend>
            <table width="780px" border="0" cellspacing="0" cellpadding="0">
                <tr>
					<td align="center" style="padding-top:5px; padding-bottom:5px">
                   	    <input type="button" class="boton"  
                        onclick="window.location.href='<? echo"pro1_generaalta.php"; ?>'" value="Egreso (Alta, Traslado)"
                        <?php if ( array_search(23, $permisos) == null ) { ?>
                        	disabled="disabled"
                    	<? } ?>
						/>
               	      <input name="" type="button" class="boton"  
                        onclick="window.location.href='<? echo"pro1_categoriza.php?id_cama=$id_cama&cod_servicio=$cod_servicio&desc_servicio=$desc_servicio&sala=$sala&cama=$cama&nom_paciente=$nom_paciente&id_paciente=$id_paciente&diagnostico2=$diagnostico2&tipo_1=$tipo_1&d_tipo_1=$d_tipo_1&tipo_2=$tipo_2&d_tipo_2=$d_tipo_2"; ?>'" value="Categorizaci�n"
						<?php if ( array_search(24, $permisos) == null ) { ?>
                        	disabled="disabled"
						<? } ?>
                        />
               	      <input name="" type="button" class="boton"
							onclick="window.location.href='<? echo"historicopaciente.php?id_cama=$id_cama&nom_paciente=$nom_paciente&id_paciente=$id_paciente"; ?>'" value="Historico Paciente"
						<?php if ( array_search(24, $permisos) == null ) { ?>
                        	disabled="disabled"
						<? } ?>                        
                        />
                        						<input name="" type="button" class="boton" 
							onclick="window.location.href='<? echo"hist_clinico.php?id_cama=$id_cama&nom_paciente=$nom_paciente&id_paciente=$id_paciente&rut_paciente=$rut_paciente&cta_cte=$cta_cte"; ?>'" value="Historial Cl&iacute;nico"
						<?php if ( array_search(24, $permisos) == null ) { ?>
                        	disabled="disabled"
						<? } ?>
                        />

                    </td>
                </tr>
                <tr>
                	<td align="center" style="padding-bottom:5px">
						<input type="button" class="boton" onclick="window.location.href='enconstruccion.php'" value="Registro Prestaciones" 
                        />
                        <input type="button" class="boton" onclick="window.location.href='enconstruccion.php'" value="Epicrisis Medica" 
   						<?php if ( array_search(243, $permisos) == null ) { ?>
                        	disabled="disabled"
						<? } ?>                        
                        />
                   	  	<input type="button" class="boton" onclick="window.location.href='enconstruccion.php'" value="Epicrisis Enfermera"
   						<?php if ( array_search(245, $permisos) == null ) { ?>
                        	disabled="disabled"
						<? } ?>                        
                         />
                      	<input type="button" class="boton"
                        	onClick="window.location.href='<? echo"aprecoz.php"; ?>'" value="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Salir &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
                       	/>
                    </td>
              </tr>
            </table>
		</fieldset>

	</div>

    
<?
}
else
{

echo "Problemas de Registro Cominuquese con el Administrador de Sistemas";
?>	<input type="button" value="               Volver               " onClick="window.location.href='<? echo"aprecoz.php"; ?>';
parent.parent.GB_hide(); " > <?

}

?>


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


