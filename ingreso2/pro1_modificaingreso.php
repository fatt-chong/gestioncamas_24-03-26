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


<script type="text/javascript">
    onload = focusIt;
    function focusIt()
    {
      document.ingresa_doc.diagnostico1.focus();
    }
</script>




</head>


	<?

	include "../funciones/funciones.php";
	  
	$sql = "SELECT * FROM camas where id = '".$id_cama."'";
	mysql_connect ($dbhost,'gestioncamas','123gestioncamas');
	mysql_select_db('camas') or die('Cannot select database');
	$query = mysql_query($sql) or die(mysql_error());

    $paciente = mysql_fetch_array($query);
	
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
	$diagnostico1 = $paciente['diagnostico1'];
	$diagnostico2 = $paciente['diagnostico2'];
	
	$rut_paciente = $paciente['rut_paciente'];
	$ficha_paciente = $paciente['ficha_paciente'];
	$nom_paciente = $paciente['nom_paciente'];
	$cod_prevision = $paciente['cod_prevision'];
	$prevision = $paciente['prevision'];
	$direc_paciente = $paciente['direc_paciente'];
	$fono1_paciente = $paciente['fono1_paciente'];
	$fono2_paciente = $paciente['fono2_paciente'];
	$fono3_paciente = $paciente['fono3_paciente'];
	$fecha_ingreso = cambiarFormatoFecha2($paciente['fecha_ingreso']);
	$categorizacion_riesgo = $paciente['categorizacion_riesgo'];
	$categorizacion_dependencia = $paciente['categorizacion_dependencia'];
	$categorizacion = $categorizacion_riesgo.''.$categorizacion_dependencia;



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

	$sql = "SELECT * FROM medicos order by medico";
	mysql_connect ($dbhost,'gestioncamas','123gestioncamas');
	mysql_select_db('camas') or die('Cannot select database');
	$query = mysql_query($sql) or die(mysql_error());

	$i = 0;
	while($l_medicos = mysql_fetch_array($query)){
		$id_medicos[$i] = $l_medicos['id'];
		$medicos[$i] = $l_medicos['medico'];
		$i++;
	}

	$sql = "SELECT * FROM sscc WHERE id < 100";
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
    	<th height="20px" align="left" bgcolor="#006699" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; color:#FFF">&nbsp; Modificar Datos de Hospitalizaci&oacute;n.</th>

        <tr>
            <td background="img/fondo.jpg">
            	<fieldset>


<div align="center">


