<?php
//date_default_timezone_set('America/Santiago');
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

		function isNumberKey(evt)// acepta solo numeros
		  {
			 var charCode = (evt.which) ? evt.which : event.keyCode
			 if (charCode > 31 && (charCode < 48 || charCode > 57))
				return false;
	
			 return true;
		  }
	
    window.onload=function(){
	setInterval('barthel(ingresa_pac_n)',10);
	}
    </script>
</head>

<?
include "../funciones/funciones.php";


$id_cama = $_SESSION['MM_pro_id_cama'];
$cama = $_SESSION['MM_pro_cama'];
$sala = $_SESSION['MM_pro_sala'];
$servicio = $_SESSION['MM_pro_servicio'];
$desc_servicio = $_SESSION['MM_pro_desc_servicio'];
$tipo_1 = $_SESSION['MM_pro_tipo_1'];
$d_tipo_1 = $_SESSION['MM_pro_d_tipo_1'];
$estado = $_SESSION['MM_pro_estado'];
$permisos = $_SESSION['permiso'];

$estaelpaciente = 0;

mysql_connect ('10.6.21.29','usuario','hospital');
mysql_select_db('camas') or die('Cannot select database');

$sqlVerifica = mysql_query("SELECT * FROM camas where id = $id_cama") or die("ERROR AL SELECCIONAR CAMA ".mysql_error());
$arrayVerifica = mysql_fetch_array($sqlVerifica);
$estadoCama = $arrayVerifica['estado']; 

if ($doc_paciente == "" and $tipodocumento <> 5)
{
	$GoTo = "ingresopaciente.php?id_cama=$id_cama&tipodocumento=$tipodocumento";
	header(sprintf("Location: %s", $GoTo));
}


$fecha_hoy = date('d-m-Y');
$fecha = $fecha_hoy;

$hora_ingreso = date('H:i');


$sql = "SELECT * FROM pauge";
$query = mysql_query($sql) or die(mysql_error());

$i = 0;
while($l_pauge = mysql_fetch_array($query)){
	$id_pauge[$i] = $l_pauge['id'];
	$pauge[$i] = $l_pauge['pauge'];
	$i++;
}

$sql = "SELECT * FROM medicos order by medico";
mysql_select_db('camas') or die('Cannot select database');
$query = mysql_query($sql) or die(mysql_error());


$i = 0;
while($l_medicos = mysql_fetch_array($query)){
	$id_medicos[$i] = $l_medicos['id'];
	$medicos[$i] = $l_medicos['medico'];

	if ($l_medicos['id'] == 0)
	{
		$medicos[$i] = "-- SELECCIONAR MEDICO --";
	}
	
	$i++;
}

$sql = "SELECT * FROM sscc WHERE id < 100";
mysql_select_db('camas') or die('Cannot select database');
$query = mysql_query($sql) or die(mysql_error());

$i = 0;
while($l_servicios = mysql_fetch_array($query)){
	$id_servicios[$i] = $l_servicios['id'];
	$servicios[$i] = $l_servicios['servicio'];
	$i++;
}




$sql = "";
$sql_pac = "";
	
if ($tipodocumento == 1) { $sql = "SELECT * FROM transito_paciente where cta_cte = '".$doc_paciente."'"; 
						   $sql_pac = "SELECT * FROM camas where cta_cte = '".$doc_paciente."'"; }
if ($tipodocumento == 2) { $sql = "SELECT * FROM transito_paciente where rut_paciente = '".$doc_paciente."'"; 
						   $sql_pac = "SELECT * FROM camas where rut_paciente = '".$doc_paciente."'"; }
if ($tipodocumento == 3) { $sql = "SELECT * FROM transito_paciente where ficha_paciente = '".$doc_paciente."'"; 						   
						   $sql_pac = "SELECT * FROM camas where ficha_paciente = '".$doc_paciente."'"; }
if ($tipodocumento == 5) { $sql = "SELECT * FROM transito_paciente where id = $id_traslado"; }

if ($sql == "")
{
	$GoTo = "ingresopaciente.php?id_cama=$id_cama&tipodocumento=$tipodocumento";
	header(sprintf("Location: %s", $GoTo));
}


