<?php 
//usar la funcion header habiendo mandado código al navegador
ob_start(); 
//end para header

if (!isset($_SESSION)) {
	session_start();
}

if ( $_SESSION['MM_Username'] == null ) {
	$GoTo = "../../acceso/index.php";
	header(sprintf("Location: %s", $GoTo));
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Detalle de Cama</title>
<link type="text/css" rel="stylesheet" href="css/estilo.css" />
<script type="text/javascript">

function barthel(formulario){
	
	  var valorBarthel = formulario.barthel.value;
	  	if(valorBarthel == ""){
			var variable = "";
		}else if((valorBarthel >= 0) & (valorBarthel < 20)){
			var variable = "Dependiente";
		}else if((valorBarthel >= 20) & (valorBarthel <= 35)){
			var variable = "Grave";
			}else if((valorBarthel >= 40) & (valorBarthel <= 55)){
				var variable = "Moderado";
				}else if((valorBarthel >= 60) & (valorBarthel < 100)){
					var variable = "Leve";
					}else if(valorBarthel == 100){
						var variable = "Independiente";
						}else{
							var variable = "Valor invalido";
							}
		document.getElementById('valorBart').value = variable;
}

window.onload=function(){
	setInterval('barthel(altaPaciente)',10);	
}

</script>
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

	$sql = "SELECT * FROM camas where id = '".$id_cama."'";
	mysql_connect ($_SESSION['BD_SERVER'],'gestioncamas','123gestioncamas');
	mysql_select_db('camas') or die('Cannot select database');
	$query = mysql_query($sql) or die(mysql_error());

    $paciente = mysql_fetch_array($query);

?>
<form name="altaPaciente" id="altaPaciente">

	<table width="840px" align="center" border="2" bordercolor="#000000" bordercolorlight="#FFFFFF" bordercolordark="#666666" cellspacing="0" cellpadding="0">
    	<th height="20px" align="left" bgcolor="#006699" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; color:#FFF">&nbsp; Informaci&oacute;n de Paciente Hospitalizado.</th>

        <tr>
            <td background="img/fondo.jpg">
            	<fieldset>
<?



if ($paciente)

{

	$cama = $paciente['cama'];
	$sala = $paciente['sala'];
	$que_cod_servicio = $paciente['que_cod_servicio'];
	$que_servicio = $paciente['que_servicio'];
	$servicio = $paciente['cod_servicio'];
	$desc_servicio = $paciente['servicio'];
	$pabellon = $paciente['pabellon'];
	$estado = $paciente['estado'];
	$tipo_1 = $paciente['tipo_1'];
	$d_tipo_1 = $paciente['d_tipo_1'];
	$tipo_2 = $paciente['tipo_2'];
	$d_tipo_2 = $paciente['d_tipo_2'];
	$epiId = $paciente['epiId'];
	$pac_fecha_ingreso = $paciente['fecha_ingreso'];
	$multiRes = $paciente['multires'];

	$_SESSION['MM_pro_id_cama'] = $id_cama;
	$_SESSION['MM_pro_cama'] = $cama;
	$_SESSION['MM_pro_sala'] = $sala;
	$_SESSION['MM_pro_servicio'] = $servicio;
	$_SESSION['MM_pro_desc_servicio'] = $desc_servicio;
	$_SESSION['MM_pro_estado'] = $estado;
	$_SESSION['MM_pro_epiId'] = $epiId;

	$cod_servicio = $paciente['cod_servicio'];
	$nom_paciente = $paciente['nom_paciente'];
	$id_paciente = $paciente['id_paciente'];
	$rut_paciente = $paciente['rut_paciente'];
	$cta_cte = $paciente['cta_cte'];
	$diagnostico2 = $paciente['diagnostico2'];
	$categorizacion_riesgo = $paciente['categorizacion_riesgo'];
	$categorizacion_dependencia = $paciente['categorizacion_dependencia'];
	$categorizacion = $categorizacion_riesgo.''.$categorizacion_dependencia;

	$ruta = "enviar_pyxis.php?servicio=".$cod_servicio."&nom_paciente=".$nom_paciente."&id_paciente=".$id_paciente."&rut_paciente=".$rut_paciente."&cta_cte=".$cta_cte;
	
	/*- DANNY DESDE AQUI ES EL NUEVO CODIGO-*/
	//DEPENDIENDO DEL SERVICIO SE MOSTRARA UNA DIFERENTE EPICRISIS MEDICA
	if (($que_cod_servicio == 2 ) || ($que_cod_servicio == 3 ) || ($que_cod_servicio == 7 ) || ($que_cod_servicio == 4 ) || ($que_cod_servicio == 1 ) || ($que_cod_servicio == 5 ) || ($que_cod_servicio == 8 ) || ($que_cod_servicio == 9 )){ 
						 
	 $linkEpi = "epicrisisMedica.php?id_cama=$id_cama&ctaCte=$cta_cte&id_paciente=$id_paciente&idServicio=$servicio&prev_paciente=".$paciente['prevision']."&cod_prev=".$paciente['cod_prevision']."&ing_paciente=".$paciente['fecha_ingreso']."&multiRes=".$multiRes."&hospitaliza=".$paciente['hospitalizado']."&medicoGC=".$paciente['cod_medico']." - ".$paciente['medico'];
	 
	 }else if($que_cod_servicio == 6 ){
		 
		 $linkEpi = "epicrisisNeo/epicrisisMedicaNeo.php?id_cama=$id_cama&ctaCte=$cta_cte&id_paciente=$id_paciente&idServicio=$servicio&prev_paciente=".$paciente['prevision']."&cod_prev=".$paciente['cod_prevision']."&ing_paciente=".$paciente['fecha_ingreso']."&multiRes=".$multiRes."&hospitaliza=".$paciente['hospitalizado']."&medicoGC=".$paciente['cod_medico']." - ".$paciente['medico'];
		 }
	/*- DANNY HASTA AQUI ES EL NUEVO CODIGO-*/
	
	?>

	<div align="center" >
       	<table width="100%" border="0" cellspacing="1" cellpadding="1">

            <tr>
                <td  align="right">
					<? if ($cod_servicio == 8 or $cod_servicio == 9 or $cod_servicio == 50 ) { ?>
<img src="../../estandar/iconos/pyxis.jpg" alt="Enviar Paciente a Pyxis" onClick="window.open('<? echo $ruta; ?>', 'ventana_pyxis', 'toolbar=0,location=0, directories=0,status=0,menubar=0,scrollbars=1,resizable=1,left=1,top=1,fullscreen=0')" />
      				<? } ?>

                </td>
            </tr>
         </table>

    	<fieldset class="fieldset_det2">
        	<table width="830px" border="0" cellspacing="1" cellpadding="1">
            	<tr height="10px">
	            </tr>

    	        <tr>
        	        <td width="10px">&nbsp;</td>
            	    <td>Servicio Clinico : <input size="20" type="text" name="pservicio" value="<?php echo $paciente['servicio']; ?>" readonly="readonly"/> Sala : <input size="10" type="text" name="pcama" value="<?php echo $paciente['sala']; ?>" readonly="readonly" /> Cama N° : <input size="3" type="text" name="pcama" value="<?php echo $paciente['cama']; ?>" readonly="readonly" /> Paciente Correspondie a... <input size="15" type="text" name="pcama" value="<?php echo $paciente['que_servicio']; ?>" readonly="readonly" />
					</td>
	            </tr>
    	    </table>
	    </fieldset>

	</div>
    
	<?
	if ($estado == 2 or $estado == 4)
	
	{
	?>

	<div align="center" >

		<fieldset class="fieldset_det2"><legend><A ID="<#AWBID>" ONMOUSEOVER="change('5','m3')" ONMOUSEOUT= "change('6','m3')" name="m3"><IMG NAME="m3" SRC="img/p_bt_modipac.gif"
        <?php if ( array_search(21, $permisos) != null ) { ?>  
	        onclick="window.location.href='<? echo"pro1_modificapaciente.php?id_cama=$id_cama"; ?>'; parent.GB_hide(); "
		<? } ?>
        BORDER="0" vspace="0" hspace="0"></A>
        </legend>
		  	<table width="830px" border="0" cellspacing="1" cellpadding="1">
		    	<tr height="10px"></tr>
		        <tr>
		            <td width="10px">&nbsp;</td>
		            <td width="67px">Rut</td>
		            <td><input size="9" type="text" name="prut" value="<?php echo $paciente['rut_paciente']; ?>" readonly="readonly" />
		              <input size="1" type="text" name="pdv" value="<?php echo ValidaDVRut($paciente['rut_paciente']); ?>" readonly="readonly" />
		              N&deg; Ficha
		              <input size="10" type="text" name="pficha" value="<?php echo $paciente['ficha_paciente']; ?>" readonly="readonly" />
		              Prevision
		              <input size="20" type="text" name="pprevision" value="<?php echo $paciente['prevision']; ?>" readonly="readonly" />
                      <input size="2" type="text" name="categorizacion" value="<?php echo $categorizacion ?>" readonly="readonly" /></td>
		            <td width="45px">Fono1</td>
                    <td width="100px">
		              <input size="12" type="text" name="pfono1" value="<?php echo $paciente['fono1_paciente']; ?>" readonly="readonly" /></td>
		            <td width="10px">&nbsp;</td>
	            </tr>
		        <tr>
		            <td>&nbsp;</td>
		            <td>Nombre</td>
		            <td><input size="60" type="text" name="pnombre" value="<?php echo $paciente['nom_paciente']; ?>" readonly="readonly"  />
		          &nbsp;Edad  &nbsp;&nbsp;     
		          <input size="7" type="text" name="pedad" value="<?php echo $paciente['edad_paciente']; ?>" readonly="readonly"  /></td>
		            <td>Fono2 </td>
                    <td>
		              <input size="12" type="text" name="pfono2" value="<?php echo $paciente['fono2_paciente']; ?>" readonly="readonly" /></td>
		            <td>&nbsp;</td>
	          	</tr>
		      	<tr>
		            <td>&nbsp;</td>
		            <td>Dirección</td>
		            <td><input size="81" type="text" name="pdireccion" value="<?php echo $paciente['direc_paciente']; ?>" readonly="readonly"/></td>
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
        
            <table width="830px" border="0" cellspacing="1" cellpadding="1">
                <tr height="10px">
                    <td width="10px"></td>
                	<td width="110px">Fecha Ingreso </td>
                    <td style="font-size:14px"> <input size="9" type="text" name="pfecha" value="<?php echo cambiarFormatoFecha($paciente['fecha_ingreso']); ?>" readonly="readonly" />
&nbsp;&nbsp; Hora <input size="4" type="text" name="hora_ingreso" value="<?php echo substr($paciente['hora_ingreso'],0,5); ?>" readonly="readonly" />
&nbsp;&nbsp; Cta-Cte <input size="8" type="text" name="cta_cte" value="<?php echo $cta_cte; ?>" readonly="readonly" />
&nbsp;&nbsp; <?php if ($servicio == 6 or $servicio == 7 or $servicio == 10 or $servicio == 11 or $servicio == 14) { ?>
Tipo Cama <input size="33" type="text" name="tipo_cama" value="<? echo $d_tipo_1." ".$d_tipo_2; ?>" readonly="readonly" /> <? } ?> 
                     </td>
                </tr>
                <? if(($servicio <> 6) && ($servicio <> 7)){ ?>
                <tr>
                	<td>&nbsp;</td>
                    <td>I. Barthel: </td>
                    <td><input type="text" name="barthel" id="barthel" size="2px" value="<?= $paciente['barthel']?>" readonly="readonly" />&nbsp;<input type="text" name="valorBart" id="valorBart" readonly="readonly" /></td>
                </tr>
                <? } ?>
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
							echo "<input type='checkbox' name='pacctransito' disabled='disabled' />Acc. Transito.";				
						}
						
						if($paciente['multires'] == 1){
							echo "<input type='checkbox' checked name='pacctransito' disabled='disabled' />Multiresistente.";
						}
						else {
							echo "<input type='checkbox' name='pacctransito' disabled='disabled' />Multiresistente.";
						}
						?>
                        
                    </td>

                </tr>
              <tr height="10px"> </tr>                
            </table>

        </fieldset>


        <fieldset class="fieldset_det2"> <legend>Opciones</legend>
            <table width="830px" border="0" cellspacing="0" cellpadding="0">
                <tr>
					<td align="center" style="padding-top:5px; padding-bottom:5px">
                   
                    
						<? 	if($estado == 2){ ?>
                        
                            <input type="button" class="boton"  
                            onclick="window.location.href='<? echo"pro1_generaalta.php"; ?>'" value="Traslado Otro Servicio"
                            <?php if ( array_search(23, $permisos) == null ) { ?>
                                disabled="disabled"
                            <? } ?>
                            />
						<? } ?>
                        <? 	if($estado == 4){ ?>
                            <input type="button" class="boton"  
                            onclick="window.location.href='<? echo"pro1_generaalta.php"; ?>'" value="Alta o Egreso Externo"
                            <?php if ( array_search(23, $permisos) == null ) { ?>
                                disabled="disabled"
                            <? } ?>
                            />
						<? } ?>
                        
	               	    <input name="" type="button" class="boton"  
                        onclick="window.location.href='<? echo	"pro1_traslado_interno.php"; ?>'" value="Traslado Interno"
                    	<?php if ( array_search(23, $permisos) == null ) { ?>
                        	disabled="disabled"
                    	<? } ?>
                        />
                        <?
						if ($pabellon == 1){ 
						?>
                        <input type="button" class="boton" onclick="window.location.href=' <? echo "pro1_regresadepabellon.php"; ?> '" value="Regreso de Pabellón"
                            <? if ( array_search(23, $permisos) == null ) { ?>
                                disabled="disabled"
                            <? } 
							?> /> <?
						}
						else
						{ ?>
							<input type="button" class="boton" 
                            onclick="window.location.href='<? echo"pro1_enviaapabellon.php"; ?>'" value="Traslado a Pabellón"
                            <?php if ( array_search(23, $permisos) == null ) { ?>
                                disabled="disabled"
                            <? }
							?> /> <?
						}?>
                         
               	    	<input name="" type="button" class="boton"  
                        onclick="window.location.href='<? echo"pro1_categoriza.php?id_cama=$id_cama&cod_servicio=$cod_servicio&desc_servicio=$desc_servicio&sala=$sala&cama=$cama&nom_paciente=$nom_paciente&id_paciente=$id_paciente&diagnostico2=$diagnostico2&tipo_1=$tipo_1&d_tipo_1=$d_tipo_1&tipo_2=$tipo_2&d_tipo_2=$d_tipo_2"; ?>'" value="Categorización"
						<?php if ( (array_search(24, $permisos) == null) || ($pac_fecha_ingreso >= date('Y-m-d')) ) {  echo 'disabled="disabled"';
						} ?>
                        />
<? if (($que_cod_servicio == 45) || ($que_cod_servicio == 11)){ ?>

                     <input name="" type="button" class="boton"  
                        onclick="window.location.href='<? echo"../../partos/listadoPartos.php?id_cama=$id_cama"; ?>'" value="Libro Partos"
						<?php if ( array_search(226, $permisos) == null ) { ?>
                        	disabled="disabled"
						<? } ?>
                        />
						<? } ?>                        
                    </td>
                </tr>
                <tr>
                	<td align="center" style="padding-bottom:5px">
<?php /*?>						<input name="" type="button" class="boton" 
							onclick="window.location.href='<? echo"hist_clinico.php?id_cama=$id_cama&nom_paciente=$nom_paciente&id_paciente=$id_paciente&rut_paciente=$rut_paciente&cta_cte=$cta_cte"; ?>'" value="Historial Cl&iacute;nico"
						<?php if ( array_search(24, $permisos) == null ) { ?>
                        	disabled="disabled"
						<? } ?>
                        />
<?php */?>               
         
                        <input name="" type="button" class="boton" 
							onclick="window.location.href='<? echo"../../historialclinico/Interfaz/resumenHistorial.php?id_cama=$id_cama&pacId=$id_paciente&rut=$rut_paciente&act=externo"; ?>'" value="Historial Cl&iacute;nico"
						<?php if ( array_search(24, $permisos) == null ) { ?>
                        	disabled="disabled"
						<? } ?>
                        />
                        	<input name="" type="button" class="boton" 
                        	onclick="window.location.href='<? echo"historicocama.php?id_cama=$id_cama&id_hosp=0&cod_servicio=$cod_servicio&desc_servicio=$desc_servicio&sala=$sala&cama=$cama"; ?>'" value="Historico Cama"
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
                        
                   	  	<?php /*?><input name="" type="button" class="boton" 
                        	onclick="window.location.href='<? echo"historicocama.php?id_cama=$id_cama&id_hosp=0&cod_servicio=$cod_servicio&desc_servicio=$desc_servicio&sala=$sala&cama=$cama"; ?>'" value="Historico Cama"
							<?php if ( array_search(24, $permisos) == null ) { ?>
                        	disabled="disabled"
							<? } ?>
                        />
                      	<input name="" type="button" class="boton"
							onclick="window.location.href='<? echo"historicopaciente.php?id_cama=$id_cama&nom_paciente=$nom_paciente&id_paciente=$id_paciente"; ?>'" value="Historico Paciente"
						<?php if ( array_search(24, $permisos) == null ) { ?>
                        	disabled="disabled"
						<? } ?>                        
                        /><?php */?>
                        <br />
                         <?php /*?><input name="" type="button" class="boton" 
							onclick="window.location.href='<? echo"../../registro_clinico_enf/vista/index.php?tipo_examen=examen_rutina&act=camas&id_cama=$id_cama&cama=".$paciente['cama']."&sala_hosp=$sala&pacId=$id_paciente&flag=si"; ?>'" value="Hoja de Enfermeria"
						<?php if ( array_search(426, $permisos) == null ) { ?>
                        	disabled="disabled"
						<? } ?>
                        /><?php */?>
                      <input name="" type="button" class="boton" 
							onclick="window.location.href='<? echo"../../registro_clinico_ajax/vista/Inicio.php?origen=cama&id_cama=$id_cama&cama=".$paciente['cama']."&sala_hosp=$sala&pacId=$id_paciente&ctacte=$cta_cte"; ?>'" value="Registro Cl&iacute;nico"
						<?php if ( array_search(426, $permisos) == null ) { ?>
                        	disabled="disabled"
						<? } ?>
                        />
                    	<? if ( array_search(506, $permisos) != null ) { ?>
                        <input type="button" name="soltras" value="Solicitud de Traslado" onclick="window.location.href='<? echo "../../solicitud_traslado/vista/solicitud_traslado.php?pacId=$id_paciente&origen=cama&desc_servicio=$desc_servicio&medico=$paciente[medico]&id_cama=$id_cama"; ?>'" />
                        <? } 
						
						if (($que_cod_servicio >= 1) && ($que_cod_servicio <= 9 )){ 
						 
						?>
                        <input name="epicrisis" value="Epicrisis Médica" type="button" class="boton" onclick="window.location.href='<? echo $linkEpi; ?>'"
						<?

						if ( array_search(243, $permisos) == null ) { ?>
                        	disabled="disabled"
                        <? } ?>
                        />
                        
                        <? } 
						/*- DANNY HASTA AQUI ES EL NUEVO CODIGO-*/
						if (($que_cod_servicio != 10 ) and ($que_cod_servicio != 45 ) and ($que_cod_servicio != 14 )){ 
							
								$enlace = "epicrisisEnfermera.php";
								if($que_cod_servicio == 12 ){
									$enlace = "epicrisisPsiquiatria.php";
									}
						?>
                   	  	<input type="button" class="boton" onclick="window.location.href='<? echo $enlace."?id_cama=$id_cama&ctaCte=$cta_cte&id_paciente=$id_paciente&idServicio=$servicio&prev_paciente=".$paciente['prevision']."&cod_prev=".$paciente['cod_prevision']."&ing_paciente=".$paciente['fecha_ingreso']."&multiRes=".$multiRes."&hospitaliza=".$paciente['hospitalizado']; ?>'" value="Epicrisis de Enfermeria"
   						<?php if ( array_search(245, $permisos) == null ) { ?>
                        	disabled="disabled"
						<? } ?>                        
                         />
                         <? } 
						 if(($cod_servicio == 45) or ($cod_servicio == 10) or ($cod_servicio == 14) or ($cod_servicio == 11)){
						 ?>
                         <input type="button" class="boton" onclick="window.location.href='<? echo "epicrisisMatronas.php?id_cama=$id_cama&ctaCte=$cta_cte&id_paciente=$id_paciente&idServicio=$servicio&prev_paciente=".$paciente['prevision']."&cod_prev=".$paciente['cod_prevision']."&ing_paciente=".$paciente['fecha_ingreso']."&multiRes=".$multiRes."&hospitaliza=".$paciente['hospitalizado']."&idParto=".$paciente['id_parto']; ?>'" value="Epicrisis de Matroneria"
   						<?php if ( array_search(362, $permisos) == null ) { ?>
                        	disabled="disabled"
						<? } ?>                        
                         />
                         <? } ?>
                        <?php /*?><? if (($que_cod_servicio != 10 ) and ($que_cod_servicio != 45 ) and ($que_cod_servicio != 14 )){ ?>
                   	  	<input type="button" class="boton" onclick="window.location.href='<? echo "epicrisisEnfermera.php?id_cama=$id_cama&ctaCte=$cta_cte&id_paciente=$id_paciente&idServicio=$servicio&prev_paciente=".$paciente['prevision']."&cod_prev=".$paciente['cod_prevision']."&ing_paciente=".$paciente['fecha_ingreso']."&multiRes=".$multiRes."&hospitaliza=".$paciente['hospitalizado']; ?>'" value="Epicrisis de Enfermeria"
   						<?php if ( array_search(245, $permisos) == null ) { ?>
                        	disabled="disabled"
						<? } ?>                        

                         />
                         <? } ?><?php */?>
                      	<input type="button" class="boton"
                        	onClick="window.location.href='<? echo"sscc.php"; ?>'" value="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Salir &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
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
		?>
		<fieldset class="fieldset_det2"><legend>Error</legend>
            <table style="font-size:18px; color: #F00;" align="center" border="0" cellspacing="0" cellpadding="0">
	            <tr height="25px">
    	        </tr>
        	    <tr>
            	    <td align="center">Cama ha cambiado se estado,</td>
	            </tr>
    	        <tr>
        	        <td align="center">ya NO se encuentra con Paciente,</td>
            	</tr>
	            <tr>
    	            <td align="center">recargue pagina de informacion de Servicio.</td>
        	    </tr>
            	<tr height="25px">
	            </tr>
    	    </table>
		</fieldset>
		<fieldset class="fieldset_det2"><legend>Opciones</legend>
            <table align="center" border="0" cellspacing="0" cellpadding="0">
	            <tr height="25px">
    	        </tr>
        	    <tr>
            	    <td>
          				<input type="button" value="               Volver               " onClick="window.location.href='<? echo"sscc.php"; ?>'; parent.parent.GB_hide(); " >
					</td>
	            </tr>
            	<tr height="25px">
	            </tr>
    	    </table>

		</fieldset>
        <?
	}

}
else
{

echo "Problemas de Registro Cominuquese con el Administrador de Sistemas";
?>	<input type="button" value="               Volver               " onClick="window.location.href='<? echo"sscc.php"; ?>';
parent.parent.GB_hide(); " > <?

}

?>


</fieldset>
</td>
</tr>
</table>
</form>


</body>
</html>


<?php
//usar la funcion header habiendo mandado código al navegador
ob_end_flush();
//end header
?>