<form method="get" action="pro2_modificaingreso.php">


    <input type="hidden" name="tipo_1" value="<? echo $tipo_1 ?>" />
    <input type="hidden" name="d_tipo_1" value="<? echo $d_tipo_1 ?>" />
    <input type="hidden" name="tipo_2" value="<? echo $tipo_2 ?>" />
    <input type="hidden" name="d_tipo_2" value="<? echo $d_tipo_2 ?>" />


    <input type="hidden" name="id_cama" value="<? echo $id_cama ?>" />


        <fieldset class="fieldset_det2">
            <table width="780px" border="0" cellspacing="1" cellpadding="1">
                <tr height="10px">
                </tr>
                <tr>
                    <td width="10px">&nbsp;</td>
					<td>Servicio Clinico : <input size="25" type="text" name="pservicio" value="<?php echo $desc_servicio; ?>" readonly="readonly"/> Sala : <input size="15" type="text" name="pcama" value="<?php echo $sala ?>" readonly="readonly" /> Cama N° : <input size="3" type="text" name="pcama" value="<?php echo $cama ?>" readonly="readonly" /> Categorización : <input size="2" type="text" name="categorizacion" value="<?php echo $categorizacion ?>" readonly="readonly" /></td>
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
                <td width="10px">&nbsp;</td>
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
	            <td>Fono3</td>
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
			<tr>
                <td width="10px"></td>                
                <td>Medico Tratante</td>
	            <td><select name="cod_medico">
              	<?php
                for($i=0; $i<count($medicos); $i++)
                {
                    if($id_medicos[$i]==$cod_medico)
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
            	Procedencia
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
                <td>Pre-Diagn
                ostico</td>
                <td><input size="103" type="text" name="diagnostico1" value="<?php echo $diagnostico1; ?>" /></td>
            </tr>
            <tr>
                <td></td>
                <td>Diagnostico</td>
                <td><input size="103" type="text" name="diagnostico2" value="<?php echo $diagnostico2; ?>" /></td>
            
            </tr>
            <tr>
                <td></td>
                 <td>Patologia Auge </td>
                 <td>
    	    	    <select name="cod_auge">
					<option value=0 selected="selected">NO AUGE</option>
  	        	 	<?
    	    	    for($i=0; $i<count($pauge); $i++)
					{
						if($id_pauge[$i]==$cod_auge)
						{
	        	    	    echo "<option value='".$id_pauge[$i]."' selected>".substr($pauge[$i], 0, 70)."</option>";
						}
						else
						{
	        	    	    echo "<option value='".$id_pauge[$i]."'>".substr($pauge[$i], 0, 70)."</option>";
						}
					}
					$selccionado = 1;
    	    	    for($i=0; $i<count($pauge); $i++)
        	    	    { echo "<option value='".$id_pauge[$i]."'>".substr($pauge[$i], 0, 70)."</option>"; }
					?>
					</select>

                    <?
                    if($paciente['acctransito'] == 1){
                        echo "<input type='checkbox' checked name='d_acctransito' />Accidente de Transito.</td>";
                    }
                    else {
                        echo "<input type='checkbox' name='d_acctransito' />Accidente de Transito.</td>";				
                    }
                    ?>

            </tr>
            <tr>
            
            
            
                            <td></td>
                <td>Fecha Ingreso</td>
                <td><input size="9"  id="f_date1" type="text" name="fecha_ingreso"  value="<? echo $fecha_ingreso ?>" /><input type="Button" id="f_btn1" value=".." />
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Cta.Cte<input size="8" type="text" name="cta_cte" value="<? echo $cta_cte; ?>" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

			<?

			if ($tipo_1 == 5 or $tipo_1 == 6) { $tipo_1 = $tipo_1."".$tipo_2; }

			switch ($cod_servicio) {
				case 1:
				    ?> <input type="hidden" name="tipo_1" value=2 /> <?
					break;
				case 2:
				    ?> <input type="hidden" name="tipo_1" value=3 /> <?
                    break;
				case 3:
				    ?> <input type="hidden" name="tipo_1" value=1 /> <?
                    break;
				case 4:
				    ?> <input type="hidden" name="tipo_1" value=1 /> <?
                    break;
				case 5:
				    ?> <input type="hidden" name="tipo_1" value=7 /> <?
                    break;
				case 6:
					?>
						Tipo De Cama
                        	<?php
							echo "<select name='tipo_1'>";
							if($tipo_1==15)
							{ echo "<option value=15 selected> CUNA BASICA </option>"; }
							else
							{ echo "<option value=15 > CUNA BASICA </option>"; }
							if($tipo_1==14)
							{ echo "<option value=14 selected> INTERMEDIO (INCUBADORA) </option>"; }
							else
							{ echo "<option value=14 > INTERMEDIO (INCUBADORA) </option>"; }
							if($tipo_1==13)
							{ echo "<option value=13 selected> UTI </option>"; }
							else
							{ echo "<option value=13 > UTI </option>"; }
							?>
							</select>
					<?
                    break;
                case 7:
					?>
						Tipo Cama
							<?php
							echo "<select name='tipo_1'>";
							if($tipo_1==61)
							{ echo "<option value=61 selected> LACTANTE MINIMO </option>"; }
							else
							{ echo "<option value=61 > LACTANTE MINIMO </option>"; }
							if($tipo_1==62)
							{ echo "<option value=62 selected> LACTANTE INTERMEDIO </option>"; }
							else
							{ echo "<option value=62 > LACTANTE INTERMEDIO </option>"; }
							if($tipo_1==51)
							{ echo "<option value=51 selected> INDIFERENCIADO MINIMO </option>"; }
							else
							{ echo "<option value=51 > INDIFERENCIADO MINIMO </option>"; }
							if($tipo_1==52)
							{ echo "<option value=52 selected> INDIFERENCIADO INTERMEDIO </option>"; }
							else
							{ echo "<option value=52 > INDIFERENCIADO INTERMEDIO </option>"; }
							if($tipo_1==4)
							{ echo "<option value=4 selected> UTI </option>"; }
							else
							{ echo "<option value=4 > UTI </option>"; }
							?>
							</select>
					<?
                    break;
				case 8:
				    ?> <input type="hidden" name="tipo_1" value=11 /> <?
                    break;
				case 9:
				    ?> <input type="hidden" name="tipo_1" value=12 /> <?
                    break;
                case 10:
					?>
						Tipo Cama
							<?php
							echo "<select name='tipo_1'>";
							if ($tipo_1 == 8)
							{
								echo "<option value='8' selected> GINECOLOGICO </option>";
								echo "<option value='9' > OBSTETRICO </option>";
							}
							else
							{
								echo "<option value='8' > GINECOLOGICO </option>";
								echo "<option value='9' selected> OBSTETRICO </option>";
							}
							?>
							</select>
					<?
                    break;
				case 11:
					?>
						Tipo Cama
							<?php
							echo "<select name='tipo_1'>";
							if ($tipo_1 == 8)
							{
								echo "<option value='8' selected> GINECOLOGICO </option>";
								echo "<option value='9' > OBSTETRICO </option>";
							}
							else
							{
								echo "<option value='8' > GINECOLOGICO </option>";
								echo "<option value='9' selected> OBSTETRICO </option>";
							}
							?>
							</select>
					<?
                    break;
				case 12:
				    ?> <input type="hidden" name="tipo_1" value=10 /> <?
                    break;
				case 45:
				    ?> <input type="hidden" name="tipo_1" value=45 /> <?
                    break;
				case 46:
				    ?> <input type="hidden" name="tipo_1" value=46 /> <?
                    break;
				case 50:
				    ?> <input type="hidden" name="tipo_1" value=50 /> <?
                    break;

            }
			
			?>
			  </td>            

            
            
          <tr height="10px"> </tr>                
        </table>
 
    </fieldset>

	<fieldset><legend>Opciones</legend>
		<input type="submit" value="          Acceptar          " >
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