mysql_select_db('camas') or die('Cannot select database');
$query = mysql_query($sql) or die(mysql_error());

$traslados = mysql_fetch_array($query);
if ($traslados)
{

	$id_traslado = $traslados['id'];
	$cta_cte = $traslados['cta_cte'];
	
	$que_cod_servicio = $traslados['que_cod_servicio'];
	$cod_sscc_desde = $traslados['cod_sscc_desde'];
	
	mysql_select_db('camas') or die('Cannot select database');

	$query = mysql_query("SELECT * FROM sscc where id_rau = $cod_sscc_desde") or die(mysql_error());
	$query_servicio = mysql_fetch_array($query);
	$cod_procedencia = $query_servicio['id'];

	
	$que_servicio    = $traslados['que_servicio'];
	$desc_sscc_desde = $traslados['desc_sscc_desde'];

	$id_paciente = $traslados['id_paciente'];
	$rut_paciente = $traslados['rut_paciente'];
	$nom_paciente = $traslados['nom_paciente'];
	
	$tipo_traslado = $traslados['tipo_traslado'];
	$hospitalizado = $traslados['hospitalizado'];
	$fecha = cambiarFormatoFecha2($traslados['fecha']);
	$hora_ingreso = substr($traslados['hora'], 0, 5);

	$cod_medico = $traslados['cod_medico'];
	$medico = $traslados['medico'];
	$cod_auge = $traslados['cod_auge'];
	$acctransito = $traslados['acctransito'];
	$multires = $traslados['multires'];
	$diagnostico1 = $traslados['diagnostico1'];
	$diagnostico2 = $traslados['diagnostico2'];
	$id_parto = $traslados['id_parto'];
	$barthel = $traslados['barthel'];


}
else
{
	
	if ($sql_pac == "")
	{
		$GoTo = "ingresopaciente.php?id_cama=$id_cama&tipodocumento=$tipodocumento";
		header(sprintf("Location: %s", $GoTo));
	}
	
	mysql_select_db('camas') or die('Cannot select database');
	$query = mysql_query($sql_pac) or die(mysql_error());

	$estaencama = mysql_fetch_array($query);
	
	if ($estaencama)
	{

		$id_traslado = "0";
		$cta_cte = $estaencama['cta_cte'];
	
		$que_cod_servicio = $estaencama['que_cod_servicio'];
		$cod_sscc_desde = $estaencama['cod_servicio'];
		
		$cod_procedencia = $cod_sscc_desde;

		$que_servicio    = $estaencama['que_servicio'];
		$desc_sscc_desde = $estaencama['servicio'];
	
		$id_paciente = $estaencama['id_paciente'];
		$rut_paciente = $estaencama['rut_paciente'];
		$nom_paciente = $estaencama['nom_paciente'];
		
		$tipo_traslado = 2;
		$hospitalizado = $estaencama['hospitalizado'];
	
		$cod_medico = $estaencama['cod_medico'];
		$medico = $estaencama['medico'];
		$cod_auge = $estaencama['cod_auge'];
		$acctransito = $estaencama['acctransito'];
		$multires = $estaencama['multires'];
		$diagnostico1 = $estaencama['diagnostico1']; 
		$diagnostico2 = $estaencama['diagnostico2'];
		
		$estaenlasala =  $estaencama['sala'];
		$estaenlacama =  $estaencama['cama'];
		$barthel = $estaencama['barthel'];
		
		
		
		if ($servicio == $cod_sscc_desde)
		{
			$estaelpaciente = 2;
		}

	}
	else
	{
		$estaelpaciente = 1;
//		$GoTo = "ingresopaciente.php?id_cama=$id_cama&tipodocumento=$tipodocumento";
//		header(sprintf("Location: %s", $GoTo));
	}


}


if ($que_cod_servicio == '')
{
	$que_cod_servicio = $servicio;
	$que_servicio    = $desc_servcio;
}
	

$sql = "SELECT * FROM paciente where id = '".$id_paciente."'";

mysql_select_db('paciente') or die('Cannot select database');
$query = mysql_query($sql) or die(mysql_error());

$paciente = mysql_fetch_array($query);
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

}
else
{
	$estaelpaciente = 1;
//	$GoTo = "ingresopaciente.php?id_cama=$id_cama&tipodocumento=$tipodocumento";
//	header(sprintf("Location: %s", $GoTo));
}


if ($hora_ingreso == "") { $hora_ingreso = date('H:i'); }


?>

<body background="../../estandar/img/fdo.jpg" topmargin="5" style="font-family:Arial, Helvetica, sans-serif; font-size:12px">
	<table width="850px" align="center" border="2" bordercolor="#000000" bordercolorlight="#FFFFFF" bordercolordark="#666666" cellspacing="0" cellpadding="0">
    	<th height="20px" align="left" bgcolor="#006699" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; color:#FFF">&nbsp; Hospitalizaci&oacute;n de Paciente.</th>

        <tr>
            <td background="img/fondo.jpg">
            	<fieldset>

<? if($estadoCama != 5) { ?>
    <div align="center">
    
    
    <?
    
    if ($estaelpaciente <> 0)
    {
    ?>
            <fieldset class="fieldset_det2"><legend>Error</legend>
                <table style="font-size:18px; color: #F00;" align="center" border="0" cellspacing="0" cellpadding="0">
                    <tr height="25px">
                    </tr>
                    <tr>
                    <? if ($estaelpaciente == 1)
                    {
                    ?>
                            <td align="center">El paciente no se encuentra en registro de pacientes Hospitalizados,</td>
                        </tr>
                        <tr>
                            <td align="center">intente ingresarlo por Nro Ficha, Cta-Cte, Rut.</td>
                        </tr>
                        <tr>
                            <td align="center">o presione el boton buscar por nombre del paciente</td>
                        </tr>
                        <tr height="25px">
                    <?
                    }
                    else
                    {
                    ?>
                    
                            <td align="center">El paciente ya se encuentra Hospitalizado,</td>
                        </tr>
                        <tr>
                            <td align="center">Sala = <? echo $estaenlasala ?> </td>
                        </tr>
                        <tr>
                            <td align="center">Cama = <? echo $estaenlacama ?> </td>
                        </tr>
                        <tr height="25px">
                    
                    
                    <?
                    }
                    ?>
                    </tr>
                </table>
            </fieldset>
            <fieldset class="fieldset_det2"><legend>Opciones</legend>
                <table align="center" border="0" cellspacing="0" cellpadding="0">
                    <tr height="25px">
                    </tr>
                    <tr>
                        <td>
                            <input type="button" value="               Volver               " onClick="window.location.href='<? echo"ingresopaciente.php?id_cama=$id_cama&tipodocumento=$tipodocumento"; ?>'; parent.parent.GB_hide(); " >
                        </td>
                    </tr>
                    <tr height="25px">
                    </tr>
                </table>
    
            </fieldset>
    
    <?
    }
    else
    {
    ?>
    
    <form name="ingresa_pac_n" id="ingresa_pac_n" method="get" action="pro2_ingresopaciente.php">
    
        <input type="hidden" name="tipodocumento" value="<? echo $tipodocumento ?>" />
        <input type="hidden" name="id_traslado" value="<? echo $id_traslado ?>" />
    
    
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
        <input type="hidden" name="tipo_traslado" value="<? echo $tipo_traslado ?>" />
    	
        <input type="hidden" name="id_solicitud" value="<? echo $id_solicitud ?>" />
        <input type="hidden" name="prevision" value="<? echo $prevision ?>" />
        <input type="hidden" name="comuna" value="<? echo $comuna ?>" />
        <input type="hidden" name="id_parto" value="<? echo $id_parto; ?>" />
        
    
        <fieldset class="fieldset_det2"><legend>Paciente</legend>
            <table width="830px" border="0" cellspacing="1" cellpadding="1">
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
                        <input size="66" type="text" name="nom_paciente" value="<?php echo $nom_paciente; ?>" disabled="disabled" />
                        Edad <input size="2" type="text" name="edad_paciente" value="<?php echo $edad_paciente; ?>" disabled="disabled" />
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
                    <td>
                        <?
                        if($acctransito == 1){
                            echo "<input type='checkbox' checked name='d_acctransito' />Accidente de Transito.";
                        }
                        else {
                            echo "<input type='checkbox' name='d_acctransito' />Accidente de Transito.";				
                        }
                        
                        if($multires == 1){
                            echo "<input type='checkbox' checked name='d_multires' />Multiresistente.</td>";
                        }
                        else {
                            echo "<input type='checkbox' name='d_multires' />Multiresistente.</td>";				
                        }
                        ?>
    
                     
                     <td>Patologia Auge
                        <select name="cod_auge">
                        <option value=0 >NO AUGE</option>
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
                    </td>
                </tr>
            </table>
        
            <table width="830px" border="0" cellspacing="1" cellpadding="1">
                <tr height="10px"></tr>
                <tr>
                    <td width="5px">&nbsp;</td>
                    <td width="110px">Servicio Clinico</td>
                  <td><input size="20" type="text" name="desc_servicio" value="<?php echo $desc_servicio; ?>" disabled="disabled" />
                  &nbsp;&nbsp;&nbsp;&nbsp; Sala <input size="10" type="text" name="sala" value="<?php echo $sala; ?>" disabled="disabled" />
                  &nbsp;&nbsp;&nbsp;&nbsp; Cama N� <input size="3" type="text" name="cama" value="<?php echo $cama; ?>" disabled="disabled" />
                  
                  
                    &nbsp;&nbsp;&nbsp;&nbsp; Correspondie a... 
                    <select name="que_cod_servicio">
                    <?php
                    for($i=0; $i<count($servicios); $i++)
                    {
						if ($id_servicios[$i] < 45)
						{
							if($id_servicios[$i]==$que_cod_servicio)
							{
								echo "<option value='".$id_servicios[$i]."' selected>".$servicios[$i]."</option>";
							}
							else
							{
								echo "<option value='".$id_servicios[$i]."'>".$servicios[$i]."</option>";
							}
						}
                    }
                    ?>
                    </select>
                        
                  
                  
                  
                  
                </tr>
                <? if(($servicio <> 6) && ($servicio <> 7)){ ?>
                <tr>
                	<td>&nbsp;</td>
                    <td>I. Barthel: </td>
                    <td><input type="text" name="barthel" id="barthel" size="2px" value="<?= $barthel; ?>" />&nbsp;<input type="text" name="valorBart" id="valorBart" readonly="readonly" /></td>
                </tr>
                <? } ?>
              <tr>
        <td></td>                
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
                    &nbsp;&nbsp;&nbsp;&nbsp; Procedencia 
                    <select name="cod_procedencia">
                    <?php
                    for($i=0; $i<count($servicios); $i++)
                    {
						if ( $id_servicios[$i] <= 45 or $id_servicios[$i] == 50 or ( $id_servicios[$i] >= 90 and $id_servicios[$i] < 100))
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
					}
                    ?>
                    </select>
                    &nbsp;&nbsp;&nbsp;&nbsp; Cta.Cte <input size="8" type="text" name="cta_cte" value="<? echo $cta_cte; ?>" readonly="readonly" /> 
                    </td>
                    
    
                </tr>
                <tr>
                    <td></td>
                    <td>Pre-Diagnostico</td>
                    <td><input size="101" type="text" name="diagnostico1" value="<? echo $diagnostico1; ?>" /></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Diagnostico</td>
                    <td><input size="101" type="text" name="diagnostico2" value="<? echo $diagnostico2; ?>" /></td>
                </tr>
                
                <tr>
                    <td></td>
                    <td>Fecha Ingreso</td>
                    <td>
    
                        <span id="spry_fecha_ingreso">
                        <input size="9"  id="f_date1" name="fecha_ingreso"  value="<? echo $fecha ?>"
                        <?php if ( array_search(248, $permisos) != null ) { echo "enabled='enabled'"; } else { echo "readonly='readonly'"; }  ?> />
                        <input type="Button" id="f_btn1" value="....."
                        <?php if ( array_search(248, $permisos) != null ) { echo "enabled='enabled'"; } else { echo "disabled='disabled'"; }  ?> />
                        <span class="textfieldRequiredMsg">Ingrese Fecha!</span>
                        <span class="textfieldInvalidFormatMsg">Fecha Inv�lida</span>
                        </span>
                        
        &nbsp;&nbsp;              
        
                        <span id="spry_hora_ingreso">
                        Hora <input size="4"  id="hora_ingreso" type="text" name="hora_ingreso"  value="<? echo $hora_ingreso ?>" />
                        <span class="textfieldRequiredMsg">Ingrese Hora!</span>
                        <span class="textfieldInvalidFormatMsg">Hora Inv�lida</span>
                        </span>
        
                      
                        
                        
                        
                        
    &nbsp;&nbsp;
    
                        <?
                        
                        if ($servicio == 6)
                            {
                            ?>
                            Tipo Cama 
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
                            }
                        if ($servicio == 7)
                            {
                            ?>
                            Tipo Cama 
                                <?php
                                echo "<select name='tipo_1'>";
                                
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
                            }
                        if ($servicio == 10)
                            {
                            ?>
                            Tipo Cama 
                                <?php
                                echo "<select name='tipo_1'>";
                                echo "<option value='8' selected> GINECOLOGICO </option>";
                                echo "<option value='9' > OBSTETRICO </option>";
                                ?>
                                </select>
                            <?
                            }
                        if ($servicio == 11 or $servicio == 14)
                            {
                            ?>
                            Tipo Cama 
                                <?php
                                echo "<select name='tipo_1'>";
                                echo "<option value='8' > GINECOLOGICO </option>";
                                echo "<option value='9' selected> OBSTETRICO </option>";
                                ?>
                                </select>
                            <?
                            }
                            ?>
                        
                        
                        
                        
                        
                    </td>            
                <tr height="5px"> </tr>
            </table>
     
        </fieldset>
    
        <fieldset><legend>Opciones</legend>
            <input class="boton" type="submit" name="Submit" value="       Aceptar       " onchange="javascript:this.disabled= true;this.form.submit();" onclick="javascript:this.disabled= true;this.form.submit();" />
            
            <input class="boton" type="Button" value="      Cancelar      " onClick="window.location.href='<? echo"ingresopaciente.php?id_cama=$id_cama"; ?>'; parent.GB_hide(); " >
                
        </fieldset>
    
    
    </form>
    
    
    <?
    }
    ?>
    
    <script type="text/javascript">
    <!--
    var spry_fecha_ingreso = new Spry.Widget.ValidationTextField("spry_fecha_ingreso", "date", {validateOn:["change"], useCharacterMasking:true, format:"dd-mm-yyyy"});
    var spry_hora_ingreso = new Spry.Widget.ValidationTextField("spry_hora_ingreso", "time", {validateOn:["change"], useCharacterMasking:true});
    //-->

//<![CDATA[
        var cal = Calendar.setup({ onSelect: function(cal) { cal.hide() } });
        cal.manageFields("f_btn1", "f_date1", "%d-%m-%Y");
    //]]></script>
    
    
    </div>
<? }else{ ?>
	<fieldset class="fieldset_det2"><legend>Error</legend>
    	<table style="font-size:18px; color: #F00;" align="center" border="0" cellspacing="0" cellpadding="0">
	            <tr height="25px">
    	        </tr>
        	    <tr>
            	    <td align="center">La cama ha cambiado de estado,</td>
	            </tr>
    	        <tr>
        	        <td align="center"> y ya no se encuentra disponible,</td>
            	</tr>
	            <tr>
    	            <td align="center">recargue pagina de informacion de Servicio.</td>
        	    </tr>
            	<tr height="25px">
	            </tr>
    	    </table>
        
    </fieldset> 
    <fieldset class="fieldset_det2"><legend>Opciones</legend>
      <div align="center"><input type="button" value="               Volver               " onClick="window.location.href='<? echo"sscc.php"; ?>'; parent.GB_hide(); " ></div>
	</fieldset>
<? }?>
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

